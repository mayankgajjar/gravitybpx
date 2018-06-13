<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Agency
 *
 * @author rashish
 */
class Agency extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/acampaigns_m', 'acampaigns_m');
        $this->load->model('vicidial/aphones_m', 'aphones_m');
    }

    public function index($param = '') {
        // For now display agency dashboard page
        $this->data['title'] = 'Agency | Dashboard';
        $this->template->load("agency", "profile_overview", $this->data);
    }

    /*
     * manage_agency is used to perform all functionality related to agency
     *
     * @param $operation string specify what type of operation is performed on agency
     * @param $id int specify unique id of agency
     *
     * return
     * 		If $operation == 'view'
     * 			load view_agencies page
     */

    public function manage_agency($operation = "view", $id = "") {
        $this->load->model('Agency_model');
        if ($operation == 'view') {
            $id = $this->session->userdata('agency')->id;
            $this->data['title'] = 'View Agencies';
            $this->data['agencies'] = $this->Agency_model->getAllAgencyInfo($id);
            $this->template->load("agency", "view_agencies", $this->data);
        } else if ($operation == 'agency_info') {
            $this->data['title'] = 'Agency Information';
            $id = decode_url($id);
            $this->data['states'] = $this->manage_state('getAll');
            $this->data['agency'] = $this->Agency_model->getAgencyInfo($id);
            $this->data['agency']->password = base64_decode($this->data['agency']->password);
            $this->template->load("agency", "agency_info", $this->data);
        }
    }

    /*
     * manage_agent is used to perform all functionality related to agent
     *
     * @param $operation string specify what type of operation is performed on agent
     * @param $id int specify unique id of agent
     *
     * return
     */

    public function manage_agent($operation = 'view', $id = '') {
        $this->load->model('Agent_model');
        if ($operation == 'view') {
            $id = $this->session->userdata('agency')->id;
            $this->data['title'] = 'View Agents';
            $this->data['agents'] = $this->Agent_model->getAllAgentInfo($id);
            $this->template->load("agency", "view_agents", $this->data);
        } else if ($operation == 'agent_info') {
            $this->data['title'] = 'Agent Information';
            $id = decode_url($id);
            $this->data['agent'] = $this->Agent_model->getAgentInfo($id);
            $this->data['agent']->password = base64_decode($this->data['agent']->password);
            $this->template->load("agency", "agent_info", $this->data);
        }
    }

    /*
     * profile is used to manage profile of agency
     */

    public function profile($operation = 'view') {
        $this->load->model('Agency_model');
        $this->data['flag'] = false;
        if ($operation == 'personal') {
            if ($this->input->post()) {
                $this->form_validation->set_rules('fname', 'First Name', 'required');
                $this->form_validation->set_rules('lname', 'Last Name', 'required');
                $this->form_validation->set_rules('phone', 'Phone Number', 'required');
                $this->form_validation->set_rules('address1', 'Address', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip Code', 'required');
                if ($this->form_validation->run()) {
                    $this->load->model('Agency_model');
                    $agency['name'] = $this->input->post('name');
                    $agency['fname'] = $this->input->post('fname');
                    $agency['lname'] = $this->input->post('lname');
                    $agency['phone_number'] = $this->input->post('phone');
                    $agency['fax_number'] = $this->input->post('fax');
                    $agency['address_line_1'] = $this->input->post('address1');
                    $agency['address_line_2'] = $this->input->post('address2');
                    $agency['city_id'] = $this->input->post('city');
                    $agency['zipcode'] = $this->input->post('zip');
                    $this->Agency_model->update($this->session->userdata('agency')->id, $agency);
                    $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                    redirect('Agency/profile');
                } else {
                    $this->data['flag'] = true;
                }
            }
        } else if ($operation == 'license') {
            if ($this->input->post()) {
                $this->form_validation->set_rules('service_phone', 'Service Phone Number', 'required');
                $this->form_validation->set_rules('service_email', 'Service Email', 'required');
                $this->form_validation->set_rules('license_number', 'Resident License Number', 'required');
                $this->form_validation->set_rules('resident_license_state', 'Resident License Number', 'required');
                if ($this->form_validation->run()) {
                    $this->load->model('Agency_model');
                    $agency_id = $this->session->userdata('agency')->id;
                    $agency['service_phone_number'] = $this->input->post('service_phone');
                    $agency['service_fax_number'] = $this->input->post('service_fax');
                    $agency['service_email'] = $this->input->post('service_email');
                    $agency['resident_license_number'] = $this->input->post('license_number');
                    $agency['resident_license_state_id'] = $this->input->post('resident_license_state');
                    $this->Agency_model->update($agency_id, $agency);

                    $states = array();
                    if (count($this->input->post('nonresident_license_state')) > 0) {
                        foreach ($this->input->post('nonresident_license_state') as $value) {
                            $state['agency_id'] = $agency_id;
                            $state['state_id'] = $value;
                            $states[] = $state;
                        }
                    }
                    $this->Agency_model->update_batch($states, $agency_id);
                    $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                    redirect('agency/profile');
                } else {
                    $this->data['flag'] = true;
                }
            }
        } else if ($operation == 'bank') {
            if ($this->input->post()) {
                $agency_id = $this->session->userdata('agency')->id;
                if ($this->input->post('card_name') != "") {
                    $this->form_validation->set_rules('card_name', 'Name on Credit Card', 'required');
                    $this->form_validation->set_rules('card_type', 'Card Type', 'required');
                    $this->form_validation->set_rules('card_number', 'Credit Card Number', 'required');
                    $this->form_validation->set_rules('expiration_date', 'Expiration Date', 'required');
                    $this->form_validation->set_rules('ccv_number', 'CCV Number', 'required');
                    if ($this->form_validation->run()) {
                        $agency['card_name'] = $this->input->post('card_name');
                        $agency['card_type'] = $this->input->post('card_type');
                        $agency['card_number'] = $this->input->post('card_number');
                        $agency['expiration_date'] = $this->input->post('expiration_date');
                        $agency['ccv_number'] = $this->input->post('ccv_number');
                    } else {
                        $this->data['flag'] = true;
                    }
                } else {
                    $this->form_validation->set_rules('bank_name', 'Full Name', 'required');
                    $this->form_validation->set_rules('bank_number', 'Bank Account Number', 'required');
                    $this->form_validation->set_rules('routing_number', 'Bank Routing Number', 'required');
                    $this->form_validation->set_rules('bank_address', 'Address', 'required');
                    $this->form_validation->set_rules('bank_country', 'Country', 'required');
                    $this->form_validation->set_rules('bank_state', 'State', 'required');
                    $this->form_validation->set_rules('bank_city', 'City', 'required');
                    $this->form_validation->set_rules('bank_zip', 'Zip Code', 'required');
                    if ($this->form_validation->run()) {
                        $agency['full_name'] = $this->input->post('bank_name');
                        $agency['bank_account_number'] = $this->input->post('bank_number');
                        $agency['bank_routing_number'] = $this->input->post('routing_number');
                        $agency['street_address'] = $this->input->post('bank_address');
                        $agency['bank_city_id'] = $this->input->post('bank_city');
                        $agency['bank_zip_code'] = $this->input->post('bank_zip');
                    } else {
                        $this->data['flag'] = true;
                    }
                }
                $this->load->model('Agency_model');
                $this->Agency_model->update($agency_id, $agency);
                $this->session->set_flashdata('msg', 'Profile is successfully updated.');
                redirect('agency/profile');
            }
        } else if ($operation == "upload") {
            $config['upload_path'] = 'uploads/agencies';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
                $agency['profile_image'] = $data['file_name'];
                $this->Agency_model->update($this->session->userdata('agency')->id, $agency);
                $this->load->model('User_model');
                $this->session->set_userdata('agency', $this->User_model->getAgencyFromUser_id($this->session->userdata('user')->id));
                $this->session->set_userdata('msg', 'Profile Image Updated');
            } else {
                $this->session->set_userdata('msg', 'Profile Image not Updated. Please try again');
            }
            redirect('Agency/profile');
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
        $this->data['title'] = 'Agency | Profile';
        $this->data['country'] = $this->Country_model->getAll();
        $this->data['state'] = $this->State_model->getStateByCountryId($this->session->userdata('agency')->cid);
        $this->data['city'] = $this->City_model->getCityByStateId($this->session->userdata('agency')->sid);
        $this->data['agency'] = $this->Agency_model->getAgencyInfo($this->session->userdata('agency')->id);
        $bank_city_name = isset($this->data['agency']->bank_city) ? $this->data['agency']->bank_city : '';
        $this->data['bank_state'] = $this->State_model->getStateIdByCityName($bank_city_name);
        $bank_state_id = $this->data['bank_state'][0]['state_id'];
        $this->data['bank_country'] = $this->Country_model->getCountryIdByStateId($bank_state_id);
        $this->data['bank_all_state'] = $this->State_model->getStateByCountryId($this->data['bank_country'][0]['id']);
        $this->data['bank_all_city'] = $this->City_model->getCityByStateId($this->data['bank_state'][0]['state_id']);
        $s = array();
        foreach ($this->data['agency']->non_resident_state as $state) {
            $s[] = $state['state_id'];
        }
        $this->data['agency']->non_resident_state = $s;
        $this->data['allState'] = $this->State_model->getAll();
        $this->template->load("agency", "profile", $this->data);
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

    public function agentedit($id = NULL) {
        $this->load->model('Agent_model');
        $this->load->library('form_validation');
        $this->data['country'] = $this->manage_country('getAll');
        $this->data['parentAgency'] = $this->session->agency;
        $this->data['states'] = $this->manage_state('getAll');

        if ($id) {
            $id = decode_url($id);
            $this->data['agent'] = $this->Agent_model->getAgentInfo($id);
            count($this->data['agent']) || $this->data['errors'][] = 'Agent could not be found.';
            $this->data['title'] = 'Edit ' . $this->data['agent']->fname . ' ' . $this->data['agent']->lname;
        } else {
            $newagent = new stdClass();
            $newagent->id = '';
            $newagent->fname = '';
            $newagent->fname = $this->input->post('fname') != '' ? $this->input->post('fname') : '';
            $newagent->mname = $this->input->post('mname') != '' ? $this->input->post('mname') : '';
            $newagent->lname = $this->input->post('lname') != '' ? $this->input->post('lname') : '';
            $newagent->parent_agency = $this->input->post('parent_agency') != '' ? $this->input->post('parent_agency') : '';
            $newagent->agent_type = $this->input->post('agent_type') != '' ? $this->input->post('agent_type') : '';
            $newagent->email_id = $this->input->post('email') != '' ? $this->input->post('email') : '';
            $newagent->phone_number = $this->input->post('phone') != '' ? $this->input->post('phone') : '';
//          $newagent->plivo_phone = $this->input->post('plivo_phone') != '' ? $this->input->post('plivo_phone') : '';
            $newagent->fax_number = $this->input->post('fax') != '' ? $this->input->post('fax') : '';
            $newagent->date_of_birth = $this->input->post('dob') != '' ? $this->input->post('dob') : '';
            $newagent->address_line_1 = $this->input->post('address1') != '' ? $this->input->post('address1') : '';
            $newagent->address_line_2 = $this->input->post('address2') != '' ? $this->input->post('address2') : '';
            $newagent->state_id = $this->input->post('state') != '' ? $this->input->post('state') : '';
            $newagent->country_id = $this->input->post('country') != '' ? $this->input->post('country') : '';
            $newagent->city_id = $this->input->post('city') != '' ? $this->input->post('city') : '';
            $newagent->zip_code = $this->input->post('zip') != '' ? $this->input->post('zip') : '';
            $newagent->national_producer_number = $this->input->post('npn') != '' ? $this->input->post('npn') : '';
            $newagent->resident_license_number = $this->input->post('license_number') != '' ? $this->input->post('license_number') : '';
            $newagent->resident_license_state_id = $this->input->post('resident_license_state') != '' ? $this->input->post('resident_license_state') : '';
            $newagent->non_resident_state = $this->input->post('nonresident_license_state') != '' ? $this->input->post('resident_license_state') : array();
            $this->data['agent'] = $newagent;
            $this->data['title'] = 'Add Agent';
        }

        $this->form_validation->set_rules('fname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('parent_agency', 'Agency', 'trim|required');
        $this->form_validation->set_rules('agent_type', 'Agent Type', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        if ($id) {
            $this->form_validation->set_rules('password', 'Password', 'trim');
            $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'trim|matches[rpassword]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'trim|required|matches[rpassword]');
        }
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        //$this->form_validation->set_rules('plivo_phone', 'Plivo Phone', 'trim|required');
        $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
        $this->form_validation->set_rules('address1', 'Address', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('zip', 'zipcode', 'trim|required');
        if ($this->input->post('agent_type') == 1) {
            $this->form_validation->set_rules('npn', 'National Producer Number', 'trim|required');
            $this->form_validation->set_rules('license_number', 'Resident License Number', 'trim|required');
            $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE) {

            /* Insert New Agent Code */
            $this->load->model('User_model');
            $agent_user['email_id'] = $this->input->post('email');
            $agent_user['password'] = base64_encode($this->input->post('password'));
            $agent_user['user_group_id'] = $this->User_model->getGroupidFromName('Agent');
            $agent_user['is_verified'] = 1;
            $agent_user['is_active'] = 1;
            $agent_user['created_at'] = date('Y-m-d H:i:s');
            $agent_user['modified_at'] = date('Y-m-d H:i:s');
            if ($id) {
                $userId = $this->data['agent']->user_id;
                $agentData = array(
                    'email_id' => $this->input->post('email'),
                    'modified_at' => date('Y-m-d H:i:s')
                );
                if ($this->input->post('password') != '') {
                    $agentData['password'] = base64_encode($this->input->post('password'));
                }
                $this->User_model->updateUser($agentData, $userId);
            } else {
                $uid = $this->User_model->insert($agent_user);
            }
            /* Insert Agent code */
            $agent['fname'] = $this->input->post('fname');
            $agent['mname'] = $this->input->post('mname');
            $agent['lname'] = $this->input->post('lname');
            $agent['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('dob')));
            $agent['phone_number'] = $this->input->post('phone');
            //$agent['plivo_phone'] = convertphoneformat($this->input->post('plivo_phone'));
            $agent['fax_number'] = $this->input->post('fax');
            $agent['address_line_1'] = $this->input->post('address1');
            $agent['address_line_2'] = $this->input->post('address2');
            $agent['city_id'] = $this->input->post('city');
            $agent['zip_code'] = $this->input->post('zip');
            if ($this->input->post('agent_type') == 1) {
                $agent['national_producer_number'] = $this->input->post('npn');
                $agent['resident_license_number'] = $this->input->post('license_number');
                $agent['resident_license_state_id'] = $this->input->post('resident_license_state');
            }
            $agent['agent_type'] = $this->input->post('agent_type');
            $agent['agency_id'] = $this->input->post('parent_agency');

            if ($id) {
                $this->Agent_model->update($id, $agent);
                $agent_id = $id;
                $viciData['email'] = $agentData['email_id'];
                $viciData['id'] = $id;
                $viciData['name'] = $agent['fname'] . ' ' . $agent['mname'] . ' ' . $agent['lname'];
                $viciData['user'] = 'agent' . $agent_id;
                if ($this->input->post('password') != '') {
                    $viciData['password'] = $this->input->post('password');
                }
                $vicidialUserId = $this->data['agent']->vicidial_user_id;
                if ($vicidialUserId < 1) {
                    $vicidialUserId = NULL;
                    $viciData['password'] = clean(base64_decode($this->data['agent']->password));
                }
                $this->vusers_m->addAgentFromCrm($viciData, $vicidialUserId);
            } else {
                $agent['user_id'] = $uid;
                $agent_id = $this->Agent_model->insert($agent);
                /* insert user in vicidial database */
                $this->vusers_m->addAgentFromCrm(array('user' => 'agent' . $agent_id, 'email' => $agent_user['email_id'], 'password' => clean(base64_decode($agent_user['password'])), 'name' => $agent['fname'] . ' ' . $agent['lname'], 'id' => $agent_id), NULL);
            }

            if ($this->input->post('agent_type') == 1 && $agent_id != false && count($this->input->post('nonresident_license_state')) > 0) {
                $agent_states = array();
                foreach ($this->input->post('nonresident_license_state') as $state) {
                    $agent_state = array();
                    $agent_state['agent_id'] = $agent_id;
                    $agent_state['state_id'] = $state;
                    $agent_states[] = $agent_state;
                }
                if ($id) {
                    $this->Agent_model->update_batch($agent_states, $agent_id);
                } else {
                    $this->Agent_model->insert_batch($agent_states);
                }
            }
            $this->session->set_flashdata('msg', 'Agent saved successfully.');
            // redirect('agency/manage_agent/view');
        }

        //$this->data['title'] = 'Add Agent';
        //$this->load->view('agency/add_agent',$this->data);
        $this->template->load("agency", "add_agent", $this->data);
    }

    public function deleteagent($id = "") {
        $this->load->model('Agent_model');
        if ($id) {
            $id = decode_url($id);
            $agent = $this->Agent_model->getAgentInfo($id);
            $vicidialId = $agent->vicidial_user_id;
            if ($this->Agent_model->delete($id)) {
                if ($vicidialId > 0) {
                    $this->vusers_m->delete($vicidialId);
                }
                $this->session->set_flashdata('msg', 'Agent deleted successfully.');
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->session->set_flashdata('msg', 'Unable to find agent.');
            echo '0';
        }
    }

    public function agencyedit($id = NULL) {
        $this->load->model('Agency_model');
        $this->load->model('City_model');
        $this->load->model('State_model');
        $this->load->model('Country_model');
        $this->load->library('form_validation');
        $this->data['country'] = $this->manage_country('getAll');
        $this->data['parentAgency'] = $this->session->agency;
        $this->data['states'] = $this->manage_state('getAll');

        if ($id) {
            $id = decode_url($id);
            $this->data['agency'] = $this->Agency_model->getAgencyInfo($id);
            count($this->data['agency']) || $this->data['errors'][] = 'Agency could not be found.';
            $this->data['title'] = 'Edit ' . $this->data['agency']->name;
        } else {
            $newagency = new stdClass();
            $newagency->id = '';
            $newagency->domain = '';
            $newagency->name = $this->input->post('agencyname') ? $this->input->post('agencyname') : '';
            $newagency->email_id = $this->input->post('email') ? $this->input->post('email') : '';
            $newagency->address_line_1 = $this->input->post('address1') ? $this->input->post('address1') : '';
            $newagency->address_line_2 = $this->input->post('address2') ? $this->input->post('address2') : '';
            $newagency->country_id = $this->input->post('country') ? $this->input->post('country') : '';
            $newagency->city_id = $this->input->post('city') ? $this->input->post('city') : '';
            $newagency->zipcode = $this->input->post('zip') ? $this->input->post('zip') : '';
            $newagency->fname = $this->input->post('fname') ? $this->input->post('fname') : '';
            $newagency->lname = $this->input->post('lname') ? $this->input->post('lname') : '';
            $newagency->phone_number = $this->input->post('phone') ? $this->input->post('phone') : '';
            $newagency->fax_number = $this->input->post('fax') ? $this->input->post('fax') : '';
            $newagency->service_phone_number = $this->input->post('service_phone') ? $this->input->post('service_phone') : '';
            $newagency->service_fax_number = $this->input->post('service_fax') ? $this->input->post('service_fax') : '';
            $newagency->service_email = $this->input->post('service_email') ? $this->input->post('service_email') : '';
            $newagency->resident_license_number = $this->input->post('license_number') ? $this->input->post('license_number') : '';
            $newagency->resident_license_state_id = $this->input->post('resident_license_state') ? $this->input->post('resident_license_state') : '';
            $newagency->payment = $this->input->post('agencyname') ? $this->input->post('agencyname') : '1';
            $newagency->bank_account_number = $this->input->post('bank_number') ? $this->input->post('bank_number') : '';
            $newagency->bank_routing_number = $this->input->post('routing_number') ? $this->input->post('routing_number') : '';
            $newagency->full_name = $this->input->post('bank_name') ? $this->input->post('bank_name') : '';
            $newagency->street_address = $this->input->post('bank_address') ? $this->input->post('agencyname') : '';
            $newagency->bank_city_id = $this->input->post('bank_city') ? $this->input->post('bank_city') : '';
            $newagency->bank_zip_code = $this->input->post('bank_zip') ? $this->input->post('bank_zip') : '';
            $newagency->card_name = $this->input->post('card_name') ? $this->input->post('card_name') : '';
            $newagency->card_type = $this->input->post('card_type') ? $this->input->post('card_type') : '';
            $newagency->card_number = $this->input->post('card_number') ? $this->input->post('card_number') : '';
            $newagency->expiration_date = $this->input->post('expiration_date') ? $this->input->post('expiration_date') : '';
            $newagency->ccv_number = $this->input->post('ccv_number') ? $this->input->post('ccv_number') : '';
            $newagency->parent_agency = $this->input->post('parent_agency') ? $this->input->post('parent_agency') : $this->data['parentAgency']->id;
            $newagency->profile_image = $this->input->post('profile') ? $this->input->post('profile') : '';
            $newagency->nonresident_license_state = $this->input->post('nonresident_license_state') ? $this->input->post('nonresident_license_state') : array();
            $newagency->user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
            $this->data['agency'] = $newagency;
            $this->data['title'] = 'Add Agency';
        }

        $this->form_validation->set_rules('agencyname', 'Agency Name', 'trim|required');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('address1', 'Address', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required');
        $this->form_validation->set_rules('service_phone', 'Service Phone Number', 'trim|required');
        $this->form_validation->set_rules('service_email', 'Service Email', 'trim|required');
        $this->form_validation->set_rules('license_number', 'Resident License Number', 'trim|required');
        $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'trim|required');
        $this->form_validation->set_rules('license_number', 'Resident License Number', 'trim|required');
        $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'trim|required');
        $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        if ($id) {
            $this->form_validation->set_rules('password', 'Password', 'trim');
            $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'trim|matches[rpassword]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('rpassword', 'Password Confirmation', 'trim|required|matches[rpassword]');
        }

        if ($this->input->post('payment') == '1') {
            $this->form_validation->set_rules('bank_name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('bank_number', 'Bank Account Number', 'trim|required');
            $this->form_validation->set_rules('routing_number', 'Bank Routing Number', 'trim|required');
            $this->form_validation->set_rules('bank_address', 'Bank Address', 'trim|required');
            $this->form_validation->set_rules('bank_country', 'Bank Country', 'trim|required');
            $this->form_validation->set_rules('bank_state', 'Bank State', 'trim|required');
            $this->form_validation->set_rules('bank_city', 'Bank City', 'trim|required');
            $this->form_validation->set_rules('bank_zip', 'Bank zipcode', 'trim|required');
        }

        if ($this->input->post('payment') == '2') {
            $this->form_validation->set_rules('card_name', 'Credit Card Name', 'trim|required');
            $this->form_validation->set_rules('card_type', 'Credit Card Type', 'trim|required');
            $this->form_validation->set_rules('card_number', 'Credit Card Number', 'trim|required');
            $this->form_validation->set_rules('expiration_date', 'Expiration Date', 'trim|required');
            $this->form_validation->set_rules('ccv_number', 'CCV Number', 'trim|required');
        }

        if ($this->form_validation->run() == TRUE) {

            /* Indert New user */
            $this->load->model('User_model');
            if ($id) {
                $uid = $this->data['parentAgency']->user_id;
                $agencyData = array(
                    'email_id' => $this->input->post('email'),
                    'modified_at' => date('Y-m-d H:i:s')
                );
                if ($this->input->post('password') != '') {
                    $agencyData['password'] = base64_encode($this->input->post('password'));
                }
                $this->User_model->updateUser($agencyData, $uid);
            } else {
                $agency_user['email_id'] = $this->input->post('email');
                $agency_user['password'] = base64_encode($this->input->post('password'));
                $agency_user['user_group_id'] = $this->User_model->getGroupidFromName('Agency');
                $agency_user['is_verified'] = 1;
                $agency_user['is_active'] = 1;
                $agency_user['created_at'] = date('Y-m-d H:i:s');
                $agency_user['modified_at'] = date('Y-m-d H:i:s');
                $uid = $this->User_model->insert($agency_user);
            }
            /* Insert agency */
            $agency['name'] = $this->input->post('agencyname');
            $agency['domain'] = $this->input->post('domain');
            $agency['address_line_1'] = $this->input->post('address1');
            $agency['address_line_2'] = $this->input->post('address2');
            $agency['city_id'] = $this->input->post('city');
            $agency['zipcode'] = $this->input->post('zip');
            $agency['fname'] = $this->input->post('fname');
            $agency['mname'] = $this->input->post('mname');
            $agency['lname'] = $this->input->post('lname');
            $agency['phone_number'] = $this->input->post('phone');
            $agency['fax_number'] = $this->input->post('fax');
            $agency['service_phone_number'] = $this->input->post('service_phone');
            $agency['service_fax_number'] = $this->input->post('service_fax');
            $agency['service_email'] = $this->input->post('service_email');
            $agency['resident_license_number'] = $this->input->post('license_number');
            $agency['resident_license_state_id'] = $this->input->post('resident_license_state');
            if (count($this->input->post('nonresident_license_state')) > 0) {
                $agency['non_resident_license_state_ids'] = implode(',', $this->input->post('nonresident_license_state'));
            } else {
                $agency['non_resident_license_state_ids'] = '';
            }

            if ($this->input->post('payment') == '1') {
                $agency['bank_account_number'] = $this->input->post('bank_number');
                $agency['bank_routing_number'] = $this->input->post('routing_number');
                $agency['full_name'] = $this->input->post('bank_name');
                $agency['street_address'] = $this->input->post('bank_address');
                $agency['bank_city_id'] = $this->input->post('bank_city');
                $agency['bank_zip_code'] = $this->input->post('bank_zip');
            } else {
                $agency['card_name'] = $this->input->post('card_name');
                $agency['card_type'] = $this->input->post('card_type');
                $agency['card_number'] = $this->input->post('card_number');
                $agency['expiration_date'] = $this->input->post('expiration_date');
                $agency['ccv_number'] = $this->input->post('ccv_number');
            }
            // $agency['nonresident_license_state'] = $this->input->post('nonresident_license_state');
            $agency['parent_agency'] = $this->input->post('parent_agency');
            $agency['user_id'] = $uid;
            $agency['profile_image'] = $this->input->post('profile');
            if ($id) {
                $agency_id = $this->Agency_model->update($id, $agency);
                $agency_id = $id;
                /* update vicidial user data start */
                $vicidialUserUd = $this->data['agency']->vicidial_user_id;
                $userData = array('email' => $agencyData['email_id'], 'id' => $agency_id, 'name' => $agency['name']);
                if ($this->input->post('password') != '') {
                    $userData['password'] = clean($this->input->post('password'));
                }
                $this->vusers_m->addAgencyFromCrm($userData, $vicidialUserUd);
                /* update vicidial user data end */
            } else {
                $agency_id = $this->Agency_model->insert($agency);
                /* insert new  user in vicidial user */
                $explode = explode('@', $agency_user['email_id']);
                $vuserId = strtolower($explode[0]) . $agency_id;
                $this->vusers_m->addAgencyFromCrm(array('user' => $vuserId, 'email' => $agency_user['email_id'], 'name' => $agency['name'], 'password' => clean(base64_decode($agency_user['password'])), 'id' => $agency_id), NULL);
            }

            /* if($agency_id != false && count($this->input->post('nonresident_license_state')) > 0)
              {
              $agency_states = array();
              foreach($this->input->post('nonresident_license_state') as $state)
              {
              $agency_state = array();
              $agency_state['agency_id'] = $agency_id;
              $agency_state['state_id'] = $state;
              $agency_states[] = $agency_state;
              }
              if($id){
              $this->Agency_model->update_batch($agency_states,$id);
              }else{
              $this->Agency_model->insert_batch($agency_states);
              }

              } */
            $this->session->set_flashdata('msg', 'Agency saved successfully.');
            redirect('agency/agencyindex');
            /* */
        }

        $this->data['title'] = 'Add Agency';
        $this->template->load("agency", "add_agency", $this->data);
    }

    public function deleteagency($id = "") {
        $this->load->model('Agency_model');
        if ($id) {
            $id = decode_url($id);

            $agency = $this->Agency_model->getAgencyInfo($id);
            $acampaigns = $this->acampaigns_m->get_by(array('agency_id' => $id));
            $vicidialId = $agency->vicidial_user_id;
            if ($this->Agency_model->delete($id)) {
                if ($vicidialId > 0) {
                    $this->vusers_m->delete($vicidialId);
                }
                if (count($acampaigns) > 0) {
                    foreach ($acampaigns as $acampaign) {
                        $data = array('agency_id' => 0);
                        $this->acampaigns_m->save($data, $acampaign->id);
                    }
                }
                $this->session->set_flashdata('msg', 'Agency deleted successfully.');
                echo '1';
            } else {
                echo '0';
            }
        } else {
            $this->session->set_flashdata('msg', 'Unable to find agency.');
            echo '0';
        }
    }

    public function check_email() {
        $this->load->model('User_model');
        if (isset($_POST['email_id']) && $_POST['email_id'] != "") {
            $id = $_POST['email_id'];
            $return_email = $this->User_model->check_email($id);
            if (isset($return_email) && $return_email != "") {
                echo "yes";
                return false;
            } else {
                echo "no";
            }
            die;
        }
    }

    public function agencyindex() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['listtitle'] = 'Agency Listing';
        $this->data['title'] = 'Agency Listing';
        $this->template->load('agency', "list", $this->data);
    }

    public function agencyindexjson() {
        $this->load->model('agencys');
        $aColumns = array('main.id', 'main.name', 'main.service_email', 'main.fname', 'main.phone_number', 'main.domain', 'sub.name');
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
        if ($_GET['sSearch'] != "") {
            $sWhere .= " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->agencys->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->agencys->queryForAgency($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->agencys->queryForAgency());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 0;

        if ($segement) :
            $count = $_GET['iDisplayStart'];
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                $count++;
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'main.id') {
                        $row[] = $count;
                    } else if ($aColumns[$i] == 'sub.name') {
                        if ($aRow['sub.name'] == '') {
                            $row[] = 'No Parent';
                        } else {
                            $row[] = $aRow[$aColumns[$i]];
                        }
                    } else {
                        $row[] = $aRow[$aColumns[$i]];
                    }
                }
                $id = $aRow['main.vicidial_user_id'];
                $str = '';
                if ($id > 0) {
                    $user = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
                    if ($user) {
                        $str .= '<a target="_blank" href="' . site_url('dialer/ausers/edit/' . encode_url($id)) . '">Dialer User</a>&nbsp;&nbsp;';
                        $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);
                        if (!$phone) {
                            $str .= '<a href="' . site_url('dialer/aphones/createphone/' . $id) . '">Create Phone</a>&nbsp;&nbsp;';
                        }
                    } else {
                        $str .= '<a href="' . site_url('dialer/ausers/createagency/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                    }
                } else {
                    $str .= '<a href="' . site_url('dialer/ausers/createagency/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                }
                $row[] = '<a class="info" title="Information" id="' . encode_url($aRow['main.id']) . '" href="' . site_url('agency/manage_agency/agency_info/' . encode_url($aRow['main.id'])) . '""><span class="fa fa-info"></span></a>&nbsp;&nbsp;<a href="' . site_url('agency/agencyedit/' . encode_url($aRow['main.id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('agency/deleteagency/' . encode_url($aRow['main.id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i></a>&nbsp;&nbsp;' . $str;

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function agentindex() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['listtitle'] = 'Agent Listing';
        $this->data['title'] = 'Agent Listing';
        $this->template->load('agency', "agent/list", $this->data);
    }

    public function agentindexjson() {
        $this->load->model('agents');
        $aColumns = array('main.id', 'main.fname', 'main.lname', 'users.email_id', 'main.phone_number', 'main.agent_type', 'agency.name');
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
        if ($_GET['sSearch'] != "") {
            $sWhere .= " WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->agents->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->agents->queryForAgency($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->agents->queryForAgency());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 0;

        if ($segement) :
            $count = $_GET['iDisplayStart'];
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                $count++;
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'main.id') {
                        $row[] = $count;
                    } else if ($aColumns[$i] == 'sub.name') {
                        if ($aRow['sub.name'] == '') {
                            $row[] = 'No Parent';
                        } else {
                            $row[] = $aRow[$aColumns[$i]];
                        }
                    } else {
                        $row[] = $aRow[$aColumns[$i]];
                    }
                }
                $id = $aRow['main.vicidial_user_id'];
                $str = '';
                if ($id > 0) {
                    $user = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
                    if ($user) {
                        $str .= '<a target="_blank" href="' . site_url('dialer/ausers/edit/' . encode_url($id)) . '">Dialer User</a>&nbsp;&nbsp;';
                        $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);
                        if (!$phone) {
                            $str .= '<a href="' . site_url('dialer/aphones/createphone/' . $id) . '">Create Phone</a>&nbsp;&nbsp;';
                        }
                    } else {
                        $str .= '<a href="' . site_url('dialer/ausers/createagent/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                    }
                } else {
                    $str .= '<a href="' . site_url('dialer/ausers/createagent/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                }

                $row[] = '<a class="info" title="Information" id="' . $aRow['main.id'] . '" href="' . site_url('agency/manage_agent/agent_info/' . encode_url($aRow['main.id'])) . '""><span class="fa fa-info"></span></a>&nbsp;&nbsp;<a href="' . site_url('agency/agentedit/' . encode_url($aRow['main.id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('agency/deleteagent/' . encode_url($aRow['main.id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i></a>&nbsp;&nbsp;' . $str;

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
     * @uses SENDING TASK NOTICATIONS
     */
    public function check_task_notification() {
        $curdate = date("Y-m-d");
        $curtime = date("H:i");
        $this->db->where('task_date', $curdate);
        $this->db->where('task_start_time', $curtime);
        $this->db->where('user_id', $this->session->userdata('agency')->user_id);
        $query = $this->db->get('tasks');
        $result = $query->result_array();
        echo json_encode($result);
    }

}
