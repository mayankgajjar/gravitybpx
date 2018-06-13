<div class="portlet-body">
    <input type="hidden" id="uid" value="<?php echo $uid; ?>" />
        <div class="inbox-header inbox-view-header">
            <h1 class="pull-left"><?php echo $data->Subject(); ?></h1>
            <div class="pull-right">
                <span class="btn btn-icon-only dark btn-outline delete-mail"><i class="fa fa-trash-o" title="Delete Mail"></i></span>
    </div>
        </div>
        <div class="inbox-view-info">
            <div class="row">
                <div class="col-md-7">
                    <span class="sbold"><?php echo $data->From()->ForeachList('fromname'); ?> </span>
                    <span> &#60; <?php echo $data->From()->ForeachList('fromemail'); ?> &#62;</span> to
                    <span class="sbold"> me </span> <?php echo substr($data->HeaderDate(), 0, 25); ?> </div>
                <div class="col-md-5 inbox-info-btn">
                    <div class="btn-group">
                        <button class="btn green reply-btn replay-mail">
                            <i class="fa fa-reply"></i> Reply
                            <i class="fa fa-angle-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="inbox-view">
            <?php if($data->Attachments()): ?>
                <?php if($data->ContentType() != '' && $data->ContentType() == 'multipart/mixed'): ?>
                    <?php if($data->InReplyTo() != ''): ?>
                        <iframe style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" id="email-html" src="<?php echo site_url('email/html').'?uid='.$uid.'&folder='.urlencode($folder) ?>" onload="AdjustIframeHeightOnLoad()"></iframe>
                    <?php else: ?>
                        <pre><?php echo $data->Plain(); ?></pre>
                    <?php endif; ?>
                <?php else: ?>
                    <iframe style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" id="email-html" src="<?php echo site_url('email/html').'?uid='.$uid.'&folder='.urlencode($folder) ?>" onload="AdjustIframeHeightOnLoad()"></iframe>
                <?php endif; ?>
            <?php else: ?>
                <?php if($data->ContentType() != '' && $data->ContentType() == 'text/plain'): ?>
                    <pre><?php echo $data->Plain(); ?></pre>
                <?php else: ?>
                    <iframe style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" id="email-html" src="<?php echo site_url('email/html').'?uid='.$uid.'&folder='.urlencode($folder) ?>" onload="AdjustIframeHeightOnLoad()"></iframe>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php if($data->Attachments()): ?>
        <hr>
            <div class="inbox-attached">
                <?php foreach($atachments as $atach) : ?>
                <span data-custom-value="<?php echo $atach->FileName(); ?>">
                    <div class="col-sm-2 attach-file">
                        <div class="attached-sextion"><div class="attach-img"><img src="<?php echo site_url('assets/images/attach.png'); ?>" alt="attachments" style="height: 85px;"></div>
                            <span class="filename"><strong><?php echo $atach->FileName(); ?></strong></span>
                        </div>
                        <div class="attached-section-hover"><div class="attach-img"></div>
                           <strong><i class="fa fa-file" aria-hidden="true"></i><?php echo $atach->FileName(); ?></strong>
                           <div class="download" onclick="attach('<?php echo $uid ?>','<?php echo $atach->FileName() ?>')"><i class="fa fa-download" aria-hidden="true"></i></div>

                        </div>
                    </div>
                </span>
    <!--                <a href="javascript:;" onclick="attach('<?php echo $uid ?>','<?php echo $atach->FileName() ?>')"><?php echo $atach->FileName(); ?></a>-->
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

</div>
<script>
function AdjustIframeHeightOnLoad() {
        document.getElementById("email-html").style.height = document.getElementById("email-html").contentWindow.document.body.scrollHeight + "px";
        //document.getElementById("email-html").style.width = jQuery('.inbox-view').width() + "px";
    }
function AdjustIframeHeight(i) { document.getElementById("email-html").style.height = parseInt(i) + "px"; }
$( document ).ready(function() {

    $(document).on("click",".delete-mail",function() {
        swal({
            title: "Are you sure?",
            text: "Are you sure you want to delete email?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, Delete it!",
            closeOnConfirm: true,
            html: false
        }, function () {
           $('#loading').modal('show');
            var uid = $('#uid').val();
            $.ajax({
                url: '<?php echo site_url('email/deleteEmail') ?>',
                method: 'POST',
                data: {id: uid},
                success: function (data) {
                    $('#loading').modal('hide');
                    window.location.replace('<?php echo site_url('email/inbox') ?>');
                }
            });
        });
    });

    $(document).on("click",".attach-file",function() {
        var uid = $('#uid').val();
        var file_name = $(this).text();
        $.ajax({
            url: '<?php echo site_url('email/download_attachment') ?>',
            method: 'POST',
            data: {id: uid, filename: file_name},
                success: function (data) {
                    console.log(data);
                }
            });
    });
});
function attach(uId, fileName){
    var str = "?is_ajax=true&id="+uId+"&filename="+fileName+"&folder="+MyAgentViewModel.oMailBoxActual();
    console.log('<?php echo site_url('email/attachment') ?>'+str);
    location.href = '<?php echo site_url('email/attachment') ?>'+str;

}
</script>
