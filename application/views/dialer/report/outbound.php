<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="tool-box"></div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post"  >
            <input type="hidden" name="agent_hours" VALUE="<?php echo isset($postData['agent_hours']) ? $postData['agent_hours'] : ''; ?>" />
            <input type="hidden" name="outbound_rate" VALUE="<?php echo isset($postData['outbound_rate']) ? $postData['outbound_rate'] : ''; ?>" />
            <input type="hidden" name="costformat" VALUE="<?php echo isset($postData['costformat']) ? $postData['costformat'] : ''; ?>" />
            <input type="hidden" name="print_calls" VALUE="<?php echo isset($postData['print_calls']) ? $postData['print_calls'] : ''; ?>" />
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Dates' ?>: </label>
                            <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="query_date" value="<?php echo isset($postData['query_date']) ? $postData['query_date'] :  date('m/d/Y') ?>">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo isset($postData['end_date']) ? $postData['end_date'] : date('m/d/Y') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo "Campaigns" ?>: </label>
                            <?php
                                $groups = isset($postData['group']) && count($postData['group']) > 0 ? $postData['group'] : array();
                                $selected = '';
                                if(in_array('--ALL--', $groups)){
                                    $selected = 'selected = "selected"';
                                }
                            ?>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency') : ?>
                                    <select multiple="" name="group[]" class="form-control" id="group" onkeyup="LoadLists(this.form.group)" onblur="LoadLists(this.form.group)" onmouseup="LoadLists(this.form.group)">
                                        <?php foreach($campaigns as $campaign): ?>
                                            <?php
                                                $selected = '';
                                                if(in_array($campaign->campaign_id, $groups)){
                                                    $selected = 'selected="selected"';
                                                }
                                            ?>
                                            <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?> <?php echo (!isset($postData['group'])) && count($postData['group']) == 0 ? 'selected="selected"':''; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            <?php else: ?>
                                    <select multiple="" name="group[]" class="form-control" id="group" onkeyup="LoadLists(this.form.group)" onblur="LoadLists(this.form.group)" onmouseup="LoadLists(this.form.group)">
                                        <option value="--ALL--" <?php echo $selected ?>><?php echo '-- ALL CAMPAIGNS --' ?></option>
                                        <?php foreach($campaigns as $campaign): ?>
                                            <?php
                                                $selected = '';
                                                if(in_array($campaign->campaign_id, $groups)){
                                                    $selected = 'selected="selected"';
                                                }
                                            ?>
                                            <option value="<?php echo $campaign->campaign_id ?>" <?php echo $selected; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Lists' ?>: <span>(optional, possibly slow)</span></label>
                            <?php
                                $list_ids = isset($postData['list_ids']) && count($postData['list_ids']) > 0 ? $postData['list_ids'] : array();
                                $selected = '';
                                if(in_array('--ALL--', $list_ids)){
                                    $selected = 'selected="selected"';
                                }
                            ?>
                            <select multiple="" name="list_ids[]" id="list_ids" class="form-control">
                                <option value="--ALL--" <?php echo $selected ?>><?php echo '--ALL LISTS--' ?></option>
                                <?php foreach($lists as $list): ?>
                                <?php
                                    $selected = '';
                                    if(in_array($list->list_id, $list_ids)){
                                        $selected = 'selected="selected"';
                                    }
                                ?>
                                <option value="<?php echo $list->list_id ?>" <?php echo $selected ?>><?php echo $list->list_id.' - '.$list->list_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Include Drop Rollover' ?>:</label>
                            <select name="include_rollover" id="include_rollover" class="form-control">
                                <option value="<?php echo 'YES' ?>" <?php echo optionSetValue('YES', isset($postData['include_rollover']) ? $postData['include_rollover'] : '' ) ?>><?php echo 'YES' ?></option>
                                <option value="<?php echo 'NO' ?>" <?php echo optionSetValue('NO', isset($postData['include_rollover']) ? $postData['include_rollover'] : '' ) ?>><?php echo 'NO' ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Bottom Graph' ?>:</label>
                            <select name="bottom_graph" id="bottom_graph" class="form-control">
                                <option value="<?php echo 'YES' ?>" <?php echo optionSetValue('YES', isset($postData['bottom_graph']) ? $postData['bottom_graph'] : '' ) ?>><?php echo 'YES' ?></option>
                                <option value="<?php echo 'NO' ?>" <?php echo optionSetValue('NO', isset($postData['bottom_graph']) ? $postData['bottom_graph'] : '' ) ?>><?php echo 'NO' ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Carrier Stats' ?>:</label>
                            <select name="carrier_stats" id="carrier_stats" class="form-control">
                                <option value="<?php echo 'YES' ?>" <?php echo optionSetValue('YES', isset($postData['carrier_stats']) ? $postData['carrier_stats'] : '' ) ?>><?php echo 'YES' ?></option>
                                <option value="<?php echo 'NO' ?>" <?php echo optionSetValue('NO', isset($postData['carrier_stats']) ? $postData['carrier_stats'] : '' ) ?>><?php echo 'NO' ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Display as' ?>:</label>
                            <select name="report_display_type" id="report_display_type" class="form-control">
                                <option value="<?php echo 'TEXT' ?>" <?php echo optionSetValue('TEXT', isset($postData['report_display_type']) ? $postData['report_display_type'] : '' ) ?>><?php echo 'TEXT' ?></option>
                                <option value="<?php echo 'HTML' ?>" <?php echo optionSetValue('HTML', isset($postData['report_display_type']) ? $postData['report_display_type'] : '' ) ?>><?php echo 'HTML' ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label><?php echo 'Shift' ?>:</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value=""><?php echo '--' ?></option>
                                <option value="<?php echo 'AM' ?>" <?php echo optionSetValue('AM', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'AM' ?></option>
                                <option value="<?php echo 'PM' ?>" <?php echo optionSetValue('PM', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'PM' ?></option>
                                <option value="<?php echo 'ALL' ?>" <?php echo optionSetValue('ALL', isset($postData['shift']) ? $postData['shift'] : '' ) ?>><?php echo 'ALL' ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="submit">Submit</button>
                        <!--button type="button" class="btn btn-circle grey-salsa btn-outline">Cancel</button-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
var list_id_ary = [];
var list_name_ary = [];
var campaign_id_ary = [];
<?php foreach($lists as $list): ?>
    list_id_ary.push('<?php echo $list->list_id ?>');
    list_name_ary.push('<?php echo $list->list_name ?>');
    campaign_id_ary.push('<?php echo $list->campaign_id ?>');
<?php endforeach; ?>
    console.log(list_id_ary);
    console.log(list_name_ary);
    console.log(campaign_id_ary);
jQuery(function(){
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
});
function LoadLists(FromBox) {
    if (!FromBox) {alert("NO"); return false;}
    var selectedCampaigns="|";
    var selectedcamps = new Array();
    jQuery('#group option').each(function(){
        if ( jQuery(this).is(':selected')) {
            selectedCampaigns += jQuery(this).val()+"|";
        }
    });
    document.getElementById('list_ids').options.length=0;
    var new_list = new Option();
    new_list.value = "--ALL--";
    new_list.text = "--<?php echo "ALL LISTS"; ?>--";
    document.getElementById('list_ids')[0] = new_list;

    list_id_index=1;
    for (j=0; j<campaign_id_ary.length; j++) {
        var campaignID="/\|"+campaign_id_ary[j]+"\|/g";
        var campaign_matches = selectedCampaigns.match(campaignID);
        if (campaign_matches) {
            var new_list = new Option();
            new_list.value = list_id_ary[j];
            new_list.text = list_id_ary[j]+" - "+list_name_ary[j];
            document.getElementById('list_ids')[list_id_index] = new_list;
            list_id_index++;
        }
    }
}
</script>
<?php if($succees == TRUE): ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"><?php echo "Result"; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <?php echo $costformat_text ?>
        <?php echo $output ?>
        <?php echo $time_stat ?>
        <?php echo $end; ?>
    </div>
    <script type="text/javascript">
        jQuery(function(){
           DrawCSSGraph('CALLS', '1');
           DrawAGENTGraph('CALLS', '1');
        });
        function DrawCSSGraph(graph, th_id){
            var CALLS_graph= "<?php echo $CALLS_graph ?>";
            var TOTALTIME_graph= "<?php echo $TOTALTIME_graph ?>";
            var AVGTIME_graph= "<?php echo $AVGTIME_graph ?>";
            var CALLSHOUR_graph= "<?php echo $CALLSHOUR_graph ?>";
            var CALLSHOUR_agent_graph= "<?php echo $CALLSHOUR_agent_graph ?>";
            for (var i=1; i<=5; i++) {
                var cellID = "cssgraph"+i;
                document.getElementById(cellID).style.backgroundColor='#DDDDDD';
            }
            var cellID = "cssgraph" + th_id;
            document.getElementById(cellID).style.backgroundColor='#999999';
            var graph_to_display = eval(graph+"_graph");
            document.getElementById('call_status_stats_graph').innerHTML = graph_to_display;
        }
        function DrawAGENTGraph(graph, th_id){
            var CALLS_graph="<?php echo $ACALLS_graph ?>";
            var TOTALTIME_graph="<?php echo $ATOTALTIME_graph ?>";
            var AVGTIME_graph= "<?php echo $AAVGTIME_graph ?>";
            for (var i=1; i<=3; i++) {
                var cellID= "AGENTgraph"+i;
                document.getElementById(cellID).style.backgroundColor='#DDDDDD';
            }
            var cellID ="AGENTgraph"+th_id;
            document.getElementById(cellID).style.backgroundColor='#999999';
            var graph_to_display = eval(graph+"_graph");
            document.getElementById('agent_stats_graph').innerHTML=graph_to_display;
        }
    </script>
</div>
<?php endif; ?>