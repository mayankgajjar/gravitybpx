<!-- Popup Model -->                          
<div id="add-fund" class="modal fade" tabindex="-1" data-width="380">
    <form method="post" action="<?php echo site_url('billing/addfund') ?>" id="addfundForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Fund To You Balance</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="message-fund">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Amount to Add: "; ?>&nbsp;&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i></span>                        
                                    <input type="text" name="amount" class="form-control" value="<?php echo 25.00; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Pay With: "; ?>&nbsp;&nbsp;</label>                                
                                <?php
                                $agent = $this->agents->get($this->session->userdata('agent')->id);
                                $result = $this->stripe->customer_list_cards($agent->stripe_client_id, 100);
                                $resultDecode = json_decode($result);                               
                                $cards = $resultDecode->data;
                                ?>                    
                                <select name="method" class="form-control">
                                    <?php if (count($cards) > 0): ?>
                                        <?php foreach ($cards as $card): ?>                        
                                            <option value="<?php echo encode_url($card->id); ?>"><?php echo $card->name . ' - ' . $card->brand ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p style="border: 1px solid #808080; font-size: 13px; padding: 10px;">By clicking the "Add Funds" button below, your selected credit card will be charged for the amount you enter under "Amount to Add" and your account will be funded with that amount. You will not actually be charged for any leads until you activate a campaign, and you will never pay more for a lead than the "Maximum Bid" you set in your campaign. If you have any questions, please contact your account manager, whose contact information is listed on the right side of your screen.</p>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                    <button type="submit" id="btn-submit"  class="btn green">Save changes</button>
                </div>
            </div>
        </div>
    </form>                                        
</div>
<script type="text/javascript">
    jQuery(function () {
        //jQuery('[name="amount"]').inputmask("currency",{ "clearIncomplete": true });
        jQuery("#addfundForm").validate({
            rules: {
                amount: {
                    required: !0
                },
                method: {
                    required: !0
                }
            },
        });
    });
    jQuery(document).on('submit', '#addfundForm', function (event) {
        event.preventDefault();
        jQuery('.loader').show();
        jQuery('#btn-submit').hide();
        var postData = jQuery(this).serialize();
        jQuery.ajax({
            method: 'POST',
            url: jQuery(this).attr('action'),
            dataType: 'json',
            data: postData,
            success: function (result) {
                jQuery('.loader').hide();
                jQuery('#btn-submit').show();
                var flag = Boolean(result.success);
                if (flag == true) {
                    var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>';
                    location.reload();
                } else {
                    var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' + result.message + '</div>';
                }
                jQuery('.message-fund').html(msg)
            },
        });
    });
</script>
<!-- Popup Model -->
