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
            if ($this->session->userdata("user")->group_name != 'Vendor') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Vendor_m');
//        $this->load->model('Country_model');
    }

    public function index($param = '') {
        $this->data['title'] = 'Agent | Vendor List';
        $this->template->load("vendor", "profile_overview", $this->data);
    }

    /*
     * profile is used to manage profile of agency
     */

    public function profile($operation = 'view') {
        $this->load->model('Vendor_m');
        $this->data['flag'] = false;
        if ($operation == 'personal') {
            if ($this->input->post()) {
                $this->form_validation->set_rules('fname', 'First Name', 'required');
                $this->form_validation->set_rules('lname', 'Last Name', 'required');
                $this->form_validation->set_rules('phone', 'Phone Number', 'required');
                $this->form_validation->set_rules('address_line_1', 'Address', 'required');
                $this->form_validation->set_rules('date_of_birth', 'Date Of Birth', 'required');
                $this->form_validation->set_rules('country_id', 'Country', 'required');
                $this->form_validation->set_rules('state_id', 'State', 'required');
                $this->form_validation->set_rules('city_id', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip Code', 'required');
                if ($this->form_validation->run()) {
                    $this->load->model('Vendor_m');
                    $vendor['fname'] = $this->input->post('fname');
                    $vendor['mname'] = $this->input->post('mname');
                    $vendor['lname'] = $this->input->post('lname');
                    $vendor['phone_number'] = $this->input->post('phone');
                    $vendor['date_of_birth'] = date("Y-m-d", strtotime($this->input->post('date_of_birth')));
                    $vendor['fax_number'] = $this->input->post('fax');
                    $vendor['address_line_1'] = $this->input->post('address_line_1');
                    $vendor['address_line_2'] = $this->input->post('address_line_2');
                    $vendor['country_id'] = $this->input->post('country_id');
                    $vendor['state_id'] = $this->input->post('state_id');
                    $vendor['city_id'] = $this->input->post('city_id');
                    $vendor['zip_code'] = $this->input->post('zip');
                    $this->Vendor_m->save($vendor, $this->session->userdata('vendor')->id);
                    $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                    redirect('vendor/profile');
                } else {
                    $this->data['flag'] = true;
                }
            }
        } else if ($operation == 'change') {
            $old = base64_encode($this->input->post('old'));
            $new = base64_encode($this->input->post('new'));
            $this->load->model('User_model');
            if ($this->User_model->chkUser($this->session->userdata('user')->email_id, $old)) {
                if ($old == $new) {
                    echo '2';
                } else {
                    $this->User_model->changePassword($this->session->userdata('user')->id, $new);
                    echo '1';
                }
            } else {
                echo '0';
            }
            return;
        }

        $this->load->model('Country_model');
        $this->load->model('State_model');
        $this->load->model('City_model');
        $this->data['title'] = 'Vendor | Profile';
        $this->data['country'] = $this->Country_model->getAll();
        $this->data['state'] = $this->State_model->getStateByCountryId($this->session->userdata('vendor')->country_id);
        $this->data['city'] = $this->City_model->getCityByStateId($this->session->userdata('vendor')->state_id);
        $table = 'vendors v';
        $relation = array(
            "fields" => 'v.*,u.email_id',
            "JOIN" => array(
                array(
                    "table" => 'users u',
                    "condition" => 'v.user_id = u.id ',
                    "type" => 'LEFT'
                ),
            ),
            "conditions" => 'v.id=' . $this->session->userdata('vendor')->id,
        );
        $vendor = $this->Vendor_m->get_relation($table, $relation);
        $this->data['vendor'] = $vendor[0];
        $this->template->load("vendor", "profile", $this->data);
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
            $str = "<option value='0'>Select State</option>";
            foreach ($this->State_model->getStateByCountryId($id) as $value) {
                $selected = '';
                if ($stateId != "" && $value['id'] == $stateId) {
                    $selected = 'selected="selected"';
                }
                $str .= "<option value='" . $value['id'] . "' " . $selected . ">" . $value['name'] . "</option>";
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
                $str .= "<option value='" . $value['id'] . "' " . $selected . ">" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

}
