<form class="form-horizontal" method="post" id="productForm" onsubmit="productFormSubmit(event)">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo 'Products' ?></h4>
    </div>
    <div class="modal-body">
        <div class="msgprodform"></div>
        <input type="hidden" name="lead_id" value="<?php echo encode_url($leadId) ?>"/>
        <input type="hidden" name="lead_product_id" value="<?php echo $leadProduct->lead_product_id > 0 ? encode_url($leadProduct->lead_product_id) : ''; ?>" />
        <div class="form-group form-group-md">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Coverage Type' ?></label>
                    <div class="col-md-8">
                        <select class="form-control" name="coverage_type">
                            <option value=""><?php echo 'Coverage Type' ?></option>
                            <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category->id ?>" <?php echo optionSetValue($category->id, $leadProduct->coverage_type) ?>><?php echo $category->category_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Carrier' ?></label>
                    <div class="col-md-8">
                        <select class="form-control" name="carriers">
                            <option value=""><?php echo 'Filter' ?></option>
                            <?php foreach($companies as $comapny): ?>
                            <option value="<?php echo $comapny['id'] ?>" <?php echo optionSetValue($comapny['id'], $leadProduct->carriers) ?>><?php echo $comapny['company_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Premium' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="premium" value="<?php echo $leadProduct->premium ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Enrollment Fee' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="enrollment_fee" value="<?php echo $leadProduct->enrollment_fee ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Plan Type' ?></label>
                    <div class="col-md-8">
                        <select class="form-control" name="plan_type">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <option value="Single" <?php echo optionSetValue('Single', $leadProduct->plan_type) ?>><?php echo 'Single' ?></option>
                            <option value="Single+Spouse" <?php echo optionSetValue('Single+Spouse', $leadProduct->plan_type) ?>><?php echo 'Single+Spouse' ?></option>
                            <option value="Single+Child" <?php echo optionSetValue('Single+Child', $leadProduct->plan_type) ?>><?php echo 'Single+Child' ?></option>
                            <option value="Family" <?php echo optionSetValue('Family', $leadProduct->plan_type) ?>><?php echo 'Family' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Policy Length' ?></label>
                    <div class="col-md-8">
                        <select class="form-control" name="policy_length">
                            <option value=""><?php echo 'Please Select' ?></option>
                            <option value="6 months" <?php echo optionSetValue('6 months', $leadProduct->policy_length) ?>><?php echo  '6 months' ?></option>
                            <option value="364 days" <?php echo optionSetValue('364 days', $leadProduct->policy_length) ?>><?php echo  '364 days' ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Policy No' ?></label>
                    <div class="col-md-8">
                        <input type="text" name="product_policy_no" class="form-control" value="<?php echo $leadProduct->product_policy_no    ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Coinsurance' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="coinsurance" value="<?php echo $leadProduct->coinsurance ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Co-Pays' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="co_pays" value="<?php echo $leadProduct->co_pays ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Specialist Co-Pays' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="specialist_co_pays" value="<?php echo $leadProduct->specialist_co_pays ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Deductible Amount' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="deductible_amount" value="<?php echo $leadProduct->deductible_amount ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Max out of Pocket' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="max_out_pocket" value="<?php echo $leadProduct->max_out_pocket ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Max Benefits' ?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="max_benefits" value="<?php echo $leadProduct->max_benefits ?>"/>
                    </div>
                </div>
            </div>
            <div id="scroll" class="scroller" style="height:600px" data-always-visible="1" data-rail-visible1="1">
                <div class="col-md-12 products">
                    <?php echo $string; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue"><?php echo 'Save Product' ?></button>
    </div>
</form>
<script type="text/javascript">
        jQuery(document).ready(function(){
            reLoadScript();
            <?php if($leadProduct->lead_product_id > 0) : ?>
                setTimeout(function(){
                    $('#scroll').animate({
                        scrollTop: $('#check-<?php echo $leadProduct->product_id ?>').offset().top
                    }, 1000);
                },1000);
            <?php endif; ?>
        });
</script>