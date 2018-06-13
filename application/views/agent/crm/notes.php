<style>
.notes-comment .well{
	padding: 10px;
}
.notes-comment .notes{
	margin: 20px 5px;
}
.spoke-man{
	color: #337ab7;
}
</style>
<div class="portlet-title">
    <div class="messagenotes"></div>
    <div class="caption" style="display: inline-block">
        <h4><i class="fa fa-edit"></i> Notes & Conversations</h4>
    </div>    
    <div class="clear: both"></div>
</div>

<span>Add a note to keep a history of your interactions.</span>
<form method="post" class="form-horizontal" action="" onsubmit="submit_note()" id="noteForm">
    <input type="hidden" name="lead_id" value="<?=$leadId?>">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-12">
            	<textarea class="form-control" name="notes" rows="3"></textarea>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn green pull-right"><?php echo 'Add Note' ?></button>
            </div>
        </div>
    </div>    
</form> 

<?php if(count($leadNotes) > 0) :?>
	<?php foreach($leadNotes as $leadnote) : ?>	
		<div class="row notes-comment">
			<div class="col-sm-12">
				<div class="well well-small"><i class="fa fa-comment"></i> | <?php echo $leadnote['created']; ?> 
                    <?php if($leadnote['agent_name'] != '') : ?>
                        | Spoke With <span class="spoke-man"><?php echo $leadnote['agent_name']; ?></span>
                    <?php elseif($leadnote['agency_name'] != '') :?>
                        | Spoke With <span class="spoke-man"><?php echo $leadnote['agency_name']; ?></span>
                    <?php elseif($leadnote['admin_name'] != '') :?>
                        | Spoke With <span class="spoke-man"><?php echo $leadnote['admin_name']; ?></span>
                    <?php endif; ?>
                </div>
			</div>	
			<div class="col-sm-12 notes">
				<?php echo $leadnote['notes']; ?>
			</div>	
		</div>
	<?php endforeach; ?>
<?php endif; ?>	

<script>
function submit_note(){
	event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening
    var validFlag = jQuery('#noteForm').valid();
    if (validFlag == true) {
        var postData = jQuery('#noteForm').serialize();            
        jQuery('#loading').modal('show');
        jQuery.ajax({
            url: '<?php echo site_url("lead/noteformpost") ?>',
            method: 'post',
            dataType: 'json',
            data: postData,
            success: function (result) {
                var flag = result.success;
                jQuery('.messagenotes').html(result.html);                                                           
                jQuery('#ajax').modal('hide');
                leadMenu('notes');
                jQuery('.modal-backdrop').remove();                    
            }
        });
    }
}
</script>       