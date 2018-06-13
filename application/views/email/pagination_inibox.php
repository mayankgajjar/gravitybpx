<div class="portlet-body">
    <div class="table-scrollable">
        <input type="hidden" id="start" value="<?php echo $offset; ?>" />
        <table class="table table-striped table-bordered table-advance table-hover">
            <thead>
                <tr>
                    <th colspan="3">
                        <span class="btn btn-sm blue deletemail"><i class="fa fa-trash-o" Title="Delete Selected Miall"></i></span>
                        <span class="btn btn-sm blue readmail" title="Mark As Read"><i class="fa fa-eye" style="font-size:15px;"></i></span>
                    </th>
                    <th class="pagination-control" colspan="3">
                        <span class="pagination-info"> <?php echo $offset; ?> - <?php echo $end; ?> of <?php echo $total; ?> </span>
                        <a class="btn btn-sm blue btn-outline previous"><i class="fa fa-angle-left"></i></a>
                        <a class="btn btn-sm blue btn-outline next"><i class="fa fa-angle-right"></i></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php //dump($msglist); ?>
                <?php foreach ($msglist as $msg) {  ?>                                        
                     <tr>                  
                        <?php if(sizeof($msg->Flags()) > 0) { ?>
                        <td><input type="checkbox" class="group-checkable" name="id[]" value="<?php echo  $msg->Uid(); ?>"/></td>
                            <td id="<?php echo  $msg->Uid(); ?>" class="msg-row"><?php echo $msg->Subject();?></td>
                            <td><b><?php $msg->From()->ForeachList('fromname'); ?></b> &#60;<?php $msg->From()->ForeachList('fromEmailList'); ?>&#62;</td>
                            <td><?php echo substr($msg->HeaderDate(), 0, 25); ?></td>
                        <?php } else {?>
                            <td><input type="checkbox" class="group-checkable" name="id[]" value="<?php echo  $msg->Uid(); ?>"/></td>
                            <td id="<?php echo  $msg->Uid(); ?>" class="msg-row"><b><?php echo $msg->Subject();?></b></td>
                            <td><b><?php $msg->From()->ForeachList('fromname'); ?> &#60;<?php $msg->From()->ForeachList('fromEmailList'); ?>&#62;</b></td>
                            <td><b><?php echo substr($msg->HeaderDate(), 0, 25); ?></b></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>