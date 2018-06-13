<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo 'Voicemail Chooser' ?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th> # </th>
                    <th><?php echo 'Voicemail Boxes' ?></th>
                    <th><?php echo 'Name' ?></th>
                    <th><?php echo 'Email' ?></th>
                    <th><?php echo 'Agency' ?></th>
                    <th><?php echo 'Agent' ?></th>
                </tr>
                <?php $i=1;foreach($voicemail1 as $voicemail): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript:selectVoicemail('<?php echo $voicemail['voicemail_id']; ?>','<?php echo $field ?>')"><?php echo $voicemail['voicemail_id']; ?></a></td>
                    <td><?php echo $voicemail['voicemail_id'].' '.$voicemail['fullname']; ?></td>
                    <td><?php echo $voicemail['email'] ?></td>
                    <td><?php echo $voicemail['name'] ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
                <?php foreach($voicemail2 as $voicemail): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript:selectVoicemail('<?php echo $voicemail['voicemail_id']; ?>','<?php echo $field ?>')"><?php echo $voicemail['voicemail_id']; ?></a></td>
                    <td><?php echo $voicemail['voicemail_id'].' '.$voicemail['fullname']; ?></td>
                    <td><?php echo $voicemail['email'] ?></td>
                    <td><?php echo $voicemail['name'] ?></td>
                    <td>&nbsp;</td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
                <?php foreach($voicemail3 as $voicemail): ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><a href="javascript:selectVoicemail('<?php echo $voicemail['voicemail_id']; ?>','<?php echo $field ?>')"><?php echo $voicemail['voicemail_id']; ?></a></td>
                    <td><?php echo $voicemail['voicemail_id'].' '.$voicemail['fullname']; ?></td>
                    <td><?php echo $voicemail['email'] ?></td>
                    <td>
                        <?php $agent = $this->agent_model->getAgentInfo($voicemail['agent_id']) ?>
                        <?php echo $agent->parent_name  ?>
                    </td>
                    <td><?php echo $voicemail['fname'].' '.$voicemail['lname'] ?></td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>
</div>
<style type='text/css'>
.modal-body {max-height: calc(100vh - 210px);overflow-y: auto;}
</style>
