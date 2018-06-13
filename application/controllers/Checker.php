<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Checker
 *
 * @author dhareen
 */
class Checker extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        }
    }

    /**
     * change the status of the login user on vicidial
     * @return [type] [description]
     */
    public function changestatus() {
        $post = $this->input->post();
        $this->load->model('LiveAgent_m', 'liveAgent');
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $status = $post['status'];
            $statusData = array('status' => $status);
            $result = $this->liveAgent->save($statusData, $this->session->userdata('liveagent')->liveagent);
            if ($result) {
                $output['success'] = true;
                $output['message'] = $status;
            } else {
                $output['success'] = false;
                $output['message'] = "status not changes.";
            }
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    /**
     * change the status of the login user on vicidial
     * @return [type] [description]
     */
    public function statuscheker() {
        $post = $this->input->post();
        $this->load->model('LiveAgent_m', 'liveAgent');
        $res = $this->liveAgent->get($this->session->userdata('liveagent')->liveagent, TRUE);
        if ($res) {
            $output['success'] = true;
            $output['status'] = $res->status;
        } else {
            $output['success'] = true;
            $output['status'] = "ERROR";
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     *
     */
    public function liveAgent_Sidebar() {
        $agencyId = $this->session->userdata('agent')->agency_id;
        $agents = getLiveAgents($agencyId);
        $this->data['agents'] = $agents;
        echo $this->load->view('templates/agent_status', $this->data, true);
    }

    function AllAgentByAgencyid() {
        $agencyId = $this->session->userdata('agency')->id;
        $sql = "select *  from agents LEFT JOIN live_agents as live on agents.user_id=live.user WHERE agency_id={$agencyId}";
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->data['agents'] = $result;
        echo $this->load->view('templates/agent_status', $this->data, true);
    }

    function agentstatus_json() {
        $agencyId = $this->session->userdata('agent')->agency_id;
        $agents = getLiveAgents($agencyId);
        $statusJson = array();
        foreach ($agents as $agent) {
            array_push($statusJson, array('agent_id' => $agent->id, 'status' => $agent->status));
        }
        $statusJson = json_encode($statusJson);
        echo $statusJson;
    }

}
