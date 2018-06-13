<?php if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) : ?>
<div class="cart">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php echo 'select' ?></th>
                <th><?php echo 'Quantity' ?></th>
                <th><?php echo 'Item Description' ?></th>
                <th><?php echo 'File Name' ?></th>
                <th><?php echo 'Item Price' ?></th>
                <th><?php echo 'Sub-Total' ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $grand_total = 0; ?>
                <?php $orderCounter = 1; ?>
                <?php foreach ($this->session->userdata('lead_cart') as $key => $cart_data) : ?>
                    <tr class="item_list_<?= $key ?>">
                        <td><input type="checkbox" name="cart_id[]" class="item_list" value="<?= $key ?>"></td>
                        <td><?= $cart_data['quantity'] ?></td>
                        <td><?= $lead_type[$cart_data['ltype']]['name'] ?>
                            <br><br>
                            <b>States </b>=
                            <?php
                            if ($cart_data['filter_by_state'] == 'all') {
                                echo "All";
                            } else {
                                echo $cart_data['state_code'];
                            }
                            ?>
                            <br>
                            <b>Consumer Age Minimum (Years)</b> =  <?= $cart_data['min_age']; ?>
                            <br>
                            <b>Consumer Age Maximum (Years)</b> =  <?= $cart_data['max_age']; ?>
                            <br>
                            <?php
                            $options = unserialize(LEADSTORE_FILTER_PHONE_OPTIONS);
                            $key_data = array_search($cart_data['cell_phone_land_line'], $options);
                            ?>
                            <b>Cell phone and/or Land Line</b> =  <?= $key_data; ?>
                            <br>
                            <b>Filter By Area Code</b> =  <?= $cart_data['filter_by_area_code']; ?>
                            <br>
                            <b>Filter By Zip Code</b> =  <?= $cart_data['filter_by_zip_code']; ?>
                        </td>
                        <td><input type="text" placeholder="GravityBPX Leads" value="<?php echo(isset($cart_data['filename'])) ? $cart_data['filename'] : 'GravityBPX Leads'; ?>" name="file_name" data-couter="<?php echo $orderCounter; ?>" class="file_name"></td>
                        <td><?= formatMoney($cart_data['lead_price'], 2, true); ?></td>
                        <?php $grand_total = $grand_total + $cart_data['sub_total']; ?>
                        <td class="sub_total_<?= $key ?>"><?= formatMoney($cart_data['sub_total'], 2, true); ?></td>
                    </tr>
                    <?php $orderCounter = $orderCounter + 1; ?>
                <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right"><?php echo 'Total' ?></th>
                <td class="grand-total"><?= formatMoney($grand_total, 2, true); ?></td>
            </tr>
        </tfoot>
    </table>
    <button type="submit" class="btn btn-danger remove_items">Remove Items</button>
    <button type="button" class="btn btn-info checkout" id="checkout" data-checkout="checkout" onclick="cartCheckout('checkout');">Checkout</button>
    <button type="button" class="btn btn-info" id="continue" data-checkout="continue" onclick="cartCheckout('continue');">Continue Shopping</button>
</div>
<?php else : ?>
 <h4>Cart Is Empty, Please Go To leads Store By <a href="<?= base_url('storecheckout/continue_shop'); ?>">Click Here</a> </h4>
<?php endif; ?>