<a class="chat-head phone-<?= $phone_no ?>" href="javascript:;" data-phone="<?= $phone_no ?>" title="<?php echo($leadname != '') ? $leadname : $phone_no; ?> ">
</a>
<script>
    $(document).ready(function () {
        $('.chat-head').addClass('animate');
        var numItems = $('.chat-head').length - 1;
        var phoneno = $('.chat-head').last().data('phone');
        var leftpos = 30 + (90 * numItems);
        $('.phone-' + phoneno).css('left', leftpos);
    });

    $(".chat-head").click(function () {
        jQuery('.dialer-chatbox-wrapper').css('display','block');
        $('#phone_num').val($(this).data('phone'));
        var phone = '1' + $(this).data('phone');
        searchLeadSMS(phone);
        $(this).remove();
        reposition_bubble();

    });

    function reposition_bubble() {
        $(".chat-head").each(function (key, index) {
            var strCls = $(this).attr('class');
            var clsname = strCls.split(' ');
            var leftpos = 30 + (90 * key);
            $('.' + clsname[1]).css('left', leftpos);
        });
    }
</script>