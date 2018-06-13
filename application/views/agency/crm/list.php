<style>
@-webkit-keyframes bouncebounce {
  0% {
    bottom: 10px;
  }
  100% {
    bottom: 20px;
  }
}
@-moz-keyframes bouncebounce {
  0% {
    bottom: 10px;
  }
  100% {
    bottom: 20px;
  }
}
@-ms-keyframes bouncebounce {
  0% {
    bottom: 10px;
  }
  100% {
    bottom: 20px;
  }
}
@keyframes bouncebounce {
  0% {
    bottom: 10px;
  }
  100% {
    bottom: 20px;
  }
}
.clickTrue {
  -webkit-animation: bouncebounce 0.9s 1.5s infinite ease-out alternate;
  -moz-animation: bouncebounce 0.9s 1.5s infinite ease-out alternate;
  -ms-animation: bouncebounce 0.9s 1.5s infinite ease-out alternate;
  animation: bouncebounce 0.9s 1.5s infinite ease-out alternate;
}
    tbody tr td:last-child,
    thead tr th:last-child{
        display:none;
    }
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $maintitle; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $maintitle; ?> </h3>
<?php if ($this->session->flashdata()) : ?>
    <?php if ($this->session->flashdata('error') != "") : ?>
        <div class='alert alert-danger'>
            <i class="fa-lg fa fa-warning"></i>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php else : ?>
        <div class='alert alert-success'>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<div class="message"></div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url($addactioncontroller); ?>" class="btn btn-info" title="Add New <?php echo $label ?>">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New {$label}"; ?></span>
            </a>
            <a href="<?php echo site_url($importactioncontroller); ?>" class="btn btn-info" title="Import">
                <i class="fa fa-file"></i>
                <span class="hidden-xs"><?php echo "Import New {$label}"; ?></span>
            </a>
            <a href="<?php echo site_url($exportactioncontroller); ?>" class="btn btn-info" title="Export">
                <i class="fa fa-file-text-o"></i>
                <span class=""><?php echo "Export {$label}"; ?></span>
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <form id="quickform" class="categories_from" action="<?php echo site_url('age/lead/massaction/' . lcfirst($type)); ?> " name="categories_form" method="post" onsubmit="submitform(event)">

            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4" style="float:right">
                        <div class="table-group-actions pull-right">
                            <select id="form_lead_action" name="action" class="table-group-action-input form-control input-inline input-small input-sm">
                                <option value="">Select...</option>
                                <option value="del">Delete</option>
                            </select>
                            <button class="btn btn-sm btn-success table-group-action-submit">
                                <i class="fa fa-check"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                <thead>
                <th>
                    <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" />
                </th>
                <th> <?php echo "Name"; ?> </th>
                <th> <?php echo "Assigned Agent" ?></th>
                <th> <?php echo "Member ID" ?></th>
                <th> <?php echo "Disposition"; ?> </th>
                <th> <?php echo "City"; ?> </th>
                <th> <?php echo "Phone"; ?> </th>
                <th> <?php echo "Status"; ?> </th>
                <th> <?php echo "Last Call"; ?> </th>
                <th> <?php echo "Ceated By"; ?> </th>
                <th> &nbsp; </th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>
    </div>
</div>
<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxemail" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="mail-box">
                <div class="modal-body">
                    <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wheel Menu-->
<div id='ss_menu'>

    <div><img src="<?php echo site_url() ?>assets/images/nav-images/call-out.png" alt="" class="loading"></div>
    <div><img src="<?php echo site_url() ?>assets/images/nav-images/bubbles.png" alt="" class="loading"> </div>
    <div class="emailSend" data-target="#ajaxemail" data-toggle="modal"><img src="<?php echo site_url() ?>assets/images/nav-images/envelope.png" alt="" class="loading"></div>
    <div class="attachment-icon"><img src="<?php echo site_url() ?>assets/images/nav-images/paper-clip.png" alt="" class="loading"></div>
    <div class="delete-icon-menu delete-lead-btn"><img src="<?php echo site_url() ?>assets/images/nav-images/delete_transparant.png" alt="" class="loading">
    </div>
    <div class='menu' id="toggle_menu">
        <div class='share' id='ss_toggle' data-rot='180'>
            <div class="menu-bar"><img src="<?php echo site_url() ?>assets/images/nav-images/bar.png" alt="" class="loading"></div>
        </div>
    </div>
</div>
<!-- /.wheel Menu -->
<script type="text/javascript">
    jQuery(function () {
        jQuery('#leadstore').parent('a').parent('li').addClass('active open');
        jQuery('#<?php echo lcfirst($type) ?>').parent('a').parent('li').parent('ul').show();
        jQuery('#<?php echo lcfirst($type) ?>').parent('a').parent('li').addClass('active');
        jQuery('#datatable').dataTable({
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('age/lead/indexjson/' . $type); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 10]
                }, {
                    "searchable": false,
                    "targets": [0, 10]
                }],
            "order": [
                [0, "DESC"]
            ]
        });
        jQuery('#datatable').find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                }
            });
            jQuery.uniform.update(set);
        });
        jQuery(document).on('click', '.delete', function (event) {
            event.preventDefault();
            var href = jQuery(this).attr('href');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function () {
                location.href = href;
            });
        });

        /* ---------- For Double click open lead info -------- */
        jQuery(document).on("dblclick", "tbody tr", function (event) {
            var edit_url = $(this).find('td:last').find('a').eq('0').attr('href');
            window.location.href = edit_url;
        });
        /* ---------- End For Double click open lead info -------- */

    });
    function submitform(event) {
        var length = jQuery('.checkboxes:checked').length;
        if (length <= 0) {
            event.preventDefault();
            swal({
                title: "Error",
                text: "Please select atleast on record!",
                type: "error",
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "",
                closeOnConfirm: true,
                html: false
            }, function () {
                event.preventDefault();
            });
        }
    }
    $(document).ready(function (ev) {
        $('#toggle_menu').addClass("clickFlase");
        $('#ss_menu').addClass("disable");
        var toggle = $('#ss_toggle');
        var menu = $('#ss_menu');
        var rot;
        $('#ss_toggle').on('click', function (ev) {
            rot = parseInt($(this).data('rot')) - 180;
            menu.css('transform', 'rotate(' + rot + 'deg)');
            menu.css('webkitTransform', 'rotate(' + rot + 'deg)');
            if ((rot / 180) % 2 == 0) {
                //Moving in
                toggle.parent().addClass('ss_active');
                 $('#toggle_menu').removeClass("clickTrue");
                toggle.addClass('close-menu');
            } else {
                //Moving Out
                toggle.parent().removeClass('ss_active');
                $('#toggle_menu').addClass("clickTrue");
                toggle.removeClass('close-menu');
            }
            $(this).data('rot', rot);
        });
        menu.on('transitionend webkitTransitionEnd oTransitionEnd', function () {
            if ((rot / 180) % 2 == 0) {
                $('#ss_menu div i').addClass('ss_animate');
            } else {
                $('#ss_menu div i').removeClass('ss_animate');
            }
        });
        jQuery(document).on('click', '.bubbleAction', function (event) {
            attachmentIcon();
            emailSender();
            clickBubble();
            if (jQuery('.checkboxes:checked').length >= 1) {
                if (jQuery('#toggle_menu').hasClass('ss_active') == false) {
                    $('#ss_toggle').click();
                }
            } else {
                if (jQuery('#toggle_menu').hasClass('ss_active') == true) {
                    $('#ss_toggle').click();
                }
            }
            return true;
        });
        jQuery(document).on('click', '.delete-lead-btn', function (event) {
            $('#form_lead_action').val('del');
            swal({
                title: "Delete this contact(s)",
                text: "Are you sure you would like to delete this contact forever?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function () {
                $('#quickform').submit();
            });
        });
        jQuery(document).on('click', '#datatable tbody tr', function (event) {
            var $checkbox = jQuery(this).find('td').find('.checkboxes');
            attachmentIcon();
            emailSender();
            clickBubble();
            if (!jQuery(event.target).is($checkbox)) {
                jQuery($checkbox).trigger('click');
            }
        });
        jQuery(document).on("click", ".attachment-icon", function (event) {
            var $checkbox = jQuery('#datatable tbody tr').find('td').find('.checkboxes:checked');
            var attachment_url = jQuery($checkbox).parent('td').parent('tr').find(".attachment");
            attachment_url.click();
        });
        function attachmentIcon() {
            if (jQuery('.checkboxes:checked').length > 1) {
                $(".attachment-icon").addClass("no-attached");
            }
            if (jQuery('.checkboxes:checked').length === 1) {
                $(".attachment-icon").removeClass("no-attached");
            }
        }
        function emailSender() {
            if (jQuery('.checkboxes:checked').length === 1) {
                jQuery('.checkboxes:checked').addClass("sendTO");
            }
        }
        function clickBubble() {
            if (jQuery('.checkboxes:checked').length >= 1) {
                $('#toggle_menu').removeClass("clickFlase");
            } else {
                $('#toggle_menu').addClass("clickFlase");
                $('#toggle_menu').removeClass("clickTrue");
            }
        }
        jQuery(document).on("click", ".sendTO", function (event) {
            if (!$(this).is(":checked")) {
                $(this).removeClass("sendTO");
            }
        });
        jQuery(document).on("click", ".emailSend", function (event) {
            var checkBoxs = jQuery('.checkboxes:checked');
            var checkIDS = [];
            var idsJson = [];
            checkBoxs.each(function (i) {
                if ($(this).hasClass('sendTO')) {
                    checkIDS.push({
                        'send': $(this).val()
                    });
                } else {
                    checkIDS.push({
                        'bcc': $(this).val()
                    });
                }
            });
            idsJson = JSON.stringify(checkIDS);
            jQuery.ajax({
                url: '<?= site_url('age/lead/mailAction/') ?>',
                method: 'post',
                data: {idsJson: idsJson},
                success: function (result) {
                    jQuery("#mail-box").html(result);
                }
            });
        });
    });
</script>
