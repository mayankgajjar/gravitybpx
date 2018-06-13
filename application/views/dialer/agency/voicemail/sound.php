<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo 'Audio Chooser' ?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th> # </th>
                    <th><?php echo 'Filename' ?></th>
                    <th><?php echo 'Play' ?></th>
                </tr>
                <?php for($i=1; $i <= (count($files[1])-1); $i++): ?>

                <tr>
                    <td><?php echo $i ?></td>
                    <?php $filename = substr($files[1][$i], 0, strpos($files[1][$i], ".")); ?>
                    <td><a href="javascript:chooseFile('<?php echo $filename ?>')"><?php echo $filename ?></a></td>
                    <td><a target="_blank" href="<?php echo $this->config->item('vicidial_url').$sounds_web_directory.'/'.$files[1][$i] ?>"><?php echo 'Play' ?></a></td>
                </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>
</div>
