<style>
    #cart-table table tbody tr td:nth-child(3) {
        word-break: break-all;
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
<div class="container">
    <form action="" method="post" name="cart_list" id="cart_list" onsubmit="remove_list_data(event)">
        <?php if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0): ?>
            <div class="ajax-cart" id="cart-table"> </div>
        <?php else: ?>
            <div class="empy-cart"><h4>Cart Is Empty, Please Go To leads Store By <a href="<?= base_url('storecheckout/continue_shop'); ?>">Click Here</a> </h4></div>
        <?php endif; ?>
    </form>
</div>
<script type="text/javascript">
    jQuery('#leadstr').addClass('open');
    $('document').ready(function () {
        $.ajax({
            url: '<?= base_url('Storecheckout/ajax_cart') ?>',
            method: 'post',
            success: function (data) {
                $('#cart-table').html(data);
            }
        });
    });
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
    function cartCheckout(btn) {
        jsonObj = [];
        var fileName = "";
        var reqType = "";
        reqType = jQuery('#' + btn).attr('data-checkout');
        $('.file_name').each(function () {
            fileName = "";
            fileName = $(this).val();
            if (fileName === "") {
                fileName = "GravityBPX Leads";
            }
            temp = {}
            temp["order_couter"] = $(this).data('couter');
            temp["file_name"] = fileName;
            temp["req_type"] = reqType;
            jsonObj.push(temp);
        });
        jsonString = JSON.stringify(jsonObj);
        $.ajax({
            url: 'storecheckout/filename',
            method: 'post',
            data: {items: jsonString},
            success: function (data) {
                console.log(data);
                if (data == 'checkout') {
                    window.location.href = "<?= site_url('storecheckout/checkout'); ?>";
                } else if (data == 'continue') {
                    window.location.href = "<?= site_url('storecheckout/continue_shop'); ?>";
                } else if (data == 'true') {
                    window.location.href = "<?= site_url('storecheckout/checkout'); ?>";
                }
            }
        });
    }
</script>