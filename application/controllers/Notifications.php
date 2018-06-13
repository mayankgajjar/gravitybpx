<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Customer
 *
 * @author Meet
 */
class Notifications extends CI_Controller {

    public $data = array();

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        }
    }

    /*
     * verification_agent_customer_notifications is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and unread
     *
     */

    public function verification_agent_customer_notifications() {
        $table_name_array = unserialize(TABLE_NAME);
        $this->load->model('Notifications_model');
        $this->load->model('Common_model');
        $codition = "theme_options_name = 'notifications_setting'";
        $notifications_setting_data = $this->Common_model->getRowByCondition($codition, $table_name_array['theme_options']);
        $notifications_type_id = unserialize($notifications_setting_data['theme_options_values'])['verification_agent_customer_not_verified_notification'];
        $query = "SELECT * FROM " . $table_name_array['notifications_message'] . " as nm JOIN " . $table_name_array['notifications_type'] . " as nt ON nm.notifications_type_id = nt.notifications_type_id where nt.notifications_type_id = $notifications_type_id";
        $notifications_message = $this->Common_model->customQuery($query, 2);
        $customer_notifications = $this->Notifications_model->getAllVerificationAgentCustomerNotifications();
        $return_value = $this->notification($customer_notifications, 'verification_success');
        echo json_encode(array("return_string" => $return_value, "count_customers_notification" => count($customer_notifications), "notifications_message_title" => $notifications_message[0]['notifications_message_title'], "notifications_message_content" => $notifications_message[0]['notifications_message_content']));
        die;
    }

    /*
     * verification_agent_customer_notifications_read is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and read
     *
     */

    public function verification_agent_customer_notifications_read($id) {
        $this->load->model('Notifications_model');
        $data = array(
            'is_read' => 1,
            'modified_at' => date('Y-m-d H:i:s')
        );
        $this->Notifications_model->updateVerificationAgentCustomerNotificationsRead($id, $data);
        $customer_notifications = $this->Notifications_model->getAllVerificationAgentCustomerNotifications();
        $return_value = $this->notification($customer_notifications, 'verification_success');
        echo json_encode(array("return_string" => $return_value, "count_customers_notification" => count($customer_notifications)));
        die;
    }

    /*
     * verification_agent_customer_notifications_display is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and read
     *
     */

    public function verification_agent_customer_notifications_display() {
        $customer_ids = $_POST['customer_ids'];
        if (!empty($customer_ids)) {
            $this->load->model('Notifications_model');
            $data = array(
                'is_display' => 1
            );
            $this->Notifications_model->updateVerificationAgentCustomerNotificationsDisplay($customer_ids, $data);
            echo 'sucess';
            die;
        }
    }

    /*
     * sales_agent_customer_notifications is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and unread
     *
     */

    public function sales_agent_customer_notifications() {
        $table_name_array = unserialize(TABLE_NAME);
        $this->load->model('Notifications_model');
        $this->load->model('Common_model');
        $codition = "theme_options_name = 'notifications_setting'";
        $notifications_setting_data = $this->Common_model->getRowByCondition($codition, $table_name_array['theme_options']);
        $notifications_type_id = unserialize($notifications_setting_data['theme_options_values'])['sales_agent_customer_submitted_notification'];
        $query = "SELECT * FROM " . $table_name_array['notifications_message'] . " as nm JOIN " . $table_name_array['notifications_type'] . " as nt ON nm.notifications_type_id = nt.notifications_type_id where nt.notifications_type_id = $notifications_type_id";
        $notifications_message = $this->Common_model->customQuery($query, 2);
        $customer_notifications = $this->Notifications_model->getAllSalesAgentCustomerNotifications();
        $return_value = $this->notification($customer_notifications, 'sales_success');
        echo json_encode(array("return_string" => $return_value, "count_customers_notification" => count($customer_notifications), "notifications_message_title" => $notifications_message[0]['notifications_message_title'], "notifications_message_content" => $notifications_message[0]['notifications_message_content']));
        die;
    }

    /*
     * sales_agent_customer_notifications_read is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and read
     *
     */

    public function sales_agent_customer_notifications_read($id) {
        $this->load->model('Notifications_model');
        $data = array(
            'is_read' => 1,
            'modified_at' => date('Y-m-d H:i:s')
        );
        $this->Notifications_model->updateSalesAgentCustomerNotificationsRead($id, $data);
        $customer_notifications = $this->Notifications_model->getAllSalesAgentCustomerNotifications();
        $return_value = $this->notification($customer_notifications, 'sales_success');
        echo json_encode(array("return_string" => $return_value, "count_customers_notification" => count($customer_notifications)));
        die;
    }

    /*
     * sales_agent_customer_notifications_display is used to perform get all notification customer for unverified and unread
     *
     *
     * return array of All customer notification unverified and read
     *
     */

    public function sales_agent_customer_notifications_display() {
        $customer_ids = $_POST['customer_ids'];
        if (!empty($customer_ids)) {
            $this->load->model('Notifications_model');
            $data = array(
                'is_display' => 1
            );
            $this->Notifications_model->updateSalesAgentCustomerNotificationsDisplay($customer_ids, $data);
            echo 'sucess';
            die;
        }
    }

    public function notification($customer_notifications, $class) {
        $return_string = "";
        if (!empty($customer_notifications)) {
            foreach ($customer_notifications as $key => $value) {
                $display_class = "";
                if ($value['is_display'] == 1) {
                    $display_class = "displayed";
                } else {
                    $display_class = "notdisplayed";
                }
                $return_string .='<li>';
                $edit_link = site_url('customer/manage_customer/getCustomerById/' . $value['id']);
                $return_string .='<a display="' . $display_class . '" id="' . $value['id'] . '" class="' . $class . '" target="_blank" href="' . $edit_link . '">';
                $return_string .='<span class="time">';
                $curenttime = $value['created_at'];
                $time_ago = strtotime($curenttime);
                $return_string .= $this->timeAgo($time_ago);
                $return_string .='</span>';
                $return_string .='<span class="details">';
                $return_string .='<span class="label label-sm label-icon label-success">';
                $return_string .='<i class="fa fa-plus"></i>';
                $return_string .='</span>' . $value['fname'] . ' ' . $value['lname'] . '</span>';
                $return_string .='</a>';
                $return_string .='</li>';
            }
        }
        return $return_string;
    }

    public function timeAgo($time_ago) {
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        $return_string = "";
        // Seconds
        if ($seconds <= 60) {
            $return_string .= "$seconds seconds ago";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                $return_string .= "one minute ago";
            } else {
                $return_string .= "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                $return_string .= "an hour ago";
            } else {
                $return_string .= "$hours hours ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                $return_string .= "yesterday";
            } else {
                $return_string .= "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                $return_string .= "a week ago";
            } else {
                $return_string .= "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                $return_string .= "a month ago";
            } else {
                $return_string .= "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                $return_string .= "one year ago";
            } else {
                $return_string .= "$years years ago";
            }
        }
        return $return_string;
    }

    /*
     * manage_notifications_type is used to perform all functionality related to notifications_type
     *
     * @param $operation string specify what type of operation is performed on notifications_type
     * @param $id int specify unique id ofnotifications_type
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into notifications_type
     */

    public function manage_notifications_type($operation = "view", $id = "") {
        $this->load->model('Common_model');
        $table_name_array = unserialize(TABLE_NAME);
        $limit = "";
        if ($operation == "add") {
            $this->data['validation'] = TRUE;
            if ($this->input->post()) {
                $post = $this->input->post();
                $this->form_validation->set_rules('notifications_type_name', 'Notification Type Name', 'trim|required');
                $this->form_validation->set_rules('is_active', 'Status', 'trim|required');

                if ($this->form_validation->run() == TRUE) {
                    $notifications_type = array(
                        'notifications_type_name' => $post['notifications_type_name'],
                        'is_active' => $post['is_active'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->input->post('notifications_type_id') == "") {

                        $this->Common_model->add($notifications_type, $table_name_array['notifications_type']);
                        $this->session->set_flashdata('msg', 'Notifications type is successfully inserted.');
                    } else {
                        unset($notifications_type['created_at']);
                        $condition = "notifications_type_id = " . $post["notifications_type_id"];
                        $this->Common_model->edit_custom($condition, $notifications_type, $table_name_array['notifications_type']);
                        $this->session->set_flashdata('msg', 'Notifications type is successfully updated.');
                    }
                }
                redirect('notifications/manage_notifications_type/view');
            } else {
                $this->data['title'] = 'Add Notifications Type';
                $this->template->load("admin", "notifications/add_notifications_type", $this->data);
            }
        } else if ($operation == 'delete') {
            if ($this->Common_model->deleteAll($id, 'notifications_type_id', $table_name_array['notifications_type'])) {
                $this->data['title'] = 'View Notifications Type';
                $this->data['notifications_type'] = $this->Common_model->viewAll($table_name_array['notifications_type'], $limit);
                $this->session->set_flashdata('msg', 'Notifications type is successfully deleted.');
                $this->template->load("admin", "notifications/view_notifications_type", $this->data);
            }
        } else if ($operation == 'multipledelete') {
            if ($this->input->post()) {
                if ($this->input->post('massaction') == "") {
                    $this->session->set_flashdata('error', 'Please select an action');
                } else if ($this->input->post('delete_ids') == "") {
                    $this->session->set_flashdata('error', 'No record selected');
                } else {
                    $ids = implode(",", $this->input->post('delete_ids'));
                    $this->Common_model->deleteMultiple($ids, $table_name_array['notifications_type'], 'notifications_type_id');
                    $this->session->set_flashdata('msg', 'Notifications type is successfully deleted.');
                }
                redirect('notifications/manage_notifications_type/view');
            }

            /* $this->data['title'] = 'View Notifications Type';
              $this->data['notifications_type'] = $this->Common_model->viewAll($table_name_array['notifications_type'],$limit);
              $this->session->set_flashdata('msg','Notifications type is successfully deleted.');
              $this->template->load("admin","notifications/view_notifications_type",$this->data); */
        } else if ($operation == 'view') {
            $this->data['datatable'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['title'] = 'View Notifications Type';
            $this->data['notifications_type'] = $this->Common_model->viewAll($table_name_array['notifications_type'], $limit);
            $this->template->load("admin", "notifications/view_notifications_type", $this->data);
        } else if ($operation == 'edit') {
            $this->data['title'] = 'Edit Notifications Type';
            $condition = "notifications_type_id= $id";
            $this->data['notifications_type'] = $this->Common_model->view_custom($condition, $table_name_array['notifications_type']);
            $this->template->load("admin", "notifications/add_notifications_type", $this->data);
        }
    }

    /*
     * manage_notifications_message is used to perform all functionality related to notifications_message
     *
     * @param $operation string specify what type of operation is performed on notifications_message
     * @param $id int specify unique id of notifications_message
     *
     * return
     *      If $operation == 'add'
     *          If request is post
     *              Insert into notifications_message
     */

    public function manage_notifications_message($operation = "view", $id = "") {
        $this->load->model('Common_model');
        $table_name_array = unserialize(TABLE_NAME);
        $limit = "";
        if ($operation == "add") {
            $this->data['validation'] = TRUE;
            $this->data['fileinput'] = TRUE;
            if ($this->input->post()) {
                $post = $this->input->post();
                $this->form_validation->set_rules('notifications_type_id', 'Notification Type Name', 'trim|required');
                $this->form_validation->set_rules('notifications_message_title', 'Notification Message Title', 'trim|required');
                $this->form_validation->set_rules('notifications_message_content', 'Notification Message Content', 'trim|required');
                $this->form_validation->set_rules('is_active', 'Status', 'trim|required');

                if ($this->form_validation->run() == TRUE) {
                    $notifications_message = array(
                        'notifications_type_id' => $post['notifications_type_id'],
                        'notifications_message_title' => $post['notifications_message_title'],
                        'notifications_message_content' => $post['notifications_message_content'],
                        'is_active' => $post['is_active'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->input->post('notifications_message_id') == "") {

                        $this->Common_model->add($notifications_message, $table_name_array['notifications_message']);
                        $this->session->set_flashdata('msg', 'Notifications message is successfully inserted.');
                    } else {
                        unset($notifications_message['created_at']);
                        $condition = "notifications_message_id = " . $post["notifications_message_id"];
                        $this->Common_model->edit_custom($condition, $notifications_message, $table_name_array['notifications_message']);
                        $this->session->set_flashdata('msg', 'Notifications message is successfully updated.');
                    }
                }
                redirect('notifications/manage_notifications_message/view');
            } else {
                $this->data['title'] = 'Add Notifications Message';
                $this->data['notifications_type'] = $this->Common_model->getArrayByCondition(1, 'is_active', $table_name_array['notifications_type'], '');
                $this->template->load("admin", "notifications/add_notifications_message", $this->data);
            }
        } else if ($operation == 'delete') {
            if ($this->Common_model->deleteAll($id, 'notifications_message_id', $table_name_array['notifications_message'])) {
                $this->data['title'] = 'View Notifications Message';
                $query = "SELECT * FROM " . $table_name_array['notifications_message'] . " as nm JOIN " . $table_name_array['notifications_type'] . " as nt ON nm.notifications_type_id = nt.notifications_type_id";
                $this->data['notifications_message'] = $this->Common_model->customQuery($query, 2);
                $this->session->set_flashdata('msg', 'Notifications message is successfully deleted.');
                $this->template->load("admin", "notifications/view_notifications_message", $this->data);
            }
        } else if ($operation == 'multipledelete') {
            if ($this->input->post()) {
                if ($this->input->post('massaction') == "") {
                    $this->session->set_flashdata('error', 'Please select an action');
                } else if ($this->input->post('delete_ids') == "") {
                    $this->session->set_flashdata('error', 'No record selected');
                } else {
                    $ids = implode(",", $this->input->post('delete_ids'));
                    $this->Common_model->deleteMultiple($ids, $table_name_array['notifications_message'], 'notifications_message_id');
                    $this->session->set_flashdata('msg', 'Notifications message is successfully deleted.');
                }
                redirect('notifications/manage_notifications_message/view');
            }
        } else if ($operation == 'view') {
            $this->data['title'] = 'View Notifications Message';
            $this->data['datatable'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $query = "SELECT * FROM " . $table_name_array['notifications_message'] . " as nm JOIN " . $table_name_array['notifications_type'] . " as nt ON nm.notifications_type_id = nt.notifications_type_id";
            $this->data['notifications_message'] = $this->Common_model->customQuery($query, 2);
            $this->template->load("admin", "notifications/view_notifications_message", $this->data);
        } else if ($operation == 'edit') {
            $this->data['title'] = 'Edit Notifications Message';
            $condition = "notifications_message_id= $id";
            $this->data['notifications_type'] = $this->Common_model->getArrayByCondition(1, 'is_active', $table_name_array['notifications_type'], '');
            $this->data['notifications_message'] = $this->Common_model->view_custom($condition, $table_name_array['notifications_message']);
            $this->template->load("admin", "notifications/add_notifications_message", $this->data);
        }
    }

}
