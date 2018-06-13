<ul id="leadtab" class="nav nav-pills">
    <li id="leadnote" class="active">
        <a href="#notes" data-toggle="tab" onclick="leadMenu('notes')"> <?php echo "Notes" ?> </a>
    </li>
    <li id="campaignedit">
        <a href="#information" data-toggle="tab"> <?php echo "Information" ?> </a>
    </li>
    <li id="file">
        <a href="#files" data-toggle="tab" onclick="leadMenu('files')"> <?php echo 'Files'; ?> </a>
    </li>
    <li id="peoplelink">
        <a href="#people" data-toggle="tab" onclick="leadMenu('people')"><?php echo "Additional People" ?> </a>
    </li>
    <?php if($lead->status == 'Client' || $lead->status == 'Opportunity' ): ?>
    <li id="productslink">
        <a href="#products" data-toggle="tab" onclick="leadMenu('products')"><?php echo "Products" ?> </a>
    </li>
    <?php endif; ?>
</ul>
<script type="text/javascript">
function leadMenu(block){
    if(block == 'information'){
        return false;
    }
    var ajaxURL;
    switch(block){
        case 'notes':
            ajaxURL = '<?php echo site_url('lead/notes/'.encode_url($lead->lead_id)) ?>';
            break;
        case 'files':
            ajaxURL = '<?php echo site_url('lead/leadfile/'.encode_url($lead->lead_id)) ?>';
            break;
        case 'people':
            ajaxURL = '<?php echo site_url('lead/leadpeople/'.encode_url($lead->lead_id)) ?>';
            break;
        case 'products':
            ajaxURL = '<?php echo site_url('lead/leadprodcut/'.encode_url($lead->lead_id)) ?>';
            break;
    }
    jQuery('#loading').modal('show');

    jQuery.ajax({
        url : ajaxURL,
        method : 'post',
        dataType : 'json',
        success : function(result){
            var flag = result.success;
            if(flag){
                jQuery('#'+block).html(result.html);
            }
            jQuery('#loading').modal('hide');
        }
    });
}
</script>