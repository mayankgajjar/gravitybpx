<div class="portlet-title">
    <div class="caption" style="display: inline-block">
        <h4><?php echo "Products" ?></h4>
    </div>
    <div class="actions" style="display: inline-block; float: right;">
        <a href="<?php echo site_url('lead/prodcutform/'. encode_url($leadId)) ?>" class="btn green" data-target="#ajaxproduct" data-toggle="modal" data-cache="false"><?php echo 'Add Product' ?></a>
    </div>
    <div class="clear: both"></div>
</div>
<div class="msgproform"></div>
<table class="table table-striped">
    <thead>
        <tr>
            <th><?php echo '#' ?></th>
            <th><?php echo 'Status' ?></th>
            <th><?php echo 'Coverage' ?></th>
            <th><?php echo 'Carrier' ?></th>
            <th><?php echo 'Product' ?></th>
            <th><?php echo 'Commission' ?></th>
            <th><?php echo 'Actions' ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($leadProducts) > 0): ?>
            <?php $i=0;foreach($leadProducts as $leadProduct): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $leadProduct['status'] ?></td>
                    <td><?php echo $leadProduct['category_name'] ?></td>
                    <td><?php echo $leadProduct['company_name'] ?></td>
                    <td><?php echo $leadProduct['product_name'] ?></td>
                    <td></td>
                    <td>
                        <a class="btn green" href="<?php echo site_url('lead/prodcutform/'. encode_url($leadId).'/'. encode_url($leadProduct['lead_product_id'])) ?>" data-target="#ajaxproduct" data-toggle="modal" data-cache="false"><i class="fa fa-edit"></i></a>
                        <a class="btn green" onclick="deleteProducts('<?php echo encode_url($leadProduct['lead_product_id']) ?>')" href="javascript:;"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
<div class="modal fade" id="ajaxproduct" role="dialog" aria-hidden="true"  data-cache="false">
    <div class="modal-dialog modal-full">
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
jQuery("#ajaxproduct").on('hidden.bs.modal', function () {
    jQuery(this).find('.modal-body').html("");
});
    function productFormSubmit(event){
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        var productIdValue = parseInt(jQuery('[name="products_id"]').val());
        if(productIdValue < 1){
            jQuery('.msgprodform').html("Please select any product.");
            jQuery('.msgprodform').css('color', 'red');
            jQuery('.msgprodform').css('font-size', '20px');
            jQuery('.msgprodform').css('margin-bottom', '15px');
            jQuery('.msgprodform').css('text-align', 'center');
            return false;
        }
        var postData = jQuery('#productForm').serialize();
        jQuery.ajax({
            url: '<?php echo site_url("lead/productformpost") ?>',
            method: 'post',
            dataType: 'json',
            data: postData,
            success: function (result) {
                var flag = result.success;
                jQuery('.msgproform').html(result.html);
                jQuery('#ajaxproduct').modal('hide');
                setTimeout(function(){
                    leadMenu('products');
                    jQuery('.modal-backdrop').remove();
                }, 1000);
            }
        });
    }

    function deleteProducts(productId){
        var postData = jQuery('#productForm').serialize();
        jQuery.ajax({
            url: '<?php echo site_url("lead/productdelete") ?>',
            method: 'post',
            dataType: 'json',
            data: {lead_prodcut_id : productId, is_ajax : true},
            success: function (result) {
                var flag = result.success;
                jQuery('.msgproform').html(result.html);
                setTimeout(function(){
                    leadMenu('products');
                }, 1000);
            }
        });
    }
    function reLoadScript(){
            jQuery('#scroll').slimScroll({
              allowPageScroll: true, // allow page scroll when the element scroll is ended
              size: '7px',
            });
    }
</script>