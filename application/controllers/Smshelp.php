<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smshelp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->library('Plivo_sms');
        $this->load->model('leadSmsLog_m', 'leadsmslog_m');
        $this->load->model('leadstore_m');
        $this->load->model('Agents');
    }

    public function searchHistory() {
        $post = $this->input->post();
        $output = array();
        if ($post && $post['is_ajax'] == true) {
            $pnoneNum = substr($post['phone'], 1);
            $pnoneNum1 = $post['phone'];
            $options = array(
                'LIMIT' => array('start' => 0, 'end' => 1),
                'conditions' => "replace(phone,'-','') = '{$pnoneNum}' AND user = {$this->session->userdata('agent')->id}"
            );
            $lead = $this->leadstore_m->get_relation('', $options);
            if ($lead) {
                $output['success'] = true;
                $output['lead'] = $lead[0];
            } else {
                $data['agency_id'] = $this->session->userdata('agent')->agency_id;
                $data['user'] = $this->session->userdata('agent')->id;
                $data['owner'] = $this->session->userdata('user')->email_id;
                $data['member_id'] = getIncrementMemberId();
                $data['dispo'] = 'NEW';
                $data['phone'] = $pnoneNum;
                $leadId = $this->leadstore_m->save($data, NULL);
                updateIncrementMemberId();
                $options = array(
                    'LIMIT' => array('start' => 0, 'end' => 1),
                    'conditions' => "lead_id = {$leadId}"
                );
                $lead = $this->leadstore_m->get_relation('', $options);
                $output['success'] = true;
                $output['lead'] = $lead[0];
            }
            $agent_data = $this->Agents->get_by(['id' => $this->session->userdata('agent')->id], TRUE);
            $agentPlivo = '1' . $agent_data->plivo_phone;
            $headerOption = array(
                'lead_name' => $lead[0]['first_name'] . ' ' . $lead[0]['last_name'],
                'lead_status' => $lead[0]['status'],
                'lead_image' => 'Avatar.png',
                'agent_image' => $agent_data->profile_image);
            // $optionsChat = array(
            //     'fields' => 'sms_status,sender_number,sms_status,receiver_number,text,created',
            //     'conditions' => "((sender_number='$agentPlivo' OR receiver_number='$agentPlivo') AND (sender_number='$pnoneNum1' OR receiver_number='$pnoneNum1'))",
            //     'ORDER_BY' => array(
            //         'field' => 'created',
            //         'order' => 'ASC'
            //     )
            // );
            $chatdata['lead_number'] = $pnoneNum;
            // $chatdata['chats'] = $this->leadsmslog_m->get_relation('', $optionsChat);
            $chatdata['header'] = $headerOption;
            $this->db->set('msg_status', 'seen');
            $this->db->where("(sender_number='$pnoneNum1' AND receiver_number='$agentPlivo') AND sms_status='inbound' AND msg_status='unseen'");
            $this->db->update('lead_sms_log'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
            echo $this->load->view('dialer/chat/chat_view', $chatdata, true);
        }
    }

    /**
     * @uses Fetch chat bubble
     */
    public function fetch_chat_head() {
        // $data['img_path'] = $this->input->post('img_path');
        $data['phone_no'] = $this->input->post('phone_no');
        $data['leadname'] = $this->input->post('leadname');
        echo $this->load->view('dialer/chat/chat_head', $data, TRUE);
    }

    /**
     * @uses Chat text
     */
    // public function chat_text() {
    //     $post = $this->input->post();
    //     if ($post && $post['is_ajax'] == true) {
    //         $pnoneNum = substr($post['phone'], 1);
    //         $pnoneNum1 = $post['phone'];
    //         $options = array(
    //             'LIMIT' => array('start' => 0, 'end' => 1),
    //             'conditions' => "replace(phone,'-','') = '{$pnoneNum}' AND user = {$this->session->userdata('agent')->id}"
    //         );
    //         $lead = $this->leadstore_m->get_relation('', $options);
    //         $agent_data = $this->Agents->get_by(['id' => $this->session->userdata('agent')->id], TRUE);
    //         $agentPlivo = '1' . $agent_data->plivo_phone;
    //         $headerOption = array(
    //             'lead_name' => $lead[0]['first_name'] . ' ' . $lead[0]['last_name'],
    //             'lead_status' => $lead[0]['status'],
    //             'lead_image' => 'Avatar.png',
    //             'agent_image' => $agent_data->profile_image);
    //         $optionsChat = array(
    //             'fields' => 'sms_status,sender_number,sms_status,receiver_number,text,created',
    //             'conditions' => "((sender_number='$agentPlivo' OR receiver_number='$agentPlivo') AND (sender_number='$pnoneNum1' OR receiver_number='$pnoneNum1'))",
    //             'ORDER_BY' => array(
    //                 'field' => 'created',
    //                 'order' => 'ASC'
    //             )
    //         );
    //         $chatdata['header'] = $headerOption;
    //         $chatdata['chats'] = $this->leadsmslog_m->get_relation('', $optionsChat);
    //         echo $this->load->view('dialer/chat/chat_text', $chatdata, true);
    //     }
    // }

    /**
     * @uses check new message for chat head(bubble)
     */
    // public function check_new_message() {
    //     $leadPhone = $this->input->post('postData');
    //     $agent_data = $this->Agents->get_by(['id' => $this->session->userdata('agent')->id], TRUE);
    //     $agentPlivo = '1' . $agent_data->plivo_phone;
    //     $newMsg = array();
    //     $i = 0;
    //     if (count($leadPhone) > 0) {
    //         foreach ($leadPhone as $key => $lead) {
    //             $optionsChat = array(
    //                 'conditions' => "receiver_number='$agentPlivo' AND sender_number='$lead' AND sms_status='inbound' AND msg_status='unseen'",
    //                 'ORDER_BY' => array(
    //                     'field' => 'created',
    //                     'order' => 'ASC'
    //                 )
    //             );
    //             $chatdata = $this->leadsmslog_m->get_relation('', $optionsChat);
    //             if (count($chatdata) > 0) {
    //                 $newMsg[$i] = substr($chatdata[0]['sender_number'], 1);
    //                 $i++;
    //             }
    //         }
    //     }
    //     return $this->output
    //                     ->set_content_type('application/json')
    //                     ->set_output(json_encode($newMsg));
    // }

}
