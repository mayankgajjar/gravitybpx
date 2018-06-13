<div class="breadcrumbs lead">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'Leads' ?>
        </li>
    </ol>
</div>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
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
        <!-- <div class="actions">
            <a class="btn btn-info" href="<?php echo site_url() ?>uploads/sample-agent.csv">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo 'Download Sample CSV File' ?></span>
            </a>
        </div> -->
    </div>
    <div class="portlet-body">
        <form action="<?=base_url('leadimport/csv_mapping')?>" name="leadForm" id="leadForm" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <input type="hidden" name="status" value="<?php echo $status ?>" />
                <?php foreach($fields as $k=>$field) :?>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?=$field?>
                        <?php if($k == 'first_name' || $k == 'last_name' || $k == 'phone' ) :?>
                        <span class="required">*</span>
                        <?php endif; ?>
                        </label>
                        <div class="col-md-4">
                            <select name="fields[<?=$k?>]" class="form-control">
                                <option value="">Select Field</option>
                                <?php if(isset($lead_header) && count($lead_header) > 0) :?>
                                    <?php foreach($lead_header as $key=>$title) :?>    
                                        <option value="<?=$key?>"><?=$title?></option>
                                    <?php endforeach; ?>
                                <?php endif;?>    
                            </select>    
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" name="submit" value="Submit" class="btn blue">
                    </div>
                </div>
            </div>
        </form>

        <h4>Import Lead Instructions</h4>
        <ul>
            <li>
                <p class="text-danger">In CSV file "first_name", "last_name" and "phone" are required fields.</p>
            </li>
            <li>
                <p class="text-danger">If you want to edit any lead record then just include valid lead "member_id" number in CSV file.</p>
            </li>
            <li>
                <p class="text-danger">For "gender" field use "M" - Male and "F" for Female. </p>
            </li>
            <li>
                <p class="text-danger">For "date_of_birth" field use "mm/dd/yyyy" format. </p>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#crm').addClass('open active');
        jQuery('#lead').addClass('open');
        jQuery('#<?php  echo lcfirst($status) ?>').addClass('active');
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                'fields[first_name]' : "required",
                'fields[last_name]' : "required",
                'fields[phone]' : "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>