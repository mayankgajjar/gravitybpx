<?php
    $ci =& get_instance();
    $method = $ci->router->method;
?>
<ul class="nav nav-tabs ">
    <li id="campaignedit">
        <a href="<?php echo site_url('dialer/campaign/campaignedit/'. encode_url($campaign->campaign_id)) ?>"> <?php echo "Campaign View" ?> </a>
    </li>
<!--    <li id="campaigndetail">
        <a href="<?php echo site_url('dialer/campaign/campaigndetail/'. encode_url($campaign->id)) ?>"> <?php echo "Detail View" ?> </a>
    </li>-->
    <li id="statusedit">
        <a href="<?php echo site_url('dialer/campaign/statusedit/'.encode_url($campaign->campaign_id)) ?>"><?php echo "Statuses" ?> </a>
    </li>
<!--    <li id="hotkeyedit">
        <a href="<?php echo site_url('dialer/campaign/hotkeyedit/'.  encode_url($campaign->id)); ?>"> <?php echo 'Hotkeys'; ?> </a>
    </li>-->
<!--    <li id="leadedit">
        <a href="<?php echo site_url('dialer/campaign/leadedit/'.  encode_url($campaign->id)); ?>"> <?php echo 'Lead Recycle'; ?> </a>
    </li>-->
    <li id="autoaltedit">
        <a href="<?php echo site_url('dialer/campaign/autoaltedit/'.  encode_url($campaign->campaign_id)); ?>"> <?php echo 'Auto Alt Dial'; ?> </a>
    </li>
<!--<li id="listmixedit">
        <a href="<?php echo site_url('dialer/campaign/listmixedit/'.  encode_url($campaign->id)); ?>"> <?php echo 'List Mix'; ?> </a>
    </li>-->
<!--    <li id="codeedit">
        <a href="<?php echo site_url('dialer/campaign/codeedit/'.  encode_url($campaign->id)); ?>"><?php echo 'Pause Codes'; ?> </a>
    </li>-->
<!--    <li id="presetedit">
        <a href="<?php echo site_url('dialer/campaign/presetedit/'.  encode_url($campaign->id)); ?>"> <?php echo 'Presets'; ?> </a>
    </li>-->
<!--    <li id="accidedit">
        <a href="<?php echo site_url('dialer/campaign/accidedit/'.  encode_url($campaign->id)); ?>"> <?php echo 'AC-CID'; ?> </a>
    </li>-->
</ul>
<script type="text/javascript">
jQuery(function(){
    jQuery('#<?php echo $method ?>').addClass('active');
    jQuery('#<?php echo $method ?>').find('a').attr('href','#');
});
</script>