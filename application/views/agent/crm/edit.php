<div class="breadcrumbs lead">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'Leads' ?>
        </li>
    </ol>
</div>
<style type="text/css">
    #leadForm .portlet-title {border-bottom: 1px solid #f3f3f3;font-size: 16px;padding: 5px;}
</style>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (validation_errors() != ''): ?>
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
            <?php if ($lead->lead_id != '') : ?>
                <?php if ($lead->status != '' && $lead->status == 'Lead') : ?>
                    <a href="<?= base_url('crm/change_status/Opportunity/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Lead to Opportunities</a>
                    <a href="<?= base_url('crm/change_status/Client/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Lead to Client</a>
                <?php elseif ($lead->status != '' && $lead->status == 'Opportunity') : ?>
                    <a href="<?= base_url('crm/change_status/Lead/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Opportunities to Lead</a>
                    <a href="<?= base_url('crm/change_status/Client/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Opportunities to Client</a>
                <?php elseif ($lead->status != '' && $lead->status == 'Client') : ?>
                    <a href="<?= base_url('crm/change_status/Lead/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Client to Lead</a>
                    <a href="<?= base_url('crm/change_status/Opportunity/' . encode_url($lead->lead_id)) ?>" class="btn green"><i class="fa fa-refresh"></i> Convert Client to Opportunities</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
        <div class="portlet-body">
            <div class="tabbable-line">
                <?php $this->load->view('agent/crm/tabs') ?>
                <div class="tab-content">
                    <div id="information" class="tab-pane">
                        <form name="leadForm" id="leadForm" class="form-horizontal" method="post">
                    <div class="form-body">
                        <input type="hidden" name="status" value="<?php echo $status ?>" />
                        <input type="hidden" name="leadid" id="lead-Id" value="<?php echo $lead->lead_id ?>" />
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Name' ?><span class="required">*</span></label>
                            <div class="col-md-2">
                                <input type="text" name="first_name" placeholder="First Name" class="form-control" value="<?php echo $lead->first_name ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="middle_name" placeholder="Middle Name" class="form-control" value="<?php echo $lead->middle_name ?>" />
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo $lead->last_name ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Email' ?></label>
                            <div class="col-md-4">
                                <input type="text" name="email" id="emailid" class="form-control" value="<?php echo $lead->email ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-md-3  control-label"><?php echo 'Dial Code' ?></label>
                            <div class="col-md-1">
                                <input type="text" name="dialcode" class="form-control" value="<?php echo $lead->dialcode ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Phone' ?><span class="required">*</span></label>
                            <div class="col-md-4">
                                <input type="text" name="phone" id="phone-number" class="form-control" value="<?php echo $lead->phone ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Cell Phone' ?></label>
                            <div class="col-md-4">
                                <input type="text" name="cellphone" class="form-control" value="<?php echo isset($lead->cellphone) && ($lead->cellphone != 0) ? $lead->cellphone : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Work Phone' ?></label>
                            <div class="col-md-4">
                                <input type="text" name="work_phone" class="form-control" value="<?php echo isset($lead->work_phone) && ($lead->work_phone != 0) ? $lead->work_phone : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Address' ?></label>
                            <div class="col-md-6">
                                <input name="address" type="text" placeholder="<?php echo 'Street Address' ?>"  class="form-control" value="<?php echo $lead->address ?>"/>
                                <br />
                                <input name="address1" type="text" placeholder="<?php echo 'Street Address' ?>" class="form-control" value="<?php echo $lead->address1 ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label class="col-md-3  control-label"><?php echo 'Country' ?></label>
                            <div class="col-md-4">
                                <select name="country" class="form-control">
                                    <?php foreach ($countries as $country): ?>
                                        <option value="<?php echo $country->sortname ?>" <?php echo optionSetValue($country->sortname, $lead->country) ?>><?php echo $country->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label">&nbsp;</label>
                            <div class="col-md-2" >
                                <label><?php echo 'State' ?></label>
                                <select name="state" class="form-control"  onchange="javascript:selectCity(this)">
                                    <option value=""><?php echo 'Please Select' ?></option>
                                    <?php foreach ($states as $state): ?>
                                        <option value="<?php echo $state->abbreviation; ?>" data-id="<?php echo $state->id ?>" <?php echo optionSetValue($state->abbreviation, $lead->state) ?>><?php echo $state->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label><?php echo 'City' ?></label>
                                <select class="form-control" name="city">
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label><?php echo 'Zip Code' ?></label>
                                <input type="text" name="postal_code" class="form-control" value="<?php echo $lead->postal_code ?>" placeholder="Zip Code"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Personal' ?></label>
                            <div class="col-md-4">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios4" value="M" <?php echo $lead->gender == 'M' ? 'checked' : '' ?>> <?php echo 'Male' ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios5" value="F" <?php echo $lead->gender == 'F' ? 'checked' : '' ?>> <?php echo 'Female' ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label">&nbsp;</label>
                            <div class="col-md-2">
                                <label><?php echo 'Height' ?></label>
                                <select class="form-control" name="height" >
                                    <option value=""><?php echo 'Select Height' ?></option>
                                    <option value="4' 6&quot;" <?php echo optionSetValue("4' 6\"", $lead->height) ?>>4' 6"</option>
                                    <option value="4' 7&quot;" <?php echo optionSetValue("4' 7\"", $lead->height) ?>>4' 7"</option>
                                    <option value="4' 8&quot;" <?php echo optionSetValue("4' 8\"", $lead->height) ?>>4' 8"</option>
                                    <option value="4' 9&quot;" <?php echo optionSetValue("4' 9\"", $lead->height) ?>>4' 9"</option>
                                    <option value="4' 10&quot;" <?php echo optionSetValue("4' 10\"", $lead->height) ?>>4' 10"</option>
                                    <option value="4' 11&quot;" <?php echo optionSetValue("4' 11\"", $lead->height) ?>>4' 11"</option>
                                    <option value="5' 0&quot;" <?php echo optionSetValue("5' 0\"", $lead->height) ?>>5' 0"</option>
                                    <option value="5' 1&quot;" <?php echo optionSetValue("5' 1\"", $lead->height) ?>>5' 1"</option>
                                    <option value="5' 2&quot;" <?php echo optionSetValue("5' 2\"", $lead->height) ?>>5' 2"</option>
                                    <option value="5' 3&quot;" <?php echo optionSetValue("5' 3\"", $lead->height) ?>>5' 3"</option>
                                    <option value="5' 4&quot;" <?php echo optionSetValue("5' 4\"", $lead->height) ?>>5' 4"</option>
                                    <option value="5' 5&quot;" <?php echo optionSetValue("5' 5\"", $lead->height) ?>>5' 5"</option>
                                    <option value="5' 6&quot;" <?php echo optionSetValue("5' 6\"", $lead->height) ?>>5' 6"</option>
                                    <option value="5' 7&quot;" <?php echo optionSetValue("5' 7\"", $lead->height) ?>>5' 7"</option>
                                    <option value="5' 8&quot;" <?php echo optionSetValue("5' 8\"", $lead->height) ?>>5' 8"</option>
                                    <option value="5' 9&quot;" <?php echo optionSetValue("5' 9\"", $lead->height) ?>>5' 9"</option>
                                    <option value="5' 10&quot;" <?php echo optionSetValue("5' 10\"", $lead->height) ?>>5' 10"</option>
                                    <option value="5' 11&quot;" <?php echo optionSetValue("5' 11\"", $lead->height) ?>>5' 11"</option>
                                    <option value="6' 0&quot;" <?php echo optionSetValue("6' 00\"", $lead->height) ?>>6' 0"</option>
                                    <option value="6' 1&quot;" <?php echo optionSetValue("6' 1\"", $lead->height) ?>>6' 1"</option>
                                    <option value="6' 2&quot;" <?php echo optionSetValue("6' 2\"", $lead->height) ?>>6' 2"</option>
                                    <option value="6' 3&quot;" <?php echo optionSetValue("6' 3\"", $lead->height) ?>>6' 3"</option>
                                    <option value="6' 4&quot;" <?php echo optionSetValue("6' 4\"", $lead->height) ?>>6' 4"</option>
                                    <option value="6' 5&quot;" <?php echo optionSetValue("6' 5\"", $lead->height) ?>>6' 5"</option>
                                    <option value="6' 6&quot;" <?php echo optionSetValue("6' 6\"", $lead->height) ?>>6' 6"</option>
                                    <option value="6' 7&quot;" <?php echo optionSetValue("6' 7\"", $lead->height) ?>>6' 7"</option>
                                    <option value="6' 8&quot;" <?php echo optionSetValue("6' 8\"", $lead->height) ?>>6' 8"</option>
                                    <option value="6' 9&quot;" <?php echo optionSetValue("6' 9\"", $lead->height) ?>>6' 9"</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label><?php echo 'Weight' ?></label>
                                <input name="weight" type="text" class="form-control" value="<?php echo $lead->weight ?>"/>
                            </div>
                            <div class="col-md-2">
                                <label><?php echo 'Date of Birth' ?></label>
                                <input type="text" placeholder="mm/dd/yyyy" name="date_of_birth" class="form-control" value="<?php echo strlen($lead->date_of_birth) > 0 ? date('m/d/Y', strtotime($lead->date_of_birth)) : '' ?>"/>
                            </div>
                        </div>
                        <?php if($status == 'Opportunity') :?>
                            <div class="form-group">
                                <label class="col-md-3  control-label"><?php echo 'Opportunity Status' ?></label>
                                <div class="col-md-4">
                                    <select name="opportunity_status" class="form-control" id="opportunity_status">
                                        <option value="Pre-Qualified"><?php echo 'Pre-Qualified' ?></option>
                                        <option value="Appointment Set"><?php echo 'Appointment Set' ?></option>
                                        <option value="Quote Sent"><?php echo 'Quote Sent' ?></option>
                                        <option value="Quote Accepted"><?php echo 'Quote Accepted' ?></option>
                                        <option value="Deal Won"><?php echo 'Deal Won' ?></option>
                                    </select>
                                </div>
                            </div>
                            <script>
                                $("#opportunity_status").val("<?=$lead->opportunity_status?>");
                            </script>
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Source' ?></label>
                            <div class="col-md-4">
                                <input type="text" name="source" class="form-control" value="<?php echo isset($lead->source) ? $lead->source : ''; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Lead Status' ?></label>
                            <div class="col-md-4">
                                <select name="lead_status" class="form-control" id="lead_status">
                                    <option value="1"><?php echo 'Active' ?></option>
                                    <option value="0"><?php echo 'Inactive' ?></option>
                                </select>
                            </div>
                             <script>
                                $("#lead_status").val("<?=$lead->lead_status?>");
                            </script>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Disposition' ?></label>
                            <div class="col-md-4">
                                <select name="dispo" class="form-control" id="dispo">
                                    <option value="NEW" <?php echo optionSetValue('NEW', $lead->dispo) ?>><?php echo 'NEW' ?></option>
                                    <option value="CALLBACK" <?php echo optionSetValue('CALLBACK', $lead->dispo) ?>><?php echo 'CALLBACK' ?></option>
                                    <option value="QUOTED" <?php echo optionSetValue('QUOTED', $lead->dispo) ?>><?php echo 'QUOTED' ?></option>
                                    <option value="SALE MADE" <?php echo optionSetValue('SALE MADE', $lead->dispo) ?>><?php echo 'SALE MADE' ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3  control-label"><?php echo 'Notes' ?></label>
                            <div class="col-md-6">
                                <textarea name="notes" class="form-control" style="height:100px;"><?php echo $lead->notes ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="fa fa-building-o font-dark"></i>
                            <span class="caption-subject bold uppercase"> <?php echo 'Additional Information'; ?> </span>
                        </div>
                        <div class="actions">
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Mothers Maiden Name' ?></label>
                                <div class="col-md-4">
                                    <input type="text" name="mothers_maiden_name" class="form-control" value="<?php echo $lead->mothers_maiden_name ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Drivers License Number' ?></label>
                                <div class="col-md-4">
                                    <input type="text" name="license_number" class="form-control" value="<?php echo $lead->license_number ?>" />
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Social Security Number' ?></label>
                                <div class="col-md-4">
                                    <input type="text" name="security_number" class="form-control" value="<?php echo $lead->security_number ?>" />
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Occupation' ?></label>
                                <div class="col-md-4">
                                    <input type="text" name="occupation" class="form-control" value="<?php echo $lead->occupation ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($lead->lead_id > 0): ?>
                        <div class="portlet-title">
                            <div class="caption font-dark" style="display: inline-block;">
                                <i class="fa fa-building-o font-dark"></i>
                                <span class="caption-subject bold uppercase"> <?php echo 'Custom Fields'; ?> </span>
                            </div>
                            <div class="actions" style="display: inline-block;float: right;">
                                <a href="<?php echo site_url('crm/addfield/' . encode_url($lead->lead_id)) ?>" class="btn green" type="button" data-target="#ajax" data-toggle="modal"><?php echo 'Add Field' ?></a>
                                <a href="<?php echo site_url('crm/removefield/' . encode_url($lead->lead_id)) ?>" class="btn green" type="button" data-target="#ajaxremove" data-toggle="modal"><?php echo 'Remove Field' ?></a>
                            </div>
                            <div style="clear:both;"></div>
                        </div>

                        <div class="portlet-body">
                            <div class="form-body custom-fi-body">

                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="portlet-body">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button class="btn green" type="submit">Submit</button>
                                    <a class="btn" href="<?php echo $cancelurl; ?>">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        </form>
                    </div><!-- #information .tab-pane  -->
                    <div id="files" class="tab-pane">
                        <h4>Files</h4>
                    </div>
                    <div id="people" class="tab-pane">
                        <h4>people</h4>
                    </div>
                    <div id="products" class="tab-pane">
                        <h4>Products</h4>
                    </div>
                    <div id="notes" class="tab-pane active">
                        <h4>Notes</h4>
                    </div>
                </div><!-- .tab-content -->
            </div><!-- .tabbable-line -->
        </div>

</div>
<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxremove" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<script type="text/javascript">
<?php if ($lead->lead_id > 0): ?>
        var requireJson = <?php echo isset($requiredJson) ? $requiredJson : ''; ?>;
<?php else: ?>
        var requireJson = '';
<?php endif; ?>
    jQuery(function () {
        $("#leadnote a").click();
        renderCustomFields();
        jQuery('#crm').addClass('open');
        jQuery('#lead').addClass('open');
        jQuery('#<?php echo lcfirst($status) ?>').addClass('active');
        var endDate = new Date();
        jQuery('[name="date_of_birth"]').datepicker({
            format: "mm/dd/yyyy",
            endDate: endDate,
            orientation: "bottom auto"
        });
<?php if (isset($lead->lead_id) && $lead->lead_id > 0): ?>
            selectCity(jQuery('[name="state"]'), '<?php echo $lead->city ?>')
<?php endif; ?>
        jQuery('#leadstore').parent('a').parent('li').addClass('open');
        jQuery('#lead').parent('a').parent('li').parent('ul').show();
        jQuery('#lead').parent('a').parent('li').addClass('active');
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    email: true,
                    remote: {
                        url: "<?php echo site_url('ajax/checkEmail/'.$lead->lead_id) ?>",
                        type: "post",
                        data: {
                            email : function() {
                              return $('#emailid').val();
                            }
                        }
                    },
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    remote: {
                        url: "<?php echo site_url('ajax/checkPhone/'.$lead->lead_id)?>",
                        type: "post",
                        data: {
                            phone : function() {
                              return $('#phone-number').val();
                            }
                        }
                    },
                },
            },
            messages: {
                phone: {
                    remote: "Phone number is already exist, please try other number."
                },
                email: {
                    remote: "Email address is already exist, please try other email address."
                },
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio") { // for uniform radio buttons, insert the after the given container
                    error.appendTo(element.parent('label').parent('div'));
                } else if (element.attr("name") == "bid_id") { // for uniform checkboxes, insert the after the given container
                    error.insertAfter("#form_bid_error");
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },
        });
    });

    function selectCity(state, city_name) {
        jQuery('#loading').modal('show');
        var state_id = jQuery(state).find(":selected").attr('data-id');
        if (typeof state_id == 'undefined') {
            state_id = '';
        }
        jQuery.ajax({
            url: '<?php echo site_url('ajax/getcity') ?>',
            method: 'post',
            dataType: 'json',
            data: {state: state_id, city: city_name},
            success: function (result) {
                jQuery('[name="city"]').replaceWith(result.result);
                jQuery('#loading').modal('hide');
            }
        });
    }
    function renderCustomFields() {
        jQuery.ajax({
            url: '<?php echo site_url("crm/renderfields/" . encode_url($lead->lead_id)) ?>',
            method: 'post',
            dataType: 'json',
            success: function (result) {
                requireJson = result.refreshjson;
                jQuery('.custom-fi-body').html(result.html);
                jQuery.each(requireJson, function (index, value) {
                    jQuery('[name="custom_field[' + value.field_id + ']"]').rules("add", {
                        required: true,
                    });
                });
            }
        });
    }
</script>