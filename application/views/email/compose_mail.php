<form class="inbox-compose form-horizontal" id="fileupload" action="<?php echo site_url('email/send_mail'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="uid" name="replay_uid" value="<?php echo (isset($uid)) && ($uid > 0) ? $uid : null; ?>" />
    <input type="hidden" id="setcc" id = "setcc" value="<?php echo (isset($uid)) && ($uid > 0) ? ($data->Cc()) && (sizeof($data->Cc()) > 0) ? $data->Cc()->ForeachList('fromemail'): '' : ''; ?>" />
    <input type="hidden" id="setbcc" id="setbcc" value="<?php echo (isset($uid)) && ($uid > 0) ? ($data->Bcc()) && (sizeof($data->Bcc()) > 0) ? $data->Bcc()->ForeachList('fromemail'): '': ''; ?>" />
    <?php if(isset($uid) && $uid > 0) { ?>
        <?php if($data->Attachments()): ?>
            <?php if($data->ContentType() != '' && $data->ContentType() == 'multipart/mixed'): ?>
                <?php if($data->InReplyTo() != ''): ?>
                    <?php echo $data->Html(); ?>
                <?php else: ?>
                    <pre><?php echo $data->Plain(); ?></pre>
                <?php endif; ?>
            <?php else: ?>
                <?php echo $data->Html(); ?>
            <?php endif; ?>
        <?php else: ?>
            <?php if($data->ContentType() != '' && $data->ContentType() == 'text/plain'): ?>
                <pre><?php echo $data->Plain(); ?></pre>
            <?php else: ?>
                <?php echo $data->Html(); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php } ?>
    <div class="inbox-compose-btn">
            <input type="submit" class="btn btn-primary" value="Send" name="Send">
            <!--<i class="fa fa-check"></i>Send</button> -->
            <button class="btn default inbox-discard-btn">Discard</button>
    </div>
    <div class="inbox-form-group mail-to">
        <label class="control-label">To:</label>
        <div class="controls controls-to">
            <input type="text" class="form-control" name="to_email" value="<?php echo (isset($uid)) && ($uid > 0) ?  ($data->From()) && (sizeof($data->From()) > 0) ? $data->From()->ForeachList('fromemail'): '' : null; ?>">
            <span class="inbox-cc-bcc">
                <span class="inbox-cc"> Cc </span>
                <span class="inbox-bcc"> Bcc </span>
            </span>
        </div>
    </div>
    <div class="inbox-form-group input-cc display-hide cc">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Cc:</label>
        <div class="controls controls-cc">
            <input type="text" name="cc_email" class="form-control" value = "<?php echo (isset($uid)) && ($uid > 0) ? ($data->Cc()) && (sizeof($data->Cc()) > 0) ? $data->Cc()->ForeachList('fromemail'): '' : ''; ?>"> </div>
    </div>
    <div class="inbox-form-group input-bcc display-hide bcc">
        <a href="javascript:;" class="close"> </a>
        <label class="control-label">Bcc:</label>
        <div class="controls controls-bcc">
            <input type="text" name="bcc_email" class="form-control" value = "<?php echo (isset($uid)) && ($uid > 0) ? ($data->Bcc()) && (sizeof($data->Bcc()) > 0) ? $data->Bcc()->ForeachList('fromemail'): '' : ''; ?>"> </div>
    </div>
    <div class="inbox-form-group">
        <label class="control-label">Subject:</label>
        <div class="controls">
            <input type="text" class="form-control" name="subject" value="<?php echo (isset($uid)) && ($uid > 0)  ? 'Re: '.$data->Subject() : null;?>"> </div>
    </div>
    <div class="inbox-form-group">
        <textarea class="inbox-editor inbox-wysihtml5 form-control" id="msg" name="message" rows="12"></textarea>
    </div>
    <div class="inbox-compose-attachment">
        <!-- The file upload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <span class="btn green btn-outline fileinput-button">
            <i class="fa fa-plus"></i>
            <span> Add files... </span>
            <input type="file" name="attachmentfile[]" multiple id="UploadFile"> </span>
       
    </div>
    <div id="filename">No File Selected.</div>
    <div class="inbox-compose-btn">
        <input type="submit" class="btn btn-primary" value="Send" name="Send">
        <button class="btn default">Discard</button>
    </div>
</form>
<script>
$( document ).ready(function() {
    $('#msg').wysihtml5();
    
    var cc = $('#setcc').val();
    if(cc != ''){
        $('.cc').css("display","block");
        $('span.inbox-cc').css("display","none");
    } 
    
    var bcc = $('#setbcc').val();
    if(bcc != ''){
        $('.bcc').css("display","block");
        $('span.inbox-bcc').css("display","none");
    }
});
$(document).on("change","#UploadFile",function() {
    var str = '';
    for (var i = 0; i < this.files.length; i++)
    {
        str = str + this.files[i].name+ ', ';
    }
    $('#filename').html(str);
});
</script>
