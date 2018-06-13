 <div class="modal-body">
     <form method="post" id="smsForm" enctype="multipart/form-data" class="form-horizontal" action="" onsubmit="sendSms(event)">
         <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
             <h4 class="modal-title"><?php echo 'SMS' ?></h4>
         </div>
         <div class="modal-body">
             <div class="form-group form-group-md">
                 <div class="col-md-12">
                     <?php
                     if ($this->session->userdata('user')->group_name == 'Agent') {
                         $name = $this->session->userdata('agent')->fname . ' ' . $this->session->userdata('agent')->lname;
                     }

                     if ($this->session->userdata('user')->group_name == 'Agency') {
                         $name = $this->session->userdata('agency')->name;
                     }
                     ?>
                     <div class="form-group">
                         <label class="col-md-3 control-label"><?php echo 'From Name' ?></label>
                         <div class="col-md-8">
                             <input type="text" name="from_name" class="form-control" value="<?php echo $name; ?>"/>
                         </div>
                     </div>
                     <div class="form-group">
                         <label class="col-md-3 control-label"><?php echo 'SMS Text' ?></label>
                         <div class="col-md-8">
                             <textarea class="smstext form-control sms-input" id="smstext" name="smstext" rows="5" maxlength="12"> </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn blue"><?php echo 'Send' ?></button>
        </div>
    </form>
</div>
<script type="text/javascript">
    function sendSms(event) {
        event.stopPropagation();
        event.preventDefault();
        jQuery('#loading').modal('show');
        var leadIds = '<?php echo $leadIds; ?>'
        var to = '<?php echo $phoneNumbers; ?>';
        var reload = '<?php echo $reload; ?>'
        var text = jQuery('#smstext').val();
        jQuery.ajax({
            url: '<?php echo site_url('lead/smspost/') ?>',
            method: 'post',
            data: {to: to, leadIds: leadIds, smstext: text},
            success: function (result) {
                jQuery('.message').html(result.html);
                jQuery('#smsbox').modal("hide");
                jQuery('#loading').modal('hide');
                if (result === 'sms_limt') {
                    toastr.error("You Can't Send More Then 200 SMS Per Day", "SMS LIMIT OVER");
                } else {
                    toastr.info(result, "SMS");
                    if (reload === 'true') {
                        location.reload();
                    }
                }
            }
        });
    }
</script>