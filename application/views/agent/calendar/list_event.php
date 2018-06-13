<div class="mt-element-list" style="margin-top:20px;">
    <div class="mt-list-head list-simple font-white bg-blue">
        <div class="list-head-title-container">
            <!-- <div class="list-date">Nov 8, 2015</div> -->
            <h4 class="list-title">Event List</h4>
        </div>
    </div>
    <div class="mt-list-container list-simple event_list">
        <ul>   
            <?php foreach($event_data as $event) :?>
                <li class="mt-list-item" style="padding:0px;">
                    <div class="list-icon-container done">
                        <a href="<?=BASE_URL('calendar/delete_event/'.encode_url($event['id']))?>" class="delete"><i class="icon-close"></i></a>
                    </div>
                    <div class="list-datetime"> <?=date("d M",strtotime($event['created']));?> </div>
                    <div class="list-item-content">
                        <h5 class="event_desc"><a onclick="gotodate('<?=$event['event_start_date']?>')"><?=$event['event_desc']?></a></h5>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>