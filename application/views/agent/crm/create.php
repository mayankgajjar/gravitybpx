<style>
    .required{
        color: #e73d4a;
    }
    .modal-backdrop{z-index: 999;}
</style>
<div class="btn-group create-pop-group">
    <a class="btn green" href="javascript:;" onclick="showPop(event)"> <i class="fa fa-plus"></i>&nbsp;Create</a>
        <div class="create-popup" style="display: none;">
            <div class="_create-menu_create-menu_1tXuF _popover_body_3XrC5 _popover_location-bottom-right_1it8o">
                <div class="_create-menu_container_1fVEf">
                    <ul>
                        <li>
                            <a class="btn green open-box" data-custom-value="lead"><?php echo 'Lead' ?></a>
                        </li>
                        <li>
                            <a class="btn green open-box" data-custom-value="opportunity"><?php echo 'Opportunity' ?></a>
                        </li>
                        <li>
                            <a class="btn green open-box" data-custom-value="client"><?php echo 'Client' ?></a>
                        </li>
                        <li>
                            <a class="btn green open-box" data-custom-value="event"><?php echo 'Event' ?></a>
                        </li>
                        <li>
                            <a class="btn green open-box" data-custom-value="task"><?php echo 'Task' ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
    function showPop(e){
        e.stopPropagation();
        jQuery('.create-popup').toggle();
    }
    jQuery(document).on('click', function(e){
        jQuery('.create-popup').hide();
    });
    
    $(document).on("click", ".open-box", function () {
        var box_type = $(this).data("custom-value");
        $.ajax({
            method: "POST",
            url: '<?php echo  base_url('crm/get_popup_box') ?>',
            data: {boxtype: box_type},
            success: function (data) {
                $('.html-data').html(data);
                $('#add-task').modal('show');
            }
        });
    });
    
    function getdata(getform,e){
        e.preventDefault();
        var frmarr = $(getform).serializeArray();
            $.ajax({
               method: "POST",
               url: '<?php echo  base_url('crm/create_save') ?>',
               data: frmarr,
               success: function (data) {
                   if(data== 'error'){
                       //location.reload();
                   } else {
                       $(location).attr('href', data);
                   }
               }
           });
    }
</script>
