<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?php echo site_url('ven/lead/index'); ?>">Lead</a>
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
            <a class="btn btn-info" href="<?php echo site_url() ?>uploads/sample-raw-lead.csv">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo 'Download Sample CSV File' ?></span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <form action="<?=base_url('ven/lead/lead_bulk_upload')?>" name="leadForm" id="leadForm" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Lead Category<span class="required">*</span></label>
                    <div class="col-md-4">
                        <select name="category" class="form-control" id="category">
                            <option value="">Select Lead Category</option>
                            <option value="raw">Raw Lead</option>
                            <option value="aged">Aged Lead</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Insurance Category<span class="required">*</span></label>
                    <div class="col-md-4">
                        <select name="lead_category" class="form-control" id="lead_category">
                            <option value="">Select Insurance Category</option>
                            <option value="health">Health Insurance</option>
                            <option value="life">Life Insurance</option>
                            <option value="medicare">Medicare Supplement</option>
                        </select>    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Load Lead From this file" ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="file" name="lead_file" style="height: auto;" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <input class="btn blue" type="submit" name="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>

        <h4>Import Lead Instructions</h4>
        <ul>
            <li>
                <p class="text-danger">In csv file "First_name", "Last_name", "State", "City",  "Zip","Email" and "Phone" are required fields.</p>
            </li>
            <li>
                <p class="text-danger">For "State" field use "State Abbreviation", Like "TX, NY".</p>
            </li>
            <li>
                <p class="text-danger">For "Gender" field use "Male" and "Female". </p>
            </li>
            <li>
                <p class="text-danger">For "Date_Of_Birth" field us "dd/mm/yyyy" format. </p>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $('#leads').parents('li').addClass('open');
    $('#leads').siblings('.arrow').addClass('open');
    $('#leads').parents('li').addClass('active');
    $('#view_leads').parents('li').addClass('active');

    jQuery(function(){
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                category : "required",
                lead_category : "required",
                leadFile : "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>