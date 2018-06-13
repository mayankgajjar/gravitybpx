<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Add_to_cart
 *
 * @author Meet
 */
class Add_to_cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /*
     * add_to_cart is used to perform all functionality related to cart
     *
     * @param $pid int specify the product id
     *
     */

    public function add_to_cart() {
        $americo_count = 0;
        if ($_POST['main_cart'] == "main_product") {
            $pid = $_POST['data'];
            $enrollment_fee = $_POST['enrollment_fee_price'];
            $company_name = $_POST['company_name'];
            if ($pid != "") {
                $this->load->model('Products_model');
                $query = $this->Products_model->getById($pid);

                $data = array(
                    'id' => $pid,
                    'qty' => 1,
                    'price' => $query->product_price,
                    'name' => $query->product_name,
                    'options' => array('enrollment_fee' => $enrollment_fee, 'company_name' => $company_name, 'application_fields' => $query->application_information)
                );

                $this->cart->insert($data);

                $cart_array = array();
                $enrollment_fee_total = 0;
                $application_fields_array = array('app_fname' => 'not_required', 'app_mname' => 'not_required', 'app_lname' => 'not_required', 'app_marital_status' => 'not_required', 'app_gender' => 'not_required', 'app_height' => 'not_required', 'app_weight' => 'not_required', 'app_primary_email' => 'not_required', 'app_zip' => 'not_required', 'app_how_to_long' => 'not_required', 'app_phone_number' => 'not_required', 'app_email' => 'not_required', 'app_soc_sec_number' => 'not_required', 'app_dob' => 'not_required', 'app_birth_state' => 'not_required', 'app_us_citizen' => 'not_required', 'app_employed' => 'not_required', 'app_employer' => 'not_required', 'app_occupation' => 'not_required', 'app_annual_salary' => 'not_required', 'app_des_of_job_duties' => 'not_required', 'app_driver_license' => 'not_required');
                if (count($this->cart->contents()) > 0) {
                    foreach ($this->cart->contents() as $items) {
                        if ($items['id'] == $pid) {
                            $cart_array['last_product_cart'] = $pid;
                            $cart_array['last_product_cart_remove_link'] = $items['rowid'];
                        }
                        if ($items['name'] == "Americo" || $items['options']['company_name'] == "Americo" || $items['options']['company_name'] == "americo") {
                            $americo_count = $americo_count + 1;
                        } else {
                            $americo_count = $americo_count + 0;
                        }
                        $enrollment_fee_total = $enrollment_fee_total + $items['options']['enrollment_fee'];

                        if ($items['options']['application_fields'] != "") {
                            $products_application_information = explode('&', unserialize($items['options']['application_fields']));
                            foreach ($products_application_information as $key1 => $value1) {
                                $explode_value = explode('=', $value1);
                                if (array_key_exists($explode_value[0], $application_fields_array) && $explode_value[1] == "required") {
                                    $application_fields_array[$explode_value[0]] = $explode_value[1];
                                }
                            }
                        }
                    }
                }
                $cart_array['count'] = count($this->cart->contents());
                $cart_array['total'] = $this->cart->total();
                $cart_array['enrollment_fee_total'] = $enrollment_fee_total;
                $cart_array['Americo'] = $americo_count;
                $cart_array['application_fields_array'] = $application_fields_array;
                echo json_encode($cart_array);
                die;
            }
        }
        if ($_POST['temp_cart'] == "temp_product") {
            $pid = $_POST['data'];
            $enrollment_fee = $_POST['enrollment_fee_price'];
            $company_name = $_POST['company_name'];

            if ($pid != "") {
                $this->load->model('Products_model');
                $query = $this->Products_model->getTempProductById($pid);

                $data = array(
                    'id' => $pid,
                    'qty' => 1,
                    'price' => $query->product_price,
                    'name' => $query->product_name,
                    'options' => array('enrollment_fee' => $enrollment_fee, 'temp_product' => 'true', 'company_name' => $company_name)
                );

                $this->cart->insert($data);

                $cart_array = array();
                $enrollment_fee_total = 0;
                if (count($this->cart->contents()) > 0) {
                    foreach ($this->cart->contents() as $items) {
                        if ($items['id'] == $pid) {
                            $cart_array['last_product_cart'] = $pid;
                            $cart_array['last_product_cart_remove_link'] = $items['rowid'];
                        }
                        if ($items['name'] == "Americo" || $items['options']['company_name'] == "Americo" || $items['options']['company_name'] == "americo") {
                            $americo_count = $americo_count + 1;
                        } else {
                            $americo_count = $americo_count + 0;
                        }
                        $enrollment_fee_total = $enrollment_fee_total + $items['options']['enrollment_fee'];
                    }
                }
                $cart_array['count'] = count($this->cart->contents());
                $cart_array['total'] = $this->cart->total();
                $cart_array['enrollment_fee_total'] = $enrollment_fee_total;
                $cart_array['Americo'] = $americo_count;
                echo json_encode($cart_array);
                die;
            }
        }
    }

    public function remove_cart() {
        $americo_count = 0;
        if ($_POST['main_cart'] == "main_product") {
            $remove_string = $_POST['data'];
            $cart_array = array();
            if ($remove_string != "") {
                $data = array(
                    'rowid' => $remove_string,
                    'qty' => 0
                );
                $this->cart->update($data);
                $enrollment_fee_total = 0;
                $application_fields_array = array('app_fname' => 'not_required', 'app_mname' => 'not_required', 'app_lname' => 'not_required', 'app_marital_status' => 'not_required', 'app_gender' => 'not_required', 'app_height' => 'not_required', 'app_weight' => 'not_required', 'app_primary_email' => 'not_required', 'app_zip' => 'not_required', 'app_how_to_long' => 'not_required', 'app_phone_number' => 'not_required', 'app_email' => 'not_required', 'app_soc_sec_number' => 'not_required', 'app_dob' => 'not_required', 'app_birth_state' => 'not_required', 'app_us_citizen' => 'not_required', 'app_employed' => 'not_required', 'app_employer' => 'not_required', 'app_occupation' => 'not_required', 'app_annual_salary' => 'not_required', 'app_des_of_job_duties' => 'not_required', 'app_driver_license' => 'not_required');
                if (count($this->cart->contents()) > 0) {
                    foreach ($this->cart->contents() as $items) {
                        if ($items['name'] == "Americo" || $items['options']['company_name'] == "Americo" || $items['options']['company_name'] == "americo") {
                            $americo_count = $americo_count + 1;
                        } else {
                            $americo_count = $americo_count + 0;
                        }
                        $enrollment_fee_total = $enrollment_fee_total + $items['options']['enrollment_fee'];
                        if ($items['options']['application_fields'] != "") {
                            $products_application_information = explode('&', unserialize($items['options']['application_fields']));
                            foreach ($products_application_information as $key1 => $value1) {
                                $explode_value = explode('=', $value1);
                                if (array_key_exists($explode_value[0], $application_fields_array) && $explode_value[1] == "required") {
                                    $application_fields_array[$explode_value[0]] = $explode_value[1];
                                }
                            }
                        }
                    }
                }
                $cart_array['count'] = count($this->cart->contents());
                $cart_array['total'] = $this->cart->total();
                $cart_array['enrollment_fee_total'] = $enrollment_fee_total;
                $cart_array['Americo'] = $americo_count;
                $cart_array['application_fields_array'] = $application_fields_array;
                echo json_encode($cart_array);
                die;
            }
        }
        if ($_POST['temp_cart'] == "temp_product") {
            $remove_string = $_POST['data'];
            $cart_array = array();
            if ($remove_string != "") {
                $data = array(
                    'rowid' => $remove_string,
                    'qty' => 0
                );
                $this->cart->update($data);
                $enrollment_fee_total = 0;
                if (count($this->cart->contents()) > 0) {
                    foreach ($this->cart->contents() as $items) {
                        if ($items['name'] == "Americo" || $items['options']['company_name'] == "Americo" || $items['options']['company_name'] == "americo") {
                            $americo_count = $americo_count + 1;
                        } else {
                            $americo_count = $americo_count + 0;
                        }
                        $enrollment_fee_total = $enrollment_fee_total + $items['options']['enrollment_fee'];
                    }
                }
                $cart_array['count'] = count($this->cart->contents());
                $cart_array['total'] = $this->cart->total();
                $cart_array['enrollment_fee_total'] = $enrollment_fee_total;
                $cart_array['Americo'] = $americo_count;
                echo json_encode($cart_array);
                die;
            }
        }
    }

}
