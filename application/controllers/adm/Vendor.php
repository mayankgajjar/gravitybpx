<?php

/**
 * Description of Vendor
 *
 * @author
 */
class Vendor extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Vendor_m');
        $this->load->model('Country_model');
        $this->load->model('User_model');
    }

    public function index($param = '') {
        $this->data['title'] = 'Admin | Vendor List';
        $this->data['pagetitle'] = 'Vendor';
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Vendor';
        $this->data['datatable'] = TRUE;
        $this->data['listtitle'] = 'Vendor Listing';
        $this->template->load("admin", "vendor/list_vendor", $this->data);
    }

    public function vendorjson() {
        $table = 'vendors v';
        $aColumns = array('v.id', 'v.fname', 'v.lname', 'u.email_id', 'v.phone_number');
        $bColumns = array('id', 'vendor_name', 'email_id', 'phone_number');
        $relation = array(
            "fields" => 'v.id,CONCAT(v.fname," ",v.lname) as vendor_name,u.email_id,v.phone_number',
            "JOIN" => array(
                array(
                    "table" => 'users u',
                    "condition" => 'v.user_id = u.id ',
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

        $aFilterResult = $this->Vendor_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }

        $rResult = $this->Vendor_m->get_relation($table, $relation);

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
                    if ($bColumns[$i] == 'id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['id']) . '"/>';
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
                $row[] = '<a href="' . site_url('adm/vendor/view/' . encode_url($aRow['id'])) . '" title="View"><i class="fa fa-info" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="' . site_url('adm/vendor/edit/' . encode_url($aRow['id'])) . '" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('adm/vendor/delete/' . encode_url($aRow['id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';

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
        $this->data['title'] = 'Admin | Vendor';
        $this->data['pagetitle'] = 'Manage Vendor';
        $this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Vendor Operation";
        $this->data['label'] = 'Vendor';
        /* set variable to include javascript */
        $this->data['country'] = $this->Country_model->getAll();

        if ($id) {
            $id = decode_url($id);
            $this->data['type'] = 'edit';
            $this->data['vendor'] = $this->Vendor_m->get_by(array('id' => $id), TRUE);
            count($this->data['vendor']) || $this->data['errors'][] = "Unable to find vendor.";
            $this->data['listtitle'] = "Edit Vendor";
        } else {
            $this->data['type'] = 'add';
            $this->data['listtitle'] = "Add A New Vendor";
            $this->data['vendor'] = $this->Vendor_m->get_new();
        }
        $rules = $this->Vendor_m->rules_admin;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === true) {
            if ($this->input->post('user_id') == "") {
                $vendor_user['email_id'] = $this->input->post('email_id');
                $vendor_user['password'] = base64_encode($this->input->post('password'));
                $vendor_user['user_group_id'] = $this->User_model->getGroupidFromName('Vendor');
                $vendor_user['is_verified'] = 1;
                $vendor_user['is_active'] = 1;
                $vendor_user['created_at'] = date('Y-m-d H:i:s');
                $vendor_user['modified_at'] = date('Y-m-d H:i:s');
                //Insert Agency in users table
                $uid = $this->User_model->insert($vendor_user);
            } else {
                $uid = $this->input->post('user_id');
            }
            $data = $this->Vendor_m->array_from_post(array(
                'fname', 'mname', 'lname', 'phone_number', 'fax_number', 'address_line_1', 'address_line_2', 'city_id', 'state_id', 'country_id', 'zip_code'
            ));
            $data['user_id'] = $uid;
            $data['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('date_of_birth')));
            $res = $this->Vendor_m->save($data, $id);
            if ($res) {
                $this->session->set_flashdata('success', 'Vendor successfully saved.');
            } else {
                $this->session->set_flashdata('error', 'Error into save vendor.');
            }
            redirect('adm/vendor');
        }
        // Load the view
        $this->template->load('admin', 'vendor/edit_vendor', $this->data);
    }

    public function view($id) {
        $this->data['title'] = 'Admin | Vendor';
        $this->data['pagetitle'] = 'View Vendor';
        $this->data['meta_title'] = "Vendor View";
        $this->data['label'] = 'Vendor';

        if ($id) {
            $id = decode_url($id);
            $table = 'vendors v';
            $relation = array(
                "fields" => 'v.*,u.email_id,co.name as country_name,s.name as state_name,c.name as city_name',
                "JOIN" => array(
                    array(
                        "table" => 'users u',
                        "condition" => 'v.user_id = u.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'country co',
                        "condition" => 'v.country_id = co.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'state s',
                        "condition" => 'v.state_id = s.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'city c',
                        "condition" => 'v.city_id = c.id',
                        "type" => 'LEFT'
                    ),
                ),
                "conditions" => 'v.id = ' . $id,
            );

            $vendor = $this->Vendor_m->get_relation($table, $relation);
            $this->data['vendor'] = $vendor[0];
            count($this->data['vendor']) || $this->data['errors'][] = "Unable to find vendor.";
            $this->data['listtitle'] = "View Vendor";
            $this->template->load('admin', 'vendor/view_vendor', $this->data);
        }
    }

    public function delete($id) {
        if ($id) {
            $id = decode_url($id);
            $vendor_data = $this->Vendor_m->get($id, TRUE);
            $res = $this->User_model->delete_user($vendor_data->user_id);
            if ($res) {
                $this->Vendor_m->delete($id);  // Delete vendor data
                $this->session->set_flashdata('success', 'Vendor deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Error into delete vendor');
            }
        } else {
            $this->session->set_flashdata('error', 'Vendor doesn\'t exist.');
        }
        redirect('adm/vendor');
    }

    public function massaction() {
        $ids = $this->input->post('id');
        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Vendor id selected.');
            redirect('adm/vendor');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $vendor_data = $this->Vendor_m->get($id, TRUE);
                    $res = $this->User_model->delete_user($vendor_data->user_id);
                    if ($res) {
                        $this->Vendor_m->delete($id);
                    }
                }
                $this->session->set_flashdata('success', 'Vendor ids deleted successfully.');
                break;
        }
        redirect('adm/vendor');
    }

    /*
     * manage_state is used to perform all functionality related to state
     *
     * @param $operation string specify what type of operation is performed on state table
     * @param $id int specify unique id of state
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All state in the form of two dimensional array
     *      Else if $operation == 'getByCountryId'
     *          return string of state for specific country in option tag
     */

    public function manage_state($operation = "", $id = "", $stateId = "") {
        $this->load->model('State_model');
        if ($operation == "getAll") {
            return $this->State_model->getAll();
        } else if ($operation == "getByCountryId") {
            $str = "<option value=''>Select State</option>";
            foreach ($this->State_model->getStateByCountryId($id) as $value) {
                $selected = '';
                if ($stateId != "" && $stateId == $value['id']) {
                    $selected = 'selected="selected"';
                }
                $str .= "<option value='" . $value['id'] . "' " . $selected . " >" . $value['name'] . "</option>";
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
                $selected = '';
                if ($cityId != "" && $cityId == $value['id']) {
                    $selected = 'selected="selected"';
                }
                $str .= "<option value='" . $value['id'] . "' " . $selected . ">" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

    /**
     * @uses For check user email id is existed in table or not
     * @param type $id
     *
     */
    function check_user_exists($id = 0) {
        if (array_key_exists('email_id', $_POST)) {
            if ($this->Vendor_m->CheckExist($this->input->post('email_id'), $id) > 0)
                echo json_encode(FALSE);
            else
                echo json_encode(TRUE);
        }
    }

}
