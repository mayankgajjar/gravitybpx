<style>
.column{margin-bottom: 10px; }
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo "Campaign Filter" ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title">Campaign Filter</h3>
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
<form name="filterForm" id="filterForm" class="form-horizontal" method="post">    
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
                    <input type="text" name="name" placeholder="Name" class="form-control" value="<?php echo $filter->name ?>" />
                </div>              
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo "Group"; ?><span aria-required="true" class="required"> * </span></label>
                <div class="col-md-4">
                    <select name="filter_group" id="filter_group" class="form-control" onChange="javascript:changeOption(this.value)">
                        <option value="">Please Select</option>
                        <option value="precision">Precision Targeting</option>
                        <option value="affordability">Affordability Filters</option>                           
                    </select>
                </div>
                <input type="hidden" name="filter_type" id="filter_type" value="<?php echo $filter->filter_type; ?>">
            </div>      

            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Label' ?><span class="required">*</span></label>
                <div class="col-md-4">
                    <textarea class="form-control" name="filter_label"><?php echo $filter->filter_label ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Value' ?><span class="required">*</span></label>
                <div class="col-md-4">
                   <input type="text" name="filter_value" placeholder="Value" class="form-control" value="<?php echo $filter->filter_value ?>" />
                </div>
            </div>
           <div class="form-group">
                <label class="col-md-3  control-label"><?php echo 'Note' ?></label>
                <div class="col-md-4">
                    <textarea class="form-control" name="note"><?php echo $filter->note ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label"><?php echo "Options"; ?></label>
                <?php
                    $options = @unserialize($filter->options);                                              
                ?>
                <?php 
                    $i = 1;
                ?>
                <div class="col-md-6 options">
                    <?php if( count($options) >  1 ) : ?>                   
                        <?php foreach($options as $key => $val): ?>
                            <div class="row column" id="colom-<?php echo $i ?>">  
                                <div class="col-md-3"><input type="text" class="form-control" name="options[name][]" value="<?php echo $val['name'] ?>" placeholder="name" /></div>                     
                                <div class="col-md-3"><input type="text" class="form-control" name="options[label][]" value="<?php echo $val['label'] ?>" placeholder="Label" /></div>
                                <div class="col-md-3"><input type="text" class="form-control" name="options[value][]" value="<?php echo $val['value'] ?>" placeholder="value" /></div>
                                <div class="col-md-2"><button class="btn green" type="button" onClick="javascript:removeColom(this)" data-id="<?php echo $i; ?>">Remove</button></div>
                            </div>
                            <?php $i++; ?>                       
                        <?php endforeach; ?>
                    <?php endif; ?>        
                    <div class="row column">  
                        <div class="col-md-3"><input type="text" class="form-control" name="options[name][]" value="" placeholder="Name" /></div>                       
                        <div class="col-md-3"><input type="text" class="form-control" name="options[label][]" value="" placeholder="Label" /></div>
                        <div class="col-md-3"><input type="text" class="form-control" name="options[value][]" value="" placeholder="value" /></div>
                        <div class="col-md-2"><button class="btn green" type="button" onClick="javascript:addColom()">Add New</button></div>
                    </div>   
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
        jQuery('#filter_group').val("<?php echo $filter->filter_group ?>");           
        jQuery('#bid').addClass('active');
        jQuery('.campaign-filters').addClass('active');
        jQuery('#filter').removeClass('active'); 
        jQuery('#filterForm').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                name : {
                    required: true,                    
                },
                filter_group :{
                    required: true
                },
                filter_label :{
                    required: true
                },
                filter_value :{
                    required: true
                },
            },
            highlight: function (element) { // hightlight error inputs
                 $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
        });        
    });

function changeOption(option){  
    jQuery('#type').find('option').hide();  
    if( option === 'precision'){
        $("#filter_type").val('checkbox');
    }else if( option === 'affordability'){
        $("#filter_type").val('radio');
    }
}

var counter = <?php echo $i ?>;
function addColom(){    
    var str = '<div id="colom-'+counter+'" class="row column"><div class="col-md-3"><input type="text" class="form-control" name="options[name][]" value="" placeholder="Name" /></div><div class="col-md-3"><input type="text" class="form-control" name="options[label][]" value="" placeholder="Label" /></div> <div class="col-md-3"><input type="text" class="form-control" name="options[value][]" value="" placeholder="value" /></div><div class="col-md-2"><button class="btn green" type="button" data-id="'+counter+'" onClick="javascript:removeColom(this)">Remove</button></div></div>';
    jQuery('.options').prepend(str);
    counter++;
}
function removeColom(element){
    $id = jQuery(element).attr('data-id');  
    jQuery('#colom-'+$id).remove();
    counter--;
}
</script>