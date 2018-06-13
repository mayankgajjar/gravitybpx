<?php
/**
 * Description of Agency_model
 *
 * @author rashish
 */
class Customer_model extends CI_Model
{   
    public function checkHeightFeet()
    {
        try
        {   
            $string_qry = "select SUBSTRING_INDEX(height, \"\'\", 1) as height_feet FROM height_weight_chart";
            return $this->db->query($string_qry)->result_array();                       
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function checkHeightInches()
    {
        try
        {   
            $string_qry = "select SUBSTRING_INDEX(height, \"\'\", -1) as height_inches FROM height_weight_chart";
            return $this->db->query($string_qry)->result_array();                       
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function checkHeight()
    {
        try
        {   
            $string_qry = "select SUBSTRING_INDEX(height, \"\'\", 1) as height_feet,SUBSTRING_INDEX(height, \"\'\", -1) as height_inches FROM height_weight_chart";
            return $this->db->query($string_qry)->result_array();                       
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function checkWeight()
    {
        try
        {   
            $string_qry = "select SUBSTRING_INDEX(weight,\"\-\", 1) as weight_start,SUBSTRING_INDEX(weight, \"\-\", -1) as weight_end FROM height_weight_chart";
            return $this->db->query($string_qry)->result_array();                       
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function checkHeightAndWeight()
    {
        try
        {   
            $string_qry = "select SUBSTRING_INDEX(height, \"\'\", 1) as height_feet,SUBSTRING_INDEX(height, \"\'\", -1) as height_inches,SUBSTRING_INDEX(weight,\"\-\", 1) as weight_start,SUBSTRING_INDEX(weight, \"\-\", -1) as weight_end FROM height_weight_chart";
            return $this->db->query($string_qry)->result_array();                       
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_insert is used to insert single record of customer in customers  table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_insert($arr)
    {
        try
        {
            $this->db->insert("customers",$arr);
            return $this->db->insert_id();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_plan_insert is used to insert single record of customer in customers  table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_plan_insert($arr)
    {
        try
        {
            $this->db->insert("customer_plan",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_update is used to insert single record of customer in customers  table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_update($arr,$id)
    {
        try
        {
            $this->db->where('id', $id);
            $this->db->update('customers', $arr);             
            return $id;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    
    
    /*
     * customer_plan_update is used to insert single record of customer in customers  table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_plan_update($arr,$id)
    {
        try
        {
            $this->db->where('customer_id', $id);
            $this->db->update('customer_plan', $arr);            
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_additonal_members_insert is used to insert single record of customer plan in customer_plan table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_additonal_members_insert($arr)
    {
        try
        {
            $this->db->insert("customer_additional_members",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_additonal_members_update is used to insert single record of customer plan in customer_plan table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_additonal_members_update($arr,$id)
    {
        try
        {
            $this->db->where('id', $id);
            $this->db->update('customer_additional_members', $arr);            
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    
     /*
     * customer_beneficiaries_insert is used to insert single record of customer plan in customer_plan table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_beneficiaries_insert($arr)
    {
        try
        {
            $this->db->insert("customer_beneficiaries",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_beneficiaries_update is used to insert single record of customer plan in customer_plan table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_beneficiaries_update($arr,$id)
    {
        try
        {
            $this->db->where('id', $id);
            $this->db->update('customer_beneficiaries', $arr);            
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    
     /*
     * customer_application_insert is used to insert single record of customer application in application table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_application_insert($arr)
    {
        try
        {
            $this->db->insert("application",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
    
    /*
     * customer_application_insert is used to insert single record of customer application in application table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_application_update($arr,$id)
    {
        try
        {
            $this->db->where('customer_id', $id);
            $this->db->update('application', $arr);                                     
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * getAllAgentInfo is used to retrive all record of agent table with all information like name of parent agency, primary email, agent type, etc
     * 
     * return two dimensional array in the form of array
     */
    public function getAllCustomerInfo($id)
    {        
        try
        {
            $this->db->select('*');
            $this->db->from('customers');
            $this->db->where('customers.agent_id',$id);
            $this->db->where('customers.is_active',1);                      
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getCustomerInfo is used to retrive single record of customers table with all information
     * 
     * @param $id int specify primary key of customers table 
     *
     * return two dimensional array in the form of array
     */
    public function getCustomerInfo($id)
    {
        try
        {
            
            $this->db->select('c.id as customer_id,c.*,be.*,app.*,s.name as birth_state,co.name as birth_country,co.id as birth_country_id,ci.name as bank_city,ci.id as bank_city_id,si.name as bank_state,si.id as bank_state_id,bci.name as bank_country,bci.id as bank_country_id,cci.name as card_city,cci.id as card_city_id,csi.name as card_state,csi.id as card_state_id,cc.name as card_country,cc.id as card_country_id');
            $this->db->from('customers c');
            $this->db->where('c.id',$id); 
            $this->db->where('c.is_active',1);                    
            $this->db->join('customer_beneficiaries be','be.customer_id = c.id','left');
            $this->db->join('application app','app.customer_id = c.id','left');
            $this->db->join('state s','s.id = app.app_birth_state_id','left');
            $this->db->join('country co','co.id = s.country_id','left');     
            $this->db->join('city ci','ci.id = c.bank_city_id','left'); 
            $this->db->join('state si','si.id = ci.state_id','left');     
            $this->db->join('country bci','bci.id = si.country_id','left');
            $this->db->join('city cci','cci.id = c.card_city_id','left'); 
            $this->db->join('state csi','csi.id = cci.state_id','left');          
            $this->db->join('country cc','cc.id = csi.country_id','left');
            $customer = $this->db->get()->row();       

            $this->db->select('customer_additional_members.*');
            $this->db->from('customer_additional_members');
            $this->db->where('customer_additional_members.customer_id',$id);         
            $this->db->join('customers','customer_additional_members.customer_id = customers.id','left');            
            $customer->additional_members = $this->db->get()->result_array();

            $this->db->select('customer_beneficiaries.*');
            $this->db->from('customer_beneficiaries');
            $this->db->where('customer_beneficiaries.customer_id',$id);         
            $this->db->join('customers','customer_beneficiaries.customer_id = customers.id','left');            
            $customer->customer_beneficiaries = $this->db->get()->result_array();

            $this->db->select('customer_plan.*');
            $this->db->from('customer_plan');
            $this->db->where('customer_plan.customer_id',$id);         
            $this->db->join('customers','customer_plan.customer_id = customers.id','left');            
            $customer->customer_plan = $this->db->get()->row();
            
            $this->db->select('customer_product.*');
            $this->db->from('customer_product');
            $this->db->where('customer_product.customer_id',$id);         
            $this->db->join('customers','customer_product.customer_id = customers.id');                    
            $customer->customer_product = $this->db->get()->row();

            $this->db->select('temp_customer_product.product_id');
            $this->db->from('temp_customer_product');
            $this->db->where('temp_customer_product.customer_id',$id);                     
            $customer->customer_temp_product = $this->db->get()->row();
            $customer->products = array();
            if($customer->customer_product != "")
            {
                $products_ids = $customer->customer_product->product_id;
                if($products_ids != "")
                {
                    $query = $this->db->query("SELECT products.id as product_id,products.*,company.*,category.category_name FROM products,company,category WHERE products.id IN (".$products_ids.") and category.id = products.category_id and company.id = products.underwriting_company");
                    $customer->products = $query->result_array();                 
                }
            }

            if($customer->customer_temp_product != "")
            {
                $products_ids = $customer->customer_temp_product->product_id;
                if($products_ids != "")
                {
                    $query = $this->db->query("SELECT temp_agent_product.id as temp_product_id,temp_agent_product.*,company.*,category.category_name FROM temp_agent_product,company,category WHERE temp_agent_product.id IN (".$products_ids.") and category.id = temp_agent_product.category_id and company.id = temp_agent_product.company_id");
                    $customer->products = array_merge($customer->products,$query->result_array());                 
                }
            }     
            /*if($customer->products1 != "" && $customer->products2 != "")
            {
                $customer->products = array_merge($customer->products1, $customer->products2);      
            }*/            
           
            return $customer;       
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_product_insert is used to insert single record of customer product in customer_product table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_product_insert($arr)
    {
        try
        {
            $this->db->insert("customer_product",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_product_update is used to insert single record of customer product in customer_product table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_product_update($arr,$id)
    {
        try
        {
            $this->db->where('customer_id', $id);
            $this->db->update('customer_product', $arr);                                     
            return true;            
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_temp_product_insert is used to insert single record of customer product in customer_product table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_temp_product_insert($customer_temp_product,$customer_temp_update_product,$customer_temp_update_product_agent_id)
    {
        try
        {
            $this->db->insert("temp_customer_product",$customer_temp_product);
            $this->db->where('agent_id', $customer_temp_update_product_agent_id);
            $this->db->update('temp_agent_product', $customer_temp_update_product); 

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * customer_temp_product_update is used to insert single record of customer product in customer_product table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : boolean true, if successfully inserted
     *          bool false if not inserted
     */
    public function customer_temp_product_update($customer_temp_product,$customer_temp_update_product,$customer_temp_update_product_agent_id,$id)
    {
        try
        {            
            $this->db->where('customer_id', $id);
            $this->db->update('temp_customer_product', $customer_temp_product);
            $this->db->where('agent_id', $customer_temp_update_product_agent_id);
            $this->db->update('temp_agent_product', $customer_temp_update_product); 

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * getAllCustomerInfoByAgency is used to retrive all records of customers
     * 
     * return two dimensional array in the form of array
     */
    public function getAllCustomerInfoByAgency($id)
    {        
        try
        {
            $this->db->select('customers.*');
            $this->db->from('customers');            
            $this->db->join('agents','agents.id = customers.agent_id');            
            $this->db->where('agents.agency_id',$id);
            $this->db->where("customers.submitted_status",1);       
            $this->db->order_by("customers.id", "desc");                   
            return $this->db->get()->result_array();
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

    public function remove_customer_additional_members($id)
    {
        try
        {
            $this->db->where('customer_id', $id);
            $this->db->delete('customer_additional_members');                                     
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function remove_customer_additional_members_by_id($id)
    {
        try
        {
            $this->db->where_in('id', $id);
            $this->db->delete('customer_additional_members');                                                 
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function remove_customer_beneficiaries_by_id($id)
    {
        try
        {
            $this->db->where_in('id', $id);
            $this->db->delete('customer_beneficiaries');                                                 
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * delete is used to delete single record of agent based on agent id
     * 
     * @param $id int primary key of agent table
     *
     * return true if record is deleted
     *        false on failure
     */
    public function customer_delete($id)
    {
        try
        {            
            // Delete from non-resident state
            $this->db->where('id',$id);
            $this->db->delete('customers');
            
            //Delete from agent_phone
            $this->db->where('customer_id',$id);
            $this->db->delete('application');
            
            //Delete from agent_phone
            $this->db->where('customer_id',$id);
            $this->db->delete('customer_plan');

            //Delete from agent_phone
            $this->db->where('customer_id',$id);
            $this->db->delete('customer_additional_members');

            //Delete from agent_phone
            $this->db->where('customer_id',$id);
            $this->db->delete('customer_beneficiaries');

            $this->db->where('customer_id',$id);
            $this->db->delete('customer_product');

            $this->db->where('customer_id',$id);
            $this->db->delete('temp_customer_product');
            
            return true;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    public function getSalesAgentIdByCustomerId($id)
    {
        try
        {
            $this->db->select('agent_id');
            $this->db->from('customers');                                          
            $this->db->where('id',$id);            
            return $this->db->get()->row();                                                           
        }
        catch (Exception $e)
        {
            return false;
        }
    }   

    /*
     * getAllSubmittedCustomers is used to retrive all record of submitted customer from customers table
     * 
     * return two dimensional array in the form of array
     */
    public function getAllSubmittedCustomers()
    {
        try
        {
            $this->db->select('customers.*');
            $this->db->from('customers as customers');
            $this->db->where('submitted_status',1);
            $this->db->order_by('submitted_date','DESC');                   
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getAllVerifiedCustomers is used to retrive all record of verified customer from customers table
     * 
     * return two dimensional array in the form of array
     */
    public function getAllVerifiedCustomers()
    {
        try
        {
            $this->db->select('customers.*');
            $this->db->from('customers as customers');
            $this->db->where('verified_status',1);
            $this->db->order_by('verified_date','DESC');                   
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * getAllUnVerifiedCustomers is used to retrive all record of un-verified customer from customers table
     * 
     * return two dimensional array in the form of array
     */
    public function getAllUnVerifiedCustomers()
    {
        try
        {
            $this->db->select('customers.*');
            $this->db->from('customers as customers');
            $this->db->where('verified_status',0);            
            $this->db->where('submitted_status',1);
            $this->db->order_by('verified_date','DESC');                   
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * countAllCustomers is used to count all record of customer from customers table
     * 
     * return intger value 
     */
    public function countAllCustomers()
    {
        try
        {
            $this->db->select('customers.*');
            $this->db->from('customers as customers');                        
            return count($this->db->get()->result_array());
        }
        catch(Exception $e)
        {
            return false;
        }
    }

}
