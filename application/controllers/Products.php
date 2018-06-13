<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Agent
 *
 * @author Meet
 */
class Products extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('/Login');
        } else {

        }
    }

    /*
     * manage_agent_product is used to perform all functionality related to customer
     *
     * @param $operation string specify what type of operation is performed on customer
     * @param $id int specify unique id of customer
     *
     * return
     * 		If $operation == 'add'
     * 			If request is post
     *
     */

    public function manage_agent_product($operation = "view", $id = "") {
        //$this->load->model('Agent_model');
        $this->load->model('Products_model');
        $sales_agent_id = $this->session->userdata('agent')->id;
        /* if($this->session->userdata('agent')->agent_type == 1)
          { */
        if ($operation == "add") {
            if ($this->input->post()) {
                $find_array = array("US$ ", "_", ",");
                $replace_array = array("", "", "");
                $add_customer_product['agent_id'] = $this->input->post('add_sales_agent_id');
                $add_customer_product['category_id'] = $this->input->post('product_category');
                $add_customer_product['product_name'] = $this->input->post('add_product_name');
                $add_customer_product['company_id'] = $this->input->post('add_underwriting_company');
                $add_customer_product['product_levels'] = $this->input->post('add_product_levels');
                if ($this->input->post('add_product_price') != "") {
                    $add_customer_product['product_price'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_product_price')), 2, '.', '');
                }
                if ($this->input->post('add_plan_type') != "") {
                    $add_customer_product['plan_type'] = $this->input->post('add_plan_type');
                }
                if ($this->input->post('add_enrollment_fee') != "") {
                    $add_customer_product['enrollment_fee'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_enrollment_fee')), 2, '.', '');
                }
                if ($this->input->post('add_monthly_payment') != "") {
                    $add_customer_product['monthly_payment'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_monthly_payment')), 2, '.', '');
                }
                if ($this->input->post('add_co_pays') != "") {
                    $add_customer_product['co_pays'] = number_format(str_replace($find_array, '', $this->input->post('add_co_pays')), 2, '.', '');
                }
                if ($this->input->post('add_specialist_co_pay') != "") {
                    $add_customer_product['specialist_co_pay'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_specialist_co_pay')), 2, '.', '');
                }
                if ($this->input->post('add_coinsurance') != "") {
                    $add_customer_product['coinsurance'] = str_replace('%', '', $this->input->post('add_coinsurance'));
                }
                if ($this->input->post('add_deductible_amount') != "") {
                    $add_customer_product['deductible_amount'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_deductible_amount')), 2, '.', '');
                }
                if ($this->input->post('add_maximum_benefits') != "") {
                    $add_customer_product['maximum_benefits'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_maximum_benefits')), 2, '.', '');
                }
                if ($this->input->post('add_maximum_out_of_pocket') != "") {
                    $add_customer_product['maximum_out_of_pocket'] = number_format(str_replace($find_array, $replace_array, $this->input->post('add_maximum_out_of_pocket')), 2, '.', '');
                }
                $add_customer_product['is_active'] = 1;
                $add_customer_product['created_at'] = date('Y-m-d H:i:s');
                $add_customer_product['modified_at'] = date('Y-m-d H:i:s');

                $this->Products_model->agent_add_product($add_customer_product);
                $products1 = $this->Products_model->getAgentProducts($this->input->post('add_sales_agent_id'));
                if (!empty($products1)) {
                    $return_string = "";
                    foreach ($products1 as $key => $value) {
                        $return_string .='<div class="col-md-3 temp_product">';
                        $return_string .='<div class="portlet box blue-hoki">';
                        $return_string .='<div class="portlet-title">';
                        $return_string .='<div class="actions">';
                        $return_string .='<a class="btn btn-default btn-sm add_to_cart1" company_name="' . $value['company_name'] . '" enrollment_fee="' . $value['enrollment_fee'] . '" temp-id="' . $value['id'] . '" href="javascript:;"> Apply <i class="fa fa-shopping-cart"></i></a>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='<div class="portlet-body">';
                        $return_string .='<div class="cbp cbp-caption-active cbp-ready">';
                        $return_string .='<div class="cbp-caption cbp-singlePageInline" data-title="' . $value['product_name'] . '" rel="nofollow">';
                        $return_string .='<div class="cbp-caption-defaultWrap">';
                        $return_string .='<div class="product_company">';
                        if ($value['company_logo'] != "") {
                            $return_string .='<img class="company_logo" src="uploads/company_logo/' . $value['company_logo'] . '" />';
                        } else {
                            $return_string .='<img class="company_logo" src="uploads/company_logo/no-photo-available.jpeg" />';
                        }
                        $return_string .='</div>';
                        $return_string .='<div class="product_name">';
                        $return_string .='<span class="product_name_span">';
                        if ($value['product_name'] != "") {
                            $return_string .= $value['product_name'];
                        }
                        $return_string .='</span>';
                        $return_string .='</div>';
                        $return_string .='<div class="product_level">';
                        if ($value['product_levels'] != "") {
                            $return_string .= $value['product_levels'];
                        }
                        $return_string .='</div>';
                        $return_string .='<div class="product_price">';
                        if ($value['product_price'] != "") {
                            $return_string .= toMoney($value['product_price']) . ' <span class="monthly">/month</span>';
                        } else {
                            $return_string .='$0.00 <span class="monthly">/month</span>';
                        }
                        $return_string .='</div>';
                        $return_string .='<div class="pre_check">';
                        $return_string .='<div enrollment_fee="' . $value['enrollment_fee'] . '" class="enrollment_fee">';
                        if ($value['enrollment_fee'] != "") {
                            $return_string .= toMoney($value['enrollment_fee']) . ' enrollment';
                        } else {
                            $return_string .='$0.00 enrollment';
                        }
                        $return_string .='</div>';
                        $return_string .='<div class="co_pays">';
                        $return_string .='<span class="light">Co-Pay</span>';
                        $return_string .='<span class="dark">';
                        if ($value['co_pays'] != "") {
                            $return_string .= toMoney($value['co_pays']);
                        } else {
                            $return_string .='$0.00';
                        }
                        $return_string .='</span>';
                        $return_string .='</div>';
                        $return_string .='<div class="specialist_co_pay">';
                        $return_string .='<span class="light">Specialist Co-Pay</span>';
                        $return_string .='<span class="dark">';
                        if ($value['specialist_co_pay'] != "") {
                            $return_string .= toMoney($value['specialist_co_pay']);
                        } else {
                            $return_string .='$0.00';
                        }
                        $return_string .='</span>';
                        $return_string .='</div>';
                        $return_string .='<div class="coinsurance">';
                        $return_string .='<span class="light">Coinsurance</span>';
                        $return_string .='<span class="dark">';
                        if ($value['coinsurance'] != "") {
                            $return_string .= $value['coinsurance'] . '%';
                        } else {
                            $return_string .='0%';
                        }
                        $return_string .='</span>';
                        $return_string .='</div>';
                        $return_string .='<div class="deductible_amount">';
                        $return_string .='<span class="light">Deductible</span>';
                        $return_string .='<span class="dark">';
                        if ($value['deductible_amount'] != "") {
                            $return_string .= toMoney($value['deductible_amount']);
                        } else {
                            $return_string .='$0.00';
                        }
                        $return_string .='</span>';
                        $return_string .='</div>';
                        $return_string .='<div class="maximum_out_of_pocket_dis">';
                        $return_string .='<span class="light">OOP Max</span>';
                        $return_string .='<span class="dark">';
                        if ($value['maximum_out_of_pocket'] != "") {
                            $return_string .= toMoney($value['maximum_out_of_pocket']);
                        } else {
                            $return_string .='$0.00';
                        }
                        '</span>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='<div class="portlet-title portlet-title-bottom">';
                        $return_string .='<div class="caption">';
                        $return_string .='<a class="btn btn-default btn-sm" href="javascript:;"> Compare </a>';
                        $return_string .='</div>';
                        $return_string .='<div class="actions">';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                        $return_string .='</div>';
                    }
                }
                echo $return_string;
                die;
                //redirect('Agent/manage_customer/view');
            }
        }
        /* } */
        if ($operation == "getAll") {
            /* if($this->session->userdata('agent')->agent_type == 1)
              {
              $agent_id = $this->session->userdata('agent')->id;
              }
              if($this->session->userdata('agent')->agent_type == 2)
              {
              $agent_id = $this->session->userdata('agent')->id;
              } */
            $products1 = $this->Products_model->getAgentProducts(explode(",", $_POST['data']));
            if (!empty($products1)) {
                $return_string = "";
                foreach ($products1 as $key => $value) {
                    $return_string .='<div class="col-md-3 temp_product">';
                    $return_string .='<div class="portlet box blue-hoki">';
                    $return_string .='<div class="portlet-title">';
                    $return_string .='<div class="actions">';
                    $return_string .='<a class="btn btn-default btn-sm add_to_cart1" company_name="' . $value['company_name'] . '" enrollment_fee="' . $value['enrollment_fee'] . '" temp-id="' . $value['id'] . '" href="javascript:;"> Apply <i class="fa fa-shopping-cart"></i></a>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='<div class="portlet-body">';
                    $return_string .='<div class="cbp cbp-caption-active cbp-ready">';
                    $return_string .='<div class="cbp-caption cbp-singlePageInline" data-title="' . $value['product_name'] . '" rel="nofollow">';
                    $return_string .='<div class="cbp-caption-defaultWrap">';
                    $return_string .='<div class="product_company">';
                    if ($value['company_logo'] != "") {
                        $return_string .='<img class="company_logo" src="uploads/company_logo/' . $value['company_logo'] . '" />';
                    } else {
                        $return_string .='<img class="company_logo" src="uploads/company_logo/no-photo-available.jpeg" />';
                    }
                    $return_string .='</div>';
                    $return_string .='<div class="product_name">';
                    $return_string .='<span class="product_name_span">';
                    if ($value['product_name'] != "") {
                        $return_string .= $value['product_name'];
                    }
                    $return_string .='</span>';
                    $return_string .='</div>';
                    $return_string .='<div class="product_level">';
                    if ($value['product_levels'] != "") {
                        $return_string .= $value['product_levels'];
                    }
                    $return_string .='</div>';
                    $return_string .='<div class="product_price">';
                    if ($value['product_price'] != "") {
                        $return_string .= toMoney($value['product_price']) . ' <span class="monthly">/month</span>';
                    } else {
                        $return_string .='$0.00 <span class="monthly">/month</span>';
                    }
                    $return_string .='</div>';
                    $return_string .='<div class="pre_check">';
                    $return_string .='<div enrollment_fee="' . $value['enrollment_fee'] . '" class="enrollment_fee">';
                    if ($value['enrollment_fee'] != "") {
                        $return_string .= toMoney($value['enrollment_fee']) . ' enrollment';
                    } else {
                        $return_string .='$0.00 enrollment';
                    }
                    $return_string .='</div>';
                    $return_string .='<div class="co_pays">';
                    $return_string .='<span class="light">Co-Pay</span>';
                    $return_string .='<span class="dark">';
                    if ($value['co_pays'] != "") {
                        $return_string .= toMoney($value['co_pays']);
                    } else {
                        $return_string .='$0.00';
                    }
                    $return_string .='</span>';
                    $return_string .='</div>';
                    $return_string .='<div class="specialist_co_pay">';
                    $return_string .='<span class="light">Specialist Co-Pay</span>';
                    $return_string .='<span class="dark">';
                    if ($value['specialist_co_pay'] != "") {
                        $return_string .= toMoney($value['specialist_co_pay']);
                    } else {
                        $return_string .='$0.00';
                    }
                    $return_string .='</span>';
                    $return_string .='</div>';
                    $return_string .='<div class="coinsurance">';
                    $return_string .='<span class="light">Coinsurance</span>';
                    $return_string .='<span class="dark">';
                    if ($value['coinsurance'] != "") {
                        $return_string .= $value['coinsurance'] . '%';
                    } else {
                        $return_string .='0%';
                    }
                    $return_string .='</span>';
                    $return_string .='</div>';
                    $return_string .='<div class="deductible_amount">';
                    $return_string .='<span class="light">Deductible</span>';
                    $return_string .='<span class="dark">';
                    if ($value['deductible_amount'] != "") {
                        $return_string .= toMoney($value['deductible_amount']);
                    } else {
                        $return_string .='$0.00';
                    }
                    $return_string .='</span>';
                    $return_string .='</div>';
                    $return_string .='<div class="maximum_out_of_pocket_dis">';
                    $return_string .='<span class="light">OOP Max</span>';
                    $return_string .='<span class="dark">';
                    if ($value['maximum_out_of_pocket'] != "") {
                        $return_string .= toMoney($value['maximum_out_of_pocket']);
                    } else {
                        $return_string .='$0.00';
                    }
                    '</span>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='<div class="portlet-title portlet-title-bottom">';
                    $return_string .='<div class="caption">';
                    $return_string .='<a class="btn btn-default btn-sm" href="javascript:;"> Compare </a>';
                    $return_string .='</div>';
                    $return_string .='<div class="actions">';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                    $return_string .='</div>';
                }
            }
            echo $return_string;
            die;
        }
    }

    /*
     * getProducts is used to get all the products form products tables
     *
     * @param $operation string specify what type of operation is performed on products
     *
     * return
     * 		If $operation == 'add'
     * 			If request is post
     *
     */

    public function getProducts($operation = "getByState") {
        $this->load->model('Products_model');
        $return_string = "";
        $products = array();
        /* if($operation == "getByState")
          {
          $state = $_POST['data'];
          if($state != "")
          {
          $products = $this->Products_model->getProductsByState($state);
          $this->cart->destroy();
          }
          } */

        /* if($operation == "getByStateAndAge")
          {
          $state = $_POST['data'];
          $age = $_POST['data1'];
          if($state != "")
          {
          $products = $this->Products_model->getProductsByStateAndAge($state,$age);
          $this->cart->destroy();
          }
          } */

        /* if($operation == "getByAge")
          {
          $age = $_POST['data'];
          if($age != "")
          {
          $products = $this->Products_model->getProductsByAge($age);
          $this->cart->destroy();
          }
          } */

        /* if($operation == "getByPreexistconditon")
          {
          $pre_exist_condition = $_POST['data'];
          $state = $_POST['data1'];
          $age = $_POST['data2'];
          if($pre_exist_condition != "" && $state != "" && $age != "")
          {
          $products = $this->Products_model->getProductsByPreexistconditon($pre_exist_condition,$state,$age);
          $this->cart->destroy();
          }
          } */

        /* if($operation == "getByPlantype")
          {
          $pre_exist_condition = $_POST['data'];
          $state = $_POST['data1'];
          $age = $_POST['data2'];
          $plan_type = $_POST['data3'];
          if($pre_exist_condition != "" && $state != "" && $age != "" && $plan_type != "")
          {
          $products = $this->Products_model->getProductsByPlantype($pre_exist_condition,$state,$age,$plan_type);
          $this->cart->destroy();
          }
          } */

        if ($operation == "getByFilter") {
            $pre_exist_condition = $_POST['pre_exist_condition'];
            $state = $_POST['state'];
            $age = $_POST['age'];
            $plan_type = $_POST['plan_type'];
            $filter_array = $_POST['filter_array'];
            /* if($pre_exist_condition != "" && $state != "" && $age != "" && $plan_type != "" && !empty($filter_array))
              { */
            $products = $this->Products_model->getProductsByFilter($pre_exist_condition, $state, $age, $plan_type, $filter_array);
            $this->cart->destroy();
            //}
        }

        $return_string .='<div class="row">';
        $return_string .='<div class="col-md-3">';
        $return_string .='<div class="portlet box blue-hoki">';
        $return_string .='<div class="portlet-title">';
        $return_string .='<div class="actions"></div>';
        $return_string .='</div>';
        $return_string .='<div class="portlet-body">';
        $return_string .='<div class="add_new_product">';
        $return_string .='<a herf="javascript:;" data-toggle="modal" data-target=".bs-example-modal-lg" class="click_new_product"><span class="image_add_product"><i aria-hidden="true" class="fa fa-plus-circle"></i></span></a>';
        $return_string .='</div>';
        $return_string .='<div class="add_product_title">Add New Product</div>';
        $return_string .='</div>';
        $return_string .='</div>';
        $return_string .='<div class="portlet-title portlet-title-bottom">';
        $return_string .='<div class="caption"></div>';
        $return_string .='<div class="actions"></div>';
        $return_string .='</div>';
        $return_string .='</div>';
        if (!empty($products)) {
            foreach ($products as $key => $value) {
                $return_string .='<div class="col-md-3">';
                $return_string .='<div class="portlet box blue-hoki">';
                $return_string .='<div class="portlet-title">';
                $return_string .='<div class="actions">';
                $return_string .='<a class="btn btn-default btn-sm add_to_cart" company_name="' . $value['company_name'] . '" enrollment_fee="' . $value['enrollment_fee'] . '" data-id="' . $value['id'] . '" href="javascript:;"> Apply <i class="fa fa-shopping-cart"></i></a>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='<div class="portlet-body">';
                $return_string .='<div class="cbp cbp-caption-active cbp-caption-zoom cbp-ready">';
                $return_string .='<div class="cbp-caption cbp-singlePageInline" data-title="' . $value['product_name'] . '" rel="nofollow">';
                $return_string .='<div class="cbp-caption-defaultWrap">';
                $return_string .='<div class="product_company">';
                if ($value['company_logo'] != "") {
                    $return_string .='<img class="company_logo" src="uploads/company_logo/' . $value['company_logo'] . '" />';
                } else {
                    $return_string .='<img class="company_logo" src="uploads/company_logo/no-photo-available.jpeg" />';
                }
                $return_string .='</div>';
                $return_string .='<div class="product_name">';
                $return_string .='<span class="product_name_span">';
                if ($value['product_name'] != "") {
                    $return_string .= $value['product_name'];
                }
                $return_string .='</span>';
                $return_string .='</div>';
                $return_string .='<div class="product_level">';
                if ($value['product_levels'] != "") {
                    $return_string .= $value['product_levels'];
                }
                $return_string .='</div>';
                $return_string .='<div class="product_price">';
                if ($value['product_price'] != "") {
                    $return_string .= toMoney($value['product_price']) . ' <span class="monthly">/month</span>';
                } else {
                    $return_string .='$0.00 <span class="monthly">/month</span>';
                }
                $return_string .='</div>';
                $return_string .='<div class="pre_check">';
                $return_string .='<div enrollment_fee="' . $value['enrollment_fee'] . '" class="enrollment_fee">';
                if ($value['enrollment_fee'] != "") {
                    $return_string .= toMoney($value['enrollment_fee']) . ' enrollment';
                } else {
                    $return_string .='$0.00 enrollment';
                }
                $return_string .='</div>';
                $return_string .='<div class="co_pays">';
                $return_string .='<span class="light">Co-Pay</span>';
                $return_string .='<span class="dark">';
                if ($value['co_pays'] != "") {
                    $return_string .= toMoney($value['co_pays']);
                } else {
                    $return_string .= '$0.00';
                }
                $return_string .='</span>';
                $return_string .='</div>';
                $return_string .='<div class="specialist_co_pay">';
                $return_string .='<span class="light">Specialist Co-Pay</span>';
                $return_string .='<span class="dark">';
                if ($value['specialist_co_pay'] != "") {
                    $return_string .= toMoney($value['specialist_co_pay']);
                } else {
                    $return_string .= '$0.00';
                }
                $return_string .='</span>';
                $return_string .='</div>';
                $return_string .='<div class="coinsurance">';
                $return_string .='<span class="light">Coinsurance</span>';
                $return_string .='<span class="dark">';
                if ($value['coinsurance'] != "") {
                    $return_string .= $value['coinsurance'] . '%';
                } else {
                    $return_string .= '0%';
                }
                $return_string .='</span>';
                $return_string .='</div>';
                $return_string .='<div class="deductible_amount">';
                $return_string .='<span class="light">Deductible</span>';
                $return_string .='<span class="dark">';
                if ($value['deductible_amount'] != "") {
                    $return_string .= toMoney($value['deductible_amount']);
                } else {
                    $return_string .= '$0.00';
                }
                $return_string .='</span>';
                $return_string .='</div>';
                $return_string .='<div class="maximum_out_of_pocket_dis">';
                $return_string .='<span class="light">OOP Max</span>';
                $return_string .='<span class="dark">';
                if ($value['maximum_out_of_pocket'] != "") {
                    $return_string .= toMoney($value['maximum_out_of_pocket']);
                } else {
                    $return_string .= '$0.00';
                }
                '</span>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='<div class="cbp-caption-activeWrap">';
                $return_string .='<div class="cbp-l-caption-alignLeft">';
                $return_string .='<div class="cbp-l-caption-body">';
                $return_string .='<div class="cbp-l-caption-title">' . $value['product_name'] . ' Overview</div>';
                $return_string .='<div class="cbp-l-caption-desc">';
                if ($value['product_overview'] != "") {
                    $return_string .= $value['product_overview'];
                }
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='<div class="portlet-title portlet-title-bottom">';
                $return_string .='<div class="caption">';
                $return_string .='<a class="btn btn-default btn-sm" href="javascript:;"> Compare </a>';
                $return_string .='</div>';
                $return_string .='<div class="actions">';
                $return_string .='<a data-id="' . $value['id'] . '"  class="btn btn-default btn-sm products_details" href="javascript:;"> Details </a>';
                $return_string .='<div class="fancybox fancy_open_' . $value['id'] . '"> <div class="product_desc_title"> ' . $value['product_name'] . ' Description </div>' . $value['product_description'] . '</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
                $return_string .='</div>';
            }
        } else {
            //$return_string .='<div class="col-md-12"><center> No Record Found </center></div>';
        }
        $return_string .='</div>';
        echo $return_string;
        die;
    }

    /* public function remove_customer_additional_members($id="")
      {
      $this->load->model('Agent_model');
      $this->Agent_model->remove_customer_additional_members($id);
      } */

    /*
     * manage_products is used to perform all functionality related to products
     *
     * @param $operation string specify what type of operation is performed on products
     * @param $id int specify unique id of products
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into products
     */

    public function manage_products($operation = "view", $id = "") {
        $this->load->model('Products_model');
        $this->load->model('Common_model');
        $category_table_name = "category";
        $products_table_name = "products";
        $product_state_table_name = "product_state";
        $company_table_name = "company";
        $limit = "";
        if ($operation == "add") {
            if ($this->input->post()) {
                $post = $this->input->post();
                $this->form_validation->set_rules('product_category', 'Product Category', 'trim|required');
                $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
                $this->form_validation->set_rules('underwriting_company', 'Company', 'trim|required');
                $this->form_validation->set_rules('product_country', 'Country', 'trim|required');
                $this->form_validation->set_rules('product_state_id[]', 'States', 'trim|required');
                $this->form_validation->set_rules('plan_type', 'Plan Type', 'trim|required');
                $this->form_validation->set_rules('product_levels', 'Product Levels', 'trim|required');
                $this->form_validation->set_rules('product_price', 'Product Price', 'trim|required');
                $this->form_validation->set_rules('product_overview', 'Product Overview', 'trim');
                $this->form_validation->set_rules('product_description', 'Product Description', 'trim');
                $this->form_validation->set_rules('product_brochure', 'Product Brochure', 'trim');
                $this->form_validation->set_rules('application_product_information', 'Application Information', 'trim');
                $this->form_validation->set_rules('age_from', 'Age From', 'trim|required');
                $this->form_validation->set_rules('age_to', 'Age To', 'trim|required');
                $this->form_validation->set_rules('height_feet_from', 'Height Feet From', 'trim');
                $this->form_validation->set_rules('height_feet_to', 'Height Feet To', 'trim');
                $this->form_validation->set_rules('height_inches_from', 'Height Inches From', 'trim');
                $this->form_validation->set_rules('height_inches_to', 'Height Inches To', 'trim');
                $this->form_validation->set_rules('weight_from', 'Weight From', 'trim');
                $this->form_validation->set_rules('weight_to', 'Weight To', 'trim');
                $this->form_validation->set_rules('pre_existing_conditions', 'Allow Pre-Existing?', 'trim|required');
                $this->form_validation->set_rules('enrollment_fee', 'Enrollment Fee', 'trim');
                $this->form_validation->set_rules('monthly_payment', 'Monthly Payment', 'trim');
                $this->form_validation->set_rules('co_pays', 'Co-Pay', 'trim');
                $this->form_validation->set_rules('specialist_co_pay', 'Specialist Co-Pay', 'trim');
                $this->form_validation->set_rules('coinsurance', 'Coinsurance', 'trim');
                $this->form_validation->set_rules('deductible_amount', 'Deductible Amount', 'trim');
                $this->form_validation->set_rules('maximum_benefits', 'Maximum Benefits', 'trim');
                $this->form_validation->set_rules('maximum_out_of_pocket', 'Maximum out of pocket', 'trim');
                $this->form_validation->set_rules('is_active', 'Status', 'trim|required');
                $find_array = array("US$ ", "_", ",");
                $replace_array = array("", "", "");
                $file_name = "";
                if ($this->form_validation->run() == TRUE) {
                    $config['upload_path'] = 'uploads/products';
                    $config['allowed_types'] = 'pdf';

                    $this->upload->initialize($config);

                    $file_name = $this->input->post('file_value');

                    if ($this->upload->do_upload('product_brochure')) {
                        $data = $this->upload->data();
                        $file_name = $data['file_name'];
                    }

                    if ($this->input->post('product_id') == "") {
                        $products = array(
                            'category_id' => $post['product_category'],
                            'product_name' => $post['product_name'],
                            'underwriting_company' => $post['underwriting_company'],
                            'state_id' => implode(",", $post['product_state_id']),
                            'product_levels' => $post['product_levels'],
                            'plan_type' => $post['plan_type'],
                            'product_price' => @number_format(str_replace($find_array, $replace_array, $post['product_price']), 2, '.', ''),
                            'product_overview' => $post['product_overview'],
                            'product_description' => $post['product_description'],
                            'product_brochure' => $file_name,
                            'application_information' => @serialize($post['application_product_information']),
                            'age_from' => $post['age_from'],
                            'age_to' => $post['age_to'],
                            'height_feet_from' => $post['height_feet_from'],
                            'height_feet_to' => $post['height_feet_to'],
                            'height_inches_from' => $post['height_inches_from'],
                            'height_inches_to' => $post['height_inches_to'],
                            'weight_from' => $post['weight_from'],
                            'weight_to' => $post['weight_to'],
                            'pre_existing_conditions' => $post['pre_existing_conditions'],
                            'enrollment_fee' => @number_format(str_replace($find_array, $replace_array, $post['enrollment_fee']), 2, '.', ''),
                            'monthly_payment' => @number_format(str_replace($find_array, $replace_array, $post['monthly_payment']), 2, '.', ''),
                            'co_pays' => @number_format(str_replace($find_array, $replace_array, $post['co_pays']), 2, '.', ''),
                            'specialist_co_pay' => @number_format(str_replace($find_array, $replace_array, $post['specialist_co_pay']), 2, '.', ''),
                            'coinsurance' => @str_replace('%', '', $post['coinsurance']),
                            'deductible_amount' => @number_format(str_replace($find_array, $replace_array, $post['deductible_amount']), 2, '.', ''),
                            'maximum_benefits' => @number_format(str_replace($find_array, $replace_array, $post['maximum_benefits']), 2, '.', ''),
                            'maximum_out_of_pocket' => @number_format(str_replace($find_array, $replace_array, $post['maximum_out_of_pocket']), 2, '.', ''),
                            'is_active' => $post['is_active'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'modified_at' => date('Y-m-d H:i:s')
                        );

                        $this->Common_model->add($products, $products_table_name);
                        /* $productid = $this->Common_model->getLastInsertId($products_table_name);
                          if($productid != "")
                          {
                          $product_states = array();
                          foreach($post['product_state_id'] as $state)
                          {
                          $product_state = array();
                          $product_state['product_id'] = $productid;
                          $product_state['state_id'] = $state;
                          $product_states[] = $product_state;
                          }
                          $this->Common_model->multipleadd($product_states,$product_state_table_name);
                          } */
                        $this->session->set_flashdata('msg', 'Product is successfully inserted.');
                    } else {
                        $products = array(
                            'category_id' => $post['product_category'],
                            'product_name' => $post['product_name'],
                            'underwriting_company' => $post['underwriting_company'],
                            'state_id' => implode(",", $post['product_state_id']),
                            'product_levels' => $post['product_levels'],
                            'plan_type' => $post['plan_type'],
                            'product_price' => @number_format(str_replace($find_array, $replace_array, $post['product_price']), 2, '.', ''),
                            'product_overview' => $post['product_overview'],
                            'product_description' => $post['product_description'],
                            'product_brochure' => $file_name,
                            'application_information' => @serialize($post['application_product_information']),
                            'age_from' => $post['age_from'],
                            'age_to' => $post['age_to'],
                            'height_feet_from' => $post['height_feet_from'],
                            'height_feet_to' => $post['height_feet_to'],
                            'height_inches_from' => $post['height_inches_from'],
                            'height_inches_to' => $post['height_inches_to'],
                            'weight_from' => $post['weight_from'],
                            'weight_to' => $post['weight_to'],
                            'pre_existing_conditions' => $post['pre_existing_conditions'],
                            'enrollment_fee' => @number_format(str_replace($find_array, $replace_array, $post['enrollment_fee']), 2, '.', ''),
                            'monthly_payment' => @number_format(str_replace($find_array, $replace_array, $post['monthly_payment']), 2, '.', ''),
                            'co_pays' => @number_format(str_replace($find_array, $replace_array, $post['co_pays']), 2, '.', ''),
                            'specialist_co_pay' => @number_format(str_replace($find_array, $replace_array, $post['specialist_co_pay']), 2, '.', ''),
                            'coinsurance' => @str_replace('%', '', $post['coinsurance']),
                            'deductible_amount' => @number_format(str_replace($find_array, $replace_array, $post['deductible_amount']), 2, '.', ''),
                            'maximum_benefits' => @number_format(str_replace($find_array, $replace_array, $post['maximum_benefits']), 2, '.', ''),
                            'maximum_out_of_pocket' => @number_format(str_replace($find_array, $replace_array, $post['maximum_out_of_pocket']), 2, '.', ''),
                            'is_active' => $post['is_active'],
                            'modified_at' => date('Y-m-d H:i:s')
                        );

                        $this->Common_model->edit($post['product_id'], $products, $products_table_name);
                        //$update_status =
                        /* if($update_status == 1)
                          {
                          $product_states = array();
                          foreach($post['product_state_id'] as $state)
                          {
                          $product_state = array();
                          $product_state['product_id'] = $post['product_id'];
                          $product_state['state_id'] = $state;
                          $product_states[] = $product_state;
                          }
                          $this->Products_model->update_state($product_states,$post['product_id']);
                          } */
                        $this->session->set_flashdata('msg', 'Product is successfully updated.');
                    }
                }
                redirect('products/manage_products/view');
            } else {
                $this->load->model('Company_model');
                $this->data['title'] = 'Add Product';
                $this->data['country'] = $this->manage_country('getAll');
                $this->data['company'] = $this->Company_model->getAll();
                $this->data['categories'] = $this->Common_model->viewAll($category_table_name, $limit);
                $this->template->load("admin", "product/add_product", $this->data);
            }
        } else if ($operation == 'delete') {
            $this->load->model('Company_model');
            if ($this->Products_model->delete($id)) {
                $this->data['title'] = 'View Products';
                $this->data['products'] = $this->Products_model->getAll();
                $this->data['company'] = $this->Company_model->getAll();
                $this->data['categories'] = $this->Common_model->viewAll($category_table_name, $limit);
                $this->session->set_flashdata('msg', 'Product is successfully deleted.');
                $this->template->load("admin", "product/view_products", $this->data);
            } else {
                return false;
            }
        } else if ($operation == 'view') {
            $this->load->model('Company_model');
            $this->data['title'] = 'View Products';
            $this->data['products'] = $this->Products_model->getAll();
            $this->data['company'] = $this->Company_model->getAll();
            $this->data['categories'] = $this->Common_model->viewAll($category_table_name, $limit);
            $this->template->load("admin", "product/view_products", $this->data);
        } else if ($operation == 'edit') {
            $this->load->model('Company_model');
            $this->data['title'] = 'Edit Products';
            $this->data['products'] = $this->Products_model->getById($id);
            $this->data['country'] = $this->manage_country('getAll');
            $this->data['company'] = $this->Company_model->getAll();
            $this->data['categories'] = $this->Common_model->viewAll($category_table_name, $limit);
            $this->template->load("admin", "product/add_product", $this->data);
        } else if ($operation == 'product_info') {
            $this->load->model('Company_model');
            $this->data['title'] = 'Product Information';
            $this->data['products'] = $this->Products_model->getProductInfo($id);
            $this->data['country'] = $this->manage_country('getAll');
            $this->data['company'] = $this->Company_model->getAll();
            $this->data['categories'] = $this->Common_model->viewAll($category_table_name, $limit);
            $this->template->load("admin", "product/product_info", $this->data);
        } else if ($operation == 'filter_option') {
            if ($id == "deductible") {
                $filter_option_array = array('text' => "Deductible");
                $product_min_max = $this->Products_model->getAllDeductibleFilterArray();
                $product_min_value = 0.00;
                $product_max_value = 0.00;
                foreach ($product_min_max[0] as $key => $value) {
                    if (floatval($product_min_value) > floatval($value)) {
                        $product_min_value = floatval($value);
                    }
                    if (floatval($product_max_value) < floatval($value)) {
                        $product_max_value = floatval($value);
                    }
                }
                $range_array = $this->range_calculate($product_min_value, $product_max_value, $increment = 500, $value_format = "price");


                $filter_option_array['children'] = $range_array;
                echo json_encode(array($filter_option_array));
                die;
            } else if ($id == "maxbenefits") {
                $filter_option_array = array('text' => "Max Benefits");
                $product_min_max = $this->Products_model->getAllMaxbenefitsFilterArray();
                $product_min_value = 0.00;
                $product_max_value = 0.00;
                foreach ($product_min_max[0] as $key => $value) {
                    if (floatval($product_min_value) > floatval($value)) {
                        $product_min_value = floatval($value);
                    }
                    if (floatval($product_max_value) < floatval($value)) {
                        $product_max_value = floatval($value);
                    }
                }
                $range_array = $this->range_calculate($product_min_value, $product_max_value, $increment = 50000, $value_format = "price");


                $filter_option_array['children'] = $range_array;
                echo json_encode(array($filter_option_array));
                die;
            } else if ($id == "coinsurance") {
                $filter_option_array = array('text' => "Coinsurance");
                $product_min_max = $this->Products_model->getAllCoinsuranceFilterArray();
                $product_min_value = 0.00;
                $product_max_value = 0.00;
                foreach ($product_min_max[0] as $key => $value) {
                    if (floatval($product_min_value) > floatval($value)) {
                        $product_min_value = floatval($value);
                    }
                    if (floatval($product_max_value) < floatval($value)) {
                        $product_max_value = floatval($value);
                    }
                }
                $range_array = $this->range_calculate($product_min_value, $product_max_value, $increment = 10, $value_format = "percentage");

                $filter_option_array['children'] = $range_array;
                echo json_encode(array($filter_option_array));
                die;
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
     * prodcut_state is used to perform all functionality related to product state
     *
     * @param $operation string specify what type of operation is performed on state table
     * @param $id int specify unique id of country id
     *
     * return
     *      if $operation == 'getByCountryId'
     *          return string of state for specific country in option tag
     */

    public function prodcut_pagination() {
        $this->load->model('Products_model');
        $order_column = $_REQUEST['order'][0]['column'];
        $order_by = $_REQUEST['order'][0]['dir'];
        $order_column_name = "";
        foreach ($_REQUEST['columns'] as $key => $value) {
            if ($value['data'] == $order_column) {
                $order_column_name = $value['name'];
            }
        }

        if (isset($_REQUEST['customActionType']) && $_REQUEST['customActionType'] != "") {
            $customActionName = $_REQUEST['customActionName'];
            $this->data['products'] = $this->Products_model->getAllProductByStatus($customActionName);
        } elseif (isset($_REQUEST['action']) && $_REQUEST['action'] != "" && $_REQUEST['action'] == "filter") {
            if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != "") {
                $search_array['products.id'] = "'" . $_REQUEST['product_id'] . "'";
            }
            if (isset($_REQUEST['product_category']) && $_REQUEST['product_category'] != "") {
                $search_array['products.category_id'] = "'" . $_REQUEST['product_category'] . "'";
            }
            if (isset($_REQUEST['product_name']) && $_REQUEST['product_name'] != "") {
                $search_array['products.product_name'] = "'" . $_REQUEST['product_name'] . "'";
            }
            if (isset($_REQUEST['product_company']) && $_REQUEST['product_company'] != "") {
                $search_array['company.company_name'] = "'" . $_REQUEST['product_company'] . "'";
            }
            if (isset($_REQUEST['product_levels']) && $_REQUEST['product_levels'] != "") {
                $search_array['products.product_levels'] = "'" . $_REQUEST['product_levels'] . "'";
            }
            if (isset($_REQUEST['plan_type']) && $_REQUEST['plan_type'] != "") {
                $search_array['products.plan_type'] = "'" . $_REQUEST['plan_type'] . "'";
            }
            if (isset($_REQUEST['product_price_from']) && $_REQUEST['product_price_from'] != "") {
                $search_array1['products.product_price'] = "'" . $_REQUEST['product_price_from'] . "'";
            }
            if (isset($_REQUEST['product_price_to']) && $_REQUEST['product_price_to'] != "") {
                $search_array2['products.product_price'] = "'" . $_REQUEST['product_price_to'] . "'";
            }
            if (isset($_REQUEST['product_age_from']) && $_REQUEST['product_age_from'] != "") {
                $search_array1['products.age_from'] = "'" . $_REQUEST['product_age_from'] . "'";
            }
            if (isset($_REQUEST['product_age_to']) && $_REQUEST['product_age_to'] != "") {
                $search_array2['products.age_to'] = "'" . $_REQUEST['product_age_to'] . "'";
            }
            if (isset($_REQUEST['product_created_from']) && $_REQUEST['product_created_from'] != "") {
                $search_array1['products.created_at'] = "'" . $_REQUEST['product_created_from'] . "'";
            }
            if (isset($_REQUEST['product_created_to_']) && $_REQUEST['product_created_to_'] != "") {
                $search_array2['products.created_at'] = "'" . $_REQUEST['product_created_to_'] . "'";
            }
            if (isset($_REQUEST['product_status']) && $_REQUEST['product_status'] != "") {
                $search_array['products.is_active'] = "'" . $_REQUEST['product_status'] . "'";
            }
            if ($search_array != "" || $search_array1 != "" || $search_array2 != "") {
                if (isset($search_array) && $search_array != "") {
                    $output = implode(' and ', array_map(
                                    function ($v, $k) {
                                return $k . ' = ' . $v;
                            }, $search_array, array_keys($search_array)
                    ));
                }
                if (isset($search_array1) && $search_array1 != "") {
                    if ($search_array != "") {
                        $output1 = " and ";
                    }
                    $output1 .= implode(' and ', array_map(
                                    function ($v, $k) {
                                return $k . ' >= ' . $v;
                            }, $search_array1, array_keys($search_array1)
                    ));
                }
                if (isset($search_array2) && $search_array2 != "") {
                    if ($search_array1 != "") {
                        $output2 = " and ";
                    }

                    $output2 .= implode(' and ', array_map(
                                    function ($v, $k) {
                                return $k . ' <= ' . $v;
                            }, $search_array2, array_keys($search_array2)
                    ));
                }
                $final_string = "";
                if ($output != "") {
                    $final_string .= $output;
                }
                if ($output1 != "") {
                    $final_string .= $output1;
                }
                if ($output1 != "") {
                    $final_string .= $output2;
                }
                $this->data['products'] = $this->Products_model->getAllProductByParameters($final_string);
            } else {
                $this->data['products'] = $this->Products_model->getAll();
            }
        } elseif ($order_column_name != "" && $order_by != "") {
            $this->data['products'] = $this->Products_model->getAllOrderBy($order_column_name, $order_by);
        } else {
            $this->data['products'] = $this->Products_model->getAll();
        }

        $iTotalRecords = count($this->data['products']);
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $status_list = array(
            array("default" => "Publushed"),
            array("default" => "Not Published"),
            array("default" => "Deleted")
        );
        $count = $iDisplayStart + 1;
        if ($iDisplayStart == 0) {
            $count = 1;
        }
        for ($i = $iDisplayStart; $i < $end; $i++) {
            if ($this->data['products'][$i]['is_active'] == 1) {
                $is_active = "Published";
            } else {
                $is_active = "Not Published";
            }
            $records["data"][] = array(
                '<input type="checkbox" value="' . $this->data['products'][$i]['id'] . '" name="id[]">',
                $count++,
                $this->data['products'][$i]['category_name'],
                $this->data['products'][$i]['product_name'],
                $this->data['products'][$i]['company_name'],
                $this->data['products'][$i]['product_levels'],
                toMoney($this->data['products'][$i]['product_price']),
                $this->data['products'][$i]['age_from'] . " to " . $this->data['products'][$i]['age_to'],
                //$dt->format('m/d/Y'),
                '<span class="label label-sm label-default">' . $is_active . '</span>',
                '<a href="' . site_url('products/manage_products/product_info/' . $this->data['products'][$i]['id']) . '" id="' . $this->data['products'][$i]['id'] . '" title="Information" class="info">
                            <span class="fa fa-info"></span>
                        </a>&nbsp;&nbsp;
                        <a style="text-decoration: none !important;" href="' . site_url('products/manage_products/edit/' . $this->data['products'][$i]['id']) . '">
                            <i class="fa  fa-pencil-square-o" aria-hidden="true"></i>
                        </a>&nbsp;&nbsp;
                        <a href="javascript:;" id="' . $this->data['products'][$i]['id'] . '" title="Delete" class="delete">
                            <span class="fa fa-trash"></span>
                        </a>'
            );
        }

        /* foreach ($this->data['products'] as $key => $value)
          {
          //$dt = new DateTime($value['created_at']);
          if($value['is_active'] == 1)
          {
          $is_active = "Published";
          }
          else
          {
          $is_active = "Not Published";
          }
          $records["data"][] = array(
          '<input type="checkbox" value="'.$value['id'].'" name="id[]">',
          $value['id'],
          $value['category_name'],
          $value['product_name'],
          $value['company_name'],
          $value['product_levels'],
          toMoney($value['product_price']),
          $value['age_from']." to ".$value['age_to'],
          //$dt->format('m/d/Y'),
          '<span class="label label-sm label-default">'.$is_active.'</span>',
          '<a href="'.site_url('products/manage_products/product_info/'.$value['id']).'" id="'.$value['id'].'" title="Information" class="info">
          <span class="fa fa-info"></span>
          </a>&nbsp;&nbsp;
          <a style="text-decoration: none !important;" href="'.site_url('products/manage_products/edit/'.$value['id']).'">
          <i class="fa  fa-pencil-square-o" aria-hidden="true"></i>
          </a>&nbsp;&nbsp;
          <a href="javascript:;" id="'.$value['id'].'" title="Delete" class="delete">
          <span class="fa fa-trash"></span>
          </a>'
          );
          } */

        if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }

    /*
     * prodcut_state is used to perform all functionality related to product state
     *
     * @param $operation string specify what type of operation is performed on state table
     * @param $id int specify unique id of country id
     *
     * return
     *      if $operation == 'getByCountryId'
     *          return string of state for specific country in option tag
     */

    public function prodcut_state($operation = "", $id = "") {
        $this->load->model('State_model');
        if ($operation == "getByCountryId") {
            $count_state = count($this->State_model->getStateByCountryId($id));
            $str = "";
            if ($count_state != 0) {
                $i = 0;
                foreach ($this->State_model->getStateByCountryId($id) as $value) {
                    if ($i == 0 || $i % 12 == 0) {
                        $str .="<div class='col-md-3'>";
                    }
                    $str .="<label style='width:100%;'>";
                    $str .="<input type='checkbox' class='state state-" . $value['abbreviation'] . "' data-state='" . $value['abbreviation'] . "' name='product_state_id[]' value=" . $value['id'] . " id='" . $value['abbreviation'] . "' data-title='' />";
                    $str .="<span> " . $value['name'] . " </span>";
                    $str .="</label>";
                    $i++;
                    if ($i % 12 == 0) {
                        $str .="</div>";
                    }
                }
            }
            echo $str;
            return;
        }
    }

    public function range_calculate($product_min_value, $product_max_value, $increment, $value_format) {
        $range_array = range($product_min_value, $product_max_value, $increment);
        $deductible_array = array();
        if ($value_format == "price") {
            for ($i = 0; $i < count($range_array); $i++) {
                if ($i == 0) {
                    $deductible_array[] = array("text" => '$' . $range_array[$i] . ' - $' . $range_array[$i + 1], 'id' => $range_array[$i] . ' - ' . $range_array[$i + 1]);
                } else if ($i == count($range_array) - 1) {
                    $deductible_array[] = array("text" => '$' . ($range_array[$i] + 1) . ' - Above', 'id' => ($range_array[$i] + 1) . ' - Above');
                } else {
                    $deductible_array[] = array("text" => '$' . ($range_array[$i] + 1) . ' - $' . $range_array[$i + 1], 'id' => ($range_array[$i] + 1) . ' - ' . $range_array[$i + 1]);
                }
            }
        } else {
            for ($i = 0; $i < count($range_array); $i++) {
                if ($i == 0) {
                    $deductible_array[] = array("text" => $range_array[$i] . '% - ' . $range_array[$i + 1] . '%', 'id' => $range_array[$i] . ' - ' . $range_array[$i + 1]);
                } else if ($i == count($range_array) - 1) {
                    if ($range_array[$i] + 1 < 100) {
                        $deductible_array[] = array("text" => ($range_array[$i] + 1) . '% - Above', 'id' => ($range_array[$i] + 1) . ' - Above');
                    } else {
                        //$deductible_array[] = array("text" => ($range_array[$i]+1).'%','id' => ($range_array[$i]+1));
                    }
                } else {
                    $deductible_array[] = array("text" => ($range_array[$i] + 1) . '% - ' . $range_array[$i + 1] . '%', 'id' => ($range_array[$i] + 1) . ' - ' . $range_array[$i + 1]);
                }
            }
        }
        return $deductible_array;
    }

}
