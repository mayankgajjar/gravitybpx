<form method="post" id="emailForm" enctype="multipart/form-data" class="form-horizontal" action="" onsubmit="sendMail(event)">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo 'Email' ?></h4>
    </div>
    <div class="modal-body">
        <div class="form-group form-group-md">
<!--            <input type="hidden" name="lead_id" value="<?php echo encode_url($leadId) ?>"/>-->
            <input type="hidden" name="to" value="<?= $send; ?>"/>
            <input type="hidden" name="bcc" value="<?= $bbc; ?>"/>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Email Subject Line' ?></label>
                    <div class="col-md-8">
                        <input type="text" name="subject" class="form-control" value=""/>
                    </div>
                </div>
                <?php
                if ($this->session->userdata('user')->group_name == 'Agent') {
                    $name = $this->session->userdata('agent')->fname . ' ' . $this->session->userdata('agent')->lname;
                }

                if ($this->session->userdata('user')->group_name == 'Agency') {
                    $name = $this->session->userdata('agency')->name;
                }
                ?>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'From Name' ?></label>
                    <div class="col-md-8">
                        <input type="text" name="from_name" class="form-control" value="<?php echo $name; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'From Email Address' ?></label>
                    <div class="col-md-8">
                        <input type="text" name="from_email" class="form-control" value="<?php echo $this->session->userdata('user')->email_id ?>"/>
                    </div>
                </div>
                <?php if ($files): ?>
                    <div class="form-group">
                        <label class="col-md-4 control-label"><?php echo 'Add following Attach Files' ?></label>
                        <div class="col-md-8">
                            <div class="">
                                <?php foreach ($files as $file): ?>
                                    <label class="checkbox-inline"><input type="checkbox" name="attachment[]" value="<?php echo $file->path ?>" /><?php echo $file->path ?></label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Attachments' ?></label>
                    <div class="col-md-8">
                        <div class="">
                            <input type="file" id="attachmentfile" name="attachmentfile[]" class="email-attachment" multiple>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <textarea class="ckeditor form-control" id="body" name="body">
                        </textarea>
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
<script type="text/javascript">
    CKEDITOR.replace('body');
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
        modal_this = this
        $(document).on('focusin.modal', function (e) {
            if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                    // add whatever conditions you need here:
                    &&
                    !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                modal_this.$element.focus()
            }
        })
    };
    function prepareUpload(event)
    {
        files = event.target.files;
    }
    function sendMail(event) {
        event.stopPropagation();
        event.preventDefault();
        jQuery('#loading').modal('show');
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var postdata = new FormData(jQuery('#emailForm')[0]);
        jQuery.ajax({
            url: '<?php echo site_url('lead/emailpost/' . encode_url($leadId)) ?>',
            method: 'post',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: postdata,
            success: function (result) {
                jQuery('.message').html(result.html);
                jQuery('#ajaxemail').modal("hide");
                jQuery('#loading').modal('hide');
            }
        });
    }
</script>
<style>
    .cke_dialog, .cke{z-index: 100010!important;}
</style>