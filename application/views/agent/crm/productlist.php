<?php $_columnCount = 3; ?>
<?php $_collectionSize = count($products) ?>
<?php $i = 0;
foreach ($products as $key => $value): ?>
        <?php if ($i++ % $_columnCount == 0): ?>
        <ul class="row products-grid">
    <?php endif ?>
    <?php
        $checked = '';
        if($leadProduct->product_id == $value['id'] ){
            $checked = 'checked="checked"';
        }
    ?>
        <li class="col-md-4 temp_product">
            <div class="portlet box blue-hoki">
                <div class="cbp cbp-caption-active cbp-ready">
                    <div class="cbp-caption cbp-singlePageInline" data-title="<?php echo $value['product_name'] ?>">
                        <div class="action-block-top">
                            <div class="actions">
                                <a href="javascript:;" onclick="selectProduct('<?php echo $value['id'] ?>')" class="btn btn-default btn-sm products_details"><?php echo 'Select Product' ?></a>
                                <input type="radio"  id="check-<?php echo $value['id'] ?>" name="products_id" value="<?php echo $value['id'] ?>" <?php echo $checked ?>>
                            </div>
                        </div>
                        <div class="cbp-caption-defaultWrap">
                            <div class="product_company">
                                <?php if ($value['company_logo'] != "") : ?>
                                    <img class="company_logo" src="<?php echo site_url() ?>uploads/company_logo/<?php echo $value['company_logo'] ?>" />
                                <?php else: ?>
                                    <img class="company_logo" src="<?php echo site_url() ?>uploads/company_logo/no-photo-available.jpeg" />
                                <?php endif; ?>
                            </div>
                            <div class="product_name">
                                <span class="product_name_span">
                                    <?php if ($value['product_name'] != "") : ?>
                                        <?php echo $value['product_name']; ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="product_level">
                                <?php if ($value['product_levels'] != ""): ?>
                                    <?php echo $value['product_levels']; ?>
                                <?php endif; ?>
                            </div>
                            <div class="product_price">
                                <?php if ($value['product_price'] != "") : ?>
                                    <?php echo toMoney($value['product_price']) ?><span class="monthly">/month</span>
                                <?php else : ?>
                                    $0.00 <span class="monthly">/month</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="action-block-bottom">
                            <div class="actions">
                                <a href="#detail-<?php echo $value['id'] ?>" data-id="<?php echo $value['id'] ?>" class="btn btn-default btn-sm p-details products_details"><?php echo 'Details' ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fancybox fancy_open_<?php echo $value['id'] ?>" style="display: none;">
                    <div class="product_desc_title"><?php echo $value['product_name'] ?> Description </div>
                        <?php echo $value['product_description'] ?>
                </div>
                <div class="modal fade" id="detail-<?php echo $value['id'] ?>" role="basic" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
                                <h4 class="modal-title">Product Description</h4>
                            </div>
                            <div class="modal-body">
                                <div class="product_desc_title"><?php echo $value['product_name'] ?></div>
                                    <?php echo $value['product_description'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php if ($i % $_columnCount == 0 || $i == $_collectionSize): ?>
        </ul>
    <?php endif ?>
<?php endforeach; ?>
<style>
    .products-grid .cbp .product_company{margin: 0 0 10px;}
    .products-grid li {list-style-type: none;}
    .products-grid .cbp .product_price{font-size: 20px;}
    .products-grid .actions{text-align: center;}
    .cbp-caption-defaultWrap{background: #fff;}
    .products-grid .action-block-bottom a.products_details, .products-grid .action-block-top a.products_details{
        color: #428bca;
        font-size: 15px;
        font-weight: 300;
        text-transform: uppercase;
        background :transparent none repeat scroll 0 0 !important;
        border : 0 none !important;
        box-shadow: none !important;
    }
    .fancybox-opened{z-index:1000000;}
</style>
<script type="text/javascript">
    jQuery('.fancybox').fancybox();

    function selectProduct(id) {
        jQuery('#check-' + id).trigger('click');
        jQuery('msgproform').html('');
    }

    jQuery(document).on('click', '.p-details', function (event)
    {
        event.preventDefault();
        var id = $(this).attr('data-id');
        $('.fancy_open_' + id).trigger("click");
    });

</script>