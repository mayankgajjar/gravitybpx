<style>
    .msg-row{cursor: pointer;}
    .loading{display: none;}
</style>
<div class="modal fade" id="ajaxremove" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo $this->config->item('base_url') ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<div class="breadcrumbs">
    <h1>Inbox</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li class="active">Inbox</li>
    </ol>
    <!-- Sidebar Toggle Button -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".page-sidebar">
        <span class="sr-only">Toggle navigation</span>
        <span class="toggle-icon">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </span>
    </button>
    <!-- Sidebar Toggle Button -->
</div>
<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
<div class="page-content-col">
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="inbox" id="inbox">
        <div class="row">
            <div class="col-md-2">
                <div class="inbox-sidebar" >
                    <span data-title="Compose" data-bind="click: composeAction"  class="btn red compose-btn btn-block compose-mail"><i class="fa fa-edit"></i> Compose </span>
                    <div class="template-loader" style="text-align: center; margin: 40px auto;"><img src="<?php echo site_url() ?>assets/images/loading-spinner-blue.gif"></div>
                    <ul class="inbox-nav" data-bind="template: {name: 'inbox-template', foreach: oFolders}">
                    </ul>
                </div>
                <script type="text/html" id="inbox-template">
                    <li data-bind="attr: {class: activeClass}">
                        <a href="javascript:;" data-bind="with: namesis,attr: {'data-type': name, 'data-title': fullname}, click: getMessages">
                            <span data-bind="text: name"></span>
                            <!-- ko if: unseen -->
                            <span class="badge badge-success" data-bind="text: unseen"></span>
                            <!-- /ko -->
                        </a>
                    </li>
                </script>
            </div>
            <div class="col-md-10">
                <div class="inbox-body">
                    <div class="inbox-header">
                        <h1 class="pull-left header-title" data-bind="text: oMailBox">Inbox</h1>
                    </div>
                    <div class="inbox-content" id="email-content" style="display: none;">

                    </div>
                    <div class="inbox-content">
                        <div class="portlet-body">
                            <div class="table-scrollable" id="email-list-table">
                                <input type="hidden" id="start" value="<?php echo $offset; ?>" />
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3">
                                                <span class="btn btn-sm blue deletemail" title="Delete Selected Miall"><i class="fa fa-trash-o" style="font-size:15px;"></i></span>
                                                <span class="btn btn-sm blue readmail" title="Mark As Read"><i class="fa fa-eye" style="font-size:15px;"></i></span>
                                            </th>
                                            <th class="pagination-control" colspan="3">
                                                <span class="pagination-info"> <?php echo $offset; ?> - <span data-bind="text: index"></span> of <span data-bind="text: totalMessage"><?php echo $total; ?></span> </span>
                                                <a class="btn btn-sm blue btn-outline previous"><i class="fa fa-angle-left"></i></a>
                                                <a class="btn btn-sm blue btn-outline" data-bind="click: getNextSet"><i class="fa fa-angle-right"></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="email-list" data-bind="foreach: oMessageList, afterAdd: yellowFadeIn">
                                        <tr data-bind="attr: {class: flags}">
                                            <td class="inbox-small-cells">
                                                <input type="checkbox" class="group-checkable" name="id[]" data-bind="value: Uid" />
                                            </td>
                                            <td class="view-message" data-bind="attr: {class : attachment},click: messageEvent"></td>
                                            <td class="view-message" data-bind="text: subject,click: messageEvent"></td>
                                            <td class="view-message"><span data-bind="text: fromname,click: messageEvent"></span>&#60;<span data-bind="text: fromEmailList"></span>&#62;</td>
                                            <td colspan="2" class="view-message text-right" data-bind="text: date,click: messageEvent"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE BASE CONTENT -->
</div>

<script>
$( document ).ready(function() {

    var offset = $('#start').val();
    if(offset == 0){
        $('.previous').addClass('disabled');
    }
    
    $(document).on("click",".deletemail",function() {
        var uid = $('input:checkbox:checked').serialize();
        if(uid == ''){
            swal('Error','Please select atleast one mail to delete.');
        } else {
            swal({
                title: "Are you sure?",
                text: "Are you sure you want to delete selected email?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: true,
                html: false
            }, function () {
                $('#loading').modal('show');
                    $.ajax({
                        url: '<?php echo site_url('email/delete_selected_mail') ?>',
                        method: 'POST',
                        data: uid,
                        success: function (data) {
                            $('#loading').modal('hide');
                            location.reload();
                        }
                    });
            });
        }
    });

    $(document).on("click",".readmail",function() {
        var uid = $('input:checkbox:checked').serialize();
        if(uid == ''){
            swal('Error','Please select atleast one mail to read.');
        } else {
            $('#loading').modal('show');
            $.ajax({
                url: '<?php echo site_url('email/read_selected_mail') ?>',
                method: 'POST',
                data: uid,
                success: function (data) {
                    $('#loading').modal('hide');
                    location.reload();
                }
            });
        }
    });
    
    $(document).on("click",".replay-mail",function() {
        var uid = $('#uid').val();
        $.ajax({
            url: '<?php echo site_url('email/replay_email') ?>',
            method: 'POST',
            data: {id: uid},
            success: function (data) {
                $('#email-content').html(data)
            }
        });
    });
    
});
</script>