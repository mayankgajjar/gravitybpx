<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leadstore extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('campaign_m');
        $this->load->model('filter_m');
        $this->load->model('vertical_m');
        $this->load->model('bid_m');
        $this->load->model('agents');
        $this->load->model('State_model');
        $this->load->model('leadorder_m');
        $this->load->model('leadstore_m');
        $this->load->model('leadorderitem_m');
    }

    public function index() {
        // For now display agent page
        $this->data['validation'] = TRUE;
        $this->data['counterup'] = TRUE;
        $this->data['datatable'] = TRUE;
        /* ----------- For check Stripe test mode or live mode ------ */
        $stripe_data = unserialize(get_option('stripe_setting'));

        if (isset($stripe_data) && $stripe_data['stripe_mode'] == 'test') {
            $config['stripe_key_test_public'] = $stripe_data['stripe_key_test_public'];
            $config['stripe_key_test_secret'] = $stripe_data['stripe_key_test_secret'];
            $config['stripe_test_mode'] = TRUE;
        } else {
            $config['stripe_key_live_public'] = $stripe_data['stripe_key_live_public'];
            $config['stripe_key_live_secret'] = $stripe_data['stripe_key_live_secret'];
            $config['stripe_test_mode'] = FALSE;
        }
        /* ----------- End For check Stripe test mode or live mode ------ */

         /*----------- Continue Shooping From Cart ------*/
        if($this->session->flashdata('conti_shop') != ''){
            $this->data['conti_cat'] = $this->session->flashdata('conti_cat');
            $this->data['conti_shop'] = 'YES';
        }else{
            $this->data['conti_shop'] = 'NO';
            $this->data['conti_cat'] = '';
        }
        /*----------- End Continue Shooping From Cart ------*/

        $config['stripe_verify_ssl'] = FALSE;
        $this->load->library('stripe', $config);
        $this->load->model('autofund_m');
        $this->load->model('transaction_m');
        $this->data['title'] = 'Agent | Lead Store';
        $this->data['pagetitle'] = '';
        $agent = $this->agents->get($this->session->userdata('agent')->id);
        $this->data['currentBalance'] = $agent->balance;
        $autofund = $this->autofund_m->get_by(array('agent_id' => $agent->id), TRUE);
        if ($autofund && $autofund->is_active == 'YES') {
            $this->data['autoFundStatus'] = 'Enabled';
        } else {
            $this->data['autoFundStatus'] = 'Disabled';
        }
        $campaigns = $this->campaign_m->get_by(array('active' => '1', 'user_id' => $agent->id));
        if ($campaigns) {
            $this->data['activeCampaigns'] = count($campaigns);
        } else {
            $this->data['activeCampaigns'] = 0;
        }
        $option = array(
            'fields' => 'SUM(amount) AS todayamt',
            'conditions' => array(
                'agent_id' => $agent->id,
                'date LIKE' => '%' . date('Y-m-d') . '%'
            )
        );
        $tran = $this->transaction_m->get_relation('', $option);
        $todayDeposits = 0;
        if ($tran) {
            $todayDeposits = $tran[0]['todayamt'];
        }
        $this->data['todayDeposits'] = $todayDeposits;
        /* ---------- For Live Transfer Lead ------ */
        $table = "lead_campaign lc";
        $sWhere = "lc.user_id = " . $this->session->userdata('agent')->id . " AND lc.is_archive = 0 AND lc.auct_type = 'live_transfer'";
        $relation = array(
            "fields" => 'lc.*,lcc.cat_name as lead_category,lbt.name as bid_type',
            "JOIN" => array(
                array(
                    "table" => 'lead_campaign_category lcc',
                    "condition" => 'lc.campcat = lcc.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'lead_bid_type lbt',
                    "condition" => 'lc.bid_id = lbt.lead_bid_id ',
                    "type" => 'LEFT'
                ),
            ),
        );
        $relation['conditions'] = $sWhere;
        $this->data['live_transfer'] = $this->campaign_m->get_relation($table, $relation);
        // pr($this->data['live_transfer']);die;
        /* ---------- End For Live Transfer Lead ------ */

        /* ---------- For Data Lead ------ */
        $table = "lead_campaign lc";
        $sWhere = "lc.user_id = " . $this->session->userdata('agent')->id . " AND lc.is_archive = 0 AND lc.auct_type = 'data'";
        $relation = array(
            "fields" => 'lc.*,lcc.cat_name as lead_category,lbt.name as bid_type',
            "JOIN" => array(
                array(
                    "table" => 'lead_campaign_category lcc',
                    "condition" => 'lc.campcat = lcc.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'lead_bid_type lbt',
                    "condition" => 'lc.bid_id = lbt.lead_bid_id ',
                    "type" => 'LEFT'
                ),
            ),
        );
        $relation['conditions'] = $sWhere;
        $this->data['data_leads'] = $this->campaign_m->get_relation($table, $relation);
        /* ---------- End For Data Lead ------ */

        /*---------- Get Raw Purchased Leads ------ */
        $raw_sql = "SELECT `loi`.`order_item_id`, `loi`.`created`, `loi`.`qty`, `loi`.`item_price`, `loi`.`item_price`, `loi`.`csv_file_name` ,`loi`.`total_price` FROM `lead_order_item` `loi` LEFT JOIN `lead_order` `lo` ON `loi`.`order_id` = `lo`.`order_id` WHERE `lo`.`agent_id` = {$this->session->userdata('agent')->id} AND order_item_id IN (SELECT DISTINCT order_item_id FROM lead_store_mst LEFT JOIN raw_lead_mst ON raw_lead_mst.id = lead_store_mst.raw_lead_id WHERE user={$this->session->userdata('agent')->id} AND raw_lead_mst.category = 'raw') ORDER BY `loi`.`created` DESC";
        $raw_data = $this->db->query($raw_sql);
        $this->data['raw_purchased_lead_data'] = $raw_data->result_array();
        /*---------- End Get Raw Purchased Leads ------ */

         /*---------- Get Aged Purchased Leads ------ */
        $aged_sql = "SELECT `loi`.`order_item_id`, `loi`.`created`, `loi`.`qty`, `loi`.`item_price`, `loi`.`item_price`, `loi`.`csv_file_name` ,`loi`.`total_price` FROM `lead_order_item` `loi` LEFT JOIN `lead_order` `lo` ON `loi`.`order_id` = `lo`.`order_id` WHERE `lo`.`agent_id` = {$this->session->userdata('agent')->id} AND order_item_id IN (SELECT DISTINCT order_item_id FROM lead_store_mst LEFT JOIN raw_lead_mst ON raw_lead_mst.id = lead_store_mst.raw_lead_id WHERE user={$this->session->userdata('agent')->id} AND raw_lead_mst.category = 'aged') ORDER BY `loi`.`created` DESC";
        $aged_data = $this->db->query($aged_sql);
        $this->data['aged_purchased_lead_data'] = $aged_data->result_array();
        /*---------- End Get Aged Purchased Leads ------ */

        /* total lead purchased aged lead by agent */
        $agentId = $this->session->userdata('agent')->id;
        $options = array(
            'fields' => 'count(*) As totalPurchasedAgedLead',
            'JOIN' => array(
                array(
                    "table" => 'raw_lead_mst',
                    "condition" => 'raw_lead_mst.id = lead_store_mst.raw_lead_id ',
                    "type" => 'INNER'
                )
            ),
            'conditions' => "user = {$agentId} AND lead_store_mst.order_item_id > 0 AND lead_store_mst.raw_lead_id > 0 AND raw_lead_mst.category = 'aged'"
        );
        $data = $this->leadstore_m->get_relation('',$options);
//        echo $this->db->last_query();
//        die;
        if($data){
            $this->data['totalPurchasedAgedLead'] = $data[0]['totalPurchasedAgedLead'];
        }else{
            $this->data['totalPurchasedAgedLead'] = 0;
        }
        $options = array(
            'fields' => 'count(*) As totalClosedAgedLead',
            'JOIN' => array(
                array(
                    "table" => 'raw_lead_mst',
                    "condition" => 'raw_lead_mst.id = lead_store_mst.raw_lead_id ',
                    "type" => 'INNER'
                )
            ),
            'conditions' => "user = {$agentId} AND lead_store_mst.status = 'Client' AND lead_store_mst.order_item_id > 0 AND lead_store_mst.raw_lead_id > 0 AND raw_lead_mst.category = 'aged'"
        );
        $data = $this->leadstore_m->get_relation('',$options);
        if($data){
            $this->data['totalClosedAgedLead'] = $data[0]['totalClosedAgedLead'];
        }else{
            $this->data['totalClosedAgedLead'] = 0;
        }
        $oldFigure = $this->data['totalPurchasedAgedLead'];
        $newFigure = $this->data['totalClosedAgedLead'];
        if($oldFigure > 0 && $newFigure > 0 ){
            $percentChange = ($newFigure * 100) / $oldFigure;
            $this->data['totalClosedRawLeadRation'] = round($percentChange);
        }else{
            $this->data['totalClosedAgedLeadRation'] = 0;
        }

        $sql = "SELECT SUM(total_price) AS totalAgedSpent FROM `lead_order_item` WHERE lead_order_item.order_item_id IN(SELECT distinct order_item_id FROM lead_store_mst LEFT JOIN raw_lead_mst ON raw_lead_mst.id = lead_store_mst.raw_lead_id WHERE `user` = {$agentId} AND raw_lead_mst.category='aged')";
        $query = $this->db->query($sql);
        $data = $query->row();
        if($data->totalAgedSpent){
            $this->data['totalAgedSpent'] = $data->totalAgedSpent;
        }else{
            $this->data['totalAgedSpent'] = 0;
        }
        /* average per lead cost for aged lead */
        if($this->data['totalPurchasedAgedLead'] > 0 && $this->data['totalAgedSpent'] > 0){
            $this->data['averagePeragedLeadCost'] = $this->data['totalPurchasedAgedLead'] / $this->data['totalAgedSpent'];
        }else{
            $this->data['averagePeragedLeadCost'] = 0;
        }
        /* start CPA calculation for aged lead */
         if($this->data['totalAgedSpent'] > 0 && $this->data['totalClosedAgedLead'] > 0){
             $this->data['agedLeadCPA'] = $this->data['totalAgedSpent'] / $this->data['totalClosedAgedLead'];
         }else{
             $this->data['agedLeadCPA'] = 0;
         }
        /* total lead purchased raw lead by agent */
        $agentId = $this->session->userdata('agent')->id;
        $options = array(
            'fields' => 'count(*) As totalPurchasedRawLead',
            'JOIN' => array(
                array(
                    "table" => 'raw_lead_mst',
                    "condition" => 'raw_lead_mst.id = lead_store_mst.raw_lead_id ',
                    "type" => 'INNER'
                )
            ),
            'conditions' => "user = {$agentId} AND lead_store_mst.order_item_id > 0 AND lead_store_mst.raw_lead_id > 0 AND raw_lead_mst.category = 'raw'"
        );
        $data = $this->leadstore_m->get_relation('',$options);

        if($data){
            $this->data['totalPurchasedRawLead'] = $data[0]['totalPurchasedRawLead'];
        }else{
            $this->data['totalPurchasedRawLead'] = 0;
        }
        $options = array(
            'fields' => 'count(*) As totalClosedRawLead',
            'JOIN' => array(
                array(
                    "table" => 'raw_lead_mst',
                    "condition" => 'raw_lead_mst.id = lead_store_mst.raw_lead_id ',
                    "type" => 'INNER'
                )
            ),
            'conditions' => "user = {$agentId} AND lead_store_mst.status = 'Client' AND lead_store_mst.order_item_id > 0 AND lead_store_mst.raw_lead_id > 0 AND raw_lead_mst.category = 'raw'"
        );
        $data = $this->leadstore_m->get_relation('',$options);
        if($data){
            $this->data['totalClosedRawLead'] = $data[0]['totalClosedRawLead'];
        }else{
            $this->data['totalClosedRawLead'] = 0;
        }

        $oldFigure = $this->data['totalPurchasedRawLead'];
        $newFigure = $this->data['totalClosedRawLead'];
        if($oldFigure > 0 && $newFigure > 0 ){
            $percentChange = ($newFigure * 100) / $oldFigure;
            $this->data['totalClosedRawLeadRation'] = round($percentChange, 2);
        }else{
            $this->data['totalClosedRawLeadRation'] = 0;
        }

        $sql = "SELECT SUM(total_price) AS totalRawSpent FROM `lead_order_item` WHERE lead_order_item.order_item_id IN(SELECT distinct order_item_id FROM lead_store_mst LEFT JOIN raw_lead_mst ON raw_lead_mst.id = lead_store_mst.raw_lead_id WHERE `user` = {$agentId} AND raw_lead_mst.category='raw')";
        $query = $this->db->query($sql);
        $data = $query->row();
        if($data->totalRawSpent){
            $this->data['totalRawSpent'] = $data->totalRawSpent;
        }else{
            $this->data['totalRawSpent'] = 0;
        }
        /* average per lead cost for raw lead */
        if($this->data['totalPurchasedRawLead'] > 0 && $this->data['totalRawSpent'] > 0){
            $this->data['averagePerRawLeadCost'] = $this->data['totalPurchasedRawLead'] / $this->data['totalRawSpent'];
        }else{
            $this->data['averagePerRawLeadCost'] = 0;
        }
        /* start CPA calculation for raw lead */
         if($this->data['totalRawSpent'] > 0 && $this->data['totalClosedRawLead'] > 0){
             $this->data['rawLeadCPA'] = $this->data['totalRawSpent'] / $this->data['totalClosedRawLead'];
         }else{
             $this->data['rawLeadCPA'] = 0;
         }
        $this->template->load("agent", "leadstore/index", $this->data);
    }

    public function campaigns() {
        $this->data['title'] = 'Agent | Lead Store Campaigns';
        $this->data['pagetitle'] = 'Campaigns';
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Campaigns';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Campaigns Listing';
        $this->template->load("agent", "leadstore/campaignslist", $this->data);
    }

    public function campaignjson() {

        $table = 'lead_campaign lc';
        $aColumns = array('campaign_id', 'lc.name', 'a.fname', 'a.lname', 'age.name', 'lcc.cat_name', 'lc.auct_type', 'lc.daily_budget', 'lc.max_cost', 'lc.active');
        $bColumns = array('campaign_id', 'name', 'agent_name', 'agency_name', 'cat_name', 'auct_type', 'daily_budget', 'max_cost', 'active');
        $relation = array(
            "fields" => 'campaign_id,lc.name,CONCAT(a.fname," ",a.lname) as agent_name,age.name as agency_name,lcc.cat_name,lc.auct_type,lc.daily_budget,lc.max_cost,lc.active',
            "JOIN" => array(
                array(
                    "table" => 'agents a',
                    "condition" => 'lc.user_id = a.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agencies age',
                    "condition" => 'a.agency_id = age.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'lead_campaign_category lcc',
                    "condition" => 'lc.campcat = lcc.id ',
                    "type" => 'LEFT'
                ),
            ),
        );

        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $relation['ORDER_BY']['field'] = $aColumns[$i];
                    $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
                }
            }
        }

        // /*
        //  * Filtering
        //  * NOTE this does not match the built-in DataTables filtering which does it
        //  * word by word on any field. It's possible to do here, but concerned about efficiency
        //  * on very large tables, and MySQL's regex functionality is very limited
        //  */
        $sWhere = "lc.user_id = " . $this->session->userdata('agent')->id . " AND lc.is_archive = 0";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] = $sWhere;

        $aFilterResult = $this->campaign_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }

        $rResult = $this->campaign_m->get_relation($table, $relation);

        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = $iFilteredTotal;

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 1;

        if ($segement) :
            $count = $_GET['iDisplayStart'] + 1;
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                //$row[] = $count++;

                for ($i = 0; $i < count($bColumns); $i++) {
                    if ($bColumns[$i] == 'campaign_id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['campaign_id']) . '"/>';
                    } elseif ($bColumns[$i] == 'daily_budget' || $bColumns[$i] == 'max_cost') {
                        $row[] = isset($aRow[$bColumns[$i]]) ? toMoney($aRow[$bColumns[$i]]) : '';
                    } elseif ($bColumns[$i] == 'auct_type') {
                        $auction = array('live_transfer' => 'Live Transfer', 'data' => 'Data');
                        $auct_type = $aRow[$bColumns[$i]];
                        $row[] = isset($aRow[$bColumns[$i]]) ? $auction[$auct_type] : '';
                    } elseif ($bColumns[$i] == 'active') {
                        if (isset($aRow[$bColumns[$i]]) && $aRow[$bColumns[$i]] == '1') {
                            $row[] = '<span class="label label-success">Active</span>';
                        } else {
                            $row[] = '<span class="label label-danger">Paused</span>';
                        }
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
                $row[] = '<a href="' . site_url('leadstore/edit/' . encode_url($aRow['campaign_id'])) . '" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('leadstore/delete/' . encode_url($aRow['campaign_id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="' . site_url('leadstore/archive/' . encode_url($aRow['campaign_id'])) . '" title="Archive"><i class="fa fa-archive" aria-hidden="true"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function archive_campaigns() {
        $this->data['title'] = 'Agent | Lead Store Archive Campaigns';
        $this->data['pagetitle'] = 'Archive Campaigns';
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Archive Campaigns';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Archive Campaigns Listing';
        $this->template->load("agent", "leadstore/archive_campaignslist", $this->data);
    }

    public function archive_campaignjson() {

        $table = 'lead_campaign lc';
        $aColumns = array('campaign_id', 'lc.name', 'a.fname', 'a.lname', 'age.name', 'lcc.cat_name', 'lc.auct_type', 'lc.daily_budget', 'lc.max_cost', 'lc.active');
        $bColumns = array('campaign_id', 'name', 'agent_name', 'agency_name', 'cat_name', 'auct_type', 'daily_budget', 'max_cost', 'active');
        $relation = array(
            "fields" => 'campaign_id,lc.name,CONCAT(a.fname," ",a.lname) as agent_name,age.name as agency_name,lcc.cat_name,lc.auct_type,lc.daily_budget,lc.max_cost,lc.active',
            "JOIN" => array(
                array(
                    "table" => 'agents a',
                    "condition" => 'lc.user_id = a.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agencies age',
                    "condition" => 'a.agency_id = age.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'lead_campaign_category lcc',
                    "condition" => 'lc.campcat = lcc.id ',
                    "type" => 'LEFT'
                ),
            ),
        );

        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $relation['ORDER_BY']['field'] = $aColumns[$i];
                    $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
                }
            }
        }

        // /*
        //  * Filtering
        //  * NOTE this does not match the built-in DataTables filtering which does it
        //  * word by word on any field. It's possible to do here, but concerned about efficiency
        //  * on very large tables, and MySQL's regex functionality is very limited
        //  */
        $sWhere = "lc.user_id = " . $this->session->userdata('agent')->id . " AND lc.is_archive = 1";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] = $sWhere;

        $aFilterResult = $this->campaign_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }

        $rResult = $this->campaign_m->get_relation($table, $relation);

        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = $iFilteredTotal;

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 1;

        if ($segement) :
            $count = $_GET['iDisplayStart'] + 1;
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                //$row[] = $count++;

                for ($i = 0; $i < count($bColumns); $i++) {
                    if ($bColumns[$i] == 'campaign_id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['campaign_id']) . '"/>';
                    } elseif ($bColumns[$i] == 'daily_budget' || $bColumns[$i] == 'max_cost') {
                        $row[] = isset($aRow[$bColumns[$i]]) ? toMoney($aRow[$bColumns[$i]]) : '';
                    } elseif ($bColumns[$i] == 'auct_type') {
                        $auction = array('live_transfer' => 'Live Transfer', 'data' => 'Data');
                        $auct_type = $aRow[$bColumns[$i]];
                        $row[] = isset($aRow[$bColumns[$i]]) ? $auction[$auct_type] : '';
                    } elseif ($bColumns[$i] == 'active') {
                        if (isset($aRow[$bColumns[$i]]) && $aRow[$bColumns[$i]] == '1') {
                            $row[] = '<span class="label label-success">Active</span>';
                        } else {
                            $row[] = '<span class="label label-danger">Paused</span>';
                        }
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
                $row[] = '<a class="delete" href="' . site_url('leadstore/delete/' . encode_url($aRow['campaign_id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="' . site_url('leadstore/unarchive/' . encode_url($aRow['campaign_id'])) . '" title="Unarchive"><i class="fa fa-archive" aria-hidden="true"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * Campaign edit and add page in maintain by this controller page.
     * @param type|null $id
     * @return type
     */
    public function edit($id = NULL) {
        $this->data['title'] = 'Agent | Lead Store Campaigns';
        $this->data['pagetitle'] = 'Manage Campaigns';

        $this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Campaign Operation";

        /* set variable to include javascript */
        $this->data['statechart'] = TRUE;
        $this->data['rangeslider'] = TRUE;
        $this->data['taginput'] = TRUE;
        $this->data['formwizard'] = TRUE;
        $this->data['statechart'] = TRUE;
        $this->data['sweetAlert'] = TRUE;

        $this->data['pre_filters'] = $this->filter_m->get_by(array('filter_group' => 'precision'));
        $this->data['aff_filters'] = $this->filter_m->get_by(array('filter_group' => 'affordability'));

        if ($id) {
            $id = decode_url($id);
            $this->data['campaign'] = $this->campaign_m->get_by(array('campaign_id' => $id), TRUE);
            count($this->data['campaign']) || $this->data['errors'][] = "Unable to find campaign.";
            $this->data['listtitle'] = "Edit Campaign";
        } else {
            $this->data['listtitle'] = "Add A New Campaign";
            $this->data['campaign'] = $this->campaign_m->get_new();
        }


        $rules = $this->campaign_m->rules_buyer;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == true) {
            // echo "<pre>";print_r($_POST);die;
            $data = $this->campaign_m->array_from_post(array(
                'campcat', 'auct_type', 'bid_id', 'user_id', 'name', 'descr', 'max_cost', 'delivery_phone', 'lead_throtle', 'daily_budget', 'delivery_email'
            ));

            if ($this->input->post('active') == 'on') {
                $data['active'] = 1;
            } else {
                $data['active'] = 0;
            }
            if ($this->input->post('custom_schedule') == 'on') {
                $data['ref_schedule'] = serialize($this->input->post('schedule_time'));
            } else {
                $data['ref_schedule'] = '';
            }
            if ($this->input->post('location-switch') == 'state' && $this->input->post('state')) {
                $data['ref_states'] = implode(',', $this->input->post('state'));
                $data['ref_zipcodes'] = '';
            } else {
                $data['ref_states'] = '';
                $data['ref_zipcodes'] = $this->input->post('ref_zipcodes');
            }
            $data['filters'] = serialize($this->input->post('filters'));

            $id = $this->campaign_m->save($data, $id);
            $this->session->set_flashdata('success', 'Campaign successfully saved.');
            redirect('leadstore/campaigns');
        }
        // Load the view
        $this->template->load('agent', 'leadstore/edit_campaign', $this->data);
    }

    public function delete($id) {
        if ($id) {
            $id = decode_url($id);
            $this->campaign_m->delete($id);
            $this->session->set_flashdata('success', 'Campaign deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Campaign doesn\'t exist.');
        }
        redirect('leadstore/campaigns');
    }

    public function massaction() {
        $ids = $this->input->post('id');
        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Campaign id selected.');
            redirect('leadstore/campaigns');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->campaign_m->delete($id);
                }
                $this->session->set_flashdata('success', 'Campaign ids deleted successfully.');
                break;
        }
        redirect('leadstore/campaigns');
    }

    /**
     * make campaign in archive
     * @param type|null $id
     * @return type
     */
    public function archive($id = NULL) {
        if ($id != NULL) {
            $id = decode_url($id);
            $data = array('is_archive' => '1');
            $this->campaign_m->save($data, $id);
            $this->session->set_flashdata('success', 'Campaign successfully archived.');
        } else {
            $this->session->set_flashdata('error', 'No Campaign id found.');
        }
        redirect('leadstore/archive_campaigns');
    }

    /**
     * make campaign unarchive
     * @param type|null $id
     * @return type
     */
    public function unarchive($id = NULL) {
        if ($id != NULL) {
            $id = decode_url($id);
            $data = array('is_archive' => '0');
            $this->campaign_m->save($data, $id);
            $this->session->set_flashdata('success', 'Campaign successfully removed from archived.');
        } else {
            $this->session->set_flashdata('error', 'No Campaign id found.');
        }
        redirect('leadstore/campaigns');
    }

    /**
     * get the bids and auctions available in selected vertical
     * @return json string
     */
    public function checkvertical() {

        $isAjax = $this->input->post('isAjax');
        if ($isAjax == 'true') {
            $vertical = $this->vertical_m->get($this->input->post('vertical'), TRUE);
            $result['auctions'] = explode(',', $vertical->auctions);
            $result['bid'] = explode(',', $vertical->bid);
            $result['filters'] = unserialize($vertical->filters);
            //$filterHtml = $this->load->view('admin/filter/campaignfilter',$data, TRUE);
            //$result['html'] = $filterHtml;
            echo json_encode($result);
        }
        exit;
    }

    /**
     * lead email example
     * @return json string
     */
    public function testemail() {
        $this->load->model('emailtemplate_m');
        $isAjax = $this->input->post('isAjax');
        if ($isAjax) {
            $mails = explode(',', $this->input->post('mails'));
            foreach ($mails as $key => $mail) {
                /* send mail to user */
                $template = $this->emailtemplate_m->get_by(array('event' => 'test_lead'), TRUE);
                $subject = $template->subject;
                $html = $template->body;
                $data = array(
                    'vertical' => $this->input->post('vertical'),
                    'auction' => $this->input->post('aucttype'),
                    'm/d/y' => date('m/d/Y'),
                    'customerName' => 'Shipper',
                    'customerPhone' => '(999) 999-9999',
                    'customerEmail' => 'admin@lead.com',
                    'customerCity' => 'San Deigo',
                    'customerState' => 'CA',
                    'customerZip' => '90210',
                    'customerSex' => 'Male',
                    'customerDob' => '07/01/1980',
                    'customerAge' => '35 years old',
                    'customerHeight' => '5\' 6"',
                    'customerWeight' => '170lbs.',
                    'customerHousehold' => '1',
                    'customerMed' => 'None',
                    'customerPregnant' => 'No',
                    'customerTobacco' => 'No',
                    'customerIncome' => 'Unknown',
                    'customerTimeframe' => 'Not Sure',
                    'customerLifeevent' => 'None',
                    'customerNotes' => 'None',
                );
                $subject = $this->parser->parse_string($subject, $data, TRUE);
                $message = $this->parser->parse_string($html, $data, TRUE);

                $this->load->model('email_model');
                $res = $this->email_model->mail_send($subject, $mail, $message);
            }
            // echo $res;die;
            echo json_encode($mails);
        }
    }

    public function change_campaign_status() {

        $campaign_id = $this->input->post('campaign_id');
        $active = $this->input->post('active');
        $data = ['active' => $active];
        $res = $this->campaign_m->save($data, $campaign_id);
        echo $res;
    }

    /**
     * Function for checkout in Leads Store
     */
    public function checkout() {
        $this->load->model('Country_model');
        $this->load->model('Agent_model');
        $this->data['title'] = 'Agent | Lead Store Checkout';
        $this->data['pagetitle'] = 'Checkout';
        $this->data['validation'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['mask'] = TRUE;
        $this->data['label'] = 'Checkout';
        $this->data['country'] = $this->Country_model->getAll();
        $this->template->load("agent", "leadstore/checkout/payment", $this->data);
    }

    public function receipt($id = null) {
        $this->data['pagetitle'] = 'Receipt';
        $this->data['breadcrumb'] = 'Receipt';
        $this->data['title'] = 'Agent | Lead Receipt';
        $order_item_id = base64_decode(urldecode($id));
        $sql = "SELECT `loi`.*,`lo`.*,`a`.fname,`a`.lname FROM `lead_order_item` `loi` "
                . "LEFT JOIN `lead_order` `lo` ON `loi`.`order_id` = `lo`.`order_id` "
                . "LEFT JOIN `agents` `a` ON `lo`.`agent_id` = `a`.`id`"
                . " WHERE `order_item_id` = ".$order_item_id."";
        $query = $this->db->query($sql);
        $this->data['result'] = $query->row_array();
        //unserialize($result['item_desc']);

        $this->template->load("agent", "leadstore/recipt", $this->data);

    }

}
