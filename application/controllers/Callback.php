<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller {

    public function dial() {
        $request = $_REQUEST;
        $request['start_time'] = date('Y-m-d H:i:s');

        //$this->__log($request);
        if (isset($request['X-PH-Type'])) {
            $callLogId = $this->__addCallLog($request);
            $conference = time();
            $liveAgentId = $request['X-PH-Live'];
            $this->__updateLiveAgent($callLogId, $liveAgentId, 'INCALL');
            $callbackUrl = site_url('callback/callbackUrl');
            $conference_name = 'demo';
            $response = '<Response>
		    <Speak>Connecting your call..</Speak>
		    <Dial callbackUrl="' . $callbackUrl . '" action="https://gravitybpx.com/callback/dial_status/" method="GET" redirect="true" callerId="' . $request['X-PH-Caller'] . '">
		        <Number>' . $request['To'] . '</Number>
		    </Dial>
		</Response>';
        } else {
            $callLogId = $this->__addCallLog($request);
            $liveAgentId = $request['X-PH-Live'];
            $this->__updateLiveAgent($callLogId, $liveAgentId, 'INCALL');
            $callbackUrl = site_url('callback/callbackUrl');
            $response = '<Response>
                        <Speak>Connecting your call..</Speak>
                        <Dial callbackUrl="' . $callbackUrl . '" action="http://gravitybpx.com/callback/dial_status/" method="GET" redirect="true" callerId="' . $request['X-PH-Caller'] . '">
                            <User>' . $request['To'] . '</User>
                        </Dial>
                    </Response>';
        }
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
    }

    public function callbackUrl() {
        $this->load->model('callog_m');
        $data = $_REQUEST;
        //$this->__log($data);
        $CallUUID = $data['CallUUID'];
        $options = array(
            'LIMIT' => array('start' => 0, 'end' => 1),
            'conditions' => "CallUUID = '{$CallUUID}'"
        );
        $logs = $this->callog_m->get_relation('', $options);
        $status = $data['DialAction'];
        if ($status == 'hangup' && $logs) {
            $log = $logs[0];
            $timeFirst = strtotime($log['start_time']);
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
        if ($callUniqueId) {
            /* ---------- For User Log ------- */
            $this->load->model('Agents');
            $this->load->model('leadstore_m');
            $agent_data = $this->Agents->get($array['X-PH-Agent'], TRUE);
            $lead_data = $this->leadstore_m->get_by(['phone' => substr($data['number_dialed'], 1), 'user' => $array['X-PH-Agent']], TRUE);
            if ($lead_data->member_id != '') {
                $m_id = $lead_data->member_id;
            } else {
                $m_id = $lead_data->phone;
            }
            $from_id = $agent_data->user_id;
            $to_id = $agent_data->user_id;
            $feed_type = 0;
            $log_type = 'outbound';
            $title = "New Outbound Call For " . $m_id;
            $log_url = '';
            user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
            /* ---------- End For User Log ------- */
        }
        return $callUniqueId;
    }

    private function __addInboundCallLog($array = array()) {
        $this->load->model('callog_m');
        $data = array(
            'agent_id' => $array['X-PH-Agent'],
            'CallUUID' => $array['CallUUID'],
            'channel' => $array['From'],
            'type' => $array['type'],
            'extension' => $array['From'],
            'number_dialed' => $array['To'],
            'start_time' => $array['start_time']
        );
        $callUniqueId = $this->callog_m->save($data, NULL);
        if ($callUniqueId) {
            /* ---------- For User Log ------- */
            $this->load->model('Agents');
            $this->load->model('leadstore_m');
            $agent_data = $this->Agents->get($array['X-PH-Agent'], TRUE);
            $lead_data = $this->leadstore_m->get_by(['phone' => substr($data['number_dialed'], 1), 'user' => $array['X-PH-Agent']], TRUE);
            if ($lead_data->member_id != '') {
                $m_id = $lead_data->member_id;
            } else {
                $m_id = $lead_data->phone;
            }
            $from_id = $agent_data->user_id;
            $to_id = $agent_data->user_id;
            $feed_type = 0;
            $log_type = 'inbound';
            // $title= "New Inbound Call For ".$m_id;
            $title = "New Inbound Call";
            $log_url = '';
            user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
            /* ---------- End For User Log ------- */
        }
        return $callUniqueId;
    }

    private function __updateLiveAgent($uniqueId, $liveAgentId, $status) {
        $this->load->model('LiveAgent_m', 'liveagent_m');
        //$this->session->userdata('liveagent')->liveagent

        $data = array(
            'status' => $status,
            'uniqueid' => $uniqueId,
        );
        $this->liveagent_m->save($data, $liveAgentId);
    }

    public function inbound() {
        $request = $_REQUEST;
        $request['start_time'] = date('Y-m-d H:i:s');
        $request['type'] = 'inbound';
        switch ($request['To']) {
            case '19162459143':
                $agentId = '67';
                $sip = 'sip:clayton170622050411@phone.plivo.com';
                break;
            case '17722071345':
                $agentId = '118';
                $sip = 'sip:davidpaul170622055813@phone.plivo.com';
                break;
            case '18055381288' :
                $agentId = '116';
                $sip = 'sip:brandon170622050331@phone.plivo.com';
                break;
            case '15597951559':
                $agentId = '103';
                $sip = 'sip:gravitybpx170615104909@phone.plivo.com';
                break;
            default :
                $agentId = '103';
                $sip = 'sip:gravitybpx170615104909@phone.plivo.com';
                break;
        }

        $this->load->model('LiveAgent_m', 'liveagent_m');
        $options = array(
            'LIMIT' => array('start' => 0, 'end' => '1'),
            'conditions' => "user IN ($agentId)",
        );
        $result = $this->liveagent_m->get_relation('', $options);

        if ($result && (!empty($result[0])) && $result[0]['status'] == 'READY') {
            $agent = $result[0];
            $this->load->model('agents');
            $ag = $this->agents->get_by(array('user_id' => $agent['user']), TRUE);
            $request['X-PH-Agent'] = $ag->id;
            $collLogId = $this->__addInboundCallLog($request);
            $callbackUrl = site_url('callback/inboundCallbackUrl/' . $agent['live_agent_id']);
            //$this->__log($collLogId);
            $this->__updateLiveAgent($collLogId, $agent['live_agent_id'], 'INCALL');
            $response = '<Response>
                        <Speak>Connecting your call..</Speak>
                        <Dial  callbackUrl="' . $callbackUrl . '" action="https://gravitybpx.com/callback/dial_status/" method="GET" redirect="true" callerId="' . $request['From'] . '">
                            <User>' . $sip . '</User>
                        </Dial>
                    </Response>';
            Header('Content-type: text/xml');
            echo $response;
            exit;
        } else {
            $response = '<Response>
                        <Speak>Leave your message after the tone</Speak>
                        <Record  action="http://gravitybpx.com/callback/voicemail/' . $agentId . '" method="GET"  maxLength="30" transcriptionType="auto" transcriptionUrl="http://gravitybpx.com/callback/test" transcriptionMethod="GET" />
                    </Response>';
            Header('Content-type: text/xml');
            echo $response;
            exit;
        }
    }

    public function inboundCallbackUrl($liveAgent) {
        $this->load->model('callog_m');
        $data = $_REQUEST;
        //$this->__log($data);
        $CallUUID = $data['CallUUID'];
        $options = array(
            'LIMIT' => array('start' => 0, 'end' => 1),
            'conditions' => "CallUUID = '{$CallUUID}'"
        );
        $logs = $this->callog_m->get_relation('', $options);
        $status = $data['DialAction'];
        if ($status == 'hangup' && $logs) {
            $log = $logs[0];
            $timeFirst = strtotime($log['start_time']);
            $endTime = date('Y-m-d H:i:s');
            $timeEnd = strtotime($endTime);
            $save['end_time'] = $endTime;
            $save['length_in_sec'] = $timeEnd - $timeFirst;
            $save['length_in_min'] = ($timeEnd - $timeFirst) / 60;
            $this->callog_m->save($save, $log['unique_id']);
            $liveAgentId = $liveAgent;
            $this->__updateLiveAgent(0, $liveAgentId, 'DISPO');
        }
    }

    public function voicemail($agentId) {
        $request = $_REQUEST;
        $this->load->model('Voicemails_m');
        $data = array(
            'agent_id' => $agentId,
            'CallUUID' => $request['CallUUID'],
            'voicemail_url' => $request['RecordUrl'],
            'from' => $request['From'],
            'created' => date("Y-m-d H:i:s"),
            'modified' => date("Y-m-d H:i:s"),
        );
        $this->Voicemails_m->save($data);
    }

    public function transfer($num = null) {
        $myfile = fopen("/var/www/html/uploads/transfer.txt", "w") or die("Unable to open file!");
        $txt = var_export($_REQUEST, true);
        fwrite($myfile, $txt);
        fclose($myfile);
        $request = $_REQUEST;
        $response = '<Response>
            <Speak>Connecting your call</Speak>
            <Dial callerId="' . $request['X-PH-Caller'] . '" action="https://morning-ocean-4669.herokuapp.com/dial_status/" method="GET" redirect="true">
                <Number>' . $num . '</Number>
            </Dial>
        </Response>';
        Header('Content-type: text/xml');
        echo $response;
        exit;
    }

    public function transfer1($num = null) {
        $myfile = fopen("/var/www/html/uploads/transfer.txt", "w") or die("Unable to open file!");
        $txt = var_export($_REQUEST, true);
        fwrite($myfile, $txt);
        fclose($myfile);
        $request = $_REQUEST;
        $response = '<Response>
            <Speak>Connecting your call</Speak>
            <Dial action="https://morning-ocean-4669.herokuapp.com/dial_status/" method="GET" redirect="true">
                <Number>917405173235</Number>
            </Dial>
        </Response>';
        Header('Content-type: text/xml');
        echo $response;
        exit;
    }

    public function smsdemo() {
        $this->load->library('Plivo_sms');
        $this->load->model('leadSmsLog_m', 'leadsmslog_m');
        //$smsres = $this->plivo_sms->sendDummysms('15597951559');
        //pr($smsres);
        $resp = $this->plivo_sms->receiveSMS();
        if (!empty($resp)) {
            // $dataSave = array('sms_status' => 'inbound', 'sender_number' => substr($resp['From'], 1), 'receiver_number' => substr($resp['To'], 1), 'text' => $resp['Text'], 'plivo_response' => serialize($resp));
            $dataSave = array('sms_status' => 'inbound', 'sender_number' => $resp['To'], 'receiver_number' => $resp['From'], 'text' => $resp['Text'], 'plivo_response' => serialize($resp));
            $this->leadsmslog_m->save($dataSave, NULL);
        }
    }

    /**
     * @uses SMS Receive.
     */
    public function smsreceive() {
        $this->load->library('Plivo_sms');
        $this->load->model('leadSmsLog_m', 'leadsmslog_m');
        $this->load->model('Agents');
        $this->load->model('leadnotes_m');
        $this->load->model('Leadstore_m');
        $resp = $this->plivo_sms->receiveSMS();
        $this->__log($resp);
        if (!empty($resp)) {
            $dataSave = array('sms_status' => 'inbound', 'sender_number' => $resp['From'], 'receiver_number' => $resp['To'], 'text' => $resp['Text'], 'plivo_response' => serialize($resp), 'msg_status' => 'unseen');
            $this->leadsmslog_m->save($dataSave, NULL);
            /* ---------- For User Log ------- */
            $agent_data = $this->Agents->get_by(['plivo_phone' => substr($resp['To'], 1)], TRUE);
            if ($agent_data->user_id != '') {
                $lead_data = $this->Leadstore_m->get_by(['phone' => substr($resp['From'], 1)], TRUE);
                if ($lead_data->first_name != '') {
                    $name = $lead_data->first_name . " " . $lead_data->last_name;
                } else {
                    $name = $lead_data->phone;
                }
                /* ---------- For LEAD NOTE ------- */
                $noteArray = array('lead_id' => $lead_data->lead_id, 'user_group_id' => $this->session->userdata('user')->user_group_id, 'user_id' => $this->session->userdata('user')->id, 'notes' => 'SMS Sent TO');
                $this->leadnotes_m->save($noteArray);
                /* ---------------------------------- */
                $from_id = 0;
                $to_id = $agent_data->user_id;
                $feed_type = 0; // Activity Feed
                $log_type = strtolower('receive_sms');
                $title = "New SMS Receive from " . $name;
                $log_url = '';
                user_log($from_id, $to_id, $feed_type, $log_type, $title, $log_url);
            }
            /* ---------- End For User Log ------- */
        }
    }

    public function conference_xml($CallUUID = null, $conference = 'demo') {
        $myfile = fopen("/var/www/html/uploads/conf.txt", "w") or die("Unable to open file!");
        $txt = var_export($_REQUEST, true);
        fwrite($myfile, $txt);
        fclose($myfile);
        /* $this->load->library('plivoresponse');
          $r = $this->plivoresponse;
          $body = "You will now be placed into a conference.";
          $r->addSpeak($body);

          $params = array(
          'enterSound' => "beep:2", # Used to play a sound when a member enters the conference
          'record' => "false", # Option to record the call
          'action' => "https://gravitybpx.com/callback/conf_action", # URL to which the API can send back parameters
          'method' => "GET", # method to invoke the action Url
          'record' => "true", # Option to record the call
          'callbackUrl' => "https://gravitybpx.com/callback/conf_callback", # If specified, information is sent back to this URL
          'callbackMethod' => "GET", # Method used to notify callbackUrl
          # For moderated conference
          'startConferenceOnEnter' => "true", # When a member joins the conference with this attribute set to true, the conference is started.
          # If a member joins a conference that has not yet started, with this attribute value set to false,
          # the member is muted and hears background music until another member joins the conference
          'endConferenceOnExit' => "false" # If a member with this attribute set to true leaves the conference, the conference ends and all
          # other members are automatically removed from the conference.
          );

          $conference_name = time();
          $r->addConference($conference_name, $params);
         */
        $conference_name = $conference;
        $response = '<Response><Speak>You will now be placed into a conference.</Speak><Conference enterSound="beep:1" record="true" action="'.site_url('callback/conf_action/'.$CallUUID.'/'.$conference).'" method="GET" callbackUrl="'.site_url('callback/conf_callback/'.$CallUUID.'/'.$conference).'" callbackMethod="GET" startConferenceOnEnter="true" endConferenceOnExit="true">' . $conference_name . '</Conference></Response>';
        Header('Content-type: text/xml');
        echo($response);
    }

    public function conf_action($CallUUID = null, $conference = 'demo') {
        $conf_name = $_REQUEST['ConferenceName'];
        $conf_uuid = $_REQUEST['ConferenceUUID'];
        $conf_mem_id = $_REQUEST['ConferenceMemberID'];
        $record_url = $_REQUEST['RecordUrl'];
        $record_id = $_REQUEST['RecordingID'];
        $log = "Conference Name : $conf_name, Conference UUID : $conf_uuid, Conference Member ID : $conf_mem_id, Record URL : $record_url, Record ID : $record_id";
        $myfile = fopen("/var/www/html/uploads/conf_action.txt", "w") or die("Unable to open file!");
        $txt = var_export($log, true);
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function conf_callback($CallUUID = null, $conference = 'demo') {
        $conf_action = $_REQUEST['ConferenceAction'];
        $conf_name = $_REQUEST['ConferenceName'];
        $conf_uuid = $_REQUEST['ConferenceUUID'];
        $conf_mem_id = $_REQUEST['ConferenceMemberID'];
        $call_uuid = $_REQUEST['CallUUID'];
        $record_url = $_REQUEST['RecordUrl'];
        $record_id = $_REQUEST['RecordingID'];
        $log = "Conference Action : $conf_action, Conference Name : $conf_name, Conference UUID : $conf_uuid,
        Conference Member ID : $conf_mem_id, Call UUID : $call_uuid, Record URL : $record_url, Record ID : $record_id";
        $myfile = fopen("/var/www/html/uploads/conf_callback.txt", "w") or die("Unable to open file!");
        $txt = var_export($log, true);
        fwrite($myfile, $txt);
        fclose($myfile);
    }

}
