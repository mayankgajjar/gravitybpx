<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Storecheckout extends CI_Controller {

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
        $this->load->model('rawleadfilter_m');
        $this->load->model('rawlead_m');
        $this->load->model('leadorder_m');
        $this->load->model('leadorderitem_m');
        $this->data['lead_type'] = array(
            '2to30' => array(
                'name' => 'Medicare Supplement 2 To 30 Days Old',
                '249' => 2.00,
                '999' => 1.50,
                '4999' => 1.20,
                '9999' => 1.00,
                '24999' => 0.75,
                '25000' => 0.60,
            ),
            '31to85' => array(
                'name' => 'Medicare Supplement 31 To 85 Days Old',
                '249' => 1.50,
                '999' => 1.20,
                '4999' => 1.00,
                '9999' => 0.75,
                '24999' => 0.60,
                '25000' => 0.40,
            ),
            '86to365' => array(
                'name' => 'Medicare Supplement 86 To 365 Days Old',
                '249' => 0.40,
                '999' => 0.40,
                '4999' => 0.30,
                '9999' => 0.25,
                '24999' => 0.15,
                '25000' => 0.12,
            ),
            '366+' => array(
                'name' => 'Medicare Supplement 366+ Days Old',
                '249' => 0.25,
                '999' => 0.25,
                '4999' => 0.20,
                '9999' => 0.15,
                '24999' => 0.12,
                '25000' => 0.10,
            )
        );
    }

    public function filter($type) {
        $this->data['type'] = $type;
        $this->data['state_result'] = $this->State_model->getAll();
        $this->load->view('agent/leadstore/checkout/filter', $this->data);
    }

    public function filterPost() {
        $this->load->model('templeadconvert_m');
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $this->data['post'] = $post;

            if ($post['min_age'] != "None") {
                $minage = $post['min_age'];
            }
            if ($post['max_age'] != "None") {
                $max_age = $post['max_age'];
            }
            if ($post['filter_by_zip_code'] == "YES") {
                $zip_list = '';
                $zip_li = '';
                $zipcode = rtrim($post['filter_by_zip_codes'], ',');
                $zip = explode(",", $zipcode);
                foreach ($zip as $zips) {
                    $zip_li .= "'" . $zips . "',";
                }
                $zip_list = rtrim($zip_li, ',');
            }
            if ($post['filter_by_area_code'] != "none") {
                $area_code = $post['filter_by_area_code'];
                $filter_area_state_code = explode(",", $post['filter_by_area_codes']);
                $city = [];
                foreach ($filter_area_state_code as $value) {
                    $city_query = "SELECT GROUP_CONCAT(CONCAT('\'',city,'\'')) as city FROM `state_city_area` WHERE `area_code`=" . $value . "";
                    $city_list_query = $this->db->query($city_query);
                    $city_list = $city_list_query->row_array();
                    $clist = explode(',', $city_list['city']);
                    foreach ($clist as $cl) {
                        $city_array[] = $cl;
                    }
                }
                $city_str01 = implode(",", $city_array);
                $city_str02 = $city_str01;
                $city_str = rtrim($city_str02, ',');
            }

            if (!empty($post['state_code'])) {
                $state_list = '';
                $states = '';
                foreach ($post['state_code'] as $state) {
                    $states .= "'" . $state . "',";
                }
                $state_list = rtrim($states, ',');
            }

            $sql = " 1 > 0 ";
            /* filter for category raw or aged lead */
            if (isset($post['category'])) {
                $sql .= " AND category LIKE '{$post['category']}'";
            }

            if (isset($post['ltype'])) {
                if ($post['ltype'] == '2to30') {
                    $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
                } else if ($post['ltype'] == '31to85') {
                    $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
                } else if ($post['ltype'] == '86to365') {
                    $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
                } else if ($post['ltype'] == '366+') {
                    $sql .= " AND `created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
                }
            }

            if (isset($zip)) {
                $sql .= " AND zip IN(" . $zip_list . ")";
            }
            if (isset($state_list)) {
                $sql .= " AND state IN(" . $state_list . ")";
            }
            if (isset($minage) && $minage > 0) {
                $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 >='" . $minage . "'";
            }
            if (isset($max_age) && $max_age > 0) {
                $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 <='" . $max_age . "'";
            }
            if (isset($area_code)) {
                if ($area_code == 'filter_area_include') {
                    $sql .= " AND city IN(" . $city_str . ")";
                }
                if ($area_code == 'filter_area_exclude') {
                    $sql .= " AND city NOT IN(" . $city_str . ")";
                }
            }
            /* ------------ For Check ids not available in the session list -------------- */
            $ids = '';
            if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) {
                foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                    if ($cart_data['lead_ids'] != '') {
                        $ids .= $cart_data['lead_ids'] . ",";
                    }
                }
            }

            $temp_data = $this->templeadconvert_m->get_by(['agent_id' => $this->session->userdata("agent")->id, 'status' => 'true']);
            if ($temp_data != '' && count($temp_data) > 0) {
                foreach ($temp_data as $key => $temp_cart_data) {
                    if ($temp_cart_data->lead_ids != '') {
                        $ids .= $temp_cart_data->lead_ids . ",";
                    }
                }
            }
            if ($ids != '') {
                $ids = rtrim($ids, ",");
                $ids = explode(",", $ids);
                $sql .= " AND (";
                $lead_ids_chunk = array_chunk($ids, 1000);
                foreach ($lead_ids_chunk as $k => $chnk) {
                    $str = implode(",", $chnk);
                    if ($k == 0) {
                        $sql .= "id NOT IN(" . $str . ")";
                    } else {
                        $sql .= " and id NOT IN(" . $str . ")";
                    }
                }
                $sql .= ")";
            }
            /* ------------ For Check ids not available in the session list -------------- */
            $data = $this->rawlead_m->get_relation('', array('fields' => 'count(id) AS Total', 'conditions' => $sql));
            $this->data['filterData'] = $data[0];
            $html = $this->load->view('agent/leadstore/checkout/filter-result', $this->data, true);
            $output['success'] = true;
            //$output['data'] = $post;
            $output['html'] = $html;
        } else {
            $output['success'] = false;
            $output['data'] = '';
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function saveFilter() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $filterId = isset($post['filter_id']) && $post['filter_id'] > 0 ? $post['filter_id'] : NULL;
            unset($post['filter_id']);
            $data = array(
                'agent_id' => $this->session->userdata('agent')->id,
                'filter_value' => serialize($post)
            );
            $id = $this->rawleadfilter_m->save($data, $filterId);
            if ($id) {
                $output['success'] = true;
                $output['data'] = $id;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Filter saved successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = false;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong.</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /*public function add_to_cart_lead() {
        $lead_cart = array();
        $lead_cart[0] = $_POST;
        $lead_price = $this->get_item_price($lead_cart[0]['ltype'], $lead_cart[0]['quantity']);
        $lead_ids = $this->fetch_item($_POST);
        $lead_cart[0]['lead_ids'] = $lead_ids;
        $lead_cart[0]['lead_price'] = $lead_price;
        $lead_cart[0]['sub_total'] = $lead_price * $lead_cart[0]['quantity'];
        if ($this->session->userdata('lead_cart') != '') {
            $lead_data = $this->session->userdata('lead_cart');
            $lead_cart1 = array_merge($lead_data, $lead_cart);
            $old_array = $this->session->userdata('lead_cart');
            foreach ($old_array as $key => $oa) {
                if ($lead_cart[0]['ltype'] == $oa['ltype'] && $lead_cart[0]['state_code'] == $oa['state_code'] && $lead_cart[0]['min_age'] == $oa['min_age'] && $lead_cart[0]['max_age'] == $oa['max_age'] && $lead_cart[0]['filter_by_area_code'] == $oa['filter_by_area_code'] && $lead_cart[0]['filter_by_zip_code'] == $oa['filter_by_zip_code'] && $lead_cart[0]['cell_phone_land_line'] == $oa['cell_phone_land_line']) {
                    unset($lead_cart1[$key]);
                }
            }
            $lead_cart1 = array_values($lead_cart1);
            $this->session->set_userdata('lead_cart', $lead_cart1);
        } else {
            $this->session->set_userdata('lead_cart', $lead_cart);
        }
        redirect('storecheckout/cart');
    }*/
    
    public function add_to_cart_lead() {
        $lead_cart = array();
        if($this->session->userdata('copy_cart_item') != '' && count($this->session->userdata('copy_cart_item')) > 0){
            $lead_cart[0] = $this->session->userdata('copy_cart_item');
            $lead_ids = $this->fetch_item($this->session->userdata('copy_cart_item')); 
            $this->session->unset_userdata('copy_cart_item');
        } else {
            $lead_cart[0] = $_POST;
            $lead_ids = $this->fetch_item($_POST);
        }
        $lead_price = $this->get_item_price($lead_cart[0]['ltype'], $lead_cart[0]['quantity']);
        $lead_cart[0]['lead_ids'] = $lead_ids;
        $lead_cart[0]['lead_price'] = $lead_price;
        $lead_cart[0]['sub_total'] = $lead_price * $lead_cart[0]['quantity'];
        if ($this->session->userdata('lead_cart') != '') {
            $lead_data = $this->session->userdata('lead_cart');
            $lead_cart1 = array_merge($lead_data, $lead_cart);
            if($status == null){
                foreach ($lead_data as $key => $oa) {
                    if ($lead_cart[0]['ltype'] == $oa['ltype'] && $lead_cart[0]['state_code'] == $oa['state_code'] && $lead_cart[0]['min_age'] == $oa['min_age'] && $lead_cart[0]['max_age'] == $oa['max_age'] && $lead_cart[0]['filter_by_area_code'] == $oa['filter_by_area_code'] && $lead_cart[0]['filter_by_zip_code'] == $oa['filter_by_zip_code'] && $lead_cart[0]['cell_phone_land_line'] == $oa['cell_phone_land_line'] && $lead_cart[0]['category'] == $oa['category']) {
                        unset($lead_cart1[$key]);
                    }
                }
                $lead_cart1 = array_values($lead_cart1);
                $this->session->set_userdata('lead_cart', $lead_cart1);
            } else {
                $this->session->set_userdata('lead_cart', $lead_cart);
            }
        } else {
            $this->session->set_userdata('lead_cart', $lead_cart);
        }
        redirect('storecheckout/cart');
    }

    public function cart() {
        $this->data['title'] = 'Aged Lead Insuarance | Cart';
        $this->data['breadcrumb'] = 'cart';
        $this->data['pagetitle'] = 'Shopping Cart';
        $this->template->load('agent', 'leadstore/checkout/cart', $this->data);
    }

    public function remove_item_list() {
        foreach ($this->input->post('cart_id') as $id) {
            unset($_SESSION['lead_cart'][$id]);
        }
        array_values($_SESSION['lead_cart']);
        echo true;
    }

    public function continue_shop() {
        $this->session->set_flashdata('conti_shop', 'yes');
        // For open popup according to category wise.
        $last_cart = end($this->session->userdata('lead_cart')); 
        $this->session->set_flashdata('conti_cat',$last_cart['category']);
        redirect('leadstore/index');
    }

    public function getCounty() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            // $url = 'http://api.sba.gov/geodata/county_links_for_state_of/'.$post['state'].'.json';
            $stmt = "SELECT distinct(county) as name FROM city_zipcodes WHERE state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->result_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
        }
    }

    public function getCity() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            //http://api.sba.gov/geodata/all_links_for_county_of/COUNTY_NAME/STATE_ABBREVIATION.FORMAT
            //$url = 'http://api.sba.gov/geodata/all_links_for_county_of/'.urlencode($post['county']).'/'.$post['state'].'.json';
            $stmt = "SELECT distinct(county), city as name FROM city_zipcodes WHERE county='" . $post['county'] . "' AND state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->result_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
        }
    }

    public function getZip() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            //$url = 'https://www.zipcodeapi.com/rest/DyXqchM5R2YWFXjFn4i5V0f2bwzVSoCvXzW9RJfILeErbY6z3pEYqU0CrzxjYaPV/city-zips.json/'.urlencode($post['city']).'/'.$post['state'];
            //$data = file_get_contents($url);
            $stmt = "SELECT zip_code FROM city_zipcodes WHERE city='" . $post['city'] . "' AND county='" . $post['county'] . "' AND state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->row_array();
            $data = array_values($data);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('zip' => implode(',', $data))));
        }
    }

    public function getZipByRadius() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $url = "http://www.zipcodeapi.com/rest/Xav11UF7ePQaAkmwqil0N1PKdw9e1lGYwb0x5FFjvvu6QQCg9YhWZ7GcEQrFc7EI/radius.json/" . urlencode($post['zipcode']) . "/" . urlencode($post['miles']) . "/miles?minimal";
            $data = file_get_contents($url);
            $data = json_decode($data);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('zip' => implode(',', $data->zip_codes))));
        }
    }

    public function getZipByScf() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $stmt = "SELECT GROUP_CONCAT(zip_code) as string FROM `city_zipcodes` WHERE zip_code like '" . $post['scf'] . "%'";
            $query = $this->db->query($stmt);
            $data = $query->row_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('zip' => $data['string'])));
        }
    }

    public function getAreaCode() {
        $state = $this->input->post('state');

        $this->db->group_by('area_code');
        $this->db->where('state_code', $state);
        $area_code_query = $this->db->get('state_city_area');
        $data = $area_code_query->result_array();

        if (!empty($data)) {
            foreach ($data as $state) {
                echo "<div class='col-sm-3'><div class='col-sm-2'><input type='checkbox' class='state-chk' name='filter_area_state_code[]' value='" . $state['area_code'] . "'></div>
                <div class='col-sm-10'>" . $state['area_code'] . "</div></div>";
            }
        }
    }

    public function get_item_price($ltype, $qty) {
        $lead_type_data = $this->data['lead_type'][$ltype];
        $item_price = 0;
        if ($qty < 250) {
            $item_price = $lead_type_data['249'];
        } elseif ($qty >= 250 && $qty <= 999) {
            $item_price = $lead_type_data['999'];
        } elseif ($qty >= 1000 && $qty <= 4999) {
            $item_price = $lead_type_data['4999'];
        } elseif ($qty >= 5000 && $qty <= 9999) {
            $item_price = $lead_type_data['9999'];
        } elseif ($qty >= 10000 && $qty <= 24999) {
            $item_price = $lead_type_data['24999'];
        } elseif ($qty >= 25000) {
            $item_price = $lead_type_data['25000'];
        }
        return $item_price;
    }

    public function findex() {
        $this->data['title'] = 'Agent | Lead Store Saved Filters';
        $this->data['pagetitle'] = 'Saved Filters';
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Filters';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Filters Listing';
        $this->template->load("agent", "leadstore/checkout/list", $this->data);
    }

    public function findexjson() {
        $agent = $this->agents->get($this->session->userdata('agent')->id);
        $aColumns = array('filter_id', 'filter_value', 'created', 'agent_id');
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
        $sWhere = " WHERE (agent_id = {$this->session->userdata('agent')->id})";
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        $rResult = $this->rawleadfilter_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->rawleadfilter_m->query($sWhere, $sOrder);
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
            $leadType = $this->data['lead_type'];
            $options = unserialize(LEADSTORE_FILTER_PHONE_OPTIONS);
            foreach ($rResult as $aRow) {
                $row = array();
                $row[] = $count++;
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'filter_id' || $aColumns[$i] == 'agent_id') {

                    } elseif ($aColumns[$i] == 'filter_value') {
                        $value = unserialize($aRow[$aColumns[$i]]);
                        $html = '<table class="table">';
                        $html .= '<tr>';
                        $html .= '<th>Lead Type</th><td>' . $leadType[$value['ltype']]['name'] . '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>States</th><td>';
                        if (isset($value['filter_by_state']) && $value['filter_by_state'] == 'all'):
                            $html .= $value['filter_by_state'];
                        else:
                            $html .= implode(',', $value['state_code']);
                        endif;
                        $html .= '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>Consumer Age Minimum (Years)</th><td>' . $value['min_age'] . '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>Consumer Age Maximum (Years)</th><td>' . $value['max_age'] . '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>Cell phone and/or Land Line</th><td>';
                        $key = array_search($value['cell_phone_land_line'], $options);
                        $html .= $key . '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>Filter By Area Code</th><td>';
                        if ($value['filter_by_area_code'] == 'filter_area_include' || $value['filter_by_area_code'] == 'filter_area_exclude'):
                            $html .= $value['filter_by_area_codes'];
                        else:
                            $html .= $value['filter_by_area_code'];
                        endif;
                        $html .= '</td>';
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<th>Filter By Zip Code</th><td>';
                        if ($value['filter_by_zip_code'] == 'YES'):
                            $html .= $value['filter_by_zip_codes'];
                        else:
                            $html .= $value['filter_by_zip_code'];
                        endif;
                        $html .= '</tr>';
                        $html .= '</table>';
                        $row[] = $html;
                    }else {
                        $row[] = $aRow[$aColumns[$i]];
                    }
                }
                $row[] = '<a class="delete btn green btn-xs" href="' . site_url('storecheckout/fdelete/' . encode_url($aRow['filter_id'])) . '"><i class="fa fa-trash"></i></a>';
                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'][] = $row;
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function fdelete($id = NULL) {
        if ($id) {
            $filterId = decode_url($id);
            $this->rawleadfilter_m->delete($filterId);
            $this->session->set_flashdata('success', 'Filter deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Filter doesn\'t exist.');
        }
        redirect('storecheckout/findex');
    }

    /**
     * Function for checkout in Leads Store
     */
    public function checkout() {
        // Check condition for your cart is empty or not
        if ($this->session->userdata('lead_cart') != '') {
            $this->load->model('templeadconvert_m');
            $this->load->model('Country_model');
            $this->load->model('Agent_model');
            $this->data['title'] = 'Agent | Lead Store Checkout';
            $this->data['pagetitle'] = 'Checkout';
            $this->data['validation'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['mask'] = TRUE;
            $this->data['label'] = 'Checkout';
            $this->data['country'] = $this->Country_model->getAll();
            //------ For Fetch 20 Year Array
            $curyear = date("Y");
            for ($i = 0; $i < 15; $i++) {
                $year[$i] = $curyear + $i;
            }
            $this->data['year'] = $year;
            //------ End For Fetch 20 Year Array
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|min_length[16]|max_length[16]|numeric');
            $this->form_validation->set_rules('card_expiration_month', 'Card Expiration Month', 'trim|required');
            $this->form_validation->set_rules('card_expiration_year', 'Card Expiration Year', 'trim|required');
            $this->form_validation->set_rules('card_security_code', 'Card Security Code', 'trim|required|min_length[3]|max_length[4]|numeric');
            if ($this->form_validation->run() == TRUE) {
                // Cart Total
                $grand_total = "0";
                foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                    $grand_total = $grand_total + $cart_data['sub_total'];
                }
                $grand_total1 = $grand_total * 100; // Payable Amount IN USD CENT
                $payable = $grand_total1;
                /**
                 * CARD info for Stripe
                 */
                $number = $this->input->post('card_number');
                $cvc = $this->input->post('card_security_code');
                $exp_month = $this->input->post('card_expiration_month');
                $exp_year = $this->input->post('card_expiration_year');
                $name = $this->input->post('card_type');
                $paymentNote = "Lead Store Purchase";
                // Stripe call
                $stripeRes = payable_stripe($payable, $number, $cvc, $exp_month, $exp_year, $name, $paymentNote);
                $stripeArray = json_decode($stripeRes);
                //if paymenet made
                if (isset($stripeArray->id)) {
                    /* Lead ORDER TABLE */
                    $data['transaction_id'] = $stripeArray->id;
                    $data['total_amount'] = $grand_total;
                    $data['agent_id'] = $this->session->userdata("agent")->id;
                    $res = $this->leadorder_m->save($data);
                    if ($res) {
                        /* Lead ORDER ITEM TABLE */
                        $orderId = $this->db->insert_id();
                        $item_data = array();
                        foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {

                            $item_data['order_id'] = $orderId;
                            $item_data['qty'] = $cart_data['quantity'];
                            $item_data['item_price'] = $cart_data['lead_price'];
                            $item_data['total_price'] = $cart_data['sub_total'];
                            $item_data['csv_file_name'] = $cart_data['filename'];
                            /* $item_desc = array(
                              'ltype' => $cart_data['ltype'],
                              'filter_by_state' => $cart_data['filter_by_state'],
                              'state_code' => $cart_data['state_code'],
                              'min_age' => $cart_data['min_age'],
                              'max_age' => $cart_data['max_age'],
                              'filter_by_area_code' => $cart_data['filter_by_area_code'],
                              'filter_by_zip_code' => $cart_data['filter_by_zip_code'],
                              'cell_phone_land_line' => $cart_data['cell_phone_land_line']
                              ); */
                            $item_desc = $cart_data;
                            $item_data['item_desc'] = serialize($item_desc);
                            $resItem = $this->leadorderitem_m->save($item_data);
                            if ($resItem) {
                                $orderItem_id = $this->db->insert_id();
                                $agentDetails = array('agency_id' => $this->session->userdata('agent')->agency_id, 'email' => $this->session->userdata('user')->email_id);
                                $tempData = array(
                                    'agent_id' => $this->session->userdata("agent")->id,
                                    'agent_details' => serialize($agentDetails),
                                    'lead_ids' => $this->session->userdata('lead_cart')[$key]['lead_ids'],
                                    'order_item_id' => $orderItem_id
                                );
                                $tempItem = $this->templeadconvert_m->save($tempData);
                            }
                        }

                        // Lead Transfer Method
                        $this->session->set_flashdata('success', 'Payment Done And System Start Lead Transfer Process');
                        $this->session->unset_userdata('lead_cart');
                        //   $this->leadTransfer(); CRON JOB RUN TRANSFER PROCESS
                        redirect('leadstore/index');
                    } else {
                        $this->session->set_flashdata('error', "Something Went To Wrong");
                    }
                } elseif (isset($stripeArray->error)) {
                    $this->session->set_flashdata('error', $stripeArray->error->message);
                } else {
                    $this->session->set_flashdata('error', "Something Went To Wrong");
                }
                redirect('storecheckout/checkout');
            } else {
                $this->template->load("agent", "leadstore/checkout/payment", $this->data);
            }
        } else {
            $this->session->set_flashdata('error', "Sorry, Your cart is empty please add item into your card.");
            redirect('storecheckout/cart');
        }
    }

    /**
     * @uses For Order History of agent profile
     */
    public function history() {

    }

    /**
     * Ajax Cart
     */
    public function ajax_cart() {
        $this->data['test'] = 'Checkout';
        echo $this->load->view("agent/leadstore/checkout/cart_table", $this->data, TRUE);
    }

    /*public function fetch_item($data) {
        $this->load->model('templeadconvert_m');
        $post = $data;

        if ($post['min_age'] != "None") {
            $minage = $post['min_age'];
        }
        if ($post['max_age'] != "None") {
            $max_age = $post['max_age'];
        }
        if ($post['filter_by_zip_code'] == "YES") {
            $zip_list = '';
            $zip_li = '';
            $zipcode = rtrim($post['filter_by_zip_codes'], ',');
            $zip = explode(",", $zipcode);
            foreach ($zip as $zips) {
                $zip_li .= "'" . $zips . "',";
            }
            $zip_list = rtrim($zip_li, ',');
        }
        if ($post['filter_by_area_code'] != "none") {
            $area_code = $post['filter_by_area_code'];
            $filter_area_state_code = explode(",", $post['filter_by_area_codes']);
            $city = [];
            foreach ($filter_area_state_code as $value) {
                $city_query = "SELECT GROUP_CONCAT(CONCAT('\'',city,'\'')) as city FROM `state_city_area` WHERE `area_code`=" . $value . "";
                $city_list_query = $this->db->query($city_query);
                $city_list = $city_list_query->row_array();
                $clist = explode(',', $city_list['city']);
                foreach ($clist as $cl) {
                    $city_array[] = $cl;
                }
            }
            $city_str01 = implode(",", $city_array);
            $city_str02 = $city_str01;
            $city_str = rtrim($city_str02, ',');
        }

        if (!empty($post['state_code'])) {
            $state_list = '';
            $states = '';
            $list_state = explode(",", $post['state_code']);
            foreach ($list_state as $state) {
                $states .= "'" . $state . "',";
            }
            $state_list = rtrim($states, ',');
        }

        $sql = " 1 > 0 ";
        
        if (isset($post['category'])) {
            $sql .= " AND category LIKE '{$post['category']}'";
        }

        if (isset($post['ltype'])) {
            if ($post['ltype'] == '2to30') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
            } else if ($post['ltype'] == '31to85') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
            } else if ($post['ltype'] == '86to365') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
            } else if ($post['ltype'] == '366+') {
                $sql .= " AND `created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
            }
        }
        if (isset($zip)) {
            $sql .= " AND zip IN(" . $zip_list . ")";
        }
        if (isset($state_list)) {
            $sql .= " AND state IN(" . $state_list . ")";
        }
        if (isset($minage) && $minage > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 >='" . $minage . "'";
        }
        if (isset($max_age) && $max_age > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 <='" . $max_age . "'";
        }
        if (isset($area_code)) {
            if ($area_code == 'filter_area_include') {
                $sql .= " AND city IN(" . $city_str . ")";
            }
            if ($area_code == 'filter_area_exclude') {
                $sql .= " AND city NOT IN(" . $city_str . ")";
            }
        }

        
        $ids = '';
        if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) {
            foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                if ($cart_data['lead_ids'] != '') {
                    $ids .= $cart_data['lead_ids'] . ",";
                }
            }
        }

        $temp_data = $this->templeadconvert_m->get_by(['agent_id' => $this->session->userdata("agent")->id, 'status' => 'true']);
        if ($temp_data != '' && count($temp_data) > 0) {
            foreach ($temp_data as $key => $temp_cart_data) {
                if ($temp_cart_data->lead_ids != '') {
                    $ids .= $temp_cart_data->lead_ids . ",";
                }
            }
        }
        if ($ids != '') {
            $ids = rtrim($ids, ",");
            $ids = explode(",", $ids);
            $sql .= " AND (";
            $lead_ids_chunk = array_chunk($ids, 1000);
            foreach ($lead_ids_chunk as $k => $chnk) {
                $str = implode(",", $chnk);
                if ($k == 0) {
                    $sql .= "id NOT IN(" . $str . ")";
                } else {
                    $sql .= " and id NOT IN(" . $str . ")";
                }
            }
            $sql .= ")";
        }

        

        $limitArray = array();
        $limitArray['end'] = 1;
        $limitArray['start'] = $post['quantity'];
        $ORDER_BY = array();
        $ORDER_BY['field'] = 'rand()';
        $data = $this->rawlead_m->get_relation('', array('fields' => 'id', 'conditions' => $sql, 'LIMIT' => $limitArray, 'ORDER_BY' => $ORDER_BY));
        $array = array_column($data, 'id');
        $str = implode(",", $array);
        return $str;
    }*/
    
    public function fetch_item($data) {
        $this->load->model('templeadconvert_m');
        $post = $data;
        
        if ($post['min_age'] != "None") {
            $minage = $post['min_age'];
        }
        if ($post['max_age'] != "None") {
            $max_age = $post['max_age'];
        }
        if ($post['filter_by_zip_code'] == "YES") {
            $zip_list = '';
            $zip_li = '';
            $zipcode = rtrim($post['filter_by_zip_codes'], ',');
            $zip = explode(",", $zipcode);
            foreach ($zip as $zips) {
                $zip_li .= "'" . $zips . "',";
            }
            $zip_list = rtrim($zip_li, ',');
        }
        if ($post['filter_by_area_code'] != "none") {
            $area_code = $post['filter_by_area_code'];
            $filter_area_state_code = explode(",", $post['filter_by_area_codes']);
            $city = [];
            foreach ($filter_area_state_code as $value) {
                $city_query = "SELECT GROUP_CONCAT(CONCAT('\'',city,'\'')) as city FROM `state_city_area` WHERE `area_code`=" . $value . "";
                $city_list_query = $this->db->query($city_query);
                $city_list = $city_list_query->row_array();
                $clist = explode(',', $city_list['city']);
                foreach ($clist as $cl) {
                    $city_array[] = $cl;
                }
            }
            $city_str01 = implode(",", $city_array);
            $city_str02 = $city_str01;
            $city_str = rtrim($city_str02, ',');
        } else { 
            
        }
        
        if (!empty($post['state_code'])) {
            $state_list = '';
            $states = '';
            $list_state = explode(",", $post['state_code']);
            foreach ($list_state as $state) {
                $states .= "'" . $state . "',";
            }
            $state_list = rtrim($states, ',');
        }

        $sql = " 1 > 0 ";
        /* filter for category raw or aged lead */
        if (isset($post['category'])) {
            $sql .= " AND category LIKE '{$post['category']}'";
        }

        if (isset($post['ltype'])) {
            if ($post['ltype'] == '2to30') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
            } else if ($post['ltype'] == '31to85') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
            } else if ($post['ltype'] == '86to365') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
            } else if ($post['ltype'] == '366+') {
                $sql .= " AND `created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
            }
        }
        if (isset($zip)) {
            $sql .= " AND zip IN(" . $zip_list . ")";
        }
        if (isset($state_list)) {
            $sql .= " AND state IN(" . $state_list . ")";
        }
        if (isset($minage) && $minage > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 >='" . $minage . "'";
        }
        if (isset($max_age) && $max_age > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 <='" . $max_age . "'";
        }
        if (isset($area_code)) {
            if ($area_code == 'filter_area_include') {
                $sql .= " AND city IN(" . $city_str . ")";
            }
            if ($area_code == 'filter_area_exclude') {
                $sql .= " AND city NOT IN(" . $city_str . ")";
            }
        }

        /* ------------ For Check ids not available in the session list -------------- */
        $ids = '';
        if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) {
            $data = $this->session->userdata('lead_cart');
            if(!isset($data['submit'])){
               unset($data);
               $data[0] = $this->session->userdata('lead_cart');
            }
            
            foreach ($data as $key => $cart_data) {
                if ($cart_data['lead_ids'] != '') {
                    $ids .= $cart_data['lead_ids'] . ",";
                } 
            }
        }
       
        $temp_data = $this->templeadconvert_m->get_by(['agent_id' => $this->session->userdata("agent")->id, 'status' => 'true']);
        if ($temp_data != '' && count($temp_data) > 0) {
            foreach ($temp_data as $key => $temp_cart_data) {
                if ($temp_cart_data->lead_ids != '') {
                    $ids .= $temp_cart_data->lead_ids . ",";
                }
            }
        }
        if ($ids != '') {
            $ids = rtrim($ids, ",");
            $ids = explode(",", $ids);
            $sql .= " AND (";
            $lead_ids_chunk = array_chunk($ids, 1000);
            foreach ($lead_ids_chunk as $k => $chnk) {
                $str = implode(",", $chnk);
                if ($k == 0) {
                    $sql .= "id NOT IN(" . $str . ")";
                } else {
                    $sql .= " and id NOT IN(" . $str . ")";
                }
            }
            $sql .= ")";
        }

        /* ------------ For Check ids not available in the session list -------------- */

        $limitArray = array();
        $limitArray['end'] = 1;
        $limitArray['start'] = $post['quantity'];
        $ORDER_BY = array();
        $ORDER_BY['field'] = 'rand()';
        $data = $this->rawlead_m->get_relation('', array('fields' => 'id', 'conditions' => $sql, 'LIMIT' => $limitArray, 'ORDER_BY' => $ORDER_BY));
        $array = array_column($data, 'id');
        $str = implode(",", $array);
        return $str;
    }


    /**
     * @uses Inserting custom values in Lead Custom Fields Tables
     * @param $leadid Last Lead ID
     * @param $field_name Field Name
     * @param type $label Field Label ( HTML USE ONLY )
     * @param type $type HTML Control Type ( TEXT is default,select,radio etc )
     * @param type $options IF Select or Radio type
     * @param type $value Field Value
     * @return boolean
     */
    public function make_custom_field($leadid, $field_name, $label, $type = 'text', $options = '', $value) {
        $data = array(
            'lead_id' => $leadid,
            'field_name' => $field_name,
            'field_settings' => serialize(array(
                'label' => $label,
                'required' => 'no',
                'type' => $type,
                'options' => $options)
            )
        );
        $res = $this->leadfield_m->save($data);
        if ($res) {
            $field_id = $this->db->insert_id();
            $fieldval = array(
                'field_id' => $field_id,
                'value' => $value,
            );
            $res = $this->leadfieldval_m->save($fieldval);
        }
        return true;
    }

    /**
     * For Saving file name in session
     * @param JSON $itemJson filename and other details
     */
    public function filename($itemJson = "") {
        $itemJson = $_REQUEST['items'];
        if ($itemJson != "") {
            $itemJson = json_decode($itemJson);
            $leadCart = $this->session->userdata('lead_cart');
            if (count($leadCart) > 0) {
                foreach ($leadCart as $key => $cartItem) {
                    $leadCart[$key]['filename'] = $itemJson[$key]->file_name;
                    $this->session->set_userdata('lead_cart', $leadCart);
                }
            }
            $returnType = $itemJson[0]->req_type;
            if ($returnType == 'checkout') {
                echo 'checkout';
            } elseif ($returnType == 'continue') {
                echo 'continue';
            } else {
                echo 'true';
            }
        }
    }

    /**
     *
     * @param type $id
     */
    public function DownloadLeadCSV($id = null) {
        $order_item_id = base64_decode(urldecode($id));
        $this->load->model('templeadconvert_m');
        $temp_data = $this->templeadconvert_m->get_by(['order_item_id' => $order_item_id, 'status' => 'true'], TRUE);
        $ids = explode(",", $temp_data->lead_ids);
        $lead_ids_chunk = array_chunk($ids, 1000);
        $sql = "SELECT DATE_FORMAT(created,'%d/%m/%Y') AS Date_post,DATE_FORMAT(created,'%h:%i %p') AS Time_stamp,ip_address AS IP,first_name AS First_name,last_name AS Last_name,address AS Address,city AS City,state AS State,zip AS Zip,email AS Email,phone AS Phone,alt_phone AS Alt_phone,best_time_to_call AS Best_Time_To_Call,existing_condition AS Existing_conditions,expectant_parent AS Expectant_parent,source_url AS Source_url,current_coverage AS Current_coverage,date_of_birth AS Date_Of_Birth,opt_in AS Opt_In,height AS Height_inches,weight AS Weight_pounds,driver_status AS Driver_status,gender AS Gender,own_rent AS Own_Rent,military AS Military,us_citizen AS US_Citizen,income_type AS Income_Type,net_monthly_income AS Net_Monthly_Income,opt_in_2 AS Opt_in_2 FROM `raw_lead_mst` WHERE ";
        $sql .= "( ";
        foreach ($lead_ids_chunk as $k => $chnk) {
            $str = implode(",", $chnk);
            if ($k == 0) {
                $sql .= "id IN(" . $str . ")";
            } else {
                $sql .= " OR id IN(" . $str . ")";
            }
        }
        $sql .= ")";

        $get_file_name_query = $this->db->where('order_item_id', $order_item_id)->get('lead_order_item');
        $get_file_name = $get_file_name_query->row_array();


        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "{$get_file_name['csv_file_name']}.csv";
        $query = $sql;
        $result = $this->db->query($query);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }
    
    public function copy_lead($id = null){
        $order_item_id = base64_decode(urldecode($id));
        $get_item_query = $this->db->where('order_item_id',$order_item_id)->get('lead_order_item');
        $get_item = $get_item_query->row_array();
        $lead_filter = unserialize($get_item['item_desc']);
        
        if ($lead_filter['min_age'] != "None") {
            $minage = $lead_filter['min_age'];
        }
        if ($lead_filter['max_age'] != "None") {
            $max_age = $lead_filter['max_age'];
        }
        if (!empty($lead_filter['state_code'])) {
            $state_list = '';
            $states = '';
            $st_array = explode(",",$lead_filter['state_code']);
            foreach ($st_array as $state) {
                $states .= "'" . $state . "',";
            }
            $state_list = rtrim($states, ',');
        }
     
        if ($lead_filter['filter_by_zip_code'] != "NO" && isset($lead_filter['filter_by_zip_codes'])){
            $zip_list = '';
            $zipcode = '';
            $zip_array = explode(",",$lead_filter['filter_by_zip_codes']);
            foreach ($zip_array as $zip) {
                $zipcode .= "'" . $zip . "',";
            }
            $zip_list = rtrim($zipcode, ',');
        }
        if ($lead_filter['filter_by_area_code'] != "none") {
            $area_code = $post['filter_by_area_code'];
            $filter_area_state_code = explode(",", $lead_filter['filter_by_area_codes']);
            $city = [];
            foreach ($filter_area_state_code as $value) {
                $city_query = "SELECT GROUP_CONCAT(CONCAT('\'',city,'\'')) as city FROM `state_city_area` WHERE `area_code`=" . $value . "";
                $city_list_query = $this->db->query($city_query);
                $city_list = $city_list_query->row_array();
                $clist = explode(',', $city_list['city']);
                foreach ($clist as $cl) {
                    $city_array[] = $cl;
                }
            }
            $city_str01 = implode(",", $city_array);
            $city_str02 = $city_str01;
            $city_str = rtrim($city_str02, ',');
        }
        
        if($lead_filter['lead_ids']){
            $id_list = $lead_filter['lead_ids'];
            
        }

        $sql = " 1 > 0 ";
        
        if (isset($lead_filter['category'])) {
            $sql .= " AND category LIKE '{$lead_filter['category']}'";
        }
        if (isset($lead_filter['ltype'])) {
            if ($lead_filter['ltype'] == '2to30') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
            } else if ($lead_filter['ltype'] == '31to85') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
            } else if ($lead_filter['ltype'] == '86to365') {
                $sql .= " AND `created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
            } else if ($lead_filter['ltype'] == '366+') {
                $sql .= " AND `created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
            }
        }
        if (isset($state_list)) {
            $sql .= " AND state IN(" . $state_list . ")";
        }
        if (isset($minage) && $minage > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 >='" . $minage . "'";
        }
        if (isset($max_age) && $max_age > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), date_of_birth)), '%Y')+0 <='" . $max_age . "'";
        }
        if (isset($zip_array)) {
            $sql .= " AND zip IN(" . $zip_list . ")";
        }
        if(isset($area_code)){
             if ($area_code == 'filter_area_include') {
                $sql .= " AND city IN(" . $city_str . ")";
            }
            if ($area_code == 'filter_area_exclude') {
                $sql .= " AND city NOT IN(" . $city_str . ")";
            }
        }
        if ($lead_filter['lead_ids'] != '') {
                $ids = $lead_filter['lead_ids'];
                $ids = explode(",", $ids);
                $sql .= " AND (";
                $lead_ids_chunk = array_chunk($ids, 1000);
                foreach ($lead_ids_chunk as $k => $chnk) {
                    $str = implode(",", $chnk);
                    if ($k == 0) {
                        $sql .= "id NOT IN(" . $str . ")";
                    } else {
                        $sql .= " and id NOT IN(" . $str . ")";
                    }
                }
                $sql .= ")";
            }
        
        $data = $this->rawlead_m->get_relation('', array('fields' => 'count(id) AS Total', 'conditions' => $sql));
        $filterData = $data[0];
        
        if($filterData['Total'] >= $lead_filter['quantity']){
            $cart_item = array(
                'ltype' => $lead_filter['ltype'],
                'filter_by_state' => $lead_filter['filter_by_state'],
                'state_code' => $lead_filter['state_code'],
                'category' => $lead_filter['category'],
                'min_age' => $lead_filter['min_age'],
                'max_age' => $lead_filter['max_age'],
                'filter_by_area_code' => $lead_filter['filter_by_area_code'],
                'filter_by_state' => $lead_filter['filter_by_state'],
                'filter_by_zip_code' => $lead_filter['filter_by_zip_code'],
                'filter_by_zip_codes' => $lead_filter['filter_by_zip_codes'],
                'filter_by_area_codes' => $lead_filter['filter_by_area_codes'],
                'cell_phone_land_line' => $lead_filter['cell_phone_land_line'],
                'total_avail_lead' => $filterData['Total'],
                'quantity' => $lead_filter['quantity'],
                'lead_ids' => '',
            );
            $this->session->set_userdata('copy_cart_item',$cart_item);
            redirect('storecheckout/add_to_cart_lead');
        } else {
            $this->session->set_flashdata('error', 'Quantity Not Available.');
        }
    }

}
