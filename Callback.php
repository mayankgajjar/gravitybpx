<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller {

    public function dial() {
        $request = $_REQUEST;
        $request['start_time'] = date('Y-m-d H:i:s');
        $callLogId = $this->__addCallLog($request);
        $liveAgentId = $request['X-PH-Live'];
        $this->__updateLiveAgent($callLogId,$liveAgentId, 'INCALL');
        $callbackUrl = site_url('callback/callbackUrl');
        $response = '<Response>
		    <Speak>Connecting your call..</Speak>
		    <Dial callbackUrl="' . $callbackUrl . '" action="http://gravitybpx.com/callback/dial_status/" method="GET" redirect="true" callerId="' . $request['X-PH-Caller'] . '">
		        <Number>' . $request['To'] . '</Number>
		    </Dial>
		</Response>';
        Header('Content-type: text/xml');
        echo $response;
        exit;
    }

    public function hangup() {
        $response = '<Response>
		    	<Hangup schedule="30" reason="rejected" />
		    	<Speak loop="0">This call will be hung up after a minute</Speak>
			</Response>';
        Header('Content-type: text/xml');
        echo $response;
        exit;
    }

    public function dial_status() {
        $_REQUEST['dial_status'] = 'test';
        //$this->__log($_REQUEST);
        $response = '<Response>
    			<Speak></Speak>
			</Response>';
        Header('Content-type: text/xml');
        echo $response;
    }

    public function callbackUrl() {
        $this->load->model('callog_m');
        $data = $_REQUEST;
        $this->__log($data);
        $CallUUID = $data['CallUUID'];
        $options = array(
            'LIMIT' => array('start' => 0, 'end' => 1),
            'conditions' => "CallUUID = '{$CallUUID}'"
        );
        $logs  = $this->callog_m->get_relation('', $options);
        $status = $data['DialAction'];
        if($status == 'hangup' && $logs){
            $log = $logs[0];
            $timeFirst  = strtotime($log['start_time']);
            $endTime = date('Y-m-d H:i:s');
            $timeEnd = strtotime($endTime);
            $save['end_time'] = $endTime;
            $save['length_in_sec'] = $timeEnd - $timeFirst;
            $save['length_in_min'] = ($timeEnd - $timeFirst) / 60;
            $this->callog_m->save($save, $log['unique_id']);
            $liveAgentId = $data['X-PH-Live'];
            $this->__updateLiveAgent(0, $liveAgentId, 'DISPO');
        }
    }

    public function message() {
        $this->__log($_REQUEST);
    }

    private function __log($array = array()) {
        $myfile = fopen("/var/www/html/uploads/newfile.txt", "w") or die("Unable to open file!");
        $txt = var_export($array, true);
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    private function __addCallLog($array = array()) {
        $this->load->model('callog_m');
        $data = array(
            'agent_id' => $array['X-PH-Agent'],
            'CallUUID' => $array['CallUUID'],
            'channel' => $array['From'],
            'type' => $array['X-PH-Type'],
            'extension' => $array['X-PH-Caller'],
            'number_dialed' => $array['To'],
            'start_time' => $array['start_time']
        );
        $callUniqueId = $this->callog_m->save($data, NULL);
        return $callUniqueId;
    }

    private function __updateLiveAgent($uniqueId, $liveAgentId, $status) {
        $this->load->model('LiveAgent_m','liveagent_m');
        //$this->session->userdata('liveagent')->liveagent

        $data = array(
            'status' => $status,
            'uniqueid' => $uniqueId,
        );
        $this->liveagent_m->save($data, $liveAgentId);
    }

}
