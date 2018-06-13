<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller {

    private $_template;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name == 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->_template = strtolower($this->session->userdata('user')->group_name);
        $this->load->library('vicidialdb');
        $this->load->model('agency_model');
        $this->load->model('agent_model');
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/vlists_m', 'vlists_m');
        $this->load->model('vicidial/vugroup_m', 'vugroup_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
    }

    public function userstat() {
        $this->data ['datatable'] = TRUE;
        $this->data ['model'] = TRUE;
        $this->data ['audiojs'] = TRUE;
        $this->data ['validation'] = TRUE;
        $this->data ['sweetAlert'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        $this->data ['listtitle'] = 'User Stats';
        $this->data ['title'] = 'User Stats';
        $this->data ['breadcrumb'] = "User Stats";
        $this->data ['agencies'] = $this->agency_model->get_nested();
        $this->data ['result'] = FALSE;

        if ($post = $this->input->post()) {
            $this->data ['postData'] = $post;
            $this->data ['result'] = TRUE;
            extract($post);
            $formdate = date('Y-m-d', strtotime($formdate));
            $todate = date('Y-m-d', strtotime($todate));
            /* start of report AGENT TALK TIME AND STATUS */
            $stmt = "SELECT count(*) AS count,status, SUM(length_in_sec) AS sum FROM vicidial_log WHERE user='" . $user_start . "' AND call_date >= '" . $formdate . " 0:00:01'  AND call_date <= '" . $todate . " 23:59:59' GROUP BY status ORDER BY status";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $VLstatuses_to_print = count($result);
            $total_calls = 0;
            $o = 0;
            $p = 0;
            $counts = array();
            $status = array();
            $call_sec = array();
            while ($VLstatuses_to_print > $o) {
                $counts [$p] = $result [$p]->count;
                $status [$p] = $result [$p]->status;
                $call_sec [$p] = $result [$p]->sum;
                $p ++;
                $o ++;
            }
            $stmt = "SELECT COUNT(*) AS count,status, sum(length_in_sec) AS sum from vicidial_closer_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' group by status order by status";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $VCLstatuses_to_print = count($result);
            $o = 0;
            while ($VCLstatuses_to_print > $o) {
                $status_match = 0;
                $r = 0;
                while ($VLstatuses_to_print > $r) {
                    if ($status [$r] == $result [$o]->status) {
                        $counts [$r] = ($counts [$r] + $result [$o]->count);
                        $call_sec [$r] = ($call_sec [$r] + $result [$o]->sum);
                        $status_match ++;
                    }
                    $r ++;
                }
                if ($status_match < 1) {
                    $counts [$p] = $result [$o]->count;
                    $status [$p] = $result [$o]->status;
                    $call_sec [$p] = $result [$o]->sum;
                    $VLstatuses_to_print ++;
                    $p ++;
                }
                $o ++;
            }
            $this->data ['talktime'] = array(
                'status' => $status,
                'counts' => $counts,
                'call_sec' => $call_sec,
                'p' => $p,
                'total_calls' => $total_calls
            );
            /* end of report AGENT TALK TIME AND STATUS */
            /* start Login and Logout time from vicidial agent interface */
            $stmt = "SELECT event,event_epoch,event_date,campaign_id,user_group,session_id,server_ip,extension,computer_ip,phone_login,phone_ip from vicidial_user_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $events_to_print = count($result);
            $this->data ['events'] = $result;
            /* end of Login and Logout time from vicidial agent interface */
            /* start of closer in-group selection logs */
            $stmt = "select user,campaign_id,event_date,blended,closer_campaigns,manager_change from vicidial_user_closer_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 1000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['closers'] = $result;
            /* end of closer in-group selection logs */
            /* start of vicidial agent outbound calls for this time period */
            $stmt = "select uniqueid,lead_id,list_id,campaign_id,call_date,start_epoch,end_epoch,length_in_sec,status,phone_code,phone_number,user,comments,processed,user_group,term_reason,alt_dial from vicidial_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $this->data ['outbounds'] = $result;
            /* end of vicidial agent outbound calls for this time period */
            /* start of vicidial agent inbound calls for this time period */
            $stmt = "select call_date,length_in_sec,status,phone_number,campaign_id,queue_seconds,list_id,lead_id,term_reason from vicidial_closer_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['inbounds'] = $result;
            /* end of vicidial agent inbound calls for this time period */
            /* start of vicidial agent activity records for this time period */
            $stmt = "select event_time,lead_id,campaign_id,pause_sec,wait_sec,talk_sec,dispo_sec,dead_sec,status,sub_status,user_group from vicidial_agent_log where user='" . $user_start . "' and event_time >= '" . $formdate . " 0:00:01'  and event_time <= '" . $todate . " 23:59:59' and ( (pause_sec > 0) or (wait_sec > 0) or (talk_sec > 0) or (dispo_sec > 0) ) order by event_time desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['activities'] = $result;
            /* end of vicidial agent activity records for this time period */
            /* start of vicidial recordings for this time period */
            $stmt = "select recording_id,channel,server_ip,extension,start_time,start_epoch,end_time,end_epoch,length_in_sec,length_in_min,filename,location,lead_id,user,vicidial_id from recording_log where user='" . $user_start . "' and start_time >= '" . $formdate . " 0:00:01'  and start_time <= '" . $todate . " 23:59:59' order by recording_id desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['recordings'] = $result;
            /* end of vicidial recordings for this time period */
            /* start of vicidial agent outbound user manual calls for this time period */
            $stmt = "select call_date,call_type,server_ip,phone_number,number_dialed,lead_id,callerid,group_alias_id,preset_name,customer_hungup,customer_hungup_seconds from user_call_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['manuals'] = $result;
            /* end of vicidial agent outbound user manual calls for this time period */
            /* start of vicidial lead searches for this time period */
            $stmt = "select event_date,source,results,seconds,search_query from vicidial_lead_search_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['searches'] = $result;
            /* end of vicidial lead searches for this time period */
            /* start of vicidial agent manual dial lead preview skips for this time period */
            $stmt = "select user,event_date,lead_id,campaign_id,previous_status,previous_called_count from vicidial_agent_skip_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 10000;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result();
            $logs_to_print = count($result);
            $this->data ['skips'] = $result;
            /* end of vicidial agent manual dial lead preview skips for this time period */
        }
        $this->template->load($this->_template, 'dialer/report/stat', $this->data);
    }

    public function download() {
        $this->load->helper('download');
        $reportsArray = array(
            'talktime',
            'events',
            'closers',
            'outbounds',
            'inbounds',
            'activities',
            'recordings',
            'manuals',
            'searches',
            'skips'
        );
        $csvtext = '';
        $data = $this->input->get();
        if ($data && in_array($data ['report'], $reportsArray)) {
            $agencyId = decode_url($data ['agency']);
            $agency = $this->agency_model->getAgencyInfo($agencyId);
            $agencyName = $agency->name;
            $user_start = $data ['user'];
            $formdate = date('Y-m-d', strtotime($data ['begin_date']));
            $todate = date('Y-m-d', strtotime($data ['end_date']));
            switch (trim($data ['report'])) {
                case 'talktime' :
                    $csvtext .= "\"" . ("AGENT TALK TIME AND STATUS") . "\"\n";
                    $csvtext .= "\"AGENCY\",\"AGENT\",\"" . ("STATUS") . "\",\"" . ("COUNT") . "\",\"" . ("HOURS:MM:SS") . "\"\n";
                    $stmt = "SELECT count(*) AS count,status, sum(length_in_sec) AS sum from vicidial_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' group by status order by status";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $VLstatuses_to_print = count($result);
                    $total_calls = 0;
                    $o = 0;
                    $p = 0;
                    $counts = array();
                    $status = array();
                    $call_sec = array();
                    while ($VLstatuses_to_print > $o) {
                        $counts [$p] = $result [$p]->count;
                        $status [$p] = $result [$p]->status;
                        $call_sec [$p] = $result [$p]->sum;
                        $p ++;
                        $o ++;
                    }
                    $stmt = "SELECT count(*) AS count,status, sum(length_in_sec) AS sum from vicidial_closer_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' group by status order by status";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $VCLstatuses_to_print = count($result);
                    $o = 0;
                    while ($VCLstatuses_to_print > $o) {
                        $status_match = 0;
                        $r = 0;
                        while ($VLstatuses_to_print > $r) {
                            if ($status [$r] == $result [$o]->status) {
                                $counts [$r] = ($counts [$r] + $result [$o]->count);
                                $call_sec [$r] = ($call_sec [$r] + $result [$o]->sum);
                                $status_match ++;
                            }
                            $r ++;
                        }
                        if ($status_match < 1) {
                            $counts [$p] = $result [$o]->count;
                            $status [$p] = $result [$o]->status;
                            $call_sec [$p] = $result [$o]->sum;
                            $VLstatuses_to_print ++;
                            $p ++;
                        }
                        $o ++;
                    }
                    $o = 0;
                    $total_sec = 0;
                    while ($o < $p) {
                        $call_hours_minutes = sec_convert($call_sec [$o], 'H');
                        $csvtext .= "\"$agencyName\",\"$user_start\",\"$status[$o]\",\"$counts[$o]\",\"$call_hours_minutes\"\n";
                        $total_calls = ($total_calls + $counts [$o]);
                        $total_sec = ($total_sec + $call_sec [$o]);
                        $call_seconds = 0;
                        $o ++;
                    }
                    $call_hours_minutes = sec_convert($total_sec, 'H');
                    $csvtext .= "\"" . ("TOTAL CALLS") . "\",\"$total_calls\",\"$call_hours_minutes\"\n";
                    break;
                case 'events' :
                    $csvtext .= "AGENT LOGIN/LOGOUT TIME \n";
                    $csvtext .= "AGENCY, AGENT, EVENT, DATE, CAMPAIGN, GROUP, HOURS:MM:SS, SESSION, SERVER, PHONE,COMPUTER, PHONE_LOGIN,PHONE_IP \n";
                    $stmt = "SELECT event,event_epoch,event_date,campaign_id,user_group,session_id,server_ip,extension,computer_ip,phone_login,phone_ip from vicidial_user_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $total_calls = 0;
                    $event_start_seconds = '';
                    $event_stop_seconds = '';
                    foreach ($result as $row) {
                        if (preg_match('/LOGIN/', $row->event)) {
                            if ($row->phone_ip == 'LOOKUP') {
                                $row->phone_ip = '';
                            }
                            $event_start_seconds = $row->event_epoch;
                            // $csvtext.= "{$agencyName}, {$user_start}, {$row->event}, {$row->event_date}, {$row->campaign_id}, {$row->user_group}, {$row->server_ip}, {$row->extension}, {$row->computer_ip}, {$row->phone_login}, {$row->phone_ip} \n";
                            $csvtext .= "\"$agencyName\",\"$user_start\",\"$row->event\",\"$row->event_date\",\"$row->campaign_id\",\"$row->user_group\",\"\",\"$row->session_id\",\"$row->server_ip\",\"$row->extension\",\"$row->computer_ip\",\"$row->phone_login\",\"$row->phone_ip\"\n";
                        } // if (preg_match('/LOGIN/', $event->event))
                        if (preg_match('/LOGOUT/', $row->event)) {
                            if ($event_start_seconds) {
                                $event_stop_seconds = $row->event_epoch;
                                $event_seconds = ($event_stop_seconds - $event_start_seconds);
                                $total_login_time = ($total_login_time + $event_seconds);
                                $event_hours_minutes = sec_convert($event_seconds, 'H');
                                $csvtext .= "\"$agencyName\",\"$user_start\",\"$row->event\",\"$row->event_date\",\"$row->campaign_id\",\"$row->user_group\",\"$event_hours_minutes\"\n";
                            } else {
                                $csvtext .= "\"$agencyName\",\"$user_start\",\"$row->event\",\"$row->event_date\",\"$row->campaign_id\"\n";
                            }
                        } // if (preg_match('/LOGOUT/', $event->event))
                    }
                    $total_login_hours_minutes = sec_convert($total_login_time, 'H');
                    $csvtext .= "\"" . ("TOTAL") . "\",\"\",\"\",\"\",\"\",\"\",\"$total_login_hours_minutes\"\n";
                    break;
                case 'closers' :
                    $stmt = "select user,campaign_id,event_date,blended,closer_campaigns,manager_change from vicidial_user_closer_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 1000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $logs_to_print = count($result);
                    $csvtext .= "\"" . ("CLOSER IN-GROUP SELECTION LOGS") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("CAMPAIGN") . "\",\"" . ("BLEND") . "\",\"" . ("GROUPS") . "\",\"" . ("MANAGER") . "\"\n";
                    foreach ($result as $row) {
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->event_date\",\"$row->campaign_id\",\"$row->blended\",\"$row->closer_campaigns\",\"$row->manager_change \"\n";
                    }
                    break;
                case 'outbounds' :
                    $stmt = "select uniqueid,lead_id,list_id,campaign_id,call_date,start_epoch,end_epoch,length_in_sec,status,phone_code,phone_number,user,comments,processed,user_group,term_reason,alt_dial from vicidial_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("LENGTH") . "\",\"" . ("STATUS") . "\",\"" . ("PHONE") . "\",\"" . ("CAMPAIGN") . "\",\"" . ("GROUP") . "\",\"" . ("LIST") . "\",\"" . ("LEAD") . "\",\"" . ("HANGUP REASON") . "\"\n";
                    $u = 0;
                    foreach ($result as $row) {
                        $u ++;
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->call_date\",\"$row->length_in_sec\",\"$row->status\",\"$row->phone_number\",\"$row->campaign_id\",\"$row->user_group\",\"$row->list_id\",\"$row->uniqueid\",\"$row->term_reason\"\n";
                    }
                    break;
                case 'inbounds' :
                    $stmt = "select call_date,length_in_sec,status,phone_number,campaign_id,queue_seconds,list_id,lead_id,term_reason from vicidial_closer_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"" . ("INBOUND/CLOSER CALLS FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("LENGTH") . "\",\"" . ("STATUS") . "\",\"" . ("PHONE") . "\",\"" . ("CAMPAIGN") . "\",\"" . ("WAIT(S)") . "\",\"" . ("AGENT(S)") . "\",\"" . ("LIST") . "\",\"" . ("LEAD") . "\",\"" . ("HANGUP REASON") . "\"\n";
                    $u = 0;
                    $TOTALinSECONDS = 0;
                    $TOTALagentSECONDS = 0;
                    foreach ($result as $row) {
                        $u ++;
                        $TOTALinSECONDS = ($TOTALinSECONDS + $inbound->length_in_sec);
                        $AGENTseconds = ($inbound->length_in_sec - $inbound->queue_seconds);
                        if ($AGENTseconds < 0) {
                            $AGENTseconds = 0;
                        }
                        $TOTALagentSECONDS = ($TOTALagentSECONDS + $AGENTseconds);
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->call_date\",\"$row->length_in_sec\",\"$row->status\",\"$row->phone_number\",\"$row->campaign_id\",\"$row->queue_seconds\",\"$AGENTseconds\",\"$row->list_id\",\"$row->lead_id\",\"$row->term_reason\"\n";
                    }
                    $csvtext .= "\"\",\"\",\"\",\"\",\"" . ("TOTALS") . "\",\"$TOTALinSECONDS\",\"\",\"\",\"\",\"\",\"$TOTALagentSECONDS\"\n";
                    break;
                case 'activities' :
                    $stmt = "select event_time,lead_id,campaign_id,pause_sec,wait_sec,talk_sec,dispo_sec,dead_sec,status,sub_status,user_group from vicidial_agent_log where user='" . $user_start . "' and event_time >= '" . $formdate . " 0:00:01'  and event_time <= '" . $todate . " 23:59:59' and ( (pause_sec > 0) or (wait_sec > 0) or (talk_sec > 0) or (dispo_sec > 0) ) order by event_time desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"" . ("AGENT ACTIVITY FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("PAUSE") . "\",\"" . ("WAIT") . "\",\"" . ("TALK") . "\",\"" . ("DISPO") . "\",\"" . ("DEAD") . "\",\"" . ("CUSTOMER") . "\",\"" . ("STATUS") . "\",\"" . ("LEAD") . "\",\"" . ("CAMPAIGN") . "\",\"" . ("PAUSE CODE") . "\"\n";
                    $u = 0;
                    $TOTALpauseSECONDS = 0;
                    $TOTALwaitSECONDS = 0;
                    $TOTALtalkSECONDS = 0;
                    $TOTALdispoSECONDS = 0;
                    $TOTALdeadSECONDS = 0;
                    $TOTALcustomerSECONDS = 0;
                    foreach ($result as $row) {
                        $u ++;
                        $event_time = $row->event_time;
                        $lead_id = $row->lead_id;
                        $campaign_id = $row->campaign_id;
                        $pause_sec = $row->pause_sec;
                        $wait_sec = $row->wait_sec;
                        $talk_sec = $row->talk_sec;
                        $dispo_sec = $row->dispo_sec;
                        $dead_sec = $row->dead_sec;
                        $status = $row->status;
                        $pause_code = $row->sub_status;
                        $user_group = $row->user_group;
                        $customer_sec = ($talk_sec - $dead_sec);
                        $customer_sec = ($talk_sec - $dead_sec);
                        if ($customer_sec < 0) {
                            $customer_sec = 0;
                        }
                        $TOTALpauseSECONDS = ($TOTALpauseSECONDS + $pause_sec);
                        $TOTALwaitSECONDS = ($TOTALwaitSECONDS + $wait_sec);
                        $TOTALtalkSECONDS = ($TOTALtalkSECONDS + $talk_sec);
                        $TOTALdispoSECONDS = ($TOTALdispoSECONDS + $dispo_sec);
                        $TOTALdeadSECONDS = ($TOTALdeadSECONDS + $dead_sec);
                        $TOTALcustomerSECONDS = ($TOTALcustomerSECONDS + $customer_sec);
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$event_time\",\"$pause_sec\",\"$wait_sec\",\"$talk_sec\",\"$dispo_sec\",\"$dead_sec\",\"$customer_sec\",\"$status\",\"$lead_id\",\"$campaign_id\",\"$pause_code \"\n";
                    }
                    $csvtext .= "\"\",\"\",\"\",\"" . ("TOTALS") . "\",\"$TOTALpauseSECONDS\",\"$TOTALwaitSECONDS\",\"$TOTALtalkSECONDS\",\"$TOTALdispoSECONDS\",\"$TOTALdeadSECONDS\",\"$TOTALcustomerSECONDS\"\n";
                    $TOTALpauseSECONDShh = sec_convert($TOTALpauseSECONDS, 'H');
                    $TOTALwaitSECONDShh = sec_convert($TOTALwaitSECONDS, 'H');
                    $TOTALtalkSECONDShh = sec_convert($TOTALtalkSECONDS, 'H');
                    $TOTALdispoSECONDShh = sec_convert($TOTALdispoSECONDS, 'H');
                    $TOTALdeadSECONDShh = sec_convert($TOTALdeadSECONDS, 'H');
                    $TOTALcustomerSECONDShh = sec_convert($TOTALcustomerSECONDS, 'H');
                    $csvtext .= "\"\",\"\",\"\",\"" . ("(in HH:MM:SS)") . "\",\"$TOTALpauseSECONDShh\",\"$TOTALwaitSECONDShh\",\"$TOTALtalkSECONDShh\",\"$TOTALdispoSECONDShh\",\"$TOTALdeadSECONDShh\",\"$TOTALcustomerSECONDShh\"\n";
                    break;
                case 'recordings' :
                    $stmt = "select recording_id,channel,server_ip,extension,start_time,start_epoch,end_time,end_epoch,length_in_sec,length_in_min,filename,location,lead_id,user,vicidial_id from recording_log where user='" . $user_start . "' and start_time >= '" . $formdate . " 0:00:01'  and start_time <= '" . $todate . " 23:59:59' order by recording_id desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $u = 0;
                    $csvtext .= "\"" . ("RECORDINGS FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("LEAD") . "\",\"" . ("DATE/TIME") . "\",\"" . ("SECONDS") . "\",\"" . ("RECID") . "\",\"" . ("FILENAME") . "\",\"" . ("LOCATION") . "\"\n";
                    foreach ($result as $row) {
                        $u ++;
                        $location = $row->location;
                        $CSV_location = $row->location;
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->lead_id\",\"$row->start_time\",\"$row->length_in_sec\",\"$row->recording_id\",\"$row->filename\",\"$CSV_location\"\n";
                    }
                    break;
                case 'manuals' :
                    $stmt = "select call_date,call_type,server_ip,phone_number,number_dialed,lead_id,callerid,group_alias_id,preset_name,customer_hungup,customer_hungup_seconds from user_call_log where user='" . $user_start . "' and call_date >= '" . $formdate . " 0:00:01'  and call_date <= '" . $todate . " 23:59:59' order by call_date desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"" . ("MANUAL OUTBOUND CALLS FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("CALL TYPE") . "\",\"" . ("SERVER") . "\",\"" . ("PHONE") . "\",\"" . ("DIALED") . "\",\"" . ("LEAD") . "\",\"" . ("CALLERID") . "\",\"" . ("ALIAS") . "\",\"" . ("PRESET") . "\",\"" . ("C3HU") . "\"\n";
                    $u = 0;
                    foreach ($result as $row) {
                        $C3HU = '';
                        if ($row->customer_hungup == 'BEFORE_CALL') {
                            $row->customer_hungup = 'BC';
                        }
                        if ($row->customer_hungup) {
                            $row->customer_hungup = 'DC';
                        }
                        if (strlen($row->customer_hungup) > 1) {
                            $C3HU = "$row->customer_hungup $row->customer_hungup_seconds";
                        }
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->call_date\",\"$row->call_type\",\"$row->server_ip\",\"$row->phone_number\",\"$row->number_dialed\",\"$row->lead_id\",\"$row->callerid\",\"$row->group_alias_id\",\"$row->preset_name\",\"$C3HU\"\n";
                    }
                    break;
                case 'searches' :
                    $stmt = "select event_date,source,results,seconds,search_query from vicidial_lead_search_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"" . ("LEAD SEARCHES FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("TYPE") . "\",\"" . ("RESULTS") . "\",\"" . ("SEC") . "\",\"" . ("QUERY") . "\"\n";
                    $u = 0;
                    foreach ($result as $row) {
                        $row->search_query = preg_replace('/select count\(\*\) from vicidial_list where/', '', $row->search_query);
                        $row->search_query = preg_replace('/SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner from vicidial_list where /', '', $row->search_query);
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->event_date\",\"$row->source\",\"$row->results\",\"$row->seconds\",\"$row->search_query\"\n";
                    }
                    break;
                case 'skips' :
                    $stmt = "select user,event_date,lead_id,campaign_id,previous_status,previous_called_count from vicidial_agent_skip_log where user='" . $user_start . "' and event_date >= '" . $formdate . " 0:00:01'  and event_date <= '" . $todate . " 23:59:59' order by event_date desc limit 10000;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result();
                    $csvtext .= "\"" . ("PREVIEW LEAD SKIPS FOR THIS TIME PERIOD: (10000 record limit)") . "\"\n";
                    $csvtext .= "\"#\",\"AGENCY\",\"AGENT\",\"" . ("DATE/TIME") . "\",\"" . ("LEAD ID") . "\",\"" . ("STATUS") . "\",\"" . ("COUNT") . "\",\"" . ("CAMPAIGN") . "\"\n";
                    $u = 0;
                    foreach ($result as $row) {
                        $csvtext .= "\"$u\",\"$agencyName\",\"$user_start\",\"$row->event_date\",\"$row->lead_id\",\"$row->previous_status\",\"$row->previous_called_count\",\"$row->campaign_id\"\n";
                    }
                    break;
            }
        }
        $FILE_TIME = date("Ymd-His");
        $CSVfilename = "user_stats__$FILE_TIME.csv";
        force_download($CSVfilename, $csvtext);
    }

    public function realtime() {
        $this->data ['listtitle'] = 'Real Time Report';
        $this->data ['title'] = 'Real Time Report';
        $this->data ['breadcrumb'] = "Real Time Report";
        $this->data ['agencies'] = $this->agency_model->get_nested();
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $camps = $this->vcampaigns_m->queryForAgency();
            $campaigns = array();
            if ($camps) {
                foreach ($camps as $campaign) {
                    $campaigns [] = (object) $campaign;
                }
            }
            $this->data ['campaigns'] = $campaigns;
        } else {
            $this->data ['campaigns'] = $this->vcampaigns_m->get_by(array(
                'active' => 'Y'
                    ));
        }
        $this->template->load($this->_template, 'dialer/report/realtime', $this->data);
    }

    public function realtimeajax() {
        $html = '';
        $NOW_TIME = date("Y-m-d H:i:s");
        $NOW_DAY = date("Y-m-d");
        $NOW_HOUR = date("H:i:s");
        $STARTtime = date("U");
        $epochONEminuteAGO = ($STARTtime - 60);
        $timeONEminuteAGO = date("Y-m-d H:i:s", $epochONEminuteAGO);
        $epochFIVEminutesAGO = ($STARTtime - 300);
        $timeFIVEminutesAGO = date("Y-m-d H:i:s", $epochFIVEminutesAGO);
        $epochFIFTEENminutesAGO = ($STARTtime - 900);
        $timeFIFTEENminutesAGO = date("Y-m-d H:i:s", $epochFIFTEENminutesAGO);
        $epochONEhourAGO = ($STARTtime - 3600);
        $timeONEhourAGO = date("Y-m-d H:i:s", $epochONEhourAGO);
        $epochSIXhoursAGO = ($STARTtime - 21600);
        $timeSIXhoursAGO = date("Y-m-d H:i:s", $epochSIXhoursAGO);
        $epochTWENTYFOURhoursAGO = ($STARTtime - 86400);
        $timeTWENTYFOURhoursAGO = date("Y-m-d H:i:s", $epochTWENTYFOURhoursAGO);
        $ingroup_detail = '';
        if ($post = $this->input->post()) {
            /* assign each variable */
            $RR = $this->input->post('RR') ? $this->input->post('RR') : '40';
            $inbound = $this->input->post('inbound') ? $this->input->post('inbound') : '';
            $group = $this->input->post('group') ? $this->input->post('group') : 'ALL-ACTIVE';
            $groups = $this->input->post('campaign_id') ? $this->input->post('campaign_id') : '';
            $usergroup = $this->input->post('usergroup') ? $this->input->post('usergroup') : '';
            $user_group_filter = $this->input->post('user_group_filter') ? $this->input->post('user_group_filter') : '';
            $UGdisplay = $this->input->post('UGdisplay') ? $this->input->post('UGdisplay') : 0;
            $UidORname = $this->input->post('UidORname') ? $this->input->post('UidORname') : 1;
            $orderby = $this->input->post('orderby') ? $this->input->post('orderby') : 'timeup';
            $SERVdisplay = $this->input->post('SERVdisplay') ? $this->input->post('SERVdisplay') : 0;
            $CALLSdisplay = $this->input->post('CALLSdisplay') ? $this->input->post('CALLSdisplay') : 1;
            $PHONEdisplay = $this->input->post('PHONEdisplay') ? $this->input->post('PHONEdisplay') : 0;
            $CUSTPHONEdisplay = $this->input->post('CUSTPHONEdisplay') ? $this->input->post('CUSTPHONEdisplay') : 0;
            $PAUSEcodes = $this->input->post('PAUSEcodes') ? $this->input->post('PAUSEcodes') : 'N';
            $with_inbound = $this->input->post('with_inbound') ? $this->input->post('with_inbound') : '';
            $droppedOFtotal = $this->input->post('droppedOFtotal') ? $this->input->post('droppedOFtotal') : '';
            $adastats = $this->input->post('adastats') ? $this->input->post('adastats') : '';
            $ALLINGROUPstats = $this->input->post('ALLINGROUPstats') ? $this->input->post('ALLINGROUPstats') : '';
            $monitor_active = $this->input->post('monitor_active') ? $this->input->post('monitor_active') : '';
            $monitor_phone = $this->input->post('monitor_phone') ? $this->input->post('monitor_phone') : '';
            $LOGallowed_campaigns = '-ALL-CAMPAIGNS- - -';
            $multi_drop = 0;
            $total_sales_talk_time = 0;
            $total_contact_talk_time = 0;
            $total_nonpause_time = 0;
            $total_nonpause_time = 0;
            $ingroup_detail = '';
            if ((strlen($group) > 1) && (strlen($groups [0]) < 1)) {
                $groups [0] = $group;
                $RR = 40;
            } else {
                $group = $groups [0];
            }

            $answersSQL = 'sum(answers_today)';
            $answers_singleSQL = 'answers_today';
            $answers_text = "ANSWERED";
            if ($droppedOFtotal > 0) {
                $answersSQL = 'sum(calls_today)';
                $answers_singleSQL = 'calls_today';
                $answers_text = "TOTAL" . '   ';
            }
            // #### START SYSTEM_SETTINGS LOOKUP #####
            $stmt = "SELECT use_non_latin,outbound_autodial_active,slave_db_server,reports_use_slave_db,enable_languages,language_method FROM system_settings;";
            $query = $this->vicidialdb->db->query($stmt);
            $row = $query->row();
            if (count($row) > 0) {
                $non_latin = $row->use_non_latin;
                $outbound_autodial_active = $row->outbound_autodial_active;
                $slave_db_server = $row->slave_db_server;
                $reports_use_slave_db = $row->reports_use_slave_db;
                $SSenable_languages = $row->enable_languages;
                $SSlanguage_method = $row->language_method;
            }
            if (strlen($with_inbound) > 0) {
                if ($outbound_autodial_active > 0) {
                    $with_inbound = 'Y';
                } else {
                    $with_inbound = 'o';
                }
            } // if(strlen($with_inbound) > 0)
            $group_string = '|';
            foreach ($groups as $campaign) {
                $group_string .= $campaign . '|';
            }

            /* get all campaigns data */

            if (preg_match('/ALL\-ACTIVE/i', $group_string)) {
                if ($this->session->userdata('user')->group_name == 'Agency') {
                    $campaigns = $this->vcampaigns_m->queryForAgency();
                    if (!$campaigns) {
                        $campaigns = array();
                    }
                } else {
                    $campaigns = $this->vcampaigns_m->get_by(array(
                        'active' => 'Y'
                            ));
                }
            } else {
                $ids = '';
                foreach ($groups as $value) {
                    $ids .= "'{$value}',";
                }
                $ids = rtrim($ids, ',');
                $sql = "SELECt * FROM vicidial_campaigns WHERE active = 'Y' AND campaign_id IN({$ids})";
                $campaigns = $this->vicidialdb->db->query($sql)->result();
            }

            $ALLcloser_campaignsSQL = '';
            foreach ($campaigns as $campaign) {
                if (is_array($campaign)) {
                    $campaign = (object) $campaign;
                }
                $ALLcloser_campaignsSQL .= "'$campaign->campaign_id',";
            }
            $ALLcloser_campaignsSQL = preg_replace("/,$/", "", $ALLcloser_campaignsSQL);
            if (strlen($ALLcloser_campaignsSQL) < 2) {
                $ALLcloser_campaignsSQL = "''";
            } // if (strlen($ALLcloser_campaignsSQL)<2)

            $group_SQLand = 'AND campaign_id IN(';
            $group_SQL = '';

            if ($this->session->userdata('user')->group_name == 'Agency') {
                if (preg_match('/ALL\-ACTIVE/i', $group_string)) {
                    $group_SQLand .= $ALLcloser_campaignsSQL;
                    $group_SQL .= $ALLcloser_campaignsSQL;
                } else {
                    foreach ($groups as $value) {
                        $group_SQLand .= "'$value',";
                        $group_SQL .= "'$value',";
                    }
                    $group_SQLand = rtrim($group_SQLand, ',');
                    $group_SQL = rtrim($group_SQL, ',');
                }
            } else {
                if (preg_match('/ALL\-ACTIVE/i', $group_string)) {
                    $group_SQLand .= $ALLcloser_campaignsSQL;
                    $group_SQL .= $ALLcloser_campaignsSQL;
                } else {
                    foreach ($groups as $value) {
                        $group_SQLand .= "'$value',";
                        $group_SQL .= "'$value',";
                    }
                    $group_SQLand = rtrim($group_SQLand, ',');
                    $group_SQL = rtrim($group_SQL, ',');
                }
            }
            $group_SQLand .= ')';

            $stmt = "select count(*) from vicidial_campaigns where active='Y' and campaign_allow_inbound='Y' $group_SQLand;";
            $query = $this->vicidialdb->db->query($stmt);
            $row = $query->row_array();
            $row = array_values($row);
            $campaign_allow_inbound = $row [0];
            /* INBOUND */
            $closer_campaignsSQL = "";
            if ((preg_match('/Y/', $with_inbound) || preg_match('/O/', $with_inbound)) && ($campaign_allow_inbound > 0)) {
                $closer_campaignsSQL = "";
                // ## Gather list of Closer group ids
                $stmt = "select closer_campaigns from vicidial_campaigns where active='Y' $group_SQLand;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result();
                foreach ($result as $row) {
                    $closer_campaigns = $row->closer_campaigns;
                    $closer_campaigns = preg_replace("/^ | -$/", "", $closer_campaigns);
                    $closer_campaigns = preg_replace("/ /", "','", $closer_campaigns);
                    $closer_campaignsSQL .= "'$closer_campaigns',";
                }
                $closer_campaignsSQL = preg_replace("/,$/", "", $closer_campaignsSQL);
            } // if ( ( preg_match('/Y/',$with_inbound) || preg_match('/O/',$with_inbound) ) && ($campaign_allow_inbound > 0) )
            if (strlen($closer_campaignsSQL) < 2) {
                $closer_campaignsSQL = "''";
            }

            /* SHOW IN-GROUP STATS OR INBOUND ONLY WITH VIEW-MORE */
            if (($ALLINGROUPstats > 0) || ((preg_match('/O/', $with_inbound)) && ($adastats > 1))) {
                $ingroup_detail = '';
                $stmtB = "select calls_today,drops_today,$answers_singleSQL,status_category_1,status_category_count_1,status_category_2,status_category_count_2,status_category_3,status_category_count_3,status_category_4,status_category_count_4,hold_sec_stat_one,hold_sec_stat_two,hold_sec_answer_calls,hold_sec_drop_calls,hold_sec_queue_calls,campaign_id from vicidial_campaign_stats where campaign_id IN ($closer_campaignsSQL) order by campaign_id;";
                $query = $this->vicidialdb->db->query($stmtB);
                $result = $query->result_array();
                $result = array_values($result);
                if (count($result) > 0) {
                    $ingroup_detail .= '<table style="background-color:#E6E6E6;" class="table">';
                }
                foreach ($result as $row) {
                    $row = array_values($row);
                    $callsTODAY = $row [0];
                    $dropsTODAY = $row [1];
                    $answersTODAY = $row [2];
                    $VSCcat1 = $row [3];
                    $VSCcat1tally = $row [4];
                    $VSCcat2 = $row [5];
                    $VSCcat2tally = $row [6];
                    $VSCcat3 = $row [7];
                    $VSCcat3tally = $row [8];
                    $VSCcat4 = $row [9];
                    $VSCcat4tally = $row [10];
                    $hold_sec_stat_one = $row [11];
                    $hold_sec_stat_two = $row [12];
                    $hold_sec_answer_calls = $row [13];
                    $hold_sec_drop_calls = $row [14];
                    $hold_sec_queue_calls = $row [15];
                    $ingroupdetail = $row [16];
                    $drpctTODAY = (MathZDC($dropsTODAY, $answersTODAY) * 100);
                    $drpctTODAY = round($drpctTODAY, 2);
                    $drpctTODAY = sprintf("%01.2f", $drpctTODAY);

                    $AVGhold_sec_queue_calls = MathZDC($hold_sec_queue_calls, $callsTODAY);
                    $AVGhold_sec_queue_calls = round($AVGhold_sec_queue_calls, 0);

                    $AVGhold_sec_drop_calls = MathZDC($hold_sec_drop_calls, $dropsTODAY);
                    $AVGhold_sec_drop_calls = round($AVGhold_sec_drop_calls, 0);

                    $PCThold_sec_stat_one = (MathZDC($hold_sec_stat_one, $answersTODAY) * 100);
                    $PCThold_sec_stat_one = round($PCThold_sec_stat_one, 2);
                    $PCThold_sec_stat_one = sprintf("%01.2f", $PCThold_sec_stat_one);
                    $PCThold_sec_stat_two = (MathZDC($hold_sec_stat_two, $answersTODAY) * 100);
                    $PCThold_sec_stat_two = round($PCThold_sec_stat_two, 2);
                    $PCThold_sec_stat_two = sprintf("%01.2f", $PCThold_sec_stat_two);
                    $AVGhold_sec_answer_calls = MathZDC($hold_sec_answer_calls, $answersTODAY);
                    $AVGhold_sec_answer_calls = round($AVGhold_sec_answer_calls, 0);
                    $AVG_ANSWERagent_non_pause_sec = (MathZDC($answersTODAY, $agent_non_pause_sec) * 60);
                    $AVG_ANSWERagent_non_pause_sec = round($AVG_ANSWERagent_non_pause_sec, 2);
                    $AVG_ANSWERagent_non_pause_sec = sprintf("%01.2f", $AVG_ANSWERagent_non_pause_sec);
                    $ingroup_detail .= '<tr>';
                    $ingroup_detail .= '<td class="text-right">&nbsp; &nbsp; &nbsp; &nbsp; </td>';
                    $ingroup_detail .= '<td class="text-right"><b>' . $ingroupdetail . '&nbsp; </b></td>';
                    $ingroup_detail .= '<td class="text-right"><b>CALLS TODAY:</b></td><td class="text-left">&nbsp;' . $callsTODAY . '&nbsp;</td>';
                    $ingroup_detail .= '<td class="text-right"><b>TMA 1</td><td class="text-left">&nbsp;' . $PCThold_sec_stat_one . '%&nbsp;</td>';
                    $ingroup_detail .= '<td class="text-right"><b>Average Hold time for Answered Calls:</b></td><td class="text-left">&nbsp;' . $AVGhold_sec_answer_calls . '&nbsp;</td>';
                    $ingroup_detail .= "</tr>";
                    $ingroup_detail .= '<tr>';
                    $ingroup_detail .= '<td class="text-right"></td><td class="text-left"></td>';
                    $ingroup_detail .= '<td class="text-right"><b>DROPS TODAY:</b></td><td class="text-left">&nbsp;' . $dropsTODAY . '&nbsp;</td>';
                    $ingroup_detail .= '<td class="text-right"><b>TMA 2:</b></td><td class="text-left">&nbsp;' . $PCThold_sec_stat_two . '% &nbsp;</td>';
                    $ingroup_detail .= '<td class="text-right"><b>Average Hold time for Dropped Calls:</b></td><td class="text-left">&nbsp;' . $AVGhold_sec_drop_calls . '&nbsp; </TD>';
                    $ingroup_detail .= "</tr>";
                    $ingroup_detail .= "<tr>";
                    $ingroup_detail .= '<td class="text-right"></td><td class="text-left"></td>';
                    $ingroup_detail .= '<td class="text-right"><b>ANSWERS TODAY:</b></td><td class="text-left">&nbsp;' . $answersTODAY . '&nbsp; </td>';
                    $ingroup_detail .= '<td class="text-right"><b>DROP PERCENT:</b></td><td class="text-left">&nbsp;' . $drpctTODAY . '%&nbsp;</td>';
                    $ingroup_detail .= '<td class="text-right"><b>Average Hold time for All Calls:</b></td><td class="text-left">&nbsp;' . $AVGhold_sec_queue_calls . '&nbsp; </td>';
                    $ingroup_detail .= "</tr>";
                }
                if (count($result) > 0) {
                    $ingroup_detail .= '</table>';
                }
            } // if ( ($ALLINGROUPstats > 0) or ( (preg_match('/O/',$with_inbound)) and ($adastats > 1) ) )
            /* start of NOT INBOUND ONLY */
            if (preg_match('/ALL\-ACTIVE/i', $group_string)) {
                $multi_drop ++;
                $non_inboundSQL = '';
                if (preg_match('/N/', $with_inbound)) {
                    $non_inboundSQL = "and campaign_id NOT IN($ALLcloser_campaignsSQL)";
                } else {
                    $non_inboundSQL = "and campaign_id IN($ALLcloser_campaignsSQL)";
                }
                $stmt = "select avg(auto_dial_level),min(dial_status_a),min(dial_status_b),min(dial_status_c),min(dial_status_d),min(dial_status_e),min(lead_order),min(lead_filter_id),sum(hopper_level),min(dial_method),avg(adaptive_maximum_level),avg(adaptive_dropped_percentage),avg(adaptive_dl_diff_target),avg(adaptive_intensity),min(available_only_ratio_tally),min(adaptive_latest_server_time),min(local_call_time),avg(dial_timeout),min(dial_statuses),max(agent_pause_codes_active),max(list_order_mix),max(auto_hopper_level) from vicidial_campaigns where active='Y' $group_SQLand;";

                $stmtB = "select sum(dialable_leads),sum(calls_today),sum(drops_today),avg(drops_answers_today_pct),avg(differential_onemin),avg(agents_average_onemin),sum(balance_trunk_fill),$answersSQL,max(status_category_1),sum(status_category_count_1),max(status_category_2),sum(status_category_count_2),max(status_category_3),sum(status_category_count_3),max(status_category_4),sum(status_category_count_4),sum(agent_calls_today),sum(agent_wait_today),sum(agent_custtalk_today),sum(agent_acw_today),sum(agent_pause_today) from vicidial_campaign_stats where calls_today > -1 $non_inboundSQL;";

                $stmtC = "select count(*) from vicidial_campaigns where agent_pause_codes_active!='N' and active='Y' $group_SQLand;";
            } else { // if (preg_match('/O/',$with_inbound))
                if (preg_match('/N/', $with_inbound)) {
                    $non_inboundSQL = "and campaign_id NOT IN($ALLcloser_campaignsSQL)";
                } else {
                    $non_inboundSQL = "and campaign_id IN($ALLcloser_campaignsSQL)";
                }
                $stmt = "select avg(auto_dial_level),min(dial_status_a),min(dial_status_b),min(dial_status_c),min(dial_status_d),min(dial_status_e),min(lead_order),min(lead_filter_id),sum(hopper_level),min(dial_method),avg(adaptive_maximum_level),avg(adaptive_dropped_percentage),avg(adaptive_dl_diff_target),avg(adaptive_intensity),min(available_only_ratio_tally),min(adaptive_latest_server_time),min(local_call_time),avg(dial_timeout),min(dial_statuses),max(agent_pause_codes_active),max(list_order_mix),max(auto_hopper_level) from vicidial_campaigns where active='Y' $group_SQLand;";

                $stmtB = "select sum(dialable_leads),sum(calls_today),sum(drops_today),avg(drops_answers_today_pct),avg(differential_onemin),avg(agents_average_onemin),sum(balance_trunk_fill),$answersSQL,max(status_category_1),sum(status_category_count_1),max(status_category_2),sum(status_category_count_2),max(status_category_3),sum(status_category_count_3),max(status_category_4),sum(status_category_count_4),sum(agent_calls_today),sum(agent_wait_today),sum(agent_custtalk_today),sum(agent_acw_today),sum(agent_pause_today) from vicidial_campaign_stats where calls_today > -1 $non_inboundSQL;";
                $stmtC = "select count(*) from vicidial_campaigns where agent_pause_codes_active!='N' and active='Y' $group_SQLand;";
            }

            $query = $this->vicidialdb->db->query($stmt);
            $row = $query->row_array();
            $row = array_values($row);
            $DIALlev = $row [0];
            $DIALstatusA = $row [1];
            $DIALstatusB = $row [2];
            $DIALstatusC = $row [3];
            $DIALstatusD = $row [4];
            $DIALstatusE = $row [5];
            $DIALorder = $row [6];
            $DIALfilter = $row [7];
            $HOPlev = $row [8];
            $DIALmethod = $row [9];
            $maxDIALlev = $row [10];
            $DROPmax = $row [11];
            $targetDIFF = $row [12];
            $ADAintense = $row [13];
            $ADAavailonly = $row [14];
            $TAPERtime = $row [15];
            $CALLtime = $row [16];
            $DIALtimeout = $row [17];
            $DIALstatuses = $row [18];
            $DIALmix = $row [20];
            $AHOPlev = $row [21];

            $query = $this->vicidialdb->db->query($stmtC);
            $row = $query->row_array();
            $row = array_values($row);
            $agent_pause_codes_active = $row [0];

            $stmt = "select count(*) from vicidial_hopper WHERE 1 > 0 $group_SQLand;";
            $query = $this->vicidialdb->db->query($stmt);
            $row = $query->row_array();
            $row = array_values($row);
            $VDhop = $row [0];

            $query = $this->vicidialdb->db->query($stmtB);
            $row = $query->row_array();
            $row = array_values($row);
            $DAleads = $row [0];
            $callsTODAY = $row [1];
            $dropsTODAY = $row [2];
            $drpctTODAY = $row [3];
            $diffONEMIN = $row [4];
            $agentsONEMIN = $row [5];
            $balanceFILL = $row [6];
            $answersTODAY = $row [7];
            if ($multi_drop > 0) {
                $drpctTODAY = (MathZDC($dropsTODAY, $answersTODAY) * 100);
                $drpctTODAY = round($drpctTODAY, 2);
                $drpctTODAY = sprintf("%01.2f", $drpctTODAY);
            }
            $VSCcat1 = $row [8];
            $VSCcat1tally = $row [9];
            $VSCcat2 = $row [10];
            $VSCcat2tally = $row [11];
            $VSCcat3 = $row [12];
            $VSCcat3tally = $row [13];
            $VSCcat4 = $row [14];
            $VSCcat4tally = $row [15];
            $VSCagentcalls = $row [16];
            $VSCagentwait = $row [17];
            $VSCagentcust = $row [18];
            $VSCagentacw = $row [19];
            $VSCagentpause = $row [20];
            $diffpctONEMIN = (MathZDC($diffONEMIN, $agentsONEMIN) * 100);
            $diffpctONEMIN = sprintf("%01.2f", $diffpctONEMIN);

            $stmt = "select sum(local_trunk_shortage) from vicidial_campaign_server_stats WHERE 1 > 0 $group_SQLand;";
            $query = $this->vicidialdb->db->query($stmt);
            $row = $query->row_array();
            $row = array_values($row);
            $balanceSHORT = $row [0];
            if (preg_match('/DISABLED/', $DIALmix)) {
                $DIALstatuses = (preg_replace("/ -$|^ /", "", $DIALstatuses));
                $DIALstatuses = (preg_replace('/\s/', ', ', $DIALstatuses));
            } else {
                $stmt = "select vcl_id from vicidial_campaigns_list_mix where status='ACTIVE' $group_SQLand limit 1;";
                $query = $this->vicidialdb->db->query($stmt);
                $row = $query->row_array();
                if (count($row) > 0) {
                    $row = array_values($row);
                    $DIALstatuses = "List Mix" . ": $row[0]";
                    $DIALorder = "List Mix" . ": $row[0]";
                }
            }
            $DIALlev = sprintf("%01.3f", $DIALlev);
            $agentsONEMIN = sprintf("%01.2f", $agentsONEMIN);
            $diffONEMIN = sprintf("%01.2f", $diffONEMIN);
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-bordered">';
            $html .= '<tr>';
            $html .= '<td><strong>DIAL LEVEL</strong>:</td><td class="text-right">&nbsp;' . $DIALlev . '&nbsp;</td>';
            if ($balanceFILL == 0) {
                $balanceFILL = 1;
            }
            $html .= '<td><strong>TRUNK SHORT/FILL</strong>:</td><td class="text-right">&nbsp;' . $balanceSHORT / $balanceFILL . '&nbsp;</td>';
            $html .= '<td><strong>FILTER</strong>:</td><td class="text-right">' . $DIALfilter . '</span></td>';
            $html .= '<td><strong>TIME</strong>:</td><td class="text-right time">' . $NOW_TIME . '</td>';
            $html .= '</tr>';
            if ($adastats > 1) {
                $html .= '<tr style="background-color:#CCCCCC">';
                $html .= '<td><strong>MAX LEVEL</strong>:</td><td class="text-right">&nbsp;' . $maxDIALlev . '&nbsp;</td>';
                $html .= '<td><strong>DROPPED MAX</strong>:</td><td class="text-right">&nbsp;' . $DROPmax . '%&nbsp;</td>';
                $html .= '<td><strong>TARGET DIFF</strong>:</td><td class="text-right">&nbsp;' . $targetDIFF . '&nbsp;</td>';
                $html .= '<td><strong>INTENSITY</strong>:</td><td class="text-right">&nbsp;' . $ADAintense . '&nbsp;</td>';
                $html .= '</tr>';
                $html .= '<tr style="background-color:#CCCCCC">';
                $html .= '<td><strong>DIAL TIMEOUT</strong>:</td><td class="text-right">&nbsp;' . $DIALtimeout . '&nbsp;</td>';
                $html .= '<td><strong>TAPER TIME</strong>:</td><td class="text-right">&nbsp;' . $TAPERtime . '&nbsp;</td>';
                $html .= '<td><strong>LOCAL TIME</strong>:</td><td class="text-right">&nbsp;' . $CALLtime . '&nbsp;</td>';
                $html .= '<td><strong>AVAIL ONLY</strong>:</td><td class="text-right">&nbsp;' . $ADAavailonly . '&nbsp;</td>';
                $html .= '</tr>';
            }
            $html .= '<tr>';
            $html .= '<td><strong>DIALABLE LEADS</strong>:</td><td class="text-right">&nbsp;' . $DAleads . '&nbsp;</td>';
            $html .= '<td><strong>CALLS TODAY</strong>:</td><td class="text-right">&nbsp;' . $callsTODAY . '&nbsp;</td>';
            $html .= '<td><strong>AVG AGENTS</strong>:</td><td class="text-right">&nbsp;' . $agentsONEMIN . '&nbsp;</td>';
            $html .= '<td><strong>DIAL METHOD</strong>:</td><td class="text-right">&nbsp;' . $DIALmethod . '&nbsp;</td>';
            $html .= '</tr>';

            $html .= '<tr>';
            if ($AHOPlev == 0) {
                $AHOPlev = 1;
            }
            if ($answersTODAY == 0) {
                $answersTODAY = 1;
            }
            $html .= '<td><strong>HOPPER</strong>&nbsp;<sub>(min/auto)</sub> :</td><td class="text-right">&nbsp;' . $HOPlev / $AHOPlev . '&nbsp;</td>';
            $html .= '<td><strong>DROPPED / ' . $answers_text . '</strong>:</td><td class="text-right">&nbsp;' . $dropsTODAY / $answersTODAY . '&nbsp;</td>';
            $html .= '<td><strong>DL DIFF</strong>:</td><td class="text-right">&nbsp;' . $diffONEMIN . '&nbsp;</td>';
            $html .= '<td><strong>STATUSES</strong>:</td><td class="text-right">&nbsp;' . $DIALstatuses . '&nbsp;</td>';
            $html .= '</tr>';
            $html .= '<tr>';
            if (1 == count(explode(',', $group_SQL))) {
                $html .= '<td><strong>LEADS IN HOPPER</strong>:</td><td class="text-right">&nbsp;' . $VDhop . '&nbsp;</td>';
            } else {
                $html .= '<td><strong>LEADS IN HOPPER</strong>:</td><td class="text-right">&nbsp;' . $VDhop . '&nbsp;</td>';
            }
            if ($drpctTODAY >= $DROPmax) {
                $drpctTODAY = '<b>' . $drpctTODAY . '%</b>';
            } else {
                $drpctTODAY = $drpctTODAY . '%';
            }
            $html .= '<td><strong>DROPPED PERCENT</strong>:</td><td class="text-right">&nbsp;' . $drpctTODAY . '&nbsp;</td>';
            $html .= '<td><strong>DIFF</strong>:</td><td class="text-right">&nbsp;' . $diffpctONEMIN . '% &nbsp;</td>';
            $html .= '<td><strong>ORDER</strong>:</td><td class="text-right">&nbsp;' . $DIALorder . '&nbsp;</td>';
            $html .= '</tr>';
            if (strlen($ingroup_detail) > 0) {
                $html .= '<tr style="background-color:#E6E6E6">';
                $html .= '<td colspan="8" class="text-left">';
                $html .= $ingroup_detail;
                $html .= '</td>';
                $html .= '</tr>';
            }
            $html .= '</table>';
            $html .= '</div>';
            // ##################################################################################
            // ##### INBOUND/OUTBOUND CALLS
            // ##################################################################################
            if ($campaign_allow_inbound > 0) {
                if (preg_match('/ALL\-ACTIVE/i', $group_string)) {
                    $stmt = "select closer_campaigns from vicidial_campaigns where active='Y' $group_SQLand";
                    $query = $this->vicidialdb->db->query($stmt);
                    $closer_campaigns = "";
                    $result = $query->result_array;
                    foreach ($result as $row) {
                        $row = array_values($row);
                        $closer_campaigns .= "$row[0]";
                    }
                    $closer_campaigns = preg_replace("/^ | -$/", "", $closer_campaigns);
                    $closer_campaigns = preg_replace("/ - /", " ", $closer_campaigns);
                    $closer_campaigns = preg_replace("/ /", "','", $closer_campaigns);
                    $closer_campaignsSQL = "'$closer_campaigns'";
                }
                $stmtB = "from vicidial_auto_calls where status NOT IN('XFER') and ( (call_type='IN' and campaign_id IN($closer_campaignsSQL)) or (call_type IN('OUT','OUTBALANCE') $group_SQLand) ) order by queue_priority desc,campaign_id,call_time;";
            } else { // if ($campaign_allow_inbound > 0)
                $stmtB = "from vicidial_auto_calls where status NOT IN('XFER') $group_SQLand order by queue_priority desc,campaign_id,call_time;";
            }
            if ($CALLSdisplay > 0) {
                $stmtA = "SELECT status,campaign_id,phone_number,server_ip,UNIX_TIMESTAMP(call_time),call_type,queue_priority,agent_only";
            } else {
                $stmtA = "SELECT status";
            }
            $k = 0;
            $agentonlycount = 0;
            $stmt = "$stmtA $stmtB";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $parked_to_print = $query->num_rows();
            if ($parked_to_print > 0) {
                $i = 0;
                $out_total = 0;
                $out_ring = 0;
                $out_live = 0;
                $in_ivr = 0;
                while ($i < $parked_to_print) {
                    $row = array_values($result [$i]);
                    if (preg_match("/LIVE/i", $row [0])) {
                        $out_live ++;
                        if ($CALLSdisplay > 0) {
                            $CDstatus [$k] = $row [0];
                            $CDcampaign_id [$k] = $row [1];
                            $CDphone_number [$k] = $row [2];
                            $CDserver_ip [$k] = $row [3];
                            $CDcall_time [$k] = $row [4];
                            $CDcall_type [$k] = $row [5];
                            $CDqueue_priority [$k] = $row [6];
                            $CDagent_only [$k] = $row [7];
                            if (strlen($CDagent_only [$k]) > 0) {
                                $agentonlycount ++;
                            }
                            $k ++;
                        }
                    } else { // if (preg_match("/LIVE/i",$row[0]))
                        if (preg_match("/IVR/i", $row [0])) {
                            $in_ivr ++;
                            if ($CALLSdisplay > 0) {
                                $CDstatus [$k] = $row [0];
                                $CDcampaign_id [$k] = $row [1];
                                $CDphone_number [$k] = $row [2];
                                $CDserver_ip [$k] = $row [3];
                                $CDcall_time [$k] = $row [4];
                                $CDcall_type [$k] = $row [5];
                                $CDqueue_priority [$k] = $row [6];
                                $CDagent_only [$k] = $row [7];
                                if (strlen($CDagent_only [$k]) > 0) {
                                    $agentonlycount ++;
                                }
                                $k ++;
                            }
                        } // if (preg_match("/IVR/i",$row[0])){
                        if (preg_match("/CLOSER/i", $row [0])) {
                            $nothing = 1;
                        } else {
                            $out_ring ++;
                        }
                    }
                    $out_total ++;
                    $i ++;
                }
                if ($out_live > 0) {
                    $F = '<FONT class="r1">';
                    $FG = '</FONT>';
                }
                if ($out_live > 4) {
                    $F = '<FONT class="r2">';
                    $FG = '</FONT>';
                }
                if ($out_live > 9) {
                    $F = '<FONT class="r3">';
                    $FG = '</FONT>';
                }
                if ($out_live > 14) {
                    $F = '<FONT class="r4">';
                    $FG = '</FONT>';
                }
                if ($campaign_allow_inbound > 0) {
                    $html .= '<p>' . $NFB . '&nbsp;' . $out_total . '&nbsp;' . $NFE . ' current active calls<p>';
                } else {
                    $html .= '<p>' . $NFB . '&nbsp;' . $out_total . '&nbsp;' . $NFE . 'calls being placed</p>';
                }
                $html .= '<p>' . $NFB . '&nbsp;' . $out_ring . '&nbsp;' . $NFE . ' calls ringing</p>';
                $html .= '<p>' . $NFB . '&nbsp;' . $F . '&nbsp;' . $out_live . '&nbsp;' . $FG . '&nbsp;' . $NFE . 'calls waiting for agents</p>';
                $html .= '<p>' . $NFB . '&nbsp;' . $in_ivr . '&nbsp' . $NFE . 'calls in IVR</p>';
            } else { // if ($parked_to_print > 0){
                $html .= '<p>NO LIVE CALLS WAITING</p>';
            }
            // ##################################################################################
            // ##### CALLS WAITING
            // ##################################################################################
            $agentonlyheader = '';
            if ($agentonlycount > 0) {
                $agentonlyheader = "AGENTONLY";
            }
            $Cecho = '<div class="table-responsive">';
            $Cecho .= '<table class="table">';
            $Cecho .= "<caption>VICIDIAL: Calls Waiting                      $NOW_TIME</caption>";
            $Cecho .= '<tr>';
            $Cecho .= '<th>STATUS</th>';
            $Cecho .= '<th>CAMPAIGN</th>';
            $Cecho .= '<th>PHONE NUMBER</th>';
            $Cecho .= '<th>SERVER IP</th>';
            $Cecho .= '<th>DIALTIME</th>';
            $Cecho .= '<th>PRIORITY</th>';
            $Cecho .= '</tr>';
            $p = 0;
            while ($p < $k) {
                $Cstatus = sprintf("%-6s", _QXZ("$CDstatus[$p]", 6)); // TRANSLATE
                $Ccampaign_id = sprintf("%-20s", $CDcampaign_id [$p]); // Do not translate
                $Cphone_number = sprintf("%-12s", $CDphone_number [$p]); // Do not translate
                $Cserver_ip = sprintf("%-15s", $CDserver_ip [$p]); // Do not translate
                $Ccall_type = sprintf("%-10s", _QXZ("$CDcall_type[$p]", 10)); // TRANSLATE
                $Cqueue_priority = sprintf("%8s", $CDqueue_priority [$p]); // Do not translate
                $Cagent_only = sprintf("%8s", $CDagent_only [$p]);

                $Ccall_time_S = ($STARTtime - $CDcall_time [$p]);
                $Ccall_time_MS = sec_convert($Ccall_time_S, 'M');
                $Ccall_time_MS = sprintf("%7s", $Ccall_time_MS);
                $G = '';
                $EG = '';
                if ($CDcall_type [$p] == 'IN') {
                    $G = "<SPAN class=\"csc$CDcampaign_id[$p]\"><B>";
                    $EG = '</B></SPAN>';
                    $Ccampaign_id = "$Ccampaign_id";
                }
                if (strlen($CDagent_only [$p]) > 0) {
                    $Gcalltypedisplay = "$G$Cagent_only$EG";
                } else {
                    $Gcalltypedisplay = '';
                }
                $Cecho .= '<tr>';
                $Cecho .= '<td>' . $G . $Cstatus . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Ccampaign_id . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Cphone_number . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Cserver_ip . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Ccall_time_MS . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Ccall_type . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Cqueue_priority . $EG . '</td>';
                $Cecho .= '<td>' . $G . $Gcalltypedisplay . $EG . '</td>';
                $Cecho .= '</tr>';
                $p ++;
            }
            $Cecho .= "</table></div>";
            if ($p < 1) {
                $Cecho = '';
            }
            // ##################################################################################
            // ##### AGENT TIME ON SYSTEM
            // ##################################################################################
            $agent_incall = 0;
            $agent_ready = 0;
            $agent_paused = 0;
            $agent_dispo = 0;
            $agent_dead = 0;
            $agent_total = 0;

            $phoneord = $orderby;
            $userord = $orderby;
            $groupord = $orderby;
            $timeord = $orderby;
            $campaignord = $orderby;

            if ($phoneord == 'phoneup') {
                $phoneord = 'phonedown';
            } else {
                $phoneord = 'phoneup';
            }
            if ($userord == 'userup') {
                $userord = 'userdown';
            } else {
                $userord = 'userup';
            }
            if ($groupord == 'groupup') {
                $groupord = 'groupdown';
            } else {
                $groupord = 'groupup';
            }
            if ($timeord == 'timeup') {
                $timeord = 'timedown';
            } else {
                $timeord = 'timeup';
            }
            if ($campaignord == 'campaignup') {
                $campaignord = 'campaigndown';
            } else {
                $campaignord = 'campaignup';
            }

            $Aecho = '';
            $Aecho .= "<p>AGENCYVUE: Agents Time On Calls Campaign : $group_string<span class='text-right'>$NOW_TIME</span>E</p>";
            $Aecho .= '<div class="table-responsive">';
            $Aecho .= '<table class="table">';
            $Aecho .= '<tr>';
            $HDbegin = '';
            $HTbegin = '';
            $HTstation = '<th>STATION</th>';
            $HTphone = '<th>PHONE</th>';
            $HTuser = '<th>USER</th>';
            if ($UidORname > 0) {
                $HTuser .= '<th>SHOW ID</th>';
            } else {
                $HTuser .= '<th>NAME</th>';
            }
            $HTuser .= '<th>Agency</th>';
            $HTusergroup = '<th>USER GROUP</th>';
            $HTsessionid = '<th>SESSIONID</th>';
            // $HTbarge = '<th>BARGE</th>';
            $HTbarge = '';
            $HTstatus = '<th>STATUS</th>';
            $HTcustphone = '<th>CUST PHONE</th>';
            $HTserver_ip = '<th>SERVER IP</th>';
            $HTcall_server_ip = '<th>CALL SERVER IP</th>';
            $HTcampaign = '<th>CAMPAIGN</th>';
            $HTcalls = '<th>CALLS</th>';
            $HTpause = '';
            $HTigcall = '';
            if ($agent_pause_codes_active > 0) {
                $HTstatus = '<th>STATUS</th>';
                $HTpause = '<th>PAUSE</th>';
            }
            $HTtime = '<th>MM:SS</th>';
            if ($PHONEdisplay < 1) {
                $HTphone = '';
            }
            if ($CUSTPHONEdisplay < 1) {
                $HTcustphone = '';
            }
            if ($UGdisplay < 1) {
                $HTusergroup = '';
            }
            $SIPmonitorLINK = 1;
            $IAXmonitorLINK = 1;

            if (isset($SIPmonitorLINK) && ($SIPmonitorLINK < 1) && ($IAXmonitorLINK < 1) && (!preg_match("/MONITOR|BARGE/", $monitor_active))) {
                $HTsessionid = "<th>" . "SESSIONID" . "<th>";
            }
            if (($SIPmonitorLINK < 2) && ($IAXmonitorLINK < 2) && (!preg_match("/BARGE/", $monitor_active))) {
                $HTbarge = '';
            }
            if ($SERVdisplay < 1) {
                $HTserver_ip = '';
                $HTcall_server_ip = '';
            }
            $Bline = $HTbegin . $HTstation . $HTphone . $HTuser . $HTusergroup . $HTsessionid . $HTbarge . $HTstatus . $HTpause . $HTcustphone . $HTserver_ip . $HTcall_server_ip . $HTtime . $HTcampaign . $HTcalls . $HTigcall;
            $Aecho .= $Bline;
            $Aecho .= '</tr>';
            if ($orderby == 'timeup') {
                $orderSQL = 'vicidial_live_agents.status,last_call_time';
            }
            if ($orderby == 'timedown') {
                $orderSQL = 'vicidial_live_agents.status desc,last_call_time desc';
            }
            if ($orderby == 'campaignup') {
                $orderSQL = 'vicidial_live_agents.campaign_id,vicidial_live_agents.status,last_call_time';
            }
            if ($orderby == 'campaigndown') {
                $orderSQL = 'vicidial_live_agents.campaign_id desc,vicidial_live_agents.status desc,last_call_time             desc';
            }
            if ($orderby == ' groupup') {
                $orderSQL = 'user_group,vicidial_live_agents.status,last_call_time';
            }
            if ($orderby == 'groupdown') {
                $orderSQL = 'user_group desc,vicidial_live_agents.status desc,last_call_time desc';
            }
            if ($orderby == 'phoneup') {
                $orderSQL = 'extension,server_ip';
            }
            if ($orderby == 'phonedown') {
                $orderSQL = 'extension desc,server_ip desc';
            }
            if ($UidORname > 0) {
                if ($orderby == 'userup') {
                    $orderSQL = 'full_name,status,last_call_time';
                }
                if ($orderby == 'userdown') {
                    $orderSQL = 'full_name desc,status desc,last_call_time desc';
                }
            } else {
                if ($orderby == 'userup') {
                    $orderSQL = 'vicidial_live_agents.user';
                }
                if ($orderby == 'userdown') {
                    $orderSQL = 'vicidial_live_agents.user desc';
                }
            }
            $user_group_string = "-ALL-ACTIVE--";
            $user_group_SQL = "";
            // if ( !preg_match("/ALL-/",$LOGallowed_campaigns) ) {$UgroupSQL = " and vicidial_live_agents.campaign_id IN($group_SQL)";}
            // else if( (preg_match('/ALL\-ACTIVE/i',$group_string)) and (strlen($group_SQL) < 3) ) {$UgroupSQL = '';}
            // else {$UgroupSQL = " and vicidial_live_agents.campaign_id IN($group_SQL)";}
            // if (strlen($usergroup)<1) {$usergroupSQL = '';}
            // else {$usergroupSQL = " and user_group='" . $usergroup . "'";}
            // if ( (preg_match('/ALL\-GROUPS/i',$user_group_string)) and (strlen($user_group_SQL) < 3) ) {$user_group_filter_SQL = '';}
            // else {$user_group_filter_SQL = " and vicidial_users.user_group IN($user_group_SQL)";}
            $ring_agents = 0;
            $stmt = "select extension,vicidial_live_agents.user,conf_exten,vicidial_live_agents.status,vicidial_live_agents.server_ip,UNIX_TIMESTAMP(last_call_time),UNIX_TIMESTAMP(last_call_finish),call_server_ip,vicidial_live_agents.campaign_id,vicidial_users.user_group,vicidial_users.full_name,vicidial_live_agents.comments,vicidial_live_agents.calls_today,vicidial_live_agents.callerid,lead_id,UNIX_TIMESTAMP(last_state_change),on_hook_agent,ring_callerid,agent_log_id from vicidial_live_agents,vicidial_users where vicidial_live_agents.user=vicidial_users.user AND vicidial_live_agents.campaign_id IN ($group_SQL) order by $orderSQL;";

            $query = $this->vicidialdb->db->query($stmt);
            $talking_to_print = $query->num_rows();
            if ($talking_to_print > 0) {
                $i = 0;
                $result = $query->result_array();
                while ($i < $talking_to_print) {
                    $row = array_values($result [$i]);
                    $Aextension [$i] = $row [0];
                    $Auser [$i] = $row [1];
                    $Asessionid [$i] = $row [2];
                    $Astatus [$i] = $row [3];
                    $Aserver_ip [$i] = $row [4];
                    $Acall_time [$i] = $row [5];
                    $Acall_finish [$i] = $row [6];
                    $Acall_server_ip [$i] = $row [7];
                    $Acampaign_id [$i] = $row [8];
                    $Auser_group [$i] = $row [9];
                    $Afull_name [$i] = $row [10];
                    $Acomments [$i] = $row [11];
                    $Acalls_today [$i] = $row [12];
                    $Acallerid [$i] = $row [13];
                    $Alead_id [$i] = $row [14];
                    $Astate_change [$i] = $row [15];
                    $Aon_hook_agent [$i] = $row [16];
                    $Aring_callerid [$i] = $row [17];
                    $Aagent_log_id [$i] = $row [18];
                    $Aring_note [$i] = ' ';

                    if ($Aon_hook_agent [$i] == 'Y') {
                        $Aring_note [$i] = '*';
                        $ring_agents ++;
                        if (strlen($Aring_callerid [$i]) > 18) {
                            $Astatus [$i] = "RING";
                        }
                    } // if ($Aon_hook_agent[$i] == 'Y')
                    if ($Alead_id [$i] != 0) {
                        $threewaystmt = "select UNIX_TIMESTAMP(last_call_time) from vicidial_live_agents where lead_id='$Alead_id[$i]' and status='INCALL' order by UNIX_TIMESTAMP(last_call_time) desc";
                        $query = $this->vicidialdb->db->query($threewaystmt);
                        if ($query->num_rows() > 1) {
                            $Astatus [$i] = "3-WAY";
                            $srow = array_values($query->row_array());
                            $Acall_mostrecent [$i] = $srow [0];
                        }
                    } // if ($Alead_id[$i]!=0){
                    $i ++;
                } // while($i < $talking_to_print)

                $callerids = '';
                $pausecode = '';
                $stmt = "select callerid,lead_id,phone_number from vicidial_auto_calls;";
                $query = $this->vicidialdb->db->query($stmt);
                $calls_to_list = $query->num_rows();
                if ($calls_to_list > 0) {
                    $i = 0;
                    $result = $query->result_array();
                    while ($i < $calls_to_list) {
                        $row = array_values($result [$i]);
                        $callerids .= "$row[0]|";
                        $VAClead_ids [$i] = $row [1];
                        $VACphones [$i] = $row [2];
                        $i ++;
                    } // while($i < $calls_to_list)
                } // if($calls_to_list > 0)
                // ## Lookup phone logins
                $i = 0;
                while ($i < $talking_to_print) {
                    if (preg_match("/R\//i", $Aextension [$i])) {
                        $protocol = 'EXTERNAL';
                        $dialplan = preg_replace('/R\//i', '', $Aextension [$i]);
                        $dialplan = preg_replace('/\@.*/i', '', $dialplan);
                        $exten = "dialplan_number='$dialplan'";
                    } // if (preg_match("/R\//i",$Aextension[$i]))
                    if (preg_match("/Local\//i", $Aextension [$i])) {
                        $protocol = 'EXTERNAL';
                        $dialplan = preg_replace('/Local\//i', '', $Aextension [$i]);
                        $dialplan = preg_replace('/\@.*/i', '', $dialplan);
                        $exten = "dialplan_number='$dialplan'";
                    } // if (preg_match("/Local\//i",$Aextension[$i]))
                    if (preg_match('/SIP\//i', $Aextension [$i])) {
                        $protocol = 'SIP';
                        $dialplan = preg_replace('/SIP\//i', '', $Aextension [$i]);
                        $dialplan = preg_replace('/\-.*/i', '', $dialplan);
                        $exten = "extension='$dialplan'";
                    } // if (preg_match('/SIP\//i',$Aextension[$i]))
                    if (preg_match('/IAX2\//i', $Aextension [$i])) {
                        $protocol = 'IAX2';
                        $dialplan = preg_replace('/IAX2\//i', '', $Aextension [$i]);
                        $dialplan = preg_replace('/\-.*/i', '', $dialplan);
                        $exten = "extension='$dialplan'";
                    } // if (preg_match('/IAX2\//i',$Aextension[$i]))
                    if (preg_match('/Zap\//i', $Aextension [$i])) {
                        $protocol = 'Zap';
                        $dialplan = preg_replace('/Zap\//i', '', $Aextension [$i]);
                        $exten = "extension='$dialplan'";
                    } // if (preg_match('/Zap\//i',$Aextension[$i]))
                    if (preg_match('/DAHDI\//i', $Aextension [$i])) {
                        $protocol = 'Zap';
                        $dialplan = preg_replace('/DAHDI\//i', '', $Aextension [$i]);
                        $exten = "extension='$dialplan'";
                    }
                    $stmt = "select login from phones where server_ip='$Aserver_ip[$i]' and $exten and protocol='$protocol';";
                    $query = $this->vicidialdb->db->query($stmt);
                    $phones_to_print = $query->num_rows();
                    if ($phones_to_print > 0) {
                        $row = array_values($query->row_array());
                        $Alogin [$i] = "$row[0]-----$i";
                    } else {
                        $Alogin [$i] = "$Aextension[$i]-----$i";
                    }
                    $i ++;
                } // while($i < $talking_to_print)
                // ## Run through the loop to display agents
                $j = 0;
                $agentcount = 0;
                while ($j < $talking_to_print) {
                    $n = 0;
                    $custphone = '';
                    while ($n < $calls_to_list) {
                        if ((preg_match("/$VAClead_ids[$n]/", $Alead_id [$j])) and ( strlen($VAClead_ids [$n]) == strlen($Alead_id [$j])) and ( strlen($VAClead_ids [$n] > 1))) {
                            $custphone = $VACphones [$n];
                        }
                        $n ++;
                    } // while ($n < $calls_to_list)
                    $phone_split = explode("-----", $Alogin [$j]);
                    $i = $phone_split [1];
                    if (preg_match("/READY|PAUSED/i", $Astatus [$i])) {
                        $Acall_time [$i] = $Astate_change [$i];
                        if ($Alead_id [$i] > 0) {
                            $Astatus [$i] = 'DISPO';
                            $Lstatus = 'DISPO';
                            $status = ' DISPO';
                        }
                    } // if (preg_match("/READY|PAUSED/i",$Astatus[$i]))
                    $extension = preg_replace('/Local\//i', '', $Aextension [$i]);
                    $extension = sprintf("%-48s", $extension);
                    while (mb_strlen($extension, 'utf-8') > 14) {
                        $extension = mb_substr("$extension", 0, - 1, 'UTF8');
                    }
                    $phone = sprintf("%-12s", $phone_split [0]);
                    $custphone = sprintf("%-11s", $custphone);
                    $Luser = $Auser [$i];
                    $user = sprintf("%-20s", $Auser [$i]);
                    $Lsessionid = $Asessionid [$i];
                    $sessionid = sprintf("%-9s", $Asessionid [$i]);
                    $Lstatus = $Astatus [$i];
                    $status = sprintf("%-6s", $Astatus [$i]);
                    $Lserver_ip = $Aserver_ip [$i];
                    $server_ip = sprintf("%-15s", $Aserver_ip [$i]);
                    $call_server_ip = sprintf("%-15s", $Acall_server_ip [$i]);
                    $campaign_id = sprintf("%-10s", $Acampaign_id [$i]);
                    $comments = $Acomments [$i];
                    $calls_today = sprintf("%-5s", $Acalls_today [$i]);
                    if ($agent_pause_codes_active > 0) {
                        $pausecode = '       ';
                    } else {
                        $pausecode = '';
                    }
                    if (preg_match("/INCALL/i", $Lstatus)) {
                        $stmtP = "select count(*) from parked_channels where channel_group='$Acallerid[$i]';";
                        $query = $this->vicidialdb->db->query($stmtP);
                        $row = array_values($query->row_array());
                        $rowP = array_values($query->row_array());
                        $parked_channel = $rowP[0];
                        if ($parked_channel > 0) {
                            $Astatus [$i] = 'PARK';
                            $Lstatus = 'PARK';
                            $status = ' PARK ';
                        } else {
                            if (!preg_match("/$Acallerid[$i]\|/", $callerids) && !preg_match("/EMAIL/i", $comments) && !preg_match("/CHAT/i", $comments)) {
                                $Acall_time [$i] = $Astate_change [$i];
                                $Astatus [$i] = 'DEAD';
                                $Lstatus = 'DEAD';
                                $status = ' DEAD ';
                            }
                        }
                        if ((preg_match("/AUTO/i", $comments)) || (strlen($comments) < 1)) {
                            $CM = 'A';
                        } else {
                            if (preg_match("/INBOUND/i", $comments)) {
                                $CM = 'I';
                            } else if (preg_match("/EMAIL/i", $comments)) {
                                $CM = 'E';
                            } else {
                                $CM = 'M';
                            }
                        }
                    } else { // if (preg_match("/INCALL/i",$Lstatus))
                        $CM = ' ';
                    }
                    if ($UGdisplay > 0) {
                        $user = sprintf("%-60s", $Afull_name [$i]);
                        while (mb_strlen($user, 'utf-8') > 20) {
                            $user = mb_substr("$user", 0, - 1, 'UTF8');
                        }
                    } // if ($UGdisplay > 0)
                    if (!preg_match("/INCALL|QUEUE|PARK|3-WAY/i", $Astatus [$i])) {
                        $call_time_S = ($STARTtime - $Astate_change [$i]);
                    } else if (preg_match("/3-WAY/i", $Astatus [$i])) {
                        $call_time_S = ($STARTtime - $Acall_mostrecent [$i]);
                    } else {
                        $call_time_S = ($STARTtime - $Acall_time [$i]);
                    }
                    $call_time_MS = sec_convert($call_time_S, 'M');
                    $call_time_MS = sprintf("%7s", $call_time_MS);
                    $call_time_MS = " $call_time_MS";
                    $G = '';
                    $EG = '';
                    $E = '';
                    if (($Lstatus == 'INCALL') || ($Lstatus == 'PARK')) {
                        if ($call_time_S >= 10) {
                            $G = '<SPAN class="thistle"><B>';
                            $EG = '</B></SPAN>';
                        }
                        if ($call_time_S >= 60) {
                            $G = '<SPAN class="violet"><B>';
                            $EG = '</B></SPAN>';
                        }
                        if ($call_time_S >= 300) {
                            $G = '<SPAN class="purple"><B>';
                            $EG = '</B></SPAN>';
                        }
                    }
                    if ($Lstatus == '3-WAY') {
                        if ($call_time_S >= 10) {
                            $G = '<SPAN class="lime"><B>';
                            $EG = '</B></SPAN>';
                        }
                    }
                    if ($Lstatus == 'DEAD') {
                        if ($call_time_S >= 21600) {
                            $j ++;
                            continue;
                        } else {
                            $agent_dead ++;
                            $agent_total ++;
                            $G = '';
                            $EG = '';
                            if ($call_time_S >= 10) {
                                $G = '<SPAN class="black"><B>';
                                $EG = '</B></SPAN>';
                            }
                        }
                    }
                    if ($Lstatus == 'DISPO') {
                        if ($call_time_S >= 21600) {
                            $j ++;
                            continue;
                        } else {
                            $agent_dispo ++;
                            $agent_total ++;
                            $G = '';
                            $EG = '';
                            if ($call_time_S >= 10) {
                                $G = '<SPAN class="khaki"><B>';
                                $EG = '</B></SPAN>';
                            }
                            if ($call_time_S >= 60) {
                                $G = '<SPAN class="yellow"><B>';
                                $EG = '</B></SPAN>';
                            }
                            if ($call_time_S >= 300) {
                                $G = '<SPAN class="olive"><B>';
                                $EG = '</B></SPAN>';
                            }
                        }
                    }
                    if ($Lstatus == 'PAUSED') {
                        if ($agent_pause_codes_active > 0) {
                            $twentyfour_hours_ago = date("Y-m-d H:i:s", mktime(date("H") - 24, date("i"), date("s"), date("m"), date("d"), date("Y")));
                            $stmtC = "select sub_status from vicidial_agent_log where agent_log_id >= \"$Aagent_log_id[$i]\" and user='$Luser' order by agent_log_id desc limit 1;";
                            $queryC = $this->vicidialdb->db->query($stmtC);
                            $rowC = array_values($queryC->row_array());
                            $pausecode = sprintf("%-6s", $rowC [0]);
                            $pausecode = "$pausecode ";
                        } else {
                            $pausecode = '';
                        }
                        if ($call_time_S >= 21600) {
                            $j ++;
                            continue;
                        } else {
                            $agent_paused ++;
                            $agent_total ++;
                            $G = '';
                            $EG = '';
                            if ($call_time_S >= 10) {
                                $G = '<SPAN class="khaki"><B>';
                                $EG = '</B></SPAN>';
                            }
                            if ($call_time_S >= 60) {
                                $G = '<SPAN class="yellow"><B>';
                                $EG = '</B></SPAN>';
                            }
                            if ($call_time_S >= 300) {
                                $G = '<SPAN class="olive"><B>';
                                $EG = '</B></SPAN>';
                            }
                        }
                    } // if ($Lstatus=='PAUSED')
                    if ((preg_match("/INCALL/i", $status)) || (preg_match("/QUEUE/i", $status)) || (preg_match("/3-WAY/i", $status)) || (preg_match('/PARK/i', $status))) {
                        $agent_incall ++;
                        $agent_total ++;
                    }
                    if ((preg_match("/READY/i", $status)) || (preg_match("/CLOSER/i", $status))) {
                        $agent_ready ++;
                        $agent_total ++;
                    }
                    if ((preg_match("/READY/i", $status)) || (preg_match("/CLOSER/i", $status))) {
                        $G = '<SPAN class="lightblue"><B>';
                        $EG = '</B></SPAN>';
                        if ($call_time_S >= 60) {
                            $G = '<SPAN class="blue"><B>';
                            $EG = '</B></SPAN>';
                        }
                        if ($call_time_S >= 300) {
                            $G = '<SPAN class="midnightblue"><B>';
                            $EG = '</B></SPAN>';
                        }
                    }
                    if ($Astatus [$i] == 'RING') {
                        $agent_total ++;
                        $G = '';
                        $EG = '';
                        if ($call_time_S >= 0) {
                            $G = '<SPAN class="salmon"><B>';
                            $EG = '</B></SPAN>';
                        }
                    }
                    $L = '';
                    $R = '';
                    $SIPmonitorLINK = 0;
                    $IAXmonitorLINK = 0;
                    if ($SIPmonitorLINK > 0) {
                        $L = "<a href=\"sip:0$Lsessionid@$server_ip\">" . "LISTEN" . "</a>";
                        $R = '';
                    }
                    if ($IAXmonitorLINK > 0) {
                        $L = " <a href=\"iax:0$Lsessionid@$server_ip\">" . "LISTEN" . "</a>";
                        $R = '';
                    }
                    if ($SIPmonitorLINK > 1) {
                        $R = " | <a href=\"sip:$Lsessionid@$server_ip\">" . "BARGE" . "</a>";
                    }
                    if ($IAXmonitorLINK > 1) {
                        $R = " | <a href=\"iax:$Lsessionid@$server_ip\">BARGE</a>";
                    }

                    if ((strlen($monitor_phone) > 1) && (preg_match("/MONITOR|BARGE/", $monitor_active))) {
                        $L = " <a href=\"javascript:send_monitor('$Lsessionid','$Lserver_ip','MONITOR');\">" . "LISTEN" . "</a>";
                        $R = '';
                    }
                    if ((strlen($monitor_phone) > 1) && (preg_match("/BARGE/", $monitor_active))) {
                        $R = " | <a href=\"javascript:send_monitor('$Lsessionid','$Lserver_ip','BARGE');\">" . "BARGE" . "</a>";
                    }
                    if ($CUSTPHONEdisplay > 0) {
                        $CP = " $G$custphone$EG";
                    } else {
                        $CP = "";
                    }
                    if ($UGdisplay > 0) {
                        $UGD = " $G$user_group$EG |";
                    } else {
                        $UGD = "";
                    }
                    if ($SERVdisplay > 0) {
                        $SVD = "$G$server_ip$EG";
                        $SVDC = "$G$call_server_ip$EG";
                    } else {
                        $SVD = "";
                        $SVDC = "";
                    }
                    if ($PHONEdisplay > 0) {
                        $phoneD = "$G$phone$EG | ";
                    } else {
                        $phoneD = " ";
                    }

                    $vac_stage = '';
                    $vac_campaign = '';
                    $INGRP = '';
                    if ($CM == 'I') {
                        $stmt = "select vac.campaign_id,vac.stage,vig.group_name from vicidial_auto_calls vac,vicidial_inbound_groups vig where vac.callerid='$Acallerid[$i]' and vac.campaign_id=vig.group_id LIMIT 1;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $ingrp_to_print = $query->num_rows();
                        if ($ingrp_to_print > 0) {
                            $row = array_values($query->row_array());
                            $vac_campaign = sprintf("%-20s", "$row[0] - $row[2]");
                            $row [1] = preg_replace('/.*\-/i', '', $row [1]);
                            $vac_stage = sprintf("%-4s", $row [1]);
                        }
                        $INGRP = " $G$vac_stage$EG | $G$vac_campaign$EG ";
                    }
                    $agentcount ++;
                    $vuser = $this->vusers_m->get_by(array(
                        'user' => $Luser
                            ), TRUE);
                    $vuserId = $vuser->user_id;
                    $stmtD = "SELECT * FROM agents WHERE vicidial_user_id=" . $vuserId;
                    $queryD = $this->db->query($stmtD);
                    $agent = $queryD->row_array();
                    $agentName = '';
                    $agenyName = '';
                    if ($agent) {
                        if ($this->session->userdata("user")->group_name == 'Agency') {
                            $agentName = '<a target="_blank" href="' . site_url('agency/manage_agent/agent_info/' . encode_url($agent ['id'])) . '">' . $agent ['fname'] . ' ' . $agent ['lname'] . '</a>';
                        } else {
                            $agentName = '<a target="_blank" href="' . site_url('admin/manage_agent/agent_info/' . $agent ['id']) . '">' . $agent ['fname'] . ' ' . $agent ['lname'] . '</a>';
                        }
                        $stmtD = "SELECT * FROM agencies WHERE id=" . $agent['agency_id'];
                        $queryD = $this->db->query($stmtD);
                        $agency = $queryD->row_array();
                        $agenyName = $agency ['name'];
                        if ($this->session->userdata("user")->group_name == 'Agency') {
                            $agenyName = '<a target="_blank" href="' . site_url('agency/manage_agency/agency_info/' . encode_url($agency ['id'])) . '">' . $agenyName . '</a>';
                        } else {
                            $agenyName = '<a target="_blank" href="' . site_url('admin/manage_agency/agency_info/' . $agency ['id']) . '">' . $agenyName . '</a>';
                        }
                    } else {
                        $agentName = $vuser->full_name;
                        $stmtD = "SELECT * FROM agencies WHERE vicidial_user_id=" . $vuserId;
                        $queryD = $this->db->query($stmtD);
                        $agency = $queryD->row_array();
                        $agenyName = $agency ['name'];
                        if ($this->session->userdata("user")->group_name == 'Agency') {
                            $agenyName = '<a target="_blank" href="' . site_url('agency/manage_agency/agency_info/' . encode_url($agency ['id'])) . '">' . $agenyName . '</a>';
                        } else {
                            $agenyName = '<a target="_blank" href="' . site_url('admin/manage_agency/agency_info/' . $agency ['id']) . '">' . $agenyName . '</a>';
                        }
                    }
                    $Aecho .= '<tr>';
                    $Aecho .= '<td>' . $G . $extension . $E . '</td>';
                    if ($PHONEdisplay > 0) {
                        $Aecho .= '<td>' . $G . $phone . $EG . '</td>';
                    }
                    $Aecho .= '<td>' . $G . $Luser . $E . '</td>';
                    $Aecho .= '<td>' . $G . $agentName . $E . '</td>';
                    $Aecho .= '<td>' . $G . $agenyName . $E . '</td>';
                    if ($UGdisplay > 0) {
                        $Aecho .= '<td><b>' . $vuser->user_group . '</b></td>';
                    }
                    $Aecho .= '<td>' . $G . $sessionid . $E . $L . $R . '</td>';
                    $Aecho .= '<td>' . $G . $status . $E . '</td>';
                    if ($CUSTPHONEdisplay > 0) {
                        $Aecho .= '<td>' . $CP . '</td>';
                    }
                    if ($SERVdisplay > 0) {
                        $Aecho .= '<td>' . $SVD . '</td>';
                        $Aecho .= '<td>' . $SVDC . '</td>';
                    }
                    $Aecho .= '<td>' . $CP . $G . $call_time_MS . $EG . '</td>';
                    $Aecho .= '<td>' . $G . $campaign_id . $EG . '</td>';
                    $Aecho .= '<td>' . $G . $calls_today . $EG . '</td>';
                    $Aecho .= '</tr>';
                    // $html .= "|$G$extension$EG$Aring_note[$i]|$phoneD<a href=\"./user_status.php?user=$Luser\" target=\"_blank\">$G$user$EG</a> <a href=\"javascript:ingroup_info('$Luser','$j');\">+</a> |$UGD $G$sessionid$EG$L$R | $G".("$status")."$EG $CM $pausecode|$CP$SVD$G$call_time_MS$EG | $G$campaign_id$EG | $G$calls_today$EG |$INGRP\n";

                    $j ++;
                } // while ($j < $talking_to_print)
                if ($agent_ready > 0) {
                    $B = '<FONT class="b1">';
                    $BG = '</FONT>';
                }
                if ($agent_ready > 4) {
                    $B = '<FONT class="b2">';
                    $BG = '</FONT>';
                }
                if ($agent_ready > 9) {
                    $B = '<FONT class="b3">';
                    $BG = '</FONT>';
                }
                if ($agent_ready > 14) {
                    $B = '<FONT class="b4">';
                    $BG = '</FONT>';
                }
                $html .= '<div class="row">';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details"><div class="number"><span>' . $agent_total . '</span><div class="desc">Agents logged in</div></div></div></a></div>';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details"><div class="number"><span>' . $agent_incall . '</span><div class="desc">Agents in calls</div></div></div></a></div>';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details"><div class="number"><span>' . '&nbsp;' . $agent_ready . '</span><div class="desc">Agents  waiting</div></div></div></a></div>';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details"><div class="number"><span>' . $agent_paused . '</span><div class="desc">Paused agents</div></div></div></a></div>';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details" style="margin-right:-10px;"><div class="number"><span>' . $agent_dead . '</span><div class="desc">Agents in dead calls</div></div></div></a></div>';
                $html .= '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"> <a class="dashboard-stat dashboard-stat-v2 blue" href="#"><div class="visual"><i class="fa fa-comments"></i></div><div class="details"><div class="number"><span>' . $agent_dispo . '</span><div class="desc">Agents in dispo</div></div></div></a></div>';
                $html .= '</div><br/>';
                $Aecho .= '</table></div>';
                $Aecho .= "<div class='row'><div class='col-md-12'><p>$agentcount Agents logged in on all servers</p>";
                // $Aecho .= "<p>".("System Load Average").": $load_ave &nbsp; $db_source</p> </div></div>";
                // $Aecho .= "<p><SPAN style='background:#FF0000' class=\"lightblue\">-</SPAN><B>Agent waiting for call</B></p>";
                // $Aecho .= "<p><SPAN style='background:#FFA500' >-</SPAN><B>Agent waiting for call > 1 minute</B></p>";
                // $Aecho .= "<p><SPAN style='background:#ADD8E6'>-</SPAN><B>Agent waiting for call > 5 minutes</B></p>";
                // $Aecho .= "<p><SPAN style='background:#0000FF'>-</SPAN><B>Agent on call > 10 seconds</B></p>";
                // $Aecho .= "<p><SPAN style='background:#191970'>-</SPAN><B>Agent on call > 1 minute</B></p>";
                // $Aecho .= "<p><SPAN style='background:#D8BFD8'>-</SPAN><B>Agent on call > 5 minutes</B></p>";
                // $Aecho .= "<p><SPAN style='background:#EE82EE'>-</SPAN><B> Agent Paused > 10 seconds</B></p>";
                // $Aecho .= "<p><SPAN style='background:#FF0000'>-</SPAN><B>Agent Paused > 1 minute</B></p>";
                // $Aecho .= "<p><SPAN style='background:#FF0000'>-</SPAN><B>Agent Paused > 5 minutes</B></p>";
                // $Aecho .= "<p><SPAN style='background:#FF0000'>-</SPAN><B> Agent in 3-WAY > 10 seconds</B></p>";
                // $Aecho .= "<p><SPAN style='background:#FF0000'>-</SPAN><B> Agent on a dead call</B></p>";
                if ($ring_agents > 0) {
                    $Aecho .= "  <SPAN class=\"salmon\"><B>- " . ("Agent phone ringing") . "</B>";
                    $Aecho .= "  <SPAN><B>* " . ("Denotes on-hook agent") . "</B></SPAN>\n";
                }
                $html .= $Cecho;
                $html .= $Aecho;
            } else { // if($talking_to_print > 0)
                $html .= "<p>NO AGENTS ON CALLS</p>";
            }
            /* */
            $output ['success'] = TRUE;
            $output ['html'] = $html;
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        } // if($post = $this->input->post())
    }

    public function monitor() {
        if ($post = $this->input->post()) {
            $user = '6666';
            $pass = '4dm1n1234';
            $monitor_phone = $post ['phone_login'];
            $session_id = $post ['session_id'];
            $stage = $post ['stage'];
            $server_ip = $post ['server_ip'];
            $apiUrl = $this->config->item('vicidial_url') . 'vicidial/non_agent_api.php?';
            $url = $apiUrl . "source=realtime&function=blind_monitor&user=" . $user . "&pass=" . $pass . "&phone_login=" . $monitor_phone . "&session_id=" . $session_id . '&server_ip=' . $server_ip . '&stage=' . $stage;
            $result = file_get_contents($url);
            $output ['success'] = TRUE;
            $output ['html'] = $result;
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        } else {
            $output ['success'] = FALSE;
            $output ['html'] = 'ERROR';
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function outbound() {
        $this->data ['datatable'] = TRUE;
        $this->data ['model'] = TRUE;
        $this->data ['validation'] = TRUE;
        $this->data ['sweetAlert'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        $this->data ['listtitle'] = 'Outbound Calling Report';
        $this->data ['title'] = 'Outbound Calling Report';
        $this->data ['breadcrumb'] = "Outbound Calling Report";
        $this->data ['agencies'] = $this->agency_model->get_nested();
        $this->data ['succees'] = FALSE;
        $this->data ['message'] = '';
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $camps = $this->vcampaigns_m->queryForAgency();
            if (!$camps) {
                $camps = array();
            }
            $campaigns = array();
            foreach ($camps as $campaign) {
                $campaigns [] = (object) $campaign;
            }
            $this->data ['campaigns'] = $campaigns;
        } else {
            $this->data ['campaigns'] = $this->vcampaigns_m->get_by(array(
                'active' => 'Y'
                    ));
        }
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $listData = $this->vlists_m->queryForAgency();
            $lists = array();
            foreach ($listData as $row) {
                $lists [] = (object) $row;
            }
            $this->data ['lists'] = $lists;
        } else {
            $list_stmt = "select list_id, list_name, campaign_id from vicidial_lists order by list_id asc";
            $query = $this->vicidialdb->db->query($list_stmt);
            $this->data ['lists'] = $query->result();
        }
        $this->data ['postData'] ['group'] = array(
            '--ALL--'
        );
        $this->data ['postData'] ['include_rollover'] = 'NO';
        $this->data ['postData'] ['bottom_graph'] = 'NO';
        $this->data ['postData'] ['carrier_stats'] = 'NO';
        $this->data ['postData'] ['report_display_type'] = 'TEXT';
        $this->data ['postData'] ['shift'] = 'ALL';
        $time_stat = '';
        if ($post = $this->input->post()) {
            $this->data['postData'] = $post;
            $print_calls = isset($post ['print_calls']) ? $post ['print_calls'] : '';
            $outbound_rate = isset($post ['outbound_rate']) ? $post ['outbound_rate'] : '';
            $costformat = isset($post ['costformat']) ? $post ['costformat'] : '';
            $include_rollover = isset($post ['include_rollover']) ? $post ['include_rollover'] : '';
            $carrier_stats = isset($post ['carrier_stats']) ? $post ['carrier_stats'] : '';
            $bottom_graph = isset($post ['bottom_graph']) ? $post ['bottom_graph'] : '';
            $agent_hours = isset($post ['agent_hours']) ? $post ['agent_hours'] : '';
            $group = isset($post ['group']) ? $post ['group'] : array();
            if (in_array('--ALL--', $group)) {
                $group = array();
                foreach ($this->data ['campaigns'] as $campaign) {
                    $group[] = $campaign->campaign_id;
                }
            }
            $list_ids = isset($post ['list_ids']) ? $post ['list_ids'] : array();
            $query_date = isset($post ['query_date']) ? date('Y-m-d', strtotime($post ['query_date'])) : '';
            $end_date = isset($post ['end_date']) ? date('Y-m-d', strtotime($post ['end_date'])) : '';
            $shift = isset($post ['shift']) ? $post ['shift'] : '';
            $agent_hours = isset($post ['agent_hours']) ? $post ['agent_hours'] : '';
            $outbound_rate = isset($post ['outbound_rate']) ? $post ['outbound_rate'] : '';
            $costformat = isset($post ['costformat']) ? $post ['costformat'] : '';
            $print_calls = isset($post ['print_calls']) ? $post ['print_calls'] : '';
            $report_display_type = isset($post ['report_display_type']) ? $post ['report_display_type'] : '';
            $carrier_logging_active = 1;
            if (strlen($shift) < 2) {
                $shift = 'ALL';
            }
            if (strlen($bottom_graph) < 2) {
                $bottom_graph = 'NO';
            }
            if (strlen($carrier_stats) < 2) {
                $carrier_stats = 'NO';
            }
            if (strlen($include_rollover) < 2) {
                $include_rollover = 'NO';
            }

            $LOGallowed_campaigns = '-ALL-CAMPAIGNS- - -';
            if ($this->session->userdata('user')->group_name == 'Agency') {
                $LOGallowed_campaigns = ' ';
                foreach ($campaigns as $camps) {
                    $LOGallowed_campaigns .= $camps->campaign_id . ' ';
                }
            }

            $LOGallowed_reports = 'ALL REPORTS';
            $NOW_DATE = date("Y-m-d");
            $NOW_TIME = date("Y-m-d H:i:s");
            $STARTtime = date("U");
            if (!isset($group)) {
                $group = '';
            }
            if (!isset($query_date)) {
                $query_date = $NOW_DATE;
            }
            if (!isset($end_date)) {
                $end_date = $NOW_DATE;
            }

            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            while ($i < $group_ct) {
                $group_string .= "$group[$i]|";
                $i ++;
            } // while($i < $group_ct)
            $LOGallowed_campaignsSQL = '';
            $whereLOGallowed_campaignsSQL = '';
            if ((!preg_match('/\-ALL/i', $LOGallowed_campaigns))) {
                $rawLOGallowed_campaignsSQL = preg_replace("/ -/", '', $LOGallowed_campaigns);
                $rawLOGallowed_campaignsSQL = preg_replace("/ /", "','", $rawLOGallowed_campaignsSQL);
                $LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
                $whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
            }
            $regexLOGallowed_campaigns = " $LOGallowed_campaigns ";
            $stmt = "select campaign_id,campaign_name from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
            $query = $this->vicidialdb->db->query($stmt);
            $campaigns_to_print = $query->num_rows();
            $result = $query->result_array();
            $i = 0;
            while ($i < $campaigns_to_print) {
                $row = array_values($result [$i]);
                $groups [$i] = $row [0];
                $group_names [$i] = $row [1];
                if (preg_match('/\-ALL/', $group_string)) {
                    $group [$i] = $groups [$i];
                }
                $i ++;
            } // while ($i < $campaigns_to_print)
            $rollover_groups_count = 0;
            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            $group_SQL = '';
            $groupQS = '';
            $group_drop_SQL = '';
            while ($i < $group_ct) {
                if ((preg_match("/ $group[$i] /", $regexLOGallowed_campaigns)) or ( preg_match("/-ALL/", $LOGallowed_campaigns))) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $groupQS .= "&group[]=$group[$i]";
                }

                if (preg_match("/YES/i", $include_rollover)) {
                    $stmt = "select drop_inbound_group from vicidial_campaigns where campaign_id='$group[$i]' $LOGallowed_campaignsSQL and drop_inbound_group NOT LIKE \"%NONE%\" and drop_inbound_group is NOT NULL and drop_inbound_group != '';";
                    $query = $this->vicidialdb->db->query($stmt);
                    $in_groups_to_print = $query->num_rows();
                    $row = $query->row_array();
                    if ($in_groups_to_print > 0) {
                        $row = array_values($row);
                        $group_drop_SQL .= "'$row[0]',";
                        $rollover_groups_count ++;
                    }
                }
                $i ++;
            } // while($i < $group_ct)
            if (strlen($group_drop_SQL) < 2) {
                $group_drop_SQL = "''";
            }

            if ((preg_match('/\-\-ALL\-\-/', $group_string)) || ($group_ct < 1) || (strlen($group_string) < 2)) {
                if ($this->session->userdata('user')->group_name == 'Agency') {
                    $group_SQL = "''";
                    $group_drop_SQL = "''";
                    $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                    $group_drop_SQL = preg_replace('/,$/i', '', $group_drop_SQL);
                    $both_group_SQLand = "and ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
                    $both_group_SQL = "where ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
                    $group_SQLand = "and campaign_id IN($group_SQL)";
                    $group_SQL = "where campaign_id IN($group_SQL)";
                    $group_drop_SQLand = "and campaign_id IN($group_drop_SQL)";
                    $group_drop_SQL = "where campaign_id IN($group_drop_SQL)";
                } else {
                    $group_SQL = "$LOGallowed_campaignsSQL";
                    $group_drop_SQL = "";
                }
            } else {
                $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                $group_drop_SQL = preg_replace('/,$/i', '', $group_drop_SQL);
                $both_group_SQLand = "and ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
                $both_group_SQL = "where ( (campaign_id IN($group_drop_SQL)) or (campaign_id IN($group_SQL)) )";
                $group_SQLand = "and campaign_id IN($group_SQL)";
                $group_SQL = "where campaign_id IN($group_SQL)";
                $group_drop_SQLand = "and campaign_id IN($group_drop_SQL)";
                $group_drop_SQL = "where campaign_id IN($group_drop_SQL)";
            }
            $i = 0;
            $list_id_string = '|';
            $list_id_ct = count($list_ids);
            $list_id_SQLand = '';
            $list_id_SQL = '';
            $list_idQS = '';
            while ($i < $list_id_ct) {
                $list_id_string .= "$list_ids[$i]|";
                $list_id_SQL .= "'$list_ids[$i]',";
                $list_idQS .= "&list_ids[]=$list_ids[$i]";
                $VL_INC = ",vicidial_list";
                $i ++;
            } // while($i < $list_id_ct)
            $list_id_SQLandVALJOIN = '';
            if ((preg_match('/\-\-ALL\-\-/', $list_id_string)) or ( $list_id_ct < 1) or ( strlen($list_id_string) < 2)) {
                $list_id_SQL = "";
                $list_id_drop_SQL = "";
                $VL_INC = "";
                $skip_productivity_calc = 0;
            } else {
                $list_id_SQL = preg_replace('/,$/i', '', $list_id_SQL);
                $list_id_SQLand = "and list_id IN($list_id_SQL)";
                $list_id_SQLandVALJOIN = "and vicidial_agent_log.lead_id=vicidial_list.lead_id and vicidial_list.list_id IN($list_id_SQL)";
                $list_id_SQLandUCLJOIN = "and user_call_log.lead_id=vicidial_list.lead_id and vicidial_list.list_id IN($list_id_SQL)";
                $list_id_SQL = "where list_id IN($list_id_SQL)";
                $skip_productivity_calc = 1;
            }

            $stmt = "select vsc_id,vsc_name from vicidial_status_categories;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statcats_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statcats_to_print) {
                $row = array_values($result [$i]);
                $vsc_id [$i] = $row [0];
                $vsc_name [$i] = $row [1];
                $vsc_count [$i] = 0;
                $i ++;
            } // while ($i < $statcats_to_print)
            $customer_interactive_statuses = '';
            $stmt = "select status from vicidial_statuses where human_answered='Y';";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statha_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statha_to_print) {
                $row = array_values($result [$i]);
                $customer_interactive_statuses .= "'$row[0]',";
                $i ++;
            }
            $stmt = "select status from vicidial_campaign_statuses where human_answered='Y' $group_SQLand;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statha_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statha_to_print) {
                $row = array_values($result [$i]);
                $customer_interactive_statuses .= "'$row[0]',";
                $i ++;
            }
            if (strlen($customer_interactive_statuses) > 2) {
                $customer_interactive_statuses = substr("$customer_interactive_statuses", 0, - 1);
            } else {
                $customer_interactive_statuses = "''";
            }
            if (strlen($group [0]) < 1) {
                $this->data ['succees'] = FALSE;
                $this->data ['message'] = "<p>PLEASE SELECT A CAMPAIGN AND DATE ABOVE AND CLICK SUBMIT</p>";
            } else {
                $time_BEGIN = '';
                $time_END = '';
                if ($shift == 'AM') {
                    $time_BEGIN = $AM_shift_BEGIN;
                    $time_END = $AM_shift_END;
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "03:45:00";
                    }
                    if (strlen($time_END) < 6) {
                        $time_END = "15:14:59";
                    }
                } else if ($shift == 'PM') {
                    $time_BEGIN = $PM_shift_BEGIN;
                    $time_END = $PM_shift_END;
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "15:15:00";
                    }
                    if (strlen($time_END) < 6) {
                        $time_END = "23:15:00";
                    }
                } else if ($shift == 'ALL') {
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "00:00:00";
                    }
                    if (strlen($time_END) < 6) {
                        $time_END = "23:59:59";
                    }
                }
                $query_date_BEGIN = "$query_date $time_BEGIN";
                $query_date_END = "$end_date $time_END";
                $OUToutput = '';
                $OUToutput .= "<p>Outbound Calling Stats <strong>$NOW_TIME</strong></p>";
                $OUToutput .= "<p>Time range: <strong>" . $query_date_BEGIN . " to " . $query_date_END . "</strong></p>";
                $OUToutput .= '<hr />';
                $OUToutput .= "<p>---------- <b>TOTALS</b></p>";
                $stmt = "select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand;";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $TOTALcallsRAW = $row [0];
                $TOTALsec = $row [1];
                $inTOTALcallsRAW = 0;
                if (preg_match("/YES/i", $include_rollover)) {
                    $length_in_secZ = 0;
                    $queue_secondsZ = 0;
                    $agent_alert_delayZ = 0;
                    $inTOTALsec = 0;
                    $stmt = "select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id $group_drop_SQLand $list_id_SQLand;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $INallcalls_to_printZ = $query->num_rows();
                    $y = 0;
                    while ($y < $INallcalls_to_printZ) {
                        $row = array_values($result [$y]);
                        $length_in_secZ = $row [0];
                        $queue_secondsZ = $row [1];
                        $agent_alert_delayZ = $row [2];
                        $TOTALdelay = round(MathZDC($agent_alert_delayZ, 1000));
                        $thiscallsec = (($length_in_secZ - $queue_secondsZ) - $TOTALdelay);
                        if ($thiscallsec < 0) {
                            $thiscallsec = 0;
                        }
                        $inTOTALsec = ($inTOTALsec + $thiscallsec);
                        $y ++;
                    } // while($y < $INallcalls_to_printZ)
                    $inTOTALcallsRAW = $y;
                    $TOTALsec = ($TOTALsec + $inTOTALsec);
                    $inTOTALcalls = sprintf("%10s", $inTOTALcallsRAW);
                } // if (preg_match("/YES/i",$include_rollover))

                $TOTALcalls = sprintf("%10s", $TOTALcallsRAW);
                $average_call_seconds = MathZDC($TOTALsec, $TOTALcallsRAW);
                $average_call_seconds = round($average_call_seconds, 2);
                $average_call_seconds = sprintf("%10s", $average_call_seconds);
                $OUToutput .= "<p>Total Calls placed from this Campaign" . ":        <b>$TOTALcalls</b></p>";
                $OUToutput .= "<p>Average Call Length for all Calls in seconds" . ": <b>$average_call_seconds</b></p>";
                if (preg_match("/YES/i", $include_rollover)) {
                    $OUToutput .= "<p>Calls that went to rollover In-Group :         $inTOTALcalls</p>";
                }
                $OUToutput .= '<hr />';
                $OUToutput .= "<p>---------- <b>HUMAN ANSWERS</b></p>";
                $stmt = "select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status IN($customer_interactive_statuses) $group_SQLand $list_id_SQLand;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->row_array();
                $row = array_values($result);
                $CIcallsRAW = $row [0];
                $CIsec = $row [1];
                if (preg_match("/YES/i", $include_rollover)) {
                    $length_in_secZ = 0;
                    $queue_secondsZ = 0;
                    $agent_alert_delayZ = 0;
                    $inCIsec = 0;
                    $stmt = "select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id and vicidial_closer_log.status IN($customer_interactive_statuses) $group_drop_SQLand $list_id_SQLand;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $INallcalls_to_printZ = $query->num_rows();
                    $y = 0;
                    while ($y < $INallcalls_to_printZ) {
                        $row = array_values($result [$y]);
                        $length_in_secZ = $row [0];
                        $queue_secondsZ = $row [1];
                        $agent_alert_delayZ = $row [2];
                        $CIdelay = round(MathZDC($agent_alert_delayZ, 1000));
                        $thiscallsec = (($length_in_secZ - $queue_secondsZ) - $CIdelay);
                        if ($thiscallsec < 0) {
                            $thiscallsec = 0;
                        }
                        $inCIsec = ($inCIsec + $thiscallsec);
                        $y ++;
                    } // while ($y < $INallcalls_to_printZ){
                    $inCIcallsRAW = $y;
                    $CIsec = ($CIsec + $inCIsec);
                    $CIcallsRAW = ($CIcallsRAW + $inCIcallsRAW);
                } // if (preg_match("/YES/i",$include_rollover)){
                $CIcalls = sprintf("%10s", $CIcallsRAW);
                $average_ci_seconds = MathZDC($CIsec, $CIcallsRAW);
                $average_ci_seconds = round($average_ci_seconds, 2);
                $average_ci_seconds = sprintf("%10s", $average_ci_seconds);
                $CIsec = sec_convert($CIsec, 'H');
                $OUToutput .= "<p>Total Human Answered calls for this Campaign: <b>$CIcalls</b></p>";
                $OUToutput .= "<p>Average Call Length for all HA in seconds:    <b>$average_ci_seconds</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total Time: $CIsec</strong></p>";
                $OUToutput .= '<hr />';
                $OUToutput .= "<p>---------- <b>DROPS</b></p>";
                $stmt = "select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status='DROP' and (length_in_sec <= 6000 or length_in_sec is null);";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->row_array();
                $row = array_values($result);
                $DROPcalls = sprintf("%10s", $row [0]);
                $DROPcallsRAW = $row [0];
                $DROPseconds = $row [1];
                // GET LIST OF ALL STATUSES and create SQL from human_answered statuses
                $q = 0;
                $stmt = "SELECT status,status_name,human_answered,category from vicidial_statuses;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $p = 0;
                $camp_ANS_STAT_SQL = '';
                while ($p < $statuses_to_print) {
                    $row = array_values($result [$p]);
                    $status [$q] = $row [0];
                    $status_name [$q] = $row [1];
                    $human_answered [$q] = $row [2];
                    $category [$q] = $row [3];
                    $statname_list ["$status[$q]"] = "$status_name[$q]";
                    $statcat_list ["$status[$q]"] = "$category[$q]";
                    if ($human_answered [$q] == 'Y') {
                        $camp_ANS_STAT_SQL .= "'$row[0]',";
                    }
                    $q ++;
                    $p ++;
                } // while ($p < $statuses_to_print){
                $stmt = "SELECT distinct status,status_name,human_answered,category from vicidial_campaign_statuses $group_SQL;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $p = 0;
                while ($p < $statuses_to_print) {
                    $row = array_values($result [$p]);
                    $status [$q] = $row [0];
                    $status_name [$q] = $row [1];
                    $human_answered [$q] = $row [2];
                    $category [$q] = $row [3];
                    $statname_list ["$status[$q]"] = "$status_name[$q]";
                    $statcat_list ["$status[$q]"] = "$category[$q]";
                    if ($human_answered [$q] == 'Y') {
                        $camp_ANS_STAT_SQL .= "'$row[0]',";
                    }
                    $q ++;
                    $p ++;
                } // while($p < $statuses_to_print){
                $camp_ANS_STAT_SQL = preg_replace('/,$/i', '', $camp_ANS_STAT_SQL);
                $stmt = "select count(*) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN($camp_ANS_STAT_SQL);";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $ANSWERcalls = $row [0];
                $DROPpercent = (MathZDC($DROPcallsRAW, $TOTALcalls) * 100);
                $DROPpercent = round($DROPpercent, 2);

                $DROPANSWERpercent = (MathZDC($DROPcallsRAW, $ANSWERcalls) * 100);
                $DROPANSWERpercent = round($DROPANSWERpercent, 2);

                $average_hold_seconds = MathZDC($DROPseconds, $DROPcallsRAW);
                $average_hold_seconds = round($average_hold_seconds, 2);
                $average_hold_seconds = sprintf("%10s", $average_hold_seconds);

                $OUToutput .= "<p>Total Outbound DROP Calls: $DROPcalls  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>$DROPpercent%</span></p>";
                $OUToutput .= "<p>Percent of DROP Calls taken out of Answers: $DROPcalls / $ANSWERcalls  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>$DROPANSWERpercent%</span></p>";
                if (preg_match("/YES/i", $include_rollover)) {
                    $inDROPANSWERpercent = (MathZDC($DROPcallsRAW, $CIcallsRAW) * 100);
                    $inDROPANSWERpercent = round($inDROPANSWERpercent, 2);
                    $OUToutput .= "Percent of DROP/Answer Calls with Rollover:<b> $DROPcalls / $CIcallsRAW </b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>$inDROPANSWERpercent%</strong>";
                }
                $OUToutput .= "<p>Average Length for DROP Calls in seconds: <b>$average_hold_seconds</b></p>";
                $stmt = "select closer_campaigns from vicidial_campaigns $group_SQL;";
                $query = $this->vicidialdb->db->query($stmt);
                $ccamps_to_print = $query->num_rows();
                $result = $query->result_array();
                $c = 0;
                $closer_campaignsSQL = "''";
                while ($ccamps_to_print > $c) {
                    $row = array_values($result [$c]);
                    $closer_campaigns = $row [0];
                    $closer_campaigns = preg_replace("/^ | -$/", "", $closer_campaigns);
                    $closer_campaigns = preg_replace("/ /", "','", $closer_campaigns);
                    $closer_campaignsSQL .= "'$closer_campaigns',";
                    $c ++;
                }
                $closer_campaignsSQL = preg_replace('/,$/i', '', $closer_campaignsSQL);
                $stmt = "select count(*) from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($closer_campaignsSQL) $list_id_SQLand and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE');";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $TOTALanswers = ($row [0] + $ANSWERcalls);
                $stmt = "SELECT sum(wait_sec + talk_sec + dispo_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQLand $list_id_SQLandVALJOIN;";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $agent_non_pause_sec = $row [0];

                $AVG_ANSWERagent_non_pause_sec = (MathZDC($TOTALanswers, $agent_non_pause_sec) * 60);
                $AVG_ANSWERagent_non_pause_sec = round($AVG_ANSWERagent_non_pause_sec, 2);
                $AVG_ANSWERagent_non_pause_sec = sprintf("%10s", $AVG_ANSWERagent_non_pause_sec);
                if ($skip_productivity_calc) {
                    $OUToutput .= "<p>Productivity Rating: <b>N/A</b></p>";
                } else {
                    $OUToutput .= "<p>Productivity Rating: <b>$AVG_ANSWERagent_non_pause_sec</b></p>";
                }
                $OUToutput .= '<hr />';
                $OUToutput .= "<p>---------- <b>" . _QXZ("NO ANSWERS") . "</b></p>";
                $stmt = "select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN('NA','ADC','AB','CPDB','CPDUK','CPDATB','CPDNA','CPDREJ','CPDINV','CPDSUA','CPDSI','CPDSNC','CPDSR','CPDSUK','CPDSV','CPDERR') and (length_in_sec <= 60 or length_in_sec is null);";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $autoNAcalls = sprintf("%10s", $row [0]);

                $stmt = "select count(*),sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and status IN('B','DC','N') and (length_in_sec <= 60 or length_in_sec is null);";
                $query = $this->vicidialdb->db->query($stmt);
                $row = array_values($query->row_array());
                $manualNAcalls = sprintf("%10s", $row [0]);

                $totalNAcalls = ($autoNAcalls + $manualNAcalls);
                $totalNAcalls = sprintf("%10s", $totalNAcalls);

                $NApercent = (MathZDC($totalNAcalls, $TOTALcalls) * 100);
                $NApercent = round($NApercent, 2);

                $average_na_seconds = MathZDC($row [1], $row [0]);
                $average_na_seconds = round($average_na_seconds, 2);
                $average_na_seconds = sprintf("%10s", $average_na_seconds);

                $OUToutput .= "<p>" . _QXZ("Total NA calls -Busy,Disconnect,RingNoAnswer", 44) . ": <b>$totalNAcalls</b>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>$NApercent%</strong></p>";
                $OUToutput .= "<p>" . _QXZ("Total auto NA calls -system-set", 44) . ": <b>$autoNAcalls</b></p>";
                $OUToutput .= "<p>" . _QXZ("Total manual NA calls -agent-set", 44) . ": <b>$manualNAcalls</b></p>";
                $OUToutput .= "<p>" . _QXZ("Average Call Length for NA Calls in seconds", 44) . ": <b>$average_na_seconds</b></p>";
                $OUToutput .= '<hr />';
                // #############################
                // ######## CALL HANGUP REASON STATS
                $TOTALcalls = 0;
                $ASCII_text = '';
                $GRAPH = '';
                $GRAPH_text = '';
                $ASCII_text .= '<table class="table">';
                $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("CALL HANGUP REASON STATS") . "</caption>";
                $ASCII_text .= "<thead>";
                $ASCII_text .= "<tr>";
                $ASCII_text .= "<th>HANGUP REASON</th><th>CALLS</th>";
                $ASCII_text .= "</tr>";
                $ASCII_text .= "</thead>";

                $GRAPH .= "<table class='table table-bodered' cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"white\" summary=\"DID Summary\">\n";
                $GRAPH .= "<caption class='bold text-center' align='top'>" . _QXZ("CALL HANGUP REASON STATS") . "</caption>";
                $GRAPH .= "<tr>";
                $GRAPH .= "<th class=\"thgraph\" scope=\"col\">" . _QXZ("DID") . "</th>\n";
                $GRAPH .= "<th class=\"thgraph\" scope=\"col\">" . _QXZ("CALLS") . "</th>\n";
                $GRAPH .= "</tr>\n";

                $stmt = "select count(*),term_reason from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand group by term_reason;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $reasons_to_print = $query->num_rows();
                $i = 0;
                $max_calls = 0;
                $graph_stats = array();
                while ($i < $reasons_to_print) {
                    $row = array_values($result [$i]);
                    $TOTALcalls = ($TOTALcalls + $row [0]);
                    $REASONcount = sprintf("%10s", $row [0]);
                    while (strlen($REASONcount) > 10) {
                        $REASONcount = substr("$REASONcount", 0, - 1);
                    }
                    $reason = sprintf("%-20s", $row [1]);
                    while (strlen($reason) > 20) {
                        $reason = substr("$reason", 0, - 1);
                    }
                    if (preg_match('/NONE/', $reason)) {
                        $reason = _QXZ("NO ANSWER", 20);
                    }
                    if (preg_match('/CALLER/', $reason)) {
                        $reason = _QXZ("CUSTOMER", 20);
                    }
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<td>$reason</td> <td>$REASONcount</td>";
                    $ASCII_text .= '<tr>';
                    if ($row [0] > $max_calls) {
                        $max_calls = $row [0];
                    }
                    $graph_stats [$i] [0] = $row [0];
                    $graph_stats [$i] [1] = $row [1];
                    $i ++;
                } // while ($i < $reasons_to_print){
                $TOTALcalls = sprintf("%10s", $TOTALcalls);

                $ASCII_text .= "<tfoot>";
                $ASCII_text .= "<tr>";
                $ASCII_text .= "<td>TOTAL: </td> <td>$TOTALcalls </td>";
                $ASCII_text .= "</tr>";
                $ASCII_text .= "</tfoot>";
                $ASCII_text .= "</table>";

                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $GRAPH .= "  <tr>\n";
                    $GRAPH .= "	<td class=\"chart_td$class\">" . $graph_stats [$d] [1] . "</td>\n";
                    $GRAPH .= "	<td nowrap class=\"chart_td value$class\"><img src='" . site_url() . "/assets/images/bar.png' alt=\"\" width=\"" . round(MathZDC(400 * $graph_stats [$d] [0], $max_calls)) . "\" height=\"16\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='bold'>" . $graph_stats [$d] [0] . "</span></td>\n";
                    $GRAPH .= "  </tr>\n";
                }
                $GRAPH .= "  <tr>\n";
                $GRAPH .= "	<th class=\"thgraph\" scope=\"col\">" . _QXZ("TOTAL") . ":</th>\n";
                $GRAPH .= "	<th class=\"thgraph\" scope=\"col\">" . trim($TOTALcalls) . "</th>\n";
                $GRAPH .= "  </tr>\n";
                $GRAPH .= "</table>";
                $GRAPH_text .= $GRAPH;
                // #############################
                // ######## CALL STATUS STATS
                $TOTALcalls = 0;
                $ASCII_text .= "<table class='table'>";
                $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("CALL STATUS STATS") . "</caption>";
                $ASCII_text .= "<thead><tr>";
                $ASCII_text .= "<th>" . _QXZ("STATUS", 6) . "</th><th>" . _QXZ("DESCRIPTION", 20) . "</th><th>" . _QXZ("CATEGORY", 20) . "</th><th>" . _QXZ("CALLS", 10) . "</th><th>" . _QXZ("TOTAL TIME", 10) . "</th><th>" . _QXZ("AVG TIME", 8) . "</th><th>" . _QXZ("CALLS/HOUR", 10) . "</th><th>" . _QXZ("CALLS/HOUR", 10) . "</th>";
                $ASCII_text .= "</tr></thead>";

                // ####### GRAPHING #########
                $GRAPH = '<table class="table table-bordered">';
                $GRAPH .= '<tr>';
                $GRAPH .= '<th id="cssgraph1" width="20%"><a class="btn blue" style="text-align: center; display: block;" href="#" onClick="javascript:DrawCSSGraph(\'CALLS\', \'1\'); return false;">CALLS</a></th>';
                $GRAPH .= '<th id="cssgraph2" width="20%"><a class="btn blue" style="text-align: center; display: block;" href="#" onClick="javascript:DrawCSSGraph(\'TOTALTIME\', \'2\'); return false;">TOTAL TIME</a></th>';
                $GRAPH .= '<th id="cssgraph3" width="20%"><a class="btn blue" style="text-align: center; display: block;" href="#" onClick="javascript:DrawCSSGraph(\'AVGTIME\', \'3\'); return false;">AVG TIME</a></th>';
                $GRAPH .= '<th id="cssgraph4" width="20%"><a class="btn blue" style="text-align: center; display: block;" href="#" onClick="javascript:DrawCSSGraph(\'CALLSHOUR\', \'4\'); return false;">CALLS/HR</a></th>';
                $GRAPH .= '<th id="cssgraph5" width="20%"><a class="btn blue" style="text-align: center; display: block;" href="#" onClick="javascript:DrawCSSGraph(\'CALLSHOUR_agent\', \'5\'); return false;">AGENT CALLS/HR</a></th>';
                $GRAPH .= '</tr>';
                $GRAPH .= "<tr><td colspan='5' class='graph_span_cell'><span id='call_status_stats_graph'><BR>&nbsp;<BR></span></td></tr></table></div>";
                $graph_stats = array();
                $max_calls = 1;
                $max_total_time = 1;
                $max_avg_time = 1;
                $max_callshr = 1;
                $max_agentcallshr = 1;
                $graph_header = "<div class='table-responsive'><table cellspacing='0' cellpadding='0' summary='STATUS' class='table table-bordered'><caption class='bold text-center' align='top'>CALL STATUS STATS</caption><tr><th class='thgraph' scope='col'>STATUS</th>";
                $CALLS_graph = $graph_header . "<th class='thgraph' scope='col'>CALLS</th></tr>";
                $TOTALTIME_graph = $graph_header . "<th class='thgraph' scope='col'>TOTAL TIME</th></tr>";
                $AVGTIME_graph = $graph_header . "<th class='thgraph' scope='col'>AVG TIME</th></tr>";
                $CALLSHOUR_graph = $graph_header . "<th class='thgraph' scope='col'>CALLS/HR</th></tr>";
                $CALLSHOUR_agent_graph = $graph_header . "<th class='thgraph' scope='col'>AGENT CALLS/HR</th></tr>";
                $campaignSQL = "$group_SQLand";
                if (preg_match("/YES/i", $include_rollover)) {
                    $campaignSQL = "$both_group_SQLand";
                }
                // # Pull the count of agent seconds for the total tally
                $stmt = "SELECT sum(pause_sec + wait_sec + talk_sec + dispo_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' $campaignSQL $list_id_SQLandVALJOIN and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->row_array();
                $Ctally_to_print = $query->num_rows();
                if ($Ctally_to_print > 0) {
                    $rowx = array_values($result);
                    $AGENTsec = "$rowx[0]";
                }

                // # get counts and time totals for all statuses in this campaign
                $rollover_exclude_dropSQL = '';
                if (preg_match("/YES/i", $include_rollover)) {
                    $rollover_exclude_dropSQL = "and status NOT IN('DROP')";
                }
                $stmt = "select count(*),status,sum(length_in_sec) from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $rollover_exclude_dropSQL $group_SQLand $list_id_SQLand group by status;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $i = 0;
                $statusSQL = '';
                while ($i < $statuses_to_print) {
                    $row = array_values($result [$i]);
                    $STATUScountARY [$i] = $row [0];
                    $RAWstatusARY [$i] = $row [1];
                    $RAWhoursARY [$i] = $row [2];
                    $statusSQL .= "'$row[1]',";
                    $i ++;
                }
                if (preg_match("/YES/i", $include_rollover)) {
                    if (strlen($statusSQL) < 2) {
                        $statusSQL = "''";
                    } else {
                        $statusSQL = preg_replace('/,$/i', '', $statusSQL);
                    }
                    $stmt = "select distinct status from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status NOT IN($statusSQL) $group_drop_SQLand $list_id_SQLand;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $inS_statuses_to_print = $query->num_rows();
                    $n = 0;
                    while ($inS_statuses_to_print > $n) {
                        $rowx = $result [$n];
                        $STATUScountARY [$i] = 0;
                        $RAWstatusARY [$i] = $rowx [0];
                        $RAWhoursARY [$i] = 0;
                        $i ++;
                        $n ++;
                        $statuses_to_print ++;
                    }
                } // if (preg_match("/YES/i",$include_rollover)){
                $i = 0;
                $STATUSavg_sec = 0;
                $TOTALtimeS = 0;
                while ($i < $statuses_to_print) {
                    $STATUScount = $STATUScountARY [$i];
                    $RAWstatus = $RAWstatusARY [$i];
                    $RAWhours = $RAWhoursARY [$i];
                    if (preg_match("/YES/i", $include_rollover)) {
                        $stmt = "select count(*),sum(length_in_sec) from vicidial_closer_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status='$RAWstatus' $group_drop_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $in_statuses_to_print = $query->num_rows();
                        if ($in_statuses_to_print > 0) {
                            $rowx = array_values($query->row_array());
                            $inSTATUScount = $rowx [0];
                            $inRAWhours = $rowx [1];
                            $STATUScount = ($STATUScount + $inSTATUScount);
                            $RAWhours = ($RAWhours + $inRAWhours);
                        }
                    }
                    $r = 0;
                    while ($r < $statcats_to_print) {
                        if ($statcat_list [$RAWstatus] == "$vsc_id[$r]") {
                            $vsc_count [$r] = ($vsc_count [$r] + $STATUScount);
                        }
                        $r ++;
                    } // while ($r < $statcats_to_print){
                    if ($AGENTsec < 1) {
                        $AGENTsec = 1;
                    }
                    $TOTALcalls = ($TOTALcalls + $STATUScount);
                    $TOTALtimeS = ($TOTALtimeS + $RAWhours);
                    $STATUSrate = MathZDC($STATUScount, MathZDC($TOTALsec, 3600));
                    $STATUSrate = sprintf("%.2f", $STATUSrate);
                    $AGENTrate = MathZDC($STATUScount, MathZDC($AGENTsec, 3600));
                    $AGENTrate = sprintf("%.2f", $AGENTrate);
                    if ($STATUScount > $max_calls) {
                        $max_calls = $STATUScount;
                    }
                    if ($RAWhours > $max_total_time) {
                        $max_total_time = $RAWhours;
                    }
                    if ($STATUSavg_sec > $max_avg_time) {
                        $max_avg_time = $STATUSavg_sec;
                    }
                    if ($STATUSrate > $max_callshr) {
                        $max_callshr = $STATUSrate;
                    }
                    if ($AGENTrate > $max_agentcallshr) {
                        $max_agentcallshr = $AGENTrate;
                    }
                    $graph_stats [$i] [1] = $STATUScount;
                    $graph_stats [$i] [2] = $RAWhours;
                    $graph_stats [$i] [3] = MathZDC($RAWhours, $STATUScount);
                    $graph_stats [$i] [4] = $STATUSrate;
                    $graph_stats [$i] [5] = $AGENTrate;
                    $STATUShours = sec_convert($RAWhours, 'H');
                    $STATUSavg_sec = MathZDC($RAWhours, $STATUScount);
                    $STATUSavg = sec_convert($STATUSavg_sec, 'H');
                    $STATUScount = sprintf("%10s", $STATUScount);
                    while (strlen($STATUScount) > 10) {
                        $STATUScount = substr("$STATUScount", 0, - 1);
                    }
                    $status = sprintf("%-6s", $RAWstatus);
                    while (strlen($status) > 6) {
                        $status = substr("$status", 0, - 1);
                    }
                    $STATUShours = sprintf("%10s", $STATUShours);
                    while (strlen($STATUShours) > 10) {
                        $STATUShours = substr("$STATUShours", 0, - 1);
                    }
                    $STATUSavg = sprintf("%8s", $STATUSavg);
                    while (strlen($STATUSavg) > 8) {
                        $STATUSavg = substr("$STATUSavg", 0, - 1);
                    }
                    $STATUSrate = sprintf("%8s", $STATUSrate);
                    while (strlen($STATUSrate) > 8) {
                        $STATUSrate = substr("$STATUSrate", 0, - 1);
                    }
                    $AGENTrate = sprintf("%8s", $AGENTrate);
                    while (strlen($AGENTrate) > 8) {
                        $AGENTrate = substr("$AGENTrate", 0, - 1);
                    }
                    $status_name = sprintf("%-60s", $statname_list [$RAWstatus]);
                    while (mb_strlen($status_name, 'utf-8') > 20) {
                        $status_name = mb_substr("$status_name", 0, - 1, 'utf-8');
                    }
                    $statcat = sprintf("%-60s", $statcat_list [$RAWstatus]);
                    while (mb_strlen($statcat, 'utf-8') > 20) {
                        $statcat = mb_substr("$statcat", 0, - 1, 'utf-8');
                    }
                    $graph_stats [$i] [0] = "$status - $status_name - $statcat";
                    $ASCII_text .= "<tr>";
                    $ASCII_text .= "<td>$status</td><td>$status_name</td><td>$statcat</td><td>$STATUScount</td><td>$STATUShours</td><td>$STATUSavg</td><td>$STATUSrate</td><td>$AGENTrate</td>";
                    $ASCII_text .= "</tr>";
                    $i ++;
                } // while ($i < $statuses_to_print){

                $TOTALrate = MathZDC($TOTALcalls, MathZDC($TOTALsec, 3600));
                $TOTALrate = sprintf("%.2f", $TOTALrate);
                $aTOTALrate = MathZDC($TOTALcalls, MathZDC($AGENTsec, 3600));
                $aTOTALrate = sprintf("%.2f", $aTOTALrate);

                $aTOTALhours = sec_convert($AGENTsec, 'H');
                $TOTALhours = sec_convert($TOTALtimeS, 'H');
                $TOTALavg_sec = MathZDC($TOTALtimeS, $TOTALcalls);
                $TOTALavg = sec_convert($TOTALavg_sec, 'H');

                $TOTALcalls = sprintf("%10s", $TOTALcalls);
                $TOTALhours = sprintf("%10s", $TOTALhours);
                while (strlen($TOTALhours) > 10) {
                    $TOTALhours = substr("$TOTALhours", 0, - 1);
                }
                $aTOTALhours = sprintf("%10s", $aTOTALhours);
                while (strlen($aTOTALhours) > 10) {
                    $aTOTALhours = substr("$aTOTALhours", 0, - 1);
                }
                $TOTALavg = sprintf("%8s", $TOTALavg);
                while (strlen($TOTALavg) > 8) {
                    $TOTALavg = substr("$TOTALavg", 0, - 1);
                }
                $TOTALrate = sprintf("%8s", $TOTALrate);
                while (strlen($TOTALrate) > 8) {
                    $TOTALrate = substr("$TOTALrate", 0, - 1);
                }
                $aTOTALrate = sprintf("%8s", $aTOTALrate);
                while (strlen($aTOTALrate) > 8) {
                    $aTOTALrate = substr("$aTOTALrate", 0, - 1);
                }

                $ASCII_text .= "<tfoot></tr>";
                $ASCII_text .= "<td colspan='3' class='text-right'>" . _QXZ("TOTAL", 51) . ":</td><td>$TOTALcalls</td><td>$TOTALhours</td><td>$TOTALavg</td><td>$TOTALrate</td><td></td>";
                // $ASCII_text .= "| AGENT TIME | $aTOTALhours | | $aTOTALrate |\n";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= "</table>";
                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $CALLS_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "/assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [1], $max_calls)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [1] . "</td></tr>";
                    $TOTALTIME_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "/assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [2], $max_total_time)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [2], 'H') . "</td></tr>";
                    $AVGTIME_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "/assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [3], $max_avg_time)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [3], 'H') . "</td></tr>";
                    $CALLSHOUR_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "/assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [4], $max_callshr)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [4] . "</td></tr>";
                    $CALLSHOUR_agent_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "/assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [5], $max_agentcallshr)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [5] . "</td></tr>";
                }

                $CALLS_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTALcalls) . "</th></tr></table>";
                $TOTALTIME_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTALhours) . "</th></tr></table>";
                $AVGTIME_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTALavg) . "</th></tr></table>";
                $CALLSHOUR_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTALrate) . "</th></tr></table>";
                $CALLSHOUR_agent_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($aTOTALrate) . "</th></tr></table>";
                $this->data ['CALLS_graph'] = $CALLS_graph;
                $this->data ['TOTALTIME_graph'] = $TOTALTIME_graph;
                $this->data ['AVGTIME_graph'] = $AVGTIME_graph;
                $this->data ['CALLSHOUR_graph'] = $CALLSHOUR_graph;
                $this->data ['CALLSHOUR_agent_graph'] = $CALLSHOUR_agent_graph;
                $GRAPH_text .= $GRAPH;
                // #############################
                // ######## LIST ID BREAKDOWN STATS
                $TOTALcalls = 0;
                $ASCII_text .= "<table class='table'>";
                $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("LIST ID STATS") . "</caption>";
                $ASCII_text .= "<thead><tr>";
                $ASCII_text .= "<th>" . _QXZ("LIST", 40) . "</th><th>" . _QXZ("CALLS", 10) . "</th>";
                $ASCII_text .= "</tr></thead>";
                $GRAPH = '<table summary="DID Summary" class="table table-bordered">';
                $GRAPH .= '<caption class="bold text-center" align="top">' . _QXZ("LIST ID STATS") . '</caption>';
                $GRAPH .= '<tr>';
                $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("LIST") . '</th>';
                $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("CALLS") . '</th>';
                $GRAPH .= '</tr>';

                $stmt = "select count(*),list_id from vicidial_log where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand group by list_id;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $listids_to_print = $query->num_rows();
                $i = 0;
                $max_calls = 1;
                $graph_stats = array();
                while ($i < $listids_to_print) {
                    $row = array_values($result [$i]);
                    $LISTIDcalls [$i] = $row [0];
                    $LISTIDlists [$i] = $row [1];
                    if ($row [0] > $max_calls) {
                        $max_calls = $row [0];
                    }
                    $graph_stats [$i] [0] = $row [0];
                    $graph_stats [$i] [1] = $row [1];
                    $i ++;
                } // while ($i < $listids_to_print){
                $i = 0;
                $LISTIDlist_names = array();
                while ($i < $listids_to_print) {
                    $stmt = "select list_name from vicidial_lists where list_id='$LISTIDlists[$i]';";
                    $query = $this->vicidialdb->db->query($stmt);
                    $list_name_to_print = $query->num_rows();
                    if ($list_name_to_print > 0) {
                        $row = array_values($query->row_array());
                        $LISTIDlist_names [$i] = $row [0];
                    } else {
                        $LISTIDlist_names [$i] = '';
                    }
                    $TOTALcalls = ($TOTALcalls + $LISTIDcalls [$i]);
                    $LISTIDcount = sprintf("%10s", $LISTIDcalls [$i]);
                    while (strlen($LISTIDcount) > 10) {
                        $LISTIDcount = substr("$LISTIDcount", 0, - 1);
                    }
                    $LISTIDname = sprintf("%-40s", "$LISTIDlists[$i] - $LISTIDlist_names[$i]");
                    while (strlen($LISTIDname) > 40) {
                        $LISTIDname = substr("$LISTIDname", 0, - 1);
                    }
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<td>$LISTIDname</td><td>$LISTIDcount</td>";
                    $ASCII_text .= '</tr>';
                    $i ++;
                } // while ($i < $listids_to_print){
                $TOTALcalls = sprintf("%10s", $TOTALcalls);
                $ASCII_text .= "<tfoot><tr>";
                $ASCII_text .= "<td class='text-right'>" . _QXZ("TOTAL", 39) . ":</td><td>$TOTALcalls</td>";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= "</table>";
                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $GRAPH .= "  <tr>";
                    $GRAPH .= '	<td class="chart_td' . $class . '">' . $graph_stats [$d] [1] . '</td>';
                    $GRAPH .= '	<td nowrap class="chart_td value' . $class . '"><img src="' . site_url() . '/assets/images/bar.png" alt="" width="' . round(MathZDC(400 * $graph_stats [$d] [0], $max_calls)) . '" height="16" />&nbsp;&nbsp;&nbsp;' . $graph_stats [$d] [0] . '</td>';
                    $GRAPH .= "  </tr>";
                }
                $GRAPH .= "  <tr>";
                $GRAPH .= '	<th class="thgraph" scope="col">' . _QXZ("TOTAL") . ':</th>';
                $GRAPH .= '	<th class="thgraph" scope="col">' . trim($TOTALcalls) . '</th>';
                $GRAPH .= '  </tr>';
                $GRAPH .= "</table>";
                $GRAPH_text .= $GRAPH;

                if (($carrier_logging_active > 0) && ($carrier_stats == 'YES')) {
                    // #############################
                    // ######## CARRIER STATS
                    $TOTCARcalls = 0;
                    $ASCII_text .= "<table class='table'>";
                    $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("CARRIER CALL STATUSES") . "</caption>";
                    $ASCII_text .= "<thead><tr>";
                    $ASCII_text .= "<th>" . _QXZ("STATUS", 20) . "</th><th>" . _QXZ("CALLS", 10) . "</th><th></th>";
                    $ASCII_text .= "</tr></thead>";
                    // # get counts and time totals for all statuses in this campaign
                    $stmt = "select dialstatus,count(*) from vicidial_carrier_log vcl,vicidial_log vl where vcl.uniqueid=vl.uniqueid and vcl.call_date > \"$query_date_BEGIN\" and vcl.call_date < \"$query_date_END\" and vl.call_date > \"$query_date_BEGIN\" and vl.call_date < \"$query_date_END\" $group_SQLand $list_id_SQLand group by dialstatus order by dialstatus;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $carrierstatuses_to_print = $query->num_rows();
                    $i = 0;
                    while ($i < $carrierstatuses_to_print) {
                        $row = array_values($result [$i]);
                        $TOTCARcalls = ($TOTCARcalls + $row [1]);
                        $CARstatus = sprintf("%-20s", $row [0]);
                        while (strlen($CARstatus) > 20) {
                            $CARstatus = substr("$CARstatus", 0, - 1);
                        }
                        $CARcount = sprintf("%10s", $row [1]);
                        while (strlen($CARcount) > 10) {
                            $CARcount = substr("$CARcount", 0, - 1);
                        }
                        $ASCII_text .= "<tr>";
                        $ASCII_text .= "<td>$CARstatus</td><td>$CARcount</td><td></td>";
                        $ASCII_text .= "</tr>";
                        $i ++;
                    }
                    $TOTCARcalls = sprintf("%10s", $TOTCARcalls);
                    while (strlen($TOTCARcalls) > 10) {
                        $TOTCARcalls = substr("$TOTCARcalls", 0, - 1);
                    }
                    $ASCII_text .= "<tfoot><tr>";
                    $ASCII_text .= "<td class='text-right'>" . _QXZ("TOTAL", 20) . "</td><td>$TOTCARcalls</td><td></td>";
                    $ASCII_text .= "</tr></tfoot>";
                    $ASCII_text .= "</table";
                } // if ( ($carrier_logging_active > 0) && ($carrier_stats == 'YES') ){
                // # find if any selected campaigns have presets enabled
                $presets_enabled = 0;
                $stmt = "select count(*) from vicidial_campaigns where enable_xfer_presets='ENABLED' $group_SQLand;";
                $query = $this->vicidialdb->db->query($stmt);
                $presets_enabled_count = $query->num_rows();
                if ($presets_enabled_count > 0) {
                    $row = array_values($query->row_array());
                    $presets_enabled = $row [0];
                }
                if ($presets_enabled > 0) {
                    // #############################
                    // ######## PRESET DIAL STATS
                    $ASCII_text .= '<table class="table">';
                    $ASCII_text .= "<caption class='bold textr-center'>" . _QXZ("AGENT PRESET DIALS") . "</caption>";
                    $ASCII_text .= "<thead><tr>";
                    $ASCII_text .= "<td>" . _QXZ("PRESET NAME", 40) . "</td><td>" . _QXZ("CALLS", 10) . "</td>";
                    $ASCII_text .= "</tr></thead>";
                    $GRAPH = '<table summary="DID Summary" class="table table-bordered">';
                    $GRAPH .= '<caption class="bold text-center" align="top">' . _QXZ("AGENT PRESET DIALS") . '</caption>';
                    $GRAPH .= '<tr>';
                    $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("PRESET NAME") . '</th>';
                    $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("CALLS") . '</th>';
                    $GRAPH .= '</tr>';
                    $max_calls = 1;
                    $graph_stats = array();
                    // # get counts and time totals for all statuses in this campaign
                    $stmt = "select preset_name,count(*) from user_call_log$VL_INC where call_date > \"$query_date_BEGIN\" and call_date < \"$query_date_END\" and preset_name!='' and preset_name is not NULL  $group_SQLand  $list_id_SQLandUCLJOIN group by preset_name order by preset_name;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $carrierstatuses_to_print = $query->num_rows();
                    $result = $query->result_array();
                    $i = 0;
                    while ($i < $carrierstatuses_to_print) {
                        $row = array_values($result [$i]);
                        $TOTPREcalls = ($TOTPREcalls + $row [1]);
                        $PREstatus = sprintf("%-40s", $row [0]);
                        while (strlen($PREstatus) > 40) {
                            $PREstatus = substr("$PREstatus", 0, - 1);
                        }
                        $PREcount = sprintf("%10s", $row [1]);
                        while (strlen($PREcount) > 10) {
                            $PREcount = substr("$PREcount", 0, - 1);
                        }
                        if ($row [1] > $max_calls) {
                            $max_calls = $row [1];
                        }
                        $graph_stats [$i] [0] = $row [1];
                        $graph_stats [$i] [1] = $row [0];
                        $ASCII_text .= '<tr>';
                        $ASCII_text .= "<td>$PREstatus</td><td>$PREcount</td>";
                        $ASCII_text .= '</tr>';
                        $i ++;
                    } // while($i < $carrierstatuses_to_print){
                    for ($d = 0; $d < count($graph_stats); $d ++) {
                        if ($d == 0) {
                            $class = " first";
                        } else if (($d + 1) == count($graph_stats)) {
                            $class = " last";
                        } else {
                            $class = "";
                        }
                        $GRAPH .= '  <tr>';
                        $GRAPH .= '	<td class="chart_td' . $class . '">' . $graph_stats [$d] [1] . '</td>';
                        $GRAPH .= '	<td nowrap class="chart_td value' . $class . '"><img src="' . site_url() . '/assets/images/bar.png" alt="" width="' . round(MathZDC(400 * $graph_stats [$d] [0], $max_calls)) . '" height="16" />' . $graph_stats [$d] [0] . '</td>';
                        $GRAPH .= '  </tr>';
                    }
                    $GRAPH .= '  <tr>';
                    $GRAPH .= '	<th class="thgraph" scope="col">' . _QXZ("TOTAL CALLS") . ':</th>';
                    $GRAPH .= '	<th class="thgraph" scope="col">' . trim($TOTPREcalls) . '</th>';
                    $GRAPH .= '  </tr>';
                    $GRAPH .= '</table>';
                    $TOTPREcalls = sprintf("%10s", $TOTPREcalls);
                    while (strlen($TOTPREcalls) > 10) {
                        $TOTPREcalls = substr("$TOTPREcalls", 0, - 1);
                    }
                    $ASCII_text .= "<tfoot><tr>";
                    $ASCII_text .= "<td>" . _QXZ("TOTAL", 40) . "</td><td>$TOTPREcalls</td>";
                    $ASCII_text .= "</tfoot></tr>";
                    $ASCII_text .= '</table>';
                    $GRAPH_text .= $GRAPH;
                } // if ($presets_enabled > 0){
                // #############################
                // ######## STATUS CATEGORY STATS \
                $ASCII_text .= "<table class='table'>";
                $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("CUSTOM STATUS CATEGORY STATS") . "</caption>";
                $ASCII_text .= "<thead><tr>";
                $ASCII_text .= "<th>" . _QXZ("CATEGORY", 20) . "</th><th>" . _QXZ("CALLS", 10) . "</th><th>" . _QXZ("DESCRIPTION", 30) . "</th>";
                $ASCII_text .= "</tr></thead>";

                $GRAPH = '<table summary="DID Summary" class="table table-bordered">';
                $GRAPH .= '<caption align="top" class="bold text-center">' . _QXZ("CUSTOM STATUS CATEGORY STATS") . '</caption>';
                $GRAPH .= '<tr>';
                $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("CATEGORY") . '</th>';
                $GRAPH .= '<th class="thgraph" scope="col">' . _QXZ("CALLS") . '</th>';
                $GRAPH .= '</tr>';
                $max_calls = 1;
                $graph_stats = array();
                $TOTCATcalls = 0;
                $r = 0;
                $i = 0;
                while ($r < $statcats_to_print) {
                    if ($vsc_id [$r] != 'UNDEFINED') {
                        $TOTCATcalls = ($TOTCATcalls + $vsc_count [$r]);
                        $category = sprintf("%-20s", $vsc_id [$r]);
                        while (strlen($category) > 20) {
                            $category = substr("$category", 0, - 1);
                        }
                        $CATcount = sprintf("%10s", $vsc_count [$r]);
                        while (strlen($CATcount) > 10) {
                            $CATcount = substr("$CATcount", 0, - 1);
                        }
                        $CATname = sprintf("%-30s", $vsc_name [$r]);
                        while (strlen($CATname) > 30) {
                            $CATname = substr("$CATname", 0, - 1);
                        }

                        if ($vsc_count [$r] > $max_calls) {
                            $max_calls = $vsc_count [$r];
                        }
                        $graph_stats [$i] [0] = $vsc_count [$r];
                        $graph_stats [$i] [1] = $vsc_id [$r];
                        $i ++;
                        $ASCII_text .= '<tr>';
                        $ASCII_text .= "<td>$category</td><td>$CATcount</td><td>$CATname</td>";
                        $ASCII_text .= '</tr>';
                    }
                    $r ++;
                } // while ($r < $statcats_to_print){
                $TOTCATcalls = sprintf("%10s", $TOTCATcalls);
                while (strlen($TOTCATcalls) > 10) {
                    $TOTCATcalls = substr("$TOTCATcalls", 0, - 1);
                }

                $ASCII_text .= "<tfoot><tr>";
                $ASCII_text .= "<td>" . _QXZ("TOTAL", 20) . "</td><td>$TOTCATcalls</td><td></td>";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= "</table>";
                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $GRAPH .= '  <tr>';
                    $GRAPH .= '	<td class="chart_td' . $class . '">' . $graph_stats [$d] [1] . '</td>';
                    $GRAPH .= '	<td nowrap class="chart_td value' . $class . '"><img src="' . site_url() . '/assests/images/bar.png" alt="" width="' . round(MathZDC(400 * $graph_stats [$d] [0], $max_calls)) . '" height="16" />' . $graph_stats [$d] [0] . '</td>';
                    $GRAPH .= '  </tr>';
                }
                $GRAPH .= '  <tr>';
                $GRAPH .= '	<th class="thgraph" scope="col">' . _QXZ("TOTAL") . ':</th>';
                $GRAPH .= '	<th class="thgraph" scope="col">' . trim($TOTCATcalls) . '</th>';
                $GRAPH .= '  </tr>';
                $GRAPH .= '</table>';
                $GRAPH_text .= $GRAPH;

                // #############################
                // ######## USER STATS

                $TOTagents = 0;
                $TOTcalls = 0;
                $TOTtime = 0;
                $TOTavg = 0;
                $ASCII_text .= "<table class='table'>";
                $ASCII_text .= "<caption class='bold text-center'>" . _QXZ("AGENT STATS") . "</caption>";
                $ASCII_text .= "<thead><tr>";
                $ASCII_text .= "<th>" . _QXZ("AGENT", 24) . "</th><th>" . _QXZ("CALLS", 10) . "</th><th>" . _QXZ("TIME H:M:S", 10) . "</th><th>" . _QXZ("AVERAGE", 7) . "</th>";
                $ASCII_text .= "</tr></thead>";

                // ####### GRAPHING #########
                $graph_stats = array();
                $max_calls = 1;
                $max_total_time = 1;
                $max_avg_time = 1;
                $GRAPH = '<table class="table table-bordered">';
                $GRAPH .= "<tr><th width='33%' class='grey_graph_cell' id='AGENTgraph1'><a class=\"btn blue\" style='text-align: center; display: block;' href='#' onClick=\"DrawAGENTGraph('CALLS', '1'); return false;\">" . _QXZ("CALLS") . "</a></th><th width='33%' class='grey_graph_cell' id='AGENTgraph2'><a class=\"btn blue\" style='text-align: center; display: block;' href='#' onClick=\"DrawAGENTGraph('TOTALTIME', '2'); return false;\">" . _QXZ("TOTAL TIME") . "</a></th><th width='34%' class='grey_graph_cell' id='AGENTgraph3'><a class=\"btn blue\" style='text-align: center; display: block;' href='#' onClick=\"DrawAGENTGraph('AVGTIME', '3'); return false;\">" . _QXZ("AVG TIME") . "</a></th></tr>";
                $GRAPH .= "<tr><td colspan='4' class='graph_span_cell'><span id='agent_stats_graph'><BR>&nbsp;<BR></span></td></tr></table><BR><BR>";
                $graph_header = "<table cellspacing='0' cellpadding='0' class='table table-bordered'><caption class='bold text-center' align='top'>" . _QXZ("AGENT STATS") . "</caption><tr><th class='thgraph' scope='col'>" . _QXZ("STATUS") . "</th>";
                $CALLS_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("CALLS") . " </th></tr>";
                $TOTALTIME_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("TOTAL TIME") . "</th></tr>";
                $AVGTIME_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("AVG TIME") . "</th></tr>";
                // ##########################
                $stmt = "select vicidial_log.user,full_name,count(*),sum(length_in_sec),avg(length_in_sec) from vicidial_log,vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand $list_id_SQLand and vicidial_log.user is not null and length_in_sec is not null and length_in_sec > 0 and vicidial_log.user=vicidial_users.user group by vicidial_log.user;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $users_to_print = $query->num_rows();
                $i = 0;
                while ($i < $users_to_print) {
                    $row = array_values($result [$i]);
                    $RAWuser [$i] = $row [0];
                    $RAWfull_name [$i] = $row [1];
                    $RAWuser_calls [$i] = $row [2];
                    $RAWuser_talk [$i] = $row [3];
                    $RAWuser_average [$i] = $row [4];

                    $TOTcalls = ($TOTcalls + $row [2]);
                    $TOTtime = ($TOTtime + $row [3]);
                    $i ++;
                } // while($i < $users_to_print){
                $i = 0;
                while ($i < $users_to_print) {
                    // $user = sprintf("%-6s", $RAWuser[$i]);while(strlen($user)>6) {$user = substr("$user", 0, -1);}
                    $user = $RAWuser [$i];
                    $full_name = sprintf("%-45s", $RAWfull_name [$i]);
                    while (mb_strlen($full_name, 'utf-8') > 15) {
                        $full_name = mb_substr("$full_name", 0, - 1, 'utf-8');
                    }
                    if (preg_match("/YES/i", $include_rollover)) {
                        $length_in_secZ = 0;
                        $queue_secondsZ = 0;
                        $agent_alert_delayZ = 0;
                        $stmt = "select length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id and user='$RAWuser[$i]' $group_drop_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->result_array();
                        $INallcalls_to_printZ = $query->num_rows();
                        $y = 0;
                        while ($y < $INallcalls_to_printZ) {
                            $row = array_values($result [$y]);
                            $length_in_secZ = $row [0];
                            $queue_secondsZ = $row [1];
                            $agent_alert_delayZ = $row [2];

                            $CIdelay = round(MathZDC($agent_alert_delayZ, 1000));
                            $thiscallsec = (($length_in_secZ - $queue_secondsZ) - $CIdelay);
                            if ($thiscallsec < 0) {
                                $thiscallsec = 0;
                            }
                            $inCIsec = ($inCIsec + $thiscallsec);
                            $y ++;
                        }
                        $inCIcallsRAW = $y;
                        $RAWuser_talk [$i] = ($RAWuser_talk [$i] + $inCIsec);
                        $RAWuser_calls [$i] = ($RAWuser_calls [$i] + $inCIcallsRAW);

                        $TOTcalls = ($TOTcalls + $inCIcallsRAW);
                        $TOTtime = ($TOTtime + $inCIsec);
                    } // if (preg_match("/YES/i",$include_rollover)){
                    $USERcalls = sprintf("%10s", $RAWuser_calls [$i]);
                    $USERtotTALK = $RAWuser_talk [$i];
                    $USERavgTALK = round(MathZDC($RAWuser_talk [$i], $RAWuser_calls [$i]));

                    if ($RAWuser_calls [$i] > $max_calls) {
                        $max_calls = $RAWuser_calls [$i];
                    }
                    if ($RAWuser_talk [$i] > $max_total_time) {
                        $max_total_time = $RAWuser_talk [$i];
                    }
                    if ($USERavgTALK > $max_avg_time) {
                        $max_avg_time = $USERavgTALK;
                    }
                    $graph_stats [$i] [0] = "$user - $full_name";
                    $graph_stats [$i] [1] = $RAWuser_calls [$i];
                    $graph_stats [$i] [2] = $RAWuser_talk [$i];
                    $graph_stats [$i] [3] = $USERavgTALK;

                    $USERtotTALK_MS = sec_convert($USERtotTALK, 'H');
                    $USERavgTALK_MS = sec_convert($USERavgTALK, 'H');

                    $USERtotTALK_MS = sprintf("%9s", $USERtotTALK_MS);
                    $USERavgTALK_MS = sprintf("%6s", $USERavgTALK_MS);
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<td>$user - $full_name</td><td>$USERcalls</td><td>$USERtotTALK_MS</td><td>$USERavgTALK_MS</td>";
                    $ASCII_text .= '</tr>';
                    $i ++;
                } // while ($i < $users_to_print){
                $rawTOTtime = $TOTtime;
                if (!$TOTcalls) {
                    $TOTcalls = 1;
                }
                $TOTavg = MathZDC($TOTtime, $TOTcalls);

                $TOTavg_MS = sec_convert($TOTavg, 'H');
                $TOTtime_MS = sec_convert($TOTtime, 'H');

                $TOTavg = sprintf("%6s", $TOTavg_MS);
                $TOTtime = sprintf("%10s", $TOTtime_MS);

                $TOTagents = sprintf("%10s", $i);
                $TOTcalls = sprintf("%10s", $TOTcalls);
                $TOTtime = sprintf("%8s", $TOTtime);
                $TOTavg = sprintf("%6s", $TOTavg);

                $stmt = "select avg(wait_sec) from vicidial_agent_log$VL_INC where event_time >= '$query_date_BEGIN' and event_time <= '$query_date_END' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQLand  $list_id_SQLandVALJOIN;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->row_array();
                $row = array_values($result);
                $AVGwait = $row [0];
                $AVGwait_MS = sec_convert($AVGwait, 'H');
                $AVGwait = sprintf("%6s", $AVGwait_MS);

                $ASCII_text .= "<tfoot><tr>";
                $ASCII_text .= "<td>" . _QXZ("TOTAL Agents", 12) . ": <span class='text-right'>$TOTagents</span></td><td>$TOTcalls</td><td>$TOTtime</td><td>$TOTavg</td>";
                $ASCII_text .= "</tr><tr>";
                $ASCII_text .= "<td colspan='3'>" . _QXZ("Average Wait time between calls", 52) . "</td><td> $AVGwait</td>";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= "</table>";

                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $CALLS_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [1], $max_calls)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [1] . "</td></tr>";
                    $TOTALTIME_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [2], $max_total_time)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [2], 'H') . "</td></tr>";
                    $AVGTIME_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [3], $max_avg_time)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [3], 'H') . "</td></tr>";
                }
                $CALLS_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTcalls) . "</th></tr></table>";
                $TOTALTIME_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtime) . "</th></tr></table>";
                $AVGTIME_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavg) . "</th></tr></table>";
                $this->data ['ACALLS_graph'] = $CALLS_graph;
                $this->data ['ATOTALTIME_graph'] = $TOTALTIME_graph;
                $this->data ['AAVGTIME_graph'] = $AVGTIME_graph;
                $GRAPH_text .= $GRAPH;
                $costformat_text = '';
                if ($costformat > 0) {
                    $stmt = "select campaign_id,phone_number,length_in_sec from vicidial_log,vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' $group_SQLand  $list_id_SQLand and vicidial_log.user=vicidial_users.user;";
                    $query = $this->vicidialdb->dd->query($stmt);
                    $result = $query->result_array();
                    $allcalls_to_print = $query->num_rows();
                    $w = 0;
                    while ($w < $allcalls_to_print) {
                        $row = array_values($result [$w]);
                        if ($print_calls > 0) {
                            echo "$row[0]\t$row[1]\t$row[2]\n";
                        }
                        $tempTALK = ($tempTALK + $row [2]);
                        $w ++;
                    } // while ($w < $allcalls_to_print){
                    if (preg_match("/YES/i", $include_rollover)) {
                        $stmt = "select campaign_id,phone_number,length_in_sec,queue_seconds,agent_alert_delay from vicidial_closer_log,vicidial_inbound_groups where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and group_id=campaign_id $group_drop_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->dd->query($stmt);
                        $result = $query->result_array();
                        $INallcalls_to_print = $query->num_rows();
                        $w = 0;
                        while ($w < $INallcalls_to_print) {
                            $row = array_values($result [$w]);
                            if ($print_calls > 0) {
                                echo "$row[0]\t$row[1]\t$row[2]\t$row[3]\t$row[4]\n";
                            }
                            $newTALK = ($row [2] - $row [3] - MathZDC($row [4], 1000));
                            if ($newTALK < 0) {
                                $newTALK = 0;
                            }
                            $tempTALK = ($tempTALK + $newTALK);
                            $w ++;
                        }
                    } // if (preg_match("/YES/i",$include_rollover)){
                    $tempTALKmin = MathZDC($tempTALK, 60);
                    if ($print_calls > 0) {
                        echo "$w\t$tempTALK\t$tempTALKmin\n";
                    }
                    $rawTOTtalk_min = round(MathZDC($tempTALK, 60));
                    $outbound_cost = ($rawTOTtalk_min * $outbound_rate);
                    $outbound_cost = sprintf("%8.2f", $outbound_cost);

                    $costformat_text .= "<p>" . _QXZ("OUTBOUND") . " $query_date " . _QXZ("to") . " $end_date, &nbsp; $rawTOTtalk_min " . _QXZ("minutes at") . " \$$outbound_rate = \$$outbound_cost</B><p>";
                } // if ($costformat > 0){
                $this->data ['costformat_text'] = $costformat_text;
                if ($report_display_type == "HTML") {
                    $OUToutput .= $GRAPH_text;
                } else {
                    $OUToutput .= $ASCII_text;
                }
                if ($bottom_graph == 'YES') {
                    // #############################
                    // ######## TIME STATS

                    $hi_hour_count = 0;
                    $last_full_record = 0;
                    $i = 0;
                    $h = 0;
                    while ($i <= 96) {
                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:00:00' and call_date <= '$query_date $h:14:59' $group_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $hour_count [$i] = $row [0];
                        if ($hour_count [$i] > $hi_hour_count) {
                            $hi_hour_count = $hour_count [$i];
                        }
                        if ($hour_count [$i] > 0) {
                            $last_full_record = $i;
                        }
                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:00:00' and call_date <= '$query_date $h:14:59' $group_SQLand $list_id_SQLand and status='DROP';";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $drop_count [$i] = $row [0];
                        $i ++;

                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:15:00' and call_date <= '$query_date $h:29:59' $group_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $hour_count [$i] = $row [0];
                        if ($hour_count [$i] > $hi_hour_count) {
                            $hi_hour_count = $hour_count [$i];
                        }
                        if ($hour_count [$i] > 0) {
                            $last_full_record = $i;
                        }
                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:15:00' and call_date <= '$query_date $h:29:59' $group_SQLand $list_id_SQLand and status='DROP';";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $drop_count [$i] = $row [0];
                        $i ++;

                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:30:00' and call_date <= '$query_date $h:44:59' $group_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $hour_count [$i] = $row [0];
                        if ($hour_count [$i] > $hi_hour_count) {
                            $hi_hour_count = $hour_count [$i];
                        }
                        if ($hour_count [$i] > 0) {
                            $last_full_record = $i;
                        }
                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:30:00' and call_date <= '$query_date $h:44:59' $group_SQLand $list_id_SQLand and status='DROP';";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $drop_count [$i] = $row [0];
                        $i ++;

                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:45:00' and call_date <= '$query_date $h:59:59' $group_SQLand $list_id_SQLand;";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $hour_count [$i] = $row [0];
                        if ($hour_count [$i] > $hi_hour_count) {
                            $hi_hour_count = $hour_count [$i];
                        }
                        if ($hour_count [$i] > 0) {
                            $last_full_record = $i;
                        }
                        $stmt = "select count(*) from vicidial_log where call_date >= '$query_date $h:45:00' and call_date <= '$query_date $h:59:59' $group_SQLand $list_id_SQLand and status='DROP';";
                        $query = $this->vicidialdb->db->query($stmt);
                        $result = $query->row_array();
                        $row = array_values($result);
                        $drop_count [$i] = $row [0];
                        $i ++;
                        $h ++;
                    } // while ($i <= 96){
                    $hour_multiplier = MathZDC(100, $hi_hour_count);
                    $time_stat = "<!-- HICOUNT: $hi_hour_count|$hour_multiplier -->\n";
                    $time_stat .= "<p><strong>" . _QXZ("GRAPH IN 15 MINUTE INCREMENTS OF TOTAL CALLS PLACED FROM THIS CAMPAIGN") . "</strong></p>";
                    $time_stat .= '<table class="table table-bordered">';
                    $time_stat .= "<caption class='bold text-center'>" . _QXZ("TIME STATS") . "</caption>";
                    $k = 1;
                    $k = 1;
                    $Mk = 0;
                    $call_scale = '0';
                    while ($k <= 102) {
                        if ($Mk >= 5) {
                            $Mk = 0;
                            $scale_num = MathZDC($k, $hour_multiplier, 100);
                            $scale_num = round($scale_num, 0);
                            $LENscale_num = (strlen($scale_num));
                            $k = ($k + $LENscale_num);
                            $call_scale .= "$scale_num";
                        } else {
                            $call_scale .= " ";
                            $k ++;
                            $Mk ++;
                        }
                    } // while ($k <= 102){
                    $time_stat .= '<thead><tr>';
                    $time_stat .= '<td>HOUR</td><td>' . $call_scale . '</td><td>DROPS</td><td>TOTAL</td>';
                    $time_stat .= '</tr></thead>';
                    $ZZ = '00';
                    $i = 0;
                    $h = 4;
                    $hour = - 1;
                    $no_lines_yet = 1;
                    while ($i <= 96) {
                        $time_stat .= '<tr>';
                        $char_counter = 0;
                        $time = '      ';
                        if ($h >= 4) {
                            $hour ++;
                            $h = 0;
                            if ($hour < 10) {
                                $hour = "0$hour";
                            }
                            $time = "+$hour$ZZ+";
                        }
                        if ($h == 1) {
                            $time = "   15 ";
                        }
                        if ($h == 2) {
                            $time = "   30 ";
                        }
                        if ($h == 3) {
                            $time = "   45 ";
                        }
                        $Ghour_count = $hour_count [$i];
                        if ($Ghour_count < 1) {
                            if (($no_lines_yet) or ( $i > $last_full_record)) {
                                $do_nothing = 1;
                            } else {
                                $hour_count [$i] = sprintf("%-5s", $hour_count [$i]);
                                $time_stat .= "<td>$time</td>";
                                $k = 0;
                                while ($k <= 102) {
                                    echo " ";
                                    $k ++;
                                }
                                $time_stat .= "<td>$hour_count[$i]</td>";
                            }
                        } else {
                            $no_lines_yet = 0;
                            $Xhour_count = ($Ghour_count * $hour_multiplier);
                            $Yhour_count = (99 - $Xhour_count);
                            $Gdrop_count = $drop_count [$i];
                            if ($Gdrop_count < 1) {
                                $hour_count [$i] = sprintf("%-5s", $hour_count [$i]);
                                $time_stat .= "<td>$time<SPAN class=\"green\">";
                                $k = 0;
                                while ($k <= $Xhour_count) {
                                    echo "*";
                                    $k ++;
                                    $char_counter ++;
                                }
                                $time_stat .= "*X</SPAN></td>";
                                $char_counter ++;
                                $k = 0;
                                while ($k <= $Yhour_count) {
                                    echo " ";
                                    $k ++;
                                    $char_counter ++;
                                }
                                while ($char_counter <= 101) {
                                    echo " ";
                                    $char_counter ++;
                                }
                                $time_stat .= "<td> 0     </td><td> $hour_count[$i]</td>";
                            } else {
                                $Xdrop_count = ($Gdrop_count * $hour_multiplier);

                                // if ($Xdrop_count >= $Xhour_count) {$Xdrop_count = ($Xdrop_count - 1);}

                                $XXhour_count = (($Xhour_count - $Xdrop_count) - 1);

                                $hour_count [$i] = sprintf("%-5s", $hour_count [$i]);
                                $drop_count [$i] = sprintf("%-5s", $drop_count [$i]);

                                $time_stat .= "<td>$time|<SPAN class=\"red\">";
                                $k = 0;
                                while ($k <= $Xdrop_count) {
                                    $time_stat .= ">";
                                    $k ++;
                                    $char_counter ++;
                                }
                                $time_stat .= "D</SPAN></td><td><SPAN class=\"green\">";
                                $char_counter ++;
                                $k = 0;
                                while ($k <= $XXhour_count) {
                                    $time_stat .= "*";
                                    $k ++;
                                    $char_counter ++;
                                }
                                $time_stat .= "X</SPAN></td>";
                                $char_counter ++;
                                $k = 0;
                                while ($k <= $Yhour_count) {
                                    $time_stat .= " ";
                                    $k ++;
                                    $char_counter ++;
                                }
                                while ($char_counter <= 102) {
                                    $time_stat .= " ";
                                    $char_counter ++;
                                }
                                $time_stat .= "<td> $drop_count[$i] </td><td>$hour_count[$i]</td>";
                            }
                        }
                        $i ++;
                        $h ++;
                        $time_stat .= '</tr>';
                    } // while ($i <= 96){
                    $time_stat .= '</table>';
                } else { // if ($bottom_graph == 'YES'){{
                    $time_stat .= '';
                }
                $ENDtime = date("U");
                $RUNtime = ($ENDtime - $STARTtime);
                $this->data ['end'] = "<p>" . _QXZ("Run Time") . ": $RUNtime " . _QXZ("seconds") . "</p>";
                $this->data ['time_stat'] = $time_stat;
                $this->data ['succees'] = TRUE;
                $this->data ['output'] = $OUToutput;
            }
        } //

        $this->template->load($this->_template, 'dialer/report/outbound', $this->data);
    }

    public function agent() {
        $this->data ['datatable'] = TRUE;
        $this->data ['model'] = TRUE;
        $this->data ['validation'] = TRUE;
        $this->data ['sweetAlert'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        $this->data ['listtitle'] = 'Agent Performance Detail';
        $this->data ['title'] = 'Agent Performance Detail';
        $this->data ['breadcrumb'] = "Agent Performance Detail";
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $this->data ['agencies'] = $this->agency_model->get_nested($this->session->userdata('agency')->id);
        } else {
            $this->data ['agencies'] = $this->agency_model->get_nested();
        }
        $this->data ['succees'] = FALSE;
        $this->data ['message'] = '';

        if ($this->session->userdata('user')->group_name == 'Agency') {
            $camps = $this->vcampaigns_m->queryForAgency();
            if (!$camps) {
                $camps = array();
            }
            $campaigns = array();
            foreach ($camps as $campaign) {
                $campaigns [] = (object) $campaign;
            }
            $this->data ['campaigns'] = $campaigns;
        } else {
            $this->data ['campaigns'] = $this->vcampaigns_m->get_by(array(
                'active' => 'Y'
            ));
        }
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $this->data ['user_groups'] = $this->agroups_m->query();
        } else {
            $this->data ['user_groups'] = $this->vugroup_m->get();
        }
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $agencyList = getAgencies();
            $stmt_B = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.id IN ({$agencyList})";
            $agencyUsers = $this->db->query($stmt_B)->result();
            $stmt_A = "SELECT main.*,sub.fname,sub.lname FROM vicidial_users main,agents sub WHERE sub.vicidial_user_id = main.user_id AND sub.agency_id IN ({$agencyList})";
            $agentUsers = $this->db->query($stmt_A)->result();
            $this->data['agencyUsers'] = $agencyUsers;
            $this->data['agentUsers'] = $agentUsers;
        } else {
            $this->data ['users'] = $this->vusers_m->get();
        }
        $postData ['shift'] = "ALL";
        $this->form_validation->set_rules('group[]', 'Campaign', 'trim|required');
        $this->form_validation->set_rules('query_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'Date', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $postData = $this->input->post();
            $this->data ['postData'] = $postData;
            $query_date = isset($postData ["query_date"]) ? date('Y-m-d', strtotime($postData ["query_date"])) : '';
            $end_date = isset($postData ["end_date"]) ? date('Y-m-d', strtotime($postData ["end_date"])) : '';
            $group = isset($postData ["group"]) ? $postData ["group"] : array();
            $user_group = isset($postData ["user_group"]) ? $postData ["user_group"] : array();
            $users = isset($postData ["users"]) ? $postData ["users"] : array();
            $shift = isset($postData ["shift"]) ? $postData ["shift"] : 'ALL';
            $stage = isset($postData ["stage"]) ? $postData ["stage"] : '';
            $report_display_type = isset($postData ["report_display_type"]) ? $postData ["report_display_type"] : '';
            $show_percentages = isset($postData ["show_percentages"]) ? $postData ["show_percentages"] : '';
            $file_download = isset($postData ["file_download"]) ? $postData ["file_download"] : '';
            $time_in_sec = isset($postData ["time_in_sec"]) ? $postData ["time_in_sec"] : '';
            $breakdown_by_date = isset($postData ["breakdown_by_date"]) ? $postData ["breakdown_by_date"] : '';
            $search_archived_data = isset($postData ["search_archived_data"]) ? $postData ["search_archived_data"] : '';
            $show_defunct_users = isset($postData ["show_defunct_users"]) ? $postData ["show_defunct_users"] : '';
            $HTML_text = '';
            $ASCII_text = '';
            $GRAPH_text = '';
            $JS_text = '';
            $JS_onload = '';
            if (strlen($shift) < 2) {
                $shift = 'ALL';
            }
            if (isset($search_archived_data) && $search_archived_data == "checked") {
                $agent_log_table = "vicidial_agent_log_archive";
            } else {
                $agent_log_table = "vicidial_agent_log";
            }

            $TIME_HF_agentperfdetail = 'HF';
            $TIME_H_agentperfdetail = 'H';
            $TIME_M_agentperfdetail = 'M';
            if (isset($file_download) && $file_download == 1) {
                $TIME_HF_agentperfdetail = 'HF';
                $TIME_H_agentperfdetail = 'HF';
                $TIME_M_agentperfdetail = 'HF';
            }

            if (isset($time_in_sec) && $time_in_sec) {
                $TIME_HF_agentperfdetail = 'S';
                $TIME_H_agentperfdetail = 'S';
                $TIME_M_agentperfdetail = 'S';
            }
            $report_name = 'Agent Performance Detail';
            // TO DO : change variable according to the agency log in
            $LOGallowed_campaigns = '-ALL-CAMPAIGNS-';
            $LOGadmin_viewable_groups = '  ';
            $LOGadmin_viewable_call_times = '  ';

            $LOGallowed_campaignsSQL = '';
            $whereLOGallowed_campaignsSQL = '';
            if ((!preg_match('/\-ALL/i', $LOGallowed_campaigns))) {
                $rawLOGallowed_campaignsSQL = preg_replace("/ -/", '', $LOGallowed_campaigns);
                $rawLOGallowed_campaignsSQL = preg_replace("/ /", "','", $rawLOGallowed_campaignsSQL);
                $LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
                $whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
            }
            $regexLOGallowed_campaigns = " $LOGallowed_campaigns ";
            $LOGadmin_viewable_groupsSQL = '';
            $whereLOGadmin_viewable_groupsSQL = '';
            if ((!preg_match('/\-\-ALL\-\-/i', $LOGadmin_viewable_groups)) and ( strlen($LOGadmin_viewable_groups) > 3)) {
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/", '', $LOGadmin_viewable_groups);
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ /", "','", $rawLOGadmin_viewable_groupsSQL);
                $LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
                $whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
            }
            $MT [0] = '';
            $NOW_DATE = date("Y-m-d");
            $NOW_TIME = date("Y-m-d H:i:s");
            $STARTtime = date("U");
            if (!isset($group)) {
                $group = '';
            }
            if (!isset($query_date)) {
                $query_date = $NOW_DATE;
            }
            if (!isset($end_date)) {
                $end_date = $NOW_DATE;
            }

            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            while ($i < $group_ct) {
                $group_string .= "$group[$i]|";
                $i ++;
            }

            $i = 0;
            $users_string = '|';
            $users_ct = count($users);
            while ($i < $users_ct) {
                $users_string .= "$users[$i]|";
                $i ++;
            }
            $stmt = "select campaign_id from vicidial_campaigns $whereLOGallowed_campaignsSQL order by campaign_id;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $campaigns_to_print = $query->num_rows();
            $i = 0;
            while ($i < $campaigns_to_print) {
                $row = array_values($result [$i]);
                $groups [$i] = $row [0];
                if (preg_match('/\-ALL/', $group_string)) {
                    $group [$i] = $groups [$i];
                }
                $i ++;
            } // while ($i < $campaigns_to_print){
            for ($i = 0; $i < count($user_group); $i ++) {
                if (preg_match('/\-\-ALL\-\-/', $user_group [$i])) {
                    $all_user_groups = 1;
                    $user_group = "";
                }
            }
            $stmt = "select user_group from vicidial_user_groups $whereLOGadmin_viewable_groupsSQL order by user_group;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $user_groups_to_print = $query->num_rows();
            $i = 0;
            while ($i < $user_groups_to_print) {
                $row = array_values($result [$i]);
                $user_groups [$i] = $row [0];
                if (isset($all_user_groups) && $all_user_groups) {
                    $user_group [$i] = $row [0];
                }
                $i ++;
            } // while ($i < $user_groups_to_print){
            $stmt = "select user, full_name from vicidial_users $whereLOGadmin_viewable_groupsSQL order by user";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $users_to_print = $query->num_rows();
            $i = 0;
            while ($i < $users_to_print) {
                $row = array_values($result [$i]);
                $user_list [$i] = $row [0];
                $user_names [$i] = $row [1];
                if (isset($all_users) && $all_users) {
                    $user_list [$i] = $row [0];
                }
                $i ++;
            } // while ($i < $users_to_print){
            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            $group_SQL = '';
            $groupQS = '';
            while ($i < $group_ct) {
                if ((preg_match("/ $group[$i] /", $regexLOGallowed_campaigns)) or ( preg_match("/-ALL/", $LOGallowed_campaigns))) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $groupQS .= "&group[]=$group[$i]";
                }
                $i ++;
            } // while($i < $group_ct){
            if ((preg_match('/\-\-ALL\-\-/', $group_string)) or ( $group_ct < 1)) {
                $group_SQL = "";
            } else {
                $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                $group_SQL = "and campaign_id IN($group_SQL)";
            }
            $i = 0;
            $user_group_string = '|';
            $user_group_SQL = '';
            $user_groupQS = '';
            $user_group_ct = count($user_group);
            while ($i < $user_group_ct) {
                $user_group_string .= "$user_group[$i]|";
                $user_group_SQL .= "'$user_group[$i]',";
                $user_groupQS .= "&user_group[]=$user_group[$i]";
                $i ++;
            }
            if ((preg_match('/\-\-ALL\-\-/', $user_group_string)) || ($user_group_ct < 1)) {
                $user_group_SQL = "";
                $user_group_agent_log_SQL = "";
                $user_group_SQL = "";
            } else {
                $user_group_SQL = preg_replace('/,$/i', '', $user_group_SQL);
                $user_group_agent_log_SQL = "and vicidial_agent_log.user_group IN($user_group_SQL)";
                $user_group_SQL = "and vicidial_users.user_group IN($user_group_SQL)";
            }
            $i = 0;
            $user_string = '|';
            $user_SQL = '';
            $userQS = '';
            $user_ct = count($users);
            while ($i < $user_ct) {
                $user_string .= "$users[$i]|";
                $user_SQL .= "'$users[$i]',";
                $userQS .= "&users[]=$users[$i]";
                $i ++;
            }
            if ((preg_match('/\-\-ALL\-\-/', $user_string)) || ($user_ct < 1)) {
                $user_SQL = "";
                $user_agent_log_SQL = "";
                $user_SQL = "";
            } else {
                $user_SQL = preg_replace('/,$/i', '', $user_SQL);
                $user_agent_log_SQL = "and vicidial_agent_log.user IN($user_SQL)";
                $user_SQL = "and vicidial_users.user IN($user_SQL)";
            }

            if (!$group) {
                $HTML_text .= "\n";
                $HTML_text .= _QXZ("PLEASE SELECT A CAMPAIGN AND DATE-TIME ABOVE AND CLICK SUBMIT") . "\n";
                $HTML_text .= " " . _QXZ("NOTE: stats taken from shift specified") . "\n";
            } else {
                if ($shift == 'AM') {
                    $AM_shift_BEGIN = '';
                    $AM_shift_END = '';
                    $time_BEGIN = $AM_shift_BEGIN;
                    $time_END = $AM_shift_END;
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "03:45:00";
                    }
                    if (strlen($time_END) < 6) {
                        $time_END = "15:14:59";
                    }
                }
                if ($shift == 'PM') {
                    $PM_shift_BEGIN = '';
                    $PM_shift_END = '';
                    $time_BEGIN = $PM_shift_BEGIN;
                    $time_END = $PM_shift_END;
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "15:15:00";
                    }
                    if (strlen($time_END) < 6) {
                        $time_END = "23:15:00";
                    }
                }
                if ($shift == 'ALL') {
                    $time_BEGIN = '';
                    $time_END = '';
                    if (isset($time_BEGIN) && strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "00:00:00";
                    }
                    if (isset($time_END) && strlen($time_END) < 6) {
                        $time_END = "23:59:59";
                    }
                }
                $query_date_BEGIN = "$query_date $time_BEGIN";
                $query_date_END = "$end_date $time_END";
                $HTML_text .= "<h3 class='text-center'>" . _QXZ("Agent Performance Detail", 47) . " $NOW_TIME</h3>";

                $HTML_text .= "<p class='text-center'>" . _QXZ("Time range") . ": $query_date_BEGIN " . _QXZ("to") . " $query_date_END</p>";
                $HTML_text .= "<h5 class='bold text-center'>---------- " . _QXZ("AGENTS Details") . " -------------</h5>";
                $HTML_text .= "<hr />";
                $statuses = '-';
                $statusesTXT = '';
                $statusesHEAD = '';
                // # Breakdown by date text
                if ($breakdown_by_date) {
                    $BBD_header = "------------+";
                    $BBD_text = "<th>" . _QXZ("CALL DATE", 10) . "</th>";
                    $BBD_filler = " | " . sprintf("%-10s", " ");
                    $BBD_csv = _QXZ("CALL DATE", 10) . "\",\"";
                    $BBD_csv_filler = "\",\"";
                } else {
                    $BBD_header = "";
                    $BBD_text = "";
                    $BBD_filler = "";
                    $BBD_csv = "";
                    $BBD_csv_filler = "";
                }

                $CSV_header = "\"" . _QXZ("Agent Performance Detail", 47) . " $NOW_TIME\"\n";
                $CSV_header .= "\"" . _QXZ("Time range") . ": $query_date_BEGIN " . _QXZ("to") . " $query_date_END\"\n\n";
                $CSV_header .= "\"---------- " . _QXZ("AGENTS Details") . " -------------\"\n";
                if ($show_percentages) {
                    $CSV_header .= '"' . _QXZ("USER NAME") . '","' . _QXZ("AGENCY") . '","' . _QXZ("AGENT") . '","' . _QXZ("ID") . '","' . _QXZ("CURRENT USER GROUP") . '","' . _QXZ("MOST RECENT USER GROUP") . '","' . _QXZ("CALLS") . '","' . _QXZ("TIME") . '","' . _QXZ("PAUSE") . '","' . _QXZ("PAUSE") . ' %","' . _QXZ("PAUSAVG") . '","' . _QXZ("WAIT") . '","' . _QXZ("WAIT") . ' %","' . _QXZ("WAITAVG") . '","' . _QXZ("TALK") . '","' . _QXZ("TALK") . ' %","' . _QXZ("TALKAVG") . '","' . _QXZ("DISPO") . '","' . _QXZ("DISPO") . ' %","' . _QXZ("DISPAVG") . '","' . _QXZ("DEAD") . '","' . _QXZ("DEAD") . ' %","' . _QXZ("DEADAVG") . '","' . _QXZ("CUSTOMER") . '","' . _QXZ("CUSTOMER") . ' %","' . _QXZ("CUSTAVG") . '"';
                } else {
                    $CSV_header .= '"' . _QXZ("USER NAME") . '","' . _QXZ("AGENCY") . '","' . _QXZ("AGENT") . '","' . _QXZ("ID") . '","' . _QXZ("CURRENT USER GROUP") . '","' . _QXZ("MOST RECENT USER GROUP") . '","' . _QXZ("CALLS") . '","' . _QXZ("TIME") . '","' . _QXZ("PAUSE") . '","' . _QXZ("PAUSAVG") . '","' . _QXZ("WAIT") . '","' . _QXZ("WAITAVG") . '","' . _QXZ("TALK") . '","' . _QXZ("TALKAVG") . '","' . _QXZ("DISPO") . '","' . _QXZ("DISPAVG") . '","' . _QXZ("DEAD") . '","' . _QXZ("DEADAVG") . '","' . _QXZ("CUSTOMER") . '","' . _QXZ("CUSTAVG") . '"';
                }
                $statusesHTML = '';
                $statusesARY [0] = '';
                $j = 0;
                $users = '-';
                $usersARY [0] = '';
                $user_namesARY [0] = '';
                $k = 0;
                $recent_UG_stmt = "select max(agent_log_id), user from vicidial_agent_log where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQL $user_group_agent_log_SQL $user_agent_log_SQL group by user";
                $query = $this->vicidialdb->db->query($recent_UG_stmt);
                $recent_UG_rslt = $query->result_array();
                foreach ($recent_UG_rslt as $row) {
                    $UG_row = array_values($row);
                    $agent_log_id = $UG_row [0];
                    $al_stmt = "select user_group from vicidial_agent_log where agent_log_id='$agent_log_id'";
                    $query = $this->vicidialdb->db->query($al_stmt);
                    $al_rslt = $query->row_array();
                    $Ugrp_row = array_values($al_rslt);
                    $recent_user_groups [$UG_row [1]] = $Ugrp_row [0];
                }
                $stmt = "select count(*) as calls,sum(talk_sec) as talk,full_name,vicidial_users.user,sum(pause_sec),sum(wait_sec),sum(dispo_sec),status,sum(dead_sec), vicidial_users.user_group from vicidial_users,vicidial_agent_log where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and vicidial_users.user=vicidial_agent_log.user and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQL $user_group_SQL $user_SQL group by user,full_name,user_group,status order by full_name,user,status desc limit 500000;";
                $query = $this->vicidialdb->db->query($stmt);
                $result = $query->result_array();
                $rows_to_print = $query->num_rows();
                $graph_stats = array();
                $max_calls = 1;
                $max_time = 1;
                $max_pause = 1;
                $max_pauseavg = 1;
                $max_wait = 1;
                $max_waitavg = 1;
                $max_talk = 1;
                $max_talkavg = 1;
                $max_dispo = 1;
                $max_dispoavg = 1;
                $max_dead = 1;
                $max_deadavg = 1;
                $max_customer = 1;
                $max_customeravg = 1;

                $GRAPH = '<div class="table-responsive"><table class="table table-bordered">';
                $GRAPH2 = "<tr>
                                <th class='column_header grey_graph_cell' id='callstatsgraph1'><a href='#' class='btn btn-link' onClick=\"DrawGraph('CALLS', '1'); return false;\">" . _QXZ("CALLS") . "</a>
                                </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph2'><a href='#' class='btn btn-link' onClick=\"DrawGraph('TIME', '2'); return false;\">" . _QXZ("TIME") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph3'><a href='#' class='btn btn-link' onClick=\"DrawGraph('PAUSE', '3'); return false;\">" . _QXZ("PAUSE") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph4'><a href='#' class='btn btn-link' onClick=\"DrawGraph('PAUSEAVG', '4'); return false;\">" . _QXZ("PAUSE AVG") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph5'><a href='#' class='btn btn-link' onClick=\"DrawGraph('WAIT', '5'); return false;\">" . _QXZ("WAIT") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph6'><a href='#' class='btn btn-link' onClick=\"DrawGraph('WAITAVG', '6'); return false;\">" . _QXZ("WAIT AVG") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph7'><a href='#' class='btn btn-link' onClick=\"DrawGraph('TALK', '7'); return false;\">" . _QXZ("TALK") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph8'><a href='#' class='btn btn-link' onClick=\"DrawGraph('TALKAVG', '8'); return false;\">" . _QXZ("TALK AVG") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph9'><a href='#' class='btn btn-link' onClick=\"DrawGraph('DISPO', '9'); return false;\">" . _QXZ("DISPO") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph10'><a href='#' class='btn btn-link' onClick=\"DrawGraph('DISPOAVG', '10'); return false;\">" . _QXZ("DISPO AVG") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph11'><a href='#' class='btn btn-link' onClick=\"DrawGraph('DEAD', '11'); return false;\">" . _QXZ("DEAD") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph12'><a href='#' class='btn btn-link' onClick=\"DrawGraph('DEADAVG', '12'); return false;\">" . _QXZ("DEAD AVG") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph13'><a href='#' class='btn btn-link' onClick=\"DrawGraph('CUST', '13'); return false;\">" . _QXZ("CUST") . "</a>
                                 </th>
                                 <th class='column_header grey_graph_cell' id='callstatsgraph14'><a href='#' class='btn btn-link' onClick=\"DrawGraph('CUSTAVG', '14'); return false;\">" . _QXZ("CUST AVG") . "</a>
                                 </th>";
                $graph_header = "<table class='table table-bordered'><caption class='bold text-center'>" . _QXZ("CALL STATS BREAKDOWN") . ": (" . _QXZ("Statistics related to handling of calls only") . ")</caption><tr><th class='thgraph' scope='col'>" . _QXZ("USER") . "</th>";
                $CALLS_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("CALLS") . "</th></tr>";
                $TIME_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("TIME") . "</th></tr>";
                $PAUSE_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("PAUSE") . "</th></tr>";
                $PAUSEAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("PAUSE AVG") . "</th></tr>";
                $WAIT_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("WAIT") . "</th></tr>";
                $WAITAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("WAIT AVG") . "</th></tr>";
                $TALK_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("TALK") . "</th></tr>";
                $TALKAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("TALK AVG") . "</th></tr>";
                $DISPO_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("DISPO") . "</th></tr>";
                $DISPOAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("DISPO AVG") . "</th></tr>";
                $DEAD_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("DEAD") . "</th></tr>";
                $DEADAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("DEAD AVG") . "</th></tr>";
                $CUST_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("CUST") . "</th></tr>";
                $CUSTAVG_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("CUST AVG") . "</th></tr>";
                if ($show_defunct_users == "checked") {
                    $user_stmt = "SELECT distinct '' as full_name, user from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' $group_SQL $user_agent_log_SQL order by user asc";
                } else {
                    $user_stmt = "SELECT distinct full_name,vicidial_users.user,vicidial_users.user_group from vicidial_users," . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and vicidial_users.user=" . $agent_log_table . ".user $group_SQL $user_group_SQL order by full_name asc";
                }
                $query = $this->vicidialdb->db->query($user_stmt);
                $q = 0;
                $result = $query->result_array();
                while ($q < $query->num_rows()) {
                    $user_row = array_values($result [$q]);
                    if ($show_defunct_users == "checked") {
                        $defunct_user_stmt = "SELECT full_name, user_group from vicidial_users where user='$user_row[1]'";
                        $query = $this->vicidialdb->db->query($defunct_user_stmt);
                        if ($query->num_rows() > 0) {
                            $defunct_user_row = array_values($query->row_array());
                            $full_name_val = $defunct_user_row [0];
                            $user_group_val = $defunct_user_row [1];
                        } else {
                            $full_name_val = $user_row [1];
                            $user_group_val = "** NONE **";
                        }
                    } else {
                        $full_name_val = $user_row [0];
                        $user_group_val = $user_row [2];
                    }
                    $full_name [$q] = $full_name_val;
                    $user [$q] = $user_row [1];
                    $user_group [$q] = $user_group_val;

                    if (!preg_match("/\-$user[$q]\-/i", $users)) {
                        $users .= "$user[$q]-";
                        $usersARY [$k] = $user [$q];
                        $user_namesARY [$k] = $full_name [$q];
                        $user_groupsARY [$k] = $user_group [$q];
                        $k ++;
                    }
                    $q ++;
                } // while($q<mysqli_num_rows($user_rslt)){
                if ($show_defunct_users == "checked") {
                    $stat_stmt = "SELECT distinct status from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQL $user_agent_log_SQL $user_SQL order by status asc";
                } else {
                    $stat_stmt = "SELECT distinct status from vicidial_users," . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and vicidial_users.user=" . $agent_log_table . ".user and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQL $user_group_SQL $user_SQL order by status asc";
                }
                $query = $this->vicidialdb->db->query($stat_stmt);
                $result = $query->result_array();
                $q = 0;
                $userTOTcalls = array();
                $rows_to_print = 0;
                $count = 0;
                while ($count < $query->num_rows()) {
                    $stat_row = array_values($result[$count]);
                    $current_status = $stat_row [0];

                    if ($show_defunct_users == "checked") {
                        $stmt = "SELECT count(*) as calls,sum(talk_sec) as talk,'' as full_name,user,sum(pause_sec),sum(wait_sec),sum(dispo_sec),status,sum(dead_sec), '' as user_group,date(event_time) as call_date from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 and status='$current_status' $group_SQL $user_agent_log_SQL $user_SQL group by user,full_name,user_group,status,call_date order by full_name,user,status desc limit 500000;";
                    } else {
                        $stmt = "SELECT count(*) as calls,sum(talk_sec) as talk,full_name,vicidial_users.user,sum(pause_sec),sum(wait_sec),sum(dispo_sec),status,sum(dead_sec), vicidial_users.user_group,date(event_time) as call_date from vicidial_users," . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and vicidial_users.user=" . $agent_log_table . ".user and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 and status='$current_status' $group_SQL $user_group_SQL $user_SQL group by user,full_name,user_group,status order by full_name,user,status desc limit 500000;";
                    }
                    $query1 = $this->vicidialdb->db->query($stmt);
                    $resultStmt = $query1->result_array();
                    $rows_to_print += $query1->num_rows();
                    $stat_rows_to_print = $query1->num_rows();
                    $i = 0;
                    while ($i < $stat_rows_to_print) {
                        $row = array_values($resultStmt [$i]);
                        if ($show_defunct_users == "checked") {
                            $defunct_user_stmt = "SELECT full_name,user_group from vicidial_users where user='$row[3]'";
                            $defunct_user_rslt = $this->vicidialdb->db->query($defunct_user_stmt);
                            if ($defunct_user_rslt->num_rows() > 0) {
                                $defunct_user_row = array_values($defunct_user_rslt->row_array());
                                $full_name_val = $defunct_user_row [0];
                                $user_group_val = $defunct_user_row [1];
                            } else {
                                $full_name_val = $row [3];
                                $user_group_val = "**NONE**";
                            }
                        } else {
                            $full_name_val = $row [2];
                            $user_group_val = $row [9];
                        }
                        $calls [$q] = $row [0];
                        $talk_sec [$q] = $row [1];
                        $full_name [$q] = $full_name_val;
                        $user [$q] = $row [3];
                        $pause_sec [$q] = $row [4];
                        $wait_sec [$q] = $row [5];
                        $dispo_sec [$q] = $row [6];
                        $status [$q] = strtoupper($row [7]);
                        $dead_sec [$q] = $row [8];
                        $user_group [$q] = $user_group_val;
                        $call_date [$q] = $row [10];
                        $customer_sec [$q] = ($talk_sec [$q] - $dead_sec [$q]);
                        if (strlen($status [$q]) > 0) {
                            if (isset($userTOTcalls [$row [3]])) {
                                $userTOTcalls [$row [3]] += $row [0];
                            } else {
                                $userTOTcalls [$row [3]] = $row [0];
                            }
                        }
                        $max_varname = "max_" . $status [$q];
                        $$max_varname = 1;
                        if ($customer_sec [$q] < 1) {
                            $customer_sec [$q] = 0;
                        }
                        if ((!preg_match("/\-$status[$q]\-/i", $statuses)) and ( strlen($status [$q]) > 0)) {
                            $statusesTXT = sprintf("%8s", $status [$q]);
                            $statusesHEAD .= "----------+";
                            $statusesHTML .= "<th>$statusesTXT</th>";
                            $CSV_header .= ",\"$status[$q]\"";
                            if ($show_percentages) {
                                $statusesHEAD .= "------------+";
                                $statusesHTML .= "<th>$statusesTXT %</th>";
                                $CSV_header .= ",\"$status[$q] %\"";
                            }
                            $statuses .= "$status[$q]-";
                            $statusesARY [$j] = $status [$q];
                            $j ++;
                        }
                        if (!preg_match("/\-$user[$q]\-/i", $users)) {
                            $users .= "$user[$q]-";
                            $usersARY [$k] = $user [$q];
                            $user_namesARY [$k] = $full_name [$q];
                            $user_groupsARY [$k] = $user_group [$q];
                            $k ++;
                        }
                        $i ++;
                        $q ++;
                    } // while ($i < $stat_rows_to_print){
                    $count++;
                } //while( $count < $query->num_rows() )
                $CSV_header .= "\n";
                $CSV_lines = '';
                // $ASCII_text.=_QXZ("CALL STATS BREAKDOWN").": ("._QXZ("Statistics related to handling of calls only").") <a href=\"\">["._QXZ("DOWNLOAD")."]</a>\n";
                $ASCII_text .= '<div class="table-responsive">';
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= '<caption class="text-center bold">' . _QXZ("CALL STATS BREAKDOWN") . ": (" . _QXZ("Statistics related to handling of calls only") . ")     <a href=\"javascript:checkDownload(1)\">[" . _QXZ("DOWNLOAD") . "]</a></caption>";
                if ($show_percentages) {
                    // $ASCII_text.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+$statusesHEAD\n";
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<th>USER NAME</th><th>Agency</th><th>ID</th><th>CURRENT USER GROUP</th><th>MOST RECENT USER GRP</th>" . $BBD_text . "<th>CALLS</th><th>TIME</th><th>PAUSE</th><th>PAUSE</th><th>PAUSAVG</th><th>WAIT</th><th>WAIT%</th><th>WAITAVG</th><th>TALK</th><th>TALK%</th><th>TALKAVG</th><th>DISPO</th><th>DISPO%</th><th>DISPAVG</th><th>DEAD</th><th>DEAD%</th><th>DEADAVG</th><th>CUSTOMER</th><th>CUSTOMER%</th><th>CUSTAVG</th>$statusesHTML";
                    $ASCII_text .= '</tr>'; // $ASCII_text.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+$statusesHEAD\n";
                } else {
                    // $ASCII_text.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+$statusesHEAD\n";
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<th>" . _QXZ("USER NAME", 15) . "</th><th>Agency</th><th>Agent</th><th>" . _QXZ("ID", 8) . "</th><th>" . _QXZ("CURRENT USER GROUP", 20) . "</th><th>" . _QXZ("MOST RECENT USER GRP", 20) . "</th>" . $BBD_text . "<th>" . _QXZ("CALLS", 6) . "</th><th>" . _QXZ("TIME", 9) . "</th><th>" . _QXZ("PAUSE", 8) . "</th><th>" . _QXZ("PAUSAVG", 7) . "</th><th>" . _QXZ("WAIT", 8) . "</th><th>" . _QXZ("WAITAVG", 7) . "</th><th>" . _QXZ("TALK", 8) . "</th><th>" . _QXZ("TALKAVG", 7) . "</th><th>" . _QXZ("DISPO", 8) . "</th><th>" . _QXZ("DISPAVG", 7) . "</th><th>" . _QXZ("DEAD", 8) . "</th><th>" . _QXZ("DEADAVG", 7) . "</th><th>" . _QXZ("CUSTOMER", 8) . "</th><th>" . _QXZ("CUSTAVG", 7) . "</th>$statusesHTML";
                    $ASCII_text .= '</tr>'; // $ASCII_text.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+$statusesHEAD\n";
                }
                // ## BEGIN loop through each user ###
                $m = 0;
                $Toutput_sub = "";
                $TOTcalls = 0;
                while ($m < $k) {
                    $Suser = $usersARY [$m];
                    if ($breakdown_by_date == 'checked') {
                        $Toutput_sub = "";
                        $CSV_lines_sub = "";

                        $SstatusesHTML = '';
                        $CSVstatuses = '';

                        $Stalk_sec_pct = 0;
                        $Spause_sec_pct = 0;
                        $Swait_sec_pct = 0;
                        $Sdispo_sec_pct = 0;
                        $Sdead_sec_pct = 0;

                        $date_stmt = "select distinct date(event_time) as call_date from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and user='$Suser' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 $group_SQL $user_group_agent_log_SQL $user_agent_log_SQL order by call_date asc limit 500000;";

                        $query = $this->vicidialdb->db->query($date_stmt);
                        $date_rslt = $query->result_array();

                        if ($date_rslt) {
                            foreach ($date_rslt as $date_row) {
                                $date_row = array_values($date_row);
                                $call_dateX = $date_row[0];
                                $cd_stmt = "SELECT count(*) as calls,sum(talk_sec) as talk,'' as full_name,user,sum(pause_sec),sum(wait_sec),sum(dispo_sec),status,sum(dead_sec), '' as user_group from " . $agent_log_table . " where date(event_time)='$call_dateX' and pause_sec<65000 and wait_sec<65000 and talk_sec<65000 and dispo_sec<65000 and user='$Suser' $group_SQL $user_agent_log_SQL $user_SQL group by user,full_name,user_group,status order by full_name,user,status desc limit 500000;";
                                $qureydat = $this->vicidialdb->db->query($cd_stmt);
                                $cd_rslt = $qureydat->result_array();
                                $x = 0;
                                if ($cd_rslt) {
                                    foreach ($cd_rslt as $cd_row) {
                                        $cd_row = array_values($cd_row);
                                        $calls_sub [$x] = $cd_row [0];
                                        $talk_sec_sub [$x] = $cd_row [1];
                                        $user_sub [$x] = $cd_row [3];
                                        $pause_sec_sub [$x] = $cd_row [4];
                                        $wait_sec_sub [$x] = $cd_row [5];
                                        $dispo_sec_sub [$x] = $cd_row [6];
                                        $status_sub [$x] = strtoupper($cd_row [7]);
                                        $dead_sec_sub [$x] = $cd_row [8];
                                        $customer_sec_sub [$x] = ($talk_sec_sub [$x] - $dead_sec_sub [$x]);
                                        $x ++;
                                    } // foreach($cd_rslt as $cd_row){
                                } // if($cd_rslt){
                                $Stime = 0;
                                $Scalls = 0;
                                $Stalk_sec = 0;
                                $Spause_sec = 0;
                                $Swait_sec = 0;
                                $Sdispo_sec = 0;
                                $Sdead_sec = 0;
                                $Scustomer_sec = 0;
                                $o = 0;
                                $SstatusesHTML = '';
                                $CSVstatuses = '';
                                while ($o < $j) {
                                    $Sstatus = $statusesARY [$o];
                                    $Scall_date = $call_date [$o];
                                    $SstatusTXT = '';
                                    $i = 0;
                                    $status_found = 0;
                                    while ($i < $x) {
                                        if ($Sstatus == "$status_sub[$i]") {
                                            $Scalls = ($Scalls + $calls_sub [$i]);
                                            $Stalk_sec = ($Stalk_sec + $talk_sec_sub [$i]);
                                            $Spause_sec = ($Spause_sec + $pause_sec_sub [$i]);
                                            $Swait_sec = ($Swait_sec + $wait_sec_sub [$i]);
                                            $Sdispo_sec = ($Sdispo_sec + $dispo_sec_sub [$i]);
                                            $Sdead_sec = ($Sdead_sec + $dead_sec_sub [$i]);
                                            $Scustomer_sec = ($Scustomer_sec + $customer_sec_sub [$i]);
                                            $SstatusTXT = sprintf("%8s", $calls_sub [$i]);
                                            $SstatusesHTML .= "<td>$SstatusTXT</td>";

                                            $CSVstatuses .= ",\"$calls_sub[$i]\"";

                                            if ($show_percentages) {
                                                $SstatusTXT_pct = sprintf("%8s", sprintf("%0.2f", MathZDC(100 * $calls [$i], $userTOTcalls [$Suser])));
                                                $SstatusesHTML .= "<td> $SstatusTXT_pct % </td>";
                                                $CSVstatuses .= ",\"$SstatusTXT_pct %\"";
                                            }

                                            $status_found ++;
                                        } // if ($Sstatus=="$status_sub[$i]"){
                                        $i ++;
                                    }
                                    if ($status_found < 1) {
                                        $SstatusesHTML .= "<td>        0 </td>";
                                        $CSVstatuses .= ",\"0\"";
                                        if ($show_percentages) {
                                            $SstatusesHTML .= "<td>     0.00 % </td>";
                                            $CSVstatuses .= ",\"0.00 %\"";
                                        }
                                    }
                                    $o ++;
                                } // while ($o < $j){
                                $Stime = ($Stalk_sec + $Spause_sec + $Swait_sec + $Sdispo_sec);

                                $Stalk_avg = MathZDC($Stalk_sec, $Scalls);
                                $Spause_avg = MathZDC($Spause_sec, $Scalls);
                                $Swait_avg = MathZDC($Swait_sec, $Scalls);
                                $Sdispo_avg = MathZDC($Sdispo_sec, $Scalls);
                                $Sdead_avg = MathZDC($Sdead_sec, $Scalls);
                                $Scustomer_avg = MathZDC($Scustomer_sec, $Scalls);

                                $RAWuser = $Suser;
                                $RAWcalls = $Scalls;
                                $Scalls = sprintf("%6s", $Scalls);
                                //$Sfull_nameRAW = $Sfull_name;
                                $SuserRAW = $Suser;

                                $pfUSERtime_MS = sec_convert($Stime, $TIME_H_agentperfdetail);
                                $pfUSERtotTALK_MS = sec_convert($Stalk_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotTALK_MS_pct = sprintf("%0.2f", MathZDC(100 * $Stalk_sec, $Stime));
                                $pfUSERavgTALK_MS = sec_convert($Stalk_avg, $TIME_M_agentperfdetail);
                                $USERtotPAUSE_MS = sec_convert($Spause_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotPAUSE_MS_pct = sprintf("%0.2f", MathZDC(100 * $Spause_sec, $Stime));
                                $USERavgPAUSE_MS = sec_convert($Spause_avg, $TIME_M_agentperfdetail);
                                $USERtotWAIT_MS = sec_convert($Swait_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotWAIT_MS_pct = sprintf("%0.2f", MathZDC(100 * $Swait_sec, $Stime));
                                $USERavgWAIT_MS = sec_convert($Swait_avg, $TIME_M_agentperfdetail);
                                $USERtotDISPO_MS = sec_convert($Sdispo_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotDISPO_MS_pct = sprintf("%0.2f", MathZDC(100 * $Sdispo_sec, $Stime));
                                $USERavgDISPO_MS = sec_convert($Sdispo_avg, $TIME_M_agentperfdetail);
                                $USERtotDEAD_MS = sec_convert($Sdead_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotDEAD_MS_pct = sprintf("%0.2f", MathZDC(100 * $Sdead_sec, $Stime));
                                $USERavgDEAD_MS = sec_convert($Sdead_avg, $TIME_M_agentperfdetail);
                                $USERtotCUSTOMER_MS = sec_convert($Scustomer_sec, $TIME_H_agentperfdetail);
                                $pfUSERtotCUSTOMER_MS_pct = sprintf("%0.2f", MathZDC(100 * $Scustomer_sec, $Stime));
                                $USERavgCUSTOMER_MS = sec_convert($Scustomer_avg, $TIME_M_agentperfdetail);

                                $pfUSERtime_MS = sprintf("%9s", $pfUSERtime_MS);
                                $pfUSERtotTALK_MS = sprintf("%8s", $pfUSERtotTALK_MS);
                                $pfUSERtotTALK_MS_pct = sprintf("%8s", $pfUSERtotTALK_MS_pct);
                                $pfUSERavgTALK_MS = sprintf("%6s", $pfUSERavgTALK_MS);
                                $pfUSERtotPAUSE_MS = sprintf("%8s", $USERtotPAUSE_MS);
                                $pfUSERtotPAUSE_MS_pct = sprintf("%8s", $pfUSERtotPAUSE_MS_pct);
                                $pfUSERavgPAUSE_MS = sprintf("%6s", $USERavgPAUSE_MS);
                                $pfUSERtotWAIT_MS = sprintf("%8s", $USERtotWAIT_MS);
                                $pfUSERtotWAIT_MS_pct = sprintf("%8s", $pfUSERtotWAIT_MS_pct);
                                $pfUSERavgWAIT_MS = sprintf("%6s", $USERavgWAIT_MS);
                                $pfUSERtotDISPO_MS = sprintf("%8s", $USERtotDISPO_MS);
                                $pfUSERtotDISPO_MS_pct = sprintf("%8s", $pfUSERtotDISPO_MS_pct);
                                $pfUSERavgDISPO_MS = sprintf("%6s", $USERavgDISPO_MS);
                                $pfUSERtotDEAD_MS = sprintf("%8s", $USERtotDEAD_MS);
                                $pfUSERtotDEAD_MS_pct = sprintf("%8s", $pfUSERtotDEAD_MS_pct);
                                $pfUSERavgDEAD_MS = sprintf("%6s", $USERavgDEAD_MS);
                                $pfUSERtotCUSTOMER_MS = sprintf("%8s", $USERtotCUSTOMER_MS);
                                $pfUSERtotCUSTOMER_MS_pct = sprintf("%8s", $pfUSERtotCUSTOMER_MS_pct);
                                $pfUSERavgCUSTOMER_MS = sprintf("%6s", $USERavgCUSTOMER_MS);
                                $PAUSEtotal [$m] = $pfUSERtotPAUSE_MS;

                                $Scall_date = sprintf("%-10s", $call_dateX);
                                $Sfull_name = sprintf("%-45s", " ");
                                $Suser_group = sprintf("%-60s", " ");
                                $Slast_user_group = sprintf("%-60s", " ");
                                $Suser_sub = sprintf("%-24s", " ");

                                if ($show_percentages) {
                                    $Toutput_sub .= '<tr>';
                                    $Toutput_sub .= "<td>$Sfull_name</td>
													<td></td><td></td>
													<td>$Suser_sub</td>
													<td> $Suser_group</td>
													<td>$Slast_user_group</td>
													<td> $Scall_date</td>
													<td>$Scalls</td>
													<td>$pfUSERtime_MS</td>
													<td>$pfUSERtotPAUSE_MS</td>
													<td>$pfUSERtotPAUSE_MS_pct %</td>
													<td>$pfUSERavgPAUSE_MS</td>
													<td>$pfUSERtotWAIT_MS</td>
													<td>$pfUSERtotWAIT_MS_pct %</td>
													<td>$pfUSERavgWAIT_MS</td>
													<td>$pfUSERtotTALK_MS</td>
													<td>$pfUSERtotTALK_MS_pct %</td>
													<td>$pfUSERavgTALK_MS</td>
													<td>$pfUSERtotDISPO_MS</td>
													<td>$pfUSERtotDISPO_MS_pct %</td>
													<td>$pfUSERavgDISPO_MS</td>
													<td>$pfUSERtotDEAD_MS </td>
													<td>$pfUSERtotDEAD_MS_pct %</td>
													<td>$pfUSERavgDEAD_MS</td>
													<td>$pfUSERtotCUSTOMER_MS</td>
													<td>$pfUSERtotCUSTOMER_MS_pct %</td>
													<td>$pfUSERavgCUSTOMER_MS</td>
													$SstatusesHTML ";
                                    $Toutput_sub .= '</tr>';
                                } else {
                                    $Toutput_sub .= '<tr>';
                                    $Toutput_sub .= "<td>$Sfull_name</td>
													<td></td><td></td>
													<td>$Suser_sub</td>
													<td>$Suser_group</td>
													<td>$Slast_user_group</td>
													<td> $Scall_date</td>
													<td>$Scalls</td>
													<td>$pfUSERtime_MS</td>
													<td>$pfUSERtotPAUSE_MS </td>
													<td>$pfUSERavgPAUSE_MS</td>
													<td>$pfUSERtotWAIT_MS</td>
													<td>$pfUSERavgWAIT_MS</td>
													<td>$pfUSERtotTALK_MS</td>
													<td>$pfUSERavgTALK_MS</td>
													<td>$pfUSERtotDISPO_MS</td>
													<td>$pfUSERavgDISPO_MS</td>
													<td>$pfUSERtotDEAD_MS</td>
													<td>$pfUSERavgDEAD_MS</td>
													<td>$pfUSERtotCUSTOMER_MS</td>
													<td> $pfUSERavgCUSTOMER_MS</td>
													$SstatusesHTML";
                                    $Toutput_sub .= '</tr>';
                                }

                                $CSV_lines_sub .= "\"\",";
                                if ($show_percentages) {
                                    $CSV_lines_sub .= preg_replace('/\s/', '', "\"\",\"\",\"\",\"\",\"\",\"$Scall_date\",\"$Scalls\",\"$pfUSERtime_MS\",\"$pfUSERtotPAUSE_MS\",\"$pfUSERtotPAUSE_MS_pct\",\"$pfUSERavgPAUSE_MS\",\"$pfUSERtotWAIT_MS\",\"$pfUSERtotWAIT_MS_pct\",\"$pfUSERavgWAIT_MS\",\"$pfUSERtotTALK_MS\",\"$pfUSERtotTALK_MS_pct\",\"$pfUSERavgTALK_MS\",\"$pfUSERtotDISPO_MS\",\"$pfUSERtotDISPO_MS_pct\",\"$pfUSERavgDISPO_MS\",\"$pfUSERtotDEAD_MS\",\"$pfUSERtotDEAD_MS_pct\",\"$pfUSERavgDEAD_MS\",\"$pfUSERtotCUSTOMER_MS\",\"$pfUSERtotCUSTOMER_MS_pct\",\"$pfUSERavgCUSTOMER_MS\"$CSVstatuses");
                                } else {
                                    $CSV_lines_sub .= preg_replace('/\s/', '', "\"\",\"\",\"\",\"\",\"\",\"$Scall_date\",\"$Scalls\",\"$pfUSERtime_MS\",\"$pfUSERtotPAUSE_MS\",\"$pfUSERavgPAUSE_MS\",\"$pfUSERtotWAIT_MS\",\"$pfUSERavgWAIT_MS\",\"$pfUSERtotTALK_MS\",\"$pfUSERavgTALK_MS\",\"$pfUSERtotDISPO_MS\",\"$pfUSERavgDISPO_MS\",\"$pfUSERtotDEAD_MS\",\"$pfUSERavgDEAD_MS\",\"$pfUSERtotCUSTOMER_MS\",\"$pfUSERavgCUSTOMER_MS\"$CSVstatuses");
                                }
                                $CSV_lines_sub .= "\n";
                            }
                        } // if($date_rslt){
                        if ($show_percentages) {
                            // $Toutput_sub.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+$statusesHEAD\n";
                        } else {
                            // $Toutput_sub.="+-----------------+----------+----------------------+----------------------+".$BBD_header."--------+-----------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+$statusesHEAD\n";
                        }
                    } // if ($breakdown_by_date) {

                    $Slast_user_group = isset($recent_user_groups [$Suser]) ? $recent_user_groups [$Suser] : '';

                    $Sfull_name = $user_namesARY [$m];
                    $Suser_group = $user_groupsARY [$m];
                    $Stime = 0;
                    $Scalls = 0;
                    $Stalk_sec = 0;
                    $Spause_sec = 0;
                    $Swait_sec = 0;
                    $Sdispo_sec = 0;
                    $Sdead_sec = 0;
                    $Scustomer_sec = 0;
                    $SstatusesHTML = '';
                    $CSVstatuses = '';

                    $Stalk_sec_pct = 0;
                    $Spause_sec_pct = 0;
                    $Swait_sec_pct = 0;
                    $Sdispo_sec_pct = 0;
                    $Sdead_sec_pct = 0;

                    // ## BEGIN loop through each status ###
                    $n = 0;
                    $Spause_sec = 0;

                    while ($n < $j) {
                        $Sstatus = $statusesARY [$n];
                        $SstatusTXT = '';
                        $varname = $Sstatus . "_graph";
                        $$varname = $graph_header . "<th class='thgraph' scope='col'>$Sstatus</th></tr>";
                        $max_varname = "max_" . $Sstatus;
                        // ## BEGIN loop through each stat line ###
                        $i = 0;
                        $status_found = 0;

                        while ($i < $rows_to_print) {

                            if ((isset($user [$i]) && $Suser == $user [$i]) && (isset($status [$i]) && $Sstatus == $status [$i])) {
                                $Scalls = ($Scalls + $calls [$i]);
                                $Stalk_sec = ($Stalk_sec + $talk_sec [$i]);
                                $Spause_sec = ($Spause_sec + $pause_sec [$i]);
                                $Swait_sec = ($Swait_sec + $wait_sec [$i]);
                                $Sdispo_sec = ($Sdispo_sec + $dispo_sec [$i]);
                                $Sdead_sec = ($Sdead_sec + $dead_sec [$i]);
                                $Scustomer_sec = ($Scustomer_sec + $customer_sec [$i]);
                                $SstatusTXT = sprintf("%8s", $calls [$i]);
                                $SstatusesHTML .= "<td>$SstatusTXT</td>";

                                if ($calls [$i] > $$max_varname) {
                                    $$max_varname = $calls [$i];
                                }
                                $graph_stats [$m] [(15 + $n)] = ($calls [$i] + 0);

                                $CSVstatuses .= ",\"$calls[$i]\"";

                                if ($show_percentages == 'checked') {
                                    $SstatusTXT_pct = sprintf("%8s", sprintf("%0.2f", MathZDC(100 * $calls [$i], isset($userTOTcalls [$Suser]) ? $userTOTcalls [$Suser] : '')));
                                    $SstatusesHTML .= "<td>$SstatusTXT_pct %</td>";
                                    $CSVstatuses .= ",\"$SstatusTXT_pct %\"";
                                }

                                $status_found ++;
                            }
                            $i ++;
                        }

                        if ($status_found < 1) {
                            $SstatusesHTML .= "<td>        0 </td>";
                            $CSVstatuses .= ",\"0\"";
                            if ($show_percentages) {
                                $SstatusesHTML .= "<td>     0.00 %</td>";
                                $CSVstatuses .= ",\"0.00 %\"";
                            }
                            $graph_stats [$m] [(15 + $n)] = 0;
                        }

                        $n ++;
                    } // while ($n < $j){

                    if (!isset($TOTtime)) {
                        $TOTtime = 0;
                    }
                    if (!isset($TOTtotTALK)) {
                        $TOTtotTALK = 0;
                    }
                    if (!isset($TOTtotWAIT)) {
                        $TOTtotWAIT = 0;
                    }
                    if (!isset($TOTtotPAUSE)) {
                        $TOTtotPAUSE = 0;
                    }
                    if (!isset($TOTtotDISPO)) {
                        $TOTtotDISPO = 0;
                    }
                    if (!isset($TOTtotDEAD)) {
                        $TOTtotDEAD = 0;
                    }
                    if (!isset($TOTtotCUSTOMER)) {
                        $TOTtotCUSTOMER = 0;
                    }
                    $Stime = ($Stalk_sec + $Spause_sec + $Swait_sec + $Sdispo_sec);
                    $TOTcalls = ($TOTcalls + $Scalls);
                    $TOTtime = ($TOTtime + $Stime);
                    $TOTtotTALK = ($TOTtotTALK + $Stalk_sec);
                    $TOTtotWAIT = ($TOTtotWAIT + $Swait_sec);
                    $TOTtotPAUSE = ($TOTtotPAUSE + $Spause_sec);
                    $TOTtotDISPO = ($TOTtotDISPO + $Sdispo_sec);
                    $TOTtotDEAD = ($TOTtotDEAD + $Sdead_sec);
                    $TOTtotCUSTOMER = ($TOTtotCUSTOMER + $Scustomer_sec);
                    $Stime = ($Stalk_sec + $Spause_sec + $Swait_sec + $Sdispo_sec);

                    $Stalk_avg = MathZDC($Stalk_sec, $Scalls);
                    $Spause_avg = MathZDC($Spause_sec, $Scalls);
                    $Swait_avg = MathZDC($Swait_sec, $Scalls);
                    $Sdispo_avg = MathZDC($Sdispo_sec, $Scalls);
                    $Sdead_avg = MathZDC($Sdead_sec, $Scalls);
                    $Scustomer_avg = MathZDC($Scustomer_sec, $Scalls);

                    $RAWuser = $Suser;
                    $RAWcalls = $Scalls;
                    $Scalls = sprintf("%6s", $Scalls);
                    $Sfull_nameRAW = $Sfull_name;
                    $SuserRAW = $Suser;
                    $Scall_date = sprintf("%-10s", " ");
                    $Sfull_name = sprintf("%-45s", $Sfull_name);
                    while (mb_strlen($Sfull_name, 'utf-8') > 15) {
                        $Sfull_name = mb_substr("$Sfull_name", 0, - 1, 'utf-8');
                    }
                    $Suser_group = sprintf("%-60s", $Suser_group);
                    while (mb_strlen($Suser_group, 'utf-8') > 20) {
                        $Suser_group = mb_substr("$Suser_group", 0, - 1, 'utf-8');
                    }
                    $Slast_user_group = sprintf("%-60s", $Slast_user_group);
                    while (mb_strlen($Slast_user_group, 'utf-8') > 20) {
                        $Slast_user_group = mb_substr("$Slast_user_group", 0, - 1, 'utf-8');
                    }
                    $Suser = sprintf("%-24s", $Suser);
                    while (mb_strlen($Suser, 'utf-8') > 8) {
                        $Suser = mb_substr("$Suser", 0, - 1, 'utf-8');
                    }

                    if (trim($Scalls) > $max_calls) {
                        $max_calls = trim($Scalls);
                    }
                    if (trim($Stime) > $max_time) {
                        $max_time = trim($Stime);
                    }
                    if (trim($Spause_sec) > $max_pause) {
                        $max_pause = trim($Spause_sec);
                    }
                    if (trim($Spause_avg) > $max_pauseavg) {
                        $max_pauseavg = trim($Spause_avg);
                    }
                    if (trim($Swait_sec) > $max_wait) {
                        $max_wait = trim($Swait_sec);
                    }
                    if (trim($Swait_avg) > $max_waitavg) {
                        $max_waitavg = trim($Swait_avg);
                    }
                    if (trim($Stalk_sec) > $max_talk) {
                        $max_talk = trim($Stalk_sec);
                    }
                    if (trim($Stalk_avg) > $max_talkavg) {
                        $max_talkavg = trim($Stalk_avg);
                    }
                    if (trim($Sdispo_sec) > $max_dispo) {
                        $max_dispo = trim($Sdispo_sec);
                    }
                    if (trim($Sdispo_avg) > $max_dispoavg) {
                        $max_dispoavg = trim($Sdispo_avg);
                    }
                    if (trim($Sdead_sec) > $max_dead) {
                        $max_dead = trim($Sdead_sec);
                    }
                    if (trim($Sdead_avg) > $max_deadavg) {
                        $max_deadavg = trim($Sdead_avg);
                    }
                    if (trim($Scustomer_sec) > $max_customer) {
                        $max_customer = trim($Scustomer_sec);
                    }
                    if (trim($Scustomer_avg) > $max_customeravg) {
                        $max_customeravg = trim($Scustomer_avg);
                    }
                    $graph_stats [$m] [0] = trim($Sfull_name) . " - " . trim($Suser);
                    $graph_stats [$m] [1] = trim($Scalls);
                    $graph_stats [$m] [2] = trim($Stime);
                    $graph_stats [$m] [3] = trim($Spause_sec);
                    $graph_stats [$m] [4] = trim($Spause_avg);
                    $graph_stats [$m] [5] = trim($Swait_sec);
                    $graph_stats [$m] [6] = trim($Swait_avg);
                    $graph_stats [$m] [7] = trim($Stalk_sec);
                    $graph_stats [$m] [8] = trim($Stalk_avg);
                    $graph_stats [$m] [9] = trim($Sdispo_sec);
                    $graph_stats [$m] [10] = trim($Sdispo_avg);
                    $graph_stats [$m] [11] = trim($Sdead_sec);
                    $graph_stats [$m] [12] = trim($Sdead_avg);
                    $graph_stats [$m] [13] = trim($Scustomer_sec);
                    $graph_stats [$m] [14] = trim($Scustomer_avg);

                    $pfUSERtime_MS = sec_convert($Stime, $TIME_H_agentperfdetail);
                    $pfUSERtotTALK_MS = sec_convert($Stalk_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotTALK_MS_pct = sprintf("%0.2f", MathZDC(100 * $Stalk_sec, $Stime));
                    $pfUSERavgTALK_MS = sec_convert($Stalk_avg, $TIME_M_agentperfdetail);
                    $USERtotPAUSE_MS = sec_convert($Spause_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotPAUSE_MS_pct = sprintf("%0.2f", MathZDC(100 * $Spause_sec, $Stime));
                    $USERavgPAUSE_MS = sec_convert($Spause_avg, $TIME_M_agentperfdetail);
                    $USERtotWAIT_MS = sec_convert($Swait_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotWAIT_MS_pct = sprintf("%0.2f", MathZDC(100 * $Swait_sec, $Stime));
                    $USERavgWAIT_MS = sec_convert($Swait_avg, $TIME_M_agentperfdetail);
                    $USERtotDISPO_MS = sec_convert($Sdispo_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotDISPO_MS_pct = sprintf("%0.2f", MathZDC(100 * $Sdispo_sec, $Stime));
                    $USERavgDISPO_MS = sec_convert($Sdispo_avg, $TIME_M_agentperfdetail);
                    $USERtotDEAD_MS = sec_convert($Sdead_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotDEAD_MS_pct = sprintf("%0.2f", MathZDC(100 * $Sdead_sec, $Stime));
                    $USERavgDEAD_MS = sec_convert($Sdead_avg, $TIME_M_agentperfdetail);
                    $USERtotCUSTOMER_MS = sec_convert($Scustomer_sec, $TIME_H_agentperfdetail);
                    $pfUSERtotCUSTOMER_MS_pct = sprintf("%0.2f", MathZDC(100 * $Scustomer_sec, $Stime));
                    $USERavgCUSTOMER_MS = sec_convert($Scustomer_avg, $TIME_M_agentperfdetail);

                    $pfUSERtime_MS = sprintf("%9s", $pfUSERtime_MS);
                    $pfUSERtotTALK_MS = sprintf("%8s", $pfUSERtotTALK_MS);
                    $pfUSERtotTALK_MS_pct = sprintf("%8s", $pfUSERtotTALK_MS_pct);
                    $pfUSERavgTALK_MS = sprintf("%6s", $pfUSERavgTALK_MS);
                    $pfUSERtotPAUSE_MS = sprintf("%8s", $USERtotPAUSE_MS);
                    $pfUSERtotPAUSE_MS_pct = sprintf("%8s", $pfUSERtotPAUSE_MS_pct);
                    $pfUSERavgPAUSE_MS = sprintf("%6s", $USERavgPAUSE_MS);
                    $pfUSERtotWAIT_MS = sprintf("%8s", $USERtotWAIT_MS);
                    $pfUSERtotWAIT_MS_pct = sprintf("%8s", $pfUSERtotWAIT_MS_pct);
                    $pfUSERavgWAIT_MS = sprintf("%6s", $USERavgWAIT_MS);
                    $pfUSERtotDISPO_MS = sprintf("%8s", $USERtotDISPO_MS);
                    $pfUSERtotDISPO_MS_pct = sprintf("%8s", $pfUSERtotDISPO_MS_pct);
                    $pfUSERavgDISPO_MS = sprintf("%6s", $USERavgDISPO_MS);
                    $pfUSERtotDEAD_MS = sprintf("%8s", $USERtotDEAD_MS);
                    $pfUSERtotDEAD_MS_pct = sprintf("%8s", $pfUSERtotDEAD_MS_pct);
                    $pfUSERavgDEAD_MS = sprintf("%6s", $USERavgDEAD_MS);
                    $pfUSERtotCUSTOMER_MS = sprintf("%8s", $USERtotCUSTOMER_MS);
                    $pfUSERtotCUSTOMER_MS_pct = sprintf("%8s", $pfUSERtotCUSTOMER_MS_pct);
                    $pfUSERavgCUSTOMER_MS = sprintf("%6s", $USERavgCUSTOMER_MS);
                    $PAUSEtotal [$m] = $pfUSERtotPAUSE_MS;
                    $vuser = $this->vusers_m->get_by(array('user' => $Suser), TRUE);
                    $agencyText = '';
                    $agentText = '';
                    $agencyCsv = '';
                    $agentCsv = '';
                    if ($vuser) {
                        $vuserId = $vuser->user_id;
                        $stmt = "SELECT * FROM agents WHERE vicidial_user_id = {$vuserId}";
                        $agent = $this->db->query($stmt)->row_array();
                        if ($agent) {
                            $agencyId = $agent['agency_id'];
                            $agentText = '<a href="' . site_url("admin/manage_agent/agent_info/" . $agent['id']) . '" target="_blank">' . $agent['fname'] . ' ' . $agent['lname'] . '</a>';
                            $agentCsv = $agent['fname'] . ' ' . $agent['lname'];
                            $stmt = "SELECT * FROM agencies WHERE id={$agencyId}";
                            $agency = $this->db->query($stmt)->row_array();
                            if ($agency) {
                                $agencyText = '<a href="' . site_url("admin/manage_agency/agency_info/" . $agency['id']) . '" target="_blank">' . $agency['name'] . '</a>';
                                $agencyCsv = $agency['name'];
                            }
                        }
                    }
                    if ($show_percentages) {
                        $addTest = '';
                        if ($breakdown_by_date == 'checked') {
                            $addTest = '<td></td>';
                        }
                        $Toutput = "<tr>";
                        $Toutput .= "<td>$Sfull_name</td>
									<td>$agencyText</td>
									<td>$agentText</td>
									<td>$Suser</td>
									<td>$Suser_group</td>
									<td>$Slast_user_group</td>
									$addTest
									<td>$Scalls</td>
									<td>$pfUSERtime_MS</td>
									<td>$pfUSERtotPAUSE_MS</td>
									<td>$pfUSERtotPAUSE_MS_pct %</td>
									<td> $pfUSERavgPAUSE_MS</td>
									<td>$pfUSERtotWAIT_MS</td>
									<td>$pfUSERtotWAIT_MS_pct %</td>
									<td>$pfUSERavgWAIT_MS</td>
									<td> $pfUSERtotTALK_MS</td>
									<td>$pfUSERtotTALK_MS_pct %</td>
									<td>$pfUSERavgTALK_MS</td>
									<td>$pfUSERtotDISPO_MS</td>
									<td>$pfUSERtotDISPO_MS_pct %</td>
									<td>$pfUSERavgDISPO_MS</td>
									<td>$pfUSERtotDEAD_MS</td>
									<td>$pfUSERtotDEAD_MS_pct %</td>
									<td>$pfUSERavgDEAD_MS </td>
									<td>$pfUSERtotCUSTOMER_MS</td>
									<td>$pfUSERtotCUSTOMER_MS_pct %</td>
									<td>$pfUSERavgCUSTOMER_MS</td>
									$SstatusesHTML";
                        $Toutput .= "</tr>";
                    } else {
                        $addTest = '';
                        if ($breakdown_by_date == 'checked') {
                            $addTest = '<td></td>';
                        }
                        $Toutput = '<tr>';
                        $Toutput .= "<td>$Sfull_name</td>
									 <td>$agencyText</td>
									 <td>$agentText</td>
									 <td>$Suser</td>
									 <td>$Suser_group</td>
									 <td>$Slast_user_group</td>
									 $addTest
									 <td>$Scalls</td>
									 <td>$pfUSERtime_MS</td>
									 <td>$pfUSERtotPAUSE_MS</td>
									 <td>$pfUSERavgPAUSE_MS</td>
									 <td>$pfUSERtotWAIT_MS</td>
									 <td>$pfUSERavgWAIT_MS</td>
									 <td>$pfUSERtotTALK_MS</td>
									 <td>$pfUSERavgTALK_MS</td>
									 <td>$pfUSERtotDISPO_MS</td>
									 <td>$pfUSERavgDISPO_MS</td>
									 <td>$pfUSERtotDEAD_MS</td>
									 <td>$pfUSERavgDEAD_MS</td>
									 <td>$pfUSERtotCUSTOMER_MS</td>
									 <td>$pfUSERavgCUSTOMER_MS
									 </td>$SstatusesHTML";
                        $Toutput .= '</tr>';
                    }

                    $Toutput .= $Toutput_sub;

                    $CSV_lines .= "\"$Sfull_nameRAW\",\"$agencyCsv\",\"$agentCsv\",";
                    if ($show_percentages) {
                        $CSV_lines .= preg_replace('/\s/', '', "\"$SuserRAW\",\"$Suser_group\",\"$Slast_user_group$BBD_csv_filler\",\"$Scalls\",\"$pfUSERtime_MS\",\"$pfUSERtotPAUSE_MS\",\"$pfUSERtotPAUSE_MS_pct\",\"$pfUSERavgPAUSE_MS\",\"$pfUSERtotWAIT_MS\",\"$pfUSERtotWAIT_MS_pct\",\"$pfUSERavgWAIT_MS\",\"$pfUSERtotTALK_MS\",\"$pfUSERtotTALK_MS_pct\",\"$pfUSERavgTALK_MS\",\"$pfUSERtotDISPO_MS\",\"$pfUSERtotDISPO_MS_pct\",\"$pfUSERavgDISPO_MS\",\"$pfUSERtotDEAD_MS\",\"$pfUSERtotDEAD_MS_pct\",\"$pfUSERavgDEAD_MS\",\"$pfUSERtotCUSTOMER_MS\",\"$pfUSERtotCUSTOMER_MS_pct\",\"$pfUSERavgCUSTOMER_MS\"$CSVstatuses");
                    } else {
                        $CSV_lines .= preg_replace('/\s/', '', "\"$SuserRAW\",\"$Suser_group\",\"$Slast_user_group$BBD_csv_filler\",\"$Scalls\",\"$pfUSERtime_MS\",\"$pfUSERtotPAUSE_MS\",\"$pfUSERavgPAUSE_MS\",\"$pfUSERtotWAIT_MS\",\"$pfUSERavgWAIT_MS\",\"$pfUSERtotTALK_MS\",\"$pfUSERavgTALK_MS\",\"$pfUSERtotDISPO_MS\",\"$pfUSERavgDISPO_MS\",\"$pfUSERtotDEAD_MS\",\"$pfUSERavgDEAD_MS\",\"$pfUSERtotCUSTOMER_MS\",\"$pfUSERavgCUSTOMER_MS\"$CSVstatuses");
                    }
                    $CSV_lines .= "\n";
                    // $CSV_lines.= $CSV_lines_sub;

                    $TOPsorted_output [$m] = $Toutput;

                    if ($stage == 'ID') {
                        $TOPsort [$m] = '' . sprintf("%08s", $RAWuser) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                    }
                    if ($stage == 'LEADS') {
                        $TOPsort [$m] = '' . sprintf("%08s", $RAWcalls) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                    }
                    if ($stage == 'TIME') {
                        $TOPsort [$m] = '' . sprintf("%08s", $Stime) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                    }
                    if (!preg_match('/ID|TIME|LEADS/', $stage)) {
                        $ASCII_text .= "$Toutput";
                    }
                    $m ++;
                } // $while($m < $k){
                // ## END loop through each user ###
                // ## BEGIN sort through output to display properly ###
                if (preg_match('/ID|TIME|LEADS/', $stage)) {
                    if (preg_match('/ID/', $stage)) {
                        sort($TOPsort, SORT_NUMERIC);
                    }
                    if (preg_match('/TIME|LEADS/', $stage)) {
                        rsort($TOPsort, SORT_NUMERIC);
                    }

                    $m = 0;
                    while ($m < $k) {
                        $sort_split = explode("-----", $TOPsort [$m]);
                        $i = $sort_split [1];
                        $sort_order [$m] = "$i";
                        $ASCII_text .= "$TOPsorted_output[$i]";
                        $m ++;
                    }
                } // if (preg_match('/ID|TIME|LEADS/',$stage)){
                // ## END sort through output to display properly ###
                // ##### LAST LINE FORMATTING ##########
                // ## BEGIN loop through each status ###
                $SUMstatusesHTML = '';
                $CSVSUMstatuses = '';
                $n = 0;
                while ($n < $j) {
                    $Scalls = 0;
                    $Sstatus = $statusesARY [$n];
                    $SUMstatusTXT = '';
                    $total_var = $Sstatus . "_total";
                    // ## BEGIN loop through each stat line ###
                    $i = 0;
                    $status_found = 0;
                    while ($i < $rows_to_print) {
                        if (isset($status [$i]) && $Sstatus == $status [$i]) {
                            $Scalls = ($Scalls + $calls [$i]);
                            $status_found ++;
                        }
                        $i ++;
                    }
                    // ## END loop through each stat line ###
                    if ($status_found < 1) {
                        $SUMstatusesHTML .= "<td>        0</td>";
                        if ($show_percentages) {
                            $SUMstatusesHTML .= "<td>     0.00%</td>";
                            $CSVSUMstatuses .= ",\"0.00 %\"";
                        }
                        $$total_var = 0;
                    } else {
                        $SUMstatusTXT = sprintf("%8s", $Scalls);
                        $SUMstatusesHTML .= "<td>$SUMstatusTXT</td>";
                        $CSVSUMstatuses .= ",\"$Scalls\"";
                        if ($show_percentages) {
                            $SstatusTXT_pct = sprintf("%8s", sprintf("%0.2f", MathZDC(100 * $Scalls, $TOTcalls)));
                            $SUMstatusesHTML .= "<td>$SstatusTXT_pct%</td>";
                            $CSVSUMstatuses .= ",\"$SstatusTXT_pct %\"";
                        }
                        $$total_var = $Scalls;
                    }
                    $n ++;
                } // while ($n < $j){
                // ## END loop through each status ###
                $TOTcalls = sprintf("%7s", isset($TOTcalls) ? $TOTcalls : 0);
                $TOT_AGENTS = sprintf("%-4s", $m);
                if (!isset($TOTtotTALK)) {
                    $TOTtotTALK = 0;
                }
                $TOTavgTALK = MathZDC($TOTtotTALK, $TOTcalls);
                if (!isset($TOTtotDISPO)) {
                    $TOTtotDISPO = 0;
                }
                $TOTavgDISPO = MathZDC($TOTtotDISPO, $TOTcalls);
                if (!isset($TOTtotDEAD)) {
                    $TOTtotDEAD = 0;
                }
                $TOTavgDEAD = MathZDC($TOTtotDEAD, $TOTcalls);
                if (!isset($TOTtotPAUSE)) {
                    $TOTtotPAUSE = 0;
                }
                $TOTavgPAUSE = MathZDC($TOTtotPAUSE, $TOTcalls);
                if (!isset($TOTtotWAIT)) {
                    $TOTtotWAIT = 0;
                }
                $TOTavgWAIT = MathZDC($TOTtotWAIT, $TOTcalls);
                if (!isset($TOTtotCUSTOMER)) {
                    $TOTtotCUSTOMER = 0;
                }
                $TOTavgCUSTOMER = MathZDC($TOTtotCUSTOMER, $TOTcalls);

                if (!isset($TOTtime)) {
                    $TOTtime = 0;
                }
                $TOTtime_MS = sec_convert($TOTtime, $TIME_H_agentperfdetail);
                if (!isset($TOTtime)) {
                    $TOTtime = 0;
                }
                $TOTtotTALK_MS = sec_convert($TOTtotTALK, $TIME_H_agentperfdetail);
                $TOTtotDISPO_MS = sec_convert($TOTtotDISPO, $TIME_H_agentperfdetail);
                $TOTtotDEAD_MS = sec_convert($TOTtotDEAD, $TIME_H_agentperfdetail);
                $TOTtotPAUSE_MS = sec_convert($TOTtotPAUSE, $TIME_H_agentperfdetail);
                $TOTtotWAIT_MS = sec_convert($TOTtotWAIT, $TIME_H_agentperfdetail);
                $TOTtotCUSTOMER_MS = sec_convert($TOTtotCUSTOMER, $TIME_H_agentperfdetail);
                $TOTtotTALK_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotTALK, $TOTtime));
                $TOTtotDISPO_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotDISPO, $TOTtime));
                $TOTtotDEAD_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotDEAD, $TOTtime));
                $TOTtotPAUSE_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotPAUSE, $TOTtime));
                $TOTtotWAIT_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotWAIT, $TOTtime));
                $TOTtotCUSTOMER_MS_pct = sprintf("%0.2f", MathZDC(100 * $TOTtotCUSTOMER, $TOTtime));
                $TOTavgTALK_MS = sec_convert($TOTavgTALK, $TIME_M_agentperfdetail);
                $TOTavgDISPO_MS = sec_convert($TOTavgDISPO, $TIME_H_agentperfdetail);
                $TOTavgDEAD_MS = sec_convert($TOTavgDEAD, $TIME_H_agentperfdetail);
                $TOTavgPAUSE_MS = sec_convert($TOTavgPAUSE, $TIME_H_agentperfdetail);
                $TOTavgWAIT_MS = sec_convert($TOTavgWAIT, $TIME_H_agentperfdetail);
                $TOTavgCUSTOMER_MS = sec_convert($TOTavgCUSTOMER, $TIME_H_agentperfdetail);

                $TOTtime_MS = sprintf("%10s", $TOTtime_MS);
                $TOTtotTALK_MS = sprintf("%10s", $TOTtotTALK_MS);
                $TOTtotDISPO_MS = sprintf("%10s", $TOTtotDISPO_MS);
                $TOTtotDEAD_MS = sprintf("%10s", $TOTtotDEAD_MS);
                $TOTtotPAUSE_MS = sprintf("%10s", $TOTtotPAUSE_MS);
                $TOTtotWAIT_MS = sprintf("%10s", $TOTtotWAIT_MS);
                $TOTtotCUSTOMER_MS = sprintf("%10s", $TOTtotCUSTOMER_MS);
                $TOTtotTALK_MS_pct = sprintf("%8s", $TOTtotTALK_MS_pct);
                $TOTtotDISPO_MS_pct = sprintf("%8s", $TOTtotDISPO_MS_pct);
                $TOTtotDEAD_MS_pct = sprintf("%8s", $TOTtotDEAD_MS_pct);
                $TOTtotPAUSE_MS_pct = sprintf("%8s", $TOTtotPAUSE_MS_pct);
                $TOTtotWAIT_MS_pct = sprintf("%8s", $TOTtotWAIT_MS_pct);
                $TOTtotCUSTOMER_MS_pct = sprintf("%8s", $TOTtotCUSTOMER_MS_pct);
                $TOTavgTALK_MS = sprintf("%6s", $TOTavgTALK_MS);
                $TOTavgDISPO_MS = sprintf("%6s", $TOTavgDISPO_MS);
                $TOTavgDEAD_MS = sprintf("%6s", $TOTavgDEAD_MS);
                $TOTavgPAUSE_MS = sprintf("%6s", $TOTavgPAUSE_MS);
                $TOTavgWAIT_MS = sprintf("%6s", $TOTavgWAIT_MS);
                $TOTavgCUSTOMER_MS = sprintf("%6s", $TOTavgCUSTOMER_MS);

                if ($file_download == 0 || !$file_download) {
                    while (strlen($TOTtime_MS) > 10) {
                        $TOTtime_MS = substr("$TOTtime_MS", 0, - 1);
                    }
                    while (strlen($TOTtotTALK_MS) > 10) {
                        $TOTtotTALK_MS = substr("$TOTtotTALK_MS", 0, - 1);
                    }
                    while (strlen($TOTtotDISPO_MS) > 10) {
                        $TOTtotDISPO_MS = substr("$TOTtotDISPO_MS", 0, - 1);
                    }
                    while (strlen($TOTtotDEAD_MS) > 10) {
                        $TOTtotDEAD_MS = substr("$TOTtotDEAD_MS", 0, - 1);
                    }
                    while (strlen($TOTtotPAUSE_MS) > 10) {
                        $TOTtotPAUSE_MS = substr("$TOTtotPAUSE_MS", 0, - 1);
                    }
                    while (strlen($TOTtotWAIT_MS) > 10) {
                        $TOTtotWAIT_MS = substr("$TOTtotWAIT_MS", 0, - 1);
                    }
                    while (strlen($TOTtotCUSTOMER_MS) > 10) {
                        $TOTtotCUSTOMER_MS = substr("$TOTtotCUSTOMER_MS", 0, - 1);
                    }
                    while (strlen($TOTavgTALK_MS) > 6) {
                        $TOTavgTALK_MS = substr("$TOTavgTALK_MS", 0, - 1);
                    }
                    while (strlen($TOTavgDISPO_MS) > 6) {
                        $TOTavgDISPO_MS = substr("$TOTavgDISPO_MS", 0, - 1);
                    }
                    while (strlen($TOTavgDEAD_MS) > 6) {
                        $TOTavgDEAD_MS = substr("$TOTavgDEAD_MS", 0, - 1);
                    }
                    while (strlen($TOTavgPAUSE_MS) > 6) {
                        $TOTavgPAUSE_MS = substr("$TOTavgPAUSE_MS", 0, - 1);
                    }
                    while (strlen($TOTavgWAIT_MS) > 6) {
                        $TOTavgWAIT_MS = substr("$TOTavgWAIT_MS", 0, - 1);
                    }
                    while (strlen($TOTavgCUSTOMER_MS) > 6) {
                        $TOTavgCUSTOMER_MS = substr("$TOTavgCUSTOMER_MS", 0, - 1);
                    }
                }
                $ASCII_text .= '<tfoot>';
                if ($show_percentages) {
                    $addText = '';
                    $colspan = 5;
                    if ($breakdown_by_date == 'checked') { // Prevent additional line from being printed - has to be here, won't work above in if-breakdown-by-date loop when results are sorted
                        // $ASCII_text.="+-----------------+----------+----------------------+----------------------+" . $BBD_header . "--------+-----------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+$statusesHEAD\n";
                        //$addText = '<td></td>';
                        $colspan = 6;
                    }
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<td colspan='$colspan'>   " . _QXZ("TOTALS", 33) . "</td>
									<td>  " . _QXZ("AGENTS", 32, "r") . ":$TOT_AGENTS </td>
									<td>$TOTcalls</td>
									<td>$TOTtime_MS</td>
									<td>$TOTtotPAUSE_MS</td>
									<td>$TOTtotPAUSE_MS_pct%</td>
									<td>$TOTavgPAUSE_MS </td>
									<td>$TOTtotWAIT_MS</td>
									<td>$TOTtotWAIT_MS_pct%</td>
									<td>$TOTavgWAIT_MS</td>
									<td>$TOTtotTALK_MS</td>
									<td>$TOTtotTALK_MS_pct%</td>
									<td>$TOTavgTALK_MS</td>
									<td>$TOTtotDISPO_MS</td>
									<td>$TOTtotDISPO_MS_pct%</td>
									<td>$TOTavgDISPO_MS</td>
									<td>$TOTtotDEAD_MS</td>
									<td>$TOTtotDEAD_MS_pct%</td>
									<td>$TOTavgDEAD_MS</td>
									<td>$TOTtotCUSTOMER_MS</td>
									<td>$TOTtotCUSTOMER_MS_pct%</td>
									<td>$TOTavgCUSTOMER_MS</td>
									$SUMstatusesHTML";
                    // $ASCII_text.="+-----------------+----------+----------------------+----------------------+" . $BBD_header . "--------+-----------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+----------+------------+--------+$statusesHEAD\n";
                    $ASCII_text .= '</tr>';
                } else {
                    $addText = '';
                    $colspan = 5;
                    if ($breakdown_by_date == 'checked') {  // Prevent additional line from being printed - has to be here, won't work above in if-breakdown-by-date loop when results are sorted
                        // $ASCII_text.="+-----------------+----------+----------------------+----------------------+" . $BBD_header . "--------+-----------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+$statusesHEAD\n";
                        $colspan = 6;
                    }

                    $ASCII_text .= '<tr>';

                    $ASCII_text .= "<td colspan='$colspan'>" . _QXZ("TOTALS", 33) . "</td><td>" . _QXZ("AGENTS", 32, "r") . ": $TOT_AGENTS</td>$addText<td> $TOTcalls</td><td>$TOTtime_MS</td><td>$TOTtotPAUSE_MS<td>$TOTavgPAUSE_MS</td><td>$TOTtotWAIT_MS</td><td>$TOTavgWAIT_MS</td><td>$TOTtotTALK_MS</td><td>$TOTavgTALK_MS</td><td>$TOTtotDISPO_MS</td><td>$TOTavgDISPO_MS</td><td>$TOTtotDEAD_MS</td><td> $TOTavgDEAD_MS</td><td>$TOTtotCUSTOMER_MS</td><td>$TOTavgCUSTOMER_MS</td>$SUMstatusesHTML";
                    // $ASCII_text.="+-----------------+----------+----------------------+----------------------+" . $BBD_header . "--------+-----------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+----------+--------+$statusesHEAD\n";
                    $ASCII_text .= '</tr>';
                }
                $ASCII_text .= '</tfoot>';
                $ASCII_text .= "</table></div>";
                for ($e = 0; $e < count($statusesARY); $e ++) {
                    $Sstatus = $statusesARY [$e];
                    $SstatusTXT = $Sstatus;
                    if ($Sstatus == "") {
                        $SstatusTXT = "(blank)";
                    }
                    $GRAPH2 .= "<th class='column_header grey_graph_cell' id='callstatsgraph" . ($e + 15) . "'><a href='#' class='btn btn-link' onClick=\"DrawGraph('$Sstatus', '" . ($e + 15) . "'); return false;\">$SstatusTXT</a></th>";
                }
                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $CALLS_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [1], $max_calls)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [1] . "</td></tr>";
                    $TIME_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [2], $max_time)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [2], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $PAUSE_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [3], $max_pause)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [3], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $PAUSEAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [4], $max_pauseavg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [4], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $WAIT_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [5], $max_wait)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [5], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $WAITAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [6], $max_waitavg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [6], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $TALK_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [7], $max_talk)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [7], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $TALKAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [8], $max_talkavg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [8], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $DISPO_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [9], $max_dispo)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [9], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $DISPOAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [10], $max_dispoavg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [10], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $DEAD_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [11], $max_dead)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [11], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $DEADAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [12], $max_deadavg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [12], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $CUST_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [13], $max_customer)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [13], $TIME_HF_agentperfdetail) . "</td></tr>";
                    $CUSTAVG_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [14], $max_customeravg)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [14], $TIME_HF_agentperfdetail) . "</td></tr>";

                    for ($e = 0; $e < count($statusesARY); $e ++) {
                        $Sstatus = $statusesARY [$e];
                        $varname = $Sstatus . "_graph";
                        $max_varname = "max_" . $Sstatus;
                        // $max.= "<!-- $max_varname => ".$$max_varname." //-->\n";

                        $$varname .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [($e + 15)], $$max_varname)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . $graph_stats [$d] [($e + 15)] . "</td></tr>";
                    }
                }
                $CALLS_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTcalls) . "</th></tr></table>";
                $TIME_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtime_MS) . "</th></tr></table>";
                $PAUSE_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotPAUSE_MS) . "</th></tr></table>";
                $PAUSEAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgPAUSE_MS) . "</th></tr></table>";
                $WAIT_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotWAIT_MS) . "</th></tr></table>";
                $WAITAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgWAIT_MS) . "</th></tr></table>";
                $TALK_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotTALK_MS) . "</th></tr></table>";
                $TALKAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgTALK_MS) . "</th></tr></table>";
                $DISPO_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotDISPO_MS) . "</th></tr></table>";
                $DISPOAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgDISPO_MS) . "</th></tr></table>";
                $DEAD_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotDEAD_MS) . "</th></tr></table>";
                $DEADAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgDEAD_MS) . "</th></tr></table>";
                $CUST_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotCUSTOMER_MS) . "</th></tr></table>";
                $CUSTAVG_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($TOTavgCUSTOMER_MS) . "</th></tr></table>";

                for ($e = 0; $e < count($statusesARY); $e++) {
                    $Sstatus = $statusesARY[$e];
                    $total_var = $Sstatus . "_total";
                    if (!isset($$total_var)) {
                        $$total_var = '';
                    }
                    $graph_var = $Sstatus . "_graph";
                    if (!isset($$graph_var)) {
                        $$graph_var = '';
                    }
                    $$graph_var .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim($$total_var) . "</th></tr></table>";
                }

                $JS_text .= "<script type='text/javascript'>";
                $JS_text .= "DrawGraph('CALLS', '1');";
                $JS_text .= "function DrawGraph(graph, th_id) {";
                $JS_text .= "	var graph_CALLS=\"$CALLS_graph\";\n";
                $JS_text .= "	var graph_TIME=\"$TIME_graph\";\n";
                $JS_text .= "	var graph_PAUSE=\"$PAUSE_graph\";\n";
                $JS_text .= "	var graph_PAUSEAVG=\"$PAUSEAVG_graph\";\n";
                $JS_text .= "	var graph_WAIT=\"$WAIT_graph\";\n";
                $JS_text .= "	var graph_WAITAVG=\"$WAITAVG_graph\";\n";
                $JS_text .= "	var graph_TALK=\"$TALK_graph\";\n";
                $JS_text .= "	var graph_TALKAVG=\"$TALKAVG_graph\";\n";
                $JS_text .= "	var graph_DISPO=\"$DISPO_graph\";\n";
                $JS_text .= "	var graph_DISPOAVG=\"$DISPOAVG_graph\";\n";
                $JS_text .= "	var graph_DEAD=\"$DEAD_graph\";\n";
                $JS_text .= "	var graph_DEADAVG=\"$DEADAVG_graph\";\n";
                $JS_text .= "	var graph_CUST=\"$CUST_graph\";\n";
                $JS_text .= "	var graph_CUSTAVG=\"$CUSTAVG_graph\";\n";


                for ($e = 0; $e < count($statusesARY); $e ++) {
                    $Sstatus = $statusesARY [$e];
                    $graph_var = $Sstatus . "_graph";
                    $JS_text .= "	var graph_" . $Sstatus . "=\"" . $$graph_var . "\";\n";
                }

                $JS_text .= "	for (var i=1; i<=" . (count($statusesARY) + 14) . "; i++) {\n";
                $JS_text .= "		var cellID=\"callstatsgraph\"+i;\n";
                $JS_text .= "		document.getElementById(cellID).style.backgroundColor='#DDDDDD';\n";
                $JS_text .= "	}\n";
                $JS_text .= "	var cellID=\"callstatsgraph\"+th_id;\n";
                $JS_text .= "	document.getElementById(cellID).style.backgroundColor='#999999';\n";
                $JS_text .= "	var graph_to_display=eval(\"graph_\"+graph);\n";
                $JS_text .= "	document.getElementById('call_stats_graph').innerHTML=graph_to_display;\n";
                $JS_text .= "}\n";
                $JS_text .= "</script>\n";

                $GRAPH3 = "<tr><td colspan='" . (14 + count($statusesARY)) . "' class='graph_span_cell'><span id='call_stats_graph'><BR>&nbsp;<BR></span></td></tr></table></div>";

                $GRAPH_text .= $GRAPH . $GRAPH2 . $GRAPH3 . $JS_text;

                if ($show_percentages) {
                    $CSV_total = preg_replace('/\s/', '', "\"\",\"\",\"\",\"\",\"" . _QXZ("TOTALS") . "\",\"" . _QXZ("AGENTS") . ":$TOT_AGENTS\",\"$TOTcalls\",\"$TOTtime_MS\",\"$TOTtotPAUSE_MS\",\"$TOTtotPAUSE_MS_pct %\",\"$TOTavgPAUSE_MS\",\"$TOTtotWAIT_MS\",\"$TOTtotWAIT_MS_pct %\",\"$TOTavgWAIT_MS\",\"$TOTtotTALK_MS\",\"$TOTtotTALK_MS_pct %\",\"$TOTavgTALK_MS\",\"$TOTtotDISPO_MS\",\"$TOTtotDISPO_MS_pct %\",\"$TOTavgDISPO_MS\",\"$TOTtotDEAD_MS\",\"$TOTtotDEAD_MS_pct %\",\"$TOTavgDEAD_MS\",\"$TOTtotCUSTOMER_MS\",\"$TOTtotCUSTOMER_MS_pct %\",\"$TOTavgCUSTOMER_MS\"$CSVSUMstatuses\n\n");
                } else {
                    $CSV_total = preg_replace('/\s/', '', "\"\",\"\",\"\",\"\",\"" . _QXZ("TOTALS") . "\",\"" . _QXZ("AGENTS") . ":$TOT_AGENTS\",\"$TOTcalls\",\"$TOTtime_MS\",\"$TOTtotPAUSE_MS\",\"$TOTavgPAUSE_MS\",\"$TOTtotWAIT_MS\",\"$TOTavgWAIT_MS\",\"$TOTtotTALK_MS\",\"$TOTavgTALK_MS\",\"$TOTtotDISPO_MS\",\"$TOTavgDISPO_MS\",\"$TOTtotDEAD_MS\",\"$TOTavgDEAD_MS\",\"$TOTtotCUSTOMER_MS\",\"$TOTavgCUSTOMER_MS\"$CSVSUMstatuses\n\n");
                }
                if ($file_download == 1) {
                    $FILE_TIME = date("Ymd-His");
                    $CSVfilename = "AGENT_PERFORMACE_DETAIL$US$FILE_TIME.csv";

                    // We'll be outputting a TXT file
                    header('Content-type: application/octet-stream');

                    // It will be called LIST_101_20090209-121212.txt
                    header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    ob_clean();
                    flush();
                    echo "$CSV_header$CSV_lines$CSV_total";
                    // $endMS = microtime ();
                    // $startMSary = explode ( " ", $startMS );
                    // $endMSary = explode ( " ", $endMS );
                    // $runS = ($endMSary [0] - $startMSary [0]);
                    // $runM = ($endMSary [1] - $startMSary [1]);
                    // $TOTALrun = ($runS + $runM);
                    exit();
                }

                if ($file_download == 2) {
                    $TIME_HF_agentperfdetail = 'HF';
                    $TIME_H_agentperfdetail = 'HF';
                    $TIME_M_agentperfdetail = 'HF';
                }
                if ($time_in_sec) {
                    $TIME_HF_agentperfdetail = 'S';
                    $TIME_H_agentperfdetail = 'S';
                    $TIME_M_agentperfdetail = 'S';
                }
                $sub_statuses = '-';
                $sub_statusesTXT = '';
                $sub_statusesHEAD = '';
                $sub_statusesHTML = '';
                $CSV_statuses = '';
                $sub_statusesARY = $MT;
                $j = 0;
                $PCusers = '-';
                $PCusersARY = $MT;
                $PCuser_namesARY = $MT;
                $k = 0;

                $graph_stats = array();
                $max_total = 1;
                $max_nonpause = 1;
                $max_pause = 1;

                $GRAPH = "<br/><br/><div class='table-responsive'><table class='table table-bordered'>";
                $GRAPH2 = "<tr>
                            <th class='column_header grey_graph_cell' id='pausegraph1'><a style='display:block;' class='btn btn-link text-center' href='#' onClick=\"DrawPauseGraph('TOTAL', '1'); return false;\">" . _QXZ("TOTAL") . "</a>
                            </th>
                            <th class='column_header grey_graph_cell' id='pausegraph2'><a style='display:block;' class='btn btn-link text-center' href='#' onClick=\"DrawPauseGraph('NONPAUSE', '2'); return false;\">" . _QXZ("NONPAUSE") . "</a>
                            </th>
                            <th class='column_header grey_graph_cell' id='pausegraph3'><a style='display:block;' class='btn btn-link text-center' href='#' onClick=\"DrawPauseGraph('PAUSE', '3'); return false;\">" . _QXZ("PAUSE") . "</a>
                            </th>";
                $graph_header = "<table class='table table-bordered'><caption class='bold text-center'>" . _QXZ("PAUSE CODE BREAKDOWN") . "</caption><tr><th class='thgraph' scope='col'>" . _QXZ("STATUS") . "</th>";
                $TOTAL_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("TOTAL") . " </th></tr>";
                $NONPAUSE_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("NONPAUSE") . "</th></tr>";
                $PAUSE_graph = $graph_header . "<th class='thgraph' scope='col'>" . _QXZ("PAUSE") . "</th></tr>";

                $sub_status_stmt = "SELECT distinct if(sub_status is null, '*', sub_status) as all_subs from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' and pause_sec >= 0 and pause_sec < 65000 $group_SQL $user_agent_log_SQL order by all_subs asc limit 10000000;";
                $query = $this->vicidialdb->db->query($sub_status_stmt);
                $sub_status_rslt = $query->result_array();
                $subs_to_print = 0;
                $q = 0;
                $count = 0;
                while ($count < $query->num_rows()) {
                    $ss_row = array_values($sub_status_rslt [$count]);
                    $current_ss = $ss_row [0];
                    // FOR NULL SUB STATUSES
                    if ($current_ss == "*") {
                        $sub_status_clause = "and sub_status is null";
                    } else {
                        $sub_status_clause = "and sub_status='$current_ss'";
                    }
                    if ($show_defunct_users == "checked") {
                        $stmt = "SELECT '' as full_name,user,sum(pause_sec),sub_status,sum(wait_sec + talk_sec + dispo_sec), '' as user_group from " . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' $sub_status_clause and pause_sec<65000 $group_SQL $user_group_agent_log_SQL $user_SQL group by user,full_name,sub_status order by user,full_name,sub_status desc limit 100000;";
                    } else {
                        $stmt = "SELECT full_name,vicidial_users.user,sum(pause_sec),sub_status,sum(wait_sec + talk_sec + dispo_sec), vicidial_users.user_group from vicidial_users," . $agent_log_table . " where event_time <= '$query_date_END' and event_time >= '$query_date_BEGIN' $sub_status_clause and vicidial_users.user=" . $agent_log_table . ".user and pause_sec<65000 $group_SQL $user_group_SQL $user_SQL group by user,full_name,sub_status order by user,full_name,sub_status desc limit 100000;";
                    }
                    $queryin = $this->vicidialdb->db->query($stmt);
                    $sub_subs_to_print = $queryin->num_rows();
                    $subs_to_print += $sub_subs_to_print;
                    $result = $queryin->result_array();
                    $i = 0;
                    while ($i < $sub_subs_to_print) {
                        $row = array_values($result [$i]);
                        if ($show_defunct_users == "checked") {
                            $defunct_user_stmt = "SELECT full_name,user_group from vicidial_users where user='$row[1]'";
                            $defunct_user_rslt = $this->vicidialdb->db->query($defunct_user_stmt);
                            if ($defunct_user_rslt->num_rows() > 0) {

                                $defunct_user_row = array_values($defunct_user_rslt->row_array());
                                $PCfull_name_val = $defunct_user_row [0];
                                $PCuser_group_val = $defunct_user_row [1];
                            } else {
                                $PCfull_name_val = $row [1];
                                $PCuser_group_val = "**NONE**";
                            }
                        } else {
                            $PCfull_name_val = $row [0];
                            $PCuser_group_val = $row [5];
                        }
                        $PCfull_name [$q] = $PCfull_name_val;
                        $PCuser [$q] = $row [1];
                        $PCpause_sec [$q] = $row [2];
                        $sub_status [$q] = $row [3];
                        $PCnon_pause_sec [$q] = $row [4];
                        $PCuser_group [$q] = $PCuser_group_val;
                        $max_varname = "max_" . $sub_status [$q];
                        $$max_varname = 1;
                        if (!preg_match("/\-$sub_status[$q]\-/i", $sub_statuses)) {
                            $sub_statusesTXT = sprintf("%8s", $sub_status [$q]);
                            $sub_statusesHEAD .= "----------+";
                            $sub_statusesHTML .= "<th>$sub_statusesTXT</th>";
                            $sub_statuses .= "$sub_status[$q]-";
                            $sub_statusesARY [$j] = $sub_status [$q];
                            $CSV_statuses .= ",\"$sub_status[$q]\"";
                            $j ++;
                        }
                        if (!preg_match("/\-$PCuser[$q]\-/i", $PCusers)) {
                            $PCusers .= "$PCuser[$q]-";
                            $PCusersARY [$k] = $PCuser [$q];
                            $PCuser_namesARY [$k] = $PCfull_name [$q];
                            $PCuser_groupsARY [$k] = $PCuser_group [$q];
                            $k ++;
                        }
                        $i ++;
                        $q ++;
                    }
                    $count++;
                } // while($q < $query->num_rows()){

                $ASCII_text .= "<div class='table-responsive'>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= '<caption class="bold text-center">' . _QXZ("PAUSE CODE BREAKDOWN", 20) . ":     <a href=\"javascript:checkDownload(2)\">[" . _QXZ("DOWNLOAD") . "]</a></caption>";
                // $ASCII_text.="+-----------------+----------+----------------------+----------------------+------------+----------+----------+ +$sub_statusesHEAD\n";
                $ASCII_text .= "<th>" . _QXZ("USER NAME", 15) . "</th><th>" . _QXZ("ID", 8) . "</th><th>" . _QXZ("CURRENT USER GROUP", 20) . "</th><th>" . _QXZ("MOST RECENT USER GRP", 20) . "</th><th>Agency</th><th>Agent</th><th>" . _QXZ("LOGIN TIME", 10) . "</th><th>" . _QXZ("NONPAUSE", 8) . "</th><th>" . _QXZ("PAUSE", 8) . "</th>$sub_statusesHTML";
                // $ASCII_text.="+-----------------+----------+----------------------+----------------------+------------+----------+----------+ +$sub_statusesHEAD\n";

                $CSV_header = "\"" . _QXZ("Agent Performance Detail", 47) . " $NOW_TIME\"\n";
                $CSV_header .= "\"" . _QXZ("Time range") . ": $query_date_BEGIN " . _QXZ("to") . " $query_date_END\"\n\n";
                $CSV_header .= "\"" . _QXZ("PAUSE CODE BREAKDOWN") . ":\"\n";
                $CSV_header .= "\"" . _QXZ("USER NAME") . "\",\"" . _QXZ("ID") . "\",\"" . _QXZ("CURRENT USER GROUP") . "\",\"" . _QXZ("MOST RECENT USER GROUP") . "\",\"" . _QXZ("AGENCY") . "\",\"" . _QXZ("AGENT") . "\",\"" . _QXZ("TOTAL") . "\",\"" . _QXZ("NONPAUSE") . "\",\"" . _QXZ("PAUSE") . "\",$CSV_statuses\n";

                // ## BEGIN loop through each user ###

                $m = 0;
                $Suser_ct = count($usersARY);
                $TOTtotNONPAUSE = 0;
                $TOTtotTOTAL = 0;
                $CSV_lines = "";

                while ($m < $k) {
                    $d = 0;
                    while ($d < $Suser_ct) {
                        if ($usersARY [$d] === "$PCusersARY[$m]") {
                            $pcPAUSEtotal = $PAUSEtotal [$d];
                        }
                        $d ++;
                    }
                    $Suser = $PCusersARY [$m];
                    $Sfull_name = $PCuser_namesARY [$m];
                    $Suser_group = $PCuser_groupsARY [$m];
                    $Slast_user_group = $recent_user_groups [$Suser];
                    $Spause_sec = 0;
                    $Snon_pause_sec = 0;
                    $Stotal_sec = 0;
                    $SstatusesHTML = '';
                    $CSV_statuses = "";
                    // ## BEGIN loop through each status ###
                    $n = 0;
                    while ($n < $j) {
                        $Sstatus = $sub_statusesARY [$n];
                        $SstatusTXT = '';
                        $varname = $Sstatus . "_graph";
                        $$varname = $graph_header . "<th class='thgraph' scope='col'>$Sstatus</th></tr>";
                        $max_varname = "max_" . $Sstatus;
                        // ## BEGIN loop through each stat line ###
                        $i = 0;
                        $status_found = 0;
                        while ($i < $subs_to_print) {
                            if (($Suser == "$PCuser[$i]") and ( $Sstatus == "$sub_status[$i]")) {
                                $Spause_sec = ($Spause_sec + $PCpause_sec [$i]);
                                $Snon_pause_sec = ($Snon_pause_sec + $PCnon_pause_sec [$i]);
                                $Stotal_sec = ($Stotal_sec + $PCnon_pause_sec [$i] + $PCpause_sec [$i]);

                                $USERcodePAUSE_MS = sec_convert($PCpause_sec [$i], $TIME_H_agentperfdetail);
                                $pfUSERcodePAUSE_MS = sprintf("%6s", $USERcodePAUSE_MS);

                                $SstatusTXT = sprintf("%8s", $pfUSERcodePAUSE_MS);
                                $SstatusesHTML .= "<td>$SstatusTXT</td>";

                                if ($PCpause_sec [$i] > $$max_varname) {
                                    $$max_varname = $PCpause_sec [$i];
                                }
                                $graph_stats [$m] [(4 + $n)] = $PCpause_sec [$i];

                                $CSV_statuses .= ",\"$USERcodePAUSE_MS\"";
                                $status_found ++;
                            }
                            $i ++;
                        }
                        if ($status_found < 1) {
                            $SstatusesHTML .= "<td>     0:00</td>";
                            $CSV_statuses .= ",\"0:00:00\"";
                            $graph_stats [$m] [(4 + $n)] = 0;
                        }
                        // ## END loop through each stat line ###
                        $n ++;
                    }
                    // ## END loop through each status ###
                    $TOTtotPAUSE = ($TOTtotPAUSE + $Spause_sec);
                    $Sfull_nameRAW = $Sfull_name;
                    $SuserRAW = $Suser;
                    $graph_stats [$m] [0] = "$Sfull_name - $SuserRAW";
                    $Sfull_name = sprintf("%-45s", $Sfull_name);
                    while (mb_strlen($Sfull_name, 'utf-8') > 15) {
                        $Sfull_name = mb_substr("$Sfull_name", 0, - 1, 'utf-8');
                    }
                    $Suser_group = sprintf("%-60s", $Suser_group);
                    while (mb_strlen($Suser_group, 'utf-8') > 20) {
                        $Suser_group = mb_substr("$Suser_group", 0, - 1, 'utf-8');
                    }
                    $Slast_user_group = sprintf("%-60s", $Slast_user_group);
                    while (mb_strlen($Slast_user_group, 'utf-8') > 20) {
                        $Slast_user_group = mb_substr("$Slast_user_group", 0, - 1, 'utf-8');
                    }
                    $Suser = sprintf("%-24s", $Suser);
                    while (mb_strlen($Suser, 'utf-8') > 8) {
                        $Suser = mb_substr("$Suser", 0, - 1, 'utf-8');
                    }

                    $TOTtotNONPAUSE = ($TOTtotNONPAUSE + $Snon_pause_sec);
                    $TOTtotTOTAL = ($TOTtotTOTAL + $Stotal_sec);

                    if (trim($Stotal_sec) > $max_total) {
                        $max_total = trim($Stotal_sec);
                    }
                    if (trim($Snon_pause_sec) > $max_nonpause) {
                        $max_nonpause = trim($Snon_pause_sec);
                    }
                    if (trim($Spause_sec) > $max_pause) {
                        $max_pause = trim($Spause_sec);
                    }
                    $graph_stats [$m] [1] = "$Stotal_sec";
                    $graph_stats [$m] [2] = "$Snon_pause_sec";
                    $graph_stats [$m] [3] = "$Spause_sec";

                    $USERtotPAUSE_MS = sec_convert($Spause_sec, $TIME_H_agentperfdetail);
                    $USERtotNONPAUSE_MS = sec_convert($Snon_pause_sec, $TIME_H_agentperfdetail);
                    $USERtotTOTAL_MS = sec_convert($Stotal_sec, $TIME_H_agentperfdetail);

                    $pfUSERtotPAUSE_MS = sprintf("%8s", $USERtotPAUSE_MS);
                    $pfUSERtotNONPAUSE_MS = sprintf("%8s", $USERtotNONPAUSE_MS);
                    $pfUSERtotTOTAL_MS = sprintf("%10s", $USERtotTOTAL_MS);
                    $vuser = $this->vusers_m->get_by(array('user' => $Suser), TRUE);
                    $agencyText = '';
                    $agentText = '';
                    $agencyCsv = '';
                    $agentCsv = '';

                    if ($vuser) {
                        $vuserId = $vuser->user_id;
                        $stmt = "SELECT * FROM agents WHERE vicidial_user_id = {$vuserId}";
                        $agent = $this->db->query($stmt)->row_array();
                        if ($agent) {
                            $agencyId = $agent['agency_id'];
                            $agentText = '<a href="' . site_url("admin/manage_agent/agent_info/" . $agent['id']) . '" target="_blank">' . $agent['fname'] . ' ' . $agent['lname'] . '</a>';
                            $agentCsv = $agent['fname'] . ' ' . $agent['lname'];
                            $stmt = "SELECT * FROM agencies WHERE id={$agencyId}";
                            $agency = $this->db->query($stmt)->row_array();
                            if ($agency) {
                                $agencyText = '<a href="' . site_url("admin/manage_agency/agency_info/" . $agency['id']) . '" target="_blank">' . $agency['name'] . '</a>';
                                $agencyCsv = $agency['name'];
                            }
                        }
                    }
                    $BOTTOMoutput = '<tr>';
                    $BOTTOMoutput .= "<td>$Sfull_name</td><td>$Suser</td><td>$Suser_group</td><td>$Slast_user_group</td><td>$agencyText</td><td>$agentText</td><td>$pfUSERtotTOTAL_MS</td><td>$pfUSERtotNONPAUSE_MS</td><td>$pfUSERtotPAUSE_MS</td>$SstatusesHTML";
                    $BOTTOMoutput .= '</tr>';
                    $BOTTOMsorted_output [$m] = $BOTTOMoutput;

                    $ASCII_text .= "$BOTTOMoutput";
                    $CSV_lines .= "\"$Sfull_nameRAW\"" . preg_replace('/\s/', '', ",\"$SuserRAW\",\"$Suser_group\",\"$Slast_user_group\",\"$agencyCsv\",\"$agentCsv\",\"$pfUSERtotTOTAL_MS\",\"$pfUSERtotNONPAUSE_MS\",\"$pfUSERtotPAUSE_MS\",$CSV_statuses");
                    $CSV_lines .= "\n";
                    $m ++;
                } // while ($m < $k){
                // ##### LAST LINE FORMATTING ##########
                // ## BEGIN loop through each status ###
                $SUMstatusesHTML = '';
                $CSVSUMstatuses = '';
                $TOTtotPAUSE = 0;
                $n = 0;
                while ($n < $j) {
                    $Scalls = 0;
                    $Sstatus = $sub_statusesARY [$n];
                    $SUMstatusTXT = '';
                    $total_var = $Sstatus . "_total";
                    // ## BEGIN loop through each stat line ###
                    $i = 0;
                    $status_found = 0;
                    while ($i < $subs_to_print) {
                        if ($Sstatus == "$sub_status[$i]") {
                            $Scalls = ($Scalls + $PCpause_sec [$i]);
                            $status_found ++;
                        }
                        $i ++;
                    }
                    // ## END loop through each stat line ###
                    if ($status_found < 1) {
                        $SUMstatusesHTML .= "<td>        0</td>";
                        $$total_var = 0;
                    } else {
                        $TOTtotPAUSE = ($TOTtotPAUSE + $Scalls);
                        $$total_var = $Scalls;

                        $USERsumstatPAUSE_MS = sec_convert($Scalls, $TIME_H_agentperfdetail);
                        $pfUSERsumstatPAUSE_MS = sprintf("%8s", $USERsumstatPAUSE_MS);

                        $SUMstatusTXT = sprintf("%8s", $pfUSERsumstatPAUSE_MS);
                        $SUMstatusesHTML .= "<td>$SUMstatusTXT</td>";
                        $CSVSUMstatuses .= ",\"$USERsumstatPAUSE_MS\"";
                    }
                    $n ++;
                }
                // ## END loop through each status ###
                $TOT_AGENTS = sprintf("%-4s", $m);

                $TOTtotPAUSE_MS = sec_convert($TOTtotPAUSE, $TIME_H_agentperfdetail);
                $TOTtotNONPAUSE_MS = sec_convert($TOTtotNONPAUSE, $TIME_H_agentperfdetail);
                $TOTtotTOTAL_MS = sec_convert($TOTtotTOTAL, $TIME_H_agentperfdetail);

                $TOTtotPAUSE_MS = sprintf("%10s", $TOTtotPAUSE_MS);
                $TOTtotNONPAUSE_MS = sprintf("%10s", $TOTtotNONPAUSE_MS);
                $TOTtotTOTAL_MS = sprintf("%12s", $TOTtotTOTAL_MS);

                if ($file_download == 0 || !$file_download) {
                    while (strlen($TOTtotPAUSE_MS) > 10) {
                        $TOTtotPAUSE_MS = substr("$TOTtotPAUSE_MS", 0, - 1);
                    }
                    while (strlen($TOTtotNONPAUSE_MS) > 10) {
                        $TOTtotNONPAUSE_MS = substr("$TOTtotNONPAUSE_MS", 0, - 1);
                    }
                    while (strlen($TOTtotTOTAL_MS) > 12) {
                        $TOTtotTOTAL_MS = substr("$TOTtotTOTAL_MS", 0, - 1);
                    }
                }
                // $ASCII_text.="+-----------------+----------+----------------------+----------------------+------------+----------+----------+ +$sub_statusesHEAD\n";
                $ASCII_text .= '<tfoot>';
                $ASCII_text .= '<tr>';
                $ASCII_text .= "<td colspan='3'>" . _QXZ("TOTALS", 33) . "</td><td></td><td></td><td>" . _QXZ("AGENTS", 32, "r") . ":$TOT_AGENTS</td><td>$TOTtotTOTAL_MS</td><td>$TOTtotNONPAUSE_MS</td><td>$TOTtotPAUSE_MS</td>$SUMstatusesHTML";
                // $ASCII_text.="+-----------------+----------+----------------------+----------------------+------------+----------+----------+ +$sub_statusesHEAD\n";
                $ASCII_text .= '</tfoot>';
                $ASCII_text .= '</table></div>';
                for ($e = 0; $e < count($sub_statusesARY); $e ++) {
                    $Sstatus = $sub_statusesARY [$e];
                    $SstatusTXT = $Sstatus;
                    if ($Sstatus == "") {
                        $SstatusTXT = "(" . _QXZ("blank") . ")";
                    }
                    $GRAPH2 .= "<th class='column_header grey_graph_cell' id='pausegraph" . ($e + 4) . "'><a style='display:block;' class='btn btn-link text-center' href='#' onClick=\"DrawPauseGraph('$Sstatus', '" . ($e + 4) . "'); return false;\">$SstatusTXT</a></th>";
                }
                for ($d = 0; $d < count($graph_stats); $d ++) {
                    if ($d == 0) {
                        $class = " first";
                    } else if (($d + 1) == count($graph_stats)) {
                        $class = " last";
                    } else {
                        $class = "";
                    }
                    $TOTAL_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [1], $max_total)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [1], $TIME_H_agentperfdetail) . "</td></tr>";
                    $NONPAUSE_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [2], $max_nonpause)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [2], $TIME_H_agentperfdetail) . "</td></tr>";
                    $PAUSE_graph .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [3], $max_pause)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [3], $TIME_H_agentperfdetail) . "</td></tr>";

                    for ($e = 0; $e < count($sub_statusesARY); $e ++) {
                        $Sstatus = $sub_statusesARY [$e];
                        $varname = $Sstatus . "_graph";
                        $max_varname = "max_" . $Sstatus;

                        $$varname .= "  <tr><td class='chart_td$class'>" . $graph_stats [$d] [0] . "</td><td nowrap class='chart_td value$class'><img src='" . site_url() . "assets/images/bar.png' alt='' width='" . round(MathZDC(400 * $graph_stats [$d] [($e + 4)], $$max_varname)) . "' height='16' />&nbsp;&nbsp;&nbsp;" . sec_convert($graph_stats [$d] [($e + 4)], $TIME_H_agentperfdetail) . "</td></tr>";
                    }
                }
                $TOTAL_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("LOGIN TIME") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotTOTAL_MS) . "</th></tr></table>";
                $NONPAUSE_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("LOGIN TIME") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotNONPAUSE_MS) . "</th></tr></table>";
                $PAUSE_graph .= "<tr><th class='thgraph' scope='col'>" . _QXZ("LOGIN TIME") . ":</th><th class='thgraph' scope='col'>" . trim($TOTtotPAUSE_MS) . "%</th></tr></table>";
                for ($e = 0; $e < count($sub_statusesARY); $e ++) {
                    $Sstatus = $sub_statusesARY [$e];
                    $total_var = $Sstatus . "_total";
                    $graph_var = $Sstatus . "_graph";
                    $$graph_var .= "<tr><th class='thgraph' scope='col'>" . _QXZ("TOTAL") . ":</th><th class='thgraph' scope='col'>" . trim(sec_convert($$total_var, $TIME_H_agentperfdetail)) . "</th></tr></table>";
                }
                $JS_onload .= "\tDrawPauseGraph('TOTAL', '1');\n";
                $JS_text = "<script type='text/javascript'>\n";
                $JS_text .= "function DrawPauseGraph(graph, th_id) {\n";
                $JS_text .= "	var graph_TOTAL=\"$TOTAL_graph\";\n";
                $JS_text .= "	var graph_NONPAUSE=\"$NONPAUSE_graph\";\n";
                $JS_text .= "	var graph_PAUSE=\"$PAUSE_graph\";\n";

                for ($e = 0; $e < count($sub_statusesARY); $e ++) {
                    $Sstatus = $sub_statusesARY [$e];
                    $graph_var = $Sstatus . "_graph";
                    $JS_text .= "	var graph_" . $Sstatus . "=\"" . $$graph_var . "\";\n";
                }

                $JS_text .= "	for (var i=1; i<=" . (3 + count($sub_statusesARY)) . "; i++) {\n";
                $JS_text .= "		var cellID=\"pausegraph\"+i;\n";
                $JS_text .= "		document.getElementById(cellID).style.backgroundColor='#DDDDDD';\n";
                $JS_text .= "	}\n";
                $JS_text .= "	var cellID=\"pausegraph\"+th_id;\n";
                $JS_text .= "	document.getElementById(cellID).style.backgroundColor='#999999';\n";
                $JS_text .= "\n";
                $JS_text .= "	var graph_to_display=eval(\"graph_\"+graph);\n";
                $JS_text .= "	document.getElementById('pause_detail_graph').innerHTML=graph_to_display;\n";
                $JS_text .= "}\n";
                if ($report_display_type == 'HTML') {
                    $JS_text .= $JS_onload;
                }
                $JS_text .= "</script>\n";
                $GRAPH3 = "<tr><td colspan='" . (3 + count($sub_statusesARY)) . "' class='graph_span_cell'><span id='pause_detail_graph'><BR>&nbsp;<BR></span></td></tr></table></div>";
                $GRAPH_text .= $GRAPH . $GRAPH2 . $GRAPH3 . $JS_text;
                $CSV_total = preg_replace('/\s/', '', "\"\",\"\",\"" . _QXZ("TOTALS") . "\",\"" . _QXZ("AGENTS") . ":$TOT_AGENTS\",\"$TOTtotTOTAL_MS\",\"$TOTtotNONPAUSE_MS\",\"$TOTtotPAUSE_MS\",$CSVSUMstatuses");
                if ($file_download == 2) {
                    $FILE_TIME = date("Ymd-His");
                    $CSVfilename = "AST_PAUSE_CODE_BREAKDOWN$US$FILE_TIME.csv";

                    // We'll be outputting a TXT file
                    header('Content-type: application/octet-stream');

                    // It will be called LIST_101_20090209-121212.txt
                    header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    ob_clean();
                    flush();

                    echo "$CSV_header$CSV_lines$CSV_total";
                    exit();
                }
                if ($report_display_type == "HTML") {
                    $HTML_text .= $GRAPH_text;
                } else {
                    $HTML_text .= $ASCII_text;
                }
                $this->data ['result'] = $HTML_text;
            } // main else
        } // if($this->form_validation->run() == TRUE){
        $this->template->load($this->_template, 'dialer/report/agent', $this->data);
    }

    public function getother($agencyId = NULL) {
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
        $campaigns = '';
        $userGroups = '';
        $users = '';
        if ($post = $this->input->post()) {
            $id = decode_url($post ['id']);
            $uGroup = json_decode($post['usergroup']);
            $uUsers = isset($post['users']) ? json_decode($post['users']) : array();
            if ($id) {
                $campaigns .= '<select multiple name="group[]" class="form-control" id="groupcam">';
                $userGroups .= '<select multiple name="user_group[]" class="form-control" id="user_group">';
                $users .= '<select multiple name="users[]" class="form-control" id="usersc">';
                $this->vcampaigns_m->cretaeTempTable();
                $stmt = "SELECT * FROM vicidial_campaigns vc, agency_campaigns ac WHERE ac.vicidial_campaign_id = vc.campaign_id AND ac.agency_id = {$id}";
                $query = $this->db->query($stmt);
                $result = $query->result();
                if ($result) {
                    foreach ($result as $row) {
                        $campaigns .= '<option selected value="' . $row->campaign_id . '">' . $row->campaign_id . ' - ' . $row->campaign_name . '</option>';
                    }
                } else {
                    $campaigns .= '<option value="">No Campaign found</option>';
                }
                $groups = $this->agroups_m->getAgencyGroup($id);
                if ($groups) {
                    foreach ($groups as $group) {
                        $selected = '';
                        if (in_array($group->user_group, $uGroup) || in_array('--ALL--', $uGroup)) {
                            $selected = 'selected="selected"';
                        }
                        $userGroups .= '<option ' . $selected . ' value="' . $group->user_group . '">' . $group->user_group . '</option>';
                    }
                } else {
                    $userGroups .= '<option>No user group found.</option>';
                }
                $stmt = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.parent_agency = {$id}";
                $stmt_B = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.id = {$id}";
                $query = $this->db->query($stmt_B);
                $row = $query->row();
                if ($row) {
                    $selected = '';
                    if (isset($post ['user']) && $post ['user'] == $row->user) {
                        $selected = 'selected="selected"';
                    }
                    $users .= '<option selected value="' . $row->user . '" ' . $selected . '>' . $row->user . ' - ' . $row->name . '</option>';
                }
                $stmt_A = "SELECT main.*,sub.fname,sub.lname FROM vicidial_users main,agents sub WHERE sub.vicidial_user_id = main.user_id AND sub.agency_id = {$id}";
                /* Agency User */
                $query = $this->db->query($stmt);
                $result = $query->result();
                if ($result) {
                    $users .= '<optgroup label="Agency User">';
                    foreach ($result as $row) {
                        $selected = '';
                        if (isset($post ['user']) && $post ['user'] == $row->user) {
                            $selected = 'selected="selected"';
                        }
                        $users .= '<option  selected value="' . $row->user . '" ' . $selected . '>' . $row->user . ' - ' . $row->name . '</option>';
                    }
                    $users .= '</optgroup>';
                }
                /* Agents users */
                $query = $this->db->query($stmt_A);
                $result = $query->result();
                if ($result) {
                    $users .= '<optgroup label="Agent User">';
                    foreach ($result as $row) {
                        $selected = '';
                        if (isset($post ['user']) && $post ['user'] == $row->user) {
                            $selected = 'selected="selected"';
                        }
                        $users .= '<option selected value="' . $row->user . '" ' . $selected . '>' . $row->user . ' - ' . $row->fname . ' ' . $row->lname . '</option>';
                    }
                    $users .= '</optgroup>';
                }
                $campaigns .= '</select>';
                $userGroups .= '</select>';
                $users .= '</select>';

                $output ['success'] = TRUE;
                $output ['campaign'] = $campaigns;
                $output ['groups'] = $userGroups;
                $output ['users'] = $users;
                return $this->output->set_content_type('application/json')->set_output(json_encode($output));
            } else {
                if ($this->session->userdata('user')->group_name == 'Agency') {
                    $campaigns .= '<select multiple name="group[]" class="form-control" id="groupcam">';
                    $selected = 'selected="selected"';
                    $userGroups .= '<select multiple name="user_group[]" class="form-control" id="user_group">';
                    $users .= '<select multiple name="users[]" class="form-control" id="usersc">';
                    $camps = $this->vcampaigns_m->queryForAgency();
                    if (!$camps) {
                        $camps = array();
                    }
                    $campaignss = array();
                    foreach ($camps as $campaign) {
                        $campaignss [] = (object) $campaign;
                    }
                    if ($campaignss) {
                        foreach ($campaignss as $row) {
                            $campaigns .= '<option selected value="' . $row->campaign_id . '">' . $row->campaign_id . ' - ' . $row->campaign_name . '</option>';
                        }
                    } else {
                        $campaigns .= '<option value="">No Campaign found</option>';
                    }

                    $user_groups = $this->agroups_m->query();
                    if ($user_groups) {
                        foreach ($user_groups as $group) {
                            $selected = '';
                            if (in_array($group->user_group, $uGroup) || in_array('--ALL--', $uGroup)) {
                                $selected = 'selected="selected"';
                            }
                            $userGroups .= '<option ' . $selected . ' value="' . $group['user_group'] . '">' . $group['user_group'] . '</option>';
                        }
                    } else {
                        $userGroups .= '<option>No user group found.</option>';
                    }
                    $agencyList = getAgencies();
                    $stmt_B = "SELECT main.*, sub.name FROM vicidial_users main,agencies sub WHERE sub.vicidial_user_id = main.user_id AND sub.id IN ({$agencyList})";
                    $agencyUsers = $this->db->query($stmt_B)->result();
                    if ($agencyUsers) {
                        foreach ($agencyUsers as $agency) {
                            $selected = '';
                            if (in_array($agency->user, $uUsers) || in_array('--ALL--', $uUsers)) {
                                $selected = 'selected="selected"';
                            }
                            $users .= '<option ' . $selected . ' value="' . $agency->user . '">' . $agency->user . '-' . $agency->full_name . '</option>';
                        }
                    }

                    $stmt_A = "SELECT main.*,sub.fname,sub.lname FROM vicidial_users main,agents sub WHERE sub.vicidial_user_id = main.user_id AND sub.agency_id IN ({$agencyList})";
                    $agentUsers = $this->db->query($stmt_A)->result();
                    if ($agentUsers) {
                        foreach ($agentUsers as $agent) {
                            $selected = '';
                            if (in_array($agent->user, $uUsers) || in_array('--ALL--', $uUsers)) {
                                $selected = 'selected="selected"';
                            }
                            $users .= '<option ' . $selected . ' value="' . $agent->user . '">' . $agent->user . '-' . $agency->full_name . '</option>';
                        }
                    }
                    $campaigns .= '</select>';
                    $userGroups .= '</select>';
                    $userGroups .= '</select>';
                    $output ['success'] = TRUE;
                    $output ['campaign'] = $campaigns;
                    $output ['groups'] = $userGroups;
                    $output ['users'] = $users;
                } else {
                    $campaigns .= '<select multiple name="group[]" class="form-control" id="groupcam">';
                    $selected = 'selected="selected"';
                    $campaigns .= '<option value="--ALL--" ' . $selected . '>-- ALL CAMPAIGNS --</option>';
                    $userGroups .= '<select multiple name="user_group[]" class="form-control" id="user_group">';
                    $users .= '<select multiple name="users[]" class="form-control" id="usersc">';
                    if ($this->session->userdata('user')->group_name == 'Agency') {
                        $camps = $this->vcampaigns_m->queryForAgency();
                        if (!$camps) {
                            $camps = array();
                        }
                        $campaignss = array();
                        foreach ($camps as $campaign) {
                            $campaignss [] = (object) $campaign;
                        }
                    } else {
                        $campaignss = $this->vcampaigns_m->get_by(array(
                            'active' => 'Y'
                                ));
                    }
                    if ($campaignss) {
                        foreach ($campaignss as $row) {
                            $campaigns .= '<option>' . $row->campaign_id . ' - ' . $row->campaign_name . '</option>';
                        }
                    } else {
                        $campaigns .= '<option value="">No Campaign found</option>';
                    }
                    $user_groups = $this->vugroup_m->get();
                    if ($user_groups) {
                        foreach ($user_groups as $group) {
                            $selected = '';
                            if (in_array($group->user_group, $uGroup) || in_array('--ALL--', $uGroup)) {
                                $selected = 'selected="selected"';
                            }
                            $userGroups .= '<option ' . $selected . ' value="' . $group->user_group . '">' . $group->user_group . '</option>';
                        }
                    } else {
                        $userGroups .= '<option>No user group found.</option>';
                    }
                    $userss = $this->vusers_m->get();
                    foreach ($userss as $row) {
                        $selected = '';
                        if (in_array($row->user, $uUsers) || in_array('--ALL--', $uUsers)) {
                            $selected = 'selected="selected"';
                        }
                        $users .= '<option ' . $selected . ' value="' . $row->user . '">' . $row->user . ' - ' . $row->full_name . '</option>';
                    }
                    $output ['success'] = TRUE;
                    $output ['campaign'] = $campaigns;
                    $output ['groups'] = $userGroups;
                    $output ['users'] = $users;
                }
                return $this->output->set_content_type('application/json')->set_output(json_encode($output));
            }
        }
    }

}
