<form id="dncform" action="<?php echo site_url('dialer/lists/dncedit') ?>">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?php echo 'Add DNC Number' ?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
                <h4><?php echo 'Phone Number' ?></h4>
                <p>
                    <input type="text" name="phone_number" value="<?php echo $number->phone_number ?>" class="col-md-12 form-control">
                </p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn blue">Save changes</button>
</div>
</form>
<script type="text/javascript">
    jQuery(function(){
       jQuery(document).on('submit','#dncform',function(event){
           event.preventDefault();
           $data = jQuery(this).serialize();
           jQuery.ajax({
               url : jQuery(this).attr('action'),
               method : 'POST',
               data : $data,
               dataType : 'json',
               success : function(result){
                   window.location.href=window.location.href;
               }
           });
       });
    });
</script>