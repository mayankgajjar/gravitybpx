<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Customer
 *
 * @author Meet
 */
class Customer extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {

        }
    }

    /*
     * manage_customer is used to perform all functionality related to customer
     *
     * @param $operation string specify what type of operation is performed on customer
     * @param $id int specify unique id of customer
     *
     * return
     * 		If $operation == 'add'
     * 			If request is post
     *
     */

    public function manage_customer($operation = "view", $id = "") {
        $table_name_array = unserialize(TABLE_NAME);
        $this->load->model('Agent_model');
        $this->load->model('Agency_model');
        $this->load->model('Customer_model');
        $this->load->model('Common_model');
        //$table_name = "category";
        $limit = "";
        if ($this->session->userdata('agent') && $this->session->userdata('agent')->agent_type == 1) {
            $sales_agent_id = $this->session->userdata('agent')->id;
        } else if ($this->session->userdata('agent') && $this->session->userdata('agent')->agent_type == 2) {
            $verification_agent_id = $this->session->userdata('agent')->id;
            $agency_id = $this->session->userdata('agent')->agency_id;
        } else if ($this->session->userdata('agent') && $this->session->userdata('agency')->id != "") {
            $agency_id = $this->session->userdata('agency')->id;
        }
        if ($operation == "add") {
            if ($this->input->post()) {
                $customer_id = $this->input->post('customer_id');
                $remove_members_ids = explode(",", $this->input->post('remove_members_ids'));
                $remove_beneficiaries_ids = explode(",", $this->input->post('remove_beneficiaries_ids'));
                $find_array = array("US$ ", "_", ",");
                $replace_array = array("", "", "");

                /* Step 1 Start */
                $customer['agent_id'] = $this->input->post('sales_agent_id');
                if ($this->input->post('verification_agent_id') != "") {
                    $customer['verification_agent_id'] = $this->input->post('verification_agent_id');
                }

                $name_string = $this->input->post('fname') . ' ' . $this->input->post('lname');
                $customer['fname'] = $this->input->post('fname');
                $customer['mname'] = $this->input->post('mname');
                $customer['lname'] = $this->input->post('lname');
                $customer['gender'] = $this->input->post('gender');
                $customer['date_of_birth'] = date('Y-m-d', strtotime($this->input->post('dob')));
                $customer['age'] = $this->input->post('age');
                $customer['zipcode'] = $this->input->post('zip');
                $customer['city'] = $this->input->post('city');
                $customer['state'] = $this->input->post('state');
                $customer['phone_number'] = $this->input->post('phone_number');
                $customer['email'] = $this->input->post('email');

                $config['upload_path'] = 'uploads/customer_file';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx|txt';

                $this->upload->initialize($config);
                if ($this->upload->do_upload('customer_file')) {
                    $data = $this->upload->data();
                    $customer['customer_file'] = $data['file_name'];
                }
                /* Step 1 End */
                /* Step 2 Start */
                $customer1['pre_existing_condition'] = $this->input->post('pre_exist_condition');
                $customer1['use_tobacco'] = $this->input->post('use_tobacco');
                $customer1['plan_type'] = $this->input->post('plan_type');
                $customer1['first_payment'] = $this->input->post('first_payment');
                /* Step 2 End */
                /* Step 3 Start */
                $application['app_fname'] = $this->input->post('app_fname');
                $application['app_mname'] = $this->input->post('app_mname');
                $application['app_lname'] = $this->input->post('app_lname');
                $application['app_marital_status'] = ($this->input->post('app_marital_status')) ? $this->input->post('app_marital_status') : '';
                $application['app_gender'] = $this->input->post('app_gender');
                $application['app_height_feet'] = $this->input->post('app_height-feet');
                $application['app_height_inches'] = $this->input->post('app_height-Inches');
                $application['app_weight'] = $this->input->post('app_weight');
                $application['app_primary_email'] = $this->input->post('app_primary_email');
                $application['app_zipcode'] = $this->input->post('app_zip');
                $application['app_city'] = $this->input->post('app_city');
                $application['app_state'] = $this->input->post('app_state');
                $application['app_how_long_address'] = $this->input->post('app_how_to_long');
                $application['app_another_address'] = $this->input->post('app_another_address');
                $application['app_another_zipcode'] = $this->input->post('app_another_zip');
                $application['app_another_city'] = $this->input->post('app_another_city');
                $application['app_another_state'] = $this->input->post('app_another_state');
                $application['app_another_time_at_address'] = $this->input->post('app_another_time_at_address');
                $application['app_phone_number'] = $this->input->post('app_phone_number');
                $application['app_email'] = $this->input->post('app_email');
                $application['app_social_sec_number'] = $this->input->post('app_soc_sec_number');
                $application['app_date_of_birth'] = date('Y-m-d', strtotime($this->input->post('app_dob')));
                $application['app_age'] = $this->input->post('app_age');
                $application['app_birth_state_id'] = $this->input->post('app_birth_state');

                if ($this->input->post('app_us_citizen') == "yes") {
                    $application['app_is_us_citizen'] = $this->input->post('app_us_citizen');
                } else {
                    $application['app_is_us_citizen'] = "no";
                }
                if ($this->input->post('app_employed') == "yes") {
                    $application['app_is_employed'] = $this->input->post('app_employed');
                } else {
                    $application['app_is_employed'] = "no";
                }
                $application['app_employer'] = $this->input->post('app_employer');
                $application['app_occupation'] = $this->input->post('app_occupation');
                if ($this->input->post('app_annual_salary') != "") {
                    $application['app_annual_salary'] = number_format(str_replace($find_array, $replace_array, $this->input->post('app_annual_salary')), 2, '.', '');
                }
                $application['app_desc_of_job_duties'] = $this->input->post('app_des_of_job_duties');
                $application['app_driver_license'] = $this->input->post('app_driver_license');
                /* Step 3 End */
                /* Step 4 Start */
                $amid = $this->input->post('amid');
                $amfname = $this->input->post('amfname');
                $ammname = $this->input->post('ammname');
                $amlname = $this->input->post('amlname');
                $amsoc_sec_number = $this->input->post('amsoc_sec_number');
                $amrelationship = $this->input->post('amrelationship');
                $amdate_of_birth = $this->input->post('amdob');
                /* Step 4 End */
                /* Step 5 Start */
                if ($this->input->post('beneficiaries_type') == "estate") {
                    $customer['beneficiaries_type'] = $this->input->post('beneficiaries_type');
                } else {
                    $customer['beneficiaries_type'] = $this->input->post('beneficiaries_type');
                }
                if ($this->input->post('individual_type') == "primary") {
                    $customer['individual_type'] = $this->input->post('individual_type');
                }
                if ($this->input->post('individual_type') == "contingent") {
                    $customer['individual_type'] = $this->input->post('individual_type');
                }
                if ($this->input->post('beneficiaries_type') != "") {
                    $beid = $this->input->post('beid');
                    $befname = $this->input->post('befname');
                    $bemname = $this->input->post('bemname');
                    $belname = $this->input->post('belname');
                    $besoc_sec_number = $this->input->post('besoc_sec_number');
                    $berelationship = $this->input->post('berelationship');
                    $bedate_of_birth = $this->input->post('bedob');
                    $bephone_number = $this->input->post('bephone_number');
                    $beemail = $this->input->post('beemail');
                    $beper_of_share = $this->input->post('beper_of_share');
                }
                /* Step 5 End */
                /* Step 6 Start */
                $payment = $this->input->post('payment');
                if ($payment == 1) {
                    $customer['bank_name'] = $this->input->post('bank_name');
                    $customer['bank_address'] = $this->input->post('bank_address');
                    $bank_country = $this->input->post('bank_country');
                    $bank_state = $this->input->post('bank_state');
                    $customer['bank_city_id'] = $this->input->post('bank_city');
                    $customer['bank_zipcode'] = $this->input->post('bank_zip');
                    $customer['bank_routing_number'] = $this->input->post('routing_number');
                    $customer['bank_account_number'] = $this->input->post('bank_number');
                } else {
                    //$customer['fname_credit_card'] = $this->input->post('card_fname');
                    //$customer['mname_credit_card'] = $this->input->post('card_mname');
                    //$customer['lname_credit_card'] = $this->input->post('card_lname');
                    $customer['card_type'] = $this->input->post('card_type');
                    $customer['card_number'] = $this->input->post('card_number');
                    $customer['expiration_date'] = $this->input->post('expiration_date');
                    $customer['ccv_number'] = $this->input->post('ccv_number');
                    $customer['bill_add_same_resi_add'] = $this->input->post('billing_same');
                    $customer['card_address'] = $this->input->post('billing_address');
                    $billing_country = $this->input->post('billing_country');
                    $billing_state = $this->input->post('billing_state');
                    $customer['card_city_id'] = $this->input->post('billing_city');
                    $customer['card_zipcode'] = $this->input->post('billing_zip');
                }
                $customer['notes'] = $this->input->post('notes');
                /* Step 6 End */
                if ($customer_id == "") {
                    $agent_name_array = $this->Agent_model->getAgentName($this->input->post('sales_agent_id'));
                    $submitted_by = $agent_name_array->fname . " " . $agent_name_array->mname . " " . $agent_name_array->lname;
                    $customer['submitted_by'] = $submitted_by;
                    $customer['submitted_date'] = date('Y-m-d H:i:s');
                    $customer['submitted_status'] = 1;
                    $customer['verified_by'] = "";
                    //$customer['verified_date'] = "0000-00-00";
                    $customer['verified_status'] = 0;
                    $customer['created_at'] = date('Y-m-d H:i:s');
                    $customer['modified_at'] = date('Y-m-d H:i:s');
                } else {
                    if ($this->session->userdata('agent')->agent_type == 1) {
                        $customer['modified_at'] = date('Y-m-d H:i:s');
                    } else if ($this->session->userdata('agent')->agent_type == 2) {
                        $verification_name_array = $this->Agent_model->getAgentName($this->input->post('verification_agent_id'));
                        $verified_by = $verification_name_array->fname . " " . $verification_name_array->mname . " " . $verification_name_array->lname;
                        $customer['verified_by'] = $verified_by;
                        $customer['verified_date'] = date('Y-m-d H:i:s');
                        $customer['verified_status'] = $this->input->post('verification_status');
                        $customer['modified_at'] = date('Y-m-d H:i:s');
                    }
                }
                $customer['is_active'] = 1;

                /*  insert code start */
                if ($customer_id == "") {
                    $customer_insert_id = $this->Customer_model->customer_insert($customer);
                } else {
                    $customer_insert_id = $this->Customer_model->customer_update($customer, $customer_id);
                }

                $application['customer_id'] = $customer_insert_id;
                if ($customer_id == "") {
                    $this->Customer_model->customer_application_insert($application);
                } else {
                    $this->Customer_model->customer_application_update($application, $customer_id);
                }
                $customer1['customer_id'] = $customer_insert_id;
                if ($customer_id == "") {
                    $this->Customer_model->customer_plan_insert($customer1);
                } else {
                    $this->Customer_model->customer_plan_update($customer1, $customer_id);
                }
                if (!empty($remove_members_ids)) {
                    $this->Customer_model->remove_customer_additional_members_by_id($remove_members_ids);
                }
                if (!empty($remove_beneficiaries_ids)) {
                    $this->Customer_model->remove_customer_beneficiaries_by_id($remove_beneficiaries_ids);
                }
                $count_additional_member = count($amfname);
                for ($i = 0; $i < $count_additional_member; $i++) {
                    $datanew['customer_id'] = $customer_insert_id;
                    $editadm = $amid[$i];
                    $datanew['am_fname'] = $amfname[$i];
                    $datanew['am_mname'] = $ammname[$i];
                    $datanew['am_lname'] = $amlname[$i];
                    $datanew['am_social_sec_number'] = $amsoc_sec_number[$i];
                    $datanew['am_relationship'] = $amrelationship[$i];
                    if ($amdate_of_birth[$i] != "") {
                        $datanew['am_date_of_birth'] = date('Y-m-d', strtotime($amdate_of_birth[$i]));
                    }
                    if ($datanew['am_fname'] != "" || $datanew['am_mname'] != "" || $datanew['am_lname'] != "") {
                        if ($customer_id == "") {
                            $this->Customer_model->customer_additonal_members_insert($datanew);
                        } else {
                            if ($editadm != "") {
                                $this->Customer_model->customer_additonal_members_update($datanew, $editadm);
                            }
                            if ($editadm == "") {
                                $this->Customer_model->customer_additonal_members_insert($datanew);
                            }
                        }
                    }
                }
                $count_beneficiaries = count($befname);
                for ($i = 0; $i < $count_beneficiaries; $i++) {
                    $datanew1['customer_id'] = $customer_insert_id;
                    $editbe = $beid[$i];
                    $datanew1['be_fname'] = $befname[$i];
                    $datanew1['be_mname'] = $bemname[$i];
                    $datanew1['be_lname'] = $belname[$i];
                    $datanew1['be_social_sec_number'] = $besoc_sec_number[$i];
                    $datanew1['be_relationship'] = $berelationship[$i];
                    if ($bedate_of_birth[$i] != "") {
                        $datanew1['be_date_of_birth'] = date('Y-m-d', strtotime($bedate_of_birth[$i]));
                    }
                    $datanew1['be_phone_number'] = $bephone_number[$i];
                    $datanew1['be_email'] = $beemail[$i];
                    $datanew1['be_per_of_share'] = $beper_of_share[$i];
                    if ($datanew1['be_fname'] != "" || $datanew1['be_mname'] != "" || $datanew1['be_lname'] != "") {
                        if ($customer_id == "") {
                            $this->Customer_model->customer_beneficiaries_insert($datanew1);
                        } else {
                            if ($editbe != "") {
                                $this->Customer_model->customer_beneficiaries_update($datanew1, $editbe);
                            }
                            if ($editbe == "") {
                                $this->Customer_model->customer_beneficiaries_insert($datanew1);
                            }
                        }
                    }
                }
                $customer_product['customer_id'] = $customer_insert_id;
                $customer_product['agent_id'] = $this->input->post('sales_agent_id');
                $customer_temp_product['customer_id'] = $customer_insert_id;
                $product_id_array = array();
                $product_temp_id_array = array();

                if (count($this->cart->contents()) > 0) {
                    foreach ($this->cart->contents() as $items) {
                        if ($items['options']['temp_product'] == "true") {
                            $product_temp_id_array[] = $items['id'];
                        } else {
                            $product_id_array[] = $items['id'];
                        }
                    }
                }

                $customer_product['product_id'] = implode(',', $product_id_array);
                $customer_temp_product['product_id'] = implode(',', $product_temp_id_array);
                $customer_product['payment_status'] = 1;
                $customer_product['created_at'] = date('Y-m-d H:i:s');
                $customer_product['modified_at'] = date('Y-m-d H:i:s');
                $customer_temp_update_product_agent_id = $this->input->post('sales_agent_id');
                $customer_temp_update_product['is_active'] = 2;

                if ($customer_id == "") {
                    $this->Customer_model->customer_product_insert($customer_product);

                    /* Notification table start */
                    $notification['type'] = 'customer_notify_to_verification';
                    $notification['content'] = 'New Customer has been register.';
                    $notification['agent_type_id'] = 2;
                    $notification['customer_id'] = $customer_insert_id;
                    $notification['is_display'] = 0;
                    $notification['is_read'] = 0;
                    $notification['is_remove'] = 0;
                    $notification['created_at'] = date('Y-m-d H:i:s');
                    $notification['modified_at'] = date('Y-m-d H:i:s');
                    /* Notification table end */
                    /* Insert notification entry for new customer */
                    $this->Common_model->add($notification, $table_name_array['notifications']);

                    $this->Customer_model->customer_temp_product_insert($customer_temp_product, $customer_temp_update_product, $customer_temp_update_product_agent_id);
                    $this->session->set_flashdata('msg', "$name_string is successfully inserted.");
                } else {
                    unset($notification['created_at']);
                    $this->Customer_model->customer_product_update($customer_product, $customer_id);
                    if ($this->session->userdata('agent')->agent_type == 1) {
                        /* Notification table start */
                        $notification['type'] = 'customer_notify_to_verification';
                        $notification['content'] = 'New Customer has been register.';
                        $notification['agent_type_id'] = 2;
                        $notification['customer_id'] = $customer_insert_id;
                        $notification['is_display'] = 0;
                        $notification['is_read'] = 0;
                        $notification['is_remove'] = 0;
                        $notification['created_at'] = date('Y-m-d H:i:s');
                        $notification['modified_at'] = date('Y-m-d H:i:s');
                        /* Notification table end */
                        /* Edit notification entry for customer by sales agent */
                        $condition = array("customer_id" => $customer_id);
                        $this->Common_model->edit_custom($condition, $notification, $table_name_array['notifications']);
                    } else if ($this->session->userdata('agent')->agent_type == 2) {
                        if ($this->input->post('verification_status') == 0) {
                            /* Notification table start */
                            $notification['type'] = 'customer_notify_to_sales_agent';
                            $notification['content'] = 'Customer is not successfully verified.';
                            $notification['agent_type_id'] = 1;
                            $notification['customer_id'] = $customer_insert_id;
                            $notification['is_display'] = 0;
                            $notification['is_read'] = 0;
                            $notification['is_remove'] = 0;
                            $notification['created_at'] = date('Y-m-d H:i:s');
                            $notification['modified_at'] = date('Y-m-d H:i:s');
                            /* Notification table end */
                            $condition = array("customer_id" => $customer_id);
                            $this->Common_model->edit_custom($condition, $notification, $table_name_array['notifications']);
                        } else {
                            /* Notification table start */
                            $notification['type'] = 'customer_notify_to_processing_agent';
                            $notification['content'] = 'Customer is successfully verified.';
                            $notification['agent_type_id'] = 3;
                            $notification['customer_id'] = $customer_insert_id;
                            $notification['is_display'] = 0;
                            $notification['is_read'] = 0;
                            $notification['is_remove'] = 0;
                            $notification['created_at'] = date('Y-m-d H:i:s');
                            $notification['modified_at'] = date('Y-m-d H:i:s');
                            /* Notification table end */
                            $condition = array("customer_id" => $customer_id);
                            $this->Common_model->edit_custom($condition, $notification, $table_name_array['notifications']);
                        }
                    }
                    $this->Customer_model->customer_temp_product_update($customer_temp_product, $customer_temp_update_product, $customer_temp_update_product_agent_id, $customer_id);
                    $this->session->set_flashdata('msg', "$name_string is successfully updated.");
                }
                redirect('customer/manage_customer/view');
            } else {
                $this->load->model('Products_model');
                $this->load->model('Company_model');
                $this->Products_model->disableProducts($sales_agent_id);
                $this->data['title'] = 'Add Customer';
                $this->data['country'] = $this->manage_country('getAll');
                $this->data['states'] = $this->manage_state('getAll');
                $return_string = "";
                foreach ($this->manage_country('getAll') as $value) {
                    $return_string .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
                }
                $this->data['bith_country'] = $return_string;
                $this->data['company'] = $this->Company_model->getAll();
                $this->data['categories'] = $this->Common_model->viewAll($table_name_array['category'], $limit);
                $this->cart->destroy();
                if ( $this->session->userdata('agency') && $this->session->userdata('agency')->id != "") {
                    $this->template->load("agency", "customer/add_customer", $this->data);
                } else {
                    $this->template->load("agent", "customer/add_customer", $this->data);
                }
            }
        } else if ($operation == 'delete') {
            if ($this->Customer_model->customer_delete($id)) {
                echo '1';
                $this->session->set_flashdata('msg', "Customer has been deleted successfully.");
            } else {
                echo '0';
            }
            return;
        } else if ($operation == 'view') {
            $this->data['datatable'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['title'] = 'View Customers';
            if ($this->session->userdata('agent') && $this->session->userdata('agent')->agent_type == 1) {
                $this->data['customers'] = $this->Customer_model->getAllCustomerInfo($sales_agent_id);
                $this->template->load("agent", "customer/view_customers", $this->data);
            } else if ($this->session->userdata('agent') && $this->session->userdata('agent')->agent_type == 2) {
                $this->data['customers'] = $this->Customer_model->getAllCustomerInfoByAgency($agency_id);
                $this->template->load("agent", "customer/view_customers", $this->data);
            } else if ($this->session->userdata('agency') && $this->session->userdata('agency')->id != "") {
                $agency_id = $this->session->userdata('agency')->id;
                $this->data['customers'] = $this->Customer_model->getAllCustomerInfoByAgency($agency_id);
                $this->template->load("agency", "customer/view_customers", $this->data);
            }
        } else if ($operation == 'customer_info') {
            $this->data['title'] = 'Customer Information';
            $this->data['customer'] = $this->Customer_model->getCustomerInfo($id);
            if ( $this->session->userdata('agency') && $this->session->userdata('agency')->id != "") {
                $this->template->load("agency", "customer/customer_info", $this->data);
            } else {
                $this->template->load("agent", "customer/customer_info", $this->data);
            }
        } else if ($operation == 'getCustomerById') {
            $this->load->model('Products_model');
            $this->load->model('Company_model');
            $this->cart->destroy();
            if ($this->session->userdata('agent')->agent_type == 1) {
                $this->Products_model->enableProducts($sales_agent_id);
            } else if ($this->session->userdata('agent')->agent_type == 2 || $this->session->userdata('agency')->id != "") {
                $sales_agent_id = $this->Customer_model->getSalesAgentIdByCustomerId($id);
                $this->Products_model->enableProducts($sales_agent_id->agent_id);
            }

            $this->data['title'] = 'Edit Customer';
            $this->data['country'] = $this->manage_country('getAll');
            $this->data['states'] = $this->manage_state('getAll');
            $return_string = "";
            foreach ($this->manage_country('getAll') as $value) {
                $return_string .= "<option value=" . $value['id'] . ">" . $value['name'] . "</option>";
            }
            $this->data['bith_country'] = $return_string;
            $this->data['company'] = $this->Company_model->getAll();
            $this->data['customer'] = $this->Customer_model->getCustomerInfo($id);
            $this->data['categories'] = $this->Common_model->viewAll($table_name_array['category'], $limit);
            if (isset($this->session->userdata('agency')->id) && $this->session->userdata('agency')->id != "") {
                $this->template->load("agency", "customer/add_customer", $this->data);
            } else {
                $this->template->load("agent", "customer/add_customer", $this->data);
            }
        }
    }

    public function dashboard_customers_section() {
        $this->load->model('Customer_model');
        $customers_submitted = $this->Customer_model->getAllSubmittedCustomers();
        $return_submitted = $this->display_customer_on_dashboard($customers_submitted);
        $customers_verified = $this->Customer_model->getAllVerifiedCustomers();
        $return_verified = $this->display_customer_on_dashboard($customers_verified);
        $customers_unverified = $this->Customer_model->getAllUnVerifiedCustomers();
        $return_unverified = $this->display_customer_on_dashboard($customers_unverified);
        echo json_encode(array("return_submitted" => $return_submitted, "return_verified" => $return_verified, "return_unverified" => $return_unverified));
        die;
    }

    public function remove_customer_additional_members($id = "") {
        $this->load->model('Customer_model');
        $this->Customer_model->remove_customer_additional_members($id);
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

    public function manage_state($operation = "", $id = "") {
        $this->load->model('State_model');
        if ($operation == "getAll") {
            return $this->State_model->getAll();
        } else if ($operation == "getByCountryId") {
            $str = "<option value=''>Select State</option>";
            foreach ($this->State_model->getStateByCountryId($id) as $value) {
                $str .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
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

    public function manage_city($operation = "", $id = "") {
        $this->load->model('City_model');
        if ($operation == "getAll") {
            return $this->City_model->getAll();
        } else if ($operation == "getByStateId") {
            $str = "";
            foreach ($this->City_model->getCityByStateId($id) as $value) {
                $str .= "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
            }
            echo $str;
            return;
        }
    }

    public function checkHeight($operation = "Feet", $value = "") {
        $this->load->model('Customer_model');
        if ($operation == "Feet") {
            $is_product_americo = "false";
            if (isset($_POST['height_feet']) && $_POST['height_feet'] != "" && isset($_POST['admin_pro_height_feet']) && $_POST['admin_pro_height_feet'] != "") {
                $value = $_POST['height_feet'];
                $admin_pro_height_feet = $_POST['admin_pro_height_feet'];
            } else {
                $admin_pro_height_feet = "false";
            }
            if (count($this->cart->contents()) > 0) {
                foreach ($this->cart->contents() as $items) {
                    if ($items['options']['company_name'] == "Americo" && !isset($items['options']['temp_product'])) {
                        $is_product_americo = "true";
                    }
                }
            }
            if ($is_product_americo == "true" || $admin_pro_height_feet == "true") {
                $allheight = $this->Customer_model->checkHeightFeet();
                if (!empty($allheight)) {
                    $height = array();
                    $min = min($allheight);
                    $max = max($allheight);
                    $height['first'] = $min['height_feet'];
                    $height['last'] = $max['height_feet'];
                    $height['status'] = "false";
                    foreach ($allheight as $key => $value1) {
                        if ($value1['height_feet'] == $value) {
                            $height['status'] = "true";
                        }
                    }
                    echo json_encode($height);
                    die;
                }
            }
        } else if ($operation == "Inches") {
            $is_product_americo = "false";
            if (isset($_POST['height_inches']) && $_POST['height_inches'] != "" && isset($_POST['admin_pro_height_inches']) && $_POST['admin_pro_height_inches'] != "") {
                $value = $_POST['height_inches'];
                $admin_pro_height_inches = $_POST['admin_pro_height_inches'];
            } else {
                $admin_pro_height_inches = "false";
            }
            if (count($this->cart->contents()) > 0) {
                foreach ($this->cart->contents() as $items) {
                    if ($items['options']['company_name'] == "Americo") {
                        $is_product_americo = "true";
                    }
                }
            }
            if ($is_product_americo == "true" || $admin_pro_height_inches == "true") {
                $allheight = $this->Customer_model->checkHeightInches();
                if (!empty($allheight)) {
                    $height = array();
                    $min = min($allheight);
                    $max = max($allheight);
                    $height['first'] = $min['height_inches'];
                    $height['last'] = $max['height_inches'];
                    $height['status'] = "false";
                    foreach ($allheight as $key => $value1) {
                        if ($value1['height_inches'] == $value) {
                            $height['status'] = "true";
                        }
                    }
                    echo json_encode($height);
                    die;
                }
            }
        } else if ($operation == "inchesStart") {
            $allheight = $this->Customer_model->checkHeight();
            if (!empty($allheight)) {
                $height = array();
                $height['first'] = $this->minvalue($allheight);
                $height['last'] = $this->maxvalue($allheight);
                $height['status'] = "false";
                $compare_value = $this->feetandinchestocm(intval($_POST['height_feet_from']), intval($_POST['height_inches_from']));
                foreach ($allheight as $key => $value1) {
                    $cm = $this->feetandinchestocm(intval($value1['height_feet']), intval($value1['height_inches']));
                    if ((floatval($cm) <= floatval($compare_value)) && (intval(0) <= intval($_POST['height_inches_from']) && intval(11) >= intval($_POST['height_inches_from']))) {
                        $height['status'] = "true";
                    }
                }
                echo json_encode($height);
                die;
            }
        } else if ($operation == "inchesEnd") {
            $allheight = $this->Customer_model->checkHeight();
            if (!empty($allheight)) {
                $height = array();
                $height['first'] = $this->minvalue($allheight);
                $height['last'] = $this->maxvalue($allheight);
                $height['status'] = "false";
                $compare_value = $this->feetandinchestocm(intval($_POST['height_feet_to']), intval($_POST['height_inches_to']));
                foreach ($allheight as $key => $value1) {
                    $cm = $this->feetandinchestocm(intval($value1['height_feet']), intval($value1['height_inches']));
                    if (floatval($cm) >= floatval($compare_value) && (intval(0) <= intval($_POST['height_inches_to']) && intval(11) >= intval($_POST['height_inches_to']))) {
                        $height['status'] = "true";
                    }
                }
                echo json_encode($height);
                die;
            }
        } else if ($operation == "Both") {
            $allheight = $this->Customer_model->checkHeight();
            if (!empty($allheight)) {
                $height = array();
                $height['first'] = $this->minvalue($allheight);
                $height['last'] = $this->maxvalue($allheight);
                $height['status'] = "false";
                $height['product_name'] = array();
                $height['remove_products'] = array();
                $height['remove_products_id'] = array();
                $height_status = 0;
                $customer_status = 0;
                $compare_value = $this->feetandinchestocm(intval($_POST['height_feet']), intval($_POST['height_inches']));
                foreach ($allheight as $key => $value1) {
                    $cm = $this->feetandinchestocm(intval($value1['height_feet']), intval($value1['height_inches']));
                    if (floatval($cm) == floatval($compare_value)) {
                        $customer_status = 1;
                        if (count($this->cart->contents()) > 0) {
                            foreach ($this->cart->contents() as $items) {
                                $this->load->model('Products_model');
                                if ($items['options']['company_name'] == "Americo") {
                                    $products = $this->Products_model->getProductInfo($items['id']);
                                    $product_height_feet_from = $products->height_feet_from;
                                    $product_height_feet_to = $products->height_feet_to;
                                    $product_height_inches_from = $products->height_inches_from;
                                    $product_height_inches_to = $products->height_inches_to;
                                    $product_height_from = $this->feetandinchestocm(intval($product_height_feet_from), intval($product_height_inches_from));
                                    $product_height_to = $this->feetandinchestocm(intval($product_height_feet_to), intval($product_height_inches_to));

                                    if ((floatval($product_height_from) <= floatval($compare_value)) && (floatval($product_height_to) >= floatval($compare_value))) {
                                        //$height['status'] = "true";
                                    } else {
                                        $height['first'] = $product_height_feet_from . "'" . $product_height_inches_from;
                                        $height['last'] = $product_height_feet_to . "'" . $product_height_inches_to;
                                        $height_status = $height_status + 1;
                                        $height['product_name'][] = $items['name'];
                                        $height['remove_products'][] = $items['rowid'];
                                        $height['remove_products_id'][] = $items['id'];
                                    }
                                }
                            }
                        }
                    }
                }
                if (!empty($height['product_name'])) {
                    $height['product_name'] = implode(" ,", $height['product_name']);
                }
                if ($customer_status == 0) {
                    $height['customer_status'] = "false";
                } else {
                    $height['customer_status'] = "true";
                }
                if ($height_status == 0) {
                    $height['status'] = "true";
                } else {
                    $height['status'] = "false";
                }
                echo json_encode($height);
                die;
            }
        }
    }

    public function checkWeight($operation = "checkweight", $value = "") {
        $this->load->model('Customer_model');
        if ($operation == "checkweight") {
            $allweight = $this->Customer_model->checkWeight();
            if (!empty($allweight)) {
                $weight = array();
                $weight['first'] = $this->minweightvalue($allweight);
                $weight['last'] = $this->maxweightvalue($allweight);
                $weight['status'] = "false";
                foreach ($allweight as $key => $value1) {
                    if ((intval($value1['weight_start']) <= intval($value)) && (intval($value1['weight_end']) >= intval($value))) {
                        $weight['status'] = "true";
                    }
                }
                echo json_encode($weight);
                die;
            }
        } else if ($operation == "checkheightandweight") {
            $allheightweight = $this->Customer_model->checkHeightAndWeight();
            if (!empty($allheightweight)) {
                $heightweight = array();
                $heightweight['height_first'] = $this->minvalue($allheightweight);
                $heightweight['height_last'] = $this->maxvalue($allheightweight);
                $heightweight['weight_first'] = 0;
                $heightweight['weight_last'] = 0;
                $heightweight['status'] = "false";
                $heightweight['product_name'] = array();
                $heightweight['remove_products'] = array();
                $heightweight['remove_products_id'] = array();
                $heightweight_status = 0;
                $customer_status = 0;
                $compare_value = $this->feetandinchestocm(intval($_POST['height_feet']), intval($_POST['height_inches']));
                foreach ($allheightweight as $key => $value1) {
                    $cm = $this->feetandinchestocm(intval($value1['height_feet']), intval($value1['height_inches']));
                    if (floatval($cm) == floatval($compare_value)) {
                        if (intval($value1['weight_start']) <= intval($_POST['weight_value']) && intval($value1['weight_end']) >= intval($_POST['weight_value'])) {
                            $customer_status = 1;
                            //$heightweight['status'] = "true";
                            if (count($this->cart->contents()) > 0) {
                                foreach ($this->cart->contents() as $items) {
                                    $this->load->model('Products_model');
                                    if ($items['options']['company_name'] == "Americo") {
                                        $products = $this->Products_model->getProductInfo($items['id']);
                                        $product_height_feet_from = $products->height_feet_from;
                                        $product_height_feet_to = $products->height_feet_to;
                                        $product_height_inches_from = $products->height_inches_from;
                                        $product_height_inches_to = $products->height_inches_to;
                                        $product_weight_from = $products->height_inches_to;
                                        $product_weight_from = $products->weight_from;
                                        $product_weight_to = $products->weight_to;
                                        $product_height_from = $this->feetandinchestocm(intval($product_height_feet_from), intval($product_height_inches_from));
                                        $product_height_to = $this->feetandinchestocm(intval($product_height_feet_to), intval($product_height_inches_to));
                                        if ((floatval($product_height_from) <= floatval($compare_value)) && (floatval($product_height_to) >= floatval($compare_value)) && intval($product_weight_from) <= intval($_POST['weight_value']) && intval($product_weight_to) >= intval($_POST['weight_value'])) {
                                            //$height['status'] = "true";
                                        } else {
                                            $heightweight['weight_first'] = intval($value1['weight_start']);
                                            $heightweight['weight_last'] = intval($value1['weight_end']);
                                            $heightweight_status = $heightweight_status + 1;
                                            $heightweight['product_name'][] = $items['name'];
                                            $heightweight['remove_products'][] = $items['rowid'];
                                            $heightweight['remove_products_id'][] = $items['id'];
                                        }
                                    }
                                }
                            }
                        } else {
                            $heightweight['weight_first'] = intval($value1['weight_start']);
                            $heightweight['weight_last'] = intval($value1['weight_end']);
                        }
                    }
                }
                if (!empty($heightweight['product_name'])) {
                    $heightweight['product_name'] = implode(" ,", $heightweight['product_name']);
                }
                if ($customer_status == 0) {
                    $heightweight['customer_status'] = "false";
                } else {
                    $heightweight['customer_status'] = "true";
                }
                if ($heightweight_status == 0) {
                    $heightweight['status'] = "true";
                } else {
                    $heightweight['status'] = "false";
                }
                echo json_encode($heightweight);
                die;
            }
        } else if ($operation == "checkheightandweightfromto") {
            $allheightweight = $this->Customer_model->checkHeightAndWeight();
            if (!empty($allheightweight)) {
                $heightweight = array();
                $heightweight['height_first'] = $this->minvalue($allheightweight);
                $heightweight['height_last'] = $this->maxvalue($allheightweight);
                $heightweight['weight_first'] = 0;
                $heightweight['weight_last'] = 0;
                $heightweight['status'] = "false";
                $compare_from_value = $this->feetandinchestocm(intval($_POST['height_feet_from']), intval($_POST['height_inches_from']));
                $compare_to_value = $this->feetandinchestocm(intval($_POST['height_feet_to']), intval($_POST['height_inches_to']));

                foreach ($allheightweight as $key => $value1) {
                    $cm = $this->feetandinchestocm(intval($value1['height_feet']), intval($value1['height_inches']));
                    if (floatval($cm) == floatval($compare_from_value)) {
                        $heightweight['weight_first'] = intval($value1['weight_start']);
                    }
                    if (floatval($cm) >= floatval($compare_from_value) && floatval($cm) <= floatval($compare_to_value)) {
                        if (intval($_POST['weight_from_value']) != "" && intval($_POST['weight_to_value']) != "") {
                            if ((intval($value1['weight_start']) >= intval($_POST['weight_from_value'])) && (intval($value1['weight_end']) >= intval($_POST['weight_to_value']))) {
                                $heightweight['status'] = "true";
                            } else {
                                $heightweight['weight_last'] = intval($value1['weight_end']);
                            }
                        } else if (intval($_POST['weight_from_value']) != "") {
                            if (intval($value1['weight_start']) <= intval($_POST['weight_from_value']) && intval($value1['weight_end']) >= intval($_POST['weight_from_value'])) {
                                $heightweight['status'] = "true";
                            } else {
                                $heightweight['weight_last'] = intval($value1['weight_end']);
                            }
                        } else if (intval($_POST['weight_to_value']) != "") {
                            if (intval($value1['weight_start']) <= intval($_POST['weight_to_value']) && intval($value1['weight_end']) >= intval($_POST['weight_to_value'])) {
                                $heightweight['status'] = "true";
                            } else {
                                $heightweight['weight_last'] = intval($value1['weight_end']);
                            }
                        }
                    }
                }
                echo json_encode($heightweight);
                die;
            }
        }
    }

    public function minvalue($allheight) {
        $mn = $this->feetandinchestocm(intval($allheight[0]['height_feet']), intval($allheight[0]['height_inches']));
        $return_mn = $allheight[0]['height_feet'] . "'" . $allheight[0]['height_inches'];
        for ($i = 0; $i < count($allheight); $i++) {
            $cm = $this->feetandinchestocm(intval($allheight[$i]['height_feet']), intval($allheight[$i]['height_inches']));
            if ($cm < $mn) {
                $mn = $cm;
                $return_mn = $allheight[$i]['height_feet'] . "'" . $allheight[$i]['height_inches'];
            }
        }
        return $return_mn;
    }

    public function maxvalue($allheight) {
        $mx = $this->feetandinchestocm(intval($allheight[0]['height_feet']), intval($allheight[0]['height_inches']));
        $return_mx = $allheight[0]['height_feet'] . "'" . $allheight[0]['height_inches'];
        for ($i = 0; $i < count($allheight); $i++) {
            $cm = $this->feetandinchestocm(intval($allheight[$i]['height_feet']), intval($allheight[$i]['height_inches']));
            if ($cm > $mx) {
                $mx = $cm;
                $return_mx = $allheight[$i]['height_feet'] . "'" . $allheight[$i]['height_inches'];
            }
        }
        return $return_mx;
    }

    public function minweightvalue($allweight) {
        $mn = intval($allweight[0]['weight_start']);
        for ($i = 0; $i < count($allweight); $i++) {
            $ws = intval($allweight[$i]['weight_start']);
            $we = intval($allweight[$i]['weight_end']);
            if ($ws < $mn) {
                $mn = $ws;
            } else if ($we < $mn) {
                $mn = $we;
            }
        }
        return $mn;
    }

    public function maxweightvalue($allweight) {
        $mx = intval($allweight[0]['weight_start']);
        for ($i = 0; $i < count($allweight); $i++) {
            $ws = intval($allweight[$i]['weight_start']);
            $we = intval($allweight[$i]['weight_end']);
            if ($ws > $mx) {
                $mx = $ws;
            } else if ($we > $mn) {
                $mx = $we;
            }
        }
        return $mx;
    }

    public function feetandinchestocm($feet, $inches) {
        return (($feet * 12) + $inches) * 2.54;
    }

    function display_customer_on_dashboard($customers_data) {
        $return_staring = "";
        if (!empty($customers_data)) {
            $return_staring .= '<div class="scroller" style="height: 282px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">';
            $return_staring .= '<div class="mt-comments">';
            foreach ($customers_data as $key => $value) {
                $return_staring .= '<div class="mt-comment">';
                $return_staring .= '<div class="mt-comment-img">';
                if ($value['gender'] == "male") {
                    $return_staring .= '<img src="' . site_url('assets/theam_assets/pages/media/users/avatar_male.png') . '" /></div>';
                } else if ($value['gender'] == "female") {
                    $return_staring .= '<img src="' . site_url('assets/theam_assets/pages/media/users/avatar_female.png') . '" /></div>';
                } else {
                    $return_staring .= '<img src="' . site_url('assets/theam_assets/pages/media/users/avatar_male_female.jpg') . '" /></div>';
                }
                $return_staring .= '<div class="mt-comment-body">';
                $return_staring .= '<div class="mt-comment-info">';
                $return_staring .= '<span class="mt-comment-author">' . $value['fname'] . ' ' . $value['lname'] . '</span>';
                $createdDate = $value['created_at'];
                $newCreatedDate = date("d M Y h:i:s A", strtotime($createdDate));
                $return_staring .= '<span class="mt-comment-date">' . $newCreatedDate;
                '</span>';
                $return_staring .= '</div>';
                $return_staring .= '<div class="mt-comment-text"></div>';
                $return_staring .= '<div class="mt-comment-details">';
                $return_staring .= '<ul class="mt-comment-actions">';
                $return_staring .= '<li>';
                $return_staring .= '<a target="_blank" href="' . site_url('customer/manage_customer/getCustomerById/' . $value['id']) . '">Edit</a>';
                $return_staring .= '</li>';
                $return_staring .= '<li>';
                $return_staring .= '<a target="_blank" href="' . site_url('customer/manage_customer/customer_info/' . $value['id']) . '">View</a>';
                $return_staring .= '</li>';
                $return_staring .= '<li>';
                $return_staring .= '<a id="' . $value['id'] . '" class="delete" href="javascript:;">Delete</a>';
                $return_staring .= '</li>';
                $return_staring .= '</ul>';
                $return_staring .= '</div>';
                $return_staring .= '</div>';
                $return_staring .= '</div>';
            }
            $return_staring .= '</div>';
            $return_staring .= '</div>';
        }
        return $return_staring;
    }

    public function cindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Customer Listing';
        $this->data['title'] = 'Customers';
        $this->template->load('agent',"customer/list",$this->data);
    }
    public function cindexjson(){
        $this->load->model('customers');

        $aColumns = array('main.id', 'main.fname', 'main.gender', 'main.date_of_birth', 'main.zipcode', 'main.phone_number', 'main.email');
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = " LIMIT ". $_GET['iDisplayStart'].", ".
                         $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                    $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                        ".$_GET['sSortDir_'.$i] .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
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
        if ( $_GET['sSearch'] != "" ){
            $sWhere .= " WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ') ';
        }


        $rResult = $this->customers->queryForAgent($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->customers->queryForAgent($sWhere);
        if($aFilterResult){
            $iFilteredTotal = count($aFilterResult);
        }else{
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->customers->queryForAgent());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 0;

        if($segement) :
            $count = $_GET['iDisplayStart'];
        endif;

        if($rResult){
            foreach( $rResult as $aRow ){
                $row = array();
                $count++;
                for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                    if($aColumns[$i] == 'main.id'){
                        $row[] = $count;
                    }else if($aColumns[$i] == 'sub.name'){
                        if($aRow['sub.name'] == ''){
                           $row[]  = 'No Parent';
                        }else{
                           $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }else{
                        $row[] = $aRow[ $aColumns[$i] ];
                    }
                }

                $row[] = '<a class="info" title="Information" id="'.$aRow['main.id'].'" href="'.site_url('customer/manage_customer/customer_info/'.($aRow['main.id'])).'""><span class="fa fa-info"></span></a>&nbsp;&nbsp;<a href="'.site_url('customer/manage_customer/getCustomerById/'.($aRow['main.id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('customer/manage_customer/delete/'.($aRow['main.id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i></a>&nbsp;&nbsp;';

                $output['aaData'][] = $row;
            }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }
}
