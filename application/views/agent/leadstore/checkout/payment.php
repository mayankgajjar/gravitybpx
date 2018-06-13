<style>
    .cart-box{margin-top: 40px;}
    #checkout .btn{width: 150px;}
    #checkout  .form-actions{background-color: transparent;}
    .form-body .title-form h2{text-align: center;margin-bottom: 30px;}
    .cart-box .table>thead:first-child>tr:first-child>th {background: #45b6af;}
    .last-error .help-block{position: relative;top: 16px;}
</style>
<div class="payment-wapper">
    <div class="page-bar">
        <div class="breadcrumbs">
            <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
                <li class="active">
                    <?php echo 'Checkout'; ?>
                </li>
            </ol>
        </div>
    </div>
    <?php if (validation_errors() != ''): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success') != ''): ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error') != ''): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-sm-8">
            <div class="portlet-body form">
                <form class="form-horizontal" action="" id="checkout" method="POST" >
                    <div class="dis">
                        <div class="text-block-detais">
                        </div>
                        <div class="payment-icon">
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-body">
                            <div class="title-form">
                                <h2>Card Information</h2>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Card Number
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="card_number" value="<?php //echo $lead->phone;                          ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Expiration Month
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <select name="card_expiration_month" id="card_expiration_month" class="form-control">
                                        <option value="">Select Card Expiration Month</option>
                                        <option value="1">01 - January</option>
                                        <option value="2">02 - February</option>
                                        <option value="3">03 - March</option>
                                        <option value="4">04 - April</option>
                                        <option value="5">05 - May</option>
                                        <option value="6">06 - June</option>
                                        <option value="7">07 - July</option>
                                        <option value="8">08 - August</option>
                                        <option value="9">09 - September</option>
                                        <option value="10">10 - October</option>
                                        <option value="11">11 - November</option>
                                        <option value="12">12 - December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Expiration Year (YYYY):
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <select name="card_expiration_year" class="form-control">
                                        <option value="">Select Card Expiration Year</option>
                                        <?php foreach ($year as $y): ?>
                                            <option value="<?= $y ?>"><?= $y ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">CVV2/CID:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="card_security_code" value="<?php //echo $lead->phone;                          ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="last-error">
                                        <input type="checkbox" name="buyer_terms_agreement_credit_card" id="buyer_terms_agreement_credit_card" value="" style="vertical-align: middle;">
                                        <label for="buyer_terms_agreement_credit_card" style="vertical-align: middle;position: absolute;margin-left: 5px;" class="user_agree"> By clicking here your agreement and acceptance to the
                                            <a href="#"> Terms and Conditions and Lead Purchase Agreement </a>as last updated 11/09/2015 are hereby acknowledged.
                                        </label>
                                    </div>
                                    <input type="hidden" value="" name="card_type">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-4 col-md-8">
                                    <button class="btn green" type="submit">Pay</button>
                                    <a class="btn" href="<?= base_url('leadstore/index') ?>">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-4 cart-box">
            <div class="form-body">
                <div class="title-form">
                    <h2>Cart</h2>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><?php echo 'File Name' ?></th>
                        <th><?php echo 'Item Description' ?></th>
                        <th><?php echo 'Item Price' ?></th>
                        <th><?php echo 'Quantity' ?></th>
                        <th><?php echo 'Sub-Total' ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grand_total = 0; ?>
                    <?php if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) : ?>
                        <?php foreach ($this->session->userdata('lead_cart') as $key => $cart_data) : ?>
                            <tr class="item_list_<?= $key ?>">
                                <td><?= $cart_data['filename'] ?></td>
                                <td><?= $lead_type[$cart_data['ltype']]['name'] ?>
                                    <!-- <br><br>
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
                                    <b>Filter By Zip Code</b> =  <?= $cart_data['filter_by_zip_code']; ?> -->
                                </td>
                                <td><?= formatMoney($cart_data['lead_price'], 2, true); ?></td>
                                <td><?= $cart_data['quantity'] ?></td>
                                <?php $grand_total = $grand_total + $cart_data['sub_total']; ?>
                                <td class="sub_total_<?= $key ?>"><?= formatMoney($cart_data['sub_total'], 2, true); ?></td>
                            </tr>
                        <?php endforeach; ?>
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


        </div>
    </div>
    <!--<div class="form-body">
        <div class="row">
            <div class="form-actions">
                <div class="col-md-offset-4 col-md-8">
                    <button class="btn green" type="submit">Pay</button>
                    <a class="btn" href="<?= base_url('leadstore/index') ?>">Cancel</a>
                </div>
            </div>
        </div>
    </div> -->
</div>
<script>
    $('document').ready(function () {
        $.ajax({
            url: '<?= base_url('Storecheckout/ajax_cart') ?>',
            method: 'post',
            success: function (data) {
                $('#cart-table').html(data);
            }
        });
    });
    $('input[name=card_number]').keyup(function () {

        //start without knowing the credit card type
        var result = "";
        var accountNumber = $('input[name=card_number]').val();
        //first check for MasterCard
        if (/^5[1-5]/.test(accountNumber))
        {
            result = "MasterCard";
        }

        //then check for Visa
        else if (/^4/.test(accountNumber))
        {
            result = "VISA";
        }

        //then check for AmEx
        else if (/^3[47]/.test(accountNumber))
        {
            result = "AmEx";
        }
        console.log(result);
        $("input[name=card_type]").val(result);
        // return result;

    });
    jQuery('#checkout').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            card_number: {
                required: true,
                number: true,
                minlength: 16,
                maxlength: 16
            },
            card_expiration_month: {
                required: true
            },
            card_expiration_year: {
                required: true
            },
            card_security_code: {
                required: true,
                number: true,
                minlength: 3,
                maxlength: 4
            },
            buyer_terms_agreement_credit_card: {
                required: true
            },
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.attr('name') == 'buyer_terms_agreement_credit_card') {
                error.insertAfter(".user_agree");
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },
    });
    $('[name="country"]').change(function () {
        var cid = $(this).val();
        $.ajax({
            url: 'agent/manage_state/getByCountryId/' + cid,
            method: 'get',
            success: function (str) {
                $('#state_list').html(str);
                $('#city_list').html('');
            }
        });
    });
    $('[name="country"]').trigger('change');
    setTimeout(function () {
        $('[name="state"]').val('<?php echo $this->session->userdata('agent')->sid; ?>');
        $('[name="state"]').trigger('change');
        $('[name="city"]').val('<?php echo $this->session->userdata('agent')->city_id; ?>');
    }, 2000);
    $('[name="state"]').change(function () {
        var sid = $(this).val();
        $.ajax({
            url: 'agent/manage_city/getByStateId/' + sid,
            method: 'get',
            success: function (str) {
                $('#city_list').html(str);
            }
        });
    });
</script>