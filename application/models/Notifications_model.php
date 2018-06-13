<?php
/**
 * Description of Notifications_model
 *
 * @author Meet
 */
class Notifications_model extends CI_Model
{    
    /*
     * getAllVerificationAgentCustomerNotifications is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function getAllVerificationAgentCustomerNotifications()
    {
        try
        {           
            $this->db->select('customers.*,notifications.*');
            $this->db->from('notifications');                      
            $this->db->join('customers','customers.id = notifications.customer_id');            
            $this->db->where('notifications.is_read',0);
            $this->db->where('notifications.agent_type_id',2);
            $this->db->where('notifications.is_remove',0);
            $this->db->order_by("notifications.created_at", "desc");                        
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }   

    /*
     * updateVerificationAgentCustomerNotificationsRead is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function updateVerificationAgentCustomerNotificationsRead($id,$data)
    {
        try
        {                       
            $this->db->where('notifications.customer_id',$id);
            $this->db->where('notifications.is_display',1);
            $this->db->where('notifications.agent_type_id',2);
            $this->db->update('notifications', $data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * updateVerificationAgentCustomerNotificationsDisplay is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function updateVerificationAgentCustomerNotificationsDisplay($customer_ids,$data)
    {
        try
        {                       
            $this->db->where_in('notifications.customer_id',$customer_ids);
            $this->db->where('notifications.is_display',0);
            $this->db->where('notifications.agent_type_id',2);
            $this->db->update('notifications', $data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }    

    /*
     * getAllSalesAgentCustomerNotifications is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function getAllSalesAgentCustomerNotifications()
    {
        try
        {           
            $this->db->select('customers.*,notifications.*');
            $this->db->from('notifications');                      
            $this->db->join('customers','customers.id = notifications.customer_id');                        
            $this->db->where('notifications.is_read',0);
            $this->db->where('notifications.agent_type_id',1);
            $this->db->where('notifications.is_remove',0);
            $this->db->order_by("notifications.created_at", "desc");                        
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * updateSalesAgentCustomerNotificationsRead is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function updateSalesAgentCustomerNotificationsRead($id,$data)
    {
        try
        {                       
            $this->db->where('notifications.customer_id',$id);
            $this->db->where('notifications.is_display',1);
            $this->db->where('notifications.agent_type_id',1);
            $this->db->update('notifications', $data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * updateSalesAgentCustomerNotificationsDisplay is used to get all record of customer notification from notifications table
     * 
     * return array value 
     */
    public function updateSalesAgentCustomerNotificationsDisplay($customer_ids,$data)
    {
        try
        {                       
            $this->db->where_in('notifications.customer_id',$customer_ids);
            $this->db->where('notifications.is_display',0);
            $this->db->where('notifications.agent_type_id',1);
            $this->db->update('notifications', $data);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
