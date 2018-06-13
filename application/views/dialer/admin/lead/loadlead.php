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
            <a class="btn btn-info" href="<?php echo site_url() ?>uploads/sample.csv">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo 'Doanload Sample CSV File' ?></span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <form name="leadForm" id="leadForm" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Load Leads Fron this file' ?><span class="required"> * </span></label>
                    <div class="col-md-4">
                        <input name="lead_file" type="file" class="form-control" style="border: none;height: auto;"/>
                    </div>
                </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo 'Agency' ?> <span class="required"> * </span></label>
                        <div class="col-md-4">
                            <?php  $tree = buildTree($agencies,0); ?>
                            <select name="agency_id" class="form-control" class="agency_id" onchange="javascript:selectList(this.value)">
                                <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTree($tree,0, null, $alead->agency_id ); ?>
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
        jQuery('#leadForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                leadFile : "required",
                agency_id : "required",
                list_id : "required",
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });
    });
</script>