
<?php if ($this->session->userdata('vicidata')): ?>
    <style type="text/css">
        .dispo li:nth-child(2n+1),.dispo li:nth-child(2n){float: left; width: 50%;list-style: none; padding: 10px;}
        .selected{color: #333;font-size: 14px; font-weight: bold;}
        .dispo li a:hover{text-decoration: none;color: #333;font-size: 14px; font-weight: bold;}
        #time{font-size: 9px;}
        #responsive2 .form-control{display: inline-block;}
        #responsive2 select.form-control{width:420px}
        #responsive2 input.form-control{width:160px}
        #responsive2 input#numbercall{width: 170px;}
    </style>
    <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>-->
                    <h4 class="modal-title"><?php echo "Disposition" ?></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <?php $statuses = getDisposition($this->session->userdata('vicidata')['campaign']) ?>
                            <ul class="dispo">
                                <?php foreach ($statuses as $status): ?>
                                    <li><a id="<?php echo $status->STATUS ?>" class="status-link" href="javascript:setDispo('<?php echo $status->STATUS ?>')"><?php echo $status->STATUS . ' - ' . $status->status_name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn green" onclick="javascript:hangupDispo()"><?php echo "Submit" ?></button>
                </div>
            </div>
        </div>
    </div>
    <?php
    
##### grab the allowable inbound groups to choose from for transfer options
    $default_xfer_group = $this->session->userdata('vicidata')['campaignObj']->default_xfer_group;
    $allow_closers = $this->session->userdata('vicidata')['campaignObj']->allow_closers;
    $xfer_groups = $this->session->userdata('vicidata')['campaignObj']->xfer_groups;
    $xfer_groups = preg_replace("/^ | -$/", "", $xfer_groups);
    $xfer_groups = preg_replace("/ /", "','", $xfer_groups);
    $xfer_groups = "'$xfer_groups'";

    $VARxfergroups = "";
    $VARxfergroupsnames = "";
    if ($allow_closers == 'Y') {
        $VARxfergroups = '';
        $stmt = "SELECT group_id,group_name FROM vicidial_inbound_groups WHERE active = 'Y' and group_id IN($xfer_groups) ORDER BY group_id LIMIT 800;";
        $query = $this->vicidialdb->db->query($stmt);
        $rslt = $query->result_array();
        $xfer_ct = $query->num_rows();
        $XFgrpCT = 0;
        while ($XFgrpCT < $xfer_ct) {
            $row = array_values($rslt[$XFgrpCT]);
            $VARxfergroups = "$VARxfergroups$row[0],";
            $VARxfergroupsnames = "$VARxfergroupsnames$row[1],";
            if ($row[0] == "$default_xfer_group") {
                $default_xfer_group_name = $row[1];
            }
            $XFgrpCT++;
        }
    }
    ?>
    <div id="responsive2" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center"><?php echo "Transfer Conference Functions" ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <select name="XfeRGrouP" id="XfeRGrouP" class="form-control" onchange="agentSelectLink();return false;">
                                        <option><?php echo '-- SELECT A GROUP TO SEND YOUR CALL TO --' ?></option>
                                        <?php if (isset($VARxfergroups) && strlen($VARxfergroups) > 0): $loop_ct = 0; ?>
                                            <?php $groups = explode(',', $VARxfergroups); ?>
                                            <?php $groupsName = explode(',', $VARxfergroupsnames); ?>
                                            <?php while ($loop_ct < count($groups)): ?>
                                                <option <?php if($loop_ct == 0){ echo 'selected="selected"'; } ?> value="<?php echo trim($groups[$loop_ct]) ?>"><?php echo $groups[$loop_ct] . ' - ' . $groupsName[$loop_ct] ?></option>
                                                <?php $loop_ct++ ?>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </select>
                                    <button id="LocalCloser" class="btn green disabled"><?php echo 'Local Closer' ?></button>
                                </div>
                                <div class="form-group">
                                    <label><?php echo 'Seconds' ?></label>
                                    <input type="text" name="xferlength" id="xferlength" class="form-control" readonly="readonly"/>
                                    <label><?php echo 'Channel' ?></label>
                                    <input type="text" name="xferchannel" id="xferchannel" class="form-control" readonly="readonly"/>
                                </div>
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <label><?php echo 'Number to call' ?></label>
                                    <input type="text" name="xfernumber" id="xfernumber" class="form-control"/>
                                    <label><input type="checkbox" value="0" size="1" id="consultativexfer" name="consultativexfer"><?php echo 'CONSULTATIVE' ?></label>
                                    <label><input type="checkbox" value="0" size="1" id="xferoverride" name="xferoverride"><?php echo 'DIAL OVERRIDE' ?></label>
                                </div>
                                <div class="form-group">
                                    <button id="DialBlindTransfer" type="button" class="btn green"><?php echo 'Blind Transfer' ?></button>
                                    <button id="DialWithCustomer" type="button" class="btn green" onclick="SendManualDial('YES','YES');return false;"><?php echo 'Dial With Customer' ?></button>
                                    <button id="ParkCustomerDial" type="button" class="btn green" onclick="xfer_park_dial('YES');return false;"><?php echo 'Park Customer Dial' ?></button>
                                    <button type="button" class="btn" id="ParkControl" style="display:none;"></button>
                                    <span id="ParkCounterSpan"></span>                           
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="button" class="btn green disabled" id="HangupXferLine" onclick="xfercall_send_hangup('YES');return false;"><?php echo 'Hangup Customer Line' ?></button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn green" id="HangupBothLines" onclick="bothcall_send_hangup('YES');return false;"><?php echo 'Hangup Both Lines' ?></button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn green" id="Leave3WayCall" onclick="leave_3way_call('FIRST','YES');return false;"><?php echo 'Leave 3-WAY Call' ?></button>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn green" id="agentdirectlink" style="display:none;" onclick="agentSelectLaunch();return false;"><?php echo 'Agents' ?></button>
                                    <input type="hidden" id="xferuniqueid" name="xferuniqueid" />
                                    <input type="hidden" id="xferchannel" name="xferchannel" />
                                    <input type="hidden" id="xfernumhidden" name="xfernumhidden" />								
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script type="text/javascript">
        var calltimer = null;
        var phoneError;
        var agentCall = 'NO';
        var CalLCID = '';
        var MDnextCID = '';
        var XDnextCID = '';
        var LastCallCID = '';
        var XDuniqueid = '';
        var XDchannel = '';
        var lastxferchannel = '';
        var MD_ring_secondS = 0;
        var XD_live_customer_call = 0;
        var XD_live_call_secondS = 0;
        var MD_channel_look = 0;
        var MD_channel_look_xfer = 0; 
	var alt_dial_status_display = 0;
        var status_display_NAME = 0,status_display_CALLID = 1,status_display_LEADID = 0,status_display_LISTID = 0;
        var manual_dial_timeout = 60;
        var MDchannel1 = '';
        var asterisk_version = '<?php echo $this->session->userdata('vicidata')['asterisk_version']; ?>';
        var serverIp = '<?php echo $this->config->item('vici_server_ip') ?>';
        <?php
            $S='*';
            $D_s_ip = explode('.', $this->config->item('vici_server_ip'));        
            if (strlen($D_s_ip[0])<2) {$D_s_ip[0] = "0$D_s_ip[0]";}
            if (strlen($D_s_ip[0])<3) {$D_s_ip[0] = "0$D_s_ip[0]";}
            if (strlen($D_s_ip[1])<2) {$D_s_ip[1] = "0$D_s_ip[1]";}
            if (strlen($D_s_ip[1])<3) {$D_s_ip[1] = "0$D_s_ip[1]";}
            if (strlen($D_s_ip[2])<2) {$D_s_ip[2] = "0$D_s_ip[2]";}
            if (strlen($D_s_ip[2])<3) {$D_s_ip[2] = "0$D_s_ip[2]";}
            if (strlen($D_s_ip[3])<2) {$D_s_ip[3] = "0$D_s_ip[3]";}
            if (strlen($D_s_ip[3])<3) {$D_s_ip[3] = "0$D_s_ip[3]";}
            $server_ip_dialstring = "$D_s_ip[0]$S$D_s_ip[1]$S$D_s_ip[2]$S$D_s_ip[3]$S";            
        ?>
        var sessionName = '<?php echo $this->session->userdata('vicidata')['session_name']; ?>';
        var server_ip_dialstring = '<?php echo $server_ip_dialstring ?>';
        var sessionId = '<?php echo $this->session->userdata('vicidata')['session_id'] ?>';
        var user = '<?php echo $this->session->userdata('vicidata')['user'] ?>';
        var pass = '<?php echo $this->session->userdata('vicidata')['pass'] ?>';
        var phoneLogin = '<?php echo $this->session->userdata('vicidata')['phone_login'] ?>';
        var phonePass = '<?php echo $this->session->userdata('vicidata')['phone_pass'] ?>';
        var campaign = '<?php echo $this->session->userdata('vicidata')['campaign'] ?>';
        var auto_dial_level = parseInt('<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->auto_dial_level : '0' ?>');
        var agentLogId = '<?php echo $this->session->userdata('vicidata')['agent_log_id'] ?>';
        var interval = null;
        var statusInterval = null;
        var filename;
        var ccall = 1;
        var dialCheck = null;
	var campaign_timer_action = '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->timer_action : '0' ?>';
	var campaign_timer_action_message = '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->timer_action_message : '0' ?>';;
	var campaign_timer_action_seconds = '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->timer_action_seconds : '0' ?>';;
	var campaign_timer_action_destination = '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->timer_action_destination : '0' ?>';;        
        /* recording function variables */
        var LIVE_campaign_rec_filename = '';
        var query_recording_exten = '';
        var query_recording_exten = '';
        var query_recording_exten = '';
        var tinydate = '';
        var LasTCID = '';
        var taskapiappend = '';        
        /* dial log varible */      
        var no_delete_VDAC = 0;
        var VDstop_rec_after_each_call = '1';
        var epoch_sec = <?php echo date("U") ?>;
        var random = <?php echo (rand(1000000, 9999999) + 10000000); ?>;
        var MDlogEPOCH = 0;
        var lastcustchannel = '';        
        var VDstop_rec_after_each_call = '1';
        var conf_silent_prefix = '5';
        var protocol = '<?php echo $this->session->userdata('vicidata')['phoneObj']->protocol ?>';
        var extension = '<?php echo $this->session->userdata('vicidata')['phoneObj']->extension ?>';
        var ext_context = '<?php echo $this->session->userdata('vicidata')['phoneObj']->ext_context ?>';
        var user_abb = user+user+user+user;
        var LasTCID = '';
        var inOUT = 'OUT';
        var dialed_label = '';
        var agentchannel = '';
        var conf_dialed = 0;
        var leaving_threeway = 0;
        var blind_transfer = 0;
        var hangup_all_non_reserved = '<?php echo 1 ?>';
        var dial_method = '<?php echo $this->session->userdata('vicidata')['campaignObj']->dial_method ?>';
        var lastxferchannel = '';
        var XD_live_customer_call = 0;
        var XD_live_call_secondS = 0;        
        var hide_xfer_number_to_dial='DISABLED';
        var xferchannellive=0;
        var XDcheck = '';
        var MDuniqueid = '';
        var MDchannel = '';
        var VD_live_customer_call = 0;
        var VD_live_call_secondS = 0;
        var customer_sec=0;        
        var lastcustchannel='';
        var lastcustserverip='';
        /* transfer variables */
        var quick_transfer_button_orig = '<?php echo $this->session->userdata('vicidata')['campaignObj']->default_xfer_group ?>';
        var VDCL_group_id = '';        
        var AgaiNHanguPChanneL = '';
        var AgaiNHanguPServeR = '';
        var AgainCalLSecondS = '';
        var AgaiNCalLCID = '';
        var threeway_end = 0;
        var leaving_threeway = 0;
	var timer_action='';
	var timer_action_message='';
	var timer_action_seconds='';
	var timer_action_destination = '';
        var three_way_call_cid = 'CAMPAIGN';
        var campaign_cid = '<?php echo $this->session->userdata('vicidata')['campaignObj']->campaign_cid ?>';
	var consult_custom_delay = '2';
	var consult_custom_wait = 0;
	var consult_custom_go = 0;
        var consult_custom_sent = 0;
        var prefix_choice = '';
        var active_group_alias = '';
        var three_way_dial_prefix = '<?php echo $this->session->userdata('vicidata')['campaignObj']->three_way_dial_prefix ?>';        
        var omit_phone_code = '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->omit_phone_code : '' ?>';
	var DispO3waychannel = '';
	var DispO3wayXtrAchannel = '';
	var DispO3wayCalLserverip = '';
	var DispO3wayCalLxfernumber = '';
	var DispO3wayCalLcamptail = '';
        var ivr_park_call='DISABLED';
        var customerparked = 0;
        var customerparkedcounter = 0;
        var reselect_alt_dial = 0;
        var open_dispo_screen = 0;
        var logstart = 0;
        var qm_extension = '<?php echo $this->session->userdata('vicidata')['phoneObj'] ? $this->session->userdata('vicidata')['phoneObj']->extension : '' ?>'
        var open_dispo_screen = 0;        
        var reselect_alt_dial = 0;
        var xfer_agent_selected = 0;
        var CheckDEADcallON = 0;
        var cid_lock=0;
        var cid_choice = '';
        var park_on_extension = '8301';
        var campaign_cid = '<?php echo $this->session->userdata('vicidata')['campaignObj']->campaign_cid ?>';
        var selectAgent = 0;
        var conf_channels_xtra_display = 0;
        var volumecontrol_active = '1';
        var custchannellive=0;
	var callholdstatus = '1';
	var agentcallsstatus = '0';
        var campagentstatctmax = '3';
        var campagentstatct = '0';
        checkStatus();
        /**
         * send connect call to agent
         * @return {[type]} [description]
         */
        function connectCall() {
            var postData = {
                is_ajax: true,
                agent_user: user,
                function: 'call_agent',
                value: 'CALL'
            };
            jQuery.ajax({
                url: '<?php echo site_url("viciagent/agentapicall") ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    console.log(result);
                    agentCall = 'YES';
                    jQuery('.btn_phone').hide();
                    //getagentchannel();
                }
            });
        }
        //changeStatus('closer');
        /**
        * 

         * @param {type} taskconfnum
         * @param {type} taskforce
         * @returns {undefined}         */
        function check_for_conf_calls(taskconfnum,taskforce){
            var campagentstdisp = 'NO';
            //taskconfnum = sessionId;
            custchannellive--;
            if ( (agentcallsstatus == '1') || (callholdstatus == '1') ){
                campagentstatct++;
                if (campagentstatct > campagentstatctmax){
                    campagentstatct = 0;
                    var campagentstdisp = 'YES';
                }else{
                    var campagentstdisp = 'NO';
                }
            }else{
                var campagentstdisp = 'NO';
            }
            var postData = {
                is_ajax : true,
                server_ip : serverIp,
                session_name : sessionName,
                user : user,
                pass : pass,
                client : 'vdc',
                conf_exten : taskconfnum,
                auto_dial_level : auto_dial_level,
                campagentstdisp : campagentstdisp,
                customer_chat_id : '',
                live_call_seconds : VD_live_call_secondS,
                clicks : '',
            };
            jQuery.ajax({
                url : '<?php echo site_url('viciagent/check_for_conf_calls') ?>',
                method : 'post',
                dataType : 'json',
                data : postData,
                success : function(result){
                    var check_conf = null;
                    var LMAforce = taskforce;
                    check_conf = result.message;
                    
                    var check_ALL_array = check_conf.split("\n");
                    var check_time_array = check_ALL_array[0].split("|");
                    var Time_array = check_time_array[1].split("UnixTime: ");  
                    
                    var check_conf_array = check_ALL_array[1].split("|");
                    var live_conf_calls = check_conf_array[0];
                    var conf_chan_array = check_conf_array[1].split(" ~");  
                    var channelfieldA = '';
                    if ( (conf_channels_xtra_display == 1) || (conf_channels_xtra_display == 0) ) {
                        if (live_conf_calls > 0){
                            var temp_blind_monitors = 0;
                            var loop_ct = 0;
                            var display_ct = 0;
                            var ARY_ct = 0;
                            var LMAalter = 0;
                            var LMAcontent_change = 0;
                            var LMAcontent_match = 0;
                            agentphonelive = 0;
                            var conv_start = -1;
                            while (loop_ct < live_conf_calls){
                                loop_ct++;
                                loop_s = loop_ct.toString();
                                var conv_ct = (loop_ct + conv_start);
                                var channelfieldA = conf_chan_array[conv_ct];
                            }
                        }
                        
                        if (channelfieldA == lastcustchannel) {custchannellive++;}
                        else{
                            if(customerparked == 1){
                                custchannellive++;
                            }
                            if(serverIp == lastcustserverip){
                                var nothing='';
                            }else{
                                custchannellive++;
                            }                            
                        }
                        
                        if (volumecontrol_active > 0){
                            if ( (protocol != 'EXTERNAL') && (protocol != 'Local') ){
                                var regAGNTchan = new RegExp(protocol + '/' + extension,"g");
                                if((channelfieldA.match(regAGNTchan)) && (agentchannel != channelfieldA)){
                                    agentchannel = channelfieldA;
                                }
                            }else{
                                if (agentchannel.length < 3){
                                    agentchannel = channelfieldA;

                                }
                            }                            
                        }
                    }
                }
            });
            
        }
        // filter conf_dtmf send string and pass on to originate call
        var dtmf_send_extension = '<?php echo $this->session->userdata('vicidata')['phoneObj']->dtmf_send_extension ?>';
        var dtmf_silent_prefix = '7';
        var conf_silent_prefix = '5';
        function SendConfDTMF(number, taskconfdtmf, SDTclick){
            var dtmf_number = number;
            var dtmf_string = dtmf_number.toString();
            var conf_dtmf_room = taskconfdtmf;
            
            var queryCID = dtmf_string;
            var postData = {
                is_ajax : true,
                server_ip : serverIp,
                session_name : sessionName,
                user : user,
                pass : pass,
                ACTION : 'SysCIDdtmfOriginate',
                format : 'text',
                channel : dtmf_send_extension,
                queryCID : queryCID,
                exten : dtmf_silent_prefix,
                ext_context : ext_context,
                ext_priority : '1'
            };
            jQuery.ajax({
                url : '<?php echo site_url("viciagent/manager_send") ?>',
                method : 'post',
                dataType : 'json',
                data : postData,
                success : function(result){
                    //alert(result);
                }
            });
        }
        function clearForm(){
            document.leadform.lead_id.value = '';
            document.leadform.list_id.value = '';
            document.leadform.phone_number.value = '';
            document.leadform.first_name.value = '';
            document.leadform.last_name.value = '';
            document.leadform.address1.value = '';
            document.leadform.city.value = '';
            document.leadform.state.value = '';
            document.leadform.postal_code.value = '';
            document.leadform.email.value = '';
            document.leadform.called_count.value = '';        
        }
        function checkPhoneNumber(number) {
            jQuery('#loading').modal('show');
            agentCall = 'NO';
            var postData = {
                is_ajax: true,
                phone_number: number,
                local_call_time: '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->local_call_time : '' ?>'
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/checkphone') ?>',
                method: 'POST',
                dataType: 'json',
                async: false,
                data: postData,
                success: function (result) {
                    var flag = Boolean(result.error);
                    var msg = result.message;
                    if (flag == true) {
                        phoneError = false;
                    }
                    var res = msg.split(" ");
                    if (res[0] == "ERROR:") {
                        var indexOf = msg.indexOf('-');
                        var str = msg.substring(25, indexOf);
                        swal("Oops...", str, "error");
                        phoneError = false;
                    } else if (res[0] == "AREACODE:") {
                        phoneError = true;
                    } else {
                        phoneError = false;
                    }
                }
            });
            jQuery('#loading').modal('hide');
        }
        function formManualDial() {            
            if (sessionId.length <= 0) {                
                swal('Oops....','Something went wrong.','error');
                return;
            }
            conf_dialed = 1;
            var postData = {
                'is_ajax': true,
                'server_ip': serverIp,
                'session_name': sessionName,
                'ACTION': 'manDiaLnextCaLL',
                'conf_exten': sessionId,
                'user': user,
                'pass': pass,
                'campaign': campaign,
                'ext_context': '<?php echo $this->session->userdata('vicidata')['phoneObj'] ? $this->session->userdata('vicidata')['phoneObj']->ext_context : '' ?>',
                'dial_timeout': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->dial_timeout : '' ?>',
                'dial_prefix': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->dial_prefix : '' ?>',
                'campaign_cid': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->campaign_cid : '' ?>',
                'preview': 'NO',
                'agent_log_id': agentLogId,
                'callback_id': '',
                'lead_id': jQuery('[name="lead_id"]').val(),
                'phone_code': 1,
                'phone_number': jQuery("#to").val(),
                //'list_id': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->manual_dial_list_id : ''; ?>',
                'list_id': '<?php echo $this->session->userdata('vicidata')['listObj'] ? $this->session->userdata('vicidata')['listObj']->list_id : ''; ?>',
                'stage': 'lookup',
                'use_internal_dnc': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->use_internal_dnc : '' ?>',
                'use_campaign_dnc': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->use_campaign_dnc : '' ?>',
                'omit_phone_code': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->omit_phone_code : '' ?>',
                'manual_dial_filter': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->manual_dial_filter : '' ?>',
                'manual_dial_search_filter': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->manual_dial_search_filter : '' ?>',
                'vendor_lead_code': '',
                'usegroupalias': 0,
                'account': '',
                'agent_dialed_number': 1,
                'agent_dialed_type': 'MANUAL_DIALNOW',
                'vtiger_callback_id': 0,
                'dial_method': '<?php echo $this->session->userdata('vicidata')['campaignObj'] ? $this->session->userdata('vicidata')['campaignObj']->dial_method : '' ?>',
                'manual_dial_call_time_check': 'DISABLED',
                'qm_extension': '<?php echo $this->session->userdata('vicidata')['phoneObj'] ? $this->session->userdata('vicidata')['phoneObj']->extension : '' ?>',
                'dial_ingroup': '',
                'nocall_dial_flag': 'DISABLED',
                'cid_lock': 0
            };
            jQuery.ajax({
                'url': '<?php echo site_url('viciagent/vdc_db_query') ?>',
                'type': 'post',
                'dataType': 'json',
                'async': false,
                'data': postData,
                'success': function (result) {
                    console.log(result);
                    var flag = result.error;
                    if (flag == false) {
                        var MDnextResponse = result.message;
                        var MDnextResponse_array = MDnextResponse.split("\n");
                        LasTCID = MDnextResponse_array[0];
                        MDnextCID = MDnextResponse_array[0];
                        LastCallCID = MDnextResponse_array[0];

                        var regMNCvar = new RegExp("HOPPER EMPTY", "ig");
                        var regMDFvarDNC = new RegExp("DNC", "ig");
                        var regMDFvarCAMP = new RegExp("CAMPLISTS", "ig");
                        var regMDFvarTIME = new RegExp("OUTSIDE", "ig");
                        if ((MDnextCID.match(regMNCvar)) || (MDnextCID.match(regMDFvarDNC)) || (MDnextCID.match(regMDFvarCAMP)) || (MDnextCID.match(regMDFvarTIME))) {
                            if (MDnextCID.match(regMNCvar)) {
                                swal("Oops...", "<?php echo ("No more leads in the hopper for campaign:"); ?>\n" + campaign, "error");
                                alert_displayed = 1;
                                phoneError = false;
                            }
                            if (MDnextCID.match(regMDFvarDNC)) {
                                swal("Oops...", "<?php echo ("This phone number is in the DNC list:"); ?>\n" + mdnPhonENumbeR, "error");
                                alert_displayed = 1;
                                phoneError = false;
                            }

                            if (MDnextCID.match(regMDFvarCAMP)) {
                                swal("Oops...", "<?php echo ("This phone number is not in the campaign lists:"); ?>\n" + mdnPhonENumbeR, "error");
                                alert_displayed = 1;
                                phoneError = false;
                            }
                            if (MDnextCID.match(regMDFvarTIME)) {
                                swal("Oops...", "<?php echo ("This phone number is outside of the local call time:"); ?>\n" + mdnPhonENumbeR, "error");
                                alert_displayed = 1;
                                phoneError = false;
                            }
                            if (alert_displayed == 0) {
                                swal("Oops...", "<?php echo ("Unspecified error:"); ?>\n" + mdnPhonENumbeR + "|" + MDnextCID, "error");
                                alert_displayed = 1;
                                phoneError = false;
                            }
                        } else {
                            checkLeadStatus('Lead');
                            calltimer = setInterval(callTimer,1000);
                            jQuery('.outbound').show();                            
                            jQuery("#leadform").show();
                            document.leadform.lead_id.value = MDnextResponse_array[1];
                            document.leadform.list_id.value = MDnextResponse_array[5];
                            var first_name = typeof MDnextResponse_array[10] != 'undefined' ? MDnextResponse_array[10] : '';
                            var last_name = typeof MDnextResponse_array[12] != 'undefined' ? MDnextResponse_array[12] : '';
                            var name = last_name + ','+ first_name;                            
                            jQuery('.user-name').html(name);
                            jQuery('#lastlbl').html(last_name + ',');
                            jQuery('#firstlbl').html(first_name);
                            var number = phone_number_format(typeof MDnextResponse_array[8] != 'undefined' ? MDnextResponse_array[8] : jQuery('#to').val());
                            jQuery('#callnumber').html(number);
                            document.leadform.phone_number.value = typeof MDnextResponse_array[8] != 'undefined' ? MDnextResponse_array[8] : jQuery('#to').val();
                            document.leadform.first_name.value = typeof MDnextResponse_array[10] != 'undefined' ? MDnextResponse_array[10] : '';
                            document.leadform.last_name.value = typeof MDnextResponse_array[12] != 'undefined' ? MDnextResponse_array[12] : '';
                            document.leadform.address1.value = typeof MDnextResponse_array[13] != 'undefined' ? MDnextResponse_array[13] : '';
                            document.leadform.city.value = typeof MDnextResponse_array[16] != 'undefined' ? MDnextResponse_array[16] : '';
                            document.leadform.state.value = typeof MDnextResponse_array[17] != 'undefined' ? MDnextResponse_array[17] : '';
                            document.leadform.postal_code.value = typeof MDnextResponse_array[19] != 'undefined' ? MDnextResponse_array[19] : '';
                            document.leadform.email.value = typeof MDnextResponse_array[24] != 'undefined' ? MDnextResponse_array[24] : '';
                            document.leadform.called_count.value = typeof MDnextResponse_array[27] != 'undefined' ? MDnextResponse_array[27] : '';
                            timer_action = campaign_timer_action;
                            timer_action_message = campaign_timer_action_message;
                            timer_action_seconds = campaign_timer_action_seconds;
                            timer_action_destination = campaign_timer_action_destination;                            
                            phoneError = true;
                            dialCheck = setInterval('formManualDialCheckChannel("")',1000);
                        }
                    }
                }
            });
        }
        function formManualDialCheckChannel(taskCheckOR) {
            if (taskCheckOR == 'YES'){
                var CIDcheck = XDnextCID;
            }else{
                var CIDcheck = MDnextCID;
            }
            var postData = {
                is_ajax: true,
                server_ip: serverIp,
                session_name: sessionName,
                ACTION: 'manDiaLlookCaLL',
                conf_exten: sessionId,
                user: user,
                pass: pass,
                MDnextCID: CIDcheck,
                agent_log_id: agentLogId,
                lead_id: document.leadform.lead_id.value,
                DiaL_SecondS: MD_ring_secondS,
                stage: ''
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/vdc_db_query') ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    var MDlookResponse = null;
                    MDlookResponse = result.message;
                    var MDlookResponse_array = MDlookResponse.split("\n");
                    var MDlookCID = MDlookResponse_array[0];
                    lead_dial_number = document.leadform.lead_id.value;
                    var regMDL = new RegExp("^Local", "ig");
                    if (MDlookCID == "NO") {
                        MD_ring_secondS++;
                        var dispnum = document.getElementById('to').value;
                        var status_display_number = phone_number_format(dispnum);
                        if (alt_dial_status_display == '0') {
                            var status_display_content = '';
                            if (status_display_NAME > 0) {
                                status_display_content = status_display_content + " <?php echo ("Name:"); ?> " + document.leadform.first_name.value + " " + document.leadform.last_name.value;
                            }
                            if (status_display_CALLID > 0) {
                                status_display_content = status_display_content + " <?php echo ("UID:"); ?> " + CIDcheck;
                            }
                            if (status_display_LEADID > 0) {
                                status_display_content = status_display_content + " <?php echo ("Lead:"); ?> " + document.leadform.lead_id.value;
                            }
                            if (status_display_LISTID > 0) {
                                status_display_content = status_display_content + " <?php echo ("List:"); ?> " + document.leadform.list_id.value;
                            }
                            //console.log(" <?php echo ("Calling:"); ?> " + status_display_number + " " + status_display_content + " &nbsp; <?php echo ("Waiting for Ring..."); ?> " + MD_ring_secondS + " <?php echo ("seconds"); ?>");
                            document.getElementById("MainStatuSSpan").innerHTML = " <?php echo ("Calling:"); ?> " + status_display_number + " " + status_display_content + " &nbsp; <?php echo ("Waiting for Ring..."); ?> " + MD_ring_secondS + " <?php echo ("seconds"); ?>";
                        }
                    } else {
                        if (taskCheckOR == 'YES') {
                            console.log('YES' + MDlookResponse_array);
                            XDuniqueid = MDlookResponse_array[0];
                            XDchannel = MDlookResponse_array[1];
                            var XDalert = MDlookResponse_array[2];
                            if (XDalert == 'ERROR') {
                                var XDerrorDesc = MDlookResponse_array[3];
                                var XDerrorDescSIP = MDlookResponse_array[4];
                                var DiaLAlerTMessagE = "<?php echo ("Call Rejected:"); ?> " + XDchannel + "\n" + XDerrorDesc + "\n" + XDerrorDescSIP;
                                swal("Oops...", DiaLAlerTMessagE, "info");
                            }
                            if ((XDchannel.match(regMDL)) && (asterisk_version != '1.0.8') && (asterisk_version != '1.0.9') && (MD_ring_secondS < 10)) {
                                MD_ring_secondS++;
                            } else {
                                jQuery('#xferuniqueid').val(MDlookResponse_array[0]);
                                jQuery('#xferchannel').val(MDlookResponse_array[1]);
                                lastxferchannel = MDlookResponse_array[1];

                                jQuery('#xferlength').val('0');

                                XD_live_customer_call = 1;
                                XD_live_call_secondS = 0;
                                MD_channel_look = 0;

                                var called3rdparty = jQuery('#xfernumber').val();
                                if (hide_xfer_number_to_dial == 'ENABLED')
                                {
                                    called3rdparty = ' ';
                                }

                                var status_display_content = '';
                                if (status_display_NAME > 0) {
                                    status_display_content = status_display_content + " <?php echo ("Name:"); ?> " + document.leadform.first_name.value + " " + document.leadform.last_name.value;
                                }
                                if (status_display_CALLID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("UID:"); ?> " + CIDcheck;
                                }
                                if (status_display_LEADID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("Lead:"); ?> " + document.leadform.lead_id.value;
                                }
                                if (status_display_LISTID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("List:"); ?> " + document.leadform.list_id.value;
                                }

                                document.getElementById("MainStatuSSpan").innerHTML = " <?php echo ("Called 3rd party:"); ?> " + called3rdparty + " " + status_display_content;
                                

                                /* enable 3-way call button */
                                jQuery('#Leave3WayCall').removeClass('disabled');
                                jQuery('#Leave3WayCall').attr('onclick', "leave_3way_call('FIRST','YES');return false;");

                                jQuery('#DialWithCustomer').addClass('disabled');
                                jQuery('#DialWithCustomer').attr('onclick');

                                jQuery('#ParkCustomerDial').addClass('disabled');
                                jQuery('#ParkCustomerDial').attr('onclick');

                                jQuery('#HangupXferLine').removeClass('disabled');
                                jQuery('#HangupXferLine').attr('onclick', "xfercall_send_hangup('YES');return false;");

                                jQuery('#HangupBothLines').removeClass('disabled');
                                jQuery('#HangupBothLines').attr('onclick', "bothcall_send_hangup('YES');return false;");
                                xferchannellive = 1;
                                XDcheck = '';
                            }
                        } else { //if (taskCheckOR == 'YES'){
                            MDuniqueid = MDlookResponse_array[0];
                            MDchannel = MDlookResponse_array[1];
                            if(MDchannel1.lenght <= 0){
                                MDchannel1= MDlookResponse_array[1];
                            }
                            //console.log(MDlookResponse_array);
                            var MDalert = MDlookResponse_array[2];

                            if (MDalert == 'ERROR') {
                                var MDerrorDesc = MDlookResponse_array[3];
                                var MDerrorDescSIP = MDlookResponse_array[4];
                                var DiaLAlerTMessagE = "<?php echo ("Call Rejected:"); ?> " + MDchannel + "\n" + MDerrorDesc + "\n" + MDerrorDescSIP;
                                console.log(DiaLAlerTMessagE);
                                swal("Oops...", DiaLAlerTMessagE, "info");
                            }
                            
                            if ((MDchannel.match(regMDL)) && (asterisk_version != '1.0.8') && (asterisk_version != '1.0.9')) {
                                MD_ring_secondS++;
                            } else {
                                custchannellive = 1;
                                document.leadform.uniqueid.value = MDlookResponse_array[0];
                                document.getElementById("callchannel").value = MDlookResponse_array[1];
                                lastcustchannel = MDlookResponse_array[1];
                                //if( document.images ) { document.images['livecall'].src = image_livecall_ON.src;}
                                document.leadform.SecondS.value = 0;
                                //document.getElementById("SecondSDISP").innerHTML = '0';

                                VD_live_customer_call = 1;
                                VD_live_call_secondS = 0;
                                customer_sec = 0;

                                MD_channel_look = 0;
                                var dispnum = document.leadform.phone_number.value;
                                
                                var status_display_number = phone_number_format(dispnum);
                                var status_display_content = '';

                                if (status_display_NAME > 0) {
                                    status_display_content = status_display_content + " <?php echo ("Name:"); ?> " + document.leadform.first_name.value + " " + document.leadform.last_name.value;
                                }
                                if (status_display_CALLID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("UID:"); ?> " + CIDcheck;
                                }
                                if (status_display_LEADID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("Lead:"); ?> " + document.leadform.lead_id.value;
                                }
                                if (status_display_LISTID > 0) {
                                    status_display_content = status_display_content + " <?php echo ("List:"); ?> " + document.leadform.list_id.value;
                                }

                                document.getElementById("MainStatuSSpan").innerHTML = " <?php echo ("Called:"); ?> " + status_display_number + " " + status_display_content + " &nbsp;";
                                //console.log(" <?php echo ("Called here else:"); ?> " + status_display_number + " " + status_display_content);

                                                                
                                //jQuery('#LocalCloser').removeClass('disabled');
                                //jQuery('#LocalCloser').prop('onclick',"mainxfer_send_redirect('XfeRLOCAL','" + lastcustchannel + "','" + lastcustserverip + "','','','','YES');return false;");
                                
                               // jQuery('#ParkControl').removeClass('disabled');
                               // jQuery('#ParkControl').attr('onclick', 'mainxfer_send_redirect("ParK","' + lastcustchannel + '","' + lastcustserverip + '","","","","YES")');

                                jQuery('#HangupControl').removeClass('disabled');
                                jQuery('#HangupControl').attr('onclick', 'dialedcall_send_hangup("","","","","YES")');

                                jQuery('#LocalCloser').removeClass('disabled');
                                jQuery('#LocalCloser').attr('onclick', 'mainxfer_send_redirect("XfeRLOCAL","' + lastcustchannel + '","' + lastcustserverip + '","","","","YES")');                                                                
                                    
                                jQuery('#DialBlindTransfer').removeClass('disabled');
                                jQuery('#DialBlindTransfer').attr('onclick', 'mainxfer_send_redirect("XfeRBLIND","' + lastcustchannel + '","' + lastcustserverip + '","","","","YES")');

                                jQuery('#DialWithCustomer').removeClass('disabled');                               
                                jQuery('#ParkCustomerDial').removeClass('disabled');
                                if(logstart == 0){
                                    dialLog("start");
                                    //jQuery('#countdown').countup();
                                }
                                custchannellive = 1;
                            }
                            //DialLog("start");
                        } //if (taskCheckOR == 'YES'){ else
                        
                    }

                } //success : function(result)
            });
            if ((MD_ring_secondS > 59) && (MD_ring_secondS > manual_dial_timeout)) {
                clearInterval(dialCheck);
                MD_channel_look=0;
                MD_ring_secondS=0;
                swal("Oops...", "<?php echo ("Dial timed out, contact your system administrator"); ?>", "info");
            }
        }
        function hangupDispo() {
            if (sessionId.length <= 0) {
                alert("Something went wrong.")
                return;
            }
            var dispo = jQuery('[name="dispo"]').val();
            if(dispo.length <= 0 ){
                swal('Opps..', 'Please select disposition.','error');
                return;
            }
            var postData = {
                'is_ajax': true,
                'server_ip': serverIp,
                'session_name': sessionName,
                'ACTION': 'updateDISPO',
                'format': 'text',
                'user': user,
                'pass': pass,
                'orig_pass': pass,
                'dispo_choice': jQuery('[name="dispo"]').val(),
                'lead_id': jQuery('[name="lead_id"]').val(),
                'campaign': campaign,
                'auto_dial_level': '1.0',
                'agent_log_id': agentLogId,
                'CallBackDatETimE': '',
                'list_id': jQuery('[name="list_id"]').val(),
                'recipient': '',
                'use_internal_dnc': 'N',
                'use_campaign_dnc': 'N',
                'MDnextCID': LasTCID,
                'stage': campaign,
                'vtiger_callback_id': 0,
                'phone_number': jQuery('[name="phone_number"]').val(),
                'phone_code': '1',
                'dial_method': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : "" ?>',
                'uniqueid': jQuery('[name="uniqueid"]').val(),
                'CallBackLeadStatus': '',
                'comments': '',
                'custom_field_names': '|',
                'call_notes': '',
                'dispo_comments': '',
                'cbcomment_comments': '',
                'qm_dispo_code': '',
                'email_enabled': 0,
                'recording_id': '',
                'recording_filename': '',
                'called_count': jQuery('[name="called_count"]').val(),
                'parked_hangup': 0,
                'phone_login': phoneLogin,
                'agent_email': '',
                'conf_exten': sessionId,
                'camp_script': '',
                'in_script': '',
                'customer_server_ip': '',
                'exten': '<?php echo $this->session->userdata('vicidata')['phoneObj']->extension ?>',
                'original_phone_login': phoneLogin,
                'phone_pass': phonePass
            };
            jQuery('#loading').modal('show');
            clearInterval(dialCheck);
            jQuery.ajax({
                'url': '<?php echo site_url('viciagent/vdc_db_query') ?>',
                'type': 'post',
                'dataType': 'json',
                'data': postData,
                'success': function (result) {
                    console.log(result);
                    var check_dispo = null;
                    check_dispo = result.message;
                    var check_DS_array = check_dispo.split("\n");
                    if (auto_dial_level < 1) {
                        if (check_DS_array[1] == 'Next agent_log_id:') {
                            agent_log_id = check_DS_array[2];
                        }
                    } //if (auto_dial_level < 1){
                    if (check_DS_array[3] == 'Dispo URLs:') {
                        dispo_urls = check_DS_array[4];
                        //sendURLs(dispo_urls, "dispo");
                    } //if (check_DS_array[3] == 'Dispo URLs:'){                                       
                    jQuery('#MainStatuSSpan').html('');
                    jQuery('#leadform').hide();
                    jQuery('#responsive').modal('hide');                                      
                    clearView();
                    jQuery('#loading').modal('hide');
                }
            });
            MD_channel_look=0;
            MD_ring_secondS=0;
            VD_live_customer_call = 0;
            VD_live_call_secondS = 0;
            MD_ring_secondS = 0;
            CalLCID = '';
            MDnextCID = '';
            logstart = 0;             
            XD_live_customer_call = 0;
            XDchannel = '';
           // jQuery('#countdown').detach();
           // jQuery('#phone_dialer').prepend('<div id="countdown"></div>');            
            jQuery('#xferlength').val('');
            jQuery('#xferchannel').val('');
            customerparked = 0;
            customerparkedcounter = 0;
            jQuery('#ParkControl').hide();
            jQuery('#ParkCounterSpan').html('');
            clearLeadData();
        }
        /*Manual dial call log function*/
       
        function dialLog(taskMDstage,nodeletevdac){
            var alt_num_status = 0;
            if (taskMDstage == "start"){
                MDlogEPOCH = 0;
                logstart++;
                var UID_test = document.leadform.uniqueid.value;
                if (UID_test.length < 4){
                    UID_test = epoch_sec + '.' + random;                    
                    jQuery('#uniqueid').val(UID_test);    
                }
            }else{
                
            }
            
            var postData = {
                is_ajax : true,
                format : 'text',
                server_ip : serverIp,
                session_name : sessionName,
                ACTION : 'manDiaLlogCaLL',
                stage : taskMDstage,
                uniqueid : jQuery('#uniqueid').val(),
                user : user,
                pass : pass,
                campaign : campaign,
                lead_id : document.leadform.lead_id.value,
                list_id : document.leadform.list_id.value,
                length_in_sec : '0',
                phone_code : '1',
                phone_number :  document.leadform.phone_number.value,
                exten : '<?php echo $this->session->userdata('vicidata')['phoneObj']->extension ?>',
                channel : lastcustchannel,
                start_epoch : MDlogEPOCH,
                auto_dial_level : auto_dial_level,
                VDstop_rec_after_each_call : VDstop_rec_after_each_call,
                conf_silent_prefix : conf_silent_prefix,
                protocol : protocol,
                extension : '<?php echo $this->session->userdata('vicidata')['phoneObj']->extension ?>',
                ext_context : ext_context,
                conf_exten : sessionId,
                user_abb : user_abb,
                agent_log_id : agentLogId,
                MDnextCID : LasTCID,
                inOUT : inOUT,
                alt_dial : 'MANUAL',
                DB : '0',
                agentchannel : agentchannel,
                conf_dialed : conf_dialed,
                leaving_threeway : leaving_threeway,
                hangup_all_non_reserved : hangup_all_non_reserved,
                blind_transfer : blind_transfer,
                dial_method : dial_method,
                nodeletevdac : nodeletevdac,
                alt_num_status : alt_num_status,
                qm_extension : phoneLogin,
                called_count : document.leadform.called_count.value
            };
           // console.log('DialLog');
           // console.log(postData);
            jQuery.ajax({
                url : '<?php echo site_url('viciagent/vdc_db_query') ?>',
                method : 'post',
                dataType : 'json',
                data : postData,
                success : function(result){                    
                    console.log(result);
                    console.log(postData);
                    /*var MDlogResponse = null;
                    MDlogResponse = result.message;
                    var MDlogResponse_array=MDlogResponse.split("\n");
                    if ( (MDlogLINE == "LOG NOT ENTERED") && (VDstop_rec_after_each_call != 1) ){
                        
                    }else{
                        
                    }
                    MDlogRecorDings = MDlogResponse_array[3];
                    if(window.MDlogRecorDings){
                        var MDlogRecorDings_array=MDlogRecorDings.split("|");
                        var RecDispNamE = MDlogRecorDings_array[2];
                        last_recording_filename = MDlogRecorDings_array[2];
                        if (RecDispNamE.length > 25){
                            RecDispNamE = RecDispNamE.substr(0,22);
                            RecDispNamE = RecDispNamE + '...';
                        }
                        document.getElementById("RecorDingFilename").innerHTML = RecDispNamE;
                        document.getElementById("RecorDID").innerHTML = MDlogRecorDings_array[3];                        
                    }*/
                }
            });
            
        }
        /** update lead information */
        function updateLead() {
            if(calltimer){
                clearInterval(calltimer);
            }
            jQuery('#responsive').modal({
                backdrop: 'static',
                keyboard: false
            });
            var postData = {
                'is_ajax': true,
                'ACTION': 'updateLEAD',
                'address1': jQuery('[name="address1"]').val(),
                'address2': '',
                'address3': '',
                'alt_phone': '',
                'campaign': campaign,
                'city': jQuery('[name="city"]').val(),
                'comments': jQuery('[name="comments"]').val(),
                'country_code': '',
                'date_of_birth': '',
                'email': jQuery('[name="email"]').val(),
                'first_name': jQuery('[name="first_name"]').val(),
                'format': 'text',
                'gender': '',
                'last_name': jQuery('[name="last_name"]').val(),
                'lead_id': jQuery('[name="lead_id"]').val(),
                'middle_initial': '',
                'pass': pass,
                'phone_number': jQuery('[name="phone_number"]').val(),
                'postal_code': jQuery('[name="postal_code"]').val(),
                'province': '',
                'security_phrase': '',
                'server_ip': serverIp,
                'session_name': sessionName,
                'state': jQuery('[name="state"]').val(),
                'title': '',
                'user': user,
                'vendor_lead_code': ''
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/vdc_db_query') ?>',
                type: 'post',
                data: postData,
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                }
            });
        }
        function setDispo(dispo) {
            jQuery('[name="dispo"]').val(dispo);
            jQuery('.status-link').removeClass('selected');
            jQuery('#' + dispo).addClass('selected');
        }
        function clearView() {
            jQuery("#btn_phone").hide();
            jQuery(".main_menu-phone-icon").show();
            jQuery('#callnumber').val('');
            jQuery('#to').val('');
            document.getElementById("RecorDingFilename").value = '';
            document.getElementById("RecorDID").value = '';
            jQuery('#uniqueid').val('');
            jQuery('#callchannel').val('');
            selectAgent = 0;
        }
        function clearLeadData(){
            jQuery('#callnumber').html('');
            jQuery('.user-name').html('');
            jQuery('#lastlbl').html('');
            jQuery('#firstlbl').html('');            
            jQuery('#lead_id').val('');
            jQuery('#list_id').val('');
            jQuery('#called_count').val('');
            jQuery('#state').val('');
            jQuery('#callserverip').val('');
            jQuery('#dispo').val('');
            jQuery('#uniqueid').val('');
            jQuery('#phone_number').val('');
            jQuery('#last_name').val('');
            jQuery('#email').val('');
            jQuery('#address1').val('');
            jQuery('#first_name').val('');            
        }
        function checkLeadStatus(value){
            jQuery('#leadstatus').html(value + '<i class="fa fa-angle-down"></i>');
        }
        function checkStatus() {
            var postData = {
                is_ajax: true,
                agent_user: '<?php echo $this->session->userdata('vicidata')['user'] ?>',
                stage: 'pipe',
                header: 'YES'
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/checkstatus') ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    var msg = result.message;
                    var Response_array = msg.split("\n");
                    var status = Response_array[1].split('|');
                    var agentStatus = status[0].trim();
                    switch (agentStatus) {
                        case 'PAUSED':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-busy');
                            jQuery('#phone_status .user-status-current').html('Pause');
                            clearInterval(interval);
                            break;
                        case 'READY':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-online');
                            jQuery('#phone_status .user-status-current').html('Online');
                            interval = setInterval(checkIncoming, 1000);
                            break;
                        case 'INCALL':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-busy');
                            jQuery('#phone_status .user-status-current').html('Busy');
                            clearInterval(interval);
                            break;
                        case 'QUEUE':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-away');
                            jQuery('#phone_status .user-status-current').html('Away');
                            clearInterval(interval);
                            break;
                        case 'CLOSER':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-online');
                            jQuery('#phone_status .user-status-current').html('Online');
                            interval = setInterval(checkIncoming, 1000);
                            break;
                        case 'MQUEUE':
                            jQuery('#phone_status i').attr('class', 'fa fa-square status-away');
                            jQuery('#phone_status .user-status-current').html('Pause');
                            clearInterval(interval);
                            break;
                    }
                }
            });
        }
        function changeStatus(status) {
            var actual = '';
            switch (status) {
                case 'ready':
                    actual = 'READY'
                    break;
                case 'incall':
                    actual = 'INCALL'
                    break;
                case 'paused':
                    actual = 'PAUSED';
                    break;
                case 'away':
                    actual = 'PAUSED'
                    break;
                case 'closer':
                    actual = 'CLOSER';
                    break;
            }
            var postData = {
                is_ajax: true,
                status: actual,
            }
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/changestatus') ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    checkStatus();
                }
            });
        }
        function checkIncoming() {
            var postData = {
                is_ajax: true,
                server_ip: serverIp,
                session_name: sessionName,
                user: user,
                pass: pass,
                orig_pass: pass,
                campaign: campaign,
                ACTION: 'VDADcheckINCOMING',
                agent_log_id: agentLogId,
                phone_login: phoneLogin,
                agent_email: '<?php echo $this->session->userdata('user')->email_id ?>',
                conf_exten: sessionId,
                camp_script: '',
                in_script: '',
                customer_server_ip: '',
                exten: '<?php echo $this->session->userdata('vicidata')['phoneObj']->extension ?>',
                original_phone_login: phoneLogin,
                phone_pass: phonePass,
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/vdc_db_query') ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    console.log(result);
                    var check_incoming = null;
                    check_incoming = result.message;
                    var check_VDIC_array = check_incoming.split("\n");
                    if (check_VDIC_array[0] == '1'){
                        AutoDialWaiting = 0;
                        QUEUEpadding = 0;
                        UpdatESettingSChecK = 1;
                        
                        var VDIC_data_VDAC = check_VDIC_array[1].split("|");
                        
                        var call_timer_action = VDIC_data_VDIG[18];
                        if ( (call_timer_action == 'NONE') || (call_timer_action.length < 2) ){
                            timer_action = campaign_timer_action;
                            timer_action_message = campaign_timer_action_message;
                            timer_action_seconds = campaign_timer_action_seconds;
                            timer_action_destination = campaign_timer_action_destination;                            
                        }else{
                            var call_timer_action_message = VDIC_data_VDIG[19];
                            var call_timer_action_seconds = VDIC_data_VDIG[20];
                            var call_timer_action_destination = VDIC_data_VDIG[27];
                            timer_action = call_timer_action;
                            timer_action_message = call_timer_action_message;
                            timer_action_seconds = call_timer_action_seconds;
                            timer_action_destination = call_timer_action_destination;  
                            
                            document.leadform.callserverip.value	= VDIC_data_VDAC[4];
                        }

                    } //if (check_VDIC_array[0] == '1'){
                }
            });
        }
        function recordingApi(action) {
            var conf_silent_prefix = '5';
            var channelrec = "Local/" + conf_silent_prefix + '' + sessionId + "@" + '<?php echo $this->session->userdata('vicidata')['phoneObj']->ext_context ?>';
            //var channelrec = 'local/8304';
            query_recording_exten = '<?php echo $this->session->userdata('vicidata')['phoneObj']->recording_exten ?>';
            LIVE_campaign_rec_filename = '<?php echo $this->session->userdata('vicidata')['campaignObj']->campaign_rec_filename ?>';
            VDCL_group_id = '';
            lead_dial_number = document.leadform.lead_id.value;
            tinydate = '';
            LasTCID = '';
            taskapiappend = '';
            if (action == 'MonitorConf') {
                var REGrecCLEANvlc = new RegExp(" ", "g");
                var recVendorLeadCode = '';
                recVendorLeadCode = recVendorLeadCode.replace(REGrecCLEANvlc, '');
                var recLeadID = document.leadform.lead_id.value;
                var REGrecCAMPAIGN = new RegExp("CAMPAIGN", "g");
                var REGrecINGROUP = new RegExp("INGROUP", "g");
                var REGrecCUSTPHONE = new RegExp("CUSTPHONE", "g");
                var REGrecFULLDATE = new RegExp("FULLDATE", "g");
                var REGrecTINYDATE = new RegExp("TINYDATE", "g");
                var REGrecEPOCH = new RegExp("EPOCH", "g");
                var REGrecAGENT = new RegExp("AGENT", "g");
                var REGrecVENDORLEADCODE = new RegExp("VENDORLEADCODE", "g");
                var REGrecLEADID = new RegExp("LEADID", "g");
                var REGrecCALLID = new RegExp("CALLID", "g");

                filename = LIVE_campaign_rec_filename + '' + taskapiappend;
                filename = filename.replace(REGrecCAMPAIGN, campaign);
                filename = filename.replace(REGrecINGROUP, VDCL_group_id);
                filename = filename.replace(REGrecCUSTPHONE, lead_dial_number);
                filename = filename.replace(REGrecFULLDATE, '<?php echo date("Ymd-His") ?>');
                filename = filename.replace(REGrecTINYDATE, tinydate);
                filename = filename.replace(REGrecEPOCH, epoch_sec++);
                filename = filename.replace(REGrecAGENT, user);
                filename = filename.replace(REGrecVENDORLEADCODE, recVendorLeadCode);
                filename = filename.replace(REGrecLEADID, recLeadID);
                filename = filename.replace(REGrecCALLID, LasTCID);
            }
            if (action == 'StopMonitorConf') {
                filename = document.leadform.RecorDingFilename.value;
            }
            var postData = {
                is_ajax: true,
                server_ip: serverIp,
                session_name: sessionName,
                user: user,
                pass: pass,
                ACTION: action,
                format: 'text',
                channel: channelrec,
                'filename': filename,
                exten: query_recording_exten,
                ext_context: '<?php echo $this->session->userdata('vicidata')['phoneObj']->ext_context ?>',
                lead_id: document.leadform.lead_id.value,
                ext_priority: 1,
                FROMvdc: 'YES',
                uniqueid: '',
                FROMapi: ''
            };
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/record') ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    var RClookResponse = null;
                    RClookResponse = result.message;

                    var RClookResponse_array = RClookResponse.split("\n");
                    var RClookFILE = RClookResponse_array[1];
                    var RClookID = RClookResponse_array[2];
                    var RClookFILE_array = RClookFILE.split("Filename: ");
                    var RClookID_array = RClookID.split("RecorDing_ID: ");

                    if (RClookID_array.length > 0) {
                        recording_filename = RClookFILE_array[1];
                        recording_id = RClookID_array[1];

                        var RecDispNamE = RClookFILE_array[1];
                        last_recording_filename = RClookFILE_array[1];

                        document.getElementById("RecorDingFilename").value = RecDispNamE;
                        document.getElementById("RecorDID").value = RClookID_array[1];
                    }
                }
            });

            /*var postData = {
             is_ajax : true,
             function : 'recording',
             value : value,
             agent_user : user,
             };
             jQuery.ajax({
             url : '<?php echo site_url('viciagent/agentapicall') ?>',
             method : 'post',
             dataType : 'json',
             data : postData,
             success : function(result){
             console.log(result);
             }
             });*/
        }
        disable_alter_custphone = 'SHOW';
        vdc_header_phone_format = 'US_DASH 000-000-0000';
        function phone_number_format(formatphone) {
            // customer_local_time, status date display 9999999999
            //  vdc_header_phone_format
            //  US_DASH 000-000-0000 - USA dash separated phone number<br />
            //  US_PARN (000)000-0000 - USA dash separated number with area code in parenthesis<br />
            //  UK_DASH 00 0000-0000 - UK dash separated phone number with space after city code<br />
            //  AU_SPAC 000 000 000 - Australia space separated phone number<br />
            //  IT_DASH 0000-000-000 - Italy dash separated phone number<br />
            //  FR_SPAC 00 00 00 00 00 - France space separated phone number<br />
            var regUS_DASHphone = new RegExp("US_DASH", "g");
            var regUS_PARNphone = new RegExp("US_PARN", "g");
            var regUK_DASHphone = new RegExp("UK_DASH", "g");
            var regAU_SPACphone = new RegExp("AU_SPAC", "g");
            var regIT_DASHphone = new RegExp("IT_DASH", "g");
            var regFR_SPACphone = new RegExp("FR_SPAC", "g");
            var status_display_number = formatphone;
            var dispnum = formatphone;
            if (disable_alter_custphone == 'HIDE') {
                var status_display_number = 'XXXXXXXXXX';
                var dispnum = 'XXXXXXXXXX';
            }
            if (vdc_header_phone_format.match(regUS_DASHphone)) {
                var status_display_number = dispnum.substring(0, 3) + '-' + dispnum.substring(3, 6) + '-' + dispnum.substring(6, 10);
            }
            if (vdc_header_phone_format.match(regUS_PARNphone)) {
                var status_display_number = '(' + dispnum.substring(0, 3) + ')' + dispnum.substring(3, 6) + '-' + dispnum.substring(6, 10);
            }
            if (vdc_header_phone_format.match(regUK_DASHphone)) {
                var status_display_number = dispnum.substring(0, 2) + ' ' + dispnum.substring(2, 6) + '-' + dispnum.substring(6, 10);
            }
            if (vdc_header_phone_format.match(regAU_SPACphone)) {
                var status_display_number = dispnum.substring(0, 3) + ' ' + dispnum.substring(3, 6) + ' ' + dispnum.substring(6, 9);
            }
            if (vdc_header_phone_format.match(regIT_DASHphone)) {
                var status_display_number = dispnum.substring(0, 4) + '-' + dispnum.substring(4, 7) + '-' + dispnum.substring(8, 10);
            }
            if (vdc_header_phone_format.match(regFR_SPACphone)) {
                var status_display_number = dispnum.substring(0, 2) + ' ' + dispnum.substring(2, 4) + ' ' + dispnum.substring(4, 6) + ' ' + dispnum.substring(6, 8) + ' ' + dispnum.substring(8, 10);
            }

            return status_display_number;
        }
        /* check current live users */
        window.onload = function () {
            //jQuery('body').append('<p id="MainStatuSSpan" style="font-weight:bold;color:#ED6B75;display:block;position:fixed;text-align:center;top:0;width:100%;z-index:10000;"></p>')
            //connectCall();
            agentSelectLink();
            /* set ingroup call */
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/setingroup') ?>',
                method: 'post',
                success: function () {

                }
            });
         startStatus();
         setInterval(function(){
                all_refresh();
                check_for_conf_calls(sessionId,'');
          },1000);
        };
        function all_refresh(){
            if (VD_live_customer_call == 1){
                VD_live_call_secondS++;
                document.leadform.SecondS.value = VD_live_call_secondS;
            }
            //console.log('MD_channel_look :: '+MD_channel_look);            
            if (XDcheck == 'YES'){
                console.log("XDcheck :"+ XDcheck);
                formManualDialCheckChannel(XDcheck);
            }
            if (customerparked == 1){
                customerparkedcounter++;
                var parked_mm = Math.floor(customerparkedcounter/60);  // The minutes
                var parked_ss = customerparkedcounter % 60;              // The balance of seconds
                if (parked_ss < 10)
                    {parked_ss = "0" + parked_ss;}
                var parked_mmss = parked_mm + ":" + parked_ss;
                document.getElementById("ParkCounterSpan").innerHTML = "<?php echo ("Time On Park:"); ?> " + parked_mmss;
            }
            if (XD_live_customer_call == 1){
                XD_live_call_secondS++;
                jQuery('#xferlength').val(XD_live_call_secondS);
            }            
        }
        var ar_refresh1 = <?php echo 1; ?>;
        var ar_seconds1 = <?php echo 1; ?>;
        var $start_count1 = 0;
        function startStatus() {
            if ($start_count1 < 1) {
                agentStatus();              
            }
            $start_count1++;
            if (ar_seconds1 > 0) {
                ar_seconds1 = (ar_seconds1 - 1);
                setTimeout("startStatus()", 1000);                
            } else {
                ar_seconds1 = ar_refresh1;
                agentStatus();
                setTimeout("startStatus()", 1000);
            }
        }
        function agentStatus() {
            jQuery.ajax({
                url: '<?php echo site_url('viciagent/liveagents') ?>',
                method: 'post',
                dataType: 'json',
                data: {is_ajax: true},
                success: function (data) {
                    var currentAgent = '<?php echo $this->session->userdata('agent')->id; ?>';
                    jQuery.each(data, function (key, val) {
                        var status = data[key].status;
                        switch (status) {
                            case 'offline':
                                jQuery('#media-' + data[key].crmagentid).attr('class', 'media media-offline');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').html('Offline');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').css('color', 'grey');
                                break;
                            case 'PAUSED':
                                jQuery('#media-' + data[key].crmagentid).attr('class', 'media media-pause');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').html('Pause');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').css('color', 'red');
                                break;
                            case 'CLOSER':
                            case 'READY':
                                jQuery('#media-' + data[key].crmagentid).attr('class', 'media media-online');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').html('Online');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').css('color', 'green');
                                break;
                            case 'INCALL':
                            case 'QUEUE':
                                jQuery('#media-' + data[key].crmagentid).attr('class', 'media media-pause');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').html('Pause');
                                jQuery('#media-' + data[key].crmagentid).find('.status-text').css('color', 'red');
                                break;
                        }
                        if(selectAgent == 1){
                            jQuery('.select-link').show();
                        }else{
                            jQuery('.select-link').hide();
                        }
                        checkCurrentUser(data[key].crmagentid, status);
                    });
                    // checkStatus();
                }
            });
        }
        function checkCurrentUser(userId, status) {
            var currentAgent = '<?php echo $this->session->userdata('agent')->id; ?>';
            if (userId == currentAgent) {
                switch (status) {
                    case 'PAUSED':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-busy');
                        jQuery('#phone_status .user-status-current').html('Pause');
                        clearInterval(interval);
                        break;
                    case 'READY':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-online');
                        jQuery('#phone_status .user-status-current').html('Online');
                        break;
                    case 'INCALL':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-busy');
                        jQuery('#phone_status .user-status-current').html('Busy');
                        clearInterval(interval);
                        break;
                    case 'QUEUE':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-away');
                        jQuery('#phone_status .user-status-current').html('Away');
                        break;
                    case 'CLOSER':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-online');
                        jQuery('#phone_status .user-status-current').html('Online');
                        break;
                    case 'MQUEUE':
                        jQuery('#phone_status i').attr('class', 'fa fa-square status-away');
                        jQuery('#phone_status .user-status-current').html('Pause');
                        clearInterval(interval);
                        break;
                }
            }
        }
        /* call transfer functions */
        function agentSelectLink() {
            var XfeRSelecT = document.getElementById("XfeRGrouP");
            var XScheck = XfeRSelecT.value;
            if (XScheck.match(/AGENTDIRECT/i)) {
                jQuery('#agentdirectlink').show();
            } else {
                jQuery('#agentdirectlink').hide();
            }
        }
        
        function agentSelectLaunch() {
            var XfeRSelecT = document.getElementById("XfeRGrouP");
            var XScheck = XfeRSelecT.value;
            selectAgent = 0;
            if (XScheck.match(/AGENTDIRECT/i)) {
                jQuery('.quick-sidebar-toggler').trigger('click');
                selectAgent = 1;
            }            
        }
        // ################################################################################
        // Send Redirect command for live call to Manager sends phone name where call is going to
        // Covers the following types: XFER, VMAIL, ENTRY, CONF, PARK, FROMPARK, XfeRLOCAL, XfeRINTERNAL, XfeRBLIND, VfeRVMAIL        
        function mainxfer_send_redirect(taskvar,taskxferconf,taskserverip,taskdebugnote,taskdispowindow,tasklockedquick,MSRclick){
            var XfeRSelecT = document.getElementById("XfeRGrouP");
            var XfeR_GrouP = XfeRSelecT.value;
            var ADvalue = jQuery('#xfernumber').val();
            if (CalLCID.length < 1){
                CalLCID = MDnextCID;
            }
            
            if(((taskvar == 'XfeRLOCAL') || (taskvar == 'XfeRINTERNAL') ) && (XfeR_GrouP.match(/AGENTDIRECT/i)) && (ADvalue.length < 2)){
                swal('Oops...','<?php echo "YOU MUST SELECT AN AGENT TO TRANSFER TO WHEN USING AGENTDIRECT" ?>','info');                
            }else{
                //var redirectvalue = agentchannel;
                var redirectvalue = MDchannel;
                var redirectserverip = lastcustserverip;
                if (redirectvalue.length < 2){
                    redirectvalue = lastcustchannel
                }
                if((taskvar == 'XfeRBLIND') || (taskvar == 'XfeRVMAIL')){
                   if (tasklockedquick > 0){
                       jQuery('#xfernumber').val(quick_transfer_button_orig);
                   }
                   var queryCID = "XBvdcW" + epoch_sec + user_abb;
                   var blindxferdialstring = jQuery('#xfernumber').val();
                   var blindxferhiddendialstring = jQuery('#xfernumhidden').val();                   
                   if ( (blindxferdialstring.length < 1) && (blindxferhiddendialstring.length > 0) ){
                       blindxferdialstring = blindxferhiddendialstring;
                   }
                   var regXFvars = new RegExp("XFER","g");
                   if (blindxferdialstring.match(regXFvars)){
                       var regAXFvars = new RegExp("AXFER","g");
                       if (blindxferdialstring.match(regAXFvars)){
                           var Ctasknum = blindxferdialstring.replace(regAXFvars, '');
                           if (Ctasknum.length < 2){
                               Ctasknum = '83009';
                           }
                           var closerxfercamptail = '_L';
                           if (closerxfercamptail.length < 3){
                               closerxfercamptail = 'IVR';
                           }
                           blindxferdialstring = Ctasknum + '*' + document.leadform.phone_number.value + '*' + document.leadform.lead_id.value + '*' + campaign + '*' + closerxfercamptail + '*' + user + '**' + VD_live_call_secondS + '*';
                       }
                   }else{
                       if((jQuery('#xferoverride').is(':checked')==false) || (manual_dial_override_field == 'DISABLED')){
                            if (three_way_dial_prefix == 'X') {var temp_dial_prefix = '';}
                            else {var temp_dial_prefix = three_way_dial_prefix;}
                            if (omit_phone_code == 'Y') {var temp_phone_code = '';}
                            else {var temp_phone_code = document.leadform.phone_code.value;}

                            if (blindxferdialstring.length > 7)
                            {blindxferdialstring = temp_dial_prefix + "" + temp_phone_code + "" + blindxferdialstring;}                           
                       }
                   }
                   var blindxfercontext = ext_context;
                   no_delete_VDAC = 0;
                   if (blindxferdialstring.length<'1'){
                       xferredirect_query = '';
                       taskvar = 'NOTHING';
                       swal('Oops..',"<?php echo "Transfer number must have at least 1 digit:" ?>" + blindxferdialstring);                       
                       return;
                    }else{
                        xferredirect_query = {
                            is_ajax : true,
                            server_ip : serverIp,
                            session_name : sessionName,
                            user : user,
                            pass : pass,
                            ACTION : 'RedirectVD',
                            format : 'text',
                            channel : redirectvalue,
                            call_server_ip : redirectserverip,
                            queryCID : queryCID,
                            exten : blindxferdialstring,
                            ext_context : blindxfercontext,
                            ext_priority : '1',
                            auto_dial_level : auto_dial_level,
                            campaign : campaign,
                            uniqueid : jQuery('#uniqueid').val(),
                            lead_id : document.leadform.lead_id.value,
                            secondS : VD_live_call_secondS,
                            session_id : sessionId,
                            nodeletevdac : no_delete_VDAC,
                            preset_name : jQuery('#xfername').val(),
                            CalLCID : CalLCID,
                            customerparked : customerparked
                        };
                        //xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectVD&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + blindxferdialstring + "&ext_context=" + blindxfercontext + "&ext_priority=1&auto_dial_level=" + auto_dial_level + "&campaign=" + campaign + "&uniqueid=" + document.leadform.uniqueid.value + "&lead_id=" + document.leadform.lead_id.value + "&secondS=" + VD_live_call_secondS + "&session_id=" + sessionId + "&nodeletevdac=" + no_delete_VDAC + "&preset_name=" + jQuery('#xfername').val() + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;                        
                    }
                } //if ( (taskvar == 'XfeRBLIND') || (taskvar == 'XfeRVMAIL') ){
                
                if (taskvar == 'XfeRINTERNAL'){
                    var closerxferinternal = '';
                    taskvar = 'XfeRLOCAL';
                }else{
                    var closerxferinternal = '9';
                }
                
                if (taskvar == 'XfeRLOCAL'){
                    if (consult_custom_sent < 1){
                        // To Do :: implement CustomerData_update()
                        CustomerData_update();
                    }
                    jQuery('#xfername').val('');
                    var XfeRSelecT = document.getElementById("XfeRGrouP");
                    dialed_number = jQuery('phone_number').val();
                    var XfeR_GrouP = XfeRSelecT.value;
                    if (tasklockedquick > 0)
                        {XfeR_GrouP = quick_transfer_button_orig;}
                    var queryCID = "XLvdcW" + epoch_sec + user_abb;
                    var redirectdestination = closerxferinternal + '90009*' + XfeR_GrouP + '**' + jQuery('#lead_id').val() + '**' + dialed_number + '*' + user + '*' + jQuery('#xfernumber').val() + '*';
                        xferredirect_query = {
                            is_ajax : true,
                            server_ip : serverIp,
                            session_name : sessionName,
                            user : user,
                            pass : pass,
                            ACTION : 'RedirectVD',
                            format : 'text',
                            channel : redirectvalue,
                            call_server_ip : redirectserverip,
                            queryCID : queryCID,
                            exten : redirectdestination,
                            ext_context : ext_context,
                            ext_priority : '1',
                            auto_dial_level : auto_dial_level,
                            campaign : campaign,
                            uniqueid : jQuery('#uniqueid').val(),
                            lead_id : document.leadform.lead_id.value,
                            secondS : VD_live_call_secondS,
                            session_id : sessionId,
                            nodeletevdac : no_delete_VDAC,
                            preset_name : jQuery('#xfername').val(),
                            CalLCID : CalLCID,
                            customerparked : customerparked
                        };                    
                   // xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectVD&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1&auto_dial_level=" + auto_dial_level + "&campaign=" + campaign + "&uniqueid=" + jQuery('#uniqueid').val() + "&lead_id=" + jQuery('#lead_id').val() + "&secondS=" + VD_live_call_secondS + "&session_id=" + sessionId + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;                    
                } //if (taskvar == 'XfeRLOCAL'){
                
                if (taskvar == 'XfeR'){
                    var queryCID = "LRvdcW" + epoch_sec + user_abb;
                    var redirectdestination = jQuery('#extension_xfer').val();
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : sessionName,
                        user : user,
                        pass : pass,
                        ACTION : 'RedirectName',
                        format : 'text',
                        channel : redirectvalue,
                        call_server_ip : redirectserverip,
                        queryCID : queryCID,
                        exten : redirectdestination,
                        ext_context : ext_context,
                        ext_priority : '1',                        
                        session_id : sessionId,
                        CalLCID : CalLCID,
                        customerparked : customerparked
                    };                     
                   // xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectName&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&extenName=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1" + "&session_id=" + sessionId + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;
                }
                
                if (taskvar == 'VMAIL'){
                    var queryCID = "LVvdcW" + epoch_sec + user_abb;
                    var redirectdestination = jQuery('#extension_xfer').val();
                        xferredirect_query = {
                            is_ajax : true,
                            server_ip : serverIp,
                            session_name : sessionName,
                            user : user,
                            pass : pass,
                            ACTION : 'RedirectNameVmail',
                            format : 'text',
                            channel : redirectvalue,
                            call_server_ip : redirectserverip,
                            queryCID : queryCID,
                            exten : voicemail_dump_exten,
                            extenName : redirectdestination,
                            ext_context : ext_context,
                            ext_priority : '1',                            
                            session_id : sessionId,
                            CalLCID : CalLCID,
                            customerparked : customerparked
                        };                     
                    //xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessioName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectNameVmail&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + voicemail_dump_exten + "&extenName=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1" + "&session_id=" + sessionId + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;
                }                
                
                if (taskvar == 'ENTRY'){
                    var queryCID = "LEvdcW" + epoch_sec + user_abb;
                    var redirectdestination = jQuery('#extension_xfer_entry').val();
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : sessionName,
                        user : user,
                        pass : pass,
                        ACTION : 'Redirect',
                        format : 'text',
                        channel : redirectvalue,
                        call_server_ip : redirectserverip,
                        queryCID : queryCID,
                        exten : redirectdestination,
                        ext_context : ext_context,
                        ext_priority : '1',
                        session_id : sessionId,
                        CalLCID : CalLCID,
                        customerparked : customerparked
                    };
                    //xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=Redirect&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1" + "&session_id=" + sessionId + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;
                }
                
                if (taskvar == '3WAY'){
                    xferredirect_query = '';
                    var queryCID = "VXvdcW" + epoch_sec + user_abb;
                    var redirectdestination = "NEXTAVAILABLE";
                    var redirectXTRAvalue = XDchannel;
                    var redirecttype_test = jQuery('#xfernumber').val();
                    var XfeRSelecT = document.getElementById("XfeRGrouP");
                    var XfeR_GrouP = XfeRSelecT.value;
                    var consultativexfer_checked = 0;
                    if (jQuery('#consultativexfer').is(':checked') == true)
			{consultativexfer_checked = 1;}                    
                    var regRXFvars = new RegExp("CXFER","g");
                    if(((redirecttype_test.match(regRXFvars)) || (consultativexfer_checked > 0) ) && (local_consult_xfers > 0))
                        {var redirecttype = 'RedirectXtraCXNeW';}
                    else
                        {var redirecttype = 'RedirectXtraNeW';}                    
                    DispO3waychannel = redirectvalue;
                    DispO3wayXtrAchannel = redirectXTRAvalue;
                    DispO3wayCalLserverip = redirectserverip;
                    DispO3wayCalLxfernumber = jQuery('#xfernumber').val();
                    DispO3wayCalLcamptail = '';                    
                    customerparked = 0;
                    
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : sessionName,
                        user : user,
                        pass : pass,
                        ACTION : redirecttype,
                        format : 'text',
                        channel : redirectvalue,
                        call_server_ip : redirectserverip,
                        queryCID : queryCID,
                        exten : redirectdestination,
                        ext_context : ext_context,
                        ext_priority : '1',
                        extrachannel : redirectXTRAvalue,
                        lead_id : jQuery('#lead_id').val(),
                        phone_code : jQuery('#phone_code').val(),
                        phone_number : jQuery('#phone_number').val(),
                        filename : taskdebugnote,
                        campaign : XfeR_GrouP,
                        session_id : sessionId,
                        agentchannel : agentchannel,
                        protocol : protocol,
                        extension : extension,
                        auto_dial_level : auto_dial_level,
                        CalLCID : CalLCID,
                        customerparked : customerparked
                    };
                    console.log('threeway');
                    console.log(xferredirect_query);
                   // xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=" + redirecttype + "&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1&extrachannel=" + redirectXTRAvalue + "&lead_id=" + jQuery('#lead_id').val() + "&phone_code=" + jQuery('#phone_code').val() + "&phone_number=" + jQuery('#phone_number').val() + "&filename=" + taskdebugnote + "&campaign=" + XfeR_GrouP + "&session_id=" + session_id + "&agentchannel=" + agentchannel + "&protocol=" + protocol + "&extension=" + extension + "&auto_dial_level=" + auto_dial_level + "&CalLCID=" + CalLCID + "&customerparked=" + customerparked;                    

                    if (taskdebugnote == 'FIRST'){
                        //document.getElementById("DispoSelectHAspan").innerHTML = "<a href=\"#\" onclick=\"DispoLeavE3wayAgaiN()\"><?php echo ("Leave 3Way Call Again"); ?></a>";
                    }                    
                }
                
                if (taskvar == 'ParK'){
                    blind_transfer = 0;                    
                    var queryCID = "LPvdcW" + epoch_sec + user_abb;
                    var redirectdestination = taskxferconf;
                    var redirectdestserverip = taskserverip;
                    var parkedby = protocol + "/" + extension;                    
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : sessionName,
                        user : user,
                        pass : pass,
                        ACTION : 'RedirectToPark',
                        format : 'text',
                        channel : redirectdestination,
                        call_server_ip : redirectdestserverip,
                        queryCID : queryCID,
                        exten : park_on_extension,
                        ext_context : ext_context,
                        ext_priority : '1',
                        extenName : 'park',
                        parkedby : parkedby,
                        session_id : sessionId,
                        CalLCID : CalLCID,
                        uniqueid : jQuery('#uniqueid').val(),
                        lead_id : jQuery('#lead_id').val(),
                        campaign : campaign
                    };
                   // xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectToPark&format=text&channel=" + redirectdestination + "&call_server_ip=" + redirectdestserverip + "&queryCID=" + queryCID + "&exten=" + park_on_extension + "&ext_context=" + ext_context + "&ext_priority=1&extenName=park&parkedby=" + parkedby + "&session_id=" + session_id + "&CalLCID=" + CalLCID + "&uniqueid=" + jQuery('#uniqueid').val() + "&lead_id=" + jQuery('#lead_id').val() + "&campaign=" + campaign;
                    
                    
                    //document.getElementById("ParkControl").innerHTML ="<a href=\"#\" onclick=\"mainxfer_send_redirect('FROMParK','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;\"><span>Grab Parked Call</span></a>";
                    jQuery('#ParkControl').show();                    
                    jQuery('#ParkControl').html('Grab Parked Call');
                    jQuery('#ParkControl').attr('onclick',"mainxfer_send_redirect('FROMParK','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;");
                    if ( (ivr_park_call=='ENABLED') || (ivr_park_call=='ENABLED_PARK_ONLY') ){
                        //document.getElementById("ivrParkControl").innerHTML ="<img src=\"./images/<?php echo ("vdc_LB_grabivrparkcall_OFF.gif") ?>\" border=\"0\" alt=\"Grab IVR Parked Call\" />";
                    }
                    customerparked = 1;
                    customerparkedcounter = 0;                    
                }
                
                if (taskvar == 'FROMParK'){

                    blind_transfer = 0;
                    var queryCID = "FPvdcW" + epoch_sec + user_abb;
                    var redirectdestination = taskxferconf;
                    var redirectdestserverip = taskserverip;                    
                    
                    if( (serverIp == taskserverip) && (taskserverip.length > 6) ){
                        var dest_dialstring = sessionId;
                    }else{
                        if(taskserverip.length > 6){
                            var dest_dialstring = server_ip_dialstring + "" + sessionId;
                        }else{
                            var dest_dialstring = sessionId;
                        }
                    }
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : sessionName,
                        user : user,
                        pass : pass,
                        ACTION : 'RedirectFromPark',
                        format : 'text',
                        channel : redirectdestination,
                        call_server_ip : redirectdestserverip,
                        queryCID : queryCID,
                        exten : dest_dialstring,
                        ext_context : ext_context,
                        ext_priority : '1',
                        ext_priority : '1',
                        session_id : sessionId,
                        CalLCID : CalLCID,
                        uniqueid : jQuery('#uniqueid').val(),
                        lead_id : jQuery('#lead_id').val(),
                        campaign : campaign
                    };
                    //xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectFromPark&format=text&channel=" + redirectdestination + "&call_server_ip=" + redirectdestserverip + "&queryCID=" + queryCID + "&exten=" + dest_dialstring + "&ext_context=" + ext_context + "&ext_priority=1" + "&session_id=" + session_id + "&CalLCID=" + CalLCID + "&uniqueid=" + jQuery('#uniqueid').val() + "&lead_id=" + jQuery('#lead_id').val() + "&campaign=" + campaign;
                    //document.getElementById("ParkControl").innerHTML ="<a href=\"#\" onclick=\"mainxfer_send_redirect('ParK','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;\"><span>Park Call</span></a>";
                     jQuery('#ParkControl').html('');
                     jQuery('#ParkControl').hide();
                    if ( (ivr_park_call=='ENABLED') || (ivr_park_call=='ENABLED_PARK_ONLY') ){
                        //document.getElementById("ivrParkControl").innerHTML ="<a href=\"#\" onclick=\"mainxfer_send_redirect('ParKivr','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;\"><img src=\"./images/<?php echo ("vdc_LB_ivrparkcall.gif") ?>\" border=\"0\" alt=\"IVR Park Call\" /></a>";
                    }
                    
                    customerparked = 0;
                    customerparkedcounter = 0;                    
                }
                
                if (taskvar == 'FROMParKivr'){
                    blind_transfer = 0;
                    var queryCID = "FPvdcW" + epoch_sec + user_abb;
                    var redirectdestination = taskxferconf;
                    var redirectdestserverip = taskserverip;
                    
                    if( (serverIp == taskserverip) && (taskserverip.length > 6) ){
                        var dest_dialstring = sessionId;
                    }else{
                        if(taskserverip.length > 6){
                            var dest_dialstring = server_ip_dialstring + "" + sessionId;}
                        else{
                            var dest_dialstring = sessionId;
                        }
                    }
                    xferredirect_query = {
                        is_ajax : true,
                        server_ip : serverIp,
                        session_name : session_name,
                        user : user,
                        pass : pass,
                        ACTION : 'RedirectFromParkIVR',
                        format : 'text',
                        channel : redirectdestination,
                        call_server_ip : redirectdestserverip,
                        queryCID : queryCID,
                        exten : dest_dialstring,
                        ext_context : ext_context,
                        ext_priority : '1',
                        session_id : sessionId,
                        CalLCID : CalLCID,
                        uniqueid : jQuery('#uniqueid').val(),
                        lead_id : jQuery('#lead_id').val(),
                        campaign : campaign
                    };
                    //xferredirect_query = "server_ip=" + serverIp + "&session_name=" + sessionName + "&user=" + user + "&pass=" + pass + "&ACTION=RedirectFromParkIVR&format=text&channel=" + redirectdestination + "&call_server_ip=" + redirectdestserverip + "&queryCID=" + queryCID + "&exten=" + dest_dialstring + "&ext_context=" + ext_context + "&ext_priority=1" + "&session_id=" + sessionId + "&CalLCID=" + CalLCID + "&uniqueid=" + jQuery('#uniqueid').val() + "&lead_id=" + jQuery('#lead_id').val() + "&campaign=" + campaign;
                    //document.getElementById("ParkControl").innerHTML ="<a href=\"#\" onclick=\"mainxfer_send_redirect('ParK','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;\"><img src=\"./images/<?php echo _QXZ("vdc_LB_parkcall.gif") ?>\" border=\"0\" alt=\"Park Call\" /></a>";
                    jQuery('#ParkControl').show();                    
                    jQuery('#ParkControl').html('Parke Call');
                    jQuery('#ParkControl').attr('onclick',"mainxfer_send_redirect('ParK','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;");
                    if ( (ivr_park_call=='ENABLED') || (ivr_park_call=='ENABLED_PARK_ONLY') ){
                       // document.getElementById("ivrParkControl").innerHTML ="<a href=\"#\" onclick=\"mainxfer_send_redirect('ParKivr','" + redirectdestination + "','" + redirectdestserverip + "','','','','YES');return false;\"><img src=\"./images/<?php echo _QXZ("vdc_LB_ivrparkcall.gif") ?>\" border=\"0\" alt=\"IVR Park Call\" /></a>";
                    }
                    customerparked = 0;
                    customerparkedcounter = 0;
                }
                //console.log('xferredirect_query' + xferredirect_query);
                jQuery.ajax({
                    url : '<?php echo site_url("viciagent/manager_send") ?>',
                    method : 'post',
                    dataType : 'json',
                    async : false,
                    data : xferredirect_query,
                    success : function(result){
                        var XfeRRedirecToutput = null;
                        XfeRRedirecToutput = result.message;
                        Command: toastr['success'](result.message);
                        if (taskvar == '3WAY'){
                            console.log(XfeRRedirecToutput);
                        }
                        var XfeRRedirecToutput_array = XfeRRedirecToutput.split("|");
                        var XFRDop = XfeRRedirecToutput_array[0];
                        if (XFRDop == "NeWSessioN"){
                            threeway_end = 1;
                            jQuery("#callchannel").val('');
                            jQuery('#callserverip').val('');
                            //TO DO :: make below functions
                            dialedcall_send_hangup();
                            
                            jQuery('#xferchannel').val('');
                            // To Do :: make below function 
                            xfercall_send_hangup();
                            
                            sessionId = XfeRRedirecToutput_array[1];
                            setSessionId(sessionId);
                            //document.getElementById("sessionIDspan").innerHTML = session_id;
                        }
                    }
                });
                
                if((auto_dial_level == 0) && (taskvar != '3WAY')){
                    RedirecTxFEr = 1;
                    xferredirect_query.stage = '2NDXfeR';
                    console.log(xferredirect_query);
                    jQuery.ajax({
                        url : '<?php echo site_url("viciagent/manager_send") ?>',
                        method : 'post',
                        dataType : 'json',
                        data : xferredirect_query,
                        success : function(result){
                            console.log('transfer 2 = '+ result);
                            Nactiveext = null;
                            Nactiveext = result.message;
                        }
                    });
                }
                
                if ( (taskvar == 'XfeRLOCAL') || (taskvar == 'XfeRBLIND') || (taskvar == 'XfeRVMAIL') ){
                    if (auto_dial_level == 0){
                        RedirecTxFEr = 1;
                    }
                    jQuery("#callchannel").val('');
                    jQuery('#callserverip').val('');
                    //if( document.images ) { document.images['livecall'].src = image_livecall_OFF.src;}
                //	alert(RedirecTxFEr + "|" + auto_dial_level);
                    // TOdo :: need to make below function
                    dialedcall_send_hangup(taskdispowindow,'','',no_delete_VDAC);
                }                
            }                        
        }
        //Send Hangup command for customer call connected to the conference now to Manager
        function dialedcall_send_hangup(dispowindow,hotkeysused,altdispo,nodeletevdac,DSHclick){
            if (VDCL_group_id.length > 1){
                var group = VDCL_group_id;
            }else{
                var group = campaign;
            }
            var form_cust_channel = jQuery("#callchannel").val();
            var form_cust_serverip = document.leadform.callserverip.value;
            var customer_channel = lastcustchannel;
            var customer_server_ip = lastcustserverip;        
            
            AgaiNHanguPChanneL = lastcustchannel;
            AgaiNHanguPServeR = lastcustserverip;
            AgainCalLSecondS = VD_live_call_secondS;
            AgaiNCalLCID = CalLCID; 
            console.log('dialedcall_send_hangup :: ' +form_cust_channel.length);
            if (form_cust_channel.length > 3){
                var queryCID = "HLvdcW" + epoch_sec + user_abb;
                var hangupvalue = customer_channel;
               
                var postData = {
                    is_ajax : true,
                    server_ip : serverIp,
                    session_name : sessionName,
                    ACTION : 'Hangup',
                    format : 'text',
                    user : user,
                    pass : pass,
                    channel : hangupvalue,
                    call_server_ip : customer_server_ip,
                    queryCID : queryCID,
                    auto_dial_level : auto_dial_level,
                    CalLCID : CalLCID,
                    secondS : VD_live_call_secondS,
                    exten : sessionId,
                    campaign : group,
                    stage : 'CALLHANGUP',
                    nodeletevdac : nodeletevdac,
                    log_campaign : campaign,
                    qm_extension : qm_extension
                };
                clearInterval(dialCheck);
                jQuery.ajax({
                    url : '<?php echo site_url("viciagent/manager_send") ?>',
                    method : 'post',
                    dataType : 'json',
                    data : postData,
                    success : function(result){
                        Nactiveext = null;
                        Nactiveext = result.message;
                        console.log('dialedcall_send_hangup result');                        
                        console.log(Nactiveext);                        
                        updateLead();
                        /*jQuery('#responsive').modal({
                            backdrop: 'static',
                            keyboard: false
                        });*/
                    }
                });                
                process_post_hangup = 1;
            }else{ //if (form_cust_channel.length > 3)
                process_post_hangup = 1;
                clearInterval(dialCheck);
            }
            
            if (process_post_hangup == 1){
                VD_live_customer_call = 0;
                VD_live_call_secondS = 0;
                MD_ring_secondS = 0;
                CalLCID = '';
                MDnextCID = '';
                cid_lock = 0;                               
                dialLog("end",nodeletevdac);
                conf_dialed = 0;
                if (dispowindow == 'NO'){
                   open_dispo_screen = 0; 
                }else{
                   if (auto_dial_level == 0){
                       reselect_alt_dial = 0;
                       open_dispo_screen = 1;
                   }else{
                       reselect_alt_dial = 0;
                       open_dispo_screen = 1;
                   }
                    jQuery('#responsive2').modal('hide');
                    updateLead();
                    /*jQuery('#responsive').modal({
                        backdrop: 'static',
                        keyboard: false
                    });*/
                }
                jQuery("#callchannel").val('');
                jQuery('#callserverip').val('');
                lastcustchannel = '';
                lastcustserverip = '';
                MDchannel = '';    
                logstart = 0;
            } //if (process_post_hangup == 1){
        }        
        // place 3way and customer into other conference and fake-hangup the lines
        function leave_3way_call(tempvarattempt,LTCclick){            
            if (LTCclick=='YES'){
               // button_click_log = button_click_log + "" + SQLdate + "-----leave_3way_call---" + tempvarattempt + "|";
            }            
            threeway_end = 0;
            leaving_threeway = 1;
            console.log('leave_3way_call ::'+ 'customerparked :: '+customerparked);
            if(customerparked > 0){
                swal('Oops....','Please first click Grab Parked Called Button','info');
                console.log('leave_3way_call ::'+ 'FROMPark :: '+ lastcustchannel + '::' + lastcustserverip);
                return false;                
                //mainxfer_send_redirect('FROMPark', lastcustchannel, lastcustserverip);
            }
            console.log('leave_3way_call ::'+ '3WAY :: '+ tempvarattempt);
            mainxfer_send_redirect('3WAY','','',tempvarattempt);           
        }    
        // Send Hangup command for 3rd party call connected to the conference now to Manager
        function xfercall_send_hangup(HANclick){
            var xferchannel = jQuery('#xferchannel').val();
            var xfer_channel = lastxferchannel;
            var process_post_hangup = 0;
            xfer_in_call = 0;
            
            if((MD_channel_look==1) && (leaving_threeway < 1)){
               MD_channel_look = 0;                
                DialTimeHangup('XFER');
            }
            console.log('xfercall_send_hangup :: ' +xferchannel.length);
            if( xferchannel.length > 3 ){
               var queryCID = "HXvdcW" + epoch_sec + user_abb;
               var hangupvalue = xfer_channel;
               
               //custhangup_query = "is_ajax=true&server_ip=" + serverIp + "&session_name=" + sessionName + "&ACTION=Hangup&format=text&user=" + user + "&pass=" + pass + "&channel=" + hangupvalue + "&queryCID=" + queryCID + "&log_campaign=" + campaign + "&qm_extension=" + qm_extension;
               
               custhangup_query = {
                    is_ajax : true,
                    server_ip : serverIp,
                    session_name : sessionName,
                    ACTION : 'Hangup',
                    format : 'text',
                    user : user,
                    pass : pass,
                    user : hangupvalue,
                    queryCID : queryCID,
                    log_campaign : campaign,
                    qm_extension : qm_extension
               };
               console.log('xfercall_send_hangup :: ');
               console.log(custhangup_query);
               jQuery.ajax({
                   url : '<?php echo site_url('viciagent/manager_send') ?>',
                   method : 'post',
                   dataType : 'json',
                   data : custhangup_query,
                   success : function(result){
                       Nactiveext = null;
                       Nactiveext = result.message;
                   }
               });
               process_post_hangup=1;
            }else{ //if((MD_channel_look==1) && (leaving_threeway < 1) ){
                process_post_hangup = 1;
            }
            if (process_post_hangup==1){
                XD_live_customer_call = 0;
                XD_live_call_secondS = 0;
                MD_ring_secondS = 0;
                MD_channel_look = 0;
                XDnextCID = '';
                XDcheck = '';
                xferchannellive = 0;
                consult_custom_wait = 0;
                consult_custom_go = 0;
                consult_custom_sent = 0;
                xfer_agent_selected = 0;  
                jQuery('#xferchannel').val('');
                lastxferchannel = '';
            }
           
            
            jQuery('#DialWithCustomer').attr('onclick','SendManualDial("YES","YES");return false;');
            jQuery('#ParkCustomerDial').attr('onclick','xfer_park_dial("YES");return false;');
            jQuery('#HangupXferLine').addClass('disabled');
            jQuery('#HangupBothLines').attr('onclick','bothcall_send_hangup("YES");return false;')
        }
        // Send Hangup command for any Local call that is not in the quiet(7) entry - used to stop manual dials even if no connect
        function DialTimeHangup(tasktypecall){
            if((RedirecTxFEr < 1) && (leaving_threeway < 1)){
                MD_channel_look = 0;
                var queryCID = "HTvdcW" + epoch_sec + user_abb;                
                var postData = {is_ajax : true,server_ip : serverIp,session_name : sessionName, ACTION : 'HangupConfDial', format : 'text',user : user, pass : pass, exten : sessionId, ext_context : ext_context, queryCID : queryCID, log_campaign : campaign,qm_extension : qm_extension};
                jQuery.ajax({
                    url : '<?php echo site_url("viciagent/manager_send") ?>',
                    method : 'post',
                    dataType : 'json',
                    data : postData,
                    success : function(result){
                        Nactiveext = null;
                        Nactiveext = result.message;
                    }
                });
            }
        }
        //filter manual dialstring and pass on to originate call        
        function SendManualDial(taskFromConf,SMDclick){
            conf_dialed = 1;
            var sending_group_alias = 0;
            if (taskFromConf == 'YES'){
                xfer_in_call = 1;
                agent_dialed_number = '1';
                agent_dialed_type = 'XFER_3WAY';                
                
                jQuery('#DialWithCustomer').addClass('disabled');
                jQuery('#ParkCustomerDial').addClass('disabled');

                var manual_number = jQuery('#xfernumber').val();
                var manual_number_hidden = jQuery('#xfernumhidden').val();
                if((manual_number.length < 1) && (manual_number_hidden.length > 0)){
                    manual_number = manual_number_hidden;
                }
                var manual_string = manual_number.toString();
                var dial_conf_exten = sessionId;
                threeway_cid = '';
                threeway_cid = campaign_cid;                                
           }else{
                var manual_number = jQuery('#xfernumber').val();
                var manual_string = manual_number.toString();
                var threeway_cid='1';                
           }
           
           var regXFvars = new RegExp("XFER","g");
           if (manual_string.match(regXFvars)){
               var donothing = 1;
           }else{
                if((document.getElementById('xferoverride').checked==false) || (manual_dial_override_field == 'DISABLED') ){
                    if (three_way_dial_prefix == 'X') {var temp_dial_prefix = '';}
                    else {var temp_dial_prefix = three_way_dial_prefix;}
                    if (omit_phone_code == 'Y') {var temp_phone_code = '';}
                    else {var temp_phone_code = document.leadform.phone_code.value;}
                    
                    // append dial prefix if phone number is greater than 7 digits on non-AGENTDIRECT calls
                    if ( (manual_string.length > 7) && (xfer_agent_selected < 1) )
                        {manual_string = temp_dial_prefix + "" + temp_phone_code + "" + manual_string;}
                }else{
                    agent_dialed_type='XFER_OVERRIDE';
                }
			// due to a bug in Asterisk, these call variables do not actually work
                call_variables = '__vendor_lead_code=' + '' + ',__lead_id=' + document.leadform.lead_id.value;                              
           }
           
           var sending_preset_name = jQuery('#xfername').val();
           if (taskFromConf == 'YES'){
                consult_custom_go = 1;
                consult_custom_wait = 0;               
                if (consult_custom_go > 0){
                    // ToDO : need to implement below function
                    basic_originate_call(manual_string,'NO','YES',dial_conf_exten,'NO',taskFromConf,threeway_cid,sending_group_alias,'',sending_preset_name,call_variables);
                }                
           }else{
               basic_originate_call(manual_string,'NO','NO','','','',threeway_cid,sending_group_alias,sending_preset_name,call_variables);
           }
           MD_ring_secondS = 0;
        }
        // park customer and place 3way call
        function xfer_park_dial(XPDclick){
            conf_dialed = 1;
            mainxfer_send_redirect('ParK',lastcustchannel,lastcustserverip);
            SendManualDial('YES');
        }
        // Start Hangup Functions for both
        function bothcall_send_hangup(){
            xfer_agent_selected = 0;
            if (lastcustchannel.length > 3){
                dialedcall_send_hangup();
            }
            if (lastxferchannel.length > 3){
                xfercall_send_hangup();
            }                        
        }
        // Send Originate command to manager to place a phone call
        function basic_originate_call(tasknum,taskprefix,taskreverse,taskdialvalue,tasknowait,taskconfxfer,taskcid,taskusegroupalias,taskalert,taskpresetname,taskvariables){
            if (taskalert == '1'){
                var TAqueryCID = tasknum;
                tasknum = '83047777777777';
                taskdialvalue = '7' + taskdialvalue;
                var alertquery = 'alertCID=1';
            }else{
               var alertquery = 'alertCID=0'; 
            }
            var usegroupalias = 0;
            var consultativexfer_checked = 0;
            if (jQuery('#consultativexfer').is(':checked') == true){
                consultativexfer_checked = 1;
            }
            var regCXFvars = new RegExp("CXFER","g");
            var tasknum_string = tasknum.toString();            
            if ((tasknum_string.match(regCXFvars)) || (consultativexfer_checked > 0)){
                if (tasknum_string.match(regCXFvars)){
                   var Ctasknum = tasknum_string.replace(regCXFvars, '');
                   if (Ctasknum.length < 2){
                        Ctasknum = '90009';  
                   }
                   var agentdirect = '';
                }else{
                   Ctasknum = '90009';
                   var agentdirect = tasknum_string;
                }
                var XfeRSelecT = document.getElementById("XfeRGrouP");
                var XfeR_GrouP = XfeRSelecT.value;                
                
                tasknum = Ctasknum + "*" + XfeR_GrouP + '*CXFER*' + document.leadform.lead_id.value + '**' + dialed_number + '*' + user + '*' + agentdirect + '*' + VD_live_call_secondS + '*';
            } //if ( (tasknum_string.match(regCXFvars)) || (consultativexfer_checked > 0) ) 
            
            if (taskprefix == 'NO') {var call_prefix = '';}
            else{ var call_prefix = agc_dial_prefix; }
            if (prefix_choice.length > 0)
                {var call_prefix = prefix_choice;}            

            if(taskreverse == 'YES'){
                if (taskdialvalue.length < 2){
                    var dialnum = dialplan_number;
                }else{
                    var dialnum = taskdialvalue;
                }
                var call_prefix = '';
                var originatevalue = "Local/" + tasknum + "@" + ext_context;
            }else{
                var dialnum = tasknum;
                if ( (protocol == 'EXTERNAL') || (protocol == 'Local') ){
                    var protodial = 'Local';
                    var extendial = extension;                    
                }else{
                    var protodial = protocol;
                    var extendial = extension;                    
                }
                var originatevalue = protodial + "/" + extendial;
            }
            var leadCID = document.leadform.lead_id.value;
            var epochCID = epoch_sec;
            if (leadCID.length < 1)
                {leadCID = user_abb;}
            leadCID = set_length(leadCID,'10','left');
            epochCID = set_length(epochCID,'6','right');            
            
            if (taskconfxfer == 'YES')
                {var queryCID = "DC" + epochCID + 'W' + leadCID + 'W';}
            else
                {var queryCID = "DV" + epochCID + 'W' + leadCID + 'W';}            
            
            if (taskalert == '1'){
                queryCID = TAqueryCID;
            }
            
            if (taskalert == '1'){
                queryCID = TAqueryCID;
            }
            var call_cid = campaign_cid;
            
            var VMCoriginate_query = {
                is_ajax : true,
                server_ip : serverIp,
                session_name : sessionName,
                user : user,
                pass : pass,
                ACTION : 'Originate',
                format : 'text',
                channel : originatevalue,
                queryCID : queryCID,
                exten : call_prefix+""+dialnum,
                ext_context : ext_context,
                ext_priority : '1',
                outbound_cid : call_cid,
                usegroupalias : usegroupalias,
                preset_name : taskpresetname,
                campaign : campaign,
                account : active_group_alias,
                agent_dialed_number : agent_dialed_number,
                agent_dialed_type : agent_dialed_type,
                lead_id :document.leadform.lead_id.value,
                stage : CheckDEADcallON+"&"+alertquery,
                cid_lock : cid_lock,
                call_variables : taskvariables
            };
            
            jQuery.ajax({
                url : '<?php echo site_url("viciagent/manager_send") ?>',
                method : 'post',
                dataType : 'json',
                data : VMCoriginate_query,
                success : function(result){
                    var regBOerr = new RegExp("ERROR","g");
                    var BOresponse = result.message;
                    if (BOresponse.match(regBOerr)){
                        swal('Oops..',BOresponse,'error');
                    }
                    if ((taskdialvalue.length > 0) && (tasknowait != 'YES')){
                        Command: toastr['success'](result.message);                        
                        XDnextCID = queryCID;
                        MD_channel_look = 1;
                        XDcheck = 'YES';
                    }                    
                }
            });
            active_group_alias='';
            cid_choice='';
            prefix_choice='';
            agent_dialed_number='';
            agent_dialed_type='';
            call_variables='';
            xfer_agent_selected=0;            
        }
        
        function CustomerData_update(){
            var VLupdate_query = {
                is_ajax : true,
                server_ip : serverIp,
                session_name : sessionName,
                campaign : campaign,
                ACTION : 'updateLEAD',
                format : 'text',
                user  : user,
                pass : pass,
                lead_id : document.leadform.lead_id.value,
                vendor_lead_code : '',
                phone_number : document.leadform.phone_number.value,
                title : '',
                first_name : document.leadform.first_name.value,
                middle_initial : '',
                last_name : document.leadform.last_name.value,
                address1  : document.leadform.address1.value,
                address2  : '',
                address3  : '',
                city : document.leadform.city.value,
                state : document.leadform.state.value,
                province : '',
                postal_code : document.leadform.postal_code.value,
                country_code : '' ,
                gender : '' ,
                date_of_birth : '' ,
                alt_phone :'' ,
                email : document.leadform.email.value,
                security_phrase : '',
                comments: ''
            };
            jQuery.ajax({
                url : '<?php echo site_url("viciagent/vdc_db_query") ?>',
                method : 'post',
                dataType : 'json',
                data : VLupdate_query,
                success : function(result){
                    console.log(result);
                }
            });
        }
        
        function set_length(SLnumber,SLlength_goal,SLdirection){
            var SLnumber = SLnumber + '';
            var begin_point=0;
            var number_length = SLnumber.length;
            if (number_length > SLlength_goal){
		if (SLdirection == 'right'){
                    begin_point = (number_length - SLlength_goal);
                    SLnumber = SLnumber.substr(begin_point,SLlength_goal);
                }else{
                    SLnumber = SLnumber.substr(0,SLlength_goal);
                }
            }
            //alert(SLnumber + '|' + SLlength_goal + '|' + begin_point + '|' + SLdirection + '|' + SLnumber.length + '|' + number_length);
            var result = SLnumber + '';
            while(result.length < SLlength_goal){
		result = "0" + result;
            }
            return result;
	}
        // Populate the number to dial field with the selected user ID
	function AgentsXferSelect(AXuser,AXlocation, event){          
           // button_click_log = button_click_log + "" + SQLdate + "-----AgentsXferSelect---" + AXuser + " " + AXlocation + "|";
            xfer_select_agents_active = 0;
            //document.getElementById('AgentXferViewSelect').innerHTML = '';                      
            xfer_agent_selected=1;
            if (AXuser=='0'){
                xfer_agent_selected=0;
            }
            jQuery('#xfernumber').val(AXuser); 
            event.preventDefault();
        }
        
        function getagentchannel(){
            jQuery.ajax({
                url : '<?php echo site_url('viciagent/getagentchannel') ?>',
                method : 'post',
                dataType : 'json',
                data : {is_ajax : true},
                success : function(result){ 
                     if(result.message){
                        agentchannel = result.message.channel;               
                    }
                }
            });
        }
        
        function setSessionId(sessionid){
            var postData = {
                is_ajax : true,
                session : sessionid
            };
            jQuery.ajax({
                url : '<?php echo site_url('viciagent/setsession') ?>',
                method : 'post',
                dataType : 'json',
                data : postData,
                success : function(result){
                    
                }
            });
        }
    </script>
<?php endif; ?>