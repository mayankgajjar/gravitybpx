<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_lead extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Leadorder_m');
    }

    public function index() {
        $this->data['title'] = 'Admin | Order Lead';
        $this->data['pagetitle'] = 'Order Lead';
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Order Lead';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Order Lead Listing';
        $this->template->load("agency", "order_lead/list_order_lead", $this->data);
    }

    public function orderleadjson() {
        $aColumns = array('ol.order_id', 'a.fname', 'a.lname', 'ol.lead_type', 'ol.lead_category', 'ol.lead_quantity', 'ol.total_amount', 'ol.transaction_id', 'ol.transaction_date');
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . $_GET['iDisplayStart'] . ", " .
                    $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                                            " . $_GET['sSortDir_' . $i] . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        /* if($type == NULL){
          $type = '';
          }
          $sWhere = "WHERE status = '{$type}' "; */
        if ($_GET['sSearch'] != "") {
            $sWhere .= "AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        $rResult = $this->Leadorder_m->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->Leadorder_m->queryForAgency($sWhere);
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

                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'lead_id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['lead_id']) . '"/>';
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function orderjson() {
        $table = 'lead_order order';
        $aColumns = array('order.order_id', 'a.fname', 'a.lname', 'order.total_amount', 'order.transaction_id', 'order.created');
        $bColumns = array('agent_name', 'lead_quantity', 'total_amount', 'transaction_id', 'created');
        $relation = array(
            "fields" => 'order.order_id,CONCAT(a.fname," ",a.lname) as agent_name,sum(item.qty) as lead_quantity,order.total_amount,order.transaction_id,order.created',
            "JOIN" => array(
                array(
                    "table" => 'agents a',
                    "condition" => 'order.agent_id = a.id ',
                    "type" => 'FULL'
                ),
                array(
                    "table" => 'lead_order_item item',
                    "condition" => 'order.order_id = item.order_id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'temp_lead_convert temp',
                    "condition" => 'temp.agent_id = a.id ',
                    "type" => 'FULL'
                ),
            ),
            "GROUP_BY" => array(
                "item.order_id"
            ),
            "conditions" => array(
                "temp.status" => 'true',
                "a.agency_id" =>$this->session->userdata('agency')->id,
            )
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
        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] = $sWhere;
        $aFilterResult = $this->Leadorder_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        $rResult = $this->Leadorder_m->get_relation($table, $relation);
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
                $row[] = $count++;
                for ($i = 0; $i < count($bColumns); $i++) {
                    $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                }

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
//        echo $this->db->last_query();
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

}
