                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agent Disable Display"; ?></label>
                            <div class="col-md-4">
                                <select name="dialer_agent_disable" id="dialer_agent_disable" class="form-control">
                                    <option value="<?php echo "NOT_ACTIVE" ?>" <?php echo optionSetValue("NOT_ACTIVE",get_dialer_option('dialer_agent_disable')) ?>><?php echo "NOT_ACTIVE" ?></option>
                                    <option value="<?php echo "LIVE_AGENT"; ?>" <?php echo optionSetValue("LIVE_AGENT",get_dialer_option('dialer_agent_disable')) ?>><?php echo "LIVE_AGENT"; ?></option>
                                    <option value="<?php echo "EXTERNAL"; ?>" <?php echo optionSetValue("EXTERNAL",get_dialer_option('dialer_agent_disable')) ?>><?php echo "EXTERNAL"; ?></option>
                                    <option value="<?php echo "ALL"; ?>" <?php echo optionSetValue("ALL",get_dialer_option('dialer_agent_disable')) ?>><?php echo "ALL"; ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Clear Frozen Calls"; ?></label>
                                <div class="col-md-4">
                                    <select name="frozen_server_call_clear" id="frozen_server_call_clear" class="form-control">
                                        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('frozen_server_call_clear')) ?>><?php echo 'Yes - 1' ?></option>
                                        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('frozen_server_call_clear')) ?>><?php echo 'No - 0' ?></option>
                                    </select>
                                </div>
                         </div>
                         <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Allow SIPSAK Messages"; ?></label>
                                <div class="col-md-4">
                                    <select name="allow_sipsak_messages" id="allow_sipsak_messages" class="form-control">
                                        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('allow_sipsak_messages')) ?>><?php echo 'Yes - 1' ?></option>
                                        <option value="<?php echo 0; ?>" <?php echo optionSetValue("1",get_dialer_option('allow_sipsak_messages')) ?>><?php echo 'No - 0' ?></option>
                                    </select>
                                </div>
                         </div>
                         <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Admin Modify Auto-Refresh"; ?></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="admin_modify_refresh" size="6" maxlength="5" value="<?php echo get_dialer_option('admin_modify_refresh'); ?>" />
                                </div>
                         </div>
                         <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Enable Agent Transfer Logfile"; ?></label>
                                <div class="col-md-4">
                                    <select class="form-control" name="enable_agc_xfer_log" id="enable_agc_xfer_log">
                                        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enable_agc_xfer_log')) ?>><?php echo 'Yes - 1' ?></option>
                                        <option value="<?php echo 0; ?>" <?php echo optionSetValue("1",get_dialer_option('enable_agc_xfer_log')) ?>><?php echo 'No - 0' ?></option>
                                    </select>
                                </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Agent Disposition Logfile"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="enable_agc_dispo_log" id="enable_agc_dispo_log">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enable_agc_dispo_log')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('enable_agc_dispo_log')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Timeclock End Of Day"; ?></label>
                            <div class="col-md-4">
                                <input type="text" name="timeclock_end_of_day" class="form-control" size="5" maxlength="4" value="<?php echo get_dialer_option('timeclock_end_of_day'); ?>" />
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Default Local GMT"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="default_local_gmt" id="default_local_gmt">
                                        <option value="12.75" <?php echo optionSetValue("12.75",get_dialer_option('default_local_gmt')) ?>>12.75</option>
                                        <option value="12.00" <?php echo optionSetValue("12.00",get_dialer_option('default_local_gmt')) ?>>12.00</option>
                                        <option value="11.00" <?php echo optionSetValue("11.00",get_dialer_option('default_local_gmt')) ?>>11.00</option>
                                        <option value="10.00" <?php echo optionSetValue("10.00",get_dialer_option('default_local_gmt')) ?>>10.00</option>
                                        <option value="9.50" <?php echo optionSetValue("9.50",get_dialer_option('default_local_gmt')) ?>>9.50</option>
                                        <option value="9.00" <?php echo optionSetValue("9.00",get_dialer_option('default_local_gmt')) ?>>9.00</option>
                                        <option value="8.00" <?php echo optionSetValue("8.00",get_dialer_option('default_local_gmt')) ?>>8.00</option>
                                        <option value="7.00" <?php echo optionSetValue("7.00",get_dialer_option('default_local_gmt')) ?>>7.00</option>
                                        <option value="6.50" <?php echo optionSetValue("6.50",get_dialer_option('default_local_gmt')) ?>>6.50</option>
                                        <option value="6.00" <?php echo optionSetValue("6.00",get_dialer_option('default_local_gmt')) ?>>6.00</option>
                                        <option value="5.75" <?php echo optionSetValue("5.75",get_dialer_option('default_local_gmt')) ?>>5.75</option>
                                        <option value="5.50" <?php echo optionSetValue("5.50",get_dialer_option('default_local_gmt')) ?>>5.50</option>
                                        <option value="5.00" <?php echo optionSetValue("5.00",get_dialer_option('default_local_gmt')) ?>>5.00</option>
                                        <option value="4.50" <?php echo optionSetValue("4.50",get_dialer_option('default_local_gmt')) ?>>4.50</option>
                                        <option value="4.00" <?php echo optionSetValue("4.00",get_dialer_option('default_local_gmt')) ?>>4.00</option>
                                        <option value="3.50" <?php echo optionSetValue("3.50",get_dialer_option('default_local_gmt')) ?>>3.50</option>
                                        <option value="3.00" <?php echo optionSetValue("3.00",get_dialer_option('default_local_gmt')) ?>>3.00</option>
                                        <option value="2.00" <?php echo optionSetValue("2.00",get_dialer_option('default_local_gmt')) ?>>2.00</option>
                                        <option value="1.00" <?php echo optionSetValue("1.00",get_dialer_option('default_local_gmt')) ?>>1.00</option>
                                        <option value="0.00" <?php echo optionSetValue("0.00",get_dialer_option('default_local_gmt')) ?>>0.00</option>
                                        <option value="-1.00" <?php echo optionSetValue("-1.00",get_dialer_option('default_local_gmt')) ?>>-1.00</option>
                                        <option value="-2.00" <?php echo optionSetValue("1",get_dialer_option('default_local_gmt')) ?>>-2.00</option>
                                        <option value="-3.00" <?php echo optionSetValue("-3.00",get_dialer_option('default_local_gmt')) ?>>-3.00</option>
                                        <option value="-3.50" <?php echo optionSetValue("-3.50",get_dialer_option('default_local_gmt')) ?>>-3.50</option>
                                        <option value="-4.00" <?php echo optionSetValue("1",get_dialer_option('default_local_gmt')) ?>>-4.00</option>
                                        <option value="-5.00" <?php echo optionSetValue("-5.00",get_dialer_option('default_local_gmt')) ?>>-5.00</option>
                                        <option value="-6.00" <?php echo optionSetValue("-6.00",get_dialer_option('default_local_gmt')) ?>>-6.00</option>
                                        <option value="-7.00" <?php echo optionSetValue("-7.00",get_dialer_option('default_local_gmt')) ?>>-7.00</option>
                                        <option value="-8.00" <?php echo optionSetValue("-8.00",get_dialer_option('default_local_gmt')) ?>>-8.00</option>
                                        <option value="-9.00" <?php echo optionSetValue("-9.00",get_dialer_option('default_local_gmt')) ?>>-9.00</option>
                                        <option value="-10.00" <?php echo optionSetValue("-10.00",get_dialer_option('default_local_gmt')) ?>>-10.00</option>
                                        <option value="-11.00" <?php echo optionSetValue("-11.00",get_dialer_option('default_local_gmt')) ?>>-11.00</option>
                                        <option value="-12.00" <?php echo optionSetValue("-12.00",get_dialer_option('default_local_gmt')) ?>>-12.00</option>
                                </select>
                                <span class="help-block"> <?php echo "Do NOT Adjust for DST"; ?> </span>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Default Voicemail Zone"; ?></label>
                            <div class="col-md-4">
                                <?php $vm_zones = get_dialer_option('voicemail_timezones'); ?>
                                <select class="form-control" name="default_voicemail_timezone" id="default_voicemail_timezone">
                                   <?php foreach (explode(',',$vm_zones) as $key => $value) : ?>
                                       <option value="<?php echo $value; ?>" <?php echo $value == get_dialer_option('default_voicemail_timezone') ? 'selected':'' ?> ><?php echo $value; ?></option>
                                   <?php endforeach; ?>
                                </select>
                             </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agents Calls Reset"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="agents_calls_reset" id="agents_calls_reset">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('agents_calls_reset')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('agents_calls_reset')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agent Screen Header Date Format"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="vdc_header_date_format" id="vdc_header_date_format">
                                    <option value="MS_DASH_24HR  2008-06-24 23:59:59" <?php echo optionSetValue("MS_DASH_24HR  2008-06-24 23:59:59",get_dialer_option('vdc_header_date_format')) ?>>MS_DASH_24HR  2008-06-24 23:59:59</option>";
                                    <option value="US_SLASH_24HR 06/24/2008 23:59:59" <?php echo optionSetValue("US_SLASH_24HR 06/24/2008 23:59:59",get_dialer_option('vdc_header_date_format')) ?>>US_SLASH_24HR 06/24/2008 23:59:59</option>";
                                    <option value="EU_SLASH_24HR 24/06/2008 23:59:59" <?php echo optionSetValue("EU_SLASH_24HR 24/06/2008 23:59:59",get_dialer_option('vdc_header_date_format')) ?>>EU_SLASH_24HR 24/06/2008 23:59:59</option>";
                                    <option value="AL_TEXT_24HR  JUN 24 23:59:59" <?php echo optionSetValue("AL_TEXT_24HR  JUN 24 23:59:59",get_dialer_option('vdc_header_date_format')) ?>>AL_TEXT_24HR  JUN 24 23:59:59</option>";
                                    <option value="MS_DASH_AMPM  2008-06-24 11:59:59 PM" <?php echo optionSetValue("MS_DASH_AMPM  2008-06-24 11:59:59 PM",get_dialer_option('vdc_header_date_format')) ?>>MS_DASH_AMPM  2008-06-24 11:59:59 PM</option>;
                                    <option value="US_SLASH_AMPM 06/24/2008 11:59:59 PM" <?php echo optionSetValue("US_SLASH_AMPM 06/24/2008 11:59:59 PM",get_dialer_option('vdc_header_date_format')) ?>>US_SLASH_AMPM 06/24/2008 11:59:59 PM</option>;
                                    <option value="EU_SLASH_AMPM 24/06/2008 11:59:59 PM" <?php echo optionSetValue("EU_SLASH_AMPM 24/06/2008 11:59:59 PM",get_dialer_option('vdc_header_date_format')) ?>>EU_SLASH_AMPM 24/06/2008 11:59:59 PM</option>;
                                    <option value="AL_TEXT_AMPM  JUN 24 11:59:59 PM" <?php echo optionSetValue("AL_TEXT_AMPM  JUN 24 11:59:59 PM",get_dialer_option('vdc_header_date_format')) ?>>AL_TEXT_AMPM  JUN 24 11:59:59 PM</option>";
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agent Screen Customer Date Format"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="vdc_customer_date_format" id="vdc_customer_date_format">
                                    <option value="MS_DASH_24HR  2008-06-24 23:59:59" <?php echo optionSetValue("MS_DASH_24HR  2008-06-24 23:59:59",get_dialer_option('vdc_customer_date_format')) ?>>MS_DASH_24HR  2008-06-24 23:59:59</option>";
                                    <option value="US_SLASH_24HR 06/24/2008 23:59:59" <?php echo optionSetValue("US_SLASH_24HR 06/24/2008 23:59:59",get_dialer_option('vdc_customer_date_format')) ?>>US_SLASH_24HR 06/24/2008 23:59:59</option>";
                                    <option value="EU_SLASH_24HR 24/06/2008 23:59:59" <?php echo optionSetValue("EU_SLASH_24HR 24/06/2008 23:59:59",get_dialer_option('vdc_customer_date_format')) ?>>EU_SLASH_24HR 24/06/2008 23:59:59</option>";
                                    <option value="AL_TEXT_24HR  JUN 24 23:59:59" <?php echo optionSetValue("AL_TEXT_24HR  JUN 24 23:59:59",get_dialer_option('vdc_customer_date_format')) ?>>AL_TEXT_24HR  JUN 24 23:59:59</option>";
                                    <option value="MS_DASH_AMPM  2008-06-24 11:59:59 PM" <?php echo optionSetValue("MS_DASH_AMPM  2008-06-24 11:59:59 PM",get_dialer_option('vdc_customer_date_format')) ?>>MS_DASH_AMPM  2008-06-24 11:59:59 PM</option>;
                                    <option value="US_SLASH_AMPM 06/24/2008 11:59:59 PM" <?php echo optionSetValue("US_SLASH_AMPM 06/24/2008 11:59:59 PM",get_dialer_option('vdc_customer_date_format')) ?>>US_SLASH_AMPM 06/24/2008 11:59:59 PM</option>;
                                    <option value="EU_SLASH_AMPM 24/06/2008 11:59:59 PM" <?php echo optionSetValue("EU_SLASH_AMPM 24/06/2008 11:59:59 PM",get_dialer_option('vdc_customer_date_format')) ?>>EU_SLASH_AMPM 24/06/2008 11:59:59 PM</option>;
                                    <option value="AL_TEXT_AMPM  JUN 24 11:59:59 PM" <?php echo optionSetValue("AL_TEXT_AMPM  JUN 24 11:59:59 PM",get_dialer_option('vdc_customer_date_format')) ?>>AL_TEXT_AMPM  JUN 24 11:59:59 PM</option>";
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                             <label class="col-md-3 control-label"><?php echo "Agent Screen Customer Phone Format"; ?></label>
                             <div class="col-md-4">
                                <select class="form-control" name="vdc_header_phone_format">
                                    <option value="US_DASH 000-000-0000" <?php echo optionSetValue("US_DASH 000-000-0000",get_dialer_option('vdc_header_phone_format')) ?>>US_DASH 000-000-0000</option>
                                    <option value="US_PARN (000)000-0000" <?php echo optionSetValue("US_PARN (000)000-0000",get_dialer_option('vdc_header_phone_format')) ?>>US_PARN (000)000-0000</option>
                                    <option value="MS_NODS 0000000000" <?php echo optionSetValue("MS_NODS 0000000000",get_dialer_option('vdc_header_phone_format')) ?>>MS_NODS 0000000000</option>
                                    <option value="UK_DASH 00 0000-0000" <?php echo optionSetValue("UK_DASH 00 0000-0000",get_dialer_option('vdc_header_phone_format')) ?>>UK_DASH 00 0000-0000</option>
                                    <option value="AU_SPAC 000 000 000" <?php echo optionSetValue("AU_SPAC 000 000 000",get_dialer_option('vdc_header_phone_format')) ?>>AU_SPAC 000 000 000</option>
                                    <option value="IT_DASH 0000-000-000" <?php echo optionSetValue("IT_DASH 0000-000-000",get_dialer_option('vdc_header_phone_format')) ?>>IT_DASH 0000-000-000</option>
                                    <option value="FR_SPAC 00 00 00 00 00" <?php echo optionSetValue("FR_SPAC 00 00 00 00 00",get_dialer_option('vdc_header_phone_format')) ?>>FR_SPAC 00 00 00 00 00</option>
                                </select>
                             </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agent API Active"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="vdc_agent_api_active" id="vdc_agent_api_active">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('vdc_agent_api_active')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('vdc_agent_api_active')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Agent Only Callback Campaign Lock"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="agentonly_callback_campaign_lock" id="agentonly_callback_campaign_lock">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('agentonly_callback_campaign_lock')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('agentonly_callback_campaign_lock')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Callback Time 24 Hours"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="callback_time_24hour" id="callback_time_24hour">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('callback_time_24hour')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('callback_time_24hour')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Central Sound Control Active"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="sounds_central_control_active" id="sounds_central_control_active">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('sounds_central_control_active')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('sounds_central_control_active')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Sounds Web Server"; ?></label>
                            <div class="col-md-4">
                               <input type="text" class="form-control" name="sounds_web_server" size="30" maxlength="50" value="<?php echo get_dialer_option('sounds_web_server'); ?>" />
                            </div>
                         </div>
<!--                     <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Active Voicemail Server"; ?></label>
                            <div class="col-md-4">
                                <select name="active_voicemail_server" class="form-control">
                                </select>
                            </div>
                         </div> -->
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Allow Voicemail Greeting Chooser"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="allow_voicemail_greeting" id="allow_voicemail_greeting">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('allow_voicemail_greeting')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('allow_voicemail_greeting')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Auto Dial Limit"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="auto_dial_limit" id="auto_dial_limit">
                                    <?php $adl=1; ?>
                                    <?php $val = get_dialer_option('auto_dial_limit') ?>
                                    <?php while( $adl < 1000 ):?>
                                        <option value="<?php echo $adl; ?>" <?php echo optionSetValue($adl,$val) ?>><?php echo $adl; ?></option>
                                        <?php
                                                if ($adl < 3)
                                                    {$adl = ($adl + 0.1);}
                                                else
                                                    {
                                                    if ($adl < 4)
                                                        {$adl = ($adl + 0.25);}
                                                    else
                                                        {
                                                        if ($adl < 5)
                                                            {$adl = ($adl + 0.5);}
                                                        else
                                                            {
                                                            if ($adl < 10)
                                                                {$adl = ($adl + 1);}
                                                            else
                                                                {
                                                                if ($adl < 20)
                                                                    {$adl = ($adl + 2);}
                                                                else
                                                                    {
                                                                    if ($adl < 40)
                                                                        {$adl = ($adl + 5);}
                                                                    else
                                                                        {
                                                                        if ($adl < 200)
                                                                            {$adl = ($adl + 10);}
                                                                        else
                                                                            {
                                                                            if ($adl < 400)
                                                                                {$adl = ($adl + 50);}
                                                                            else
                                                                                {
                                                                                if ($adl < 1000)
                                                                                    {$adl = ($adl + 100);}
                                                                                else
                                                                                    {$adl = ($adl + 1);}
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                        ?>
                                    <?php endwhile;  ?>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Outbound Auto-Dial Active"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="outbound_autodial_active" id="outbound_autodial_active">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('outbound_autodial_active')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('outbound_autodial_active')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Max FILL Calls per Second"; ?></label>
                            <div class="col-md-4">
                                <input type="text" name="outbound_calls_per_second" class="form-control" size="4" maxlength="3" value="<?php echo get_dialer_option('outbound_calls_per_second'); ?>" />
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Allow Custom Dialplan Entries"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="allow_custom_dialplan">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('allow_custom_dialplan')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('allow_sipsak_messages')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "PLLB Grouping Limit"; ?></label>
                            <div class="col-md-4">
                                <input type="text" name="pllb_grouping_limit" class="form-control" size="4" maxlength="3" value="<?php echo get_dialer_option('pllb_grouping_limit') ; ?>">
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Generate Cross-Server Phone Extensions"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="generate_cross_server_exten">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('generate_cross_server_exten')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('generate_cross_server_exten')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "User Territories Active"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="user_territories_active">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('user_territories_active')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('user_territories_active')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Second Webform"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="enable_second_webform">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enable_second_webform')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('enable_second_webform')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable TTS Integration"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="enable_tts_integration">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enable_tts_integration')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('enable_tts_integration')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable CallCard"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="callcard_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('callcard_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('callcard_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Custom List Fields"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="custom_fields_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('custom_fields_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('custom_fields_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Campaign Test Calls"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="test_campaign_calls">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('test_campaign_calls')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('test_campaign_calls')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Expanded List Stats"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="expanded_list_stats">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('expanded_list_stats')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('expanded_list_stats')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Country Code List Stats"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="country_code_list_stats">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('country_code_list_statscountry_code_list_stats')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('country_code_list_stats')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enhanced Disconnect Logging"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="enhanced_disconnect_logging">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enhanced_disconnect_logging')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('enhanced_disconnect_logging')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Campaign Areacode CID"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="campaign_cid_areacodes_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('campaign_cid_areacodes_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('campaign_cid_areacodes_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Remote Agent Extension Overrides"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="did_ra_extensions_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('did_ra_extensions_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('did_ra_extensions_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Enable Contacts"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="contacts_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('contacts_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('contacts_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Call Menu Qualify Enabled"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="call_menu_qualify_enabled">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('call_menu_qualify_enabled')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('call_menu_qualify_enabled')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Level 8 Disable Add"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="level_8_disable_add">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('level_8_disable_add')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('level_8_disable_add')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Admin List Counts"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="admin_list_counts">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('admin_list_counts')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('admin_list_counts')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo "Allow Emails"; ?></label>
                            <div class="col-md-4">
                                <select class="form-control" name="allow_emails">
                                    <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('allow_emails')) ?>><?php echo 'Yes - 1' ?></option>
                                    <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('allow_emails')) ?>><?php echo 'No - 0' ?></option>
                                </select>
                            </div>
                         </div>
                         <div class="form-group" style="display: none;">
                            <label class="col-md-3 control-label"><?php echo "First Login Trigger"; ?></label>
                            <div class="col-md-4">
                                <input type="hidden" name="first_login_trigger" class="form-control" size="4" maxlength="3" value="<?php echo get_dialer_option('first_login_trigger') ?>" />
                            </div>
                         </div>
                    </div>
                    <div class="form-actions">
                        <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn blue">Submit</button>
                        </div>
                    </div>