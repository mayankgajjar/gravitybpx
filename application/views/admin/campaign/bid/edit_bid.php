<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo "Bid Type" ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title">Campaign Bid</h3>
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
<form name="bidForm" id="bidForm" class="form-horizontal" method="post">    
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
        </div>
    </div>
    <div class="portlet-body">        
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Name'  ?><span class="required">*</span></label>
                <div class="col-md-4">
                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $bid->name ?>" />
                </div>              
            </div>
            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Minimum Bid' ?><span class="required">*</span></label>
                <div class="col-md-4">
                    <input type="text" name="minbid" class="form-control" value="<?php echo $bid->minbid ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Description' ?></label>
                <div class="col-md-4">
                    <textarea class="form-control" name="descr"><?php echo $bid->descr ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Status' ?><span class="required">*</span></label>
                <div class="col-md-4">
                    <select name="active" class="form-control" id="active">
                        <option value="">Please Select</option>
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>    
                </div>
            </div>
        </div>  
    </div>
    
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
</div>
<script type="text/javascript">
    jQuery(function(){             
        jQuery('#active').val("<?php echo $bid->active ?>");
        jQuery(".bid-type").addClass('active');
        // jQuery('#leadstore').parent('a').parent('li').addClass('open');
        // jQuery('#<?php  echo lcfirst($status) ?>').parent('a').parent('li').parent('ul').show();
        // jQuery('#<?php  echo lcfirst($status) ?>').parent('a').parent('li').addClass('active');
        jQuery('#bidForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                name : {
                    required: true,                    
                },
                minbid :{
                    required: true
                },
                active :{
                    required: true
                },
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });        
    });
</script>