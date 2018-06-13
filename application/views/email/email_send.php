<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url('assets/theam_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE HEADER-->   
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="<?php echo site_url(); ?>">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Email Send</span>
            </li>
        </ul>
        <div class="page-toolbar">           
        </div>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Email Send </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<?php
    $uniq_key = $this->session->userdata("user")->email_id."_agencyvue_encryptionagencyvue";                
    $token = sha1(uniqid($uniq_key,true));
?>
<div class="portlet light bordered">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-envelope-o font-dark"></i>
            <span class="caption-subject bold uppercase">Email Send</span>
        </div>        
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <?php 
            if($this->session->flashdata())
            {
                if($this->session->flashdata('error') != "")
                {
                ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php    
                }
                else
                {                    
                ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php
                }
            }
            if($this->session->flashdata('error_server_register_link'))
            {
                ?>                        
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span><?php echo $this->session->flashdata('error_server_register_link'); ?></span>
                </div>
                <?php
            }
        ?> 
        <form class="form-horizontal form-row-seperated" action="<?php echo site_url('email_send/email_send_function/add') ?>" name="send_email_form" method="post" id="send_email_form">
            <div class="tabbable-bordered">                               
                <div class="form-body">                    
                    <?php                                
                        /*if(!empty($notifications_setting_data))
                        {
                            $notifications_setting_result = unserialize($notifications_setting_data['theme_options_values']);
                            $id = $notifications_setting_data['id'];
                            $sales_agent_customer_submitted_notification = $notifications_setting_result['sales_agent_customer_submitted_notification'];
                            $verification_agent_customer_not_verified_notification = $notifications_setting_result['verification_agent_customer_not_verified_notification'];
                        }
                        else
                        {
                            $id = $notifications_setting_data['id'];
                            $sales_agent_customer_submitted_notification = "";
                            $verification_agent_customer_not_verified_notification = "";
                        }*/                                
                    ?>                            
                    <?php
                        $send_email_type = unserialize(REGISTER_TYPE);
                        $email_setting_data = get_option('email_setting');        
                        $email_setting_config = unserialize($email_setting_data);                        
                    ?>
                    <input type="hidden" name="token" value="<?php echo $token; ?>" />
                    <div class="select_type_of_send_email_to form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-3">Send Email Type
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">                             
                                <select name="select_send_email_type" class="select_send_email_type form-control">
                                    <option value="">Select Send Email Type</option>                                                                                                        
                                    <?php                                    
                                        if(!empty($send_email_type))
                                        {                                                    
                                            foreach ($send_email_type as $key => $value)
                                            {                                                
                                            ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                            <?php        
                                            }    
                                        }                                    
                                    ?>
                                </select>
                                <span class="help-block">Select send email type</span>
                            </div>                        
                        </div>
                    </div>
                    <div class="form-group parent_agency">
                        <label class="control-label col-md-3">Parent Agency
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <select name="parent_agency" id="" class="form-control">
                                <option value="">No Parent Agency</option>
                                <?php
                                    foreach ($agency as $value) 
                                    {
                                        ?>
                                        <option value="<?php echo $value['id'] ?>">
                                            <?php echo $value['name'] ?>
                                        </option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <span class="help-block">Select parent agency</span>
                        </div>
                    </div>
                    <div class="form-group agent_type">
                        <label class="control-label col-md-3">Agent Category
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <?php
                                $agent_type = unserialize(AGENT_TYPE);
                            ?>
                            <select name="agent_type" class="form-control">                                                        
                                <option value="">Select Agent Type</option>
                                <?php
                                    if(!empty($agent_type))
                                    {
                                        foreach ($agent_type as $key => $value)
                                        {
                                    ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php
                                        }                                                            
                                    }
                                ?>                                                                                                                 
                            </select>
                            <span class="help-block">Select agent type</span>
                        </div>
                    </div>                    
                    <?php /* <div class="form-group email_from">
                        <label class="control-label col-md-3">From
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email_from" placeholder="" value="<?php echo $email_setting_config['sender_email']; ?>"/>                                                        
                        </div>
                    </div> */ ?>
                    <div class="form-group email_to">
                        <label class="control-label col-md-3">To
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email_to" placeholder="" value=""/>                                                        
                        </div>
                    </div>
                    <div class="form-group email_subject">
                        <label class="control-label col-md-3">Subject
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email_subject" placeholder="" value=""/>                                                        
                        </div>
                    </div>
                    <div class="form-group email_body">
                        <label class="control-label col-md-3">Body
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-9">
                            <textarea class="ckeditor form-control" id="email_body" name="email_body" rows="6"></textarea>
                        </div>
                    </div>                   
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-9">
                            <div class="actions btn-set">                                                                    
                                <button type="reset" class="btn btn-secondary-outline">
                                    <i class="fa fa-reply"></i> Reset
                                </button>                                
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Send
                                </button>                                
                            </div>  
                        </div>
                    </div>                                                                                                                                                                                                                                                                 
                </div>                                                                                                                                                        
            </div>            
        </form>
    </div>    
</div>
<!-- END EXAMPLE TABLE PORTLET-->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo site_url('assets/theam_assets/global/plugins/ckeditor/ckeditor.js'); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->        
<script type="text/javascript">
    $('document').ready(function()
    {       
        $('#mail_send').parents('li').addClass('open');
        $('#mail_send').siblings('.arrow').addClass('open');
        $('#mail_send').parents('li').addClass('active');
        $('<span class="selected"></span>').insertAfter($('#mail_send'));
        $('#mail_send').parents('li').addClass('active');
        $('.parent_agency,.agent_type,.email_from,.email_to,.email_subject,.email_body').hide();        
        var send_url = "";
        var i = 0;
        var agency_id_encode = "";
        var agent_id_encode = "";
        var token = "<?php echo $token; ?>";
        $('.select_send_email_type').change(function()
        {                                             
            i = 0;
            if($(this).val() == "agency")
            {                                        
                CKEDITOR.instances['email_body'].setData();                
                $('.agent_type').hide();
                $('.parent_agency,.email_from,.email_to,.email_subject,.email_body').show();
                $('.email_subject [name="email_subject"]').val("New agency register link");                                
            }
            else if($(this).val() == "agent")
            {                            
                CKEDITOR.instances['email_body'].setData();               
                $('.agent_type').show();
                $('.parent_agency,.email_from,.email_to,.email_subject,.email_body').show();
                $('.email_subject [name="email_subject"]').val("New agent register link");                
            }
            else
            {
                $('.parent_agency,.agent_type,.email_from,.email_to,.email_subject,.email_body').hide();
                $('.btn.btn-secondary-outline').trigger("click");                                            
            }
        });
        
        $('[name="parent_agency"],[name="agent_type"]').change(function()
        {                                
            if($('[name="select_send_email_type"]').val() != "")
            {
                if($('[name="agent_type"]').val() == "")
                {                       
                    encode_value('agency',$('[name="parent_agency"]').val());                    
                    var params = "agency/"+agency_id_encode;
                    var send_url = "<?php echo site_url('login/index') ?>/"+params+"/token/"+token;                                                                                       
                    var remove_div = 'link'+i.toString();                    
                    if(i >= 1 && CKEDITOR.instances['email_body'].document.getById(remove_div) != null)
                    {                        
                        CKEDITOR.instances['email_body'].document.getById(remove_div).remove();                        
                        i--;
                    }                    
                    i++;                                        
                    CKEDITOR.instances['email_body'].insertHtml("<div id='link"+i+"' class='link'><h2>New agency register link:-</h2><a href="+send_url+">"+send_url+"</a></div>");
                }
                else
                {                   
                    if($('[name="agent_type"]').val() != "" && $('[name="parent_agency"]').val() != "")
                    {
                        encode_value('agency',$('[name="parent_agency"]').val());
                        encode_value('agent',$('[name="agent_type"]').val());
                        var params = "agency/"+agency_id_encode+"/agent/"+agent_id_encode;
                        var send_url = "<?php echo site_url('login/index') ?>/"+params+"/token/"+token;
                        var remove_div = 'link'+i.toString();                    
                        if(i >= 1 && CKEDITOR.instances['email_body'].document.getById(remove_div) != null )
                        {                        
                            CKEDITOR.instances['email_body'].document.getById(remove_div).remove();
                            i--;
                        }                    
                        i++;                                        
                        CKEDITOR.instances['email_body'].insertHtml("<div id='link"+i+"' class='link'><h2>New agent register link:-</h2><a href="+send_url+">"+send_url+"</a></div>");
                    }                    
                }                
            }                        
        });
        
        $('.btn.btn-secondary-outline').click(function(){
            CKEDITOR.instances['email_body'].setData();
            $('.parent_agency,.agent_type,.email_from,.email_to,.email_subject,.email_body').hide();        
        });

        $("#send_email_form").validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            rules: {
                "select_send_email_type": {
                    required: true                            
                },
                "parent_agency": {
                    required: true                            
                },
                "agent_type": {
                    required: true                            
                },
                /*"email_from": {
                    required: true,
                    email: true                            
                },*/
                "email_to": {
                    required: true,
                    email: true
                },
                "email_subject": {
                    required: true
                },
                "email_body": {
                    required: true
                }
            },          
            invalidHandler: function(event, validator) 
            {             
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            unhighlight: function (element)
            {                 
                $(element).closest('.form-group').removeClass('has-error');             
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element)
            { 
               error.insertAfter(element); // for other inputs, just perform default behavior              
            },
            submitHandler: function(form) {
                success.show();
                error.hide();
                form.submit();
            }
        });
        function encode_value(type,value)
        {                                
            var url = "<?php echo site_url('email_send/encode_value') ?>"+'/'+value;
            $.ajax({
                url : url,
                method : 'get',
                async : false,
                success : function(str)
                {                                      
                    if(type == "agency")
                    {
                        agency_id_encode = str;
                    }
                    else
                    {
                        agent_id_encode = str;
                    }                    
                }
            });
        }        
        /*var session_type = "<?php echo $this->session->userdata('user')->group_name ?>";       
        if(session_type == "Agent")
        {
            $('[name="select_send_email_type"] option').each(function( index )
            {   
                if($(this).val() == session_type.toLowerCase())
                {
                    $(this).attr('selected','true');                    
                }
            });
            $('.parent_agency,.agent_type,.email_from,.email_to,.email_subject,.email_body').show();
            $('.select_type_of_send_email_to').hide();
            $('.email_subject [name="email_subject"]').val("New agent register link");
        }
        else if(session_type == "Agency")
        {
            $('[name="select_send_email_type"] option').each(function( index )
            {   
                if($(this).val() == session_type.toLowerCase())
                {
                    $(this).attr('selected','true');                    
                }
            });
            $('.parent_agency,.agent_type,.email_from,.email_to,.email_subject,.email_body').show();
            //$('.select_type_of_send_email_to').hide();
            $('.email_subject [name="email_subject"]').val("New agency register link");                
        }*/
    });
</script>  