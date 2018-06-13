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
        <div class="caption">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase"><?php echo $title; ?></span>
        </div>
    </div>
    <div class="portlet-body form">
        <form class="form-horizontal" id="commentForm" method="post">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Vertical Name"; ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" id="cat_name" name="cat_name" value="<?php echo $vertical->cat_name; ?>"/>
                    </div>
                </div>
                <input type="hidden" name="cat_slug" id="cat_slug" value="<?php echo $vertical->cat_slug; ?>"/>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Supported Auction"; ?></label>
                    <div class="col-md-4">
                        <?php $auct_type = array(AUCTION_TYPE_DATA => 'Data', AUCTION_TYPE_LIVE_TRANSFER => 'Live Transfer'); ?>
                        <?php $supportedAuction = explode(',', $vertical->auctions) ?>
                        <select class="form-control" name="auctions[]" multiple="multiple">
                            <?php foreach ($auct_type as $key => $val): ?>
                                <option value="<?php echo $key ?>" <?php echo in_array($key, $supportedAuction) ? 'selected="selected"' : '' ?>><?php echo $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Supported Bid Type"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="bid[]" multiple="multiple">
                            <?php $supportesBid = explode(',', $vertical->bid) ?>
                            <?php foreach ($bids as $key => $bid): ?>
                                <option value="<?php echo $bid->lead_bid_id ?>" <?php echo in_array($bid->lead_bid_id, $supportesBid) ? 'selected="selected"' : '' ?>><?php echo $bid->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Status"; ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select class="form-control" name="active">
                            <option value=""><?php echo "Please Select"; ?></option>
                            <option value="1" <?php echo $vertical->active == '1' ? 'selected="selected"' : '' ?>><?php echo "Enable"; ?></option>
                            <option value="0" <?php echo $vertical->active == '0' ? 'selected="selected"' : '' ?>><?php echo "Disable"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Condition Popup"; ?></label>
                    <div class="col-md-4">
                        <select class="form-control" name="is_condition" onChange="javascript:selectPopup(this.value)">
                            <option value=""><?php echo "Please Select"; ?></option>
                            <option value="1" <?php echo $vertical->is_condition == '1' ? 'selected="selected"' : '' ?>><?php echo "Enable"; ?></option>
                            <option value="0" <?php echo $vertical->is_condition == '0' ? 'selected="selected"' : '' ?>><?php echo "Disable"; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Choose Filters"; ?></label>
                    <div class="col-md-9">                        
                        <?php $filters = unserialize(FILTER_GROUPS) ?>
                        <?php $key1 = key($filters); ?>
                        <?php $precision = $this->filter_m->get_by(array('filter_group' => $key1)); ?>
                        <?php unset($filters['precision']) ?>
                        <?php $affordibility = $this->filter_m->get_by(array('filter_group' => key($filters))) ?>
                        <div class="col-md-3">
                            <?php
                            $data = array($key1 => array(), key($filters) => array());
                            if ($vertical->filters != '' || $vertical->filters != 'NULL') {
                                $data = unserialize($vertical->filters);
                            }
                            ?>
                            
                            <?php if(isset($precision) && count($precision) > 0): ?>                                
                                <?php foreach ($precision as $prec): ?>
                                    <label><input type="checkbox" name="filters[<?php echo $key1 ?>][]" value="<?php echo $prec->filter_id; ?>" <?php echo @in_array($prec->filter_id, $data[$key1]) ? 'checked="checked"' : ''; ?> /><?php echo $prec->name; ?></label>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">                            
                            <?php foreach ($affordibility as $prec): ?>
                                <label><input type="checkbox" name="filters[<?php echo key($filters) ?>][]" value="<?php echo $prec->filter_id; ?>" <?php echo @in_array($prec->filter_id, $data[key($filters)]) ? 'checked="checked"' : ''; ?> /><?php echo $prec->filter_label; ?><span><?php ?></span></label>
                            <?php endforeach; ?>
                        </div>
                         
                    </div>
                </div>
                <div class="form-group" id="popup" style="display:none">
                    <label class="col-md-3 control-label"><?php echo "Popup Text"; ?></label>
                    <div class="col-md-4">
                        <textarea class="form-control" name="condition_text"><?php echo $vertical->condition_text; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn green" type="submit">Submit</button>
                        <button class="btn default" type="button" onClick="location.href = '<?php echo site_url('adm/vertical/index'); ?>'">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    /*----- For Generate a slug ------*/
    $("#cat_name").blur(function () {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
        $("#cat_slug").val(Text);
    });
    /*----- End For Generate a slug ------*/
    jQuery(function () {
        jQuery('#bid').addClass('active');
        jQuery('.campaign-type').addClass('active');
        jQuery("#commentForm").validate({
            rules: {
                cat_name: "required",
                active: "required",
            },
            messages: {
                cat_name: "Please enter vertical name.",
                active: "Please select one options.",
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            invalidHandler: function (event, validator) { //display error alert on form submit
                //success1.hide();
                //error1.show();
                //App.scrollTo(error1, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
            }
        });
        selectPopup(<?php echo $vertical->is_condition; ?>);
    });
    function selectPopup(value)
    {
        if (value == 1) {
            jQuery('#popup').show();
        } else {
            jQuery('#popup').hide();
        }
    }
</script>