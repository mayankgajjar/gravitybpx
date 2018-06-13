<?php

/**
 * Description of Admin
 *
 * @author Meet
 */
class Register extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        // $this->load->library('vicidialdb');
        // $this->load->model('vicidial/vusers_m', 'vusers_m');
    }

    /*
     * manage_agency is used to perform all functionality related to agency
     *
     * @param $operation string specify what type of operation is performed on agency
     * @param $id int specify unique id of agency
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into users, agencies and agency_
     */

    public function manage_agency($operation = "add") {
        $this->load->model('Agency_model');
        $this->load->model('User_model');
        $this->load->model('Common_model');
        $table_name_array = unserialize(TABLE_NAME);
        if ($operation == "add") {
            if ($this->input->post()) {
                //Insert Agency in users table
                $this->form_validation->set_rules('agencyname', 'Agency Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_unique_email');
                $this->form_validation->set_rules('password', 'Password', 'required|matches[rpassword]');
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
                        // $explode = explode('@', $agency_user['email_id']);
                        // $vuserId = strtolower($explode[0]) . $agency_id;
                        // $this->vusers_m->addAgencyFromCrm(array('user' => $vuserId, 'email' => $agency_user['email_id'], 'password' => base64_decode($agency_user['password']), 'name' => $agency['name'], 'id' => $agency_id), NULL);
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                        $this->session->set_flashdata('error_server_register_agency', validation_errors());
                        $this->data['country'] = $this->manage_country('getAll');
                        $this->data['agency'] = $this->Agency_model->getAll();
                        $this->data['states'] = $this->manage_state('getAll');
                        $this->load->view('login', $this->data);
                    } else {
                        if ($this->input->post('parent_id') != "" && $this->input->post('token') != "") {
                            $parent_id = $this->input->post('parent_id');
                            $token = $this->input->post('token');

                            $condition = 'parent_id = ' . $parent_id . ' and token = "' . $token . '" and is_active = 1';
                            $register_link_data = $this->Common_model->view_custom($condition, $table_name_array['register_link']);
                            if ($register_link_data != "") {
                                $editdata[is_active] = 0;
                                $this->Common_model->edit($register_link_data->id, $editdata, $table_name_array['register_link']);
                            }
                        }
                        $this->db->trans_commit();
                        $this->load->model('User_model');
                        $user = $this->User_model->getUser($this->input->post('email'), base64_encode($this->input->post('password')));
                        if ($user->is_verified && $user->is_active) {
                            if ($user->group_name == 'Agency') {
                                $agency = $this->User_model->getAgencyFromUser_id($user->id);
                                // $this->session->set_userdata("user", $user);
                                // $this->session->set_userdata('agency', $agency);
                                $this->session->set_flashdata('success', 'Agency is successfully register.');
                                $this->load->model('Email_model');
                                $subject = "New Agency Register";
                                $client_email = $this->input->post('email');
                                $admin_email = get_admin_email();
                                $message = "Thank you for register agency";
                                $this->Email_model->mail_send($subject, $client_email, $message);
                                $this->Email_model->mail_send($subject, $admin_email, $message);
                                // $cookie_name = "subdomain";
                                // $cookie_value = $agency->domain;
                                // setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/', $this->config->item('cookie_domain')); // 86400 = 1 day
                                // redirect($this->config->item('http') . $cookie_value . '.' . $this->config->item('main_url') . 'agency'); // If you direct redirect to agency then please set token
                                redirect('login');
                            } else {
                                redirect('login');
                            }
                        }
                        redirect('login');
                    }
                } else {
                    $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                    $this->session->set_flashdata('error_server_register_agency', validation_errors());
                    $this->data['country'] = $this->manage_country('getAll');
                    $this->data['agency'] = $this->Agency_model->getAll();
                    $this->data['states'] = $this->manage_state('getAll');
                    $this->load->view('login', $this->data);
                }
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

    public function manage_agent($operation = 'add') {
        $this->load->model('Agent_model');
        $this->load->model('User_model');
        $this->load->model('Agency_model');
        $this->load->model('Common_model');
        // $this->load->library('vicidialdb');
        // $this->load->model('vicidial/vusers_m', 'vusers_m');

        $table_name_array = unserialize(TABLE_NAME);
        if ($operation == 'add') {
            if ($this->input->post()) {
                //Insert Agent in users table
                $this->form_validation->set_rules('fname', 'First Name', 'required');
                $this->form_validation->set_rules('lname', 'Last Name', 'required');
                $this->form_validation->set_rules('parent_agency', 'Parent Agency', 'required');
                $this->form_validation->set_rules('agent_type', 'Agent Type', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_unique_email');
                $this->form_validation->set_rules('password', 'Password', 'required|matches[rpassword]');
                $this->form_validation->set_rules('rpassword', 'Confirm Password', 'required');
                $this->form_validation->set_rules('phone', 'Phone Number', 'required');
                $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
                $this->form_validation->set_rules('address1', 'Address', 'required');
                $this->form_validation->set_rules('country', 'Country', 'required');
                $this->form_validation->set_rules('state', 'State', 'required');
                $this->form_validation->set_rules('city', 'City', 'required');
                $this->form_validation->set_rules('zip', 'Zip Code', 'required');
                if ($this->input->post('agent_type') == 1) {
                    $this->form_validation->set_rules('npn', 'National Producer Number', 'required');
                    $this->form_validation->set_rules('license_number', 'Resident License Number', 'required');
                    $this->form_validation->set_rules('resident_license_state', 'Resident License State', 'required');
                }

                $agent_user['email_id'] = $this->input->post('email');
                $agent_user['password'] = base64_encode($this->input->post('password'));
                $agent_user['user_group_id'] = $this->User_model->getGroupidFromName('Agent');
                $agent_user['is_verified'] = 1;
                $agent_user['is_active'] = 1;
                $agent_user['created_at'] = date('Y-m-d H:i:s');
                $agent_user['modified_at'] = date('Y-m-d H:i:s');

                $agent['fname'] = $this->input->post('fname');
                $agent['mname'] = $this->input->post('mname');
                $agent['lname'] = $this->input->post('lname');
                $agent['agency_id'] = $this->input->post('parent_agency');
                $agent['agent_type'] = $this->input->post('agent_type');
                $agent['phone_number'] = convertphoneformat($this->input->post('phone'));
                // $agent['plivo_phone'] = convertphoneformat($this->input->post('plivo_phone'));
                $agent['fax_number'] = convertphoneformat($this->input->post('fax'));
                $agent['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('dob')));
                $agent['address_line_1'] = $this->input->post('address1');
                $agent['address_line_2'] = $this->input->post('address2');
                $agent['country_id'] = $this->input->post('country');
                $agent['state_id'] = $this->input->post('state');
                $agent['city_id'] = $this->input->post('city');
                $agent['zip_code'] = $this->input->post('zip');

                if ($this->input->post('agent_type') == 1) {
                    $agent['national_producer_number'] = $this->input->post('npn');
                    $agent['resident_license_number'] = $this->input->post('license_number');
                    $agent['resident_license_state_id'] = $this->input->post('resident_license_state');
                    if (count($this->input->post('nonresident_license_state')) > 0) {
                        $agent['non_resident_license_state_ids'] = implode(',', $this->input->post('nonresident_license_state'));
                        $array_new = array();
                        foreach ($this->input->post('nonresident_license_state') as $key => $value) {
                            $array_new[]['state_id'] = $value;
                        }
                        $agent['non_resident_state'] = $array_new;
                    } else {
                        $agent['non_resident_license_state_ids'] = '';
                        $agent['non_resident_state'] = '';
                    }
                }

                if ($this->form_validation->run() == TRUE) {
                    unset($agent['country_id']);
                    unset($agent['state_id']);
                    unset($agent['non_resident_state']);

                    $this->db->trans_begin();
                    //Insert Agent in users table
                    $uid = $this->User_model->insert($agent_user);
                    $agent['user_id'] = $uid;
                    if ($uid != false) {
                        //Insert Agent into Agent table
                        $agency_id = $this->Agent_model->insert($agent);

                        // $this->vusers_m->addAgentFromCrm(array('email' => $agent_user['email_id'], 'password' => base64_decode($agent_user['password']), 'name' => $agent['fname'] . ' ' . $agent['lname'], 'id' => $agency_id), NULL);
                    }
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                        $this->session->set_flashdata('error_server_register_agent', validation_errors());
                        $this->data['country'] = $this->manage_country('getAll');
                        $this->data['agency'] = $this->Agency_model->getAll();
                        $this->data['states'] = $this->manage_state('getAll');
                        $this->load->view('login', $this->data);
                    } else {
                        if ($this->input->post('parent_id') != "" && $this->input->post('agent_type_id') != "" && $this->input->post('token') != "") {
                            $parent_id = $this->input->post('parent_id');
                            $agent_type_id = $this->input->post('agent_type_id');
                            $token = $this->input->post('token');

                            $condition = 'parent_id = ' . $parent_id . ' and agent_type_id = ' . $agent_type_id . ' and token = "' . $token . '" and is_active = 1';
                            $register_link_data = $this->Common_model->view_custom($condition, $table_name_array['register_link']);
                            if ($register_link_data != "") {
                                $editdata[is_active] = 0;
                                $this->Common_model->edit($register_link_data->id, $editdata, $table_name_array['register_link']);
                            }
                        }
                        $this->db->trans_commit();
                        $this->load->model('User_model');
                        $user = $this->User_model->getUser($this->input->post('email'), base64_encode($this->input->post('password')));
                        if($user->is_verified && $user->is_active)
                        {
                           if($user->group_name == 'Agent')
                           {
                               // $this->session->set_userdata("user",$user);
                               // $this->session->set_userdata('agent',$this->User_model->getAgentFromUser_id($user->id));
                               $this->session->set_flashdata('success','Agent is successfully register.');
                               $this->load->model('Email_model');
                               $subject = "New Agent Register";
                               $client_email = $this->input->post('email');
                               $admin_email = get_admin_email();
                               $message = "Thank you for register agent";
                               $this->Email_model->mail_send($subject,$client_email,$message);
                               $this->Email_model->mail_send($subject,$admin_email,$message);
                               // redirect('agent'); // If you direct redirect to agent then please set token
                               redirect('login');
                           }
                           else
                           {
                               redirect('login');
                           }
                       }
                        redirect('login');
                    }
                } else {
                    $this->data['agent'] = (object) array_merge($agent_user, $agent);
                    $this->form_validation->set_error_delimiters('<div class="error_fields">', '</div>');
                    $this->session->set_flashdata('error_server_register_agent', validation_errors());
                    $this->data['country'] = $this->manage_country('getAll');
                    $this->data['agency'] = $this->Agency_model->getAll();
                    $this->data['states'] = $this->manage_state('getAll');
                    $this->load->view('login', $this->data);
                }
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
            $str = "<option value=''>Select City</option>";
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

    public function unique_email($email) {
        // Do NOT validate if email already exists
        // UNLESS it's the email for the current user
        $this->load->model('User_model');
        $return_email = $this->User_model->check_email($email);
        if (isset($return_email) && $return_email != "") {
            $this->form_validation->set_message('unique_email', '%s should be unique.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
