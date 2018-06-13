<?php if(count($campaigns) > 0): ?>
<select class="form-control" name="campaign_id" id="campaign_id">
    <?php foreach($campaigns as $campaign): ?>
    <option value="<?php echo encode_url($campaign->campaign_id) ?>" <?php echo $campaign->campaign_id == $cId ? 'selected="selected"':''; ?>><?php echo $campaign->campaign_id.' - '.$campaign->campaign_name ?></option>
    <?php endforeach; ?>
</select>
<?php else: ?>
<p id="campaign_id"><?php echo 'No campaigns find in agency.' ?></p>
<?php endif; ?>

