<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Treport extends CI_Controller{
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
        $this->load->model('vicidial/indid_m','indid_m');
        $this->load->model('vicidial/ainded_m','ainded_m');
    }
    /**
     * get the indound report for both inbound group and inbound DID
     * @return null
     */
    public function inbound(){
        $get = $this->input->get();
        $this->data ['datatable'] = TRUE;
        $this->data ['model'] = TRUE;
        $this->data ['validation'] = TRUE;
        $this->data ['sweetAlert'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        if(isset($get['did']) && $get['did'] == 'yes'){
            $this->data ['listtitle'] = 'Inbound Report By DID';
            $this->data ['title'] = 'Inbound Report By DID';
            $this->data ['breadcrumb'] = "Inbound Report By DID";
            $this->data['did'] = $get;
            $this->data['ingroups'] = $this->ainded_m->query();
        }else{
            $this->data ['listtitle'] = 'Inbound Report';
            $this->data ['title'] = 'Inbound Report';
            $this->data ['breadcrumb'] = "Inbound Report";
            $this->data['ingroups'] = $this->aingroup_m->query();
        }
        $this->data ['agencies'] = $this->agency_model->get_nested();
        $MAIN = '';$ASCII_text = '';$CSV_text1 = '';$CSV_text2 = '';$CSV_text3 = '';$CSV_text4 = '';$CSV_text5 = '';$CSV_text6 = '';$CSV_text7 = '';$CSV_text7 = '';$CSV_text8 = '';$CSV_text9 = '';
        if($post = $this->input->post()){
            $this->data['postData'] = $post;
            $group = isset($post['group']) ? $post['group'] : '';
            $query_date = isset($post['query_date']) ? date('Y-m-d',  strtotime($post['query_date'])) : '';
            $end_date = isset($post['end_date']) ? date('Y-m-d',  strtotime($post['end_date'])) : '';
            $shift = 'ALL';
            $DID = isset($post['DID']) ? $post['DID'] : '';
            if(isset($get['did']) && $get['did'] == 'yes'){
                $DID = 'Y';
            }
            $EMAIL = isset($post['EMAIL']) ? $post['EMAIL'] : '';
            $file_download = isset($post['file_download']) ? $post['file_download'] : '';
            $search_archived_data = isset($post['search_archived_data']) ? $post['search_archived_data'] : '';
            $MT[0]='0';
            $report_name = 'Inbound Report';
            if ($DID=='Y'){$report_name = 'Inbound Report by DID';}
            $vicidial_did_log_table="vicidial_did_log";
            $vicidial_closer_log_table="vicidial_closer_log";
            $live_inbound_log_table="live_inbound_log";
            $LOGallowed_campaigns = '';
            $LOGallowed_reports = '';
            $LOGadmin_viewable_groups =	'';
            $LOGadmin_viewable_call_times = '';
            $LOGadmin_viewable_groupsSQL = '';
            $whereLOGadmin_viewable_groupsSQL = '';$time_BEGIN = '';$time_END = '';
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
            $NOW_DATE = date("Y-m-d");
            $NOW_TIME = date("Y-m-d H:i:s");
            $STARTtime = date("U");
            if (!isset($group)) {$group = '';}
            if (!isset($query_date)) {$query_date = $NOW_DATE;}
            if (!isset($end_date)) {$end_date = $NOW_DATE;}

            $stmt = "SELECT local_gmt FROM servers where active='Y' limit 1;";
            $query = $this->vicidialdb->db->query($stmt);
            $rslt = $query->row_array();
            $gmt_conf_ct = $query->num_rows();
            $dst = date("I");
            if ($gmt_conf_ct > 0){
                $row = array_values($rslt);
                $local_gmt =		$row[0];
                $epoch_offset =		(($local_gmt + $dst) * 3600);
            }

            $stmt = "select vsc_id,vsc_name from vicidial_status_categories;";
            $query = $this->vicidialdb->db->query($stmt);
            $rslt = $query->result_array();
            $statcats_to_print = $query->num_rows();
            $i = 0;
            while ($i < $statcats_to_print) {
                $row = array_values($rslt[$i]);
                $vsc_id[$i] = $row[0];
                $vsc_name[$i] = $row[1];
                $vsc_count[$i] = 0;
                $i++;
            }

            $stmt = "select group_id,group_name,8 from vicidial_inbound_groups where group_handling='PHONE' $LOGadmin_viewable_groupsSQL order by group_id;";
            if ($DID == 'Y') {
                $stmt = "select did_pattern,did_description,did_id from vicidial_inbound_dids $whereLOGadmin_viewable_groupsSQL order by did_pattern;";
            }
            if ($EMAIL == 'Y') {
                $stmt = "select email_account_id,email_account_name,email_account_id from vicidial_email_accounts $whereLOGadmin_viewable_groupsSQL order by email_account_id;";
                $stmt = "select group_id,group_name,8 from vicidial_inbound_groups where group_handling='EMAIL' $LOGadmin_viewable_groupsSQL order by group_id;";
            }
            $query = $this->vicidialdb->db->query($stmt);
            $groups_to_print = $query->num_rows();
            $result = $query->result_array();
            $i = 0;
            $LISTgroups[$i] = '---NONE---';
            $i++;
            $groups_to_print++;
            $groups_string = '|';
            $j = 0;
            while ($i < $groups_to_print){
                $row = array_values($result[$j]);
        	$LISTgroups[$i] = $row[0];
                $LISTgroup_names[$i] = $row[1];
                $LISTgroup_ids[$i] = $row[2];
                $groups_string .= "$LISTgroups[$i]|";
                $i++;$j++;
            } //while ($i < $groups_to_print){

            $i = 0;
            $group_string = '|';
            $group_ct = count($group);
            $group_SQL = '';$groupQS = '';
            while ($i < $group_ct) {
                if ( isset($group[$i]) && (strlen($group[$i]) > 0) && ( preg_match("/\|$group[$i]\|/", $groups_string))) {
                    $group_string .= "$group[$i]|";
                    $group_SQL .= "'$group[$i]',";
                    $groupQS .= "&group[]=$group[$i]";
                }
                $i++;
            }//while($i < $group_ct)
            if ((preg_match('/\s\-\-NONE\-\-\s/', $group_string) ) || ( $group_ct < 1)) {
                $group_SQL = "''";
            } else {
                $group_SQL = preg_replace('/,$/i', '', $group_SQL);
            }
            if (strlen($group_SQL)<3) {$group_SQL="''";}
            if ($groups_to_print < 1){
        	if ($EMAIL == 'Y') {
                    $MAIN.=_QXZ("PLEASE SELECT AN EMAIL ACCOUNT AND DATE RANGE ABOVE AND CLICK SUBMIT") . "\n";
                }
                if ($DID == 'Y') {
                    $MAIN.=_QXZ("PLEASE SELECT A DID AND DATE RANGE ABOVE AND CLICK SUBMIT") . "\n";
                } else {
                    $MAIN.=_QXZ("PLEASE SELECT AN IN-GROUP AND DATE RANGE ABOVE AND CLICK SUBMIT") . "\n";
                }
            }else{
                if ($shift == 'ALL') {
                    if (strlen($time_BEGIN) < 6) {
                        $time_BEGIN = "00:00:00";
                    }
                    if (isset($time_END) && strlen($time_END) < 6) {
                        $time_END = "23:59:59";
                    }
                }
                $query_date_BEGIN = "$query_date $time_BEGIN";
                $query_date_END = "$end_date $time_END";
                # Calculate first record in interval and last
                $time_BEGIN_array = explode(":", $time_BEGIN);
                $first_shift_record = (4 * $time_BEGIN_array[0]) + (ceil($time_BEGIN_array[1] / 15));
                $time_END_array = explode(":", $time_END);
                $last_shift_record = (4 * $time_END_array[0]) + (ceil($time_END_array[1] / 15));

                if ($EMAIL == 'Y') {
                    $MAIN.='<h4 class="bold">'._QXZ("Inbound Email Stats") . ": $group_string          $NOW_TIME        <a href=\"javascript:checkDownload(1)\">" . _QXZ("DOWNLOAD") . "</a></h4>";
                    $CSV_text1.="\"" . _QXZ("Inbound Call Stats") . ":\",\"$group_string\",\"$NOW_TIME\"\n";
                } else {
                    $MAIN.= '<h4 class="bold">'._QXZ("Inbound Call Stats") . ": $group_string          $NOW_TIME        <a href=\"javascript:checkDownload(1)\">" . _QXZ("Download") . "</a></h4>";
                    $CSV_text1.="\"" . _QXZ("Inbound Call Stats") . ":\",\"$group_string\",\"$NOW_TIME\"\n";
                }
                if ($DID=='Y'){
                    $unid_SQL = '';
                    $stmt = "select did_id from vicidial_inbound_dids where did_pattern IN($group_SQL) $LOGadmin_viewable_groupsSQL;";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $dids_to_print = $query->num_rows();
                    $i = 0;$did_SQL = '';
                    while($i < $dids_to_print){
                        $row = array_values($result[$i]);
                        $did_id[$i] = $row[0];
                        $did_SQL .= "'$row[0]',";
                        $i++;
                    }
                    $did_SQL = preg_replace('/,$/i', '',$did_SQL);
                    if(strlen($did_SQL)<3) {$did_SQL="''";}
                    $stmt = "select uniqueid from ".$vicidial_did_log_table." where did_id IN($did_SQL);";
                    $query = $this->vicidialdb->db->query($stmt);
                    $result = $query->result_array();
                    $unids_to_print = $query->num_rows();
                    $i = 0;
                    while ($i < $unids_to_print){
                        $row = array_values($result[$i]);
                        $unid_SQL .= "'$row[0]',";
                        $i++;
                    }
                    $unid_SQL = preg_replace('/,$/i', '',$unid_SQL);
                    if (strlen($unid_SQL)<3) {$unid_SQL="''";}
                } //if ($DID=='Y'){

                if ($group_ct > 1){
                    $ASCII_text.="<div class='responsive-table'><table class='table table-bordered'>";
                    $ASCII_text.="<caption class='text-center bold'>"._QXZ("MULTI-GROUP BREAKDOWN")."</caption>";
                    $CSV_text1.="\n\""._QXZ("MULTI-GROUP BREAKDOWN").":\"\n";
                    if ($EMAIL == 'Y') {
                        $ASCII_text.= '<tr>';
                        $ASCII_text.="<th>" . _QXZ("EMAIL", 20) . "</th><th>" . _QXZ("EMAILS", 7) . "</th><th>" . _QXZ("DROPS", 7) . "</th><th>" . _QXZ("DROP", 5) . " %<t/th><th> " . _QXZ("IVR", 7) . "</th>";
                        $ASCII_text.= '</tr>';
                        $CSV_text1.="\"" . _QXZ("EMAIL") . "\",\"" . _QXZ("CALLS") . "\",\"" . _QXZ("DROPS") . "\",\"" . _QXZ("DROP") . " %\",\"" . _QXZ("IVR") . "\"\n";
                    } else if ($DID == 'Y') {
                        $ASCII_text.= '<tr>';
                        $ASCII_text.="<th>" . _QXZ("DID", 20) . "</th><th>" . _QXZ("CALLS", 7) . "</th><th>" . _QXZ("DROPS", 7) . "</th><th>" . _QXZ("DROP", 5) . " %</th><th> " . _QXZ("IVR", 7) . "</th>";
                        $ASCII_text.= '</tr>';
                        $CSV_text1.="\"" . _QXZ("DID") . "\",\"" . _QXZ("CALLS") . "\",\"" . _QXZ("DROPS") . "\",\"" . _QXZ("DROP") . " %\",\"" . _QXZ("IVR") . "\"\n";
                    } else {
                        $ASCII_text.= '<tr>';
                        $ASCII_text.="<th>" . _QXZ("IN-GROUP", 20) . "</th><th>" . _QXZ("CALLS", 7) . "</th><th>" . _QXZ("DROPS", 7) . "</th><th>" . _QXZ("DROP", 5) . " %</th><th>" . _QXZ("IVR", 7) . "</th>";
                        $ASCII_text.= '</tr>';
                        $CSV_text1.="\"" . _QXZ("IN-GROUP") . "\",\"" . _QXZ("CALLS") . "\",\"" . _QXZ("DROPS") . "\",\"" . _QXZ("DROP") . " %\",\"" . _QXZ("IVR") . "\"\n";
                    }
                    $i = 0;$max_value = 0;
                    while($i < $group_ct){
                        $did_id[$i] = '0';
                        $DIDunid_SQL = '';
                        $stmt = "select did_id from vicidial_inbound_dids where did_pattern='$group[$i]';";
                        $query1 = $this->vicidialdb->db->query($stmt);
                        $result1 = $query1->row_array();
                        $Sdids_to_print = $query1->num_rows();
    		            if ($Sdids_to_print > 0) {
                            $row = array_values($result1);
                            $did_id[$i] = $row[0];
                        }
                        $stmt = "select uniqueid from ".$vicidial_did_log_table." where did_id='$did_id[$i]';";
                        $query1 = $this->vicidialdb->db->query($stmt);
                        $result1 = $query1->result_array();
                        $DIDunids_to_print = $query1->num_rows();
                        $k=0;
                        while ($k < $DIDunids_to_print){
                            $row = array_values($result1[$k]);
                            $DIDunid_SQL .= "'$row[0]',";
                            $k++;
                        }
                        $DIDunid_SQL = preg_replace('/,$/i', '',$DIDunid_SQL);
                        if (strlen($DIDunid_SQL)<3) {$DIDunid_SQL="''";}
                        $stmt = "select count(*),sum(length_in_sec) from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id='$group[$i]';";
                        if ($DID == 'Y'){
                            $stmt="select count(*),sum(length_in_sec) from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($DIDunid_SQL);";
			            }
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $row = array_values($rslt);

                        $stmt="select count(*) from ".$live_inbound_log_table." where start_time >= '$query_date_BEGIN' and start_time <= '$query_date_END' and comment_a='$group[$i]' and comment_b='START';";
                        if ($DID=='Y'){
                            $stmt="select count(*) from ".$live_inbound_log_table." where start_time >= '$query_date_BEGIN' and start_time <= '$query_date_END' and uniqueid IN($DIDunid_SQL);";
                        }
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $rowx = array_values($rslt);

		                $stmt = "select count(*),sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id='$group[$i]' and status IN('DROP','XDROP') and (length_in_sec <= 49999 or length_in_sec is null);";
                        if ($DID == 'Y') {
                            $stmt = "select count(*),sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status IN('DROP','XDROP') and (length_in_sec <= 49999 or length_in_sec is null) and uniqueid IN($DIDunid_SQL);";
                        }
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $rowy = array_values($rslt);
                        if ($row[0] > $max_value) {$max_value = $row[0];}
                        $groupDISPLAY = sprintf("%20s", $group[$i]);
                        $gTOTALcalls = sprintf("%7s", $row[0]);
                        $gIVRcalls = sprintf("%7s", $rowx[0]);
                        $gDROPcalls = sprintf("%7s", $rowy[0]);
                        $gDROPpercent = (MathZDC($gDROPcalls, $gTOTALcalls) * 100);
                        $gDROPpercent = round($gDROPpercent, 2);
                        $gDROPpercent = sprintf("%6s", $gDROPpercent);
                        $ASCII_text.= '<tr>';
                        $ASCII_text.="<td>$groupDISPLAY</td><td>$gTOTALcalls</td><td>$gDROPcalls</td><td>$gDROPpercent%</td><td>$gIVRcalls</td>";
                        $ASCII_text.= '</tr>';
                        $CSV_text1.="\"$groupDISPLAY\",\"$gTOTALcalls\",\"$gDROPcalls\",\"$gDROPpercent%\",\"$gIVRcalls\"\n";
                        $i++;
                    }//while($i < $group_ct){
                    $ASCII_text.="</table></div>";
                }//if ($group_ct > 1){
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                $MAIN.= '<h3 class="text-center bold">'._QXZ("Time range") . ": $query_date_BEGIN " . _QXZ("to") . " $query_date_END</h3>";
                $MAIN.="<h4 class='bold'>" . _QXZ("TOTALS") . "</h4>";
                $CSV_text1.="\n\""._QXZ("Time range").":\",\"$query_date_BEGIN\",\""._QXZ("to")."\",\"$query_date_END\"\n\n";
                $stmt = "select count(*),sum(length_in_sec) from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id IN($group_SQL);";
                if ($DID=='Y'){
                    $stmt="select count(*),sum(length_in_sec) from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL);";
                }
                $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                $row = array_values($rslt);
                $stmt = "select count(*),sum(queue_seconds) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id IN($group_SQL) and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL');";
                if ($DID == 'Y') {
                    $stmt = "select count(*),sum(queue_seconds) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL') and uniqueid IN($unid_SQL);";
                }
                $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                $rowy = array_values($rslt);
                $stmt = "select count(*) from " . $live_inbound_log_table . " where start_time >= '$query_date_BEGIN' and start_time <= '$query_date_END' and comment_a IN($group_SQL) and comment_b='START';";
                if ($DID == 'Y') {
                    $stmt = "select count(*) from " . $live_inbound_log_table . " where start_time >= '$query_date_BEGIN' and start_time <= '$query_date_END' and uniqueid IN($unid_SQL);";
                }
                $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                $rowx = array_values($rslt);
                $TOTALcalls = sprintf("%10s", $row[0]);
                $IVRcalls = sprintf("%10s", $rowx[0]);
                $TOTALsec = $row[1];

                $average_call_seconds = MathZDC($TOTALsec, $row[0]);
                $average_call_seconds = round($average_call_seconds, 0);
                $average_call_seconds = sprintf("%10s", $average_call_seconds);

                $ANSWEREDcalls = sprintf("%10s", $rowy[0]);

                $ANSWEREDpercent = (MathZDC($ANSWEREDcalls, $TOTALcalls) * 100);
                $ANSWEREDpercent = round($ANSWEREDpercent, 0);

                $average_answer_seconds = MathZDC($rowy[1], $rowy[0]);
                $average_answer_seconds = round($average_answer_seconds, 2);
                $average_answer_seconds = sprintf("%10s", $average_answer_seconds);
                $MAIN.= '<table class="table">';
                if ($EMAIL == 'Y') {
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Total Emails taken in to this In-Group:", 47).'</th>'.'<td>'."$TOTALcalls</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Average Email Length for all Emails:", 47) .'</th>'."<td>$average_call_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Answered Emails:", 47).'</th>'.'<td>'."$ANSWEREDcalls  $ANSWEREDpercent%</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Average queue time for Answered Emails:", 47).'</th>'.'<td>'."$average_answer_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Emails taken into the IVR for this In-Group:", 47).'</th>'.'<td>'."$IVRcalls</td>";
                    $MAIN.= '</tr>';

                    $CSV_text1.="\"" . _QXZ("Total Emails taken in to this In-Group") . ":\",\"$TOTALcalls\"\n";
                    $CSV_text1.="\"" . _QXZ("Average Email Length for all Emails") . ":\",\"$average_call_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Answered Emails") . ":\",\"$ANSWEREDcalls\",\"$ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"" . _QXZ("Average queue time for Answered Emails") . ":\",\"$average_answer_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Emails taken into the IVR for this In-Group") . ":\",\"$IVRcalls\"\n";
                } else {
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Total calls taken in to this In-Group:", 47) .'</th>'."<td>$TOTALcalls</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Average Call Length for all Calls:", 47).'</th>'."<td>$average_call_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Answered Calls:", 47) .'</th>'."<td>$ANSWEREDcalls  $ANSWEREDpercent%</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Average queue time for Answered Calls:", 47) .'</th>'."<td>$average_answer_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN.= '</tr>';
                    $MAIN.= '<tr>';
                    $MAIN.= '<th>'._QXZ("Calls taken into the IVR for this In-Group:", 47).'</th>'."<td>$IVRcalls</td>";
                    $MAIN.= '</tr>';
                    $CSV_text1.="\"" . _QXZ("Total calls taken in to this In-Group") . ":\",\"$TOTALcalls\"\n";
                    $CSV_text1.="\"" . _QXZ("Average Call Length for all Calls") . ":\",\"$average_call_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Answered Calls") . ":\",\"$ANSWEREDcalls\",\"$ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"" . _QXZ("Average queue time for Answered Calls") . ":\",\"$average_answer_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Calls taken into the IVR for this In-Group") . ":\",\"$IVRcalls\"\n";
                }
                $MAIN.= '</table>';
                $MAIN.="<h4 class='bold'>"._QXZ("DROPS")."</h4>";

                $CSV_text1.="\n\""._QXZ("DROPS")."\"\n";
                $stmt = "select count(*),sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id IN($group_SQL) and status IN('DROP','XDROP') and (length_in_sec <= 49999 or length_in_sec is null);";
                if ($DID == 'Y') {
                    $stmt = "select count(*),sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and status IN('DROP','XDROP') and (length_in_sec <= 49999 or length_in_sec is null) and uniqueid IN($unid_SQL);";
                }
                $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                $row = array_values($rslt);
                $DROPcalls = sprintf("%10s", $row[0]);
                $DROPpercent = (MathZDC($DROPcalls, $TOTALcalls) * 100);
                $DROPpercent = round($DROPpercent, 0);

                $average_hold_seconds = MathZDC($row[1], $row[0]);
                $average_hold_seconds = round($average_hold_seconds, 0);
                $average_hold_seconds = sprintf("%10s", $average_hold_seconds);

                $DROP_ANSWEREDpercent = (MathZDC($DROPcalls, $ANSWEREDcalls) * 100);
                $DROP_ANSWEREDpercent = round($DROP_ANSWEREDpercent, 0);
                $MAIN .= '<table class="table">';
                if ($EMAIL == 'Y') {
                    $MAIN .= '<tr>';
                    $MAIN.= '<th>'._QXZ("Total DROP Emails:", 47) . "$DROPcalls  $DROPpercent%</th><td>" . _QXZ("drop/answered") . ": $DROP_ANSWEREDpercent%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN.= '<th>'._QXZ("Average hold time for DROP Emails:", 47) .'</th><td>'."$average_hold_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $CSV_text1.="\"Total DROP Emails:\",\"$DROPcalls\",\"$DROPpercent%\",\"" . _QXZ("drop/answered") . ":\",\"$DROP_ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"Average hold time for DROP Emails:\",\"$average_hold_seconds " . _QXZ("seconds") . "\"\n";
                } else {
                    $MAIN .= '<tr>';
                    $MAIN.= '<th>'._QXZ("Total DROP Calls:", 47).'</th>' . "<td>$DROPcalls  $DROPpercent%</td><td>" . _QXZ("drop/answered") . ": $DROP_ANSWEREDpercent%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Average hold time for DROP Calls:", 47). "<th><td>$average_hold_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $CSV_text1.="\"" . _QXZ("Total DROP Calls") . ":\",\"$DROPcalls\",\"$DROPpercent%\",\"" . _QXZ("drop/answered") . ":\",\"$DROP_ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"" . _QXZ("Average hold time for DROP Calls") . ":\",\"$average_hold_seconds " . _QXZ("seconds") . "\"\n";
                }
                $MAIN .= '</table>';
                $Sanswer_sec_pct_rt_stat_one = ''; $PCTanswer_sec_pct_rt_stat_one = '';$Sanswer_sec_pct_rt_stat_two = '';$PCTanswer_sec_pct_rt_stat_two = '';
                if (strlen($group_SQL)>3){
                    if ($DID!='Y'){
        		$stmt = "SELECT answer_sec_pct_rt_stat_one,answer_sec_pct_rt_stat_two from vicidial_inbound_groups where group_id IN($group_SQL) order by answer_sec_pct_rt_stat_one desc limit 1;";
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $row = array_values($rslt);
                        $Sanswer_sec_pct_rt_stat_one = $row[0];
                        $Sanswer_sec_pct_rt_stat_two = $row[1];

                        $stmt = "SELECT count(*) from ".$vicidial_closer_log_table." where campaign_id IN($group_SQL) and call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and queue_seconds <= $Sanswer_sec_pct_rt_stat_one and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL');";
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $row = array_values($rslt);
                        $answer_sec_pct_rt_stat_one = $row[0];

                        $stmt = "SELECT count(*) from ".$vicidial_closer_log_table." where campaign_id IN($group_SQL) and call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and queue_seconds <= $Sanswer_sec_pct_rt_stat_two and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL');";
                        $rslt = $this->vicidialdb->db->query($stmt)->row_array();
                        $row = array_values($rslt);
                        $answer_sec_pct_rt_stat_two = $row[0];

                        $PCTanswer_sec_pct_rt_stat_one = (MathZDC($answer_sec_pct_rt_stat_one, $ANSWEREDcalls) * 100);
                        $PCTanswer_sec_pct_rt_stat_one = round($PCTanswer_sec_pct_rt_stat_one, 0);
                        #$PCTanswer_sec_pct_rt_stat_one = sprintf("%10s", $PCTanswer_sec_pct_rt_stat_one);
                        $PCTanswer_sec_pct_rt_stat_two = (MathZDC($answer_sec_pct_rt_stat_two, $ANSWEREDcalls) * 100);
                        $PCTanswer_sec_pct_rt_stat_two = round($PCTanswer_sec_pct_rt_stat_two, 0);
                        #$PCTanswer_sec_pct_rt_stat_two = sprintf("%10s", $PCTanswer_sec_pct_rt_stat_two);
                    }
                } //if (strlen($group_SQL)>3){
                if ($EMAIL == 'Y') {
                    $MAIN.="<h4 class='bold'>" . _QXZ("CUSTOM INDICATORS") . "</h4>";
                    $MAIN.="<table class='table'";
                    $MAIN.='<tr>';
                    $MAIN.="<th>GDE " . _QXZ("(Answered/Total emails taken in to this In-Group):", 50) . "</th><td>$ANSWEREDpercent%</td>";
                    $MAIN.='</tr>';
                    $MAIN.='<tr>';
                    $MAIN.="<th>ACR " . _QXZ("(Dropped/Answered):", 50) . "</th><td>$DROP_ANSWEREDpercent%</td>";
                    $MAIN.='</tr>';
                    $MAIN.= '</table>';
                    $CSV_text1.="\n\"" . _QXZ("CUSTOM INDICATORS") . "\"\n";
                    $CSV_text1.="\"GDE " . _QXZ("(Answered/Total emails taken in to this In-Group)") . ":\",\"$ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"ACR " . _QXZ("(Dropped/Answered)") . ":\",\"$DROP_ANSWEREDpercent%\"\n";
                } else {
                    $MAIN.="<h4 class='bold'>" . _QXZ("CUSTOM INDICATORS") . "</h4>";
                    $MAIN.='<table class="table">';
                    $MAIN.='<tr>';
                    $MAIN.="<th>GDE " . _QXZ("(Answered/Total calls taken in to this In-Group):", 50) . "</th><td>$ANSWEREDpercent%</td>";
                    $MAIN.='</tr>';
                    $MAIN.='<tr>';
                    $MAIN.="<th>ACR " . _QXZ("(Dropped/Answered):", 50) . "</th><td>$DROP_ANSWEREDpercent%</td>";
                    $MAIN.='</tr>';
                    $MAIN.='</table>';
                    $CSV_text1.="\n\"" . _QXZ("CUSTOM INDICATORS") . "\"\n";
                    $CSV_text1.="\"GDE " . _QXZ("(Answered/Total calls taken in to this In-Group)") . ":\",\"$ANSWEREDpercent%\"\n";
                    $CSV_text1.="\"ACR " . _QXZ("(Dropped/Answered)") . ":\",\"$DROP_ANSWEREDpercent%\"\n";
                }

                if ($DID != 'Y') {
                    $MAIN .= '<table class="table">';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'."TMR1 " . _QXZ("(Answered within %1s seconds/Answered):", 50, '', $Sanswer_sec_pct_rt_stat_one).'</th>'. "<td>$PCTanswer_sec_pct_rt_stat_one%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'."TMR2 " . _QXZ("(Answered within %1s seconds/Answered):", 50, '', $Sanswer_sec_pct_rt_stat_two) .'</th>'."<td>$PCTanswer_sec_pct_rt_stat_two%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '</table>';
                    $CSV_text1.="\"TMR1 " . _QXZ("(Answered within %1s seconds/Answered)", 0, '', $Sanswer_sec_pct_rt_stat_one) . ":\",\"$PCTanswer_sec_pct_rt_stat_one%\"\n";
                    $CSV_text1.="\"TMR2 " . _QXZ("(Answered within %1s seconds/Answered)", 0, '', $Sanswer_sec_pct_rt_stat_two) . ":\",\"$PCTanswer_sec_pct_rt_stat_two%\"\n";
                }
                # GET LIST OF ALL STATUSES and create SQL from human_answered statuses
                $q = 0;
                $stmt = "SELECT status,status_name,human_answered,category from vicidial_statuses;";
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $p = 0;
                while ($p < $statuses_to_print) {
                    $row = array_values($rslt[$p]);
                    $status[$q] = $row[0];
                    $status_name[$q] = $row[1];
                    $human_answered[$q] = $row[2];
                    $category[$q] = $row[3];
                    $statname_list["$status[$q]"] = "$status_name[$q]";
                    $statcat_list["$status[$q]"] = "$category[$q]";
                    $q++;
                    $p++;
                }
                $stmt = "SELECT status,status_name,human_answered,category from vicidial_campaign_statuses;";
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $p = 0;
                while ($p < $statuses_to_print) {
                    $row = array_values($rslt[$p]);
                    $status[$q] = $row[0];
                    $status_name[$q] = $row[1];
                    $human_answered[$q] = $row[2];
                    $category[$q] = $row[3];
                    $statname_list["$status[$q]"] = "$status_name[$q]";
                    $statcat_list["$status[$q]"] = "$category[$q]";
                    $q++;
                    $p++;
                }
                ##############################
                #########  CALL QUEUE STATS
                $MAIN.="<h4 class='bold'>"._QXZ("QUEUE STATS")."</h4>";

                $CSV_text1.="\n\""._QXZ("QUEUE STATS")."\"\n";
                $stmt = "select count(*),sum(queue_seconds) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id IN($group_SQL) and (queue_seconds > 0);";
                if ($DID == 'Y') {
                    $stmt = "select count(*),sum(queue_seconds) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and (queue_seconds > 0) and uniqueid IN($unid_SQL);";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->row_array();
                $row = array_values($rslt);
                $QUEUEcalls = sprintf("%10s", $row[0]);
                $QUEUEpercent = (MathZDC($QUEUEcalls, $TOTALcalls) * 100);
                $QUEUEpercent = round($QUEUEpercent, 0);

                $average_queue_seconds = MathZDC($row[1], $row[0]);
                $average_queue_seconds = round($average_queue_seconds, 2);
                $average_queue_seconds = sprintf("%10.2f", $average_queue_seconds);

                $average_total_queue_seconds = MathZDC($row[1], $TOTALcalls);
                $average_total_queue_seconds = round($average_total_queue_seconds, 2);
                $average_total_queue_seconds = sprintf("%10.2f", $average_total_queue_seconds);
                $MAIN .= '<table class="table"';
                if ($EMAIL == 'Y') {
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Total Emails That entered Queue:", 46) . "</th><td>$QUEUEcalls  $QUEUEpercent%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Average QUEUE Length for queue emails:", 46) . "</th><td>$average_queue_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Average QUEUE Length across all emails:", 46) . "</th><td>$average_total_queue_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $CSV_text1.="\"" . _QXZ("Total Emails That entered Queue") . ":\",\"$QUEUEcalls\",\"$QUEUEpercent%\"\n";
                    $CSV_text1.="\"" . _QXZ("Average QUEUE Length for queue emails") . ":\",\"$average_queue_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Average QUEUE Length across all emails") . ":\",\"$average_total_queue_seconds " . _QXZ("seconds") . "\"\n";
                } else {
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Total Calls That entered Queue:", 46).'</th>'."<td>$QUEUEcalls  $QUEUEpercent%</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Average QUEUE Length for queue calls:", 46).'</th>'."<td>$average_queue_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $MAIN .= '<tr>';
                    $MAIN .= '<th>'._QXZ("Average QUEUE Length across all calls:", 46).'</th>'. "<td>$average_total_queue_seconds " . _QXZ("seconds") . "</td>";
                    $MAIN .= '</tr>';
                    $CSV_text1.="\"" . _QXZ("Total Calls That entered Queue") . ":\",\"$QUEUEcalls\",\"$QUEUEpercent%\"\n";
                    $CSV_text1.="\"" . _QXZ("Average QUEUE Length for queue calls") . ":\",\"$average_queue_seconds " . _QXZ("seconds") . "\"\n";
                    $CSV_text1.="\"" . _QXZ("Average QUEUE Length across all calls") . ":\",\"$average_total_queue_seconds " . _QXZ("seconds") . "\"\n";
                }
                $MAIN .= '</table>';
                if ($EMAIL == 'Y') {
                    $rpt_type_verbiage = _QXZ("EMAIL", 6);
                    $rpt_type_verbiages = _QXZ("EMAILS", 6);
                } else {
                    $rpt_type_verbiage = _QXZ("CALL", 6);
                    $rpt_type_verbiages = _QXZ("CALLS", 6);
                }

                ##############################
                #########  CALL HOLD TIME BREAKDOWN IN SECONDS
                $TOTALcalls = 0;
                $ASCII_text .="<h4 class='bold'>$rpt_type_verbiage "._QXZ("HOLD TIME BREAKDOWN IN SECONDS",36)." <a href=\"javascript:checkDownload(2)\">"._QXZ("Download")."</a></h4>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= '<tr>';
                $ASCII_text .="<td>0</td><td>5</td><td>10</td><td>15</td><td>20</td><td>25</td><td>30</td><td>35</td><td>40</td><td>45</td><td>50</td><td>55</td><td>60</td><td>90</td><td>+90</td><td>TOTAL</td>";
                $ASCII_text .= '</tr>';
                $CSV_text2.="\n\"$rpt_type_verbiage "._QXZ("HOLD TIME BREAKDOWN IN SECONDS")."\"\n";
                $CSV_text2.="\"\",\"0\",\"5\",\"10\",\"15\",\"20\",\"25\",\"30\",\"35\",\"40\",\"45\",\"50\",\"55\",\"60\",\"90\",\"+90\",\"TOTAL\"\n";
                $stmt="select count(*),queue_seconds from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) group by queue_seconds;";
                if ($DID=='Y'){
                    $stmt="select count(*),queue_seconds from ".$vicidial_closer_log_table." where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) group by queue_seconds;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $reasons_to_print = $query->num_rows();
                $i=0; $hd_0 = 0;
                $hd_5=0; $hd10=0; $hd15=0; $hd20=0; $hd25=0; $hd30=0; $hd35=0; $hd40=0; $hd45=0; $hd50=0; $hd55=0; $hd60=0; $hd90=0; $hd99=0;
                while ($i < $reasons_to_print){
                    $row = array_values($rslt[$i]);
                    $TOTALcalls = ($TOTALcalls + $row[0]);
                    if ($row[1] == 0) {$hd_0 = ($hd_0 + $row[0]);}
                    if ( ($row[1] > 0) && ($row[1] <= 5) ) {$hd_5 = ($hd_5 + $row[0]);}
                    if ( ($row[1] > 5) && ($row[1] <= 10) ) {$hd10 = ($hd10 + $row[0]);}
                    if ( ($row[1] > 10) && ($row[1] <= 15) ) {$hd15 = ($hd15 + $row[0]);}
                    if ( ($row[1] > 15) && ($row[1] <= 20) ) {$hd20 = ($hd20 + $row[0]);}
                    if ( ($row[1] > 20) && ($row[1] <= 25) ) {$hd25 = ($hd25 + $row[0]);}
                    if ( ($row[1] > 25) && ($row[1] <= 30) ) {$hd30 = ($hd30 + $row[0]);}
                    if ( ($row[1] > 30) && ($row[1] <= 35) ) {$hd35 = ($hd35 + $row[0]);}
                    if ( ($row[1] > 35) && ($row[1] <= 40) ) {$hd40 = ($hd40 + $row[0]);}
                    if ( ($row[1] > 40) && ($row[1] <= 45) ) {$hd45 = ($hd45 + $row[0]);}
                    if ( ($row[1] > 45) && ($row[1] <= 50) ) {$hd50 = ($hd50 + $row[0]);}
                    if ( ($row[1] > 50) && ($row[1] <= 55) ) {$hd55 = ($hd55 + $row[0]);}
                    if ( ($row[1] > 55) && ($row[1] <= 60) ) {$hd60 = ($hd60 + $row[0]);}
                    if ( ($row[1] > 60) && ($row[1] <= 90) ) {$hd90 = ($hd90 + $row[0]);}
                    if ($row[1] > 90) {$hd99 = ($hd99 + $row[0]);}
                    $i++;
                } //while ($i < $reasons_to_print){
                $hd_0 = sprintf("%5s", $hd_0);
                $hd_5 = sprintf("%5s", $hd_5);
                $hd10 = sprintf("%5s", $hd10);
                $hd15 = sprintf("%5s", $hd15);
                $hd20 = sprintf("%5s", $hd20);
                $hd25 = sprintf("%5s", $hd25);
                $hd30 = sprintf("%5s", $hd30);
                $hd35 = sprintf("%5s", $hd35);
                $hd40 = sprintf("%5s", $hd40);
                $hd45 = sprintf("%5s", $hd45);
                $hd50 = sprintf("%5s", $hd50);
                $hd55 = sprintf("%5s", $hd55);
                $hd60 = sprintf("%5s", $hd60);
                $hd90 = sprintf("%5s", $hd90);
                $hd99 = sprintf("%5s", $hd99);
                $TOTALcalls = sprintf("%10s", $TOTALcalls);
                $ASCII_text .= '<tr>';
                $ASCII_text .= "<td>$hd_0</td><td>$hd_5</td><td>$hd10</td><td>$hd15</td><td>$hd20</td><td>$hd25</td><td>$hd30</td><td>$hd35</td><td>$hd40</td><td>$hd45</td><td>$hd50</td><td>$hd55</td><td>$hd60</td><td>$hd90</td><td>$hd99</td><td>$TOTALcalls</td>";
                $ASCII_text .= "</tr>";
                $ASCII_text .= '</table>';
                $CSV_text2.="\"\",\"$hd_0\",\"$hd_5\",\"$hd10\",\"$hd15\",\"$hd20\",\"$hd25\",\"$hd30\",\"$hd35\",\"$hd40\",\"$hd45\",\"$hd50\",\"$hd55\",\"$hd60\",\"$hd90\",\"$hd99\",\"$TOTALcalls\"\n";
                ##############################
                #########  CALL DROP TIME BREAKDOWN IN SECONDS
                $BDdropCALLS = 0;

                $ASCII_text .= "<h4 class='bold'>$rpt_type_verbiage " . _QXZ("DROP TIME BREAKDOWN IN SECONDS")."</h4>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= '<tr>';
                $ASCII_text .="<td>0</td><td>5</td><td>10</td><td>15</td><td>20</td><td>25</td><td>30</td><td>35</td><td>40</td><td>45</td><td>50</td><td>55</td><td>60</td><td>90</td><td>+90</td><td>" . _QXZ("TOTAL", 10) . "</td>";
                $ASCII_text .= '</tr>';

                $CSV_text2.="\n\"$rpt_type_verbiage " . _QXZ("DROP TIME BREAKDOWN IN SECONDS") . "\"\n";
                $CSV_text2.="\"\",\"0\",\"5\",\"10\",\"15\",\"20\",\"25\",\"30\",\"35\",\"40\",\"45\",\"50\",\"55\",\"60\",\"90\",\"+90\",\"" . _QXZ("TOTAL") . "\"\n";
                $stmt = "select count(*),queue_seconds from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) and status IN('DROP','XDROP') group by queue_seconds;";
                if ($DID == 'Y') {
                    $stmt = "select count(*),queue_seconds from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) and status IN('DROP','XDROP') group by queue_seconds;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $reasons_to_print = $query->num_rows();
                $i=0;
                $dd_0=0; $dd_5=0; $dd10=0; $dd15=0; $dd20=0; $dd25=0; $dd30=0; $dd35=0; $dd40=0; $dd45=0; $dd50=0; $dd55=0; $dd60=0; $dd90=0; $dd99=0;
                while ($i < $reasons_to_print){
                    $row = array_values($rslt[$i]);
                    $BDdropCALLS = ($BDdropCALLS + $row[0]);
                    if ($row[1] == 0) {
                        $dd_0 = ($dd_0 + $row[0]);
                    }
                    if (($row[1] > 0) && ( $row[1] <= 5)) {
                        $dd_5 = ($dd_5 + $row[0]);
                    }
                    if (($row[1] > 5) && ( $row[1] <= 10)) {
                        $dd10 = ($dd10 + $row[0]);
                    }
                    if (($row[1] > 10) && ( $row[1] <= 15)) {
                        $dd15 = ($dd15 + $row[0]);
                    }
                    if (($row[1] > 15) && ( $row[1] <= 20)) {
                        $dd20 = ($dd20 + $row[0]);
                    }
                    if (($row[1] > 20) && ( $row[1] <= 25)) {
                        $dd25 = ($dd25 + $row[0]);
                    }
                    if (($row[1] > 25) && ( $row[1] <= 30)) {
                        $dd30 = ($dd30 + $row[0]);
                    }
                    if (($row[1] > 30) && ( $row[1] <= 35)) {
                        $dd35 = ($dd35 + $row[0]);
                    }
                    if (($row[1] > 35) && ( $row[1] <= 40)) {
                        $dd40 = ($dd40 + $row[0]);
                    }
                    if (($row[1] > 40) && ( $row[1] <= 45)) {
                        $dd45 = ($dd45 + $row[0]);
                    }
                    if (($row[1] > 45) && ( $row[1] <= 50)) {
                        $dd50 = ($dd50 + $row[0]);
                    }
                    if (($row[1] > 50) && ( $row[1] <= 55)) {
                        $dd55 = ($dd55 + $row[0]);
                    }
                    if (($row[1] > 55) && ( $row[1] <= 60)) {
                        $dd60 = ($dd60 + $row[0]);
                    }
                    if (($row[1] > 60) && ( $row[1] <= 90)) {
                        $dd90 = ($dd90 + $row[0]);
                    }
                    if ($row[1] > 90) {
                        $dd99 = ($dd99 + $row[0]);
                    }
                    $i++;
                }
                $dd_0 = sprintf("%5s", $dd_0);
                $dd_5 = sprintf("%5s", $dd_5);
                $dd10 = sprintf("%5s", $dd10);
                $dd15 = sprintf("%5s", $dd15);
                $dd20 = sprintf("%5s", $dd20);
                $dd25 = sprintf("%5s", $dd25);
                $dd30 = sprintf("%5s", $dd30);
                $dd35 = sprintf("%5s", $dd35);
                $dd40 = sprintf("%5s", $dd40);
                $dd45 = sprintf("%5s", $dd45);
                $dd50 = sprintf("%5s", $dd50);
                $dd55 = sprintf("%5s", $dd55);
                $dd60 = sprintf("%5s", $dd60);
                $dd90 = sprintf("%5s", $dd90);
                $dd99 = sprintf("%5s", $dd99);

                $BDdropCALLS = sprintf("%10s", $BDdropCALLS);
                $ASCII_text .= '<tr>';
                $ASCII_text.="<td>$dd_0</td><td>$dd_5</td><td>$dd10</td><td>$dd15</td><td>$dd20</td><td>$dd25</td><td>$dd30</td><td>$dd35</td><td>$dd40</td><td>$dd45</td><td>$dd50</td><td>$dd55</td><td>$dd60</td><td>$dd90</td><td>$dd99</td><td>$BDdropCALLS</td>";
                $ASCII_text .= '</tr>';
                $ASCII_text .= "</table>";

                $CSV_text2.="\"\",\"$dd_0\",\"$dd_5\",\"$dd10\",\"$dd15\",\"$dd20\",\"$dd25\",\"$dd30\",\"$dd35\",\"$dd40\",\"$dd45\",\"$dd50\",\"$dd55\",\"$dd60\",\"$dd90\",\"$dd99\",\"$BDdropCALLS\"\n";
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                ##############################
                #########  CALL ANSWERED TIME AND PERCENT BREAKDOWN IN SECONDS

                $BDansweredCALLS = 0;

                $ASCII_text .= "<h4 class='bold'>$rpt_type_verbiage " . _QXZ("ANSWERED TIME AND PERCENT BREAKDOWN IN SECONDS") . "</h4>";
                $ASCII_text .= "<table class='table table-bordered'>";
                $ASCII_text .= '<tr>';
                $ASCII_text.="<td>&nbsp;</td><td>0</td><td>5</td><td>10</td><td>15</td><td>20</td><td>25</td><td>30</td><td>35</td><td>40</td><td>45</td><td>50</td><td>55</td><td>60</td><td>90</td><td>+90</td><td>" . _QXZ("TOTAL", 10) . "</td>";
                $ASCII_text .= '</tr>';

                $CSV_text2.="\n\"$rpt_type_verbiage " . _QXZ("ANSWERED TIME AND PERCENT BREAKDOWN IN SECONDS") . "\"\n";
                $CSV_text2.="\"\",\"0\",\"5\",\"10\",\"15\",\"20\",\"25\",\"30\",\"35\",\"40\",\"45\",\"50\",\"55\",\"60\",\"90\",\"+90\",\"" . _QXZ("TOTAL") . "\"\n";
                $stmt = "select count(*),queue_seconds from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL') group by queue_seconds;";
                if ($DID == 'Y') {
                    $stmt = "select count(*),queue_seconds from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) and status NOT IN('DROP','XDROP','HXFER','QVMAIL','HOLDTO','LIVE','QUEUE','TIMEOT','AFTHRS','NANQUE','INBND','MAXCAL') group by queue_seconds;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $reasons_to_print = $query->num_rows();
                $i=0;$ad_0 = 0;$ad_5 = 0;$ad10 = 0; $ad15 = 0;$ad20 = 0;$ad25 = 0;$ad30 = 0;$ad35 = 0;$ad40 = 0;$ad45 = 0;$ad50 = 0;$ad55 = 0; $ad60 = 0;$ad90 = 0;$ad99 = 0;

                while ($i < $reasons_to_print){
                    $row = array_values($rslt[$i]);
                    $BDansweredCALLS = ($BDansweredCALLS + $row[0]);
                    ### Get interval totals
                    if ($row[1] == 0) {
                        $ad_0 = ($ad_0 + $row[0]);
                    }
                    if (($row[1] > 0) && ( $row[1] <= 5)) {
                        $ad_5 = ($ad_5 + $row[0]);
                    }
                    if (($row[1] > 5) && ( $row[1] <= 10)) {
                        $ad10 = ($ad10 + $row[0]);
                    }
                    if (($row[1] > 10) && ( $row[1] <= 15)) {
                        $ad15 = ($ad15 + $row[0]);
                    }
                    if (($row[1] > 15) && ( $row[1] <= 20)) {
                        $ad20 = ($ad20 + $row[0]);
                    }
                    if (($row[1] > 20) && ( $row[1] <= 25)) {
                        $ad25 = ($ad25 + $row[0]);
                    }
                    if (($row[1] > 25) && ( $row[1] <= 30)) {
                        $ad30 = ($ad30 + $row[0]);
                    }
                    if (($row[1] > 30) && ( $row[1] <= 35)) {
                        $ad35 = ($ad35 + $row[0]);
                    }
                    if (($row[1] > 35) && ( $row[1] <= 40)) {
                        $ad40 = ($ad40 + $row[0]);
                    }
                    if (($row[1] > 40) && ( $row[1] <= 45)) {
                        $ad45 = ($ad45 + $row[0]);
                    }
                    if (($row[1] > 45) && ( $row[1] <= 50)) {
                        $ad50 = ($ad50 + $row[0]);
                    }
                    if (($row[1] > 50) && ( $row[1] <= 55)) {
                        $ad55 = ($ad55 + $row[0]);
                    }
                    if (($row[1] > 55) && ( $row[1] <= 60)) {
                        $ad60 = ($ad60 + $row[0]);
                    }
                    if (($row[1] > 60) && ( $row[1] <= 90)) {
                        $ad90 = ($ad90 + $row[0]);
                    }
                    if ($row[1] > 90) {
                        $ad99 = ($ad99 + $row[0]);
                    }
                    $i++;
                }
                ### Calculate cumulative totals
                $Cad_0 = $ad_0;
                $Cad_5 = ($Cad_0 + $ad_5);
                $Cad10 = ($Cad_5 + $ad10);
                $Cad15 = ($Cad10 + $ad15);
                $Cad20 = ($Cad15 + $ad20);
                $Cad25 = ($Cad20 + $ad25);
                $Cad30 = ($Cad25 + $ad30);
                $Cad35 = ($Cad30 + $ad35);
                $Cad40 = ($Cad35 + $ad40);
                $Cad45 = ($Cad40 + $ad45);
                $Cad50 = ($Cad45 + $ad50);
                $Cad55 = ($Cad50 + $ad55);
                $Cad60 = ($Cad55 + $ad60);
                $Cad90 = ($Cad60 + $ad90);
                $Cad99 = ($Cad90 + $ad99);
                ### Calculate interval percentages
                $pad_0=0; $pad_5=0; $pad10=0; $pad15=0; $pad20=0; $pad25=0; $pad30=0; $pad35=0; $pad40=0; $pad45=0; $pad50=0; $pad55=0; $pad60=0; $pad90=0; $pad99=0;
                $pCad_0=0; $pCad_5=0; $pCad10=0; $pCad15=0; $pCad20=0; $pCad25=0; $pCad30=0; $pCad35=0; $pCad40=0; $pCad45=0; $pCad50=0; $pCad55=0; $pCad60=0; $pCad90=0; $pCad99=0;
                $ApCad_0 = 0; $ApCad_5 = 0; $ApCad10 = 0;$ApCad15 = 0; $ApCad20=0; $ApCad25 = 0;$ApCad30 = 0;$ApCad35 = 0;$ApCad40 =0;$ApCad45 = 0;$ApCad50 = 0;$ApCad55 = 0;$ApCad60 = 0;$ApCad90= 0;$ApCad99= 0;
                if (($BDansweredCALLS > 0) && ( $TOTALcalls > 0)) {
                    $pad_0 = (MathZDC($ad_0, $TOTALcalls) * 100);$pad_0 = round($pad_0, 0);
                    $pad_5 = (MathZDC($ad_5, $TOTALcalls) * 100);$pad_5 = round($pad_5, 0);
                    $pad10 = (MathZDC($ad10, $TOTALcalls) * 100);$pad10 = round($pad10, 0);
                    $pad15 = (MathZDC($ad15, $TOTALcalls) * 100);$pad15 = round($pad15, 0);
                    $pad20 = (MathZDC($ad20, $TOTALcalls) * 100);$pad20 = round($pad20, 0);
                    $pad25 = (MathZDC($ad25, $TOTALcalls) * 100);$pad25 = round($pad25, 0);
                    $pad30 = (MathZDC($ad30, $TOTALcalls) * 100);$pad30 = round($pad30, 0);
                    $pad35 = (MathZDC($ad35, $TOTALcalls) * 100);$pad35 = round($pad35, 0);
                    $pad40 = (MathZDC($ad40, $TOTALcalls) * 100);$pad40 = round($pad40, 0);
                    $pad45 = (MathZDC($ad45, $TOTALcalls) * 100);$pad45 = round($pad45, 0);
                    $pad50 = (MathZDC($ad50, $TOTALcalls) * 100);$pad50 = round($pad50, 0);
                    $pad55 = (MathZDC($ad55, $TOTALcalls) * 100);$pad55 = round($pad55, 0);
                    $pad60 = (MathZDC($ad60, $TOTALcalls) * 100);$pad60 = round($pad60, 0);
                    $pad90 = (MathZDC($ad90, $TOTALcalls) * 100);$pad90 = round($pad90, 0);
                    $pad99 = (MathZDC($ad99, $TOTALcalls) * 100);$pad99 = round($pad99, 0);
                    $pCad_0 = (MathZDC($Cad_0, $TOTALcalls) * 100);$pCad_0 = round($pCad_0, 0);
                    $pCad_5 = (MathZDC($Cad_5, $TOTALcalls) * 100);$pCad_5 = round($pCad_5, 0);
                    $pCad10 = (MathZDC($Cad10, $TOTALcalls) * 100);$pCad10 = round($pCad10, 0);
                    $pCad15 = (MathZDC($Cad15, $TOTALcalls) * 100);$pCad15 = round($pCad15, 0);
                    $pCad20 = (MathZDC($Cad20, $TOTALcalls) * 100);$pCad20 = round($pCad20, 0);
                    $pCad25 = (MathZDC($Cad25, $TOTALcalls) * 100);$pCad25 = round($pCad25, 0);
                    $pCad30 = (MathZDC($Cad30, $TOTALcalls) * 100);$pCad30 = round($pCad30, 0);
                    $pCad35 = (MathZDC($Cad35, $TOTALcalls) * 100);$pCad35 = round($pCad35, 0);
                    $pCad40 = (MathZDC($Cad40, $TOTALcalls) * 100);$pCad40 = round($pCad40, 0);
                    $pCad45 = (MathZDC($Cad45, $TOTALcalls) * 100);$pCad45 = round($pCad45, 0);
                    $pCad50 = (MathZDC($Cad50, $TOTALcalls) * 100);$pCad50 = round($pCad50, 0);
                    $pCad55 = (MathZDC($Cad55, $TOTALcalls) * 100);$pCad55 = round($pCad55, 0);
                    $pCad60 = (MathZDC($Cad60, $TOTALcalls) * 100);$pCad60 = round($pCad60, 0);
                    $pCad90 = (MathZDC($Cad90, $TOTALcalls) * 100);$pCad90 = round($pCad90, 0);
                    $pCad99 = (MathZDC($Cad99, $TOTALcalls) * 100);$pCad99 = round($pCad99, 0);

                    $ApCad_0 = (MathZDC($Cad_0, $BDansweredCALLS) * 100);$ApCad_0 = round($ApCad_0, 0);
                    $ApCad_5 = (MathZDC($Cad_5, $BDansweredCALLS) * 100);$ApCad_5 = round($ApCad_5, 0);
                    $ApCad10 = (MathZDC($Cad10, $BDansweredCALLS) * 100);$ApCad10 = round($ApCad10, 0);
                    $ApCad15 = (MathZDC($Cad15, $BDansweredCALLS) * 100);$ApCad15 = round($ApCad15, 0);
                    $ApCad20 = (MathZDC($Cad20, $BDansweredCALLS) * 100);$ApCad20 = round($ApCad20, 0);
                    $ApCad25 = (MathZDC($Cad25, $BDansweredCALLS) * 100);$ApCad25 = round($ApCad25, 0);
                    $ApCad30 = (MathZDC($Cad30, $BDansweredCALLS) * 100);$ApCad30 = round($ApCad30, 0);
                    $ApCad35 = (MathZDC($Cad35, $BDansweredCALLS) * 100);$ApCad35 = round($ApCad35, 0);
                    $ApCad40 = (MathZDC($Cad40, $BDansweredCALLS) * 100);$ApCad40 = round($ApCad40, 0);
                    $ApCad45 = (MathZDC($Cad45, $BDansweredCALLS) * 100);$ApCad45 = round($ApCad45, 0);
                    $ApCad50 = (MathZDC($Cad50, $BDansweredCALLS) * 100);$ApCad50 = round($ApCad50, 0);
                    $ApCad55 = (MathZDC($Cad55, $BDansweredCALLS) * 100);$ApCad55 = round($ApCad55, 0);
                    $ApCad60 = (MathZDC($Cad60, $BDansweredCALLS) * 100);$ApCad60 = round($ApCad60, 0);

                    $ApCad90 = (MathZDC($Cad90, $BDansweredCALLS) * 100);$ApCad90 = round($ApCad90, 0);
                    $ApCad99 = (MathZDC($Cad99, $BDansweredCALLS) * 100);$ApCad99 = round($ApCad99, 0);
                }
                ### Format variables
                $ad_0 = sprintf("%5s", $ad_0);
                $ad_5 = sprintf("%5s", $ad_5);
                $ad10 = sprintf("%5s", $ad10);
                $ad15 = sprintf("%5s", $ad15);
                $ad20 = sprintf("%5s", $ad20);
                $ad25 = sprintf("%5s", $ad25);
                $ad30 = sprintf("%5s", $ad30);
                $ad35 = sprintf("%5s", $ad35);
                $ad40 = sprintf("%5s", $ad40);
                $ad45 = sprintf("%5s", $ad45);
                $ad50 = sprintf("%5s", $ad50);
                $ad55 = sprintf("%5s", $ad55);
                $ad60 = sprintf("%5s", $ad60);
                $ad90 = sprintf("%5s", $ad90);
                $ad99 = sprintf("%5s", $ad99);
                $Cad_0 = sprintf("%5s", $Cad_0);
                $Cad_5 = sprintf("%5s", $Cad_5);
                $Cad10 = sprintf("%5s", $Cad10);
                $Cad15 = sprintf("%5s", $Cad15);
                $Cad20 = sprintf("%5s", $Cad20);
                $Cad25 = sprintf("%5s", $Cad25);
                $Cad30 = sprintf("%5s", $Cad30);
                $Cad35 = sprintf("%5s", $Cad35);
                $Cad40 = sprintf("%5s", $Cad40);
                $Cad45 = sprintf("%5s", $Cad45);
                $Cad50 = sprintf("%5s", $Cad50);
                $Cad55 = sprintf("%5s", $Cad55);
                $Cad60 = sprintf("%5s", $Cad60);
                $Cad90 = sprintf("%5s", $Cad90);
                $Cad99 = sprintf("%5s", $Cad99);
                $pad_0 = sprintf("%4s", $pad_0) . '%';
                $pad_5 = sprintf("%4s", $pad_5) . '%';
                $pad10 = sprintf("%4s", $pad10) . '%';
                $pad15 = sprintf("%4s", $pad15) . '%';
                $pad20 = sprintf("%4s", $pad20) . '%';
                $pad25 = sprintf("%4s", $pad25) . '%';
                $pad30 = sprintf("%4s", $pad30) . '%';
                $pad35 = sprintf("%4s", $pad35) . '%';
                $pad40 = sprintf("%4s", $pad40) . '%';
                $pad45 = sprintf("%4s", $pad45) . '%';
                $pad50 = sprintf("%4s", $pad50) . '%';
                $pad55 = sprintf("%4s", $pad55) . '%';
                $pad60 = sprintf("%4s", $pad60) . '%';
                $pad90 = sprintf("%4s", $pad90) . '%';
                $pad99 = sprintf("%4s", $pad99) . '%';
                $pCad_0 = sprintf("%4s", $pCad_0) . '%';
                $pCad_5 = sprintf("%4s", $pCad_5) . '%';
                $pCad10 = sprintf("%4s", $pCad10) . '%';
                $pCad15 = sprintf("%4s", $pCad15) . '%';
                $pCad20 = sprintf("%4s", $pCad20) . '%';
                $pCad25 = sprintf("%4s", $pCad25) . '%';
                $pCad30 = sprintf("%4s", $pCad30) . '%';
                $pCad35 = sprintf("%4s", $pCad35) . '%';
                $pCad40 = sprintf("%4s", $pCad40) . '%';
                $pCad45 = sprintf("%4s", $pCad45) . '%';
                $pCad50 = sprintf("%4s", $pCad50) . '%';
                $pCad55 = sprintf("%4s", $pCad55) . '%';
                $pCad60 = sprintf("%4s", $pCad60) . '%';
                $pCad90 = sprintf("%4s", $pCad90) . '%';
                $pCad99 = sprintf("%4s", $pCad99) . '%';
                $ApCad_0 = sprintf("%4s", $ApCad_0) . '%';
                $ApCad_5 = sprintf("%4s", $ApCad_5) . '%';
                $ApCad10 = sprintf("%4s", $ApCad10) . '%';
                $ApCad15 = sprintf("%4s", $ApCad15) . '%';
                $ApCad20 = sprintf("%4s", $ApCad20) . '%';
                $ApCad25 = sprintf("%4s", $ApCad25) . '%';
                $ApCad30 = sprintf("%4s", $ApCad30) . '%';
                $ApCad35 = sprintf("%4s", $ApCad35) . '%';
                $ApCad40 = sprintf("%4s", $ApCad40) . '%';
                $ApCad45 = sprintf("%4s", $ApCad45) . '%';
                $ApCad50 = sprintf("%4s", $ApCad50) . '%';
                $ApCad55 = sprintf("%4s", $ApCad55) . '%';
                $ApCad60 = sprintf("%4s", $ApCad60) . '%';
                $ApCad90 = sprintf("%4s", $ApCad90) . '%';
                $ApCad99 = sprintf("%4s", $ApCad99) . '%';

                $BDansweredCALLS = sprintf("%10s", $BDansweredCALLS);
                ### Format and output
                $answeredTOTALs = "<td>$ad_0</td><td>$ad_5</td><td>$ad10</td><td>$ad15</td><td>$ad20</td><td>$ad25</td><td>$ad30</td><td>$ad35</td><td>$ad40</td><td>$ad45</td><td>$ad50</td><td>$ad55</td><td>$ad60</td><td>$ad90</td><td>$ad99</td><td>$BDansweredCALLS</td>";
                $answeredCUMULATIVE = "<td>$Cad_0</td><td>$Cad_5</td><td>$Cad10</td><td>$Cad15</td><td>$Cad20</td><td>$Cad25</td><td>$Cad30</td><td>$Cad35</td><td>$Cad40</td><td>$Cad45</td><td>$Cad50</td><td>$Cad55</td><td>$Cad60</td><td>$Cad90</td><td>$Cad99</td><td>$BDansweredCALLS</td>";
                $answeredINT_PERCENT = "<td>$pad_0</td><td>$pad_5</td><td>$pad10</td><td>$pad15</td><td>$pad20</td><td>$pad25</td><td>$pad30</td><td>$pad35</td><td>$pad40</td><td>$pad45</td><td>$pad50</td><td>$pad55</td><td>$pad60</td><td>$pad90</td><td>$pad99</td><td>&nbsp;</td>";
                $answeredCUM_PERCENT = "<td>$pCad_0</td><td>$pCad_5</td><td>$pCad10</td><td>$pCad15</td><td>$pCad20</td><td>$pCad25</td><td>$pCad30</td><td>$pCad35</td><td>$pCad40</td><td>$pCad45</td><td>$pCad50</td><td>$pCad55</td><td>$pCad60</td><td>$pCad90</td><td>$pCad99</td><td>&nbsp;</td>";
                $answeredCUM_ANS_PERCENT = "<td>$ApCad_0</td><td>$ApCad_5</td><td>$ApCad10</td><td>$ApCad15</td><td>$ApCad20</td><td>$ApCad25</td><td>$ApCad30</td><td>$ApCad35</td><td>$ApCad40</td><td>$ApCad45</td><td>$ApCad50</td><td>$ApCad55</td><td>$ApCad60</td><td>$ApCad90</td><td>$ApCad99</td><td>&nbsp;</td>";
                $ASCII_text .= '<tr>';
                $ASCII_text .= "<th>"._QXZ("INTERVAL", 10) . "</th>$answeredTOTALs";
                $ASCII_text .= '</tr>';
                $ASCII_text .= '<tr>';
                $ASCII_text .= '<th>'._QXZ("INT", 8) . " %</th> $answeredINT_PERCENT\n";
                $ASCII_text .= '</tr>';
                $ASCII_text .= '<tr>';
                $ASCII_text .= '<th>'._QXZ("CUMULATIVE", 10) . "</th> $answeredCUMULATIVE\n";
                $ASCII_text .= '</tr>';
                $ASCII_text .= '<tr>';
                $ASCII_text .= '<th>'._QXZ("CUM", 8) . " %</th> $answeredCUM_PERCENT\n";
                $ASCII_text .= '</tr>';
                $ASCII_text .= '<tr>';
                $ASCII_text .= '<th>'._QXZ("CUM ANS", 8) . " %</th> $answeredCUM_ANS_PERCENT\n";
                $ASCII_text .= '</tr>';
                $ASCII_text .= "</table>";


                $CSV_text2.="\"" . _QXZ("INTERVAL") . "\",\"$ad_0\",\"$ad_5\",\"$ad10\",\"$ad15\",\"$ad20\",\"$ad25\",\"$ad30\",\"$ad35\",\"$ad40\",\"$ad45\",\"$ad50\",\"$ad55\",\"$ad60\",\"$ad90\",\"$ad99\",\"$BDansweredCALLS\"\n";
                $CSV_text2.="\"" . _QXZ("INT") . " %\",\"$pad_0\",\"$pad_5\",\"$pad10\",\"$pad15\",\"$pad20\",\"$pad25\",\"$pad30\",\"$pad35\",\"$pad40\",\"$pad45\",\"$pad50\",\"$pad55\",\"$pad60\",\"$pad90\",\"$pad99\"\n";
                $CSV_text2.="\"" . _QXZ("CUMULATIVE") . "\",\"$Cad_0\",\"$Cad_5\",\"$Cad10\",\"$Cad15\",\"$Cad20\",\"$Cad25\",\"$Cad30\",\"$Cad35\",\"$Cad40\",\"$Cad45\",\"$Cad50\",\"$Cad55\",\"$Cad60\",\"$Cad90\",\"$Cad99\",\"$BDansweredCALLS\"\n";
                $CSV_text2.="\"" . _QXZ("CUM") . " %\",\"$pCad_0\",\"$pCad_5\",\"$pCad10\",\"$pCad15\",\"$pCad20\",\"$pCad25\",\"$pCad30\",\"$pCad35\",\"$pCad40\",\"$pCad45\",\"$pCad50\",\"$pCad55\",\"$pCad60\",\"$pCad90\",\"$pCad99\"\n";
                $CSV_text2.="\"" . _QXZ("CUM ANS") . " %\",\"$ApCad_0\",\"$ApCad_5\",\"$ApCad10\",\"$ApCad15\",\"$ApCad20\",\"$ApCad25\",\"$ApCad30\",\"$ApCad35\",\"$ApCad40\",\"$ApCad45\",\"$ApCad50\",\"$ApCad55\",\"$ApCad60\",\"$ApCad90\",\"$ApCad99\"\n";
                $MAIN.=$ASCII_text;

                ##############################
                #########  CALL HANGUP REASON STATS

                $TOTALcalls = 0;

                $ASCII_text.="<h4 class='bold'>$rpt_type_verbiage " . _QXZ("HANGUP REASON STATS", 25) . " <a href=\"javascript:checkDownload(3)\">" . _QXZ("Download") . "</a></h4>";
                $ASCII_text .= "<table class='table table-bordered'>";
                $ASCII_text .= "<tr>";
                $ASCII_text.="<th>" . _QXZ("HANGUP REASON", 20) . "</th><th>$rpt_type_verbiages</th>";
                $ASCII_text .= "</tr>";

                $CSV_text3.="\n\"$rpt_type_verbiage " . _QXZ("HANGUP REASON STATS") . "\"\n";
                $CSV_text3.="\"" . _QXZ("HANGUP REASON") . "\",\"$rpt_type_verbiages\"\n";

                $stmt = "select count(*),term_reason from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) group by term_reason order by term_reason;";
                if ($DID == 'Y') {
                    $stmt = "select count(*),term_reason from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) group by term_reason order by term_reason;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $reasons_to_print = $query->num_rows();
                $i = 0;
                while ($i < $reasons_to_print) {
                    $row = array_values($rslt[$i]);

                    $TOTALcalls = ($TOTALcalls + $row[0]);

                    $REASONcount = sprintf("%10s", $row[0]);
                    while (strlen($REASONcount) > 10) {
                        $REASONcount = substr("$REASONcount", 0, -1);
                    }
                    $reason = sprintf("%-20s", $row[1]);
                    while (strlen($reason) > 20) {
                        $reason = substr("$reason", 0, -1);
                    }
                    #if (preg_match('/NONE/',$reason)) {$reason = 'NO ANSWER           ';}
                    $ASCII_text .=  '<tr>';
                    $ASCII_text .= "<td>$reason</td><td>$REASONcount</td>";
                    $ASCII_text .=  '</tr>';
                    $CSV_text3  .= "\"$reason\",\"$REASONcount\"\n";

                    $i++;
                }
                $TOTALcalls = sprintf("%10s", $TOTALcalls);

                $ASCII_text .= "<tfoot><tr>";
                $ASCII_text .= "<td>" . _QXZ("TOTAL:", 20) . "<td>$TOTALcalls</td>";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= '</table>';
                $CSV_text3.="\"" . _QXZ("TOTAL") . ":\",\"$TOTALcalls\"\n";
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                ##############################
                #########  CALL STATUS STATS
                $TOTALcalls = 0;

                $ASCII_text.="<h4 class='bold'>$rpt_type_verbiage " . _QXZ("STATUS STATS", 18) . " <a href=\"javascript:checkDownload(4)\">" . _QXZ("DOWNLOAD") . "</a></h4>";
                $ASCII_text .= "<table class='table table-bordered'>";
                $ASCII_text .= '<tr>';
                $ASCII_text.="<th>" . _QXZ("STATUS", 6) . "</th><th>" . _QXZ("DESCRIPTION", 20) . "</th><th>" . _QXZ("CATEGORY", 20) . "</th><th>$rpt_type_verbiages</th><th>" . _QXZ("TOTAL TIME", 10) . "</th><th>" . _QXZ("AVG TIME", 8) . "</th><th>$rpt_type_verbiages/" . _QXZ("HOUR", 4) . "</th>";
                $ASCII_text .= '<tr>';

                $CSV_text4.="\n\"$rpt_type_verbiage "._QXZ("STATUS STATS")."\"\n";
                $CSV_text4.="\""._QXZ("STATUS")."\",\""._QXZ("DESCRIPTION")."\",\""._QXZ("CATEGORY")."\",\"$rpt_type_verbiages\",\""._QXZ("TOTAL TIME")."\",\""._QXZ("AVG TIME")."\",\"$rpt_type_verbiages/HOUR\"\n";
                ## get counts and time totals for all statuses in this campaign
                $stmt = "select count(*),status,sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) group by status;";
                if ($DID == 'Y') {
                    $stmt = "select count(*),status,sum(length_in_sec) from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) group by status;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $statuses_to_print = $query->num_rows();
                $i=0;$max_calls = 0;$max_total_time = 0;$max_avg_time = 0;$max_callshr = 0;
                while ($i < $statuses_to_print){
                    $row = array_values($rslt[$i]);
                    $STATUScount =	$row[0];
                    $RAWstatus =	$row[1];
                    $r=0;  $foundstat=0;
                    while ($r < $statcats_to_print) {
                        if (($statcat_list[$RAWstatus] == "$vsc_id[$r]") and ( $foundstat < 1)) {
                            $vsc_count[$r] = ($vsc_count[$r] + $STATUScount);
                        }
                        $r++;
                    }
                    $TOTALcalls = ($TOTALcalls + $row[0]);
                    $STATUSrate = (MathZDC($STATUScount, MathZDC($TOTALsec, 3600)) );
                    $STATUSrate = sprintf("%.2f", $STATUSrate);

                    $STATUShours = sec_convert($row[2], 'H');
                    $STATUSavg_sec = MathZDC($row[2], $STATUScount);
                    $STATUSavg = sec_convert($STATUSavg_sec, 'H');

                    if ($row[0]>$max_calls) {$max_calls=$row[0];}
                    if ($row[2]>$max_total_time) {$max_total_time=$row[2];}
                    if ($STATUSavg_sec>$max_avg_time) {$max_avg_time=$STATUSavg_sec;}
                    if ($STATUSrate>$max_callshr) {$max_callshr=$STATUSrate;}

                    $STATUScount =	sprintf("%10s", $row[0]);while(strlen($STATUScount)>10) {$STATUScount = substr("$STATUScount", 0, -1);}
                    $status =	sprintf("%-6s", $row[1]);while(strlen($status)>6) {$status = substr("$status", 0, -1);}
                    $STATUShours =	sprintf("%10s", $STATUShours);while(strlen($STATUShours)>10) {$STATUShours = substr("$STATUShours", 0, -1);}
                    $STATUSavg =	sprintf("%8s", $STATUSavg);while(strlen($STATUSavg)>8) {$STATUSavg = substr("$STATUSavg", 0, -1);}
                    $STATUSrate =	sprintf("%8s", $STATUSrate);while(strlen($STATUSrate)>8) {$STATUSrate = substr("$STATUSrate", 0, -1);}

                    $status_name =	sprintf("%-20s", $statname_list[$RAWstatus]);
                    while(strlen($status_name)>20) {$status_name = substr("$status_name", 0, -1);}
                    $statcat =	sprintf("%-20s", $statcat_list[$RAWstatus]);
                    while(strlen($statcat)>20) {$statcat = substr("$statcat", 0, -1);}
                    $ASCII_text .= "<tr>";
                    $ASCII_text .= "<td>$status</td><td>$status_name</td><td>$statcat</td><td>$STATUScount</td><td>$STATUShours</td><td>$STATUSavg</td><td>$STATUSrate</td>";
                    $ASCII_text .= "</tr>";
                    $CSV_text4.="\"$status\",\"$status_name\",\"$statcat\",\"$STATUScount\",\"$STATUShours\",\"$STATUSavg\",\"$STATUSrate\"\n";
                    $i++;
                }

                if ($TOTALcalls < 1) {
                    $TOTALhours = '0:00:00';
                    $TOTALavg = '0:00:00';
                    $TOTALrate = '0.00';
                } else {
                    $TOTALrate = MathZDC($TOTALcalls, MathZDC($TOTALsec, 3600));
                    $TOTALrate = sprintf("%.2f", $TOTALrate);

                    $TOTALhours = sec_convert($TOTALsec, 'H');
                    $TOTALavg_sec = MathZDC($TOTALsec, $TOTALcalls);
                    $TOTALavg = sec_convert($TOTALavg_sec, 'H');
                }

                $TOTALcalls = sprintf("%10s", $TOTALcalls);
                $TOTALhours = sprintf("%10s", $TOTALhours);
                while (strlen($TOTALhours) > 10) {
                    $TOTALhours = substr("$TOTALhours", 0, -1);
                }
                $TOTALavg = sprintf("%8s", $TOTALavg);
                while (strlen($TOTALavg) > 8) {
                    $TOTALavg = substr("$TOTALavg", 0, -1);
                }
                $TOTALrate = sprintf("%9s", $TOTALrate);
                while (strlen($TOTALrate) > 9) {
                    $TOTALrate = substr("$TOTALrate", 0, -1);
                }

                $ASCII_text.="<tfoot><tr>";
                $ASCII_text.="<td colspan='3'>" . _QXZ("TOTAL:", 52) . "</td><td>$TOTALcalls</td><td>$TOTALhours</td><td>$TOTALavg</td><td>$TOTALrate</td>";
                $ASCII_text.="</tr></tfoot>";
                $ASCII_text .= '</table>';

                $CSV_text4.="\""._QXZ("TOTAL").":\",\"\",\"\",\"$TOTALcalls\",\"$TOTALhours\",\"$TOTALavg\",\"$TOTALrate\"\n";
                $MAIN.=$ASCII_text;
                $ASCII_text = '';
                ##############################
                #########  STATUS CATEGORY STATS

                $ASCII_text.="<h4 class='bold'>" . _QXZ("CUSTOM STATUS CATEGORY STATS", 34) . " <a href=\"javascript:checkDownload(5)\">" . _QXZ("Download") . "</a></h4>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= '<tr>';
                $ASCII_text .= "<th>" . _QXZ("CATEGORY", 20) . "</th><th>$rpt_type_verbiages</th><th>" . _QXZ("DESCRIPTION", 30) . "</th>";
                $ASCII_text .= '</tr>';
                $CSV_text5.="\n\"" . _QXZ("CUSTOM STATUS CATEGORY STATS") . "\"\n";
                $CSV_text5.="\"" . _QXZ("CATEGORY") . "\",\"$rpt_type_verbiages\",\"" . _QXZ("DESCRIPTION") . "\"\n";

                $TOTCATcalls = 0;
                $r = 0;
                while ($r < $statcats_to_print) {
                    if ($vsc_id[$r] != 'UNDEFINED') {
                        $TOTCATcalls = ($TOTCATcalls + $vsc_count[$r]);
                        $category = sprintf("%-20s", $vsc_id[$r]);
                        while (strlen($category) > 20) {
                            $category = substr("$category", 0, -1);
                        }
                        $CATcount = sprintf("%10s", $vsc_count[$r]);
                        while (strlen($CATcount) > 10) {
                            $CATcount = substr("$CATcount", 0, -1);
                        }
                        $CATname = sprintf("%-30s", $vsc_name[$r]);
                        while (strlen($CATname) > 30) {
                            $CATname = substr("$CATname", 0, -1);
                        }
                        $ASCII_text .= '<tr>';
                        $ASCII_text.="<td>$category</td><td>$CATcount</td><td>$CATname</td>";
                        $ASCII_text .= '</tr>';
                        $CSV_text5.="\"$category\",\"$CATcount\",\"$CATname\"\n";
                    }

                    $r++;
                }
                $TOTCATcalls = sprintf("%10s", $TOTCATcalls);
                while (strlen($TOTCATcalls) > 10) {
                    $TOTCATcalls = substr("$TOTCATcalls", 0, -1);
                }
                $ASCII_text .= '<tfoot><tr>';
                $ASCII_text .= "<td>" . _QXZ("TOTAL", 20) . "</td><td colspan='2'>$TOTCATcalls</td>";
                $ASCII_text .= '</tr></tfoot>';
                $ASCII_text .= '</table>';
                $CSV_text5  .= "\"" . _QXZ("TOTAL") . "\",\"$TOTCATcalls\"\n";
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                ##############################
                #########  CALL INITIAL QUEUE POSITION BREAKDOWN
                $TOTALcalls = 0;
                $ASCII_text .= "<h4 class='bold'>$rpt_type_verbiage "._QXZ("INITIAL QUEUE POSITION BREAKDOWN",38)." <a href=\"javascript:checkDownload(6)\">"._QXZ("Download")."</a></h4>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= "<tr>";
                $ASCII_text .= "<th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th><th>15</th><th>20</th><th>25</th><th>+25</th><th>"._QXZ("TOTAL",10)."</th>";
                $ASCII_text .= "</tr>";

                $CSV_text6.="\n\"$rpt_type_verbiage "._QXZ("INITIAL QUEUE POSITION BREAKDOWN")."\"\n";
                $CSV_text6.="\"\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"15\",\"20\",\"25\",\"+25\",\""._QXZ("TOTAL")."\"\n";

                $stmt = "select count(*),queue_position from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) group by queue_position;";
                if ($DID == 'Y') {
                    $stmt = "select count(*),queue_position from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) group by queue_position;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $positions_to_print = $query->num_rows();
                $i=0;$qp_1 = 0;$qp_2 = 0; $qp_3 = 0;$qp_4 = 0;$qp_5 = 0;$qp_6 = 0;$qp_7 = 0;$qp_8 = 0;$qp_9 = 0;$qp10 = 0;$qp15 =0;$qp20 = 0;$qp25 = 0;$qp99 = 0;
                while ($i < $positions_to_print){
                    $row = array_values($rslt[$i]);

                    $TOTALcalls = ($TOTALcalls + $row[0]);

                    if ( ($row[1] > 0) && ($row[1] <= 1) ) {$qp_1 = ($qp_1 + $row[0]);}
                    if ( ($row[1] > 1) && ($row[1] <= 2) ) {$qp_2 = ($qp_2 + $row[0]);}
                    if ( ($row[1] > 2) && ($row[1] <= 3) ) {$qp_3 = ($qp_3 + $row[0]);}
                    if ( ($row[1] > 3) && ($row[1] <= 4) ) {$qp_4 = ($qp_4 + $row[0]);}
                    if ( ($row[1] > 4) && ($row[1] <= 5) ) {$qp_5 = ($qp_5 + $row[0]);}
                    if ( ($row[1] > 5) && ($row[1] <= 6) ) {$qp_6 = ($qp_6 + $row[0]);}
                    if ( ($row[1] > 6) && ($row[1] <= 7) ) {$qp_7 = ($qp_7 + $row[0]);}
                    if ( ($row[1] > 7) && ($row[1] <= 8) ) {$qp_8 = ($qp_8 + $row[0]);}
                    if ( ($row[1] > 8) && ($row[1] <= 9) ) {$qp_9 = ($qp_9 + $row[0]);}
                    if ( ($row[1] > 9) && ($row[1] <= 10) ) {$qp10 = ($qp10 + $row[0]);}
                    if ( ($row[1] > 10) && ($row[1] <= 15) ) {$qp15 = ($qp15 + $row[0]);}
                    if ( ($row[1] > 15) && ($row[1] <= 20) ) {$qp20 = ($qp20 + $row[0]);}
                    if ( ($row[1] > 20) && ($row[1] <= 25) ) {$qp25 = ($qp25 + $row[0]);}
                    if ($row[1] > 25) {$qp99 = ($qp99 + $row[0]);}
                    $i++;
                }
                $qp_1 =	sprintf("%5s", $qp_1);
                $qp_2 =	sprintf("%5s", $qp_2);
                $qp_3=	sprintf("%5s", $qp_3);
                $qp_4 =	sprintf("%5s", $qp_4);
                $qp_5 =	sprintf("%5s", $qp_5);
                $qp_6 =	sprintf("%5s", $qp_6);
                $qp_7 =	sprintf("%5s", $qp_7);
                $qp_8 =	sprintf("%5s", $qp_8);
                $qp_9 =	sprintf("%5s", $qp_9);
                $qp10 =	sprintf("%5s", $qp10);
                $qp15 =	sprintf("%5s", $qp15);
                $qp20 =	sprintf("%5s", $qp20);
                $qp25 =	sprintf("%5s", $qp25);
                $qp99 =	sprintf("%5s", $qp99);
                $TOTALcalls =		sprintf("%10s", $TOTALcalls);
                $ASCII_text .= '<tr>';
                $ASCII_text .= "<td>$qp_1</td><td>$qp_2</td><td>$qp_3</td><td>$qp_4</td><td>$qp_5</td><td>$qp_6</td><td>$qp_7</td><td>$qp_8</td><td>$qp_9</td><td>$qp10</td><td>$qp15</td><td>$qp20</td><td>$qp25</td><td>$qp99</td><td>$TOTALcalls</td>";
                $ASCII_text .= "</tr>";
                $ASCII_text .= '</table>';
                $CSV_text6.="\"\",\"$qp_1\",\"$qp_2\",\"$qp_3\",\"$qp_4\",\"$qp_5\",\"$qp_6\",\"$qp_7\",\"$qp_8\",\"$qp_9\",\"$qp10\",\"$qp15\",\"$qp20\",\"$qp25\",\"$qp99\",\"$TOTALcalls\"\n";
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                ##############################
                #########  USER STATS

                $TOTagents = 0;
                $TOTcalls = 0;
                $TOTtime = 0;
                $TOTavg = 0;

                $ASCII_text .= "<h4 class='bold'>" . _QXZ("AGENT STATS", 17) . " <a href=\"javascript:checkDownload(7)\">" . _QXZ("Download") . "</a></h4>";
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= "<tr>";
                $ASCII_text .= "<th>" . _QXZ("AGENT", 24) . "</th><th>Agency</th><th>{$rpt_type_verbiages}</th><th>" . _QXZ("TIME H:M:S", 10) . "</th><th>" . _QXZ("AVERAGE", 8) . "</th>";
                $ASCII_text .= "</tr>";

                $CSV_text7.="\n\"" . _QXZ("AGENT STATS") . "\"\n";
                $CSV_text7.="\"" . _QXZ("AGENT") . "\",\"AGENCY\",\"$rpt_type_verbiages\",\"" . _QXZ("TIME H:M:S") . "\",\"" . _QXZ("AVERAGE") . "\"\n";

                $stmt = "select " . $vicidial_closer_log_table . ".user,full_name,count(*),sum(length_in_sec),avg(length_in_sec) from " . $vicidial_closer_log_table . ",vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and  campaign_id IN($group_SQL) and " . $vicidial_closer_log_table . ".user is not null and length_in_sec is not null and " . $vicidial_closer_log_table . ".user=vicidial_users.user group by " . $vicidial_closer_log_table . ".user;";
                if ($DID == 'Y') {
                    $stmt = "select " . $vicidial_closer_log_table . ".user,full_name,count(*),sum(length_in_sec),avg(length_in_sec) from " . $vicidial_closer_log_table . ",vicidial_users where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL) and " . $vicidial_closer_log_table . ".user is not null and length_in_sec is not null and " . $vicidial_closer_log_table . ".user=vicidial_users.user group by " . $vicidial_closer_log_table . ".user;";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $users_to_print = $query->num_rows();
                $i=0;$max_timehms = 0;$max_average = 0;
                while ($i < $users_to_print){
                    $row = array_values($rslt[$i]);
                    $TOTcalls = ($TOTcalls + $row[2]);
                    $TOTtime = ($TOTtime + $row[3]);
                    $user = sprintf("%-6s", $row[0]);
                    $full_name =	sprintf("%-15s", $row[1]); while(strlen($full_name)>15) {$full_name = substr("$full_name", 0, -1);}
                    $USERcalls = sprintf("%10s", $row[2]);
                    $USERtotTALK = $row[3];
                    $USERavgTALK = $row[4];

                    if ($row[2] > $max_calls) {
                        $max_calls = $row[2];
                    }
                    if ($row[3] > $max_timehms) {
                        $max_timehms = $row[3];
                    }
                    if ($row[4] > $max_average) {
                        $max_average = $row[4];
                    }
                    $USERtotTALK_MS = sec_convert($USERtotTALK, 'H');
                    $USERavgTALK_MS = sec_convert($USERavgTALK, 'H');

                    $USERtotTALK_MS = sprintf("%9s", $USERtotTALK_MS);
                    $USERavgTALK_MS = sprintf("%6s", $USERavgTALK_MS);
                    $vUser = $this->vusers_m->get_by(array('user' => $row[0]), TRUE);
                    $agecyHtml = '';$agecyCsv = '';
                    $agentHtml = $user.' - '.$full_name;
                    if($vUser){
                        $stmt = "SELECT * FROM agents WHERE vicidial_user_id={$vUser->user_id}";
                        $agent = $this->db->query($stmt)->row();
                        if($agent){
                            $agentHtml = '<a target="_blank" href="'.site_url($this->_template.'/manage_agent/agent_info/'.$agent->id).'">'.$user.'-'.$full_name.'</a>';
                            $stmt = "SELECT * FROM agencies WHERE id={$agent->agency_id}";
                            $agency = $this->db->query($stmt)->row();
                            if($agency){
                                $agecyHtml = '<a target="_blank" href="'.site_url($this->_template.'manage_agency/agency_info/'.$agency->id).'">'.$agency->name.'</a>';
                                $agecyCsv = $agency->name;
                            }
                        }
                    }
                    $ASCII_text .= '<tr>';
                    $ASCII_text .= "<td>$agentHtml</td><td>$agecyHtml</td><td>$USERcalls</td><td>$USERtotTALK_MS</td><td>$USERavgTALK_MS</td>";
                    $ASCII_text .= '</tr>';
                    $CSV_text7.="\"$user - $full_name\",\"$agecyCsv\",\"$USERcalls\",\"$USERtotTALK_MS\",\"$USERavgTALK_MS\"\n";
                    $i++;
                }
                $TOTavg = MathZDC($TOTtime, $TOTcalls);
                $TOTavg_MS = sec_convert($TOTavg, 'H');
                $TOTavg = sprintf("%6s", $TOTavg_MS);

                $TOTtime_MS = sec_convert($TOTtime, 'H');
                $TOTtime = sprintf("%10s", $TOTtime_MS);

                $TOTagents = sprintf("%10s", $i);
                $TOTcalls = sprintf("%10s", $TOTcalls);
                $TOTtime = sprintf("%8s", $TOTtime);
                $TOTavg = sprintf("%6s", $TOTavg);

                $ASCII_text .= "<tfoot><tr>";
                $ASCII_text .= "<td colspan='1'>" . _QXZ("TOTAL Agents:", 13) . " $TOTagents </td><td>$TOTcalls</td><td>$TOTtime</td><td>$TOTavg</td>";
                $ASCII_text .= "</tr></tfoot>";
                $ASCII_text .= '</table>';
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                $CSV_text7 .= "\""._QXZ("TOTAL Agents").": $TOTagents\",\"\",\"$TOTcalls\",\"$TOTtime\",\"$TOTavg\"\n";
                ##############################
                #########  TIME Stats\\
                $MAIN .= "<h4 class='bold'>"._QXZ("TIME STATS",16)." <a href=\"javascript:checkDownload(9)\">"._QXZ("Download")."</a></h4>";
                $CSV_text9.="\""._QXZ("TIME STATS")."\"\n\n";

                ##############################
                #########  15-minute increment breakdowns of total calls and drops, then answered table
                $BDansweredCALLS = 0;
                $stmt = "SELECT status,queue_seconds,UNIX_TIMESTAMP(call_date),call_date from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and campaign_id IN($group_SQL);";
                if ($DID == 'Y') {
                    $stmt = "SELECT status,queue_seconds,UNIX_TIMESTAMP(call_date),call_date from " . $vicidial_closer_log_table . " where call_date >= '$query_date_BEGIN' and call_date <= '$query_date_END' and uniqueid IN($unid_SQL);";
                }
                $query = $this->vicidialdb->db->query($stmt);
                $rslt = $query->result_array();
                $calls_to_print = $query->num_rows();
                $j=0;
                while ($j < $calls_to_print) {
                    $row = array_values($rslt[$j]);
                    $Cstatus[$j] = $row[0];
                    $Cqueue[$j] = $row[1];
                    $Cepoch[$j] = $row[2];
                    $Cdate[$j] = $row[3];
                    $Crem[$j] = (($Cepoch[$j] + $epoch_offset) % 86400); # find the remainder(Modulus) of seconds since start of the day
                #	$MAIN.="|$Cepoch[$j]|$Crem[$j]|$Cdate[$j]|\n";
                    $j++;
                }
                ### Loop through all call records and gather stats for total call/drop report and answered report
                $j = 0;$Ftotal = array();$Fanswer = array();$adB_0 = array();$adB_5 = array();$adB10 = array();$adB15 = array();$adB20 = array();$adB25 = array();$adB30 = array();$adB35 = array();$adB40 = array();$adB45 = array();$adB50 = array();$adB55 = array();$adB60 = array();$adB90 = array();$adB99 = array();
                while ($j < $calls_to_print){
                    $i=0; $sec=0; $sec_end=900;
                    while ($i <= 96){
                        if ( ($Crem[$j] >= $sec) && ($Crem[$j] < $sec_end) ) {
                            if(isset($Ftotal[$i])){
                                $Ftotal[$i]++;
                            }else{
                                $Ftotal[$i] = 1;
                            }

                            if (preg_match('/DROP/',$Cstatus[$j])) {
                                if(isset($Fdrop[$i])){
                                    $Fdrop[$i]++;
                                }
                            }
                            if (!preg_match('/DROP|XDROP|HXFER|QVMAIL|HOLDTO|LIVE|QUEUE|TIMEOT|AFTHRS|NANQUE|INBND|MAXCAL/',$Cstatus[$j])){
                                $BDansweredCALLS++;
                                isset($Fanswer[$i]) ? $Fanswer[$i]++ : $Fanswer[$i] = 1;
                				if ($Cqueue[$j] == 0) { isset($adB_0[$i] ) ? $adB_0[$i]++ : $adB_0[$i] = '' ;}
                				if ( ($Cqueue[$j] > 0) && ($Cqueue[$j] <= 5) )		{isset($adB_5[$i]) ? $adB_5[$i]++ : $adB_5[$i] = 0;}
                				if ( ($Cqueue[$j] > 5) && ($Cqueue[$j] <= 10) )	    {isset($adB10[$i]) ? $adB10[$i]++ : $adB10[$i] = 0 ;}
                				if ( ($Cqueue[$j] > 10) && ($Cqueue[$j] <= 15) )	{isset($adB15[$i]) ? $adB15[$i]++ : $adB15[$i] = 0;}
                				if ( ($Cqueue[$j] > 15) && ($Cqueue[$j] <= 20) )	{isset($adB20[$i]) ? $adB20[$i]++ : $adB20[$i] = 0;}
                				if ( ($Cqueue[$j] > 20) && ($Cqueue[$j] <= 25) )	{isset($adB25[$i]) ? $adB25[$i]++ : $adB25[$i] = 0;}
                				if ( ($Cqueue[$j] > 25) && ($Cqueue[$j] <= 30) )	{isset($adB30[$i]) ? $adB30[$i]++ : $adB30[$i] = 0;}
                				if ( ($Cqueue[$j] > 30) && ($Cqueue[$j] <= 35) )	{isset($adB35[$i]) ? $adB35[$i]++ : $adB35[$i] = 0;}
                				if ( ($Cqueue[$j] > 35) && ($Cqueue[$j] <= 40) )	{isset($adB40[$i]) ? $adB40[$i]++ : $adB40[$i] = 0;}
                				if ( ($Cqueue[$j] > 40) && ($Cqueue[$j] <= 45) )	{isset($adB45[$i]) ? $adB45[$i]++ : $adB45[$i] = 0;}
                				if ( ($Cqueue[$j] > 45) && ($Cqueue[$j] <= 50) )	{isset($adB50[$i]) ? $adB50[$i]++ : $adB50[$i] = 0;}
                				if ( ($Cqueue[$j] > 50) && ($Cqueue[$j] <= 55) )	{isset($adB55[$i]) ? $adB55[$i]++ : $adB55[$i] = 0;}
                				if ( ($Cqueue[$j] > 55) && ($Cqueue[$j] <= 60) )	{isset($adB60[$i]) ? $adB60[$i]++ : $adB60[$i] = 0;}
                				if ( ($Cqueue[$j] > 60) && ($Cqueue[$j] <= 90) )	{isset($adB90[$i]) ? $adB90[$i]++ : $adB90[$i] = 0;}
                				if ($Cqueue[$j] > 90) {$adB99[$i]++;}
                            }
                        }else{
                            $adB_0[$i] = '';$adB_5[$i] = '';$adB10[$i] = '';$adB15[$i] = '';$adB20[$i] = '';$adB25[$i] = '';$adB30[$i] = '';$adB35[$i] = '';$adB40[$i] = '';$adB45[$i] = '';$adB50[$i] = '';$adB55[$i] = '';$adB60[$i] = '';$adB90[$i] = '';
                                $adB99[$i] = '';
                            if(!isset($Fanswer[$i])) { $Fanswer[$i] = 0; }
                            if(!isset($Ftotal[$i])) { $Ftotal[$i] = ''; }
                            if(!isset($Fdrop[$i]))  { $Fdrop[$i] = ''; }
                        }
                        $sec = ($sec + 900);
                        $sec_end = ($sec_end + 900);
                        $i++;
                    }
                    $j++;
                }

                ##### 15-minute total and drops graph
                $hi_hour_count=0;
                $last_full_record=0;
                $i=0;
                $h=0;$hour_count = array();
                while ($i <= 96) {
                    $hour_count[$i] = isset($Ftotal[$i]) ? $Ftotal[$i] : '' ;
                    if ($hour_count[$i] > $hi_hour_count) {
                        $hi_hour_count = $hour_count[$i];
                    }
                    if ($hour_count[$i] > 0) {
                        $last_full_record = $i;
                    }
                    $drop_count[$i] = isset($Fdrop[$i]) ? $Fdrop[$i] : '';
                    $i++;
                }
                $hour_multiplier = MathZDC(100, $hi_hour_count);

                $ASCII_text .= "<!-- HICOUNT: $hi_hour_count|$hour_multiplier -->\n";
                $ASCII_text .= '<h5>'._QXZ("GRAPH IN 15 MINUTE INCREMENTS OF TOTAL")." $rpt_type_verbiages "._QXZ("TAKEN INTO THIS IN-GROUP")."</h5>";

                $k=1;
                $Mk=0;
                $call_scale = '0';
                while ($k <= 102) {
                    if ($Mk >= 5) {
                        $Mk = 0;
                        $scale_num = MathZDC($k, $hour_multiplier);
                        $scale_num = round($scale_num, 0);
                        $LENscale_num = (strlen($scale_num));
                        $k = ($k + $LENscale_num);
                        $call_scale .= "$scale_num";
                    } else {
                        $call_scale .= "&nbsp;&nbsp;";
                        $k++;
                        $Mk++;
                    }
                }
                $ASCII_text .= '<div class="table-responsive">';
                $ASCII_text .= '<table class="table table-bordered">';
                $ASCII_text .= "<tr>";
#$ASCII_text.="| HOUR | GRAPH IN 15 MINUTE INCREMENTS OF TOTAL INCOMING CALLS FOR THIS GROUP                                  | DROPS | TOTAL |\n";
                $ASCII_text.="<th>" . _QXZ("HOUR", 4) . "</th><th>$call_scale</th><th>" . _QXZ("DROPS", 5) . "</th><th>" . _QXZ("TOTAL", 5) . "</th>";
                $ASCII_text.="</tr>";

                $CSV_text9.="\"" . _QXZ("HOUR") . "\",\"" . _QXZ("DROPS") . "\",\"" . _QXZ("TOTAL") . "\"\n";

                $ZZ = '00';
                $i=0;
                $h=4;
                $hour= -1;
                $no_lines_yet=1;

                while ($i <= 96){
                    $char_counter = 0;
                    $time = '      ';
                    if ($h >= 4) {
                        $hour++;
                        $h = 0;
                        if ($hour < 10) {
                            $hour = "0$hour";
                        }
                        $time = "+$hour$ZZ+";
                        #$CSV_text9.="$hour$ZZ,";
                    }
                    if ($h == 1) {$time = "   15 ";}
                    if ($h == 2) {$time = "   30 ";}
                    if ($h == 3) {$time = "   45 ";}
                    $Ghour_count = $hour_count[$i];
                    if ($i >= $first_shift_record && $i <= $last_shift_record){
                        $ASCII_text .= '<tr>';
                        if ($Ghour_count < 1) {
                            $hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);
                            $ASCII_text.="<td>$time";
                            $CSV_text9.="\"$time\",";
                            $k=0;   while ($k <= 102) {$ASCII_text.=" ";   $k++;}
                            $ASCII_text.="</td><td>$hour_count[$i]</td><td>&nbsp;</td><td>&nbsp;</td>";
                            $CSV_text9.="\"0\",\"0\"\n";
                        }else{
		                    $no_lines_yet = 0;
			                $Xhour_count = ($Ghour_count * $hour_multiplier);
			                $Yhour_count = (99 - $Xhour_count);
                            $Gdrop_count = $drop_count[$i];
                            if ($Gdrop_count < 1){
                                $hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);
                                $ASCII_text.="<td>$time</td><td><SPAN class=\"green\">";
                                $CSV_text9.="\"$time\",";
                                $k=0;   while ($k <= $Xhour_count) {$ASCII_text.="*";   $k++;   $char_counter++;}
                                $ASCII_text.="*X</SPAN>";   $char_counter++;
                                $k=0;   while ($k <= $Yhour_count) {$ASCII_text.=" ";   $k++;   $char_counter++;}
                                while ($char_counter <= 101) {$ASCII_text.=" ";   $char_counter++;}
                                $ASCII_text.="</td><td>0</td><td>$hour_count[$i]</td>";
                                $CSV_text9.="\"0\",\"$hour_count[$i]\"\n";
                            }else{
                                $Xdrop_count = ($Gdrop_count * $hour_multiplier);
                                $XXhour_count = ( ($Xhour_count - $Xdrop_count) - 1 );
                                $hour_count[$i]+=0;
                                $drop_count[$i]+=0;
                                $hour_count[$i] =	sprintf("%-5s", $hour_count[$i]);
                                $drop_count[$i] =	sprintf("%-5s", $drop_count[$i]);

                                $ASCII_text.="<td>$time</td><td><SPAN class=\"red\">";
                                $CSV_text9.="\"$time\",";
                                $k=0;   while ($k <= $Xdrop_count) {$ASCII_text.=">";   $k++;   $char_counter++;}
                                $ASCII_text.="D</SPAN><SPAN class=\"green\">";   $char_counter++;
                                $k=0;   while ($k <= $XXhour_count) {$ASCII_text.="*";   $k++;   $char_counter++;}
                                $ASCII_text.="X</SPAN></td>";   $char_counter++;
                                $k=0;   while ($k <= $Yhour_count) {$ASCII_text.=" ";   $k++;   $char_counter++;}
                                while ($char_counter <= 102) {$ASCII_text.=" ";   $char_counter++;}
                                $ASCII_text.="<td>$drop_count[$i]</td><td>$hour_count[$i]</td>";
                                $CSV_text9.="\"$drop_count[$i]\",\"$hour_count[$i]\"\n";
                            }
                       }
                       $ASCII_text .= '</tr>';
                    }
                    if (trim($hour_count[$i])>$max_calls) {$max_calls=trim($hour_count[$i]);}
                    $i++;
                    $h++;
                } //while ($i <= 96)
                $ASCII_text .= "</table>";
                $ASCII_text .= "</div>";
                $MAIN .= $ASCII_text;
                $ASCII_text = '';
                ##### Answered wait time breakdown
                $MAIN.="<h4 class='bold'>$rpt_type_verbiage " . _QXZ("ANSWERED TIME BREAKDOWN IN SECONDS", 40) . " <a href=\"javascript:checkDownload(8)\">" . _QXZ("Download") . "</a></h4>";
                $MAIN .= "<table class='table table-bordered'>";
                $MAIN .= "<tr>";
                $MAIN.="<th>" . _QXZ("HOUR", 4) . "</th><th>0</th><th>5</th><th>10</th><th>15</th><th>20</th><th>25</th><th>30</th><th>35</th><th>40</th><th>45</th><th>50</th><th>55</th><th>60</th><th>90</th><th>+90</th><th>" . _QXZ("TOTAL", 10) . "</th>";
                $MAIN .= "</tr>";

                $CSV_text8.="\n\"$rpt_type_verbiage " . _QXZ("ANSWERED TIME BREAKDOWN IN SECONDS") . "\"\n";
                $CSV_text8.="\"" . _QXZ("HOUR") . "\",\"0\",\"5\",\"10\",\"15\",\"20\",\"25\",\"30\",\"35\",\"40\",\"45\",\"50\",\"55\",\"60\",\"90\",\"+90\",\"" . _QXZ("TOTAL") . "\"\n";
                $ZZ = '00';
                $i=0;
                $h=4;
                $hour= -1;
                $no_lines_yet=1;
                while ($i <= 96){
                    $char_counter=0;
                    $time = '      ';
                    if ($h >= 4) {
                        $hour++;
                        $h=0;
                        if ($hour < 10) {$hour = "0$hour";}
                        $time = "+$hour$ZZ+";
                        $SQLtime = "$hour:$ZZ:00";
                        $SQLtimeEND = "$hour:15:00";
                    }
                    if ($h == 1) {$time = "   15 ";   $SQLtime = "$hour:15:00";   $SQLtimeEND = "$hour:30:00";}
                    if ($h == 2) {$time = "   30 ";   $SQLtime = "$hour:30:00";   $SQLtimeEND = "$hour:45:00";}
                    if ($h == 3) {
                        $time = "   45 ";
                        $SQLtime = "$hour:45:00";
                        $hourEND = ($hour + 1);
                        if ($hourEND < 10) {$hourEND = "0$hourEND";}
                        if ($hourEND > 23) {$SQLtimeEND = "23:59:59";}
                        else {$SQLtimeEND = "$hourEND:00:00";}
                    }
                    if (!isset($adB_0[$i]) || strlen($adB_0[$i]) < 1)  {$adB_0[$i]='-';}
                    if (!isset($adB_5[$i]) || strlen($adB_5[$i]) < 1)  {$adB_5[$i]='-';}
                    if (!isset($adB10[$i]) || strlen($adB10[$i]) < 1)  {$adB10[$i]='-';}
                    if (!isset($adB15[$i]) || strlen($adB15[$i]) < 1)  {$adB15[$i]='-';}
                    if (!isset($adB20[$i]) || strlen($adB20[$i]) < 1)  {$adB20[$i]='-';}
                    if (!isset($adB25[$i]) || strlen($adB25[$i]) < 1)  {$adB25[$i]='-';}
                    if (!isset($adB30[$i]) || strlen($adB30[$i]) < 1)  {$adB30[$i]='-';}
                    if (!isset($adB35[$i]) || strlen($adB35[$i]) < 1)  {$adB35[$i]='-';}
                    if (!isset($adB40[$i]) || strlen($adB40[$i]) < 1)  {$adB40[$i]='-';}
                    if (!isset($adB45[$i]) || strlen($adB45[$i]) < 1)  {$adB45[$i]='-';}
                    if (!isset($adB50[$i]) || strlen($adB50[$i]) < 1)  {$adB50[$i]='-';}
                    if (!isset($adB55[$i]) || strlen($adB55[$i]) < 1)  {$adB55[$i]='-';}
                    if (!isset($adB60[$i]) || strlen($adB60[$i]) < 1)  {$adB60[$i]='-';}
                    if (!isset($adB90[$i]) || strlen($adB90[$i]) < 1)  {$adB90[$i]='-';}
                    if (!isset($adB99[$i]) || strlen($adB99[$i]) < 1)  {$adB99[$i]='-';}
                    if (!isset($Fanswer[$i]) || strlen($Fanswer[$i]) < 1)  {$Fanswer[$i]='0';}

                    $adB_0[$i] = sprintf("%5s", $adB_0[$i]);
                    $adB_5[$i] = sprintf("%5s", $adB_5[$i]);
                    $adB10[$i] = sprintf("%5s", $adB10[$i]);
                    $adB15[$i] = sprintf("%5s", $adB15[$i]);
                    $adB20[$i] = sprintf("%5s", $adB20[$i]);
                    $adB25[$i] = sprintf("%5s", $adB25[$i]);
                    $adB30[$i] = sprintf("%5s", $adB30[$i]);
                    $adB35[$i] = sprintf("%5s", $adB35[$i]);
                    $adB40[$i] = sprintf("%5s", $adB40[$i]);
                    $adB45[$i] = sprintf("%5s", $adB45[$i]);
                    $adB50[$i] = sprintf("%5s", $adB50[$i]);
                    $adB55[$i] = sprintf("%5s", $adB55[$i]);
                    $adB60[$i] = sprintf("%5s", $adB60[$i]);
                    $adB90[$i] = sprintf("%5s", $adB90[$i]);
                    $adB99[$i] = sprintf("%5s", $adB99[$i]);
                    $Fanswer[$i] = sprintf("%10s", $Fanswer[$i]);
                    $MAIN .= '<tr>';
                    $MAIN .= "<td>$time</td><td>$adB_0[$i]</td><td>$adB_5[$i]</td><td>$adB10[$i]</td><td>$adB15[$i]</td><td>$adB20[$i]</td><td>$adB25[$i]</td><td>$adB30[$i]</td><td>$adB35[$i]</td><td>$adB40[$i]</td><td>$adB45[$i]</td><td>$adB50[$i]</td><td>$adB55[$i]</td><td>$adB60[$i]</td><td>$adB90[$i]</td><td>$adB99[$i]</td><td>$Fanswer[$i]</td>";
                    $MAIN .= '</tr>';
                    $CSV_text8.="\"$time\",\"$adB_0[$i]\",\"$adB_5[$i]\",\"$adB10[$i]\",\"$adB15[$i]\",\"$adB20[$i]\",\"$adB25[$i]\",\"$adB30[$i]\",\"$adB35[$i]\",\"$adB40[$i]\",\"$adB45[$i]\",\"$adB50[$i]\",\"$adB55[$i]\",\"$adB60[$i]\",\"$adB90[$i]\",\"$adB99[$i]\",\"$Fanswer[$i]\"\n";
                    $i++;
                    $h++;
                } //while ($i <= 96){

                $BDansweredCALLS =		sprintf("%10s", $BDansweredCALLS);

                $MAIN .="<tfoot><tr>";
                $MAIN .="<td colspan='16'>"._QXZ("TOTALS",6)."</td><td>$BDansweredCALLS</td>";
                $MAIN .="</tr></tfoot>";
                $MAIN .= '</table>';
                $CSV_text8.="\""._QXZ("TOTALS")."\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"\",\"$BDansweredCALLS\"\n";
                if ($file_download>0) {
                        $FILE_TIME = date("Ymd-His");
                        $CSVfilename = "AST_CLOSERstats_$US$FILE_TIME.csv";
                        $CSV_var="CSV_text".$file_download;
                        $CSV_text=preg_replace('/^\s+/', '', $$CSV_var);
                        $CSV_text=preg_replace('/ +\"/', '"', $CSV_text);
                        $CSV_text=preg_replace('/\" +/', '"', $CSV_text);
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
                }else{
                    $this->data['result'] = TRUE;
                    $this->data['output'] = $MAIN;
                }
            } //else
        }
        $this->template->load($this->_template, 'dialer/report/inbound', $this->data);
    }
    /**
     * get the agency inbound group
     * @return JSON
     */
    public function getIngroup(){
        $post = $this->input->post();
        if($post && $post['id'] != ''){
            if(decode_url($post['id'])){
                $post['id'] = decode_url($post['id']);
            }
            if($post['id'] > 0){
                $this->vingroup_m->createTempTable();
                $tempTable = $this->vingroup_m->_temptable;
                $stmt="SELECT group_id,group_name from {$tempTable}  main,agency_inbound_group sub WHERE sub.vicidial_ingroup_id = main.group_id AND sub.agency_id = {$post['id']} order by group_id;";
                $ingroups = $this->db->query($stmt)->result_array();
            }else{
               $stmt="SELECT group_id,group_name from vicidial_inbound_groups WHERE group_id order by group_id;";
               $ingroups = $this->vicidialdb->db->query($stmt)->result_array();
            }
            $html = '<select name="group[]" id="groupcall" class="form-control" multiple="multiple">';
            if ($this->session->userdata ( 'user' )->group_name != 'Agency'){
                $html .= '<option value="---NONE---">---NONE---</option>';
            }
            $pIngroups = json_decode($post['ingroup']);
            if($pIngroups){
                foreach($ingroups as $ingroup){
                    $selected = '';
                    if(in_array($ingroup['group_id'], $pIngroups)){
                        $selected = 'selected="selected"';
                    }
                    $html .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
                }
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
        }else{
            $output['success'] = FALSE;
            $output['html'] = '<select name="group[]" id="groupcall" class="form-control" multiple>';
            if ($this->session->userdata ( 'user' )->group_name != 'Agency'){
                $output['html'] .= '<option value="---NONE---">---NONE---</option>';
            }
            $ingroups = $this->aingroup_m->query();
            foreach($ingroups as $ingroup){
                $selected = '';
                $output['html'] .= '<option value="'.$ingroup['group_id'].'" '.$selected.'>'.$ingroup['group_id'].' - '.$ingroup['group_name'].'</option>';
            }
            $output['html'] .= '</select>';
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        }
    }
    /**
     * get the agency inbound DID
     * @return JSON
     */
    public function getInboundDid(){
        $this->load->model('vicidial/indid_m', 'indid_m');
        $html = '';
        if($post = $this->input->post()){
            $iGroup = json_decode($post['ingroup']);
            $html .= '<select name="group[]" id="groupcall" class="form-control" multiple="multiple">';
            $id = decode_url($post['id']);
            if($id){
               $this->indid_m->createTempTable();
               $tempTable = $this->indid_m->_temptable;
               $stmt =  "SELECT * FROM {$tempTable} main, agency_inbound_did sub WHERE sub.vicidial_did_id=main.did_id AND sub.agency_id={$id}";
               $query = $this->db->query($stmt);
               $result = $query->result_array();
               if($result){
                    foreach ($result as $row) {
                        $selected = '';
                        if(in_array($row['did_pattern'], $iGroup)){
                            $selected = 'selected="selected"';
                        }
                        $html .= '<option '.$selected.' value="'.$row['did_pattern'].'">'.$row['did_pattern'].'-'.$row['did_description'].'</option>';
                    }
               }
            }else{ // if($id)
                if ($this->session->userdata ('user')->group_name == 'Agency'){
                    $this->load->model('vicidial/ainded_m', 'ainded_m');
                    $result = $this->ainded_m->query();
                    if($result){
                        foreach ($result as $row) {
                            $selected = '';
                            if(in_array($row['did_pattern'], $iGroup)){
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option '.$selected.' value="'.$row['did_pattern'].'">'.$row['did_pattern'].'-'.$row['did_description'].'</option>';
                        }
                    }
                }else{
                    $result = $this->indid_m->query();
                    if($result){
                        foreach ($result as $row) {
                            $selected = '';
                            if(in_array($row['did_pattern'], $iGroup)){
                                $selected = 'selected="selected"';
                            }
                            $html .= '<option '.$selected.' value="'.$row['did_pattern'].'">'.$row['did_pattern'].'-'.$row['did_description'].'</option>';
                        }
                    }
               }
            }
            $html .= '</select>';
            $output['success'] = TRUE;
            $output['html'] = $html;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
        }//if($post = $this->input->post()){
    }
    /**
     * recording report for both admin and agency site
     */
    public function recreport(){       
        $this->data['datatable'] = TRUE;
        $this->data['model'] = TRUE;
        $this->data ['datepicker'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data ['audiojs'] = TRUE;
        $this->data ['listtitle'] = 'Recording Report';
        $this->data ['title'] = 'Recording Report';
        $this->data ['breadcrumb'] = "Recording Report";
        $this->data ['agencies'] = $this->agency_model->get_nested();
        $this->template->load($this->_template, 'dialer/report/recording', $this->data);
    }
    
    public function recjson(){
        $where = $this->input->post('customActionType');
        
        if($this->session->userdata('user')->group_name == 'Agency'){
            $agencies = $this->agency_model->get_nested();
            $str = '';
            foreach($agencies as $agency){
                $str .= "'".$agency['id']."',";
            }
            $str = rtrim($str, ',');
            $whereStr = " WHERE ag.id IN({$str})";
        }else{
            $whereStr = ' ';
        }
        // Recommended        
        if(is_array($where) && count($where) > 0){
            if($this->session->userdata('user')->group_name == 'Agency'){
                $whereStr .= ' AND (';
            }else{    
                $whereStr .= ' WHERE (';
            }
            if(isset($where['agency_id']) && strlen($where['agency_id']) > 0 ){
                $agencyId = decode_url($where['agency_id']);
                $whereStr .= " ag.id = '{$agencyId}' OR";
            }
            if(isset($where['user_start']) && strlen($where['user_start']) > 0 ){               
                $whereStr .= " rec.user = '{$where['user_start']}' OR";
            }
            if(isset($where['lead_id']) && strlen($where['lead_id']) > 0 ){               
                $whereStr .= " rec.lead_id = '{$where['lead_id']}' OR";
            }
            $whereStr = rtrim($whereStr,'OR');    
            $whereStr .= ' )';
        }   
       
        $aColumns = array(
            'rec.recording_id', 'channel', 'start_time', 'end_time', 'length_in_sec', 'lead_id', 'location', 'agentname', 'name'
        );
        $this->load->model('vicidial/vrecording_m', 'vrecording_m');
        $this->vrecording_m->cretaeTempTable();        
        $recordings = $this->vrecording_m->get();
        $order = $this->input->post('order');
        $order = $order[0];
        $orderColumn = $aColumns[isset($order['column']) ? $order['column'] : 0];        
        $orderDir = isset($order['dir']) ? $order['dir'] : 'DESC';         
        $sql = "SELECT rec.*,concat(a.fname,' ',a.lname) as agentname,ag.name FROM recording_log_temp rec LEFT JOIN agents a ON a.vicidial_user_id = rec.user_id LEFT JOIN agencies ag ON a.agency_id = ag.id {$whereStr} ORDER BY {$orderColumn} $orderDir";        
        $query = $this->db->query($sql);
        $recordings = $query->result();
        $iTotalRecords = $query->num_rows();
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        for($i = $iDisplayStart; $i < $end; $i++) {          
          $record = $recordings[$i];
          $id = ($i + 1);
          $records["data"][] = array(
            $id,
            $record->channel,
            $record->start_time,
            $record->end_time,
            $record->length_in_min,
            $record->lead_id,
            '<audio src="'.$record->location.'"></audio>',
            $record->user.'/'.$record->agentname,
            $record->name,
         );
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);        
    }
}

