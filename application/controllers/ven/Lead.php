<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Vendor Can manage leads for leads store module.
 *
 * @author dhareen
 */
class Lead extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Vendor') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Country_model');
        $this->load->model('Rawlead_m');
    }

    public function index() {

        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Vendor | CRM Lead';
        $this->data['maintitle'] = 'Lead';
        $this->data['listtitle'] = "Lead Listing";
        $this->data['label'] = "Lead";
        $this->data['type'] = 'Lead';
        $this->template->load('vendor', 'lead/list', $this->data);
    }

    public function leadjson() {
        $table = 'raw_lead_mst lead';
        $aColumns = array('id', 'first_name', 'last_name', 'email', 'phone');
        $relation = array(
            "fields" => 'id,first_name,last_name,email,phone',
//            "JOIN" => array(
//                array(
//                    "table" => 'users u',
//                    "condition" => 'v.user_id = u.id ',
//                    "type" => 'LEFT'
//                ),
//            ),
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

        $aFilterResult = $this->Rawlead_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }

        $rResult = $this->Rawlead_m->get_relation($table, $relation);

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
                    if ($aColumns[$i] == 'id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['id']) . '"/>';
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] = '<a href="' . site_url('ven/lead/edit/' . encode_url($aRow['id'])) . '" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('ven/lead/delete/' . encode_url($aRow['id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function edit($id = NULL) {
        $this->data['title'] = 'Vendor | Leads';
        $this->data['datepicker'] = 'TRUE';
        $this->data['validation'] = 'TRUE';
        $this->data['mask'] = 'TRUE';
        $this->data['pagetitle'] = 'Manage Leads';
        $this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Leads Operation";
        $this->data['label'] = 'Leads';
        $this->data['country'] = $this->Country_model->getAll();
        /* set variable to include javascript */
        if ($id) {
            $id = decode_url($id);
            $this->data['type'] = 'edit';
            $this->data['listtitle'] = "Edit Lead";
            $this->data['lead'] = $this->Rawlead_m->get_by(array('id' => $id), TRUE);
        } else {
            $this->data['type'] = 'add';
            $this->data['listtitle'] = "Add A New Lead";
            $this->data['lead'] = $this->Rawlead_m->get_new();
        }
        $this->form_validation->set_rules($this->Rawlead_m->rules);

        if ($this->form_validation->run() == TRUE) {

            $data = $this->Rawlead_m->array_from_post(array(
                'category','lead_category' ,'first_name', 'last_name', 'address', 'state', 'city', 'zip', 'email', 'best_time_to_Call', 'existing_condition', 'expectant_parent', 'source_url', 'current_coverage', 'opt_in', 'height', 'weight', 'driver_status', 'gender', 'own_rent', 'military', 'us_citizen', 'income_type', 'net_monthly_income', 'opt_in_2'));
            $data['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('date_of_birth')));

            $data['phone'] = convertphoneformat($this->input->post('phone'));
            $data['alt_phone'] = convertphoneformat($this->input->post('alt_phone'));
            $data['ip_address'] = $this->input->ip_address();
            $res = $this->Rawlead_m->save($data, $id);
            if ($res) {
                $this->session->set_flashdata('success', 'Lead saved successfully.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong');
            }
            redirect('ven/lead');
        }
        $this->template->load('vendor', 'lead/edit_lead', $this->data);
    }

    public function delete($id)
    {
        if ($id){
            $id = decode_url($id);
            $this->Rawlead_m->delete($id);  // Delete vendor data          
            $this->session->set_flashdata('success','Lead deleted successfully.');
        } else {
            $this->session->set_flashdata('error','Lead doesn\'t exist.');
        }
        redirect('ven/lead');   

    }

     public function massaction()
    {
        $ids = $this->input->post('id');
        if(empty($ids))
        {
            $this->session->set_flashdata('error','No Lead id selected.');
            redirect('ven/lead');
        }
        $action = $this->input->post('action');
        switch ($action) 
        {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->Rawlead_m->delete($id);                                          
                }
                $this->session->set_flashdata('success','Lead ids deleted successfully.');
                break;                          
        }           
        redirect('ven/lead');
    }   

    public function lead_bulk_upload(){
        $this->data['title'] = 'Vendor | Leads';
        $this->data['listtitle'] = "Upload Lead";
        $this->data['maintitle'] = "Upload Lead";
        $this->data['validation'] = TRUE;
        $data = [];
        if(isset($_POST['submit'])){
            // echo phpinfo();die;
            ini_set('memory_limit', '-1');
            $filename = $_FILES['lead_file']['name'];
            $file_name = $_FILES['lead_file']['tmp_name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if(file_exists($file_name)){

                    if($ext == 'csv'){
                            $file = fopen($file_name, "r");
                            $key = 0;
                            $data['lead_category'] = $this->input->post('lead_category');
                            $data['category'] = $this->input->post('category');
                             while (($lead_data = fgetcsv($file, 10000, ",")) !== FALSE)
                             {
                                if($key == 0){
                                    if(isset($lead_data[1]) &&  $lead_data[1] != 'Date_post' && isset($lead_data[28]) && $lead_data[28] != 'Opt_in_2'){
                                        $this->session->set_flashdata('error', 'Invalid File Format');
                                        redirect('ven/lead/lead_bulk_upload');
                                    }
                                }else{
                                   
                                    $data['ip_address'] 		= $lead_data[2];
                                    $data['first_name'] 		= $lead_data[3];
                                    $data['last_name'] 			= $lead_data[4];
                                    $data['address'] 			= $lead_data[5];
                                    $data['city'] 			    = $lead_data[6];
                                    $data['state'] 			    = $lead_data[7];
                                    $data['zip'] 			    = $lead_data[8];
                                    $data['email'] 			    = $lead_data[9];
                                    $data['phone'] 			    = convertphoneformat($lead_data[10]);
                                    $data['alt_phone'] 			= convertphoneformat($lead_data[11]);
                                    $data['best_time_to_call']  = strtolower($lead_data[12]);
                                    $data['existing_condition'] = strtolower($lead_data[13]);
                                    $data['expectant_parent']   = $lead_data[14];
                                    $data['source_url'] 		= $lead_data[15];
                                    $data['current_coverage']   = strtolower($lead_data[16]);
                                    $data['date_of_birth'] 		= implode("-", array_reverse(explode("/", $lead_data[17])));
                                    $data['opt_in'] 			= strtolower($lead_data[18]);
                                    // $data['ssn'] 			    = $lead_data[19];
                                    $data['height'] 			= $lead_data[19];
                                    $data['weight'] 			= $lead_data[20];
                                    $data['driver_status'] 		= strtolower($lead_data[21]);
                                    $data['gender'] 			= strtolower($lead_data[22]);
                                    $data['own_rent'] 			= strtolower($lead_data[23]);
                                    $data['military'] 			= strtolower($lead_data[24]);
                                    $data['us_citizen'] 		= strtolower($lead_data[25]);
                                    $data['income_type'] 		= $lead_data[26];
                                    $data['net_monthly_income'] = $lead_data[27];
                                    $data['opt_in_2'] 			= strtolower($lead_data[28]);
                                    $data['created'] 			= date("Y-m-d H:i:s");
                                    $lines[] = $data;
                                }
                                $key++;
                            }
                            $res=$this->Rawlead_m->bulk_upload($lines);
                            if($res){
                                $this->session->set_flashdata('success', 'Lead Imported Successfully');
                                redirect('ven/lead');
                            }else{
                                $this->session->set_flashdata('error', 'Please select valid data');
                            }

                    }
                    $this->session->set_flashdata('error', 'Invalid File Extension');
            }
            else{
                $this->session->set_flashdata('error', 'File Not Exist');
            }
            redirect('ven/lead/lead_bulk_upload');
        }
        $this->template->load('vendor', 'lead/bulk_upload', $this->data);
    }


    /**
     * manage_state is used to perform all functionality related to state
     *
     * @param $operation string specify what type of operation is performed on state table
     * @param $id int specify unique id of state
     *
     * @return
     *      If $operation == 'getAll'
     *          return array[][] All state in the form of two dimensional array
     *      Else if $operation == 'getByCountryId'
     *          return string of state for specific country in option tag
     * @uses Return value in abbreviations EG. New York = NY
     */
    public function manage_state($operation = "", $id = "", $stateId = "") {
        $this->load->model('State_model');
        if ($operation == "getAll") {
            return $this->State_model->getAll();
        } else if ($operation == "getByCountryId") {
            $str = "<option value=''>Select State</option>";
            foreach ($this->State_model->getStateByCountryId($id) as $value) {
                $selected = '';
                if ($stateId != "" && $value['abbreviation'] == $stateId) {
                    $selected = 'selected="selected"';
                }
                $str .= "<option value='" . $value['abbreviation'] . "' " . $selected . " data-custom='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

    /*
     * manage_city is used to perform all functionality related to city
     *
     * @param $operation string specify what type of operation is performed on city table
     * @param $id int specify unique id of city
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All city in the form of two dimensional array
     *      Else if $operation == 'getByStateId'
     *          return string of state for specific city in option tag
     */

    public function manage_city($operation = "", $id = "", $cityId = "") {
        $this->load->model('City_model');
        if ($operation == "getAll") {
            return $this->City_model->getAll();
        } else if ($operation == "getByStateId") {
            $str = "";
            foreach ($this->City_model->getCityByStateId($id) as $value) {
                $selected = "";
                if ($value['id'] == $cityId) {
                    $selected = 'selected="selected"';
                }
                $str .= "<option value='" . $value['name'] . "' " . $selected . ">" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

}
