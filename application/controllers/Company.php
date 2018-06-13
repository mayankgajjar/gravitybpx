<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Admin
 *
 * @author Meet
 */
class Company extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {

        }
    }

    public function index() {
        $this->data['title'] = 'Dashboard';
        $this->template->load("admin", "dashboard", $this->data);
    }

    /*
     * manage_country is used to perform all functionality related to country
     *
     * @param $operation string specify what type of operation is performed on country table
     * @param $id int specify unique id of country
     *
     * return
     *      If $operation == 'getAll'
     *          return array[][] All country in the form of two dimensional array
     */

    public function manage_country($operation = "", $id = "") {
        $this->load->model('Country_model');
        if ($operation == "getAll") {
            return $this->Country_model->getAll();
        }
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

    /*
     * manage_company is used to perform all functionality related to company
     *
     * @param $operation string specify what type of operation is performed on comapny
     * @param $id int specify unique id of company
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into company
     */

    public function manage_company($operation = "view", $id = "") {
        $this->load->model('Company_model');
        if ($operation == "add") {
            $this->data['validation'] = TRUE;
            $this->data['fileinput'] = TRUE;
            if ($this->input->post()) {
                try {
                    $company['company_name'] = $this->input->post('company_name');
                    //$company['company_logo'] = $this->input->post('company_logo');

                    if ($this->input->post('id') == "") {
                        $company['created_at'] = date('Y-m-d H:i:s');
                        $company['modified_at'] = date('Y-m-d H:i:s');
                    } else {
                        $company['modified_at'] = date('Y-m-d H:i:s');
                    }


                    $config['upload_path'] = 'uploads/company_logo';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('company_logo')) {
                        $data = $this->upload->data();

                        $company['company_logo'] = $data['file_name'];
                    }

                    if ($this->input->post('id') != "") {
                        $id = $this->input->post('id');
                        $this->Company_model->update($company, $id);
                        $this->session->set_flashdata('msg', 'Company is successfully updated.');
                    } else {
                        $this->Company_model->insert($company);
                        $this->session->set_flashdata('msg', 'Company is successfully inserted.');
                    }
                    redirect('admin/manage_company/view');
                } catch (Exception $e) {

                }
            } else {
                $this->data['title'] = 'Add Comapny';
                $this->template->load("admin", "company/add_company", $this->data);
            }
        } else if ($operation == 'delete') {
            if ($this->Company_model->delete($id)) {
                $this->data['title'] = 'View Company';
                $this->data['company'] = $this->Company_model->getAll();
                $this->session->set_flashdata('msg', 'Company is successfully deleted.');
                $this->template->load("admin", "company/view_company", $this->data);
            } else {
                return false;
            }
        } else if ($operation == 'view') {
            $this->data['datatable'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['title'] = 'View Company';
            $this->data['company'] = $this->Company_model->getAll();
            $this->template->load("admin", "company/view_company", $this->data);
        } else if ($operation == 'edit') {
            $this->data['validation'] = TRUE;
            $this->data['fileinput'] = TRUE;
            $this->data['title'] = 'Edit Products';
            $this->data['company'] = $this->Company_model->getById($id);
            $this->template->load("admin", "company/add_company", $this->data);
        } else if ($operation == 'filter_option') {
            $filter_option_array = array('text' => "Company");
            $filter_option_array['children'] = $this->Company_model->viewAllCompanyObject();
            echo json_encode(array($filter_option_array));
            die;
        }
    }

}
