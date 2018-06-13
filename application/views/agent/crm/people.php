<div class="portlet-title">
    <div class="caption" style="display: inline-block">
        <h4><?php echo "Additional People" ?></h4>
    </div>    
    <div class="actions" style="display: inline-block; float: right;">
        <a href="<?php echo site_url('lead/leadpeopleform/'. encode_url($leadId)) ?>" class="btn green" data-target="#ajax" data-toggle="modal"><?php echo 'Add Person' ?></a>
    </div>
    <div class="clear: both"></div>
</div>
<div class="messagepep"></div>
<table class="table table-striped">    
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo 'Name' ?></th>
            <th><?php echo 'Relationship' ?></th>
            <th><?php echo 'Dob' ?></th>
            <th><?php echo 'Phone' ?></th>
            <th><?php echo 'Email' ?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($leadPeoples): ?> 
            <?php $i = 0; ?>
            <?php foreach ($leadPeoples as $people): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $people->name ?></td>
                    <td><?php echo $people->relation ?></td>
                    <td><?php 
                            $date = strtotime($people->date_of_birth);                            
                            if($date > 0){
                                echo date('m/d/Y',$date);
                            }else{
                                echo '';
                            }                            
                        ?></td>
                    <td><?php echo $people->phone ?></td>
                    <td><?php echo $people->email ?></td>
                    <td>
                        <a href="<?php echo site_url('lead/leadpeopleform/'. encode_url($leadId)).'/'.encode_url($people->people_id) ?>" class="btn green" data-target="#ajax" data-toggle="modal"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" onclick="deletePeople('<?php echo encode_url($people->people_id) ?>')" class="btn green"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td align="center" colspan="7"><?php echo 'No data found.' ?></td>
            </tr>
        <?php endif; ?>
    </tbody>            
</table>
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
<!-- /.modal -->
<script type="text/javascript">
    function personForm(event) {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        var validFlag = jQuery('#peopleForm').valid();
        if (validFlag == true) {
            var postData = jQuery('#peopleForm').serialize();            
            jQuery('#loading').modal('show');
            jQuery.ajax({
                url: '<?php echo site_url("lead/peopleformpost") ?>',
                method: 'post',
                dataType: 'json',
                data: postData,
                success: function (result) {
                    var flag = result.success;
                    jQuery('.msgpepform').html(result.html);                                                           
                    jQuery('#ajax').modal('hide');
                    leadMenu('people');
                    jQuery('.modal-backdrop').remove();                    
                }
            });
        }
    }
    function selectCity(state, city_name) {
        jQuery('#loading').modal('show');
        var state_id = jQuery(state).find(":selected").attr('data-id');
        if (typeof state_id == 'undefined') {
            state_id = '';
        }
        jQuery.ajax({
            url: '<?php echo site_url('ajax/getcity') ?>',
            method: 'post',
            dataType: 'json',
            data: {state: state_id, city: city_name},
            success: function (result) {
                jQuery('[name="city"]').replaceWith(result.result);
                jQuery('#loading').modal('hide');
            }
        });
    }
    
    function deletePeople(peopleId){
        jQuery.ajax({
            url: '<?php echo site_url('lead/leadpdelete') ?>',
            method: 'post',
            dataType: 'json',
            data: {is_ajax: true ,people_id : peopleId },
            success: function (result) {
                jQuery('.messagepep').html(result.html);                
                leadMenu('people');
            }
        });        
    }    
</script>