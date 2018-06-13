<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sreport extends CI_Controller {

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
        $this->load->model('vicidial/vlists_m', 'vlists_m');
        $this->load->model('vicidial/vingroup_m', 'vingroup_m');
        $this->load->model('vicidial/aingroup_m', 'aingroup_m');
    }
    /**
     *  basic operations function for all methods in this controller
     * @return NULL
     */
    private function _static() {
        $this->data ['datatable'] = TRUE;
        $this->data ['model'] = TRUE;
        $this->data ['validation'] = TRUE;
        $this->data ['sweetAlert'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        $this->data ['listtitle'] = 'Team Performance Detail';
        $this->data ['title'] = 'Team Performance Detail';
        $this->data ['breadcrumb'] = "Team Performance Detail";
        $this->data ['agencies'] = $this->agency_model->get_nested();
        $this->data ['result'] = FALSE;
        if ($this->session->userdata('user')->group_name == 'Agency') {
            $this->data ['agencies'] = $this->agency_model->get_nested($this->session->userdata('agency')->id);
        } else {
            $this->data ['agencies'] = $this->agency_model->get_nested();
        }
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
        $a = array_map(function($obj) {
            return "'" . $obj->campaign_id . "'";
        }, $this->data['campaigns']);
        $stmt = "SELECT DISTINCT status, status_name FROM vicidial_statuses where sale!='Y' UNION select distinct status, status_name FROM vicidial_campaign_statuses WHERE sale!='Y' AND campaign_id IN (" . implode(',', $a) . ") ORDER BY status, status_name;";
        $query = $this->vicidialdb->db->query($stmt);
        $result = $query->result_array();
        $this->data['callStatuses'] = $result;
        $ASCII_text = '';
        $CSV_text = '';
        $GROUP_text = '';
        $GROUP_CSV_text = '';
        $this->form_validation->set_rules('user_group[]', 'Team', 'trim|required');
    }
    /**
     * [team performance report function]
     * @return [type] [description]
     */
    public function team() {
        $this->_static();
        if ($this->form_validation->run() == TRUE) {
            $postData = $this->input->post();
            $this->data['postData'] = $postData;
            $query_date_D = isset($postData['query_date_D']) ? date('Y-m-d', strtotime($postData['query_date_D'])) : '';
            $end_date_D = isset($postData['end_date_D']) ? date('Y-m-d', strtotime($postData['end_date_D'])) : '';
            $query_date_T = isset($postData['query_date_T']) ? $postData['query_date_T'] : '';
            $end_date_T = isset($postData['end_date_T']) ? $postData['end_date_T'] : '';
            $group = isset($postData['group']) ? $postData['group'] : array();
            $call_status = isset($postData['call_status']) ? $postData['call_status'] : array();
            $user_group = isset($postData['user_group']) ? $postData['user_group'] : '';
            $file_download = isset($postData['file_download']) ? $postData['file_download'] : '';
            $query_date = "$query_date_D $query_date_T";
            $end_date = "$end_date_D $end_date_T";
            $LOGallowed_campaigns = ' -ALL-CAMPAIGNS-';
            $LOGallowed_reports = 'ALL REPORTS';
            $LOGadmin_viewable_groups = '';
            $LOGadmin_viewable_call_times = '';
            $LOGallowed_campaignsSQL = '';
            $whereLOGallowed_campaignsSQL = '';
            $ASCII_text = '';$CSV_text = '';$GROUP_text = '';$GROUP_CSV_text = '';
            $multi_drop = 0;$total_sales_talk_time = 0;$total_contact_talk_time=0;$total_nonpause_time=0;$total_nonpause_time = 0;
            if ((!preg_match('/\-ALL/i', $LOGallowed_campaigns))) {
                $rawLOGallowed_campaignsSQL = preg_replace("/ -/", '', $LOGallowed_campaigns);
                $rawLOGallowed_campaignsSQL = preg_replace("/ /", "','", $rawLOGallowed_campaignsSQL);
                $LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
                $whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
            }
            $regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

            $LOGadmin_viewable_groupsSQL = '';
            $whereLOGadmin_viewable_groupsSQL = '';
            if ((!preg_match('/\-\-ALL\-\-/i', $LOGadmin_viewable_groups)) && ( strlen($LOGadmin_viewable_groups) > 3)) {
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/", '', $LOGadmin_viewable_groups);
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ /", "','", $rawLOGadmin_viewable_groupsSQL);
                $LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
                $whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
            }

            $LOGadmin_viewable_call_timesSQL = '';
            $whereLOGadmin_viewable_call_timesSQL = '';
            if ((!preg_match('/\-\-ALL\-\-/i', $LOGadmin_viewable_call_times)) && ( strlen($LOGadmin_viewable_call_times) > 3)) {
                $rawLOGadmin_viewable_call_timesSQL = preg_replace("/ -/", '', $LOGadmin_viewable_call_times);
                $rawLOGadmin_viewable_call_timesSQL = preg_replace("/ /", "','", $rawLOGadmin_viewable_call_timesSQL);
                $LOGadmin_viewable_call_timesSQL = "and call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
                $whereLOGadmin_viewable_call_timesSQL = "where call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
            }

            $MT[0] = '';
            $NOW_DATE = date("Y-m-d");
            $NOW_TIME = date("Y-m-d H:i:s");
            $STARTtime = date("U");
            if (!isset($group)) {
                $group = '';
            }
            if (!isset($call_statuses)) {
                $call_statuses = '';
            }
            if (!isset($query_date_D)) {
                $query_date_D = $NOW_DATE;
            }
            if (!isset($end_date_D)) {
                $end_date_D = $NOW_DATE;
            }
            if (!isset($query_date_T)) {
                $query_date_T = "00:00:00";
            }
            if (!isset($end_date_T)) {
                $end_date_T = "23:59:59";
            }
            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            while ($i < $group_ct) {
                $group_string .= "$group[$i]|";
                $i++;
            }
            $stmt = "SELECT campaign_id FROM vicidial_campaigns $whereLOGallowed_campaignsSQL ORDER BY campaign_id;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $campaigns_to_print = $query->num_rows();
            $i = 0;
            while ($i < $campaigns_to_print) {
                $row = array_values($result[$i]);
                $groups[$i] = $row[0];
                if (preg_match('/\-ALL/', $group_string)) {
                    $group[$i] = $groups[$i];
                }
                $i++;
            }
            $i = 0;
            $call_status_string = '|';
            $call_status_ct = count($call_status);
            while ($i < $call_status_ct) {
                $call_status_string .= "$call_status[$i]|";
                $i++;
            }
            if (preg_match("/--NONE--/", $call_status_string)) {
                $call_status_string = "";
                $call_status = array();
                $call_status_ct = 0;
            }
            for ($i = 0; $i < count($user_group); $i++) {
                if (preg_match('/\-\-ALL\-\-/', $user_group[$i])) {
                    $all_user_groups = 1;
                    $user_group = "";
                }
            }
            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            $group_SQL = '';
            $groupQS = '';
            while ($i < $group_ct) {
                if ((preg_match("/ $group[$i] /", $regexLOGallowed_campaigns)) || ( preg_match("/-ALL/", $LOGallowed_campaigns))) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $groupQS .= "&group[]=$group[$i]";
                }
                $i++;
            }
            if ((preg_match('/\-\-ALL\-\-/', $group_string) ) || ( $group_ct < 1)) {
                $group_SQL = "";
            } else {
                $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                $group_SQL_str = $group_SQL;
                $group_SQL = "and campaign_id IN($group_SQL)";
            }
            $i = 0;
            $call_status_string = '';
            $call_status_ct = count($call_status);
            $HTMLstatusheader = '';
            $CSVstatusheader = '';
            while ($i < $call_status_ct) {
                $call_status_string .= "$call_status[$i]";
                $call_status_SQL .= "'$call_status[$i]',";
                $CSVstatusheader.=",\"$call_status[$i]\"";
                $HTMLborderheader.="--------+";
                $HTMLstatusheader.="<th>" . sprintf("%6s", $call_status[$i]) . "</th>";
                $call_statusQS .= "&call_status[]=$call_status[$i]";
                $i++;
            }
            if ((preg_match('/\s\-\-NONE\-\-\s/', $call_status_string) ) || ( $call_status_ct < 1)) {
                $call_status_SQL = "";
            } else {
                $call_status_SQL = preg_replace('/,$/i', '', $call_status_SQL);
                $call_status_SQL_str = $call_status_SQL;
                $call_status_SQL = "and status IN($call_status_SQL)";
            }
            $i = 0;
            $user_group_string = '|';
            $user_group_ct = is_array($user_group) ? count($user_group) : 0;
            $user_group_SQL = '';
            $user_groupQS = '';
            while ($i < $user_group_ct) {
                $user_group_string .= "$user_group[$i]|";
                $user_group_SQL .= "'$user_group[$i]',";
                $user_groupQS .= "&user_group[]=$user_group[$i]";
                $i++;
            }

            if ((preg_match('/\-\-ALL\-\-/', $user_group_string) ) or ( $user_group_ct < 1)) {
                $user_group_SQL = "";
            } else {
                $user_group_SQL = preg_replace('/,$/i', '', $user_group_SQL);
                $user_group_SQL = "and vicidial_agent_log.user_group IN($user_group_SQL)";
            }
            $stmt = "SELECT MAX(event_time), vicidial_agent_log.user, vicidial_agent_log.lead_id, vicidial_list.status AS current_status FROM vicidial_agent_log, vicidial_list WHERE event_time>='$query_date' AND event_time<='$end_date' $group_SQL AND vicidial_agent_log.status in (SELECT status FROM vicidial_campaign_statuses WHERE sale='Y' $group_SQL UNION SELECT status FROM vicidial_statuses where sale='Y') AND vicidial_agent_log.lead_id=vicidial_list.lead_id GROUP BY vicidial_agent_log.user, vicidial_agent_log.lead_id";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $count = 0;
            while ($count < $query->num_rows()) {
                $row = $result[$count];
                $lead_id = $row["lead_id"];
                $user = $row["user"];
                $current_status = $row["current_status"];
                if (preg_match("/QCCANC/i", $current_status)) {
                    $cancel_array[$row["user"]] ++;
                } elseif (preg_match("/QCFAIL/i", $current_status)) {
                    $incomplete_array[$row["user"]] ++;
                } else {
                    if(isset($sale_array[$row["user"]])){
                        $sale_array[$row["user"]] ++;
                    }
                    $sale_time_stmt = "select sum(talk_sec)-sum(dead_sec) from vicidial_agent_log where user='$user' and lead_id='$lead_id' $group_SQL";
                    $innerQuery = $this->vicidialdb->db->query($sale_time_stmt);
                    $sale_time_rslt = $innerQuery->row_array();
                    $sale_time_row = array_values($sale_time_rslt);
                    if(isset($sales_talk_time_array[$row["user"]])){
                        $sales_talk_time_array[$row["user"]] += $sale_time_row[0];
                    }
                }

                $count++;
            } //while($count < $query->num_rows()){
            $total_average_sale_time = 0;
            $total_average_contact_time = 0;
            $total_talk_time = 0;
            $total_system_time = 0;
            $total_calls = 0;
            $total_leads = 0;
            $total_contacts = 0;
            $total_sales = 0;
            $total_inc_sales = 0;
            $total_cnc_sales = 0;
            $total_callbacks = 0;
            $total_stcall = 0;

            $max_totalcalls = 1;
            $max_totalleads = 1;
            $max_totalcontacts = 1;
            $max_totalcontactratio = 1;
            $max_totalsystemtime = 1;
            $max_totaltalktime = 1;
            $max_totalsales = 1;
            $max_totalsalesleadsratio = 1;
            $max_totalsalescontactsratio = 1;
            $max_totalsalesperhour = 1;
            $max_totalincsales = 1;
            $max_totalcancelledsales = 1;
            $max_totalcallbacks = 1;
            $max_totalfirstcall = 1;
            $max_totalavgsaletime = 1;
            $max_totalavgcontacttime = 1;
            for ($i = 0; $i < $user_group_ct; $i++) {
                $avg_sale_time = 0;
                $avg_contact_time = 0;
                $group_contact_talk_time = 0;
                $call_status_group_totals = 0;
                $call_status_totals_grand_total = 0;
                $group_average_sale_time = 0;
                $group_average_contact_time = 0;
                $group_talk_time = 0;
                $group_system_time = 0;
                $group_nonpause_time = 0;
                $group_calls = 0;
                $group_leads = 0;
                $group_contacts = 0;
                $group_sales = 0;
                $group_inc_sales = 0;
                $group_cnc_sales = 0;
                $group_callbacks = 0;
                $group_stcall = 0;
                $name_stmt = "SELECT group_name FROM vicidial_user_groups WHERE user_group='$user_group[$i]'";
                $name_query = $this->vicidialdb->db->query($name_stmt);
                $name_row = array_values($name_query->row_array());
                $group_name = $name_row[0];
                for ($q = 0; $q < count($call_status); $q++) {
                    $call_status_group_totals[$q] = 0;
                }
                $ASCII_text .= "<div class='team_{$i}'>";
                $ASCII_text.="<h4 class='bold text-center'>" . _QXZ("TEAM") . ": $user_group[$i] - $group_name</h4>";
                $CSV_text.="\"\",\"" . _QXZ("TEAM") . ": $user_group[$i] - $group_name\"\n";
                #### USER COUNTS
                $user_stmt = "SELECT DISTINCT vicidial_users.full_name, vicidial_users.user FROM vicidial_users, vicidial_agent_log WHERE vicidial_users.user_group='$user_group[$i]' AND vicidial_users.user=vicidial_agent_log.user AND vicidial_agent_log.user_group='$user_group[$i]'  AND vicidial_agent_log.event_time>='$query_date' AND vicidial_agent_log.event_time<='$end_date' AND vicidial_agent_log.campaign_id IN ($group_SQL_str) ORDER BY full_name, user";
                $userQuery = $this->vicidialdb->db->query($user_stmt);
                if ($userQuery->num_rows() > 0) {
                    $max_calls = 1;
                    $max_leads = 1;
                    $max_contacts = 1;
                    $max_contactratio = 1;
                    $max_systemtime = 1;
                    $max_talktime = 1;
                    $max_sales = 1;
                    $max_salesleadsratio = 1;
                    $max_salescontactsratio = 1;
                    $max_salesperhour = 1;
                    $max_incsales = 1;
                    $max_cancelledsales = 1;
                    $max_callbacks = 1;
                    $max_firstcall = 1;
                    $max_avgsaletime = 1;
                    $max_avgcontacttime = 1;
                    $j = 0;
                    //$ASCII_text .= $HTMLborderheader;
                    $ASCII_text .= '<div class="table-responsive">';
                    $ASCII_text .= '<table class="table table-bordered">';
                    $ASCII_text .= "<thead>"
                            . "<tr><th>Agent Name</th>"
                            . "<th>Agent ID</th>"
                            . "<th>Agency</th>"
                            . "<th>Agent</th>"
                            . "<th>Calls</th>"
                            . "<th>Leads</th>"
                            . "<th>Contacts</th>"
                            . "<th>Contact Ratio</th>"
                            . "<th>Nonpause Time</th>"
                            . "<th>System Time</th>"
                            . "<th>Talk Time</th>"
                            . "<th>Sales</th>"
                            . "<th>Sales per Working Hour</th>"
                            . "<th>Sales to Leads Ratio</th>"
                            . "<th>Sales to Contacts Ratio</th>"
                            . "<th>Sales Per Hour</th>"
                            . "<th>Incomplete Sales</th>"
                            . "<th>Cancelled Sales</th>"
                            . "<th>Callbacks</th>"
                            . "<th>First Call Resolution</th>"
                            . "<th>Average Sale Time</th>"
                            . "<th>Average Contact Time</th>$HTMLstatusheader";
                    $ASCII_text .= '</tr></thead>';
                    $CSV_text.="\"\",\"" . _QXZ("Agent Name") . "\",\"" . _QXZ("Agent ID") . "\",\"" . _QXZ("Calls") . "\",\"" . _QXZ("Leads") . "\",\"" . _QXZ("Contacts") . "\",\"" . _QXZ("Contact Ratio") . "\",\"" . _QXZ("Nonpause Time") . "\",\"" . _QXZ("System Time") . "\",\"" . _QXZ("Talk Time") . "\",\"" . _QXZ("Sales") . "\",\"" . _QXZ("Sales per Working Hour") . "\",\"" . _QXZ("Sales to Leads Ratio") . "\",\"" . _QXZ("Sales to Contacts Ratio") . "\",\"" . _QXZ("Sales Per Hour") . "\",\"" . _QXZ("Incomplete Sales") . "\",\"" . _QXZ("Cancelled Sales") . "\",\"" . _QXZ("Callbacks") . "\",\"" . _QXZ("First Call Resolution") . "\",\"" . _QXZ("Average Sale Time") . "\",\"" . _QXZ("Average Contact Time") . "\"$CSVstatusheader\n";
                    $userResult = $userQuery->result_array();
                    $group_sales_talk_time = 0;
                    $count = 0;
                    while ($count < $userQuery->num_rows()) {
                        $contact_talk_time = 0;
                        $user_row_1 = $userResult[$count];
                        $user_row_2 = array_values($userResult[$count]);
                        $user_row = array_merge($user_row_1, $user_row_2);
                        $j++;
                        $contacts = 0;
                        $callbacks = 0;
                        $stcall = 0;
                        $calls = 0;
                        $leads = 0;
                        $system_time = 0;
                        $talk_time = 0;
                        $nonpause_time = 0;
                        # For each user
                        $user = $user_row["user"];
                        $vuser = $this->vusers_m->get_by(array('user' => $user), TRUE);
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
                        isset($sale_array[$user]) ? $sale_array[$user] += 0 : $sale_array[$user] = 0;
                        isset($sale_array[$user]) ? $sale_array[$user] += 0 : $sale_array[$user] = 0;  # For agents with no sales logged
                        isset($incomplete_array[$user]) ? $incomplete_array[$user] +=0 : $incomplete_array[$user] = 0;  # For agents with no QCFAIL logged
                        isset($cancel_array[$user]) ? $cancel_array[$user] += 0 : $cancel_array[$user] = 0;  # For agents with no QCCANC logged
                        # Leads
                        $lead_stmt = "SELECT COUNT(distinct lead_id) FROM vicidial_agent_log WHERE lead_id is not null AND event_time>='$query_date' AND event_time<='$end_date' $group_SQL AND user='$user' AND user_group='$user_group[$i]'";
                        $lead_rslt = $this->vicidialdb->db->query($lead_stmt);
                        $lead_row = array_values($lead_rslt->row_array());
                        $leads = $lead_row[0];
                        # Callbacks
                        $callback_stmt = "SELECT count(*) FROM vicidial_callbacks WHERE status IN ('ACTIVE', 'LIVE') $group_SQL AND user='$user' AND user_group='$user_group[$i]'";
                        $callback_rslt = $this->vicidialdb->db->query($callback_stmt);
                        $callback_row = array_values($callback_rslt->row_array());
                        $callbacks = $callback_row[0];

                        $stat_stmt = "SELECT val.status, val.sub_status, vs.customer_contact, SUM(val.talk_sec), SUM(val.pause_sec), SUM(val.wait_sec), SUM(val.dispo_sec), SUM(val.dead_sec), COUNT(*) FROM vicidial_agent_log val, vicidial_statuses vs WHERE val.user='$user' AND val.user_group='$user_group[$i]' AND val.event_time>='$query_date' AND val.event_time<='$end_date' AND val.status=vs.status AND vs.status IN (SELECT status FROM vicidial_statuses) AND val.campaign_id IN ($group_SQL_str) GROUP BY status, customer_contact UNION SELECT val.status, val.sub_status, vs.customer_contact, SUM(val.talk_sec), SUM(val.pause_sec), SUM(val.wait_sec), SUM(val.dispo_sec), SUM(val.dead_sec), COUNT(*) FROM vicidial_agent_log val, vicidial_campaign_statuses vs WHERE val.campaign_id IN ($group_SQL_str) AND val.user='$user' AND val.user_group='$user_group[$i]' AND val.event_time>='$query_date' AND val.event_time<='$end_date' AND val.status=vs.status AND val.campaign_id=vs.campaign_id AND vs.status IN (SELECT distinct status FROM vicidial_campaign_statuses WHERE " . substr($group_SQL, 4) . ") GROUP BY status, customer_contact";
                        $statQuery = $this->vicidialdb->db->query($stat_stmt);
                        $stat_rslt = $statQuery->result_array();
                        $countS = 0;
                        while ($countS < $statQuery->num_rows()) {
                            $stat_row = array_values($stat_rslt[$countS]);
                            if ($stat_row[2] == "Y") {
                                $contacts += $stat_row[8];
                                $contact_talk_time += ($stat_row[3] - $stat_row[7]);
                                $group_contact_talk_time += ($stat_row[3] - $stat_row[7]);
                            }
                            # if ($stat_row[2]=="Y") {$callbacks+=$stat_row[8];}
                            $calls += $stat_row[8];
                            $talk_time += ($stat_row[3] - $stat_row[7]);
                            $system_time += ($stat_row[3] + $stat_row[5] + $stat_row[6]);
                            $nonpause_time += ($stat_row[3] + $stat_row[5] + $stat_row[6]);
                            if ($stat_row[1] == "PRECAL") {
                                $nonpause_time += $stat_row[4];
                            }
                            $countS++;
                        } // while($countS < $statQuery->num_rows()){
                        $user_talk_time = sec_convert($talk_time, 'H');
                        $group_talk_time+=$talk_time;
                        $user_system_time = sec_convert($system_time, 'H');
                        $talk_hours = MathZDC($talk_time, 3600);
                        $group_system_time+=$system_time;
                        $user_nonpause_time = sec_convert($nonpause_time, 'H');
                        $group_nonpause_time+=$nonpause_time;

                        if ($sale_array[$user] > 0) {
                            $average_sale_time = sec_convert(round(MathZDC($sales_talk_time_array[$user], $sale_array[$user])), 'H');
                        } else {
                            $average_sale_time = "00:00";
                        }
                        $group_sales_talk_time += isset($sales_talk_time_array[$user]) ? $sales_talk_time_array[$user] : 0;
                        if ($contacts > 0) {
                            $average_contact_time = sec_convert(round(MathZDC($contact_talk_time, $contacts)), 'H');
                        } else {
                            $average_contact_time = "00:00";
                        }
                        $ASCII_text .= "<tr>";
                        $ASCII_text.="<td>" . sprintf("%-40s", $user_row["full_name"]) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%10s", "$user") . "</td>";
                        $ASCII_text.="<td>" . sprintf("%10s", "$agencyText") . "</td>";
                        $ASCII_text.="<td>" . sprintf("%10s", "$agentText") . "</td>";
                        $ASCII_text.="<td>" . sprintf("%5s", $calls) . "</td>";
                        $group_calls+=$calls;
                        $ASCII_text.="<td>" . sprintf("%5s", $leads) . "</td>";
                        $group_leads+=$leads;
                        $ASCII_text.="<td>" . sprintf("%8s", $contacts) . "</td>";
                        $group_contacts+=$contacts;
                        $contact_ratio = sprintf("%.2f", MathZDC(100 * $contacts, $leads));
                        $ASCII_text.="<td>" . sprintf("%12s", $contact_ratio) . "%" . "</td>";
                        $ASCII_text.="<td>" . sprintf("%13s", $user_nonpause_time) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%11s", $user_system_time) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%9s", $user_talk_time) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%5s", $sale_array[$user]) . "</td>";
                        $group_sales+=$sale_array[$user];
                        $sales_per_working_hours = sprintf("%.2f", (MathZDC($sale_array[$user], MathZDC($nonpause_time, 3600))));
                        $ASCII_text.="<td>" . sprintf("%22s", $sales_per_working_hours) . "</td>";
                        $sales_ratio = sprintf("%.2f", MathZDC(100 * $sale_array[$user], $leads));
                        $ASCII_text.="<td>" . sprintf("%19s", $sales_ratio) . "%" . "</td>";
                        $sale_contact_ratio = sprintf("%.2f", MathZDC(100 * $sale_array[$user], $contacts));
                        $ASCII_text.="<td>" . sprintf("%22s", $sale_contact_ratio) . "%" . "</td>";
                        $sales_per_hour = sprintf("%.2f", MathZDC($sale_array[$user], $talk_hours));
                        $stcall = sprintf("%.2f", MathZDC($calls, $leads));

                        if (trim($calls) > $max_calls) {
                            $max_calls = trim($calls);
                        }
                        if (trim($leads) > $max_leads) {
                            $max_leads = trim($leads);
                        }
                        if (trim($contacts) > $max_contacts) {
                            $max_contacts = trim($contacts);
                        }
                        if (trim($contact_ratio) > $max_contactratio) {
                            $max_contactratio = trim($contact_ratio);
                        }
                        if (trim($system_time) > $max_systemtime) {
                            $max_systemtime = trim($system_time);
                        }
                        if (trim($talk_time) > $max_talktime) {
                            $max_talktime = trim($talk_time);
                        }
                        if (trim($sale_array[$user]) > $max_sales) {
                            $max_sales = trim($sale_array[$user]);
                        }
                        if (trim($sales_ratio) > $max_salesleadsratio) {
                            $max_salesleadsratio = trim($sales_ratio);
                        }
                        if (trim($sale_contact_ratio) > $max_salescontactsratio) {
                            $max_salescontactsratio = trim($sale_contact_ratio);
                        }
                        if (trim($sales_per_hour) > $max_salesperhour) {
                            $max_salesperhour = trim($sales_per_hour);
                        }
                        if (trim($incomplete_array[$user]) > $max_incsales) {
                            $max_incsales = trim($incomplete_array[$user]);
                        }
                        if (trim($cancel_array[$user]) > $max_cancelledsales) {
                            $max_cancelledsales = trim($cancel_array[$user]);
                        }
                        if (trim($callbacks) > $max_callbacks) {
                            $max_callbacks = trim($callbacks);
                        }
                        if (trim($stcall) > $max_firstcall) {
                            $max_firstcall = trim($stcall);
                        }
                        if (trim($avg_sale_time) > $max_avgsaletime) {
                            $max_avgsaletime = trim($avg_sale_time);
                        }
                        if (trim($avg_contact_time) > $max_avgcontacttime) {
                            $max_avgcontacttime = trim($avg_contact_time);
                        }

                        $ASCII_text.="<td>" . sprintf("%14s", $sales_per_hour) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%16s", $incomplete_array[$user]) . "</td>";
                        $group_inc_sales+=$incomplete_array[$user];
                        $ASCII_text.="<td>" . sprintf("%15s", $cancel_array[$user]) . "</td>";
                        $group_cnc_sales+=$cancel_array[$user];
                        $ASCII_text.="<td>" . sprintf("%9s", $callbacks) . "</td>";
                        $group_callbacks+=$callbacks;
                        $ASCII_text.="<td>" . sprintf("%21s", $stcall) . "</td>"; # first call resolution
                        $ASCII_text.="<td>" . sprintf("%17s", $average_sale_time) . "</td>";
                        $ASCII_text.="<td>" . sprintf("%20s", $average_contact_time) . "</td>";
                        $CSV_status_text = "";
                        for ($q = 0; $q < count($call_status); $q++) {
                            $stat_stmt = "SELECT SUM(stat_ct) FROM (SELECT COUNT(distinct uniqueid) AS stat_ct From vicidial_agent_log val, vicidial_statuses vs WHERE val.user='$user' AND val.user_group='$user_group[$i]' AND val.event_time>='$query_date' AND val.event_time<='$end_date' AND val.status=vs.status AND vs.status='$call_status[$q]' AND val.campaign_id IN ($group_SQL_str) UNION SELECT COUNT(DISTINCT uniqueid) AS stat_ct From vicidial_agent_log val, vicidial_campaign_statuses vs where val.user='$user' AND val.user_group='$user_group[$i]' AND val.event_time>='$query_date' AND val.event_time<='$end_date' AND val.status=vs.status AND vs.status='$call_status[$q]' and val.campaign_id IN ($group_SQL_str)) as counts";
                            $stat_rslt = $this->vicidialdb->db->query($stat_stmt);
                            $stat_row = array_values($stat_rslt->row_array());
                            $ASCII_text.="<td>" . sprintf("%6s", $stat_row[0]) . "</td>";
                            $CSV_status_text.=",\"$stat_row[0]\"";
                        } //for ($q=0; $q<count($call_status); $q++) {
                        $ASCII_text.="</tr>";

                        $CSV_text.="\"$j\",\"$user_row[full_name]\",\"$user\",\"$calls\",\"$leads\",\"$contacts\",\"$contact_ratio %\",\"$user_nonpause_time\",\"$user_system_time\",\"$user_talk_time\",\"$sale_array[$user]\",\"$sales_per_working_hours\",\"$sales_ratio\",\"$sale_contact_ratio\",\"$sales_per_hour\",\"$incomplete_array[$user]\",\"$cancel_array[$user]\",\"$callbacks\",\"$stcall\",\"$average_sale_time\",\"$average_contact_time\"$CSV_status_text\n";
                        $count++;
                    } //while($count < $userQuery->num_rows()){

                    $group_average_sale_time = sec_convert(round(MathZDC($group_sales_talk_time, $group_sales)), 'H');
                    $group_average_contact_time = sec_convert(round(MathZDC($group_contact_talk_time, $group_contacts)), 'H');
                    $group_talk_hours = MathZDC($group_talk_time, 3600);

                    $GROUP_text.="<tr><td>" . sprintf("%40s", "$group_name") . '</td>';
                    $GROUP_text.="<td>" . sprintf("%10s", "$user_group[$i]") . '</td>';
                    $total_graph_stats[$i][0] = "$user_group[$i] - $group_name";

                    $ASCII_text.="<tfoot><tr><td>" . sprintf("%40s", "") . "</td>";
                    $ASCII_text.="<td>" . sprintf("%40s", "") . "</td>";
                    $ASCII_text.="<td>" . sprintf("%40s", "") . "</td>";
                    $ASCII_text.="<td>" . sprintf("%10s", _QXZ("TOTALS:", 10)) . "</td>";

                    $TOTAL_text = "<td>" . sprintf("%5s", $group_calls) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%5s", $group_leads) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%8s", $group_contacts) . "</td>";
                    $group_contact_ratio = sprintf("%.2f", MathZDC(100 * $group_contacts, $group_leads));
                    $TOTAL_text.="<td>" . sprintf("%12s", $group_contact_ratio) . "%" . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%13s", sec_convert($group_nonpause_time, 'H')) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%11s", sec_convert($group_system_time, 'H')) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%9s", sec_convert($group_talk_time, 'H')) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%5s", $group_sales) . "</td>";
                    $sales_per_working_hours = sprintf("%.2f", (MathZDC($group_sales, MathZDC($group_nonpause_time, 3600))));
                    $TOTAL_text.="<td>" . sprintf("%22s", $sales_per_working_hours) . "</td>";
                    $group_sales_ratio = sprintf("%.2f", MathZDC(100 * $group_sales, $group_leads));
                    $TOTAL_text.="<td>" . sprintf("%19s", $group_sales_ratio) . "%" . "</td>";
                    $group_sale_contact_ratio = sprintf("%.2f", MathZDC(100 * $group_sales, $group_contacts));
                    $TOTAL_text.="<td>" . sprintf("%22s", $group_sale_contact_ratio) . "%" . "</td>";
                    $group_sales_per_hour = sprintf("%.2f", MathZDC($group_sales, $group_talk_hours));
                    $group_stcall = sprintf("%.2f", MathZDC($group_calls, $group_leads));
                    $TOTAL_text.="<td>" . sprintf("%14s", $group_sales_per_hour) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%16s", $group_inc_sales) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%15s", $group_cnc_sales) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%9s", $group_callbacks) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%21s", $group_stcall) . "</td>";  # first call resolution
                    $TOTAL_text.="<td>" . sprintf("%17s", $group_average_sale_time) . "</td>";
                    $TOTAL_text.="<td>" . sprintf("%20s", $group_average_contact_time) . "</td>";

                    $CSV_status_text = "";
                    $call_status_group_count = is_array($call_status_group_totals) ? count($call_status_group_totals) : 0;
                    for ($q = 0; $q < $call_status_group_count; $q++) {
                        $TOTAL_text .="<td>" . sprintf("%6s", $call_status_group_totals[$q]) . "</td>";
                        isset($call_status_totals_grand_total[$q]) ? $call_status_totals_grand_total[$q]+=$call_status_group_totals[$q] : 0;
                        $CSV_status_text.=",\"$call_status_group_totals[$q]\"";
                    }
                    isset($total_calls) ? $total_calls +=$group_calls : $total_calls = 0;
                    isset($total_leads) ? $total_leads +=$group_leads : $total_leads = 0;
                    isset($total_contacts) ? $total_contacts +=$group_contacts : $total_contacts = 0;
                    isset($total_system_time) ? $total_system_time +=$group_system_time : $total_system_time = 0;
                    isset($total_nonpause_time) ? $total_nonpause_time +=$group_nonpause_time : $total_nonpause_time = 0;
                    isset($total_talk_time) ? $total_talk_time +=$group_talk_time : $total_talk_time = 0;
                    $total_sales +=$group_sales;
                    $total_inc_sales +=$group_inc_sales;
                    $total_cnc_sales +=$group_cnc_sales;
                    $total_callbacks +=$group_callbacks;
                    $total_stcall +=$group_stcall;  # first call resolution
                    isset($total_sales_talk_time) ? $total_sales_talk_time +=$group_sales_talk_time : $total_sales_talk_time = 0;
                    isset($total_contact_talk_time) ? $total_contact_talk_time +=$group_contact_talk_time : $total_contact_talk_time = 0;

                    $ASCII_text .= $TOTAL_text . '</tr></tfoot>';
                    $GROUP_text .= $TOTAL_text . '</tr>';
                    $CSV_text.="\"\",\"\",\"" . _QXZ("TOTALS") . ":\",\"$group_calls\",\"$group_leads\",\"$group_contacts\",\"$group_contact_ratio %\",\"" . sec_convert($group_nonpause_time, 'H') . "\",\"" . sec_convert($group_system_time, 'H') . "\",\"" . sec_convert($group_talk_time, 'H') . "\",\"$group_sales\",\"$sales_per_working_hours\",\"$group_sales_ratio\",\"$group_sale_contact_ratio\",\"$group_sales_per_hour\",\"$group_inc_sales\",\"$group_cnc_sales\",\"$group_callbacks\",\"$group_stcall\",\"$group_average_sale_time\",\"$group_average_contact_time\"$CSV_status_text\n";
                    $GROUP_CSV_text.="\"$i\",\"$group_name\",\"$user_group[$i]\",\"$group_calls\",\"$group_leads\",\"$group_contacts\",\"$group_contact_ratio %\",\"" . sec_convert($group_nonpause_time, 'H') . "\",\"" . sec_convert($group_system_time, 'H') . "\",\"" . sec_convert($group_talk_time, 'H') . "\",\"$group_sales\",\"$sales_per_working_hours\",\"$group_sales_ratio\",\"$group_sale_contact_ratio\",\"$group_sales_per_hour\",\"$group_inc_sales\",\"$group_cnc_sales\",\"$group_callbacks\",\"$group_stcall\",\"$group_average_sale_time\",\"$group_average_contact_time\"$CSV_status_text\n";
                    $CSV_text.="\n\n";
                    $ASCII_text .= '</table></div></div>';
                } else { //if($userQuery->num_rows() > 0){
                    $ASCII_text.="<p class='text-center'>**** " . _QXZ("NO AGENTS FOUND UNDER THESE REPORT PARAMETERS") . " ****</p>";
                    $ASCII_text .= '</div>';
                    $CSV_text.="\"\",\"**** " . _QXZ("NO AGENTS FOUND UNDER THESE REPORT PARAMETERS") . " ****\"\n\n";
                }
            } // for($i=0; $i<$user_group_ct; $i++) {

            $ASCII_text .= '<div class="table-responsive"><table class="table table-bordered">';
            $ASCII_text .= "<caption class='bold text-center'>CALL CENTER TOTAL</caption>";
            $ASCII_text .= '<thead><tr>';
            $ASCII_text.="<th>Team Name</th>"
                    . "<th>Agent ID</th>"
                    . "<th>Calls</th>"
                    . "<th>Leads</th>"
                    . "<th>Contacts</th>"
                    . "<th>Contact Ratio</th>"
                    . "<th>Nonpause Time</th>"
                    . "<th>System Time</th>"
                    . "<th>Talk Time</th>"
                    . "<th>Sales</th>"
                    . "<th>Sales per Working Hour</th>"
                    . "<th>Sales to Leads Ratio</th>"
                    . "<th>Sales to Contacts Ratio</th>"
                    . "<th>Sales Per Hour</th>"
                    . "<th>Incomplete Sales</th>"
                    . "<th>Cancelled Sales</th>"
                    . "<th>Callbacks</th>"
                    . "<th>First Call Resolution</th>"
                    . "<th>Average Sale Time</th>"
                    . "<th>Average Contact Time</th>$HTMLstatusheader";
            $ASCII_text .= '</tr></thead>';
            $ASCII_text .=$GROUP_text;
            $total_average_sale_time = sec_convert(round(MathZDC($total_sales_talk_time, $total_sales)), 'H');
            $total_average_contact_time = sec_convert(round(MathZDC($total_contact_talk_time, $total_contacts)), 'H');
            $total_talk_hours = MathZDC($total_talk_time, 3600);
            $ASCII_text.= "<tfoot><tr>";
            $ASCII_text.="<td>" . sprintf("%40s", "") . "</td>";
            $ASCII_text.="<td>" . sprintf("%10s", _QXZ("TOTALS:")) . "</td>";
            $ASCII_text.="<td>" . sprintf("%5s", $total_calls) . "</td>";
            $ASCII_text.="<td>" . sprintf("%5s", $total_leads) . "</td>";
            $ASCII_text.="<td>" . sprintf("%8s", $total_contacts) . "</td>";
            $total_contact_ratio = sprintf("%.2f", MathZDC(100 * $total_contacts, $total_leads));
            $ASCII_text.="<td>" . sprintf("%12s", $total_contact_ratio) . "%" . "</td>";
            $ASCII_text.="<td>" . sprintf("%13s", sec_convert($total_nonpause_time, 'H')) . "</td>";
            $ASCII_text.="<td>" . sprintf("%11s", sec_convert($total_system_time, 'H')) . "</td>";
            $ASCII_text.="<td>" . sprintf("%9s", sec_convert($total_talk_time, 'H')) . "</td>";
            $ASCII_text.="<td>" . sprintf("%5s", $total_sales) . "</td>";
            $sales_per_working_hours = sprintf("%.2f", MathZDC($total_sales, MathZDC($total_nonpause_time, 3600)));
            $ASCII_text.="<td>" . sprintf("%22s", $sales_per_working_hours) . "</td>";
            $total_sales_ratio = sprintf("%.2f", MathZDC(100 * $total_sales, $total_leads));
            $ASCII_text.="<td>" . sprintf("%19s", $total_sales_ratio) . "%" . "</td>";
            $total_sale_contact_ratio = sprintf("%.2f", MathZDC(100 * $total_sales, $total_contacts));
            $ASCII_text.="<td>" . sprintf("%22s", $total_sale_contact_ratio) . "%" . "</td>";
            $total_sales_per_hour = sprintf("%.2f", MathZDC($total_sales, $total_talk_hours));
            $total_stcall = sprintf("%.2f", MathZDC($total_calls, $total_leads));
            $ASCII_text.="<td>" . sprintf("%14s", $total_sales_per_hour) . "</td>";
            $ASCII_text.="<td>" . sprintf("%16s", $total_inc_sales) . "</td>";
            $ASCII_text.="<td>" . sprintf("%15s", $total_cnc_sales) . "</td>";
            $ASCII_text.="<td>" . sprintf("%9s", $total_callbacks) . "</td>";
            $ASCII_text.="<td>" . sprintf("%21s", $total_stcall) . "</td>";  # first call resolution
            $ASCII_text.="<td>" . sprintf("%17s", $total_average_sale_time) . "</td>";
            $ASCII_text.="<td>" . sprintf("%20s", $total_average_contact_time) . "</td>";
            $CSV_status_text = "";
            $call_status_totals_grand_count = is_array($call_status_totals_grand_total) ? count($call_status_totals_grand_total) : 0;
            for ($q = 0; $q < $call_status_totals_grand_count; $q++) {
                $ASCII_text.="<td>" . sprintf("%6s", $call_status_totals_grand_total[$q]) . "</td>";
                $CSV_status_text.=",\"$call_status_totals_grand_total[$q]\"";
            }
            $ASCII_text.= "</tr></tfoot>";
            $ASCII_text.="\n";
            $ASCII_text .= '</table></div>';
            $CSV_text.="\"\",\"" . _QXZ("CALL CENTER TOTAL") . "\"\n";
            $CSV_text.="\"\",\"" . _QXZ("Team Name") . "\",\"" . _QXZ("Team ID") . "\",\"" . _QXZ("Calls") . "\",\"" . _QXZ("Leads") . "\",\"" . _QXZ("Contacts") . "\",\"" . _QXZ("Contact Ratio") . "\",\"" . _QXZ("Nonpause Time") . "\",\"" . _QXZ("System Time") . "\",\"" . _QXZ("Talk Time") . "\",\"" . _QXZ("Sales") . "\",\"" . _QXZ("Sales per Working Hour") . "\",\"" . _QXZ("Sales to Leads Ratio") . "\",\"" . _QXZ("Sales to Contacts Ratio") . "\",\"" . _QXZ("Sales Per Hour") . "\",\"" . _QXZ("Incomplete Sales") . "\",\"" . _QXZ("Cancelled Sales") . "\",\"" . _QXZ("Callbacks") . "\",\"" . _QXZ("First Call Resolution") . "\",\"" . _QXZ("Average Sale Time") . "\",\"" . _QXZ("Average Contact Time") . "\"$CSVstatusheader\n";
            $CSV_text.=$GROUP_CSV_text;
            $CSV_text.="\"\",\"\",\"" . _QXZ("TOTALS") . ":\",\"$total_calls\",\"$total_leads\",\"$total_contacts\",\"$total_contact_ratio %\",\"" . sec_convert($total_nonpause_time, 'H') . "\",\"" . sec_convert($total_system_time, 'H') . "\",\"" . sec_convert($total_talk_time, 'H') . "\",\"$total_sales\",\"$sales_per_working_hours\",\"$total_sales_ratio\",\"$total_sale_contact_ratio\",\"$total_sales_per_hour\",\"$total_inc_sales\",\"$total_cnc_sales\",\"$total_callbacks\",\"$total_stcall\",\"$total_average_sale_time\",\"$total_average_contact_time\"$CSV_status_text\n";
            if ($file_download > 0) {
                $FILE_TIME = date("Ymd-His");
                $CSVfilename = "AST_team_performance_detail_$US$FILE_TIME.csv";
                $CSV_text = preg_replace('/\n +,/', ',', $CSV_text);
                $CSV_text = preg_replace('/ +\"/', '"', $CSV_text);
                $CSV_text = preg_replace('/\" +/', '"', $CSV_text);

                // We'll be outputting a TXT file
                header('Content-type: application/octet-stream');
                // It will be called LIST_101_20090209-121212.txt
                header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                ob_clean();
                flush();
                echo "$CSV_text";
                exit;
            }
            $this->data['result'] = $ASCII_text;
        } //if($postData = $this->input->post()){
        $this->template->load($this->_template, 'dialer/report/team', $this->data);
    }
    /**
     * [status description]
     * @return [type] [description]
     */
    public function status() {
        $this->_static();
        $ASCII_text = '';
        $file_output = '';
        $fileToutput = '';
        $report_name = 'Agent Status Detail';
        $this->data ['listtitle'] = 'Agent Status Detail';
        $this->data ['title'] = 'Agent Status Detail';
        $this->data ['breadcrumb'] = "Agent Status Detail";
        $postData = $this->input->post();
        if ($this->form_validation->run() == TRUE) {
            $this->data['postData'] = $postData;
            $query_date = isset($postData['query_date']) ? date('Y-m-d', strtotime($postData['query_date'])) : '';
            $end_date = isset($postData['end_date']) ? date('Y-m-d', strtotime($postData['end_date'])) : '';
            $group = isset($postData['group']) ? $postData['group'] : array();
            if(in_array('--ALL--', $group)){
                $group = array();
                foreach($this->data['campaigns'] as $campaign){
                    $group = $campaign->campaign_id;
                }
            }
            $user_group = isset($postData['user_group']) ? $postData['user_group'] : '';
            $file_download = isset($postData['file_download']) ? $postData['file_download'] : '';
            $shift = 'ALL';
            $search_archived_data = '';
            $show_defunct_users = '';
            $stage = 'ID';
            $agent_log_table = "vicidial_agent_log";
            $LOGallowed_campaigns = ' -ALL-CAMPAIGNS-';
            $LOGallowed_reports = 'ALL REPORTS';
            $LOGadmin_viewable_groups = '';
            $LOGadmin_viewable_call_times = '';
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

            $LOGadmin_viewable_call_timesSQL = '';
            $whereLOGadmin_viewable_call_timesSQL = '';
            if ((!preg_match('/\-\-ALL\-\-/i', $LOGadmin_viewable_call_times)) and ( strlen($LOGadmin_viewable_call_times) > 3)) {
                $rawLOGadmin_viewable_call_timesSQL = preg_replace("/ -/", '', $LOGadmin_viewable_call_times);
                $rawLOGadmin_viewable_call_timesSQL = preg_replace("/ /", "','", $rawLOGadmin_viewable_call_timesSQL);
                $LOGadmin_viewable_call_timesSQL = "and call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
                $whereLOGadmin_viewable_call_timesSQL = "where call_time_id IN('---ALL---','$rawLOGadmin_viewable_call_timesSQL')";
            }
            $MT[0] = '';
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
            $group_string = '';
            $group_SQL = '';
            $groupQS = '';
            while ($i < $group_ct) {
                if ((preg_match("/ $group[$i] /", $regexLOGallowed_campaigns)) or ( preg_match("/-ALL/", $LOGallowed_campaigns))) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $groupQS .= "&group[]=$group[$i]";
                }
                $i++;
            }
            if ((preg_match('/\-\-ALL\-\-/', $group_string) ) or ( $group_ct < 1)) {
                $group_SQL = "";
            } else {
                $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                $group_SQL = "and campaign_id IN($group_SQL)";
            }

            $stmt = "SELECT campaign_id FROM vicidial_campaigns $whereLOGallowed_campaignsSQL ORDER BY campaign_id;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $campaigns_to_print = $query->num_rows();
            $i = 0;
            while ($i < $campaigns_to_print) {
                $row = array_values($result[$i]);
                $groups[$i] = $row[0];
                if (preg_match('/\-ALL/', $group_string)) {
                    $group[$i] = $groups[$i];
                }
                $i++;
            }
            $i = 0;
            $user_group_string = '|';
            $user_group_ct = is_array($user_group) ? count($user_group) : 0;
            $user_group_SQL = '';
            $user_groupQS = '';
            while ($i < $user_group_ct) {
                $user_group_string .= "$user_group[$i]|";
                $user_group_SQL .= "'$user_group[$i]',";
                $user_groupQS .= "&user_group[]=$user_group[$i]";
                $i++;
            }

            if ((preg_match('/\-\-ALL\-\-/', $user_group_string) ) or ( $user_group_ct < 1)) {
                $user_group_SQL = "";
            } else {
                $user_group_SQL = preg_replace('/,$/i', '', $user_group_SQL);
                $user_group_SQL = "and vicidial_agent_log.user_group IN($user_group_SQL)";
            }
            $stmt = "SELECT vsc_id,vsc_name FROM vicidial_status_categories;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statcats_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statcats_to_print) {
                $row = array_values($result[$i]);
                $vsc_id[$i] = $row[0];
                $vsc_name[$i] = $row[1];
                $vsc_count[$i] = 0;
                $i++;
            }
            $customer_interactive_statuses = '';
            $stmt = "SELECT status FROM vicidial_statuses WHERE human_answered='Y';";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statha_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statha_to_print) {
                $row = array_values($result[$i]);
                $customer_interactive_statuses .= "|$row[0]";
                $i++;
            }
            $stmt = "SELECT status FROM vicidial_campaign_statuses WHERE human_answered='Y' $LOGallowed_campaignsSQL;";
            $query = $this->vicidialdb->db->query($stmt);
            $result = $query->result_array();
            $statha_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statha_to_print) {
                $row = array_values($result[$i]);
                $customer_interactive_statuses .= "|$row[0]";
                $i++;
            }
            if (strlen($customer_interactive_statuses) > 0) {
                $customer_interactive_statuses .= '|';
            }
            if ((strlen($group[0]) < 1) or ( strlen($user_group[0]) < 1)) {
                $ASCII_text .= "<p>PLEASE SELECT A CAMPAIGN OR USER GROUP AND DATE-TIME BELOW AND CLICK SUBMIT</p>";
                $ASCII_text .= "</p>NOTE: stats taken from shift specified</p>";
            } else {
                $time_BEGIN = "00:00:00";
                $time_END = "23:59:59";
                $query_date_BEGIN = "$query_date $time_BEGIN";
                $query_date_END = "$end_date $time_END";
                if ($file_download < 1) {
                    $ASCII_text.="<p>" . _QXZ("$report_name") . " Report                     $NOW_TIME</p>";
                    $ASCII_text.="<p>Time range: $query_date_BEGIN to $query_date_END</p>";
                } else {
                    $file_output .= _QXZ("$report_name") . " Report                     $NOW_TIME\n";
                    $file_output .= "Time range: $query_date_BEGIN to $query_date_END\n\n";
                }
                $statuses = '-';
                $statusesTXT = '';
                $statusesHEAD = '';
                $statusesHTML = '';
                $statusesFILE = '';
                $statusesARY[0] = '';
                $j = 0;
                $users = '-';
                $usersARY[0] = '';
                $user_namesARY[0] = '';
                $k = 0;
                if ($show_defunct_users) {
                    $user_stmt = "SELECT DISTINCT '' as full_name, user FROM " . $agent_log_table . " WHERE event_time <= '$query_date_END' AND event_time >= '$query_date_BEGIN'  AND status is not null $group_SQL $user_group_SQL ORDER BY user asc";
                } else {
                    $user_stmt = "SELECT DISTINCT full_name,vicidial_users.user FROM vicidial_users," . $agent_log_table . " WHERE event_time <= '$query_date_END' AND event_time >= '$query_date_BEGIN' AND vicidial_users.user=" . $agent_log_table . ".user AND status is not null $group_SQL $user_group_SQL ORDER BY full_name ASC";
                }
                $query = $this->vicidialdb->db->query($user_stmt);
                $user_rslt = $query->result_array();
                $q = 0;
                while ($q < $query->num_rows()) {
                    $user_row = array_values($user_rslt[$q]);
                    $full_name_val = $user_row[0];
                    $full_name[$q] = $full_name_val;
                    $user[$q] = $user_row[1];
                    if (!preg_match("/\-$user[$q]\-/i", $users)) {
                        $users .= "$user[$q]-";
                        $usersARY[$k] = $user[$q];
                        $user_namesARY[$k] = $full_name[$q];
                        $k++;
                    }
                    $q++;
                } //while($q < $query->num_rows()){
                if ($show_defunct_users) {
                    $status_stmt = "SELECT DISTINCT status FROM " . $agent_log_table . " WHERE event_time <= '$query_date_END' AND event_time >= '$query_date_BEGIN' and status is not null $group_SQL $user_group_SQL ORDER BY status";
                } else {
                    $status_stmt = "SELECT DISTINCT status FROM vicidial_users," . $agent_log_table . " WHERE event_time <= '$query_date_END' AND event_time >= '$query_date_BEGIN' AND vicidial_users.user=" . $agent_log_table . ".user $group_SQL $user_group_SQL ORDER BY status";
                }
                $query = $this->vicidialdb->db->query($status_stmt);
                $status_rslt = $query->result_array();
                $q = 0;
                $count = 0;
                $status_rows_to_print = 0;
                $sub_status_count = 0;
                $rows_to_print = 0;
                while ($count < $query->num_rows()) {
                    $row = array_values($status_rslt[$count]);
                    $current_status = $row[0];
                    $stmt = "SELECT COUNT(*) AS calls,full_name,vicidial_users.user,status FROM vicidial_users," . $agent_log_table . " where event_time <= '$query_date_END' AND event_time >= '$query_date_BEGIN' AND vicidial_users.user=" . $agent_log_table . ".user AND status='$current_status' $group_SQL $user_group_SQL GROUP BY user,full_name,status ORDER BY full_name,user,status DESC LIMIT 500000;";
                    $queryInner = $this->vicidialdb->db->query($stmt);
                    $iResult = $queryInner->result_array();
                    $status_rows_to_print = $queryInner->num_rows();
                    $rows_to_print += $status_rows_to_print;
                    $i = 0;
                    while ($i < $status_rows_to_print) {
                        $row = array_values($iResult[$i]);
                        $full_name_val = $row[1];
                        if (($row[0] > 0) && ( strlen($row[2]) > 0) && ( strlen($row[3]) > 0) && ( !preg_match("/NULL/i", $row[3]))) {
                            $calls[$q] = $row[0];
                            $full_name[$q] = $full_name_val;
                            $user[$q] = $row[2];
                            $status[$q] = $row[3];
                            if ((!preg_match("/-$status[$q]-/i", $statuses)) && ( strlen($status[$q]) > 0)) {
                                $statusesTXT = sprintf("%8s", $status[$q]);
                                $statusesHEAD .= "----------+";
                                $statusesHTML .= "<th>$statusesTXT</th>";
                                $statusesFILE .= "$statusesTXT,";
                                $statuses .= "$status[$q]-";
                                $statusesARY[$j] = $status[$q];

                                $sub_statusesARY[$sub_status_count] = $status[$q];
                                $sub_status_count++;
                                $max_varname = "max_" . $status[$q];
                                $$max_varname = 1;

                                $j++;
                            }
                            if (!preg_match("/\-$user[$q]\-/i", $users)) {
                                $users .= "$user[$q]-";
                                $usersARY[$k] = $user[$q];
                                $user_namesARY[$k] = $full_name[$q];
                                $k++;
                            }
                        }
                        $i++;
                        $q++;
                    } //while ($i < $status_rows_to_print){
                    $count++;
                }//while($count < $query->num_rows()){
                if ($file_download < 1) {
                    $ASCII_text.= "<div class='table-responsive'><table class='table table-bordered'>";
                    $ASCII_text.="<caption class='bold text-center'>CALLS STATS BREAKDOWN:</caption>";
                    //$ASCII_text.="+---------------------------+----------+--------+--------+--------+$statusesHEAD\n";
                    $ASCII_text.= '<thead><tr>';
                    $ASCII_text.="<th>USER NAME</th><th>Agency</th><th>Agent</th><th>ID</th><th>CALLS</th><th>CIcalls</th><th>DNC/CI%</th>$statusesHTML";
                    $ASCII_text.= '</tr></thead>';
                    //$ASCII_text.="+---------------------------+----------+--------+--------+--------+$statusesHEAD\n";
                    $cnt = isset($sub_statusesARY) && is_array($sub_statusesARY) ? count($sub_statusesARY) : 0;
                    for ($i = 0; $i < $cnt; $i++) {
                        $Sstatus = isset($sub_statusesARY) ? $sub_statusesARY[$i] : '';
                        $SstatusTXT = $Sstatus;
                        if ($Sstatus == "") {
                            $SstatusTXT = "(blank)";
                        }
                    }
                } else {
                    $file_output .= "USER,Agency,Agent,ID,CALLS,CIcalls,DNC-CI%,$statusesFILE\n";
                }
                ### BEGIN loop through each user ###
                $m = 0;
                $CIScountTOT = 0;
                $DNCcountTOT = 0;

                $graph_stats = array();
                $max_calls = 1;
                $max_cicalls = 1;
                $max_dncci = 1;
                $TOPsortMAX = 0;
                $TOTcalls = 0;
                while ($m < $k) {
                    $Suser = $usersARY[$m];
                    $Sfull_name = $user_namesARY[$m];
                    $Scalls = 0;
                    $SstatusesHTML = '';
                    $SstatusesFILE = '';
                    $CIScount = 0;
                    $DNCcount = 0;
                    ### BEGIN loop through each status ###
                    $n = 0;
                    while ($n < $j) {
                        $Sstatus = $statusesARY[$n];
                        $SstatusTXT = '';
                        ### BEGIN loop through each stat line ###
                        $i = 0;
                        $status_found = 0;
                        while ($i < $rows_to_print) {
                            if (($Suser == "$user[$i]") and ( $Sstatus == "$status[$i]")) {
                                $Scalls = ($Scalls + $calls[$i]);
                                if (preg_match("/\|$status[$i]\|/i", $customer_interactive_statuses)) {
                                    $CIScount = ($CIScount + $calls[$i]);
                                    $CIScountTOT = ($CIScountTOT + $calls[$i]);
                                }
                                if (preg_match("/DNC/i", $status[$i])) {
                                    $DNCcount = ($DNCcount + $calls[$i]);
                                    $DNCcountTOT = ($DNCcountTOT + $calls[$i]);
                                }
                                $SstatusTXT = sprintf("%8s", $calls[$i]);
                                $SstatusesHTML .= "<td>$SstatusTXT</td>";
                                $SstatusesFILE .= "$SstatusTXT,";
                                $status_found++;
                            }
                            $i++;
                        }
                        if ($status_found < 1) {
                            $graph_stats[$m][(4 + $n)] = 0;
                            $SstatusesHTML .= "<td>0</td>";
                            $SstatusesFILE .= "0,";
                        }
                        ### END loop through each stat line ###
                        $n++;
                    }//while ($n < $j){
                    ### END loop through each status ###

                    $TOTcalls = ($TOTcalls + $Scalls);
                    $RAWuser = $Suser;
                    $RAWcalls = $Scalls;
                    $RAWcis = $CIScount;
                    $Scalls = sprintf("%6s", $Scalls);
                    $CIScount = sprintf("%6s", $CIScount);
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
                    if ($file_download < 1) {
                        $Sfull_name = sprintf("%-25s", $Sfull_name);
                        while (strlen($Sfull_name) > 25) {
                            $Sfull_name = substr("$Sfull_name", 0, -1);
                        }
                        $Suser = sprintf("%-8s", $Suser);
                        while (strlen($Suser) > 8) {
                            $Suser = substr("$Suser", 0, -1);
                        }
                    }
                    $DNCcountPCTs = ( MathZDC($DNCcount, $CIScount) * 100);
                    $RAWdncPCT = $DNCcountPCTs;
                    #	$DNCcountPCTs = round($DNCcountPCTs,2);
                    $DNCcountPCTs = round($DNCcountPCTs);
                    $rawDNCcountPCTs = $DNCcountPCTs;
                    #	$DNCcountPCTs = sprintf("%3.2f", $DNCcountPCTs);
                    $DNCcountPCTs = sprintf("%6s", $DNCcountPCTs);

                    if (trim($Scalls) > $max_calls) {
                        $max_calls = trim($Scalls);
                    }
                    if (trim($CIScount) > $max_cicalls) {
                        $max_cicalls = trim($CIScount);
                    }
                    if (trim($DNCcountPCTs) > $max_dncci) {
                        $max_dncci = trim($DNCcountPCTs);
                    }
                    if ($file_download < 1) {
                        $Toutput = '<tr>';
                        $Toutput .= "<td>$Sfull_name</td><td>$agencyText</td><td>$agentText</td><td>$Suser</td><td>$Scalls</td><td>$CIScount</td><td>$DNCcountPCTs%</td>$SstatusesHTML";
                        $Toutput .= '</tr>';
                        $graph_stats[$m][0] = trim("$user_namesARY[$m] - $usersARY[$m]");
                    } else {
                        $fileToutput = "$Sfull_name,$agencyCsv,$agentCsv,$RAWuser,$RAWcalls,$RAWcis,$rawDNCcountPCTs%,$SstatusesFILE\n";
                    }
                    $TOPsorted_output[$m] = $Toutput;
                    $TOPsorted_outputFILE[$m] = $fileToutput;

                    if ($stage == 'ID') {
                        $TOPsort[$m] = '' . sprintf("%08s", $RAWuser) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                        $TOPsortTALLY[$m] = $RAWcalls;
                    }
                    if ($stage == 'LEADS') {
                        $TOPsort[$m] = '' . sprintf("%08s", $RAWcalls) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                        $TOPsortTALLY[$m] = $RAWcalls;
                    }
                    if ($stage == 'TIME') {
                        $TOPsort[$m] = '' . sprintf("%08s", $Stime) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                        $TOPsortTALLY[$m] = $Stime;
                    }
                    if ($stage == 'CI') {
                        $TOPsort[$m] = '' . sprintf("%08s", $RAWcis) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                        $TOPsortTALLY[$m] = $RAWcis;
                    }
                    if ($stage == 'DNCCI') {
                        $TOPsort[$m] = '' . sprintf("%08s", $RAWdncPCT) . '-----' . $m . '-----' . sprintf("%020s", $RAWuser);
                        $TOPsortTALLY[$m] = $RAWdncPCT;
                    }
                    if (!preg_match('/ID|TIME|LEADS|CI|DNCCI/', $stage))
                        if ($file_download < 1) {
                            $ASCII_text.="$Toutput";
                        } else {
                            $file_output .= "$fileToutput";
                        }

                    if ($TOPsortMAX < $TOPsortTALLY[$m]) {
                        $TOPsortMAX = $TOPsortTALLY[$m];
                    }
                    $m++;
                } //while ($m < $k){
                $TOT_AGENTS = sprintf("%4s", $m);
                ### BEGIN sort through output to display properly ###
                if (preg_match('/ID|TIME|LEADS|CI|DNCCI/', $stage)) {
                    if (preg_match('/ID/', $stage) && isset($TOPsort)) {
                        sort($TOPsort, SORT_NUMERIC);
                    }
                    if (preg_match('/TIME|LEADS|CI|DNCCI/', $stage)) {
                        rsort($TOPsort, SORT_NUMERIC);
                    }

                    $m = 0;
                    while ($m < $k) {
                        $sort_split = explode("-----", $TOPsort[$m]);
                        $i = $sort_split[1];
                        $sort_order[$m] = "$i";
                        if ($file_download < 1) {
                            $ASCII_text.="$TOPsorted_output[$i]";
                        } else {
                            $file_output .= "$TOPsorted_outputFILE[$i]";
                        }
                        $m++;
                    }
                }
                ### END sort through output to display properly ###
                ###### LAST LINE FORMATTING ##########
                ### BEGIN loop through each status ###
                $SUMstatusesHTML = '';
                $n = 0;
                $SUMstatusesFILE = '';
                while ($n < $j) {
                    $Scalls = 0;
                    $Sstatus = $statusesARY[$n];
                    $SUMstatusTXT = '';
                    $total_var = $Sstatus . "_total";
                    ### BEGIN loop through each stat line ###
                    $i = 0;
                    $status_found = 0;
                    while ($i < $rows_to_print) {
                        if ($Sstatus == "$status[$i]") {
                            $Scalls = ($Scalls + $calls[$i]);
                            $status_found++;
                        }
                        $i++;
                    }
                    ### END loop through each stat line ###
                    if ($status_found < 1) {
                        $SUMstatusesHTML .= "<td>0</td>";
                        $$total_var = "0";
                    } else {
                        $SUMstatusTXT = sprintf("%8s", $Scalls);
                        $SUMstatusesHTML .= "<td>$SUMstatusTXT</td>";
                        $SUMstatusesFILE .= "$SUMstatusTXT,";
                        $$total_var = $Scalls;
                    }
                    $n++;
                }
                ### END loop through each status ###
                $TOTcalls = sprintf("%7s", $TOTcalls);
                $CIScountTOT = sprintf("%7s", $CIScountTOT);
                $DNCcountPCT = ( MathZDC($DNCcountTOT, $CIScountTOT) * 100);
                $DNCcountPCT = round($DNCcountPCT, 2);
                $DNCcountPCT = sprintf("%3.2f", $DNCcountPCT);
                $DNCcountPCT = ( MathZDC($DNCcountTOT, $CIScountTOT) * 100);
                #$DNCcountPCT = round($DNCcountPCT,2);
                $DNCcountPCT = round($DNCcountPCT);
                #$DNCcountPCT = sprintf("%3.2f", $DNCcountPCT);
                $DNCcountPCT = sprintf("%6s", $DNCcountPCT);
                if ($file_download < 1) {
                    //$ASCII_text.="+------------ ---------------+----------+--------+--------+--------+$statusesHEAD\n";
                    $ASCII_text .= '<tfoot><tr>';
                    $ASCII_text.="<td colspan='4'>TOTALS        <span class='text-right' style='float:right;'>AGENTS:$TOT_AGENTS</span></td><td>$TOTcalls</td><td>$CIScountTOT</td><td>$DNCcountPCT%</td>$SUMstatusesHTML\n";
                    $ASCII_text .= '</tr></tfoot>';
                    //$ASCII_text.="+--------------------------------------+--------+--------+--------+$statusesHEAD\n";

                    $ASCII_text.='</table></div>';
                } else {
                    $file_output .= "TOTALS,$TOT_AGENTS,,,$TOTcalls,$CIScountTOT,$DNCcountPCT%,$SUMstatusesFILE\n";
                }
                if ($file_download > 0) {
                    $FILE_TIME = date("Ymd-His");
                    $CSVfilename = "AGENT_STATUS$US$FILE_TIME.csv";

                    // We'll be outputting a TXT file
                    header('Content-type: application/octet-stream');

                    // It will be called LIST_101_20090209-121212.txt
                    header("Content-Disposition: attachment; filename=\"$CSVfilename\"");
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    ob_clean();
                    flush();
                    echo "$file_output";
                    exit;
                }
                $this->data['result'] = $ASCII_text;
            } // else
        }
        $this->template->load($this->_template, 'dialer/report/status', $this->data);
    }
    /**
     * [calls description]
     * @return [type] [description]
     */
    public function calls() {
        $this->_static();
        $this->data ['listtitle'] = 'Export Calls Report';
        $this->data ['title'] = 'Export Calls Report';
        $this->data ['breadcrumb'] = "Export Calls Report";
        $stmt = "select status from vicidial_statuses order by status;";
        $query = $this->vicidialdb->db->query($stmt);
        $result1 = $query->result_array();
        $a = array_map(function($obj) {
            return "'" . $obj->campaign_id . "'";
        }, $this->data['campaigns']);
        $str = implode(',', $a);
        $stmt = "select distinct status from vicidial_campaign_statuses WHERE campaign_id IN({$str}) order by status;";
        $query = $this->vicidialdb->db->query($stmt);
        $result2 = $query->result_array();
        $this->data['statuses'] = array_merge($result1, $result2);
        if($this->session->userdata('user')->group_name == 'Agency'){
            $this->data['lists'] = $this->vlists_m->queryForAgency();
        }else{
            $this->data['lists'] = $this->vlists_m->query();
        }
        $this->data['ingroups'] = $this->aingroup_m->query();
        $postData = $this->input->post();
        $this->data['postData'] = $postData;
        if ($postData) {
            $file_exported = 0;
            $query_date = isset($postData['query_date']) ? date('Y-m-d', strtotime($postData['query_date'])) : '';
            $end_date = isset($postData['end_date']) ? date('Y-m-d', strtotime($postData['end_date'])) : '';
            $campaign = isset($postData['campaign']) ? $postData['campaign'] : array();
            $group = isset($postData['group']) ? $postData['group'] : array();
            $user_group = isset($postData['user_group']) ? $postData['user_group'] : array();
            $list_id = isset($postData['list_id']) ? $postData['list_id'] : array();
            $status = isset($postData['status']) ? $postData['status'] : array();
            $run_export = isset($postData['run_export']) ? $postData['run_export'] : 1;
            $header_row = isset($postData['header_row']) ? $postData['header_row'] : '';
            $rec_fields = isset($postData['rec_fields']) ? $postData['rec_fields'] : '';
            $custom_fields = isset($postData['custom_fields']) ? $postData['custom_fields'] : '';
            $call_notes = isset($postData['call_notes']) ? $postData['call_notes'] : '';
            $export_fields = isset($postData['export_fields']) ? $postData['export_fields'] : '';
            $ivr_export = isset($postData['ivr_export']) ? $postData['ivr_export'] : '';
            $search_archived_data = isset($postData['search_archived_data']) ? $postData['search_archived_data'] : '';
            $inbound_to_print = 0;
            $vicidial_log_table = "vicidial_log";
            $vicidial_closer_log_table = "vicidial_closer_log";
            $vicidial_agent_log_table = "vicidial_agent_log";
            $vicidial_log_extended_table = "vicidial_log_extended";
            $recording_log_table = "recording_log";
            $vicidial_carrier_log_table = "vicidial_carrier_log";
            $vicidial_cpd_log_table = "vicidial_cpd_log";
            $vicidial_did_log_table = "vicidial_did_log";
            $vicidial_outbound_ivr_log_table = "vicidial_outbound_ivr_log";
            $shift = 'ALL';
            $report_name = 'Export Calls Report';
            $LOGallowed_campaigns = ' -ALL-CAMPAIGNS-';
            $LOGallowed_reports = 'ALL REPORTS';
            $LOGadmin_viewable_groups = '';
            $LOGallowed_campaignsSQL = '';
            $whereLOGallowed_campaignsSQL = '';
            $custom_fields_enabled = 0;
            if ((!preg_match('/\-ALL/i', $LOGallowed_campaigns))) {
                $rawLOGallowed_campaignsSQL = preg_replace("/ -/", '', $LOGallowed_campaigns);
                $rawLOGallowed_campaignsSQL = preg_replace("/ /", "','", $rawLOGallowed_campaignsSQL);
                $LOGallowed_campaignsSQL = "and campaign_id IN('$rawLOGallowed_campaignsSQL')";
                $whereLOGallowed_campaignsSQL = "where campaign_id IN('$rawLOGallowed_campaignsSQL')";
            }
            $regexLOGallowed_campaigns = " $LOGallowed_campaigns ";

            $LOGadmin_viewable_groupsSQL = '';
            $whereLOGadmin_viewable_groupsSQL = '';
            if ((!preg_match('/\-\-ALL\-\-/i', $LOGadmin_viewable_groups)) && ( strlen($LOGadmin_viewable_groups) > 3)) {
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/", '', $LOGadmin_viewable_groups);
                $rawLOGadmin_viewable_groupsSQL = preg_replace("/ /", "','", $rawLOGadmin_viewable_groupsSQL);
                $LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
                $whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
            }

            if ($run_export > 0) {
                $US = '_';
                $MT[0] = '';
                $ip = getenv("REMOTE_ADDR");
                $NOW_DATE = date("Y-m-d");
                $NOW_TIME = date("Y-m-d H:i:s");
                $FILE_TIME = date("Ymd-His");
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
                $campaign_ct = count($campaign);
                $group_ct = count($group);
                $user_group_ct = count($user_group);
                $list_ct = count($list_id);
                $status_ct = count($status);
                $campaign_string = '|';
                $group_string = '|';
                $user_group_string = '|';
                $list_string = '|';
                $status_string = '|';
                $i = 0;
                $RUNcampaign = 0;
                $campaign_SQL = '';
                while ($i < $campaign_ct) {
                    if ((preg_match("/ $campaign[$i] /", $regexLOGallowed_campaigns)) || ( preg_match("/-ALL/", $LOGallowed_campaigns))) {
                        $campaign_string .= "$campaign[$i]|";
                        $campaign_SQL .= "'$campaign[$i]',";
                    }
                    $i++;
                }
                if ((preg_match('/\s\-\-NONE\-\-\s/', $campaign_string) ) || ( $campaign_ct < 1)) {
                    $campaign_SQL = "campaign_id IN('')";
                    $RUNcampaign = 0;
                } else {
                    $campaign_SQL = preg_replace('/,$/i', '', $campaign_SQL);
                    $campaign_SQL = "and vl.campaign_id IN($campaign_SQL)";
                    $RUNcampaign++;
                }
                $i = 0;
                $group_SQL = '';
                while ($i < $group_ct) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $i++;
                }
                $RUNgroup = 0;
                if ((preg_match('/\s\-\-NONE\-\-\s/', $group_string) ) || ( $group_ct < 1)) {
                    $group_SQL = "''";
                    $group_SQL = "campaign_id IN('')";
                    $RUNgroup = 0;
                } else {
                    $group_SQL = preg_replace('/,$/i', '', $group_SQL);
                    $group_SQL = "and vl.campaign_id IN($group_SQL)";
                    $RUNgroup++;
                }
                $i = 0;
                $user_group_SQL = '';
                while ($i < $user_group_ct) {
                    $user_group_string .= "$user_group[$i]|";
                    $user_group_SQL .= "'$user_group[$i]',";
                    $i++;
                }
                if ((preg_match('/\-\-ALL\-\-/', $user_group_string) ) || ( $user_group_ct < 1)) {
                    $user_group_SQL = "";
                } else {
                    $user_group_SQL = preg_replace('/,$/i', '', $user_group_SQL);
                    $user_group_SQL = "and vl.user_group IN($user_group_SQL)";
                }
                $i = 0;
                $list_SQL = '';
                while ($i < $list_ct) {
                    $list_string .= "$list_id[$i]|";
                    $list_SQL .= "'$list_id[$i]',";
                    $i++;
                }
                if ((preg_match('/\-\-ALL\-\-/', $list_string) ) || ( $list_ct < 1)) {
                    $list_SQL = "";
                } else {
                    $list_SQL = preg_replace('/,$/i', '', $list_SQL);
                    $list_SQL = "and vi.list_id IN($list_SQL)";
                }
                $i = 0;
                $status_SQL = '';
                while ($i < $status_ct) {
                    $status_string .= "$status[$i]|";
                    $status_SQL .= "'$status[$i]',";
                    $i++;
                }
                if ((preg_match('/\-\-ALL\-\-/', $status_string) ) || ( $status_ct < 1)) {
                    $status_SQL = "";
                } else {
                    $status_SQL = preg_replace('/,$/i', '', $status_SQL);
                    $status_SQL = "and vl.status IN($status_SQL)";
                }
                $export_fields_SQL = '';
                $EFheader = '';
                if ($export_fields == 'EXTENDED') {
                    $export_fields_SQL = ",entry_date,vl.called_count,last_local_call_time,modify_date,called_since_last_reset";
                    $EFheader = ",entry_date,called_count,last_local_call_time,modify_date,called_since_last_reset";
                }
                if ($export_fields == 'EXTENDED_2') {
                    $export_fields_SQL = ",entry_date,vl.called_count,last_local_call_time,modify_date,called_since_last_reset,term_reason";
                    $EFheader = ",entry_date,called_count,last_local_call_time,modify_date,called_since_last_reset,term_reason";
                }
                if ($export_fields == 'ALTERNATE_1') {
                    $export_fields_SQL = ",vl.called_count,last_local_call_time";
                    $EFheader = ",called_count,last_local_call_time";
                }
                $outbound_calls = 0;
                $export_rows = '';
                $k = 0;
                if ($RUNcampaign > 0) {
                    if (($export_fields == 'EXTENDED') or ( $export_fields == 'EXTENDED_2')) {
                        $stmt = "SELECT vl.call_date,vl.phone_number,vl.status,vl.user,vu.full_name,vl.campaign_id,vi.vendor_lead_code,vi.source_id,vi.list_id,vi.gmt_offset_now,vi.phone_code,vi.phone_number,vi.title,vi.first_name,vi.middle_initial,vi.last_name,vi.address1,vi.address2,vi.address3,vi.city,vi.state,vi.province,vi.postal_code,vi.country_code,vi.gender,vi.date_of_birth,vi.alt_phone,vi.email,vi.security_phrase,vi.comments,vl.length_in_sec,vl.user_group,vl.alt_dial,vi.rank,vi.owner,vi.lead_id,vl.uniqueid,vi.entry_list_id, ifnull(val.dispo_sec+val.dead_sec,0)$export_fields_SQL FROM vicidial_users vu,vicidial_list vi," . $vicidial_log_table . " vl LEFT OUTER JOIN " . $vicidial_agent_log_table . " val ON vl.uniqueid=val.uniqueid and vl.lead_id=val.lead_id and vl.user=val.user WHERE vl.call_date >= '$query_date 00:00:00' AND vl.call_date <= '$end_date 23:59:59' AND vu.user=vl.user AND vi.lead_id=vl.lead_id $list_SQL $campaign_SQL $user_group_SQL $status_SQL ORDER BY vl.call_date limit 100000;";
                    } else {
                        $stmt = "SELECT vl.call_date,vl.phone_number,vl.status,vl.user,vu.full_name,vl.campaign_id,vi.vendor_lead_code,vi.source_id,vi.list_id,vi.gmt_offset_now,vi.phone_code,vi.phone_number,vi.title,vi.first_name,vi.middle_initial,vi.last_name,vi.address1,vi.address2,vi.address3,vi.city,vi.state,vi.province,vi.postal_code,vi.country_code,vi.gender,vi.date_of_birth,vi.alt_phone,vi.email,vi.security_phrase,vi.comments,vl.length_in_sec,vl.user_group,vl.alt_dial,vi.rank,vi.owner,vi.lead_id,vl.uniqueid,vi.entry_list_id$export_fields_SQL FROM vicidial_users vu," . $vicidial_log_table . " vl,vicidial_list vi WHERE vl.call_date >= '$query_date 00:00:00' and vl.call_date <= '$end_date 23:59:59' AND vu.user=vl.user AND vi.lead_id=vl.lead_id $list_SQL $campaign_SQL $user_group_SQL $status_SQL ORDER BY vl.call_date limit 100000;";
                    }
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $outbound_to_print = $query->num_rows();
                    if (($outbound_to_print < 1) and ( $RUNgroup < 1)) {
                        $this->data['result'] = "There are no outbound calls during this time period for these parameters.";
                    } else {
                        $i = 0;
                        $LOGadmin_hide_lead_data = 0;
                        $LOGadmin_hide_phone_data = 0;
                        while ($i < $outbound_to_print) {
                            $row = array_values($result[$i]);
                            $row[29] = preg_replace("/\n|\r/", '!N', $row[29]);
                            $export_status[$k] = $row[2];
                            $export_list_id[$k] = $row[8];
                            $export_lead_id[$k] = $row[35];
                            $export_uniqueid[$k] = $row[36];
                            $export_vicidial_id[$k] = $row[36];
                            $export_entry_list_id[$k] = isset($row[37]) ? $row[37] : '';
                            $export_wrapup_time[$k] = isset($row[38]) ? $row[38] : '';
                            $export_queue_time[$k] = 0;

                            if ($LOGadmin_hide_phone_data != '0') {
                                $phone_temp = $row[1];
                                if (strlen($phone_temp) > 0) {
                                    if ($LOGadmin_hide_phone_data == '4_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 4)) . substr($phone_temp, -4, 4);
                                    } elseif ($LOGadmin_hide_phone_data == '3_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 3)) . substr($phone_temp, -3, 3);
                                    } elseif ($LOGadmin_hide_phone_data == '2_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 2)) . substr($phone_temp, -2, 2);
                                    } else {
                                        $row[1] = preg_replace("/./", 'X', $phone_temp);
                                    }
                                }
                            }
                            if ($LOGadmin_hide_lead_data != '0') {
                                if ($DB > 0) {
                                    echo "HIDELEADDATA|$row[6]|$row[7]|$row[12]|$row[13]|$row[14]|$row[15]|$row[16]|$row[17]|$row[18]|$row[19]|$row[20]|$row[21]|$row[22]|$row[26]|$row[27]|$row[28]|$LOGadmin_hide_lead_data|\n";
                                }
                                if (strlen($row[6]) > 0) {
                                    $data_temp = $row[6];
                                    $row[6] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[7]) > 0) {
                                    $data_temp = $row[7];
                                    $row[7] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[12]) > 0) {
                                    $data_temp = $row[12];
                                    $row[12] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[13]) > 0) {
                                    $data_temp = $row[13];
                                    $row[13] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[14]) > 0) {
                                    $data_temp = $row[14];
                                    $row[14] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[15]) > 0) {
                                    $data_temp = $row[15];
                                    $row[15] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[16]) > 0) {
                                    $data_temp = $row[16];
                                    $row[16] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[17]) > 0) {
                                    $data_temp = $row[17];
                                    $row[17] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[18]) > 0) {
                                    $data_temp = $row[18];
                                    $row[18] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[19]) > 0) {
                                    $data_temp = $row[19];
                                    $row[19] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[20]) > 0) {
                                    $data_temp = $row[20];
                                    $row[20] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[21]) > 0) {
                                    $data_temp = $row[21];
                                    $row[21] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[22]) > 0) {
                                    $data_temp = $row[22];
                                    $row[22] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[26]) > 0) {
                                    $data_temp = $row[26];
                                    $row[26] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[27]) > 0) {
                                    $data_temp = $row[27];
                                    $row[27] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[28]) > 0) {
                                    $data_temp = $row[28];
                                    $row[28] = preg_replace("/./", 'X', $data_temp);
                                }
                            }
                            ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                            for ($t = 0; $t < count($row); $t++) {
                                $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                            }
                            $export_fieldsDATA = '';
                            if ($export_fields == 'ALTERNATE_1') {
                                $ALTcall_date = $row[0];
                                $LASTcall_date = isset($row[39]) ? $row[39] : '';
                                $ALTcall_date = preg_replace("/-| |:|\d\d$/", '', $ALTcall_date);
                                $LASTcall_date = preg_replace("/-| |:|\d\d$/", '', $LASTcall_date);
                                $export_fieldsDATA = "$row[38],$LASTcall_date,";
                                $export_rows[$k] = "$ALTcall_date,$row[1],$row[2],$row[5],$row[6],$row[7],$row[13],$row[15],$row[30],$export_fieldsDATA";
                            } else {
                                $row[39] = isset($row[39]) ? $row[39] : '';
                                $row[40] = isset($row[40]) ? $row[40] : '';
                                $row[41] = isset($row[41]) ? $row[41] : '';
                                $row[42] = isset($row[42]) ? $row[42] : '';
                                $row[43] = isset($row[43]) ? $row[43] : '';
                                $row[44] = isset($row[44]) ? $row[44] : '';
                                if ($export_fields == 'EXTENDED') {
                                    $export_fieldsDATA = "$row[39],$row[40],$row[41],$row[42],$row[43],";
                                }
                                if ($export_fields == 'EXTENDED_2') {
                                    $export_fieldsDATA = "$row[39],$row[40],$row[41],$row[42],$row[43],$row[44],";
                                }
                                $agencyName = '';
                                $agentName = '';
                                if(strlen($row[3]) > 0){
                                    $vUser = $this->vusers_m->get_by(array('user' => $row[3]),TRUE);
                                    $vUserId = $vUser->user_id;
                                    $stmt = "SELECT * FROM agents WHERE vicidial_user_id={$vUserId}";
                                    $aResult = $this->db->query($stmt)->row();
                                    if($aResult){
                                        $agentName = $aResult->fname.' '.$aResult->lname;
                                        $agencyId = $aResult->agency_id;
                                        $stmt = "SELECT * FROM agencies WHERE id={$agencyId}";
                                        $agResult = $this->db->query($stmt)->row();
                                        if($agResult){
                                            $agencyName = $agResult->name;
                                        }
                                    }
                                }
                                $export_rows[$k] = "$row[0],$row[1],$row[2],$row[3],$agencyName,$agentName,$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[1],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$row[17],$row[18],$row[19],$row[20],$row[21],$row[22],$row[23],$row[24],$row[25],$row[26],$row[27],$row[28],$row[29],$row[30],$row[31],$row[32],$row[33],$row[34]";
                                if (strlen($export_fieldsDATA) > 0) {
                                    $export_rows[$k] .= ',' . $export_fieldsDATA;
                                }
                            }
                            $k++;
                            $outbound_calls++;
                            $i++;
                        } //while($i < $outbound_to_print){
                    }
                }
                if ($RUNgroup > 0) {
                    if (($export_fields == 'EXTENDED') or ( $export_fields == 'EXTENDED_2')) {
                        $stmtA = "SELECT vl.call_date,vl.phone_number,vl.status,vl.user,vu.full_name,vl.campaign_id,vi.vendor_lead_code,vi.source_id,vi.list_id,vi.gmt_offset_now,vi.phone_code,vi.phone_number,vi.title,vi.first_name,vi.middle_initial,vi.last_name,vi.address1,vi.address2,vi.address3,vi.city,vi.state,vi.province,vi.postal_code,vi.country_code,vi.gender,vi.date_of_birth,vi.alt_phone,vi.email,vi.security_phrase,vi.comments,vl.length_in_sec,vl.user_group,vl.queue_seconds,vi.rank,vi.owner,vi.lead_id,vl.closecallid,vi.entry_list_id,vl.uniqueid, ifnull(val.dispo_sec+val.dead_sec,0)$export_fields_SQL FROM vicidial_users vu,vicidial_list vi," . $vicidial_closer_log_table . " vl LEFT OUTER JOIN " . $vicidial_agent_log_table . " val ON vl.uniqueid=val.uniqueid and vl.lead_id=val.lead_id AND vl.user=val.user WHERE vl.call_date >= '$query_date 00:00:00' AND vl.call_date <= '$end_date 23:59:59' AND vu.user=vl.user AND vi.lead_id=vl.lead_id $list_SQL $group_SQL $user_group_SQL $status_SQL ORDER BY vl.call_date limit 100000;";
                    } else {
                        $stmtA = "SELECT vl.call_date,vl.phone_number,vl.status,vl.user,vu.full_name,vl.campaign_id,vi.vendor_lead_code,vi.source_id,vi.list_id,vi.gmt_offset_now,vi.phone_code,vi.phone_number,vi.title,vi.first_name,vi.middle_initial,vi.last_name,vi.address1,vi.address2,vi.address3,vi.city,vi.state,vi.province,vi.postal_code,vi.country_code,vi.gender,vi.date_of_birth,vi.alt_phone,vi.email,vi.security_phrase,vi.comments,vl.length_in_sec,vl.user_group,vl.queue_seconds,vi.rank,vi.owner,vi.lead_id,vl.closecallid,vi.entry_list_id,vl.uniqueid$export_fields_SQL FROM vicidial_users vu," . $vicidial_closer_log_table . " vl,vicidial_list vi where vl.call_date >= '$query_date 00:00:00' AND vl.call_date <= '$end_date 23:59:59' AND vu.user=vl.user AND vi.lead_id=vl.lead_id $list_SQL $group_SQL $user_group_SQL $status_SQL ORDER BY vl.call_date LIMIT 100000;";
                    }
                    $query = $this->vicidialdb->db->query($stmtA);
                    $result = $query->result_array();
                    $inbound_to_print = $query->num_rows();
                    if (($inbound_to_print < 1) && ( $outbound_calls < 1)) {
                        $this->data['result'] = "There are no inbound calls during this time period for these parameters.";
                    } else {
                        $i = 0;
                        while ($i < $inbound_to_print) {
                            $row = array_values($result[$i]);
                            $row[29] = preg_replace("/\n|\r/", '!N', $row[29]);
                            $export_status[$k] = $row[2];
                            $export_list_id[$k] = $row[8];
                            $export_lead_id[$k] = $row[35];
                            $export_vicidial_id[$k] = $row[36];
                            $export_entry_list_id[$k] = $row[37];
                            $export_uniqueid[$k] = isset($row[38]) ? $row[38] : '';
                            $export_wrapup_time[$k] = isset($row[39]) ? $row[39] : '';
                            $export_queue_time[$k] = $row[32];
                            if ($LOGadmin_hide_phone_data != '0') {
                                if ($DB > 0) {
                                    echo "HIDEPHONEDATA|$row[1]|$LOGadmin_hide_phone_data|\n";
                                }
                                $phone_temp = $row[1];
                                if (strlen($phone_temp) > 0) {
                                    if ($LOGadmin_hide_phone_data == '4_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 4)) . substr($phone_temp, -4, 4);
                                    } elseif ($LOGadmin_hide_phone_data == '3_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 3)) . substr($phone_temp, -3, 3);
                                    } elseif ($LOGadmin_hide_phone_data == '2_DIGITS') {
                                        $row[1] = str_repeat("X", (strlen($phone_temp) - 2)) . substr($phone_temp, -2, 2);
                                    } else {
                                        $row[1] = preg_replace("/./", 'X', $phone_temp);
                                    }
                                }
                            }
                            if ($LOGadmin_hide_lead_data != '0') {
                                if ($DB > 0) {
                                    echo "HIDELEADDATA|$row[6]|$row[7]|$row[12]|$row[13]|$row[14]|$row[15]|$row[16]|$row[17]|$row[18]|$row[19]|$row[20]|$row[21]|$row[22]|$row[26]|$row[27]|$row[28]|$LOGadmin_hide_lead_data|\n";
                                }
                                if (strlen($row[6]) > 0) {
                                    $data_temp = $row[6];
                                    $row[6] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[7]) > 0) {
                                    $data_temp = $row[7];
                                    $row[7] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[12]) > 0) {
                                    $data_temp = $row[12];
                                    $row[12] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[13]) > 0) {
                                    $data_temp = $row[13];
                                    $row[13] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[14]) > 0) {
                                    $data_temp = $row[14];
                                    $row[14] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[15]) > 0) {
                                    $data_temp = $row[15];
                                    $row[15] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[16]) > 0) {
                                    $data_temp = $row[16];
                                    $row[16] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[17]) > 0) {
                                    $data_temp = $row[17];
                                    $row[17] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[18]) > 0) {
                                    $data_temp = $row[18];
                                    $row[18] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[19]) > 0) {
                                    $data_temp = $row[19];
                                    $row[19] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[20]) > 0) {
                                    $data_temp = $row[20];
                                    $row[20] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[21]) > 0) {
                                    $data_temp = $row[21];
                                    $row[21] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[22]) > 0) {
                                    $data_temp = $row[22];
                                    $row[22] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[26]) > 0) {
                                    $data_temp = $row[26];
                                    $row[26] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[27]) > 0) {
                                    $data_temp = $row[27];
                                    $row[27] = preg_replace("/./", 'X', $data_temp);
                                }
                                if (strlen($row[28]) > 0) {
                                    $data_temp = $row[28];
                                    $row[28] = preg_replace("/./", 'X', $data_temp);
                                }
                            }
                            ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                            for ($t = 0; $t < count($row); $t++) {
                                $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                            }

                            $export_fieldsDATA = '';
                            if ($export_fields == 'ALTERNATE_1') {
                                $ALTcall_date = $row[0];
                                $LASTcall_date = $row[39];
                                $ALTcall_date = preg_replace("/-| |:|\d\d$/", '', $ALTcall_date);
                                $LASTcall_date = preg_replace("/-| |:|\d\d$/", '', $LASTcall_date);
                                $export_fieldsDATA = "$row[38],$LASTcall_date,";
                                $export_rows[$k] = "$ALTcall_date,$row[1],$row[2],$row[5],$row[6],$row[7],$row[13],$row[15],$row[30],$export_fieldsDATA";
                            } else {
                                $row[40] = isset($row[40]) ? $row[40] : '';
                                $row[41] = isset($row[41]) ? $row[41] : '';
                                $row[42] = isset($row[42]) ? $row[42] : '';
                                $row[43] = isset($row[43]) ? $row[43] : '';
                                $row[44] = isset($row[44]) ? $row[44] : '';
                                if ($export_fields == 'EXTENDED') {
                                    $export_fieldsDATA = "$row[40],$row[41],$row[42],$row[43],$row[44],";
                                }
                                if ($export_fields == 'EXTENDED_2') {
                                    $export_fieldsDATA = "$row[40],$row[41],$row[42],$row[43],$row[44],$row[45],";
                                }
                                $agencyName = '';
                                $agentName = '';
                                if(strlen($row[3]) > 0){
                                    $vUser = $this->vusers_m->get_by(array('user' => $row[3]),TRUE);
                                    $vUserId = $vUser->user_id;
                                    $stmt = "SELECT * FROM agents WHERE vicidial_user_id={$vUserId}";
                                    $aResult = $this->db->query($stmt)->row();
                                    if($aResult){
                                        $agentName = $aResult->fname.' '.$aResult->lname;
                                        $agencyId = $aResult->agency_id;
                                        $stmt = "SELECT * FROM agencies WHERE id={$agencyId}";
                                        $agResult = $this->db->query($stmt)->row();
                                        if($agResult){
                                            $agencyName = $agResult->name;
                                        }
                                    }
                                }
                                $export_rows[$k] = "$row[0],$row[1],$row[2],$row[3],$agencyName,$agentName,$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[1],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$row[17],$row[18],$row[19],$row[20],$row[21],$row[22],$row[23],$row[24],$row[25],$row[26],$row[27],$row[28],$row[29],$row[30],$row[31],$row[32],$row[33],$row[34]";
                                if (strlen($export_fieldsDATA) > 0) {
                                    $export_rows[$k] .= ',' . $export_fieldsDATA;
                                }
                            }
                            $k++;
                            $i++;
                        }
                    }
                }
                if (($outbound_to_print > 0) || ( $inbound_to_print > 0)) {
                    $TXTfilename = "EXPORT_CALL_REPORT_$FILE_TIME.csv";
                    // We'll be outputting a TXT file
                    header('Content-type: application/octet-stream');

                    // It will be called LIST_101_20090209-121212.txt
                    header("Content-Disposition: attachment; filename=\"$TXTfilename\"");
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    ob_clean();
                    flush();
                    if ($header_row == 'YES') {
                        $RFheader = '';
                        $NFheader = '';
                        $CFheader = '';
                        $IVRheader = '';
                        $EXheader = '';
                        if ($rec_fields == 'ID') {
                            $RFheader = ",recording_id";
                        }
                        if ($rec_fields == 'FILENAME') {
                            $RFheader = ",recording_filename";
                        }
                        if ($rec_fields == 'LOCATION') {
                            $RFheader = ",recording_location";
                        }
                        if ($rec_fields == 'ALL') {
                            $RFheader = ",recording_id,recording_filename,recording_location";
                        }
                        if (($export_fields == 'EXTENDED') || ( $export_fields == 'EXTENDED_2')) {
                            $EXheader = ",wrapup_time,queue_time,uniqueid,caller_code,server_ip,hangup_cause,dialstatus,channel,dial_time,answered_time,cpd_result,did_pattern,did_id,did_description";
                        }
                        if ($export_fields == 'ALTERNATE_1') {
                            $EXheader = ",caller_code";
                        }
                        if ($call_notes == 'YES') {
                            $NFheader = ",call_notes";
                        }
                        if ($ivr_export == 'YES') {
                            $IVRheader = ",ivr_path";
                            if ($export_fields == 'ALTERNATE_1') {
                                $IVRheader = ",ivr_path";
                            }
                        }
                        if (($custom_fields_enabled > 0) && ( $custom_fields == 'YES')) {
                            $CFheader = ",custom_fields";
                        }

                        if ($export_fields == 'ALTERNATE_1') {
                            echo "call_date,phone_number_dialed,status,campaign_id,vendor_lead_code,source_id,first_name,last_name,length_in_sec$EFheader$RFheader$EXheader$NFheader$IVRheader$CFheader\n";
                        } else {
                            echo "call_date,phone_number_dialed,status,user,Agency,CRM Agent,full_name,campaign_id,vendor_lead_code,source_id,list_id,gmt_offset_now,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,length_in_sec,user_group,alt_dial,rank,owner,lead_id$EFheader,list_name,list_description,status_name$RFheader$EXheader$NFheader$IVRheader$CFheader\n";
                        }
                    }
                    $i = 0;
                    while ($k > $i) {
                        $custom_data = '';
                        $ex_list_name = '';
                        $ex_list_description = '';
                        $stmt = "SELECT list_name,list_description FROM vicidial_lists WHERE list_id='$export_list_id[$i]';";
                        $queryinner = $this->vicidialdb->db->query($stmt);
                        $rslt = $queryinner->row_array();
                        $ex_list_ct = $queryinner->num_rows();
                        if ($ex_list_ct > 0) {
                            $row = array_values($rslt);
                            $ex_list_name = $row[0];
                            $ex_list_description = $row[1];
                        }
                        $ex_status_name = '';
                        $stmt = "SELECT status_name FROM vicidial_statuses WHERE status='$export_status[$i]';";
                        $queryinner = $this->vicidialdb->db->query($stmt);
                        $rslt = $queryinner->row_array();
                        $ex_list_ct = $queryinner->num_rows();
                        if ($ex_list_ct > 0) {
                            $row = array_values($rslt);
                            $ex_status_name = $row[0];
                        } else {
                            $stmt = "SELECT status_name FROM vicidial_campaign_statuses WHERE status='$export_status[$i]';";
                            $queryinner = $this->vicidialdb->db->query($stmt);
                            $rslt = $queryinner->row_array();
                            $ex_list_ct = $queryinner->num_rows();
                            if ($ex_list_ct > 0) {
                                $row = array_values($rslt);
                                $ex_status_name = $row[0];
                            }
                        }

                        $rec_data = '';
                        if (($rec_fields == 'ID') || ( $rec_fields == 'FILENAME') || ( $rec_fields == 'LOCATION') || ( $rec_fields == 'ALL')) {
                            $rec_id = '';
                            $rec_filename = '';
                            $rec_location = '';
                            $stmt = "SELECT recording_id,filename,location FROM " . $recording_log_table . " WHERE vicidial_id='$export_vicidial_id[$i]' ORDER BY recording_id desc LIMIT 10;";
                            $queryinner = $this->vicidialdb->db->query($stmt);
                            $rslt = $queryinner->row_array();
                            $recordings_ct = $queryinner->num_rows();
                            $u = 0;
                            while ($recordings_ct > $u) {
                                $row = array_values($rslt);

                                ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                for ($t = 0; $t < count($row); $t++) {
                                    $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                                }

                                $rec_id .= "$row[0],";
                                $rec_filename .= "$row[1],";
                                $rec_location .= "$row[2],";

                                $u++;
                            }
                            $rec_id = preg_replace("/.$/", '', $rec_id);
                            $rec_filename = preg_replace("/.$/", '', $rec_filename);
                            $rec_location = preg_replace("/.$/", '', $rec_location);

                            if ($rec_fields == 'ID') {
                                $rec_data = ",$rec_id";
                            }
                            if ($rec_fields == 'FILENAME') {
                                $rec_data = ",$rec_filename";
                            }
                            if ($rec_fields == 'LOCATION') {
                                $rec_data = ",$rec_location";
                            }
                            if ($rec_fields == 'ALL') {
                                $rec_data = ",$rec_id,$rec_filename,$rec_location";
                            }
                        }

                        $extended_data_a = '';
                        $extended_data_b = '';
                        $extended_data_c = '';
                        $extended_data_d = '';
                        $extended_data = '';

                        if ($export_fields == 'ALTERNATE_1') {
                            $extended_data = '';
                            if (strlen($export_uniqueid[$i]) > 0) {
                                $uniqueidTEST = $export_uniqueid[$i];
                                $uniqueidTEST = preg_replace('/\..*$/', '', $uniqueidTEST);
                                $stmt = "SELECT caller_code,server_ip FROM " . $vicidial_log_extended_table . " WHERE uniqueid LIKE \"$uniqueidTEST%\" AND lead_id='$export_lead_id[$i]' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $vle_ct = $queryinner->num_rows();
                                if ($vle_ct > 0) {
                                    $row = array_values($rslt);
                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    $row[0] = preg_replace('/\t/', ' -- ', $row[0]);

                                    $extended_data_a = "$row[0],";
                                    $export_call_id[$i] = $row[0];
                                }
                            }
                            if (strlen($extended_data_a) < 1) {
                                $extended_data_a = "";
                            }
                            $extended_data .= "$extended_data_a";
                        }

                        if (($export_fields == 'EXTENDED') || ( $export_fields == 'EXTENDED_2')) {
                            $extended_data = ",$export_wrapup_time[$i],$export_queue_time[$i],$export_uniqueid[$i]";

                            if (strlen($export_uniqueid[$i]) > 0) {
                                $uniqueidTEST = $export_uniqueid[$i];
                                $uniqueidTEST = preg_replace('/\..*$/', '', $uniqueidTEST);
                                $stmt = "SELECT caller_code,server_ip FROM " . $vicidial_log_extended_table . " WHERE uniqueid LIKE \"$uniqueidTEST%\" AND lead_id='$export_lead_id[$i]' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $vle_ct = $queryinner->num_rows();
                                $export_call_id = array();
                                if ($vle_ct > 0) {
                                    $row = array_values($rslt);
                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    for ($t = 0; $t < count($row); $t++) {
                                        $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                                    }

                                    $extended_data_a = ",$row[0],$row[1]";
                                    $export_call_id[$i] = $row[0];
                                } else {
                                    $export_call_id[$i] = '';
                                }

                                $stmt = "SELECT hangup_cause,dialstatus,channel,dial_time,answered_time FROM " . $vicidial_carrier_log_table . " WHERE uniqueid LIKE \"$uniqueidTEST%\" AND lead_id='$export_lead_id[$i]' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $vcarl_ct = $queryinner->num_rows();
                                if ($vcarl_ct > 0) {
                                    $row = array_values($rslt);

                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    for ($t = 0; $t < count($row); $t++) {
                                        $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                                    }

                                    $extended_data_b = ",$row[0],$row[1],$row[2],$row[3],$row[4]";
                                }

                                $stmt = "SELECT result FROM " . $vicidial_cpd_log_table . " WHERE callerid='" . $export_call_id[$i] . "' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $vcpdl_ct = $queryinner->num_rows();
                                if ($vcpdl_ct > 0) {
                                    $row = array_values($rslt);
                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    $row[0] = preg_replace('/\t/', ' -- ', $row[0]);
                                    $extended_data_c = ",$row[0]";
                                }

                                $stmt = "SELECT extension,did_id FROM " . $vicidial_did_log_table . " WHERE uniqueid='$export_uniqueid[$i]' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $vcdid_ct = $queryinner->num_rows();
                                if ($vcdid_ct > 0) {
                                    $row = array_values($rslt);

                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    for ($t = 0; $t < count($row); $t++) {
                                        $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                                    }

                                    $extended_data_d = ",$row[0],$row[1]";

                                    $stmt = "SELECT did_description FROM vicidial_inbound_dids WHERE did_id='$row[1]' LIMIT 1;";
                                    $queryinner = $this->vicidialdb->db->query($stmt);
                                    $rslt = $queryinner->row_array();
                                    $vcdidx_ct = $queryinner->num_rows();
                                    if ($vcdidx_ct > 0) {
                                        $row = array_values($rslt);
                                        ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                        $row[0] = preg_replace('/\t/', ' -- ', $row[0]);
                                        $extended_data_d .= ",$row[0]";
                                    } else {
                                        $extended_data_d .= ",";
                                    }
                                }
                            }
                            if (strlen($extended_data_a) < 1) {
                                $extended_data_a = "\t\t";
                            }
                            if (strlen($extended_data_b) < 1) {
                                $extended_data_b = "\t\t\t\t\t";
                            }
                            if (strlen($extended_data_c) < 1) {
                                $extended_data_c = "\t";
                            }
                            if (strlen($extended_data_d) < 1) {
                                $extended_data_d = "\t\t\t";
                            }
                            $extended_data .= "$extended_data_a$extended_data_b$extended_data_c$extended_data_d";
                        }
                        $notes_data = '';
                        if ($call_notes == 'YES') {
                            if (strlen($export_vicidial_id[$i]) > 0) {
                                $stmt = "SELECT call_notes FROM vicidial_call_notes WHERE vicidial_id='$export_vicidial_id[$i]' LIMIT 1;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $notes_ct = $queryinner->num_rows();
                                if ($notes_ct > 0) {
                                    $row = array_values($rslt);

                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    $row[0] = preg_replace('/\t/', ' -- ', $row[0]);

                                    $notes_data = $row[0];
                                }
                                $notes_data = preg_replace("/\r\n/", ' ', $notes_data);
                                $notes_data = preg_replace("/\n/", ' ', $notes_data);
                            }
                            $notes_data = ",$notes_data";
                        }

                        $ivr_data = '';
                        if ($ivr_export == 'YES') {
                            $ivr_path = '';
                            if (strlen($export_uniqueid[$i]) > 0) {
                                $IVRdelimiter = '|';
                                if ($export_fields == 'ALTERNATE_1') {
                                    $IVRdelimiter = '^';
                                }
                                $stmt = "SELECT menu_id,UNIX_TIMESTAMP(event_date) FROM " . $vicidial_outbound_ivr_log_table . " WHERE event_date >= '$query_date 00:00:00' AND event_date <= '$end_date 23:59:59' AND uniqueid='$export_uniqueid[$i]' ORDER BY event_date,menu_action desc;";
                                $queryinner = $this->vicidialdb->db->query($stmt);
                                $rslt = $queryinner->row_array();
                                $logs_to_print = $queryinner->num_rows();
                                $u = 0;
                                while ($u < $logs_to_print) {
                                    $row = array_values($rslt);

                                    ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                    $row[0] = preg_replace('/\t/', ' -- ', $row[0]);

                                    $ivr_path .= "$row[0]$IVRdelimiter";
                                    $u++;
                                }
                                $ivr_path = preg_replace("/\|$|\^$/", '', $ivr_path);
                            }
                            $ivr_data = ",$ivr_path";
                            if ($export_fields == 'ALTERNATE_1') {
                                $ivr_data = ",$ivr_path";
                            }
                        }

                        if (($custom_fields_enabled > 0) && ( $custom_fields == 'YES')) {
                            $CF_list_id = $export_list_id[$i];
                            if ($export_entry_list_id[$i] > 99) {
                                $CF_list_id = $export_entry_list_id[$i];
                            }
                            $stmt = "SHOW TABLES LIKE \"custom_$CF_list_id\";";
                            $queryinner = $this->vicidialdb->db->query($stmt);
                            $rslt = $queryinner->row_array();
                            $tablecount_to_print = $queryinner->num_rows();
                            if ($tablecount_to_print > 0) {
                                $column_list = '';
                                $encrypt_list = '';
                                $hide_list = '';
                                $stmt = "DESCRIBE custom_$CF_list_id;";
                                $queryA = $this->vicidialdb->db->query($stmt);
                                $columns_ct = $queryA->num_rows();
                                $rsltA = $queryA->result_array();
                                $u = 0;
                                while ($columns_ct > $u) {
                                    $row = array_values($rsltA[$u]);
                                    $column = $row[0];
                                    $column_list .= "$row[0],";
                                    $u++;
                                }
                                if ($columns_ct > 1) {
                                    $column_list = preg_replace("/lead_id,/", '', $column_list);
                                    $column_list = preg_replace("/,$/", '', $column_list);
                                    $column_list_array = explode(',', $column_list);
                                    if (preg_match("/cf_encrypt/", $active_modules)) {
                                        $enc_fields = 0;
                                        $stmt = "SELECT COUNT(*) FROM vicidial_lists_fields WHERE field_encrypt='Y' AND list_id='$CF_list_id';";
                                        $queryB = $this->vicidialdb->db->query($stmt);
                                        $enc_field_ct = $queryB->num_rows();
                                        if ($enc_field_ct > 0) {
                                            $row = array_values($queryB->row_array());
                                            $enc_fields = $row[0];
                                        }
                                        if ($enc_fields > 0) {
                                            $stmt = "SELECT field_label FROM vicidial_lists_fields WHERE field_encrypt='Y' AND list_id='$CF_list_id';";
                                            $queryC = $this->vicidialdb->db->query($stmt);
                                            $rslt = $queryC->result_array();
                                            $enc_field_ct = $queryC->num_rows();
                                            $r = 0;
                                            while ($enc_field_ct > $r) {
                                                $row = array_values($rslt[$r]);
                                                $encrypt_list .= "$row[0],";
                                                $r++;
                                            }
                                            $encrypt_list = ",$encrypt_list";
                                        }
                                        if ($LOGadmin_cf_show_hidden < 1) {
                                            $hide_fields = 0;
                                            $stmt = "SELECT count(*) FROM vicidial_lists_fields WHERE field_show_hide!='DISABLED' AND list_id='$CF_list_id';";
                                            $queryD = $this->vicidialdb->db->query($stmt);
                                            $hide_field_ct = $queryD->num_rows();
                                            if ($hide_field_ct > 0) {
                                                $row = array_values($queryD->row_array());
                                                $hide_fields = $row[0];
                                            }
                                            if ($hide_fields > 0) {
                                                $stmt = "SELECT field_label FROM vicidial_lists_fields WHERE field_show_hide!='DISABLED' AND list_id='$CF_list_id';";
                                                $queryE = $this->vicidialdb->db->query($stmt);
                                                $rslt = $queryE->result_array();
                                                $hide_field_ct = $queryE->num_rows();
                                                $r = 0;
                                                while ($hide_field_ct > $r) {
                                                    $row = array_values($rslt[$r]);
                                                    $hide_list .= "$row[0],";
                                                    $r++;
                                                }
                                                $hide_list = ",$hide_list";
                                            }
                                        }
                                    }
                                    $stmt = "SELECT $column_list FROM custom_$CF_list_id WHERE lead_id='$export_lead_id[$i]' LIMIT 1;";
                                    $queryE = $this->vicidialdb->db->query($stmt);
                                    $rslt = $queryE->row_array();
                                    $customfield_ct = $queryE->num_rows();
                                    if ($customfield_ct > 0) {
                                        $row = array_values($rslt);
                                        $t = 0;
                                        while ($columns_ct >= $t) {
                                            if ($enc_fields > 0) {
                                                $field_enc = '';
                                                $field_enc_all = '';
                                                if ($DB) {
                                                    echo "|$column_list|$encrypt_list|\n";
                                                }
                                                if ((preg_match("/,$column_list_array[$t],/", $encrypt_list)) && ( strlen($row[$t]) > 0)) {
                                                    exec("../agc/aes.pl --decrypt --text=$row[$t]", $field_enc);
                                                    $field_enc_ct = count($field_enc);
                                                    $k = 0;
                                                    while ($field_enc_ct > $k) {
                                                        $field_enc_all .= $field_enc[$k];
                                                        $k++;
                                                    }
                                                    $field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/", '', $field_enc_all);
                                                    $row[$t] = base64_decode($field_enc_all);
                                                }
                                            }
                                            if ((preg_match("/,$column_list_array[$t],/", $hide_list)) && ( strlen($row[$t]) > 0)) {
                                                $field_temp_val = $row[$t];
                                                $row[$t] = preg_replace("/./", 'X', $field_temp_val);
                                            }
                                            ### PARSE TAB CHARACTERS FROM THE DATA ITSELF
                                            $row[$t] = preg_replace('/\t/', ' -- ', $row[$t]);
                                            $custom_data .= ",$row[$t]";
                                            $t++;
                                        }
                                    }
                                }
                                $custom_data = preg_replace("/\r\n/", '!N', $custom_data);
                                $custom_data = preg_replace("/\n/", '!N', $custom_data);
                            }
                        }

                        if ($export_fields == 'ALTERNATE_1') {
                            echo "$export_rows[$i]$rec_data$extended_data$notes_data$ivr_data$custom_data\r\n";
                        } else {
                            echo "$export_rows[$i],$ex_list_name,$ex_list_description,$ex_status_name$rec_data$extended_data$notes_data$ivr_data$custom_data\r\n";
                        }
                        $i++;
                    }
                    $file_exported++;
                    exit;
                } else {
                    $this->data['result'] = "There are no calls during this time period for these parameters.";
                }
            } // if
        }
        $this->template->load($this->_template, 'dialer/report/calls', $this->data);
    }
    /**
     * [updateField description]
     * @return [type] [description]
     */
    public function updateField() {
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
        $this->load->model('vicidial/vingroup_m', 'vingroup_m');
        $this->load->model('vicidial/alists_m', 'alists_m');
        $campaigns = '';
        $userGroups = '';
        $inGroups = '';
        $list = '';
        $post = $this->input->post();
        if ($post){
            $id = decode_url($post['id']);
            if ($id) {
                $campaigns .= '<select style="min-height: 400px;" multiple name="campaign[]" class="form-control" id="campaigncall">';
                $userGroups .= '<select style="min-height: 400px;" multiple name="user_group[]" class="form-control" id="user_group">';
                $inGroups .= '<select style="min-height: 400px;" multiple name="group[]" id="groupcall" class="form-control">';
                $list .= '<select style="min-height: 400px;" multiple name="list_id[]" id="list_id" class="form-control">';
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
                        $userGroups .= '<option selected value="' . $group->user_group . '">' . $group->user_group . '</option>';
                    }
                } else {
                    $userGroups .= '<option>No user group found.</option>';
                }
                $this->vingroup_m->createTempTable();
                $temp = $this->vingroup_m->_temptable;
                $stmt = "SELECT * FROM {$temp} main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND sub.agency_id =".$id;
                $query = $this->db->query($stmt);
                $ingroups = $query->result();
                if($ingroups){
                    foreach($ingroups as $ingroup){
                        $inGroups .= '<option value="'.$ingroup->group_id.'">'.$ingroup->group_id.'-'.$ingroup->group_name.'</option>';
                    }
                }
                $lists = $this->alists_m->get_by(array('agency_id' => $id));
                if($lists){
                    foreach($lists as $l){
                        $list .= '<option value="'.$l->vicidial_list_id.'">'.$l->vicidial_list_id.'</option>';
                    }
                }
                $campaigns .= '</select>';
                $userGroups .= '</select>';
                $inGroups .= '</select>';
                $list .= '</select>';
                $output['success'] = TRUE;
                $output['campaign'] = $campaigns;
                $output['groups'] = $userGroups;
                $output['ingroups'] = $inGroups;
                $output['list'] = $list;
                return $this->output->set_content_type('application/json')->set_output(json_encode($output));
            }else{ //if($agenyId){
                if ($this->session->userdata('user')->group_name == 'Agency') {
                    $campaigns .= '<select style="min-height: 400px;" multiple name="campaign[]" class="form-control" id="campaigncall">';
                    $selected = 'selected="selected"';
                    $userGroups .= '<select style="min-height: 400px;" multiple name="user_group[]" class="form-control" id="user_group">';
                    $inGroups .= '<select  style="min-height: 400px;" multiple name="group[]" id="groupcall" class="form-control">';
                    $list .= '<select style="min-height: 400px;" multiple name="list_id[]" id="list_id" class="form-control">';
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
                            $userGroups .= '<option selected value="' . $group['user_group'] . '">' . $group['user_group'] . '</option>';
                        }
                    } else {
                        $userGroups .= '<option>No user group found.</option>';
                    }
                    $ingroups = $this->aingroup_m->query();
                    if($ingroups){
                        foreach($ingroups as $ingroup){
                            $inGroups .= '<option value="'.$ingroup->group_id.'">'.$ingroup->group_id.'-'.$ingroup->group_name.'</option>';
                        }
                    }
                    $lists = $this->vlists_m->queryForAgency();
                    if($lists){
                        foreach($lists as $l){
                            $list .= '<option value="'.$l->vicidial_list_id.'">'.$l->vicidial_list_id.'</option>';
                        }
                    }
                    $campaigns .= '</select>';
                    $userGroups .= '</select>';
                    $inGroups .= '</select>';
                    $list .= '</select>';
                    $output ['success'] = TRUE;
                    $output ['campaign'] = $campaigns;
                    $output ['groups'] = $userGroups;
                    $output['ingroups'] = $inGroups;
                    $output['list'] = $list;
                } else {
                    $campaigns .= '<select style="min-height: 400px;" multiple name="campaign[]" class="form-control" id="campaigncall">';
                    $selected = 'selected="selected"';
                    $userGroups .= '<select style="min-height: 400px;" multiple name="user_group[]" class="form-control" id="user_group">';
                    $inGroups .= '<select style="min-height: 400px;" multiple name="group[]" id="groupcall" class="form-control">';
                    $list .= '<select style="min-height: 400px;" multiple name="list_id[]" id="list_id" class="form-control">';
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
                            $userGroups .= '<option value="' . $group->user_group . '">' . $group->user_group . '</option>';
                        }
                    } else {
                        $userGroups .= '<option>No user group found.</option>';
                    }
                    $ingroups = $this->aingroup_m->query();
                    if($ingroups){
                        foreach($ingroups as $ingroup){
                            $inGroups .= '<option value="'.$ingroup['group_id'].'">'.$ingroup['group_id'].'-'.$ingroup['group_name'].'</option>';
                        }
                    }
                    $lists = $this->vlists_m->query();
                    if($lists){
                        foreach($lists as $l){
                            $list .= '<option value="'.$l['list_id'].'">'.$l['list_id'].'</option>';
                        }
                    }
                    $output ['success'] = TRUE;
                    $output ['campaign'] = $campaigns;
                    $output ['groups'] = $userGroups;
                    $output['ingroups'] = $inGroups;
                    $output['list'] = $list;
                }
                return $this->output->set_content_type('application/json')->set_output(json_encode($output));
            }
        }
    }

}
