<style>
    .filename{
        text-align: center;
    }
    .inbox-attached .attach-file {
        border: 1px solid #ddd;
        padding: 20px;
        margin-right: 15px;
            position: relative;
    }
    .inbox-attached .attach-file .attach-img {
        display: block;
        text-align: center;
    }
    .attached-section-hover {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 20px;
        display: none;
        background: rgba(246, 246, 246, 0.9);
    }
    .inbox-attached .attach-file:hover .attached-section-hover{
        display: block;
        transition: all .4s;
    }
    .inbox-attached .attach-file .download{
        position: absolute;
        bottom: 15px;
        font-size: 20px;
        right: 15px;
    }
    .inbox-attached .attach-file .download i {
        background: #2f373e;
        height: 34px;
        width: 34px;
        line-height: 36px;
        text-align: center;
        color: #fff;
        font-size: 20px;
        border-radius: 50%;
    }
    .inbox-attached .attached-section-hover strong i{
        padding-right: 10px;
        color: #838383;
        vertical-align: middle;
    }
</style>
<div class="portlet-body">
    <input type="hidden" id="uid" value="<?php echo $uid; ?>" />
        <div class="inbox-header inbox-view-header">
            <h1 class="pull-left"><?php echo $data['subject']; ?></h1>
            <div class="pull-right">
                <span class="btn btn-icon-only dark btn-outline delete-send-mail"><i class="fa fa-trash-o" title="Delete Mail"></i></span>
            </div>
        </div>
        <div class="inbox-view-info">
            <div class="row">
                <div class="col-md-7">
                    <span class="sbold"><?php echo $data['to_email']; ?> </span> On
                    <span class="sbold">  </span> <?php echo $data['created']; ?> </div>
                <div class="col-md-5 inbox-info-btn">
                    <!--<div class="btn-group">
                        <button class="btn green reply-btn replay-mail">
                            <i class="fa fa-reply"></i> Reply
                            <i class="fa fa-angle-down"></i>
                        </button>
                    
                    </div> -->
                </div>
            </div>
        </div>
        <div class="inbox-view">
            <?php echo unserialize($data['massage_body']); ?>
        </div>
       
</div>
<script>
$( document ).ready(function() {
    $(document).on("click",".delete-send-mail",function() {
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
                url: '<?php echo site_url('email/deletesendEmail') ?>',
                method: 'POST',
                data: {id: uid},
                success: function (data) {
                    $('#loading').modal('hide');
                    window.location.replace('<?php echo site_url('email/inbox') ?>');
                }
            });
        });
    });
    
});
</script>
