<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
        </div>
    </div>
    <div class="portlet-body">
        <form name="leadForm" id="leadForm" class="form-horizontal" method="post">
            <div class="form-body">
                <div class="form-group">
                    <?php
                            $settingLabel = (array)get_dialer_option();
                            $label_title =  "Title";
                            if( $temp = $settingLabel['label_title'] ) { $label_title = $temp; }
                            $label_first_name =	"First";
                            if( $temp = $settingLabel['label_first_name'] ) { $label_first_name = $temp; }
                            $label_middle_initial = "MI";
                            if( $temp = $settingLabel['label_middle_initial'] ) { $label_middle_initial = $temp; }
                            $label_last_name = "Last";
                            if( $temp = $settingLabel['label_last_name'] ) { $label_last_name = $temp; }
                            $label_address1 = "Address1";
                            if( $temp = $settingLabel['label_address1'] ) { $label_address1 = $temp; }
                            $label_address2 = "Address2";
                            if( $temp = $settingLabel['label_address2'] ) { $label_address2 = $temp; }
                            $label_address3 = "Address3";
                            if( $temp = $settingLabel['label_address3'] ) { $label_address3 = $temp; }
                            $label_city = "City";
                            if( $temp = $settingLabel['label_city'] ) { $label_city = $temp; }
                            $label_state = "State";
                            if( $temp = $settingLabel['label_state'] ) { $label_state = $temp; }
                            $label_province = "Province";
                            if( $temp = $settingLabel['label_province'] ) { $label_province = $temp; }
                            $label_postal_code = "Postal Code";
                            if( $temp = $settingLabel['label_postal_code'] ) { $label_postal_code = $temp; }
                            $label_vendor_lead_code = "Vendor ID";
                            if( $temp = $settingLabel['label_vendor_lead_code'] ) { $label_vendor_lead_code = $temp; }
                            $label_gender = "Gender";
                            if( $temp = $settingLabel['label_gender'] ) { $label_gender = $temp; }
                            $label_phone_number = "Phone";
                            if( $temp = $settingLabel['label_phone_number'] ) { $label_phone_number = $temp; }
                            $label_phone_code =	"DialCode";
                            if( $temp = $settingLabel['label_phone_code'] ) { $label_phone_code = $temp; }
                            $label_alt_phone = "Alt. Phone";
                            if( $temp = $settingLabel['label_alt_phone'] ) { $label_alt_phone = $temp; }
                            $label_security_phrase = "Show";
                            if( $temp = $settingLabel['label_security_phrase'] ) { $label_security_phrase = $temp; }
                            $label_email = "Email";
                            if( $temp = $settingLabel['label_email'] ) { $label_email = $temp; }
                            $label_comments = "Comments";
                            if( $temp = $settingLabel['label_comments'] ) { $label_comments = $temp; }
                    ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Agency' ?> <span class="required"> * </span></label>
                        <div class="col-md-4">
                            <?php  $tree = buildTree($agencies,0); ?>
                            <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectList(this.value)">
                                <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTree($tree,0, null, isset($alead->agency_id) ? $alead->agency_id : '' ); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'List Id' ?> <span class="required"> * </span> </label>
                        <div class="col-md-4">
                            <select class="form-control" name="list_id">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_title ?></label>
                        <div class="col-md-4">
                            <input type="text" name="title"  value="<?php echo $lead->title ?>" maxlength="4" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_first_name ?> <span class="required"> * </span></label>
                        <div class="col-md-4">
                            <input type="text" name="first_name" value="<?php echo $lead->first_name ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_middle_initial ?></label>
                        <div class="col-md-4">
                            <input type="text" name="middle_initial" value="<?php echo $lead->middle_initial ?>" maxlength="1" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_last_name ?> <span class="required"> * </span></label>
                        <div class="col-md-4">
                            <input type="text" name="last_name" value="<?php echo $lead->last_name ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_address1 ?></label>
                        <div class="col-md-4">
                            <input type="text" name="address1" value="<?php echo $lead->address1 ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_address2 ?></label>
                        <div class="col-md-4">
                            <input type="text" name="address2" value="<?php echo $lead->address2 ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_address3 ?></label>
                        <div class="col-md-4">
                            <input type="text" name="address3" value="<?php echo $lead->address3 ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Country' ?></label>
                        <div class="col-md-4">
                            <select name="country_code" class="form-control">
                                <?php foreach($countries as $country): ?>
                                    <option value="<?php echo $country->sortname ?>" <?php echo optionSetValue($country->sortname, $lead->country_code ) ?>><?php echo $country->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_state ?></label>
                        <div class="col-md-4" >
                            <select name="state" class="form-control"  onchange="javascript:selectCity(this)">
                                <option value=""><?php echo 'Please Select' ?></option>
                                <?php foreach($states as $state): ?>
                                <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>" <?php echo optionSetValue($state->abbreviation, $lead->state) ?>><?php echo $state->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_city ?></label>
                        <div class="col-md-4">
                            <select class="form-control" name="city">
                            </select>
<!--                            <input type="text" name="city" value="" maxlength="30" class="form-control" />-->
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_postal_code ?></label>
                        <div class="col-md-4">
                            <input type="text" name="postal_code" value="<?php echo $lead->postal_code ?>" maxlength="10" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_province ?></label>
                        <div class="col-md-4">
                            <input type="text" name="province" value="<?php echo $lead->province ?>" maxlength="30" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Date of Birth' ?></label>
                        <div class="col-md-4">
                            <input type="text" id="date" name="date_of_birth" value="<?php echo $lead->date_of_birth ?>" maxlength="10" class="form-control" />
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_phone_number ?></label>
                        <div class="col-md-4">
                            <input type="text" name="phone_number" value="<?php echo $lead->phone_number ?>" maxlength="20" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_phone_code ?></label>
                        <div class="col-md-4">
                            <input type="text" name="phone_code" value="<?php echo $lead->phone_code ?>" maxlength="10" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_alt_phone ?></label>
                        <div class="col-md-4">
                            <input type="text" name="alt_phone" value="<?php echo $lead->alt_phone ?>" maxlength="20" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_email ?></label>
                        <div class="col-md-4">
                            <input type="text" name="email" value="<?php echo $lead->email ?>" maxlength="50" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_security_phrase ?></label>
                        <div class="col-md-4">
                            <input type="text" name="security_phrase" value="<?php echo $lead->security_phrase ?>" maxlength="100" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_vendor_lead_code ?></label>
                        <div class="col-md-4">
                            <input type="text" name="vendor_lead_code" value="<?php echo $lead->vendor_lead_code ?>" maxlength="100" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Rank' ?></label>
                        <div class="col-md-4">
                            <input type="text" name="rank" value="<?php echo $lead->rank ?>" maxlength="5" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Owner' ?></label>
                        <div class="col-md-4">
                            <input type="text" name="owner" value="<?php echo $lead->owner ?>" maxlength="22" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $label_comments ?></label>
                        <div class="col-md-4">
                            <textarea name="comments" ROWS="3" COLS="65" class="form-control"><?php echo $lead->comments ?></textarea>
                        </div>
                    </div>
                    <?php if(isset($lead->lead_id) && $lead->lead_id != ''): ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo 'Disposition' ?></label>
                            <div class="col-md-4">
                                <select name="status" class="form-control">
                                    <?php echo getDespositionStatus($lead, $lead->status) ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- .portlet-body -->
    <?php if(isset($lead->lead_id) && $lead->lead_id != ''): ?>
    <div class="portlet-body">
        <p><strong><?php echo 'Callback Details:' ?></strong></p>
        <p><?php echo 'If you want to change this lead to a scheduled callback, first change the Disposition to CBHOLD, then submit and you will be able to set the callback date and time.' ?></p>

        <table class="table table-bordered">
            <caption style="text-align: center;font-weight: bold;color: #217ebd;"><?php echo 'CALLS TO THIS LEAD:' ?></caption>
            <thead>
                <tr>
                    <th> <?php echo '#' ?> </th>
                    <th> <?php echo 'Date/Time' ?> </th>
                    <th> <?php echo 'Lenght' ?> </th>
                    <th> <?php echo 'Status' ?> </th>
                    <th> <?php echo 'TSR' ?> </th>
                    <th> <?php echo 'Campaign' ?> </th>
                    <th> <?php echo 'List' ?> </th>
                    <th> <?php echo 'Lead' ?> </th>
                    <th> <?php echo 'Hangup Reason' ?> </th>
                    <th> <?php echo 'Phone' ?> </th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0 ?>
                <?php foreach($call_logs as $log): $i++; ?>
                <tr>
                    <td> <?php echo $i ?> </td>
                    <td> <?php echo $log->call_date ?> </td>
                    <td> <?php echo $log->length_in_sec ?> </td>
                    <td> <?php echo $log->status ?> </td>
                    <td> <?php echo $log->user ?> </td>
                    <td> <?php echo $log->campaign_id ?> </td>
                    <td> <?php echo $log->list_id ?> </td>
                    <td> <?php echo $log->lead_id ?> </td>
                    <td> <?php echo $log->term_reason ?> </td>
                    <td> <?php echo $log->phone_number ?> </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <caption style="text-align: center;font-weight: bold;color: #217ebd;"><?php echo 'CLOSER RECORDS FOR THIS LEAD:' ?></caption>
            <thead>
                <tr>
                    <th> <?php echo '#' ?> </th>
                    <th> <?php echo 'Date/Time' ?> </th>
                    <th> <?php echo 'Lenght' ?> </th>
                    <th> <?php echo 'Status' ?> </th>
                    <th> <?php echo 'TSR' ?> </th>
                    <th> <?php echo 'Campaign' ?> </th>
                    <th> <?php echo 'List' ?> </th>
                    <th> <?php echo 'Lead' ?> </th>
                    <th> <?php echo 'Wait' ?> </th>
                    <th> <?php echo 'Hangup Reason' ?> </th>
                    <th> <?php echo 'Phone' ?> </th>
                </tr>
            </thead>
            <tbody>
                <?php $i;foreach($closer_logs as $log): $i++; ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $log->call_date ?></td>
                    <td><?php echo $log->length_in_sec ?></td>
                    <td><?php echo $log->status ?></td>
                    <td><?php echo $log->user ?></td>
                    <td><?php echo $log->list_id ?></td>
                    <td><?php echo $log->closecallid ?></td>
                    <td><?php echo $log->queue_seconds ?></td>
                    <td><?php echo $log->term_reason ?></td>
                    <td>
                        <?php $stmtA="SELECT call_notes FROM vicidial_call_notes WHERE lead_id='" . $lead->lead_id . "' and vicidial_id='$log->closecallid';"; ?>
                        <?php $row = $this->vicidialdb->db->query($stmtA)->row(); ?>
                        <?php if($row): ?>
                            <?php echo $row->call_notes ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <caption style="text-align: center;font-weight: bold;color: #217ebd;"><?php echo 'AGENT LOG RECORDS FOR THIS LEAD:' ?></caption>
            <thead>
                <tr>
                    <th> <?php echo '#' ?> </th>
                    <th> <?php echo 'Date/Time' ?> </th>
                    <th> <?php echo 'Campaign' ?> </th>
                    <th> <?php echo 'TSR' ?> </th>
                    <th> <?php echo 'Pause' ?> </th>
                    <th> <?php echo 'Wait' ?> </th>
                    <th> <?php echo 'Talk' ?> </th>
                    <th> <?php echo 'Dispo' ?> </th>
                    <th> <?php echo 'Status' ?> </th>
                    <th> <?php echo 'Group' ?> </th>
                    <th> <?php echo 'Sub' ?> </th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach($agent_logs as $log): $i++; ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $log->event_time; ?></td>
                    <td><?php echo $log->campaign_id; ?></td>
                    <td><?php echo $log->user; ?></td>
                    <td><?php echo $log->pause_epoch; ?></td>
                    <td><?php echo $log->wait_epoch; ?></td>
                    <td><?php echo $log->talk_epoch; ?></td>
                    <td><?php echo $log->dispo_epoch; ?></td>
                    <td><?php echo $log->status; ?></td>
                    <td><?php echo $log->user_group; ?></td>
                    <td><?php echo $log->sub_status; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="table table-bordered">
            <caption style="text-align: center;font-weight: bold;color: #217ebd;"><?php echo 'IVR LOGS FOR THIS LEAD:' ?></caption>
            <thead>
                <tr>
                    <th><?php echo '#' ?></th>
                    <th><?php echo 'Campaign' ?></th>
                    <th><?php echo 'Date/Time' ?></th>
                    <th><?php echo 'Call Menu' ?></th>
                    <th><?php echo 'Action' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $i=0;foreach($ivr_logs as $log): $i++; ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $log->campaign_id ?></td>
                    <td><?php echo $log->event_date ?></td>
                    <td><?php echo $log->menu_id ?></td>
                    <td><?php echo $log->menu_action ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
    function selectCity(state,city_name){
        var state_id = jQuery(state).find(":selected").attr('data-id');
        jQuery.ajax({
            url : '<?php echo site_url('dialer/lists/getcity') ?>',
            method : 'post',
            dataType : 'json',
            data : {state : state_id, city : city_name},
            success : function(result){
                jQuery('[name="city"]').replaceWith(result.result);
            }
        });
    }
    function selectList(agency_id, list_id){
        jQuery.ajax({
            url : '<?php echo site_url('dialer/lists/getlist') ?>',
            method : 'post',
            dataType : 'json',
            data : {agency : agency_id, list : list_id},
            success : function(result){
                jQuery('[name="list_id"]').replaceWith(result.result);
            }
        });
    }
    jQuery(function(){
        selectList('<?php echo isset($alead->agency_id) ? $alead->agency_id : '' ?>','<?php echo isset($alead->list_id) ? $alead->list_id : '' ?>');
        selectCity(jQuery('[name="state"]'),'<?php echo $lead->city ?>');
        jQuery('#date').datepicker({
            format: 'mm/dd/yyyy',
            endDate: '+0d',
        });
    });
</script>