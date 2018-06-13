<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $maintitle; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $maintitle; ?> </h3>
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
        <div class="actions">
            <a class="btn btn-info" href="<?php echo site_url() ?>uploads/sample-agency.csv">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo 'Download Sample CSV File' ?></span>
            </a>            
        </div>
    </div>
    <div class="portlet-body">
        <form name="leadForm" id="leadForm" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <input type="hidden" name="status" value="<?php echo $status ?>" />
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Load {$status} Fron this file" ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="file" name="lead_file" style="height: auto;" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit' ?></button>
                    </div>
                </div>
            </div>
        </form>
        
        <h4>Import Lead Instructions</h4>
        <ul>
            <li>
                <p class="text-danger">In csv file "first_name", "last_name" and "phone" are required fields.</p>
            </li>
            <li>
                <p class="text-danger">To assign agent from CSV, add the column name "agent" with his email address. And from this It will automatically take agency also.</p>
                <p class="text-danger">If you don't want to assign agent then leave agent column blank and assign Agency email address to agency column.</p>
                <p class="text-danger">If you not assign agency It will take automatically current logged in agency.</p>
            </li>                        
            <li>
                <p class="text-danger">If you want to edit any lead record then just include valid lead "member_id" number in CSV file.</p>
            </li>
            <li>
                <p class="text-danger">For "gender" field us "M" - Male and "F" for Female. </p>
            </li>
            <li>
                <p class="text-danger">For "date_of_birth" field us "mm/dd/yyyy" format. </p>
            </li>            
        </ul>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){        
        jQuery('#leadstore').parent('a').parent('li').addClass('open');
        jQuery('#lead').parent('a').parent('li').parent('ul').show();
        jQuery('#<?php echo lcfirst($status) ?>').parent('a').parent('li').addClass('active');
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                leadFile : "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });                
    });
</script>