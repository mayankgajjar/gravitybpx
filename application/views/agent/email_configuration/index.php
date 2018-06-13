<style>
    .nipl-lead-model textarea,.nipl-lead-model select{
        width: 70% !important;
        display: inline-block;
    }
    .add {
        margin-right: 10px;
    }
</style>
<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $label; ?>
        </li>
    </ol>
</div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <?php if($smtp_already_added == 0){ ?>
            <div class="actions smtp-configuration">
                <a class="btn btn-info add" data-toggle="modal" href="#add-configuration-smtp">
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs"><?php echo "SMTP Configuration"; ?></span>
                </a>
            </div>
        <?php } ?>
        
        <?php if($emailclient_already_added == 0){ ?>
            <div class="actions email-configuration">
                <a class="btn btn-info add" data-toggle="modal" href="#add-configuration-email">
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs"><?php echo "Emailclient Configuration"; ?></span>
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th> Username </th>
                    <th> Host </th>
                    <th> Port </th>
                    <th> SSL </th>
                    <th> SMTP </th>
                    <th> Configuration Type </th>
                    <th> &nbsp; </th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- /Add email configuration modal -->
<div class="modal fade bs-modal-lg" id="add-configuration-email" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg nipl-lead-model">
    <form action="" method="post" class="email-configuration-form com-form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title_email; ?></span>
                </div>
            </div>
            <input type="hidden" name="id" id="config_id" value="" />
            <input type="hidden" name="config_type" id="config_type" value="Email_Client"/>
            
            <div class="modal-body"> 
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Username <span class="required"> * </span></label> 
                            <div class="nipl_input_div">
                                <input type="email" name="username" class="form-control" id="username" placeholder="demo@example.com" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="password" name="password" class="form-control" id="password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Port <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="port" class="form-control" id="port" placeholder="993" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Host <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="host" class="form-control" id="host" placeholder="imap.gmail.com" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SSL  <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <span><input type="radio" name="ssl_type" id="ssl_yes" value="Yes"></span> Yes                            </label>
                                    <label class="radio-inline">
                                        <span><input type="radio" name="ssl_type" id="ssl_no" value="No"></span> No                            </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <input type="submit" class="btn green" id="save" name="Save_Changes" value="Save Changes" >
            </div>
        </div>
    </form>
    <!-- /.modal-content -->
</div> 
<!-- /.modal-dialog -->
</div>
<!-- /Add email configuration modal -->

<!-- /Add smtp configuration modal -->
<div class="modal fade bs-modal-lg" id="add-configuration-smtp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg nipl-lead-model">
    <form action="" method="post" class="smtp-configuration-form com-form">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title_smtp; ?></span>
                </div>
            </div>
            <input type="hidden" name="id" id="smtp_config_id" value="" />
            <input type="hidden" name="config_type" id="config_type" value="SMTP"/>
            <div class="modal-body"> 
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Username <span class="required"> * </span></label> 
                            <div class="nipl_input_div">
                                <input type="email" name="username" class="form-control" id="smtp_username" placeholder="demo@example.com" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="password" name="password" class="form-control" id="smtp_password" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Port <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="port" class="form-control" id="smtp_port" placeholder="465" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Host <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <input type="text" name="host" class="form-control" id="smtp_host" placeholder="ssl://smtp.gmail.com" value="">
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="control-label">SMTP <span class="required"> * </span> </label>
                            <div class="nipl_input_div">
                                <div class="radio-list">
                                    <label class="radio-inline">
                                        <span><input type="radio" name="smtp_type" id="smtp_yes" value="Yes"></span> Yes                            </label>
                                    <label class="radio-inline">
                                        <span><input type="radio" name="smtp_type" id="smtp_no" value="No"></span> No                            </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <input type="submit" class="btn green" id="save" name="Save_Changes" value="Save Changes" >
            </div>
        </div>
    </form>
    <!-- /.modal-content -->
</div> 
<!-- /.modal-dialog -->
</div>
<!-- /Add email configuration modal -->

<script type="text/javascript">
    jQuery(document).ready(function() {
        
        jQuery(function () {
            jQuery('#datatable').dataTable({
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('emailconfiguration/emailjson'); ?>",
                "columnDefs": [{
                        'orderable': false,
                        'targets': [0, 7]
                    }, {
                        "searchable": false,
                        "targets": [0, 7]
                    }],
                "order": [
                    [3, "DESC"]
                ]
            });
        });
        
        jQuery('.email-configuration-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                username: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
                port: {
                    required: true,
                },
                host: {
                    required: true,
                }
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
        jQuery('.smtp-configuration-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                username: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
                port: {
                    required: true,
                },
                host: {
                    required: true,
                }
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
        
        $(document).on("click", ".delete_configuration", function () {
            var config_id = $(this).data("custom-value");
            swal({
                title: "Are you sure?",
                text: "You want to delete this configuration ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true,
                html: false
            }, function () {
                $.ajax({
                    method: "POST",
                    url: '<?php echo base_url('emailconfiguration/delete_configuration') ?>',
                    data: {id: config_id},
                    success: function (data) {
                        swal("success", data, "success");
                        location.reload();
                    }
                });
            });
        });
        
        $(document).on("click", ".edit_configuration", function () {
            var config_id = $(this).data("custom-value");
            
            $.ajax({
                method: "POST",
                url: '<?php echo base_url('emailconfiguration/edit_configuration') ?>',
                data: {id: config_id},
                success: function (data) {
                    var edata = $.parseJSON(data);
                    if(edata.data.config_type ===  'SMTP'){
                        $('#smtp_config_id').val(edata.data.configuration_id);
                        $('#smtp_username').val(edata.data.username);
                        $('#smtp_port').val(edata.data.port);
                        $('#smtp_host').val(edata.data.host);
                        if(edata.data.smtp_type === 'Yes'){
                            $("#smtp_yes").prop( "checked", true );
                            $( "#smtp_yes" ).parent().addClass('checked');
                        }else{
                            $("#smtp_no").prop( "checked", true );
                            $("#smtp_no").parent().addClass('checked');
                        }
                        $('#add-configuration-smtp').modal('show');
                    } else {
                        $('#config_id').val(edata.data.configuration_id);
                        $('#username').val(edata.data.username);
                        $('#port').val(edata.data.port);
                        $('#host').val(edata.data.host);
                        if(edata.data.ssl_type === 'Yes'){
                            $("#ssl_yes").prop( "checked", true );
                            $( "#ssl_yes" ).parent().addClass('checked');
                        }else{
                            $("#ssl_no").prop( "checked", true );
                            $("#ssl_no").parent().addClass('checked');
                        }
                        $('#add-configuration-email').modal('show');
                    }
                }
            });
        });
        
    });
    
    jQuery(".com-form").submit(function(event) {
        event.preventDefault();
            if (jQuery('.email-configuration-form').valid() || jQuery('.smtp-configuration-form').valid()) {
                if(jQuery('.email-configuration-form').valid()){
                    var frmarr = jQuery(".email-configuration-form").serialize();
                    save(frmarr);
                } else {
                    var frmarr = jQuery(".smtp-configuration-form").serialize();
                    save(frmarr);
                }
            }
        
    });
    
    function save(frmarr){
        $.ajax({
            method: "POST",
            url: '<?php echo  base_url('emailconfiguration/SaveConfiguration') ?>',
            data: frmarr,
            success: function (data) {
                $('#add-configuration-email').modal('hide');
                $('#add-configuration-smtp').modal('hide');
                $(".smtp-configuration-form").trigger('reset');
                $(".email-configuration-form").trigger('reset');
                if(data == 'Configuration saved successfully'){
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                    swal("success", data, "success");
                } else {
                    swal("error", data, "error");
                }
            }
        });   
    }
</script>