<ul class="dropdown-menu-list notifications1 scroller" style="height: 250px;" data-handle-color="#637283">
    <?php if(count($notifications) > 0) :?>
        <?php foreach($notifications as $notification) :?>
            <li class="<?php if($notification['status'] == 0) { echo "unread_notify"; }?>">
                <a href="<?=base_url('agent/read_notification/'.encode_url($notification['log_id']))?>"> 
                    <span class="details ">
                        <span class="label label-sm label-icon label-success">
                            <?php echo feed_status($notification['log_type']); ?>
                        </span> <p><?=$notification['title']?></p>
                    </span>
                    <span class="time"><?=time_ago($notification['created'])?></span>
                </a>
            </li>
        <?php endforeach; ?>    
    <?php else : ?> 
     <li>No Notification</li>  
    <?php endif; ?>
</ul>

<script>
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url() . 'agent/fetch_unread_notification_count'; ?>',
        success: function (data) {
            $(".user_notification").html(data);
        }
    });
</script>