<?php
/**
 * Description of ImportExportProducts
 *
 * @author Meet
 */
class Importexportproducts extends CI_Controller
{
	public $data = array();
    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata("user"))
        {
            redirect('login');
        }
        else
        {

        }
    }

    public function manage_products_csv($operation="view")
    {
        if($operation == "import")
        {
            $this->load->model('Common_model');
            $this->load->model('Products_model');
            $table_name_category = "category";
            $table_name_comapnay = "company";
            $table_name_state = "state";
            $table_name_products = "products";
            $limit = "";
            if(isset($_POST['submit']) && $_POST['submit'])
            {
                if(isset($_FILES['products_csv']))
                {
                      $errors= array();
                      $file_name = $_FILES['products_csv']['name'];
                      $file_size = $_FILES['products_csv']['size'];
                      $file_tmp = $_FILES['products_csv']['tmp_name'];
                      $file_type = $_FILES['products_csv']['type'];
                      $file_ext = strtolower(end(explode('.',$_FILES['products_csv']['name'])));

                      $expensions = array("csv");

                      if(in_array($file_ext,$expensions) === false)
                      {
                         $errors[] = "extension not allowed, please choose a CSV or Excel file.";
                      }
                      $upload_path = 'uploads/products/csv/import';
                      $new_name = date("Y_m_d_h_i_sa").'_'.$file_name;

                      if(empty($errors)==true)
                      {
                        move_uploaded_file($file_tmp,$upload_path.'/'.$new_name);
                        $categories_array = $this->Common_model->viewAll($table_name_category,$limit);
                        $result_categories_array = array_column($categories_array, 'category_name', 'id');


                        $company_array = $this->Common_model->viewAll($table_name_comapnay,$limit);
                        $result_company_array = array_column($company_array, 'company_name', 'id');

                        $state_array = $this->Common_model->viewAll($table_name_state,$limit);
                        $result_state_array = array_column($state_array, 'name', 'id');

                        $file_path =  $upload_path.'/'.$new_name;

                        if ($this->csvimport->get_array($file_path))
                        {
                            $csv_array = $this->csvimport->get_array($file_path);
                            foreach ($csv_array as $row)
                            {
                                $category_id = array_search($row['category_name'], $result_categories_array);
                                $company_id = array_search($row['company_name'], $result_company_array);
                                $explode_state = explode(',', $row['states']);
                                $state_id_array = array();
                                $plan_type = "";
                                $application_information = "";
                                $is_active = "";
                                foreach ($explode_state as $key => $value)
                                {
                                    $state_id_array[] = array_search($value, $result_state_array);
                                }
                                if($row['plan_type'] == "Single" || $row['plan_type'] == "single")
                                {
                                    $plan_type = "single";
                                }
                                else if($row['plan_type'] == "Single+Spouse" || $row['plan_type'] == "single_spouse")
                                {
                                    $plan_type = "single_spouse";
                                }
                                else if($row['plan_type'] == "Single+Child" || $row['plan_type'] == "single_child")
                                {
                                    $plan_type = "single_child";
                                }
                                else if($row['plan_type'] == "Family" || $row['plan_type'] == "family")
                                {
                                    $plan_type = "family";
                                }
                                else if($row['plan_type'] == "All" || $row['plan_type'] == "all")
                                {
                                    $plan_type = "all";
                                }
                                if($row['application_information'] != "")
                                {
                                    $application_information = serialize($row['application_information']);
                                }
                                if($row['is_active'] != "" && ($row['is_active'] == "Published" || $row['is_active'] == "published" || $row['is_active'] == 1))
                                {
                                    $is_active = 1;
                                }
                                else
                                {
                                    $is_active = 2;
                                }
                                $state_ids = implode(',',$state_id_array);
                                $data = array(
                                    'category_id' => $category_id,
                                    'product_name' => $row['product_name'],
                                    'underwriting_company' => $company_id,
                                    'state_id' => $state_ids,
                                    'product_levels' => $row['product_levels'],
                                    'plan_type' => $plan_type,
                                    'product_price' => $row['product_price'],
                                    'product_overview' => $row['product_overview'],
                                    'product_description' => $row['product_description'],
                                    'product_brochure' => $row['product_brochure'],
                                    'application_information' => $application_information,
                                    'age_from' => $row['age_from'],
                                    'age_to' => $row['age_to'],
                                    'height_feet_from' => $row['height_feet_from'],
                                    'height_feet_to' => $row['height_feet_to'],
                                    'height_inches_from' => $row['height_inches_from'],
                                    'height_inches_to' => $row['height_inches_to'],
                                    'weight_from' => $row['weight_from'],
                                    'weight_to' => $row['weight_to'],
                                    'pre_existing_conditions' => $row['pre_existing_conditions'],
                                    'enrollment_fee' => $row['enrollment_fee'],
                                    'monthly_payment' => $row['monthly_payment'],
                                    'co_pays' => $row['co_pays'],
                                    'specialist_co_pay' => $row['specialist_co_pay'],
                                    'coinsurance' => $row['coinsurance'],
                                    'deductible_amount' => $row['deductible_amount'],
                                    'maximum_benefits' => $row['maximum_benefits'],
                                    'maximum_out_of_pocket' => $row['maximum_out_of_pocket'],
                                    'is_active' => $is_active,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'modified_at' => date('Y-m-d H:i:s'),
                                );

                                if(isset($row['id']) && $row['id'] != "")
                                {
                                    unset($data['created_at']);
                                    $this->Common_model->edit($row['id'],$data,$table_name_products);
                                }
                                else
                                {
                                    $this->Common_model->add($data,$table_name_products);
                                }
                            }
                            $products_data = $this->Products_model->getAll();
                            $return_string = "";
                            foreach ($products_data as $key => $value)
                            {
                                $return_string .= "<tr class='odd gradeX'>";
                                $return_string .= "<td>".($key + 1)."</td>";
                                $return_string .= "<td>".$value['category_name']."</td>";
                                $return_string .= "<td>".$value['product_name']."</td>";
                                $return_string .= "<td>".$value['company_name']."</td>";
                                $return_string .= "<td>".$value['product_levels']."</td>";
                                $return_string .= "<td>".toMoney($value['product_price'])."</td>";
                                $return_string .= "</tr>";
                            }
                            echo $return_string;
                            die;
                        }
                        else
                        {
                            $data['error'] = "Error occured";
                            $this->template->load("admin","product/import_export_product",$this->data);
                        }
                      }
                      else
                      {
                         print_r($errors);
                      }
                }
            }
            else
            {
                $this->data['title'] = 'Import Products CSV';
                $this->template->load("admin","product/import_export_product",$this->data);
            }
        }
        else if($operation == "export")
        {
            /*$query = $this->db->query('SELECT * FROM products');
            $num = $query->num_fields();
            $var = array();
            $i = 1;
            $fname = "";
            while($i <= $num)
            {
                $test = $i;
                $value = $this->input->post($test);
                echo $value;
                if($value != '')
                {
                    $fname = $fname." ".$value;
                    array_push($var, $value);
                }
                $i++;
            }

            $fname = trim($fname);

            $fname = str_replace(' ', ',', $fname);*/

            $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,country.name AS country_name,group_concat(state.name separator  ',') AS states FROM products
                LEFT JOIN state ON state.id IN (products.state_id)
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN country ON country.id = state.country_id group by products.id");
           $result = $prodcuts->result_array();
           $final_array = array();
           foreach ($result as $key => $value)
           {
               unset($value['category_id']);
               unset($value['underwriting_company']);
               $arrayvalue = array();
               if($value['is_active'] == 1)
               {
                 $value['is_active'] = "Published";
               }
               else
               {
                 $value['is_active'] = "Not Published";
               }
               if($value['application_information'] != "")
               {
                 $value['application_information'] = unserialize($value['application_information']);
               }
               if($value['state_id'] != "")
               {
                   foreach (explode(',',$value['state_id']) as $key1 => $value1)
                   {
                      $arrayvalue[] = $this->db->query("SELECT name FROM state WHERE id = $value1")->row()->name;
                   }
                   $value['states'] = implode(',',$arrayvalue);
               }
                unset($value['state_id']);
                $final_array[] = $value;
           }
        array_to_csv($final_array,TRUE,'Products_'.date('m_d_y_h_i_s_a').'.csv');
        }
    }
}
