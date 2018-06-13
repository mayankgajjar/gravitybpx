<style>
    .table-head{
        text-align: center;
        background-color: #45b6af;
    }
</style>
<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $breadcrumb ?>
        </li>
    </ol>
</div>
<div class="container">
    <form action="" method="post" name="cart_list" id="cart_list" onsubmit="remove_list_data(event)">
        <div class="cart">
            <div class="row">
                <div class="col-sm-8">
                    <label><b>Agent Name : </b></label>
                    <label> <?php echo $result['fname'].' '.$result['lname']; ?></label>
                </div>
                <div class="col-sm-4">
                    <label><b>Transaction Date : </b></label>
                    <label><?php echo date('d-m-Y', strtotime($result['created'])); ?></label>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <label><b>Transaction ID : </b></label>
                    <label><?php echo $result['transaction_id']; ?></label>
                </div>
                <div class="col-sm-4">
                    <label><b>Payment By : </b></label>
                    <label>Stripe</label>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class='table-head'><?php echo 'Item Description' ?></th>
                        <th class='table-head'><?php echo 'Quantity' ?></th>
                        <th class='table-head'><?php echo 'Item Price' ?></th>
                        <th class='table-head'><?php echo 'Sub-Total' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grand_total = 0; ?>
                    <?php if (isset($result)) :  ?>
                    <?php $item = unserialize($result['item_desc']); ?>

                        <tr>
                            <td><?php
                                if($item['ltype'] == '2to30') {
                                    echo '<b>Medicare Supplement 2 To 30 Days Old</b>';
                                } elseif ($item['ltype'] == '31to85') {
                                    echo '<b>Medicare Supplement 31 To 85 Days Old</b>';
                                } elseif ($item['ltype'] == '86to365') {
                                    echo '<b>Medicare Supplement 86 To 365 Days Old</b>';
                                }elseif ($item['ltype'] == '366+') {
                                    echo '<b>Medicare Supplement 366 or More Days Old</b>';
                                }
                            ?>
                            <br><br>
                                <b>States </b>=
                                <?php
                                if ($item['filter_by_state'] == 'all') {
                                    echo "All";
                                } else {
                                    echo $item['state_code'];
                                }
                                ?>
                                <br>
                                <b>Consumer Age Minimum (Years)</b> =  <?= $item['min_age']; ?>
                                <br>
                                <b>Consumer Age Maximum (Years)</b> =  <?= $item['max_age']; ?>
                                <br>
                                <?php
                                $options = unserialize(LEADSTORE_FILTER_PHONE_OPTIONS);
                                $key_data = array_search($item['cell_phone_land_line'], $options);
                                ?>
                                <b>Cell phone and/or Land Line</b> =  <?= $key_data; ?>
                                <br>
                                <b>Filter By Area Code</b> =  <?= $item['filter_by_area_code']; ?>
                                <br>
                                <b>Filter By Zip Code</b> =  <?= $item['filter_by_zip_code']; ?>
                            </td>
                            <td><?= $result['qty'] ?></td>
                            <td><?= formatMoney($result['item_price'], 2, true); ?></td>
                            <?php $grand_total = $grand_total + $result['total_price']; ?>
                            <td><?= formatMoney($result['total_price'], 2, true); ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">No Product Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right"><?php echo 'Total' ?></th>
                        <td class="grand-total"><?= formatMoney($grand_total, 2, true); ?></td>
                    </tr>
                </tfoot>
            </table>
            <!--<button type="submit" class="btn btn-danger remove_items">Remove Items</button>
            <button type="button" class="btn btn-info" onclick="location.href = '<?= site_url("storecheckout/checkout") ?>'">Checkout</button>
            <a href="<?= base_url('storecheckout/continue_shop') ?>" class="btn btn-info">Continue Shopping</a> -->
        </div>
    </form>
</div>
<script type="text/javascript">
    jQuery('#leadstr').addClass('open');
    function remove_list_data(e) {
        e.preventDefault();
        $.post("<?= base_url('Storecheckout/remove_item_list') ?>", $("#cart_list").serialize(), function (data) {
            $.ajax({
                url: '<?= base_url('Storecheckout/ajax_cart') ?>',
                method: 'post',
                success: function (data) {
                    $('#cart-table').html(data);
                }
            });
        });
    }
</script>