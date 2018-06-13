<?php
/**
 * Description of ImportExportProducts_model
 *
 * @author Meet
 */
class ImportExportProducts_model extends CI_Model
{    
    public $filter_query = "";
    public $state = "";
    /*
     * getAll is used to retrive all record of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getAll()
    {
        try
        {                    
            
            $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN state ON state.id = product_state.state_id group by products.id");        
            return $prodcuts->result_array();            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * insert is used to insert single record of product in prodcuts table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function insert($arr)
    {
        try
        {
            $this->db->insert("products",$arr);
            return $this->db->insert_id();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * insert_batch is used to insert multiple record of products_state in product_state table of database
     * 
     * @param $arr[][] array key and value field as database field and its value
     * 
     * return : bool true if record inserted
     *          bool false if not inserted
     */
    public function insert_batch($arr)
    {
        try
        {
            $this->db->insert_batch("product_state",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }    

    /*
     * getAllProductByStatus is used to retrive all record by product status of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getAllProductByStatus($customActionName)
    {
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN state ON state.id = product_state.state_id WHERE products.is_active = ".$customActionName." GROUP BY products.id");        
            return $prodcuts->result_array();            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getAllProductByStatus is used to retrive all record by product status of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getAllProductByParameters($search_string)
    {
        try
        {      
            if(isset($search_string) && $search_string != "")
            {
                $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN state ON state.id = product_state.state_id WHERE ".$search_string." GROUP BY products.id");            
            }   
            else
            {
                $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN state ON state.id = product_state.state_id GROUP BY products.id");            
            }                           
            return $prodcuts->result_array();            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getById is used to retrive record by perticular id of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getById($id="")
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids,country.name AS country_name,country.id AS country_id FROM products
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN state ON state.id = product_state.state_id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN country ON country.id = state.country_id WHERE products.id = ".$id." group by products.id");        
           return $prodcuts->row();                
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * delete is used to delete single record of products based on product id
     * 
     * @param $id int primary key of agency table
     *
     * return true if record is deleted
     *        false on failure
     */
    public function delete($id)
    {
        try
        {
            
            return $this->db->query("DELETE p, pa FROM products p JOIN product_state pa ON pa.product_id = p.id WHERE p.id=".$id);                    
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


    /*
     * update is used to update single record of product in prodcuts table of database
     * 
     * @param $arr array key and value field as database field and its value
     * @param $id field as product id

     * return : bool true if successfully updated
     *          bool false if not inserted
     */
    public function update($arr,$product_id)
    {
        try
        {
            $this->db->where('id',$product_id);
            return $this->db->update('products',$arr);                            
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * update is used to update single record of product in product_state tables of database
     * 
     * @param $arr array key and value field as database field and its value
     * @param $id field as product id
     * return : bool true if successfully updated
     *          bool false if not inserted
     */
    public function update_state($arr,$product_id)
    {
        try
        {
            $this->db->where('product_id', $product_id);
            $this->db->delete('product_state');            
            $this->db->insert_batch("product_state",$arr);
            return true;             
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * getProductsByState is used to retrive all record by product state of products table
     * 
     * return two dimensional array in the form of array
     */
    /*public function getProductsByState($state)
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                JOIN product_state ON product_state.product_id = products.id
                JOIN company ON company.id = products.underwriting_company
                JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 group by products.id");        
            return $prodcuts->result_array();                        
        }
        catch(Exception $e)
        {
            return false;
        }
    }*/

    /*
     * getProductsByStateAndAge is used to retrive all record by product state of products table
     * 
     * return two dimensional array in the form of array
     */
    /*public function getProductsByStateAndAge($state,$age)
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                JOIN product_state ON product_state.product_id = products.id
                JOIN company ON company.id = products.underwriting_company
                JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' group by products.id");        
            return $prodcuts->result_array();                        
        }
        catch(Exception $e)
        {
            return false;
        }
    }*/

    /*
     * getProductsByStateAndAge is used to retrive all record by product state of products table
     * 
     * return two dimensional array in the form of array
     */
    /*public function getProductsByAge($age)
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                JOIN product_state ON product_state.product_id = products.id
                JOIN company ON company.id = products.underwriting_company
                JOIN state ON state.id = product_state.state_id WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' group by products.id");        
            return $prodcuts->result_array();                        
        }
        catch(Exception $e)
        {
            return false;
        }
    }*/

    /*
     * getProductsByPreexistconditon is used to retrive all record by product Pre exist conditon  of products table
     * 
     * return two dimensional array in the form of array
     */
    /*public function getProductsByPreexistconditon($pre_exist_condition,$state,$age)
    {                
        if($pre_exist_condition == "yes")
        {
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' and pre_existing_conditions != 'no' group by products.id");
    
                    return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            }    
        }
        else
        {
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' group by products.id");                                
    
                    return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            } 
        }                                    
    }*/

    /*
     * getProductsByPlantype is used to retrive all record by product Plan type  of products table
     * 
     * return two dimensional array in the form of array
     */
    /*public function getProductsByPlantype($pre_exist_condition,$state,$age,$plan_type)
    {                
        if($pre_exist_condition == "yes")
        {
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' and pre_existing_conditions != 'no' and (plan_type = '".$plan_type."' || plan_type = 'All') group by products.id");
    
                    return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            }    
        }
        else
        {            
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id and state.name = '".$state."' WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' and (plan_type = '".$plan_type."' || plan_type = 'All') group by products.id");                                
    
                    return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            } 
        }                                    
    }*/

    /*
     * getProductsByProductType is used to retrive all record by product Plan type  of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getProductsByFilter($pre_exist_condition,$state,$age,$plan_type,$filter_array)
    {                                
        /*echo '<pre>';
        print_r($filter_array[0]);
        echo '</pre>';
        die;*/
        if($pre_exist_condition != "")
        {
            if($pre_exist_condition == "yes")
            {
                $this->filter_query .= " and pre_existing_conditions != 'no'";
            }            
        }
        if($state != "")
        {
            $this->state .= " and state.name = '".$state."'";
        }
        if($age != "" && intval($age) > 0)
        {
            $this->filter_query .= " and age_from <= '".$age."' and age_to >= '".$age."'";
        }
        if($plan_type != "")
        {
            $this->filter_query .= " and (plan_type = '".$plan_type."' || plan_type = 'All')";
        }        
        if(!empty($filter_array[0]['category_id']))
        {
            $this->filter_query .= " and category_id IN (".implode(',',$filter_array[0]['category_id']).")";
        }
        if(!empty($filter_array[0]['underwriting_company']))
        {
            $this->filter_query .= " and underwriting_company IN (".implode(',',$filter_array[0]['underwriting_company']).")";
        }
        if(!empty($filter_array[0]['deductible_amount']))
        {
            $this->filter_query .= " and ";
            $this->check_multiplevalues_checkbox($filter_array[0]['deductible_amount'],'deductible_amount');                    
        }
        if(!empty($filter_array[0]['maximum_benefits']))
        {
            $this->filter_query .= " and ";
            $this->check_multiplevalues_checkbox($filter_array[0]['maximum_benefits'],'maximum_benefits');                    
        }
        if(!empty($filter_array[0]['coinsurance']))
        {
            $this->filter_query .= " and ";
            $this->check_multiplevalues_checkbox($filter_array[0]['coinsurance'],'coinsurance');                    
        }        
        /*echo '<pre>';
        print_r($this->filter_query);
        echo '</pre>';
        die;*/
        /*if($pre_exist_condition == "yes")
        {*/
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id ".$this->state." WHERE is_active = 1 ".$this->filter_query." group by products.id");
                /*echo '<pre>';
                print_r($this->db->last_query());
                die;*/
                return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            }    
        /*}
        else
        {            
            try
            {                                
                $prodcuts = $this->db->query("SELECT products.*,company.company_name,company.company_logo,group_concat(state.name separator',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids FROM products                
                    JOIN product_state ON product_state.product_id = products.id                 
                    JOIN company ON company.id = products.underwriting_company
                    JOIN state ON state.id = product_state.state_id ".$this->state." WHERE is_active = 1 and age_from <= '".$age."' and age_to >= '".$age."' and (plan_type = '".$plan_type."' || plan_type = 'All') ".$this->filter_query." group by products.id");                                
    
                    return $prodcuts->result_array();                        
            }
            catch(Exception $e)
            {
                return false;
            } 
        }*/                                    
    }
    /*
     * getAgencyInfo is used to retrive record by perticular id of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getProductInfo($id="")
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT products.*,category.category_name,company.company_name,company.company_logo,group_concat(state.name separator  ',') AS product_states_names,group_concat(state.id separator  ',') AS product_states_ids,country.name AS country_name,country.id AS country_id FROM products
                LEFT JOIN product_state ON product_state.product_id = products.id
                LEFT JOIN state ON state.id = product_state.state_id
                LEFT JOIN company ON company.id = products.underwriting_company
                LEFT JOIN category ON category.id = products.category_id
                LEFT JOIN country ON country.id = state.country_id WHERE products.id = ".$id." group by products.id");        
           return $prodcuts->row();                
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getById is used to retrive record by perticular id of products table
     * 
     * return two dimensional array in the form of array
     */
    public function getTempProductById($id="")
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT * FROM temp_agent_product WHERE id = ".$id." and is_active=1");        
            return $prodcuts->row();                
        }
        catch(Exception $e)
        {
            return false;
        }
    }
       
    public function disableProducts($id="")
    {               
        try
        {                                
            return $this->db->query("UPDATE temp_agent_product SET is_active = 2 WHERE agent_id = ".$id);                    
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function enableProducts($id="")
    {               
        try
        {                                
            return $this->db->query("UPDATE temp_agent_product SET is_active = 1 WHERE agent_id = ".$id);                    
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function enableProductsByCustomer($id="")
    {               
        try
        {                                
            $id = decode_url($id);
            //return $this->db->query("UPDATE temp_agent_product SET is_active = 1 WHERE agent_id = ".$id);                                                                    
            $this->db->join('customers','customers.agent_id = temp_agent_product.agent_id' and 'customers.id ='.$id);
            $this->db->join('agents','agents.id = temp_agent_product.agent_id');
            $this->db->join('agencies','agencies.id = agents.agency_id');
            $this->db->set('temp_agent_product.is_active',1);                        
            $this->db->update('temp_agent_product');
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }


     /*
     * agent_add_product is used to insert single record of agency in agents table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function agent_add_product($arr)
    {
        try
        {
            $this->db->insert("temp_agent_product",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * temp_agent_product is used to retrive all records of customers
     * 
     * return two dimensional array in the form of array
     */
    public function getAgentProducts($id)
    {        
        try
        {            
            $this->db->select('temp_agent_product.*,company.company_logo as company_logo');
            $this->db->from('temp_agent_product');                      
            $this->db->join('company','company.id = temp_agent_product.company_id');            
            $this->db->where_in('agent_id',$id);
            $this->db->where('is_active',1);
            $this->db->order_by("temp_agent_product.id", "desc");                        
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getAllDeductibleFilterArray() {
        $query = "SELECT MIN(products.deductible_amount) as product_min_deductible,MAX(products.deductible_amount) AS product_max_deductible,MIN(temp_agent_product.deductible_amount) as temp_product_min_deductible,MAX(temp_agent_product.deductible_amount) AS temp_product_max_deductible FROM products,temp_agent_product";
        $list = $this->db->query($query);
        return $list->result_array();
    }

    public function getAllMaxbenefitsFilterArray() {
        $query = "SELECT MIN(products.maximum_benefits) as product_min_benefits,MAX(products.maximum_benefits) AS product_max_benefits,MIN(temp_agent_product.maximum_benefits) as temp_product_min_benefits,MAX(temp_agent_product.maximum_benefits) AS temp_product_max_benefits FROM products,temp_agent_product";
        $list = $this->db->query($query);
        return $list->result_array();
    }

    public function getAllCoinsuranceFilterArray() {
        $query = "SELECT MIN(products.coinsurance) as product_min_coinsurance,MAX(products.coinsurance) AS product_max_coinsurance,MIN(temp_agent_product.coinsurance) as temp_product_min_coinsurance,MAX(temp_agent_product.coinsurance) AS temp_product_max_coinsurance FROM products,temp_agent_product";
        $list = $this->db->query($query);
        return $list->result_array();
    }

    public function check_multiplevalues_checkbox($array,$field_name)
    {                
        $array_count = count($array);        
        foreach($array as $key => $value)
        {            
            $array_value = split('-', $value);
            if($key == 0)
            {                
                $this->filter_query .= " ".$field_name." >= ".trim(floatval($array_value[0]))." and ".$field_name." <= ".trim(floatval($array_value[1]));
            }
            else if($key == $array_count - 1)
            {
                if(trim($array_value[1]) == "Above")
                {
                    $this->filter_query .= " or ".$field_name." >= ".trim(floatval($array_value[0]));
                }
                else
                {
                    $this->filter_query .= " or ".$field_name." >= ".trim(floatval($array_value[0]))." and ".$field_name." <= ".trim(floatval($array_value[1]));
                }                
            }
            else
            {
                $this->filter_query .= " or ".$field_name." >= ".trim(floatval($array_value[0]))." and ".$field_name." <= ".trim(floatval($array_value[1]));
            }
        }
    }
}
