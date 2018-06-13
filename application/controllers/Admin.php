<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Admin
 *
 * @author Meet
 */
class Admin extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/aphones_m', 'aphones_m');
        $this->load->model('vicidial/acampaigns_m', 'acampaigns_m');
    }

    public function index() {
        $this->data['title'] = 'Dashboard';
        $this->template->load("admin", "dashboard", $this->data);
    }

    /*
     * manage_agency is used to perform all functionality related to agency
     *
     * @param $operation string specify what type of operation is performed on agency
     * @param $id int specify unique id of agency
     *
     * return
     * 		If $operation == 'add'
     * 			If request is post
     * 				Insert into users, agencies and agency_
     */

    public function manage_agency($operation = "view", $id = "") {
        $this->load->model('Agency_model');
        $this->load->model('User_model');


        if ($operation == "add") {
            if ($this->input->post()) {

                //Insert Agency in users table
                $this->form_validation->set_rules('agencyname', 'Agency Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('password', 'Password', 'required|matches[rpassword]|base64_encode');
                $this->form_validation->set_rules('rpassword', 'Confirm Password', 'required');
                $this->form_validation->set_rules('fname', 'First Name', 'required');
                $this->form_validation->set_rules('lname', 'Last Name', 'required');
                $this->form_validation->set_rules('phone', 'Phone Number', 'required');
                $this->form_validation->set_rules('address1', 'Address', 'required');
                $this->form_validation->set_rules('country', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip Code', 'required');
                $this->form_validation->set_rules('service_phone', 'Service Phone Number', 'required');
                $this->form_validation->set_rules('service_email', 'Service Email', 'required');
                $this->form_validation->set_rules('license_number', 'Resident License Number', 'required');
                $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'required');
                $this->form_validation->set_rules('payment', 'Payment Option', 'required');
                if ($this->input->post('payment') == '1') {
                    $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
                    $this->form_validation->set_rules('bank_address', 'Bank Address', 'required');
                    $this->form_validation->set_rules('bank_country', 'Bank Country', 'required');
                    $this->form_validation->set_rules('bank_state', 'Bank State', 'required');
                    $this->form_validation->set_rules('bank_city', 'Bank City', 'required');
                    $this->form_validation->set_rules('bank_zip', 'Bank Zip Code', 'required');
                    $this->form_validation->set_rules('routing_number', 'Bank Routing Number', 'required');
                    $this->form_validation->set_rules('bank_number', 'Bank Account Number', 'required');
                } else {
                    $this->form_validation->set_rules('card_name', 'Name on Credit Card', 'required');
                    $this->form_validation->set_rules('card_type', 'Card Type', 'required');
                    $this->form_validation->set_rules('card_number', 'Credit Card Number', 'required');
                    $this->form_validation->set_rules('expiration_date', 'Expiration Date', 'required');
                    $this->form_validation->set_rules('ccv_number', 'CVV Number', 'required');
                }
                /* var_dump($this->form_validation->run());
                  var_dump(validation_errors());
                  die; */
                if ($this->form_validation->run() == TRUE) {
                    $agency_user['email_id'] = $this->input->post('email');
                    $agency_user['password'] = base64_encode($this->input->post('password'));
                    $agency_user['user_group_id'] = $this->User_model->getGroupidFromName('Agency');
                    $agency_user['is_verified'] = 1;
                    $agency_user['is_active'] = 1;
                    $agency_user['created_at'] = date('Y-m-d H:i:s');
                    $agency_user['modified_at'] = date('Y-m-d H:i:s');

                    $agency['name'] = $this->input->post('agencyname');
                    $agency['domain'] = $this->input->post('domain');
                    $agency['profile_image'] = $this->input->post('profile');
                    $agency['parent_agency'] = $this->input->post('parent_agency');
                    $agency['fname'] = $this->input->post('fname');
                    $agency['mname'] = $this->input->post('mname');
                    $agency['lname'] = $this->input->post('lname');
                    $agency['phone_number'] = $this->input->post('phone');
                    $agency['fax_number'] = $this->input->post('fax');
                    $agency['address_line_1'] = $this->input->post('address1');
                    $agency['address_line_2'] = $this->input->post('address2');
                    $agency['city_id'] = $this->input->post('city');
                    $agency['zipcode'] = $this->input->post('zip');
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
                        $agency['full_name'] = $this->input->post('bank_name');
                        $agency['street_address'] = $this->input->post('bank_address');
                        $agency['bank_city_id'] = $this->input->post('bank_city');
                        $agency['bank_zip_code'] = $this->input->post('bank_zip');
                        $agency['bank_routing_number'] = $this->input->post('routing_number');
                        $agency['bank_account_number'] = $this->input->post('bank_number');
                    } else {
                        $agency['card_name'] = $this->input->post('card_name');
                        $agency['card_type'] = $this->input->post('card_type');
                        $agency['card_number'] = $this->input->post('card_number');
                        $agency['expiration_date'] = $this->input->post('expiration_date');
                        $agency['ccv_number'] = $this->input->post('ccv_number');
                    }
                    $agency['parent_agency'] = $this->input->post('parent_agency');
                    $this->db->trans_begin();
                    //Insert Agency in users table
                    $uid = $this->User_model->insert($agency_user);

                    $agency['user_id'] = $uid;
                    if ($uid != false) {
                        //Insert Agency into agencies table
                        $agency_id = $this->Agency_model->insert($agency);

                        $this->vusers_m->addAgencyFromCrm(array('user' => $agency['domain'], 'email' => $agency_user['email_id'], 'name' => $agency['name'], 'password' => clean(base64_decode($agency_user['password'])), 'id' => $agency_id), NULL);
                    }

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->data['title'] = 'Add Agency';
                        $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                        $this->session->set_flashdata('error_server_register_agency', validation_errors());
                        $this->data['country'] = $this->manage_country('getAll');
                        $this->data['agency'] = $this->Agency_model->getAll();
                        $this->data['states'] = $this->manage_state('getAll');
                        $this->template->load("admin", "agency/add_agency", $this->data);
                    } else {
                        $this->db->trans_commit();
                        $user = $this->User_model->getUser($this->input->post('email'), base64_encode($this->input->post('password')));
                        if ($user->is_verified && $user->is_active) {
                            if ($user->group_name == 'Agency') {
                                //$this->session->set_userdata("user", $user);
                                //$this->session->set_userdata('agency', $this->User_model->getAgencyFromUser_id($user->id));
                                $this->session->set_flashdata('success', 'Agency is successfully inserted.');
                                $this->load->model('Email_model');
                                $subject = "New Agency Register";
                                $client_email = $this->input->post('email');
                                $admin_email = get_admin_email();
                                $message = "Thank you for register agency";
                                $this->Email_model->mail_send($subject, $client_email, $message);
                                $this->Email_model->mail_send($subject, $admin_email, $message);
                                redirect('admin/agencyindex');
                            } else {
                                redirect('admin/agencyindex');
                            }
                        }
                    }
                } else {
                    $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                    $this->data['title'] = 'Add Agency';
                    $this->session->set_flashdata('error_server_register_agency', validation_errors());
                    $this->data['country'] = $this->manage_country('getAll');
                    $this->data['agency'] = $this->Agency_model->getAll();
                    $this->data['states'] = $this->manage_state('getAll');
                    $this->template->load("admin", "agency/add_agency", $this->data);
                }
            } else {
                $this->data['title'] = 'Add Agency';
                $this->data['country'] = $this->manage_country('getAll');
                $this->data['agency'] = $this->Agency_model->getAll();
                $this->data['states'] = $this->manage_state('getAll');
                // $this->template->load("admin","temp",$this->data);
                $this->template->load("admin", "agency/add_agency", $this->data);
            }
        } else if ($operation == 'delete') {
            $agency = $this->Agency_model->getAgencyInfo($id);
            $vicidialId = $agency->vicidial_user_id;
            $acampaigns = $this->acampaigns_m->get_by(array('agency_id' => $id));
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
                echo '1';
            } else {
                echo '0';
            }
            return;
        } else if ($operation == 'view') {
            $id = '0';
            $this->data['title'] = 'View Agencies';
            $this->data['agencies'] = $this->Agency_model->getAllAgencyInfo($id);
            $this->template->load("admin", "agency/view_agencies", $this->data);
        } else if ($operation == 'agency_info') {
            $this->data['title'] = 'Agency Information';
            $this->data['states'] = $this->manage_state('getAll');
            $this->data['agency'] = $this->Agency_model->getAgencyInfo($id);
            $this->data['agency']->password = base64_decode($this->data['agency']->password);
            $this->template->load("admin", "agency/agency_info", $this->data);
        } else if ($operation == 'edit' && $id != '') {
            $this->load->model('Agency_model');
            $this->load->model('City_model');
            $this->load->model('State_model');
            $this->load->model('Country_model');
            $post = $this->input->post();
            if ($post && $post['user_id']) {
                $this->load->model('User_model');
                /* User Account Update */
                $userId = $post['user_id'];
                $agencyData = array(
                    'email_id' => $post['email'],
                    'modified_at' => date('Y-m-d H:i:s')
                );
                if ($post['password'] != '') {
                    $agencyData['password'] = base64_encode($post['password']);
                }

                $this->User_model->updateUser($agencyData, $userId);
                /* agency update */
                $agency['name'] = $post['agencyname'];
                $agency['domain'] = $post['domain'];
                $agency['address_line_1'] = $post['address1'];
                $agency['address_line_2'] = $post['address2'];
                $agency['city_id'] = $post['city'];
                $agency['zipcode'] = $post['zip'];
                $agency['fname'] = $post['fname'];
                $agency['mname'] = $post['mname'];
                $agency['lname'] = $post['lname'];
                $agency['phone_number'] = $post['phone'];
                $agency['fax_number'] = $post['fax'];
                $agency['service_phone_number'] = $post['service_phone'];
                $agency['service_fax_number'] = $post['service_fax'];
                $agency['service_email'] = $post['service_email'];
                $agency['resident_license_number'] = $post['license_number'];
                $agency['resident_license_state_id'] = $post['resident_license_state'];
                if (count($post['nonresident_license_state']) > 0) {
                    $agency['non_resident_license_state_ids'] = implode(',', $post['nonresident_license_state']);
                } else {
                    $agency['non_resident_license_state_ids'] = '';
                }

                if ($post['payment'] == '1') {
                    $agency['bank_account_number'] = $post['bank_number'];
                    $agency['bank_routing_number'] = $post['routing_number'];
                    $agency['full_name'] = $post['bank_name'];
                    $agency['street_address'] = $post['bank_address'];
                    $agency['bank_city_id'] = $post['bank_city'];
                    $agency['bank_zip_code'] = $post['bank_zip'];
                } else {
                    $agency['card_name'] = $post['card_name'];
                    $agency['card_type'] = $post['card_type'];
                    $agency['card_number'] = $post['card_number'];
                    $agency['expiration_date'] = $post['expiration_date'];
                    $agency['ccv_number'] = $post['ccv_number'];
                }
                // $agency['nonresident_license_state'] = $this->input->post('nonresident_license_state');
                $agency['parent_agency'] = $post['parent_agency'];
                //$agency['user_id'] = $uid;
                //Upload Profile Image
                $agency['profile_image'] = $post['profile'];

                $agency_id = $this->Agency_model->update($id, $agency);
                $viciData['email'] = $agencyData['email_id'];
                $viciData['id'] = $id;
                $viciData['name'] = $agency['name'];
                if ($post['password'] != '') {
                    $viciData['password'] = $post['password'];
                }
                $agencynew = $this->Agency_model->getAgencyInfo($id);
                $vicidialUserId = $agencynew->vicidial_user_id;
                if ($vicidialUserId < 1) {
                    $vicidialUserId = NULL;
                    $viciData['password'] = clean(base64_decode($agencynew->password));
                }
                $this->vusers_m->addAgencyFromCrm($viciData, $vicidialUserId);
                /* if($agency_id != false && count($post['nonresident_license_state']) > 0)
                  {
                  $agency_states = array();
                  foreach($post['nonresident_license_state'] as $state)
                  {
                  $agency_state              = array();
                  $agency_state['agency_id'] = $id;
                  $agency_state['state_id']  = $state;
                  $agency_states[]           = $agency_state;
                  }
                  $this->Agency_model->update_batch($agency_states,$id);
                  } */
                $this->session->set_flashdata('msg', $agency['name'] . ' agency successfully updated.');
                redirect('admin/agencyindex');
            } else {
                $this->data['agency'] = $this->Agency_model->getAgencyInfo($id);
                $this->data['title'] = 'Edit Agency ' . $this->data['agency']->name;
                $this->data['country'] = $this->manage_country('getAll');
                $this->data['states'] = $this->manage_state('getAll');
                $this->data['parentagency'] = $this->Agency_model->getAll();
                $this->template->load("admin", "agency/edit_agency", $this->data);
            }
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
        if ($operation == 'add') {

            if ($this->input->post()) {

                $this->load->model('User_model');
                $agent_user['email_id'] = $this->input->post('email');
                $agent_user['password'] = base64_encode($this->input->post('password'));
                $agent_user['user_group_id'] = $this->User_model->getGroupidFromName('Agent');
                $agent_user['is_verified'] = 1;
                $agent_user['is_active'] = 1;
                $agent_user['created_at'] = date('Y-m-d H:i:s');
                $agent_user['modified_at'] = date('Y-m-d H:i:s');
                $uid = $this->User_model->insert($agent_user);

                if ($uid != false) {
                    //Insert Agent into agents table
                    $this->load->model('Agent_model');
                    $agent['fname'] = $this->input->post('fname');
                    $agent['mname'] = $this->input->post('mname');
                    $agent['lname'] = $this->input->post('lname');
                    $agent['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('dob')));
                    $agent['phone_number'] = convertphoneformat($this->input->post('phone'));
                    $agent['plivo_phone'] = convertphoneformat($this->input->post('plivo_phone'));
                    $agent['fax_number'] = convertphoneformat($this->input->post('fax'));
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
                    $agent['user_id'] = $uid;

                    $agent_id = $this->Agent_model->insert($agent);
                    $this->vusers_m->addAgentFromCrm(array('user' => 'agent' . $agent_id, 'email' => $agent_user['email_id'], 'password' => clean(base64_decode($agent_user['password'])), 'name' => $agent['fname'] . ' ' . $agent['lname'], 'id' => $agent_id), NULL);
                    if ($this->input->post('agent_type') == 1 && $agent_id != false && count($this->input->post('nonresident_license_state')) > 0) {
                        $agent_states = array();
                        foreach ($this->input->post('nonresident_license_state') as $state) {
                            $agent_state = array();
                            $agent_state['agent_id'] = $agent_id;
                            $agent_state['state_id'] = $state;
                            $agent_states[] = $agent_state;
                        }
                        $this->Agent_model->insert_batch($agent_states);
                    }
                    redirect('admin/manage_agent/view');
                }
            } else {
                $this->load->model('Agency_model');
                $this->data['title'] = 'Add Agent';
                $this->data['country'] = $this->manage_country('getAll');
                $this->data['agency'] = $this->Agency_model->getAll();
                $this->data['states'] = $this->manage_state('getAll');
                $this->template->load("admin", "agent/add_agent", $this->data);
            }
        } else if ($operation == 'delete') {
            $agent = $this->Agent_model->getAgentInfo($id);
            $vicidialId = $agent->vicidial_user_id;
            if ($this->Agent_model->delete($id)) {
                if ($vicidialId > 0) {
                    $this->vusers_m->delete($vicidialId);
                }
                echo '1';
            } else {
                echo '0';
            }
            return;
        } else if ($operation == 'view') {
            $this->data['title'] = 'View Agents';
            $this->data['agents'] = $this->Agent_model->getAllAgentInfo();
            $this->template->load("admin", "agent/view_agents", $this->data);
        } else if ($operation == 'agent_info') {
            $this->data['title'] = 'Agent Information';
            $this->data['agent'] = $this->Agent_model->getAgentInfo($id);
            $this->data['agent']->password = base64_decode($this->data['agent']->password);
            $this->template->load("admin", "agent/agent_info", $this->data);
        } else if ($operation == 'edit' && $id != '') {
            $this->load->model('Agency_model');

            $this->data['agent'] = $this->Agent_model->getAgentInfo($id);
            $this->data['agencies'] = $this->Agency_model->getAll();
            $this->data['country'] = $this->manage_country('getAll');
            $this->data['states'] = $this->manage_state('getAll');
            $post = $this->input->post();
            if ($post) {
                $this->load->model('User_model');

                $userId = $post['user_id'];
                $agentData = array(
                    'email_id' => $post['email'],
                    'modified_at' => date('Y-m-d H:i:s')
                );
                if ($post['password'] != '') {
                    $agentData['password'] = base64_encode($post['password']);
                }

                $this->User_model->updateUser($agentData, $userId);

                /* update agent information */
                $agent['fname'] = $post['fname'];
                $agent['mname'] = $post['mname'];
                $agent['lname'] = $post['lname'];
                $agent['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('dob')));
                $agent['phone_number'] = convertphoneformat($post['phone']);
                $agent['plivo_phone'] = convertphoneformat($post['plivo_phone']);
                $agent['fax_number'] = convertphoneformat($post['fax']);
                $agent['address_line_1'] = $post['address1'];
                $agent['address_line_2'] = $post['address2'];
                $agent['city_id'] = $post['city'];
                $agent['zip_code'] = $post['zip'];

                if ($post['agent_type'] == 1) {
                    $agent['national_producer_number'] = $post['npn'];
                    $agent['resident_license_number'] = $post['license_number'];
                    $agent['resident_license_state_id'] = $post['resident_license_state'];
                }
                $agent['agent_type'] = $post['agent_type'];
                $agent['agency_id'] = $post['parent_agency'];
                $agent['user_id'] = $userId;

                $this->Agent_model->update($id, $agent);

                $agent_id = $id;
                $viciData['email'] = $agentData['email_id'];
                $viciData['id'] = $id;
                $viciData['name'] = $agent['fname'] . ' ' . $agent['mname'] . ' ' . $agent['lname'];
                $viciData['user'] = 'agent' . $agent_id;
                if ($post['password'] != '') {
                    $viciData['password'] = $post['password'];
                }
                $agentNew = $this->Agent_model->getAgentInfo($id);
                $vicidialUserId = $agentNew->vicidial_user_id;
                if ($vicidialUserId < 1) {
                    $vicidialUserId = NULL;
                    $viciData['password'] = clean(base64_decode($agentNew->password));
                }
                $this->vusers_m->addAgentFromCrm($viciData, $vicidialUserId);

                if ($post['agent_type'] == 1 && $agent_id != false && count($post['nonresident_license_state']) > 0) {
                    $agent_states = array();
                    foreach ($post['nonresident_license_state'] as $state) {
                        $agent_state = array();
                        $agent_state['agent_id'] = $agent_id;
                        $agent_state['state_id'] = $state;
                        $agent_states[] = $agent_state;
                    }

                    $this->Agent_model->update_batch($agent_states, $agent_id);
                }
                $this->session->set_flashdata('msg', $agent['fname'] . ' ' . $agent['lname'] . ' successfully saved.');
                redirect('admin/manage_agent/view');
            } else {
                $this->data['title'] = 'Agent Information';
                //$this->data['agent']->password = base64_decode($this->data['agent']->password);
                $this->template->load("admin", "agent/edit_agent", $this->data);
            }
        }
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

    /*
     * check_email is used to perform check email already exists or not.
     *
     * return
     * 		if isset($return_email) && $return_email != ""
      echo "yes";
      return false;
      return yes for email id already exists in database.
      else
      echo "no";
      return no for email id not exists in database.
      @author Meet
     */

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

    public function profile() {
        $post = $this->input->post();
        $this->load->model('admin_model');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $info = array(
                'name' => $post['name'],
                'address' => $post['address'],
                'phone_number' => $post['phone_number']
            );
            $this->admin_model->updateAdminInfo($info, $this->session->userdata('admin')->user_id);
            $now = date('Y-m-d H:i:s');
            $credentials = array(
                'email_id' => $post['email'],
                'modified_at' => $now
            );

            if ($post['password'] != '') {
                $credentials['password'] = hashPassword($post['password']);
            }
            $this->admin_model->updateAdmin($credentials, $this->session->userdata('user')->id);

            $this->session->set_flashdata('msg', 'User information updated successfully.');
            redirect('admin/profile');
        }

        $this->data['title'] = 'My Profile';
        $this->template->load("admin", "profile", $this->data);
    }

    public function agencyindex() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['listtitle'] = 'Agency Listing';
        $this->data['title'] = 'Agency Listing';
        $this->template->load('admin', "admin/agency/list", $this->data);
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


        $rResult = $this->agencys->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->agencys->query($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->agencys->get());

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
                        $str .= '<a target="_blank" href="' . site_url('dialer/users/edit/' . encode_url($id)) . '">Dialer User</a>&nbsp;&nbsp;';
                        $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);
                        if (!$phone) {
                            $str .= '<a href="' . site_url('dialer/phones/createphone/' . $id) . '">Create Phone</a>&nbsp;&nbsp;';
                        }
                    } else {
                        $str .= '<a href="' . site_url('dialer/users/createagency/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                    }
                } else {
                    $str .= '<a href="' . site_url('dialer/users/createagency/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                }

                $row[] = '<a class="info" title="Information" id="' . $aRow['main.id'] . '" href="' . site_url('admin/manage_agency/agency_info/' . ($aRow['main.id'])) . '""><span class="fa fa-info"></span></a>&nbsp;&nbsp;<a href="' . site_url('admin/manage_agency/edit/' . ($aRow['main.id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('admin/manage_agency/delete/' . ($aRow['main.id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i></a>&nbsp;&nbsp;' . $str;

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
        $this->template->load('admin', "admin/agent/list", $this->data);
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


        $rResult = $this->agents->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->agents->query($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->agents->get());

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
                $str = '';
                if(strlen($aRow['main.sip_end_point']) <= 0){
                    $str = "<a href='javascript:;' class='plivo' data-agent='".$aRow['main.id']."'>Create End Point</a>";
                }
                /*$id = $aRow['main.vicidial_user_id'];
                $str = '';
                if ($id > 0) {
                    $user = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
                    if ($user) {
                        $str .= '<a target="_blank" href="' . site_url('dialer/users/edit/' . encode_url($id)) . '">Dialer User</a>&nbsp;&nbsp;';
                        $phone = $this->aphones_m->get_by(array('vicidial_user_id' => $id), TRUE);
                        if (!$phone) {
                            $str .= '<a href="' . site_url('dialer/phones/createphone/' . $id) . '">Create Phone</a>&nbsp;&nbsp;';
                        }
                    } else {
                        $str .= '<a href="' . site_url('dialer/users/createagent/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                    }
                } else {
                    $str .= '<a href="' . site_url('dialer/users/createagent/' . $aRow['main.id']) . '">Create Dialer User</a>&nbsp;&nbsp;';
                }*/

                /* ------- Check for user Login Or Not ------ */
                $logout_link = '';
                if ($aRow['user_token']) {
                    $logout_link .= '&nbsp;&nbsp;<a class="info" title="Logout" href="' . site_url('admin/logout_user/' . ($aRow['users.id'])) . '""><span class="fa fa-sign-out"></span></a>';
                }
                /* ------- End Check for user Login Or Not ------ */
                $row[] = '<a class="info" title="Information" id="' . $aRow['main.id'] . '" href="' . site_url('admin/manage_agent/agent_info/' . ($aRow['main.id'])) . '""><span class="fa fa-info"></span></a>&nbsp;&nbsp;<a href="' . site_url('admin/manage_agent/edit/' . ($aRow['main.id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('admin/manage_agent/delete/' . ($aRow['main.id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i></a>&nbsp;&nbsp;' . $str . $logout_link;

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function logout_user($user_id) {
        $this->load->model('User_model');
        $res = $this->User_model->updateUser(['user_token' => null], $user_id);
        if ($res) {
            $this->session->set_flashdata('success', 'User logout Successfully');
        } else {
            $this->session->set_flashdata('error', 'Error into logout user');
        }
        redirect('admin/agentindex');
    }

}
