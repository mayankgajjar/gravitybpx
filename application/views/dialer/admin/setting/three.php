<div class="form-body">
	<div class="form-group">
	    <label class="col-md-3 control-label"><?php echo "Enable QueueMetrics Logging"; ?></label>
	    <div class="col-md-4">
		    <select class="form-control" name="enable_queuemetrics_logging">
		        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('enable_queuemetrics_logging')) ?>><?php echo 'Yes - 1' ?></option>
		        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('enable_queuemetrics_logging')) ?>><?php echo 'No - 0' ?></option>
		    </select>
	    </div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Server IP"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_server_ip" value="<?php echo get_dialer_option('queuemetrics_server_ip'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics DB Name"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_dbname" value="<?php echo get_dialer_option('queuemetrics_dbname'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics DB Login"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_login" value="<?php echo get_dialer_option('queuemetrics_login'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics DB Password"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_pass" value="<?php echo get_dialer_option('queuemetrics_pass'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics URL"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_url" value="<?php echo get_dialer_option('queuemetrics_url'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Log ID"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_log_id" value="<?php echo get_dialer_option('queuemetrics_log_id'); ?>" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics EnterQueue Prepend"; ?></label>
		<div class="col-md-4">
			<select class="form-control" name="queuemetrics_eq_prepend">
				<option value="NONE" <?php echo optionSetValue("NONE",get_dialer_option('queuemetrics_eq_prepend')) ?>><?php echo "NONE" ?></option>
				<option value="lead_id" <?php echo optionSetValue("lead_id",get_dialer_option('queuemetrics_eq_prepend')) ?>>lead_id</option>
				<option value="list_id" <?php echo optionSetValue("list_id",get_dialer_option('queuemetrics_eq_prepend')) ?>>list_id</option>
				<option value="source_id" <?php echo optionSetValue("source_id",get_dialer_option('queuemetrics_eq_prepend')) ?>>source_id</option>
				<option value="vendor_lead_code" <?php echo optionSetValue("vendor_lead_code",get_dialer_option('queuemetrics_eq_prepend')) ?>>vendor_lead_code</option>
				<option value="address3" <?php echo optionSetValue("address3",get_dialer_option('queuemetrics_eq_prepend')) ?>>address3</option>
				<option value="security_phrase" <?php echo optionSetValue("security_phrase",get_dialer_option('queuemetrics_eq_prepend')) ?>>security_phrase</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Login-Out"; ?></label>
		<div class="col-md-4">
			<select class="form-control" name="queuemetrics_loginout">
				<option value="STANDARD" <?php echo optionSetValue("STANDARD",get_dialer_option('queuemetrics_loginout')) ?>>STANDARD</option>
				<option value="CALLBACK" <?php echo optionSetValue("CALLBACK",get_dialer_option('queuemetrics_loginout')) ?>>CALLBACK</option>
				<option value="NONE" <?php echo optionSetValue("NONE",get_dialer_option('queuemetrics_loginout')) ?>>NONE</option>
			</select>
		</div>
	</div>
	 <div class="form-group">
	    <label class="col-md-3 control-label"><?php echo "QueueMetrics CallStatus"; ?></label>
	    <div class="col-md-4">
	    <select class="form-control" name="queuemetrics_callstatus">
	        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('queuemetrics_callstatus')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('queuemetrics_callstatus')) ?>><?php echo 'No - 0' ?></option>
	    </select>
	    </div>
	 </div>	
	 <div class="form-group">
	    <label class="col-md-3 control-label"><?php echo "QueueMetrics Addmember Enabled"; ?></label>
	    <div class="col-md-4">
	    <select class="form-control" name="queuemetrics_addmember_enabled">
	        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('queuemetrics_addmember_enabled')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('queuemetrics_addmember_enabled')) ?>><?php echo 'No - 0' ?></option>
	    </select>
	    </div>
	 </div>		 
	 <div class="form-group">
	    <label class="col-md-3 control-label"><?php echo "QueueMetrics Pause Type Logging"; ?></label>
	    <div class="col-md-4">
	    <select class="form-control" name="queuemetrics_pause_type">
	        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('queuemetrics_pause_type')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('queuemetrics_pause_type')) ?>><?php echo 'No - 0' ?></option>
	    </select>
	    </div>
	 </div>		 	 
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Dispo Pause Code"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_dispo_pause" value="<?php echo get_dialer_option('queuemetrics_dispo_pause'); ?>" />
		</div>
	</div>	
	 <div class="form-group">
	    <label class="col-md-3 control-label"><?php echo "QueueMetrics Phone Environment Phone Append"; ?></label>
	    <div class="col-md-4">
	    <select class="form-control" name="queuemetrics_pe_phone_append">
	        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('queuemetrics_pe_phone_append')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('queuemetrics_pe_phone_append')) ?>><?php echo 'No - 0' ?></option>
	    </select>
	    </div>
	 </div>		 	 	
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Hold Call Log"; ?></label>
		<div class="col-md-4">
	    <select class="form-control" name="queuemetrics_record_hold">
	        <option value="<?php echo 1 ?>" <?php echo optionSetValue("1",get_dialer_option('queuemetrics_record_hold')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 0; ?>" <?php echo optionSetValue("0",get_dialer_option('queuemetrics_record_hold')) ?>><?php echo 'No - 0' ?></option>
	     </select>
		</div>
	</div>		 
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Socket Send"; ?></label>
		<div class="col-md-4">
	    <select class="form-control" name="queuemetrics_socket">
	        <option value="<?php echo 'NONE' ?>" <?php echo optionSetValue("NONE",get_dialer_option('queuemetrics_socket')) ?>><?php echo 'Yes - 1' ?></option>
	        <option value="<?php echo 'CONNECT_COMPLETE'; ?>" <?php echo optionSetValue("CONNECT_COMPLETE",get_dialer_option('queuemetrics_socket')) ?>><?php echo 'No - 0' ?></option>
	    </select>
		</div>
	</div>	
	<div class="form-group">
		<label class="col-md-3 control-label"><?php echo "QueueMetrics Socket Send URL"; ?></label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="queuemetrics_socket_url" value="<?php echo get_dialer_option('queuemetrics_socket_url'); ?>" />
		</div>
	</div>	
</div>
<div class="form-actions">
	<div class="row">
		<div class="col-md-offset-3 col-md-9">
			 <button type="submit" class="btn blue">Submit</button>
		</div>
	</div>
</div>