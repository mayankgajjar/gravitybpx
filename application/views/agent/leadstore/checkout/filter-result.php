<style>
    .help-block{
        color: red;
    }
    #qty-error{
        color: red;
    }
</style>
<div class="info">
    <h3><?php echo 'Selected Filters' ?></h3>
    <table class="table table-striped">
        <tbody>
            <tr>
                <th class="text-right"><?php echo 'Lead Type' ?></th>
                <td><?php echo $lead_type[$post['ltype']]['name'] ?></td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'States' ?></th>
                <td>
                    <?php if (!isset($post['filter_by_state']) && !isset($post['state_code'])) : ?>
                        <?php echo 'State Not Select'; ?>
                    <?php else : ?>
                        <?php if (isset($post['filter_by_state']) && $post['filter_by_state'] == 'all'): ?>
                            <?php echo $post['filter_by_state']; ?>
                        <?php else: ?>
                            <?php echo implode(',', $post['state_code']) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'Consumer Age Minimum (Years)' ?></th>
                <td><?php echo $post['min_age'] ?></td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'Consumer Age Maximum (Years)' ?></th>
                <td><?php echo $post['max_age'] ?></td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'Cell phone and/or Land Line' ?></th>
                <td>
                    <?php $options = unserialize(LEADSTORE_FILTER_PHONE_OPTIONS); ?>
                    <?php $key = array_search($post['cell_phone_land_line'], $options) ?>
                    <?php echo $key ?>
                </td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'Filter By Area Code' ?></th>
                <td style="word-break: break-all;">
                    <?php if ($post['filter_by_area_code'] == 'filter_area_include' || $post['filter_by_area_code'] == 'filter_area_exclude'): ?>
                        <?php echo $post['filter_by_area_codes'] ?>
                    <?php else: ?>
                        <?php echo $post['filter_by_area_code'] ?>
                    <?php endif; ?>

                </td>
            </tr>
            <tr>
                <th class="text-right"><?php echo 'Filter By Zip Code' ?></th>
                <td>
                    <?php if ($post['filter_by_zip_code'] == 'YES'): ?>
                        <?php echo $post['filter_by_zip_codes'] ?>
                    <?php else: ?>
                        <?php echo $post['filter_by_zip_code'] ?>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center">
        <button type="button" class="btn green" onclick="changeFilter()">
            <?php echo 'Change Filters' ?>
        </button>
    </div>
</div>
<hr />
<form action="<?= base_url('storecheckout/add_to_cart_lead') ?>" name="lead_add_to_cart" method="post" id="lead_add_to_cart">
    <input type="hidden" name="ltype" value="<?= $post['ltype'] ?>">
    <input type="hidden" name="filter_by_state" value="<?php
    if (isset($post['filter_by_state']) && $post['filter_by_state'] == 'all') {
        echo $post['filter_by_state'];
    }
    ?>">
           <?php if (isset($post['state_code'])) { ?>
        <input type="hidden" name="state_code" value="<?= implode(',', $post['state_code']); ?>">
    <?php } ?>
    <input type="hidden" name="category" value="<?= $post['category'] ?>">
    <input type="hidden" name="min_age" value="<?= $post['min_age'] ?>">
    <input type="hidden" name="max_age" value="<?= $post['max_age'] ?>">
    <input type="hidden" name="filter_by_area_code" value="<?= $post['filter_by_area_code'] ?>">
    <?php if ($post['filter_by_area_code'] == 'filter_area_include' || $post['filter_by_area_code'] == 'filter_area_exclude'): ?>
        <input type="hidden" name="filter_by_area_codes" value="<?= $post['filter_by_area_codes'] ?>">
    <?php endif; ?>

    <input type="hidden" name="filter_by_zip_code" value="<?= $post['filter_by_zip_code'] ?>">
    <input type="hidden" name="filter_by_zip_codes" value="<?php echo  isset($post['filter_by_zip_codes']) ? $post['filter_by_zip_codes'] : '' ?>" />
    <input type="hidden" name="cell_phone_land_line" value="<?= $post['cell_phone_land_line'] ?>">
    <input type="hidden" name="total_avail_lead" value="<?= $filterData['Total'] ?>">
    <div class="quantity-box">
        <h3><?php echo 'Number of Matching Leads' ?></h3>
        <table class="table table-striped">
            <tr>
                <th><?php echo 'Quantity Available' ?></th>
                <td><?php echo $filterData['Total'] ?></td>
            </tr>
            <tr>
                <th><?php echo 'Enter Quantity To add' ?></th>
                <td style="border-bottom: none !important;"><input type="text" name="quantity" id="quantity" /> </td>
            </tr>
            <tr>
                <th></th>
                <td><span id="qty-error"></span></td>
            </tr>
        </table>
        <div class="row">
            <div class="text-left col-md-6">
                <button type="button" id="saveFilter" class="btn green" onclick="saveFilter()">
                    <?php echo 'Save Filters' ?>
                </button>
            </div>
            <div class="text-right col-md-6">
                <input type="submit" class="btn green" name="submit" value="Add Leads To Cart" >
            </div>
        </div>
        <br/><br/>
        <div class="filter-msg">

        </div>
    </div>
</form>
<script type="text/javascript">
    function changeFilter() {
        jQuery('.filter-result').hide();
        jQuery('.tabbable-custom').show();
    }

    function saveFilter() {
        var postData = <?php echo json_encode($post); ?>;
        postData.is_ajax = true;
        postData.filter_id = jQuery('#filter_id').val();
        jQuery('#saveFilter').addClass('disabled');
        jQuery.ajax({
            url: '<?php echo site_url('storecheckout/saveFilter') ?>',
            method: 'post',
            dataType: 'json',
            data: postData,
            success: function (result) {
                console.log(result);
                var flag = Boolean(result.success);
                if (flag) {
                    jQuery('#filter_id').val(result.data);
                }
                jQuery('.filter-msg').html(result.html);
                jQuery('#saveFilter').removeClass('disabled');
            }
        });
    }

    /* ---------------- Max and Min value allow Qty--------------------*/
    $('#quantity').keyup(function () {
        var total_lead = <?= $filterData['Total'] ?>;
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value > total_lead) {
            $("#qty-error").html('You entered more leads than are available.');
            this.value = total_lead;
        } else {
            $("#qty-error").html('');
        }
    });
    /* ---------------- End Max and Min value allow Qty--------------------*/


    jQuery('#lead_add_to_cart').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            quantity: {
                required: true,
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
</script>