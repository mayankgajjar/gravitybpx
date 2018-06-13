<!DOCTYPE html>
<html>
    <head>
        <title><?php echo 'CRM Vici AGENT Screen' ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <base href="<?php echo base_url(); ?>"/>
        <!-- favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo site_url() ?>uploads/logo/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo site_url() ?>uploads/logo/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url() ?>uploads/logo/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo site_url() ?>uploads/logo/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/global/css/components-md.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/global/css/plugins-md.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/layout.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/themes/grey.min.css'); ?>" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo site_url('assets/theam_assets/layouts/layout/css/custom.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo site_url('assets/theam_assets/pages/css/customcss.css'); ?>" rel="stylesheet" type="text/css" />
        <style type="text/css">
            .dispo li:nth-child(2n+1),.dispo li:nth-child(2n){float: left; width: 50%;}
        </style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner">
                <div class="page-logo">
                    <a href="#">
                        <img src="<?php echo site_url() ?>uploads/logo/logo.png" alt="logo" class="logo-default">
                    </a>
                </div>
            </div>
        </div>
        <div class="page-container">
            <div class="page-content-wrapper">
                <div class="page-content" style="margin-left: 0px;">
                    <div class="portlet" style="box-shadow: none;">
                        <div class="portlet-body">
                            <?php if (!$this->session->userdata('vicidata')): ?>
                                <form class="form-horizontal" method="post" onsubmit="formSubmit();
                                        return false;">
                                    <input type="hidden" name="is_ajax" value="<?php echo TRUE; ?>" />
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3  control-label"><?php echo "Phone Login" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="phone_login" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Phone Password" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="phone_pass" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "User" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="VD_login" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Password" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="VD_pass" class="form-control" onblur="javascript:selectCampaign()" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Campaign" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="VD_campaign" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-3">
                                                <button class="btn btn-primary"><?php echo "Login" ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>

                                <form class="form-horizontal" method="post" onsubmit="return false;">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 col-md-offset-3"></label>
                                            <div class="col-md-4">
                                                    <!-- <button class="status" type="button" class="btn btn-primary" id="DiaLControl"><a href="javascript:void(0)" onclick="AutoDial_ReSume_PauSe('VDADready');"><?php echo "You are paused" ?></a></button> -->
                                                <button class="btn btn-primary" type="bitton" onclick="javascript:logOut()"><?php echo "Logout" ?></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Phone Code" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="phone_code" class="form-control" id="phone_code"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Phone Number" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="number" id="phone_number" class="form-control" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-3">
                                                <button class="btn btn-primary" type="button" onclick="javascript:formManualDial();"><?php echo 'Manual Dial' ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form class="form-horizontal" name="leadform" method="post" id="leadform" style="display: none;">
                                    <input type="hidden" name="lead_id" />
                                    <input type="hidden" name="list_id" />
                                    <input type="hidden" name="dispo" />
                                    <input type="hidden" name="called_count" />

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "First Name" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="first_name" id="first_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Last Name" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="last_name" id="last_name" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Phone Number" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="phone_number" id="phone_number" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo 'Address' ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="address1" id="address1" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "City" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="city" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "State" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="state" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Postal Code" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="postal_code" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo "Email" ?></label>
                                            <div class="col-md-4">
                                                <input type="text" name="email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-3 col-md-offset-3">
                                                <button type="button" class="btn btn-primary" onclick="updateLead()"><?php echo "Hangup" ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h4 class="modal-title"><?php echo "Disposition" ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                                                    <div class="row">
                                                            <?php $statuses = getDisposition($this->session->userdata('vicidata')['campaign']) ?>
                                                        <ul class="dispo">
                                                            <?php foreach ($statuses as $status): ?>
                                                                <li><a href="javascript:setDispo('<?php echo $status->STATUS ?>')"><?php echo $status->STATUS . ' - ' . $status->status_name ?></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                                                <button type="button" class="btn green" onclick="javascript:hangup()"><?php echo "Submit" ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $closer_campaigns = $this->session->userdata('campaign')->closer_campaigns;
                                $closer_campaigns = preg_replace("/^ | -$/", "", $closer_campaigns);
                                $closer_campaigns = preg_replace("/ /", "','", $closer_campaigns);
                                $closer_campaigns = "'$closer_campaigns'";
                                if (($this->session->userdata('campaign')->campaign_allow_inbound == 'Y') and ( $this->session->userdata('campaign')->dial_method != 'MANUAL')) {
                                    //some code for intialization
                                } else {
                                    $closer_campaigns = "''";
                                }
                                $sql = "SELECT group_id,group_handling from vicidial_inbound_groups where active = 'Y' and group_id IN($closer_campaigns) order by group_id limit 800";
                                $ingroup = $this->vicidialdb->db->query($sql)->result();
                                if ($ingroup) {
                                    $ingroupname = $ingroup[0]->group_id . ' -';
                                }
                                $sql = "SELECT group_id,group_handling from vicidial_inbound_groups where active = 'Y' and group_id IN($closer_campaigns) order by group_id limit 800;";
                                $query = $this->vicidialdb->db->query($sql);
                                $results = $query->result_array();
                                $closer_ct = $query->num_rows();
                                $INgrpCT = 0;
                                while ($INgrpCT < $closer_ct) {
                                    $INgrpCT++;
                                }
                                ?>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-footer">
                <div class="page-footer-inner">&copy;<?php echo date('Y') ?>&nbsp;<a href="http://agencyvue.com" style="color:white;"><?php echo "agencyvue.com" ?></a></div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo site_url() ?>assets/theam_assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            var sessionName = '<?php echo $this->session->userdata('vicidata')['session_name'] ? $this->session->userdata('vicidata')['session_name'] : '' ?>';
            var sessionId = '<?php echo $this->session->userdata('vicidata')['session_id'] ? $this->session->userdata('vicidata')['session_id'] : '' ?>';
            var agentLogId = '<?php echo $this->session->userdata('vicidata')['agent_log_id'] ? $this->session->userdata('vicidata')['agent_log_id'] : '' ?>';
            var user = '<?php echo $this->session->userdata('vicidata')['user'] ? $this->session->userdata('vicidata')['user'] : '' ?>';
            var pass = '<?php echo $this->session->userdata('vicidata')['pass'] ? $this->session->userdata('vicidata')['pass'] : '' ?>';
            var campaign = '<?php echo $this->session->userdata('vicidata')['campaign'] ? $this->session->userdata('vicidata')['campaign'] : '' ?>';
            var phone_login = '<?php echo $this->session->userdata('vicidata')['phone_login'] ? $this->session->userdata('vicidata')['phone_login'] : '' ?>';
            var phone_pass = '<?php echo $this->session->userdata('vicidata')['phone_pass'] ? $this->session->userdata('vicidata')['phone_pass'] : '' ?>';
            var server_ip = '<?php echo $this->config->item('vici_server_ip') ?>';
            var auto_dial_level = parseInt('<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->auto_dial_level : '0' ?>');
            /* config variables */

            var INgroupCOUNT = '<?php echo isset($INgrpCT) ? $INgrpCT : "0" ?>';

            /** add login to vicidial agent */
            function formSubmit() {
                var data = jQuery('form').serialize();
                jQuery.ajax({
                    'url': '<?php echo site_url("chat/loginpost") ?>',
                    'type': 'post',
                    'dataType': 'json',
                    'data': data,
                    success: function (result) {
                        var flag = Boolean(result.error);
                        if (flag == false) {
                            sessionName = jQuery(result.message).find('#crmses').val();
                            sessionId = jQuery(result.message).find('#crmid').val();
                            agentLogId = jQuery(result.message).find('#crmlogid').val();
                            if (typeof sessionName != 'undefined' && typeof sessionId != 'undefined') {
                                alert("Log In Successfully. " + sessionName);
                                selectIngroups();
                                jQuery.ajax({
                                    url: '<?php echo site_url("chat/setphonesession") ?>',
                                    type: 'post',
                                    data: {session_name: sessionName, session_id: sessionId, agent_log_id: agentLogId, user: jQuery('[name="VD_login"]').val(), pass: jQuery('[name="VD_pass"]').val(), phone_login: jQuery('[name="phone_login"]').val(), phone_pass: jQuery('[name="phone_pass"]').val(), campaign: jQuery('[name="VD_campaign"]').val(), is_ajax: true},
                                    success: function (result) {
                                        location.reload();
                                    }
                                });
                            } else {
                                alert("Something went wrong.");
                            }
                        } else {
                            alert("Something went wrong.");
                        }
                    }
                });
            }
                                                /** add the manual dial functionality */
            function formManualDial() {
                if (sessionId.length <= 0) {
                    alert("Something went wrong.")
                    return;
                }
                var postData = {
                    'is_ajax': true,
                    'server_ip': server_ip,
                    'session_name': sessionName,
                    'ACTION': 'manDiaLnextCaLL',
                    'conf_exten': sessionId,
                    'user': user,
                    'pass': pass,
                    'campaign': campaign,
                    'ext_context': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->ext_context : '' ?>',
                    'dial_timeout': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_timeout : '' ?>',
                    'dial_prefix': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_prefix : '' ?>',
                    'campaign_cid': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->campaign_cid : '' ?>',
                    'preview': 'NO',
                    'agent_log_id': agentLogId,
                    'callback_id': '',
                    'lead_id': jQuery('[name="lead_id"]').val(),
                    'phone_code': jQuery("#phone_code").val(),
                    'phone_number': jQuery("#phone_number").val(),
                    'list_id': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->manual_dial_list_id : ''; ?>',
                    'stage': 'lookup',
                    'use_internal_dnc': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->use_internal_dnc : '' ?>',
                    'use_campaign_dnc': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->use_campaign_dnc : '' ?>',
                    'omit_phone_code': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->omit_phone_code : '' ?>',
                    'manual_dial_filter': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->manual_dial_filter : '' ?>',
                    'manual_dial_search_filter': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->manual_dial_search_filter : '' ?>',
                    'vendor_lead_code': '',
                    'usegroupalias': 0,
                    'account': '',
                    'agent_dialed_number': 1,
                    'agent_dialed_type': 'MANUAL_DIALNOW',
                    'vtiger_callback_id': 0,
                    'dial_method': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : '' ?>',
                    'manual_dial_call_time_check': 'DISABLED',
                    'qm_extension': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->extension : '' ?>',
                    'dial_ingroup': '',
                    'nocall_dial_flag': 'DISABLED',
                    'cid_lock': 0
                };
                jQuery.ajax({
                    'url': '<?php echo site_url("chat/vdc_db_query") ?>',
                    'type': 'post',
                    'dataType': 'json',
                    'data': postData,
                    'success': function (result) {
                        console.log(result);
                        var flag = result.error;
                        if (flag == false) {
                            var MDnextResponse = result.message;
                            var MDnextResponse_array = MDnextResponse.split("\n");
                            MDnextCID = MDnextResponse_array[0];
                            LastCallCID = MDnextResponse_array[0];

                            var regMNCvar = new RegExp("HOPPER EMPTY", "ig");
                            var regMDFvarDNC = new RegExp("DNC", "ig");
                            var regMDFvarCAMP = new RegExp("CAMPLISTS", "ig");
                            var regMDFvarTIME = new RegExp("OUTSIDE", "ig");
                            if ((MDnextCID.match(regMNCvar)) || (MDnextCID.match(regMDFvarDNC)) || (MDnextCID.match(regMDFvarCAMP)) || (MDnextCID.match(regMDFvarTIME))) {
                                alert('error');
                            } else {
                                jQuery("#leadform").show();
                                document.leadform.lead_id.value = MDnextResponse_array[1];
                                document.leadform.list_id.value = MDnextResponse_array[5];

                                document.leadform.phone_number.value = MDnextResponse_array[8];
                                document.leadform.first_name.value = MDnextResponse_array[10];
                                document.leadform.last_name.value = MDnextResponse_array[12];
                                document.leadform.address1.value = MDnextResponse_array[13];
                                document.leadform.city.value = MDnextResponse_array[16];
                                document.leadform.state.value = MDnextResponse_array[17];
                                document.leadform.postal_code.value = MDnextResponse_array[19];
                                document.leadform.email.value = MDnextResponse_array[24];
                                document.leadform.called_count.value = MDnextResponse_array[27];
                            }
                        }
                    }
                });
            }
                                                /** call hangup functionality */
            function hangup() {
                if (sessionId.length <= 0) {
                    alert("Something went wrong.")
                    return;
                }
                var postData = {
                    'is_ajax': true,
                    'server_ip': server_ip,
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
                    'MDnextCID': '',
                    'stage': '',
                    'vtiger_callback_id': 0,
                    'phone_number': jQuery('[name="phone_number"]').val(),
                    'phone_code': '1',
                    'dial_method': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : "" ?>',
                    'uniqueid': '',
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
                    'phone_login': phone_login,
                    'agent_email': '',
                    'conf_exten': sessionId,
                    'camp_script': '',
                    'in_script': '',
                    'customer_server_ip': '',
                    'exten': '',
                    'original_phone_login': phone_login,
                    'phone_pass': phone_pass
                };
                jQuery.ajax({
                    'url': '<?php echo site_url("chat/vdc_db_query") ?>',
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
                            sendURLs(dispo_urls, "dispo");
                        } //if (check_DS_array[3] == 'Dispo URLs:'){
                    }
                });
                jQuery('#leadform').hide();
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
                jQuery('#responsive').modal('hide');
            }
            /**  */
            function setDispo(dispo) {
                jQuery('[name="dispo"]').val(dispo);
            }
            /**  Submit the URLs */
            function sendURLs(newurlids, newurltype) {
                var postData = {
                    'is_ajax': true,
                    'server_ip': server_ip,
                    'session_name': session_name,
                    'ACTION': 'RUNurls',
                    'format': 'text',
                    'user': user,
                    'pass': pass,
                    'orig_pass': pass,
                    'url_ids': newurlids,
                    'campaign': campaign,
                    'auto_dial_level': auto_dial_level,
                    'stage': 'dispo'
                };
                jQuery.ajax({
                    url: '<?php echo site_url("chat/vdc_db_query") ?>',
                    type: 'post',
                    dataType: 'json',
                    data: postData,
                    success: function (result) {
                        var dispo_url_send_response = null;
                        dispo_url_send_response = result.message;
                    }
                });
            }
            /** select inbounf groups of agent */
            function selectIngroups() {
                if (sessionId.length <= 0) {
                    alert("Something went wrong.")
                    return;
                }
                var postData = {
                    'server_ip': server_ip,
                    'session_name': sessionName,
                    'ACTION': 'regCLOSER',
                    'format': 'text',
                    'user': user,
                    'pass': pass,
                    'comments': '',
                    'closer_blended': 0,
                    'campaign': campaign,
                    'qm_phone': phone_login,
                    'qm_extension': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->extension : '' ?>',
                    'dial_method': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : '' ?>',
                    'closer_choice': '<?php echo isset($ingroupname) ? $ingroupname : '' ?>'
                };
                jQuery.ajax({
                    'url': '<?php echo site_url("chat/vdc_db_query") ?>',
                    'type': 'post',
                    'dataType': 'json',
                    'data': postData,
                    success: function (result) {
                        console.log(result);
                    }
                });
            }
            /** make logout from agent screen */
            function logOut() {
                if (sessionId.length <= 0) {
                    //alert("Something went wrong.")
                    return;
                }
                var postData = {
                    'is_ajax': true,
                    'server_ip': server_ip,
                    'session_name': sessionName,
                    'ACTION': 'userLOGout',
                    'format': 'text',
                    'user': user,
                    'pass': pass,
                    'campaign': campaign,
                    'conf_exten': sessionId,
                    'extension': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->extension : '' ?>',
                    'protocol': 'SIP',
                    'agent_log_id': agentLogId,
                    'no_delete_sessions': 1,
                    'phone_ip': '',
                    'enable_sipsak_messages': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->enable_sipsak_messages : '' ?>',
                    'LogouTKicKAlL': 1,
                    'ext_context': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->ext_context : '' ?>',
                    'qm_extension': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->extension : '' ?>',
                    'stage': 'NORMAL',
                    'pause_trigger': '',
                    'dial_method': '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : '' ?>',
                };
                jQuery.ajax({
                    'url': '<?php echo site_url("chat/vdc_db_query") ?>',
                    'type': 'post',
                    'data': postData,
                    success: function (result) {
                        console.log(result);
                        //location.reload();
                    }
                });
            }
            function selectCampaign() {
                var postData = {'is_ajax': true, 'ACTION': 'LogiNCamPaigns', 'format': 'html', 'pass': jQuery('[name="VD_login"]').val(), 'user': jQuery('[name="VD_login"]').val(), 'pass' : jQuery('[name="VD_pass"]').val()
                };
                jQuery.ajax({
                    url: '<?php echo site_url("chat/vdc_db_query") ?>',
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    success: function (result) {
                        var flag = result.error;
                        if (flag == false) {
                            jQuery("[name='VD_campaign']").replaceWith(result.message);
                            jQuery("[name='VD_campaign']").addClass('form-control');
                        }
                    }
                });
            }
            /** update lead information */
            function updateLead() {
                jQuery('#responsive').modal('show')
                var postData = {
                    'is_ajax': true,
                    'ACTION': 'updateLEAD',
                    'address1': jQuery('[name="address1"]').val(),
                    'address2': '',
                    'address3': '',
                    'alt_phone': '',
                    'campaign': campaign,
                    'city': jQuery('[name="city"]').val(),
                    'comments': '',
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
                    'server_ip': server_ip,
                    'session_name': sessionName,
                    'state': jQuery('[name="state"]').val(),
                    'title': '',
                    'user': user,
                    'vendor_lead_code': ''
                };
                jQuery.ajax({
                    url: '<?php echo site_url("chat/vdc_db_query") ?>',
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                    }
                });
            }
            /** Set the client to READY and start looking for calls (VDADready, VDADpause) */
            var VDRP_stage = 'PAUSED';
            var VDRP_stage_seconds = 0;
            var VICIDiaL_closer_blended = '0';
            var AutoDialReady = 0;
            var AutoDialWaiting = 0;
            var dial_method = '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->dial_method : '' ?>';
            var auto_dial_level = '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->auto_dial_level : '' ?>';
            var starting_dial_level = '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->auto_dial_level : '' ?>';
            var DiaLControl_auto_HTML = "<a href=\"#\" onclick=\"AutoDial_ReSume_PauSe('VDADready');\"><?php echo 'You are paused' ?></a>";
            var DiaLControl_auto_HTML_ready = "<a href=\"#\" onclick=\"AutoDial_ReSume_PauSe('VDADpause');\"><?php echo "You are active" ?></a>";
            var pause_code_counter = 1;
            var dial_next_failed = 0;
            var agent_pause_codes_active = '<?php echo $this->session->userdata('campaign') ? $this->session->userdata('campaign')->agent_pause_codes_active : '' ?>';
            function AutoDial_ReSume_PauSe(taskaction, taskagentlog, taskwrapup, taskstatuschange, temp_reason, temp_auto, temp_auto_code) {
                var add_pause_code = '';
                if (taskaction == 'VDADready') {
                    VDRP_stage = 'READY';
                    VDRP_stage_seconds = 0;
                    if (INgroupCOUNT > 0) {
                        if (VICIDiaL_closer_blended == 0) {
                            VDRP_stage = 'CLOSER';
                        } else {
                            VDRP_stage = 'READY';
                        }
                    } //if (INgroupCOUNT > 0){
                    AutoDialReady = 1;
                    AutoDialWaiting = 1;
                    if (dial_method == "INBOUND_MAN") {
                        auto_dial_level = starting_dial_level;
                        // Dial Next Number
                        document.getElementById("DiaLControl").innerHTML = "<a href=\"#\" onclick=\"AutoDial_ReSume_PauSe('VDADready');\"><?php echo 'You are pause' ?></a>";
                    } else {
                        document.getElementById("DiaLControl").innerHTML = DiaLControl_auto_HTML;
                    }
                } else { //if (taskaction == 'VDADready'){
                    VDRP_stage = 'PAUSED';
                    VDRP_stage_seconds = 0;
                    AutoDialReady = 0;
                    AutoDialWaiting = 0;
                    pause_code_counter = 0;
                    dial_next_failed = 0;
                    if (dial_method == "INBOUND_MAN") {
                        auto_dial_level = starting_dial_level;
                        document.getElementById("DiaLControl").innerHTML = "<a href=\"#\" onclick=\"AutoDial_ReSume_PauSe('VDADpause');\"><?php echo 'You are active' ?></a>";
                    } else { //if (dial_method == "INBOUND_MAN"){
                        document.getElementById("DiaLControl").innerHTML = DiaLControl_auto_HTML;
                    }
                    if ((agent_pause_codes_active == 'FORCE') && (temp_reason != 'LOGOUT') && (temp_reason != 'REQUEUE') && (temp_reason != 'DIALNEXT') && (temp_auto != '1')) {
                        PauseCodeSelectContent_create();
                    }
                    if (temp_auto == '1') {
                        add_pause_code = "&sub_status=" + temp_auto_code;
                    }
                }
                var postData = {
                    'is_ajax': true,
                    'server_ip': server_ip,
                    'session_name': sessionName,
                    'ACTION': taskaction,
                    'user': user,
                    'pass': pass,
                    'stage': VDRP_stage,
                    'agent_log_id': agentLogId,
                    'agent_log': taskagentlog,
                    'wrapup': taskwrapup,
                    'campaign': campaign,
                    'dial_method': dial_method,
                    'comments': taskstatuschange + add_pause_code,
                    'qm_extension': '<?php echo $this->session->userdata('phone') ? $this->session->userdata('phone')->extension : ''; ?>'
                };
                jQuery.ajax({
                    url: '<?php echo site_url("chat/vdc_db_query") ?>',
                    type: 'post',
                    data: postData,
                    dataType: 'json',
                    async: false,
                    success: function (result) {
                        console.log(result);
                        var check_dispo = null;
                        check_dispo = result.message;
                        var check_DS_array = check_dispo.split("\n");
                        if (check_DS_array[1] == 'Next agent_log_id:') {
                            agentLogId = check_DS_array[2];
                        }
                    }
                });
                waiting_on_dispo = 0;
                return agentLogId;
            }
        </script>
    </body>
</html>