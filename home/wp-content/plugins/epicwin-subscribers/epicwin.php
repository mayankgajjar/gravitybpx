<?php
/*
Plugin Name: Epicwin Plugin Ajax
Plugin URI: http://www.epicwindesigns.com/projects
Description: This plugin allows your blog visitors to subscribe to your blog via email and receive notifications whenever you create a new post through AJAX. You can control everything from the Wordpress admin.
Version: 30.5
Author: Smart Infosys
Author URI: http://www.epicwindesigns.com
*/

/*  Copyright 2010 Antonio V. Mendes De Araujo (email: antonio@epicwindesigns.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

DEFINE('ADMIN_URL', admin_url('admin.php?page=epicwin-subscribers'));

// Plugin activation:
function epicwin_install() {
	global $wp_version;
	global $wpdb;

	if (version_compare($wp_version, '2.9', '<')) {
		deactivate_plugins(basename(__FILE__));
		wp_die('This plugin requires WordPress version 2.9 or higher.');
	} else {
		$wpdb->query($wpdb->prepare("CREATE TABLE epicwin_feed (id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, email VARCHAR(100) NOT NULL, name VARCHAR(30), opt_in TINYINT(1), UNIQUE(email));"));
	}

}
register_activation_hook(__FILE__, 'epicwin_install');

// Plugin Deactivation:
function epicwin_uninstall() {
	global $wpdb;
	$wpdb->query($wpdb->prepare("DROP TABLE epicwin_feed"));
	unregister_widget('Epicwin_Widget');
}
register_deactivation_hook(__FILE__, 'epicwin_uninstall');

// Register the email settings:
function epicwin_register_settings() {
	register_setting('epicwin_settings_group', 'epicwin_email_from');
	register_setting('epicwin_settings_group', 'epicwin_email_subject');
	register_setting('epicwin_settings_group', 'epicwin_email_message');
	
	register_setting('epicwin_settings_group', 'epicwin_email_from_notify_admin');
	register_setting('epicwin_settings_group', 'epicwin_email_subject_notify_admin');
	register_setting('epicwin_settings_group', 'epicwin_email_message_notify_admin');
}
add_action('admin_init', 'epicwin_register_settings');

// Attach the plugin stylesheet to the header:
function epicwin_styles() {
	echo "<link rel='stylesheet' href='" . WP_PLUGIN_URL . "/epicwin-subscribers/style.css' type='text/css' media='all' />";
}
add_action('wp_head', 'epicwin_styles');

function epicwin_scripts(){
?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
		jQuery(document).on('submit','form#epicwin_subscription',function(e){
			e.preventDefault();

				var sub_email = jQuery('#subnewsemail').val();
				//alert(sub_email);
				jQuery.ajax({
					url:"<?php echo esc_url( home_url( '/' ) ); ?>wp-admin/admin-ajax.php",
					type:'POST',
					data: {
						  sub_email:sub_email,
						  action:'check_info_details'
						  },
					success:function(results)
					{
						jQuery('.epic_results').html(results);
						if(jQuery('.epic_results p').hasClass('success'))
						{
							
							jQuery('#epicwin_subscription')[0].reset();
							
						}
						
						
						

						// Redirection code after success
						/*if(jQuery('.epic_results').find('p.success').length == 1 ) {
							window.location.href = "<?php echo home_url(); ?>/?page_id=163";
						}*/
					},
					 complete:function(){
						jQuery('.loading').hide();
						jQuery(".news_text").show();
						jQuery("#sidebar_button").show();
						jQuery('.epic_results').show();
						
						
						
					},
					beforeSend:function(){
						jQuery('.loading').show();
						jQuery(".news_text").show();
						jQuery("#sidebar_button").show();
						jQuery('.epic_results').hide();
						
					}
				});
			});
			
			//pop up js
			jQuery(document).on('submit','form#epicwin_subscription1',function(e){
			e.preventDefault();

				var sub_email1 = jQuery('#subnewsemail1').val();
				//alert(sub_email);
				jQuery.ajax({
					url:"<?php echo esc_url( home_url( '/' ) ); ?>wp-admin/admin-ajax.php",
					type:'POST',
					data: {
						  sub_email1:sub_email1,
						  action:'check_info_details1'
						  },
					success:function(results)
					{
						jQuery('.epic_results1').html(results);
						if(jQuery('.epic_results1 p').hasClass('success'))
						{
							
							jQuery('#epicwin_subscription1')[0].reset();
							
						}
						// Redirection code after success
						/*if(jQuery('.epic_results').find('p.success').length == 1 ) {
							window.location.href = "<?php echo home_url(); ?>/?page_id=163";
						}*/
					},
					 complete:function(){
						jQuery('.loading1').hide();
						jQuery(".news_text1").show();
						jQuery("#sidebar_button1").show();
						jQuery('.epic_results1').show();
					},
					beforeSend:function(){
						jQuery('.loading1').show();
						jQuery(".news_text1").show();
						jQuery("#sidebar_button1").show();
						jQuery('.epic_results1').hide();
					}
				});
			});
			//pop up js over

	});


</script>
<?php
}
add_action('wp_footer', 'epicwin_scripts');
?>
<?php
//~ function my_scripts_method() {
    //~ wp_enqueue_script( 'jQuery1.11', 'http://code.jquery.com/jquery-1.11.1.min.js' );
//~ }
//~ add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); // wp_enqueue_scripts action hook to link only on the front-end



// Return the current url in order to set the method attribute for the forms:
function currentUrl() {
	$url = add_query_arg(array());
	return $url;
}
/******pop up form*****/
function get_epicwin_box1() {
	global $wpdb; ?>
	<div class="widget_epicwin_widget">
		<p>
			<?php dynamic_sidebar('Newsletter Description'); ?>
        </p>
		<form method="post" action="<?php echo currentUrl() ?>" class="epicwin-subscription" id="epicwin_subscription1" >
					<!--<input placeholder="<?php _e('Name') ?>" type="text" name="sub_name" class="news_text" id="subnewsname"/>-->
					<input placeholder="<?php _e('Enter Your Email') ?>" type="text" name="sub_email1" class="news_text1" id="subnewsemail1" />
					<div class="subscribe_btn_wrap">
						<img height='16' width='16' src="<?php echo WP_PLUGIN_URL ;?>/epicwin-subscribers/ajax-loader.gif"	style="display:none;" name="loading" class="loading1"/>
						<input type="hidden" name="action" value="subscribe" />
						<!--<input  type="button" id="footer_button" class="sub_button" value="<?php _e('Subscribe') ?>"></input>-->
						<input type="submit" name="submit" id="sidebar_button1" class="colora" title="Subscribe" alt="Subscribe" value="Subscribe">
					</div>
					<!--<input  type="button" id="sidebar_button" class="sub_button" value="<?php _e('Go') ?>"></input>-->
					<div class="loading1"></div>
		</form>

		<div class="epic_results1"></div>
		</div>
	<?php
}
	add_action('wp_ajax_check_info_details1', 'check_info_details1');
	add_action('wp_ajax_nopriv_check_info_details1', 'check_info_details1');

	function check_info_details1()
	{
		global $wpdb;
		$errors = array();

		//echo $_POST['sub_name'];
		/*if (empty($_POST['sub_name'])) {
			$errors[] = 'Please type in your name';
		} else {
			$sub_name = strip_tags($_POST['sub_name']);
		}*/

		if (filter_input(INPUT_POST, 'sub_email1', FILTER_VALIDATE_EMAIL)) {
			$sub_email = $_POST['sub_email1'];
		} else {
			$errors[] = 'Please type in a valid email';
		}

		if ($errors) {
			echo '<div class="errors">';

			foreach ($errors as $error) {
				echo '<p class="error"> ' . $error . '</p>';
			}
			echo '</div>';
			echo "<script>jQuery('#subnewsemail1').addClass('error_email');</script>";
		}	else {
			$res = $wpdb->query($wpdb->prepare("SELECT email FROM epicwin_feed WHERE email='{$_POST['sub_email1']}'",1,1));
			if ($res > 0) {
				if ($wpdb->query($wpdb->prepare("UPDATE epicwin_feed SET opt_in=1 WHERE email='{$_POST['sub_email1']}'",1,1))) {
					echo '<p class="success">You have been subscribed!</p>';
				} else {
					echo '<p class="error">You are already subscribed!</p>';
				}
			}
			else
			{
				echo '<p class="success">You have been subscribed!</p>';
			}

			if($wpdb->insert('epicwin_feed', array('email' => $sub_email, 'name' => $sub_name, 'opt_in' => 1), array('%s', '%s', '%d'))) {
				
				/*********Notify admin on new subscription***********/
				
						global $theme_options;
						$to = get_option('admin_email');
						$from2 = get_option('epicwin_email_from_notify_admin') ? get_option('epicwin_email_from_notify_admin') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
						$subject2 = (get_option('epicwin_email_subject_notify_admin')) ? get_option('epicwin_email_subject_notify_admin') : get_the_title();
						$body2 = '<html><head><title>' . $subject2 . '</title></head><body><div>';
						$body2 .= (get_option('epicwin_email_message_notify_admin'));
						$body2 = str_replace('{email}',$sub_email,$body2);
						
						// To send HTML mail, the Content-type header must be set
						$hedr  = 'MIME-Version: 1.0' . "\r\n";
						$hedr .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$hedr .= "From: ".$from2."\r\n";
						// Additional headers			
										
						wp_mail($to,$subject2, $body2, $hedr) or die(mysql_error());
						
					
					/************ Mail to Subscriber **************/
						$s_to = $sub_email;
						$s_from2 = get_option('epicwin_email_from') ? get_option('epicwin_email_from') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
						$s_subject2 = (get_option('epicwin_email_subject')) ? get_option('epicwin_email_subject') : get_the_title();
						
						$s_body2 = '<html><head><title>' . $s_subject2 . '</title></head><body><div>';
						$s_body2 .= (get_option('epicwin_email_message'));
						
						// To send HTML mail, the Content-type header must be set
						$s_hedr  = 'MIME-Version: 1.0' . "\r\n";
						$s_hedr .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$s_hedr .= "From: ".$s_from2."\r\n";
						// Additional headers			
										
						wp_mail($s_to, $s_subject2, $s_body2, $s_hedr) or die(mysql_error());
				
				echo '<p class="success">You have been subscribed!</p>';
			}
			
		}
		
	exit(1);
	}


/******pop up form over*****/

function get_epicwin_box() {
	global $wpdb; ?>
	<div class="widget_epicwin_widget">
		<p>
			<?php dynamic_sidebar('Newsletter Description'); ?>
        </p>
		<form method="post" action="<?php echo currentUrl() ?>" class="epicwin-subscription" id="epicwin_subscription" >
					<!--<input placeholder="<?php _e('Name') ?>" type="text" name="sub_name" class="news_text" id="subnewsname"/>-->
					<input placeholder="<?php _e('Email') ?>" type="text" name="sub_email" class="news_text" id="subnewsemail" onblur="this.value=(this.value=='') ? 'Enter Your Email Here' : this.value;" onfocus="this.value=(this.value=='Enter Your Email Here') ? '' : this.value;"/>
					<img src="<?php echo WP_PLUGIN_URL ;?>/epicwin-subscribers/ajax-loader.gif"	style="display:none;" name="loading" class="loading"/>
					<input type="hidden" name="action" value="subscribe" />
					<!--<input  type="button" id="footer_button" class="sub_button" value="<?php _e('Subscribe') ?>"></input>-->
					<input type="submit" name="submit" id="sidebar_button" class="colora" title="Subscribe" alt="Subscribe" value="Subscribe">

					<!--<input  type="button" id="sidebar_button" class="sub_button" value="<?php _e('Go') ?>"></input>-->
					<div class="loading"></div>
		</form>

		<div class="epic_results"></div>
		</div>
	<?php
}
	add_action('wp_ajax_check_info_details', 'check_info_details');
	add_action('wp_ajax_nopriv_check_info_details', 'check_info_details');

	function check_info_details()
	{
		global $wpdb;
		$errors = array();

		//echo $_POST['sub_name'];
		/*if (empty($_POST['sub_name'])) {
			$errors[] = 'Please type in your name';
		} else {
			$sub_name = strip_tags($_POST['sub_name']);
		}*/

		if (filter_input(INPUT_POST, 'sub_email', FILTER_VALIDATE_EMAIL)) {
			$sub_email = $_POST['sub_email'];
		} else {
			$errors[] = 'Please type in a valid email';
		}

		if ($errors) {
			echo '<div class="errors">';

			foreach ($errors as $error) {
				echo '<p class="error"> ' . $error . '</p>';
			}
			echo '</div>';

		}	else {
			$res = $wpdb->query($wpdb->prepare("SELECT email FROM epicwin_feed WHERE email='{$_POST['sub_email']}'",1,1));
			if ($res > 0) {
				if ($wpdb->query($wpdb->prepare("UPDATE epicwin_feed SET opt_in=1 WHERE email='{$_POST['sub_email']}'",1,1))) {
					
					echo '<p class="success">You have been subscribed!</p>';
					
				} else {
					echo '<p class="success">You are already subscribed!</p>';
				}
			}

			if($wpdb->insert('epicwin_feed', array('email' => $sub_email, 'name' => $sub_name, 'opt_in' => 1), array('%s', '%s', '%d'))) {
				
				/*********Notify admin on new subscription***********/
				
						global $theme_options;
						$to = get_option('admin_email');
						$from2 = get_option('epicwin_email_from_notify_admin') ? get_option('epicwin_email_from_notify_admin') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
						$subject2 = (get_option('epicwin_email_subject_notify_admin')) ? get_option('epicwin_email_subject_notify_admin') : get_the_title();
						$body2 = '<html><head><title>' . $subject2 . '</title></head><body><div>';
						$body2 .= (get_option('epicwin_email_message_notify_admin'));
						$body2 = str_replace('{email}',$sub_email,$body2);
						
						// To send HTML mail, the Content-type header must be set
						$hedr  = 'MIME-Version: 1.0' . "\r\n";
						$hedr .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$hedr .= "From: ".$from2."\r\n";
						// Additional headers			
										
						wp_mail($to,$subject2, $body2, $hedr) or die(mysql_error());
						
					
					/************ Mail to Subscriber **************/
						$s_to = $sub_email;
						$s_from2 = get_option('epicwin_email_from') ? get_option('epicwin_email_from') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
						$s_subject2 = (get_option('epicwin_email_subject')) ? get_option('epicwin_email_subject') : get_the_title();
						
						$s_body2 = '<html><head><title>' . $s_subject2 . '</title></head><body><div>';
						$s_body2 .= (get_option('epicwin_email_message'));
						
						// To send HTML mail, the Content-type header must be set
						$s_hedr  = 'MIME-Version: 1.0' . "\r\n";
						$s_hedr .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$s_hedr .= "From: ".$s_from2."\r\n";
						// Additional headers			
										
						wp_mail($s_to, $s_subject2, $s_body2, $s_hedr) or die(mysql_error());
					
				
				echo '<p class="success">You have been subscribed!</p>';
			}
			
			
		
		}
	exit(1);
	}

	//echo '</div>';


// Create the plugin settings page:
function epicwin_settings_page() {
	global $wpdb;

	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page'));
	} else {
		// Export as a comma separate value:
		if ($_POST['csv_export'] == 'csv_export') {
			$q = $wpdb->get_results($wpdb->prepare("SELECT * FROM epicwin_feed"));
			if (file_exists(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv')) {
				if (count($q) > 0) {
					$file = fopen(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv', 'w');

					foreach ($q as $row) {
						fwrite($file, $row->name . ', ' . $row->email . ', ' . $row->opt_in . "\n");
					}
					fclose($file);
					echo '<div class="updated"><p>The CSV file was updated.</p></div>';
				}
			} else {
				if (count($q) > 0) {
					$file = fopen(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv', 'w');

					foreach ($q as $row) {
						fwrite($file, $row->name . ', ' . $row->email . ', ' . $row->opt_in . "\n");
					}
					fclose($file);
					echo '<div class="updated"><p>The CSV file was created.</p></div>';
				}
			}
		}

		if(isset($_POST['delete'])) {
			if (unlink(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv')) {
				echo '<div class="updated"><p>The file was deleted succesfully.</p></div>';
			} else {
				echo '<div class="error">The file could not be deleted, please verify if the file exists and try again.</p></div>';
			}
		}

		if (isset($_GET['opt'])) {
			$update = $wpdb->query($wpdb->prepare("DELETE FROM epicwin_feed WHERE id=" . $_GET['id']));
			if($delete) {
				echo '<div class="updated"><p>The record was deleted succesfully.</p></div>';
			} else {
				echo '<div class="error">There was an error while trying to delete the record. Please try again.</p></div>';
			}
		}

		if (isset($_GET['id'])) {
			$delete = $wpdb->query($wpdb->prepare("DELETE FROM epicwin_feed WHERE id=" . $_GET['id']));
			if($delete) {
				echo '<div class="updated"><p>The record was deleted succesfully.</p></div>';
			} else {
				echo '<div class="error"><p>There was an error while trying to delete the record. Please try again.</p></div>';
			}
		}

		if (isset($_POST['import'])) {
			if ($_FILES['upload']['size'] > 0) {
				if (end(explode('.', strtolower($_FILES['upload']['name']))) == 'csv') {
					$query = "INSERT INTO epicwin_feed VALUES ";
					$row = file($_FILES['upload']['tmp_name']);
					foreach($row as $key => $value) {
						$entry[$key] = explode(',', $value);
						$query .= "(null, '{$entry[$key][1]}', '{$entry[$key][0]}', '{$entry[$key][2]}'), ";
					}
					$query = substr($query, 0, (strlen($query) - 2)) . ';';
					if($wpdb->query($wpdb->prepare($query))) {
						echo '<div class="updated"><p>The CSV file has been imported.</p></div>';
					}
				} else {
					echo '<div class="error"><p>Error: Only CSV files are allowed.</p></div>';
				}
			} else {
				echo '<div class="error"><p>Error: Please select a CSV file to upload.</p></div>';
			}
		}

		if (isset($_GET['updated'])) {
			echo '<div class="updated"><p>Email Settings Saved</p></div>';
		}
		?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32">&nbsp;</div>
			<h2><?php _e('Epicwin Settings') ?></h2>
			<h3><?php _e('Subscription Settings'); ?></h3>
			<table class="form-table" style="width: 980px;">
				<tbody>
					<tr valign="top">
						<td width="80"><?php _e('Export data') ?>:</td>
						<td>
							<form action="<?php echo ADMIN_URL ?>" method="post" class="export" style="float: left; width: auto; margin-right: 10px;">
								<?php if(file_exists(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv')): ?>
									<input type="submit"  value="<?php _e('Update CSV') ?>" />
								<?php else: ?>
									<input type="submit" value="<?php _e('Create CSV') ?>" />
								<?php endif; ?>
								<input type="hidden" name="csv_export" value="csv_export" />
							</form>

						<?php if (file_exists(str_replace('\\', '/', WP_PLUGIN_DIR) . '/epicwin-subscribers/subscribers.csv')):?>
							<form action ="<?php echo ADMIN_URL ?>" method="post" style="float: left; width: auto; margin-right: 10px;">
								<input type="submit" value="<?php _e('Delete CSV') ?>" />
								<input type="hidden" value="true" name="delete" />
							</form>
							<a href="<?php echo WP_PLUGIN_URL .'/epicwin-subscribers/subscribers.csv' ?>" style="float: left;" class="button-secondary"><?php _e('Download CSV') ?></a>
						<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php _e('Import data'); ?>: </td>
						<td>
							<form action ="<?php echo ADMIN_URL ?>" method="post"  enctype="multipart/form-data">
								<input type="file" name="upload" />
								<input type="submit" value="<?php _e('Import Subscribers'); ?>" />
								<input type="hidden" value="true" name="import" />
							</form>
						</td>
					</tr>
					<tr>
						<td><?php _e('Filters') ?>: </td>
						<td>
							<form action="<?php echo ADMIN_URL . '?' ?>" method="get">
								<table>
									<tr>
										<td>
											<input type="hidden" name="page" value="epicwin-subscribers" />
											<label for="sort"><?php _e('Sort By') ?>: </label>
											<select name="sort" style="width: 70px">
											<?php if ($_GET['sort'] == 'email'): ?>
												<option value="name"><?php _e('Name') ?></option>
												<option value="email" selected="selected"><?php _e('Email') ?></option>
											<?php else: ?>
												<option value="name" selected="selected"><?php _e('Name') ?></option>
												<option value="email"><?php _e('Email') ?></option>
											<?php endif; ?>
											</select>
										</td>
										<td>
											<label for="sort"><?php _e('Sort Order') ?>: </label>
											<select name="sort_order" style="width: 100px">
											<?php if ($_GET['sort_order'] == 'DESC'): ?>
												<option value="ASC"><?php _e('Ascending') ?></option>
												<option value="DESC" selected="selected"><?php _e('Descending') ?></option>
											<?php else: ?>
												<option value="ASC" selected="selected"><?php _e('Ascending') ?></option>
												<option value="DESC"><?php _e('Descending') ?></option>
											<?php endif; ?>
											</select>
										</td>
										<td>
											<label for="sort"><?php _e('Records Per Page') ?>: </label>
											<select name="record_count" style="width: 50px">
											<?php
												switch ($_GET['record_count']) {
													case '20':
														echo '<option value="10">10</option>
														<option value="20" selected="selected">20</option>
														<option value="30">30</option>';
														break;

													case '30':
														echo '<option value="10">10</option>
														<option value="20">20</option>
														<option value="30" selected="selected">30</option>';
														break;

													default:
														echo '<option value="10" selected="selected">10</option>
														<option value="20">20</option>
														<option value="30">30</option>';
														break;
												}
											?>
											</select>
										</td>
										<td>
											<input type="submit" value="<?php _e('Apply Filters') ?>" />
										</td>
									</tr>
									
								</table>
							</form>
						</td>
					</tr>
					<tr valign="top">
						<td><?php _e('Subscribers') ?>:</td>
						<td>
							<table cellspacing="0" border="0" class="widefat">
								<thead>
									<tr>
									<!--	<th><?php _e('Name') ?>:</th>-->
									<th><input type='checkbox' name='allcheck' id='allcheck' value='all'></th>
										<th><?php _e('Email') ?>:</th>
										<th><?php _e('Opt-In') ?>:</th>
										<th><?php _e('Action') ?>: </th>
									</tr>
								</thead>
								<tbody>
								<?php
								$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM %s", 'epicwin_feed'));

								$numRows = count($results);
								$rowsPerPage = (isset($_GET['record_count'])) ? $_GET['record_count'] : 10;
								$totalPages = (isset($_GET['total_pages'])) ? $_GET['total_pages'] : ceil($numRows / $rowsPerPage);
								$startPage = (isset($_GET['start_page'])) ? $_GET['start_page'] : 0;
								$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
								$sortOrder = (isset($_GET['sort_order'])) ? $_GET['sort_order'] : 'ASC';

								$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM epicwin_feed ORDER BY $sort  $sortOrder LIMIT $startPage, $rowsPerPage"));
								//$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM epicwin_feed ORDER BY %s %s LIMIT %s, %s", $sort,$sortOrder, $startPage, $rowsPerPage));
								//$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM epicwin_feed ORDER BY $sort $sortOrder LIMIT $startPage, %s",  $rowsPerPage));
								?>
								<form method='post'>
								<?php
								if (count($results) > 0):

									foreach ($results as $row):
									?>
										<tr>
										<!--	<td><?php echo $row->name ?></td> -->
										<td><input type='checkbox' name='cid[]' value='<?php echo $row->id;?>' class='mailids'></td>
											<td><?php echo $row->email ?></td>
											<?php if($row->opt_in == 0): ?>
												<td><?php _e('No') ?></td>
											<?php else: ?>
												<td><?php _e('Yes') ?></td>
											<?php endif; ?>
											<td>
												<a href="<?php echo ADMIN_URL . '&id=' . $row->id ?>"><?php _e('Delete') ?></a>
												<a href="<?php echo ADMIN_URL . '&temp_id=' . $row->id ?>" class='email_temp'><?php _e('Email'); ?></a>
											</td>
										</tr>
									<?php endforeach; ?>
											<tr>
											<td colspan="4" align="left"><input type='submit' value='Mail' class='mailaction' name='mailbtn'/>
											<input type='submit' value='Delete' class='deleteaction' name='deletebtn'/></td>
										</tr>
								<?php else: ?>
									<tr>
										<td colspan="4" align="center"><?php _e('There aren\'t any subscribers at this moment.') ?></td>
									</tr>
								<?php endif ?>
								</form>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td><?php _e('Pagination') ?>: </td>
						<td><?php
							if ($totalPages > 1) {
								$currentPage = ($startPage/$rowsPerPage) + 1;

								if ($currentPage != 1) {
									echo '<a href="' . currentUrl() . '&start_page=' . ($startPage - $rowsPerPage) . '&total_pages=' . $totalPages . '">' . _e('Previous') . '</a> ';
								}

								for ($i = 1; $i <= $totalPages; $i++) {
									if ($i !=$currentPage) {
										echo '<a href="' . currentUrl() . '&start_page=' . (($rowsPerPage * ($i - 1))) . '&total_pages=' .$totalPages . '">' . $i . '</a> ';
									} else {
										echo $i . ' ';
									}
								}

								if ($currentPage != $totalPages) {
									echo '<a href="' . currentUrl() . '&start_page=' . ($startPage + $rowsPerPage) . '&total_pages=' . $totalPages . '">' . _e('Next') . '</a>';
								}
							} else {
								_e('There are not enough records to generate a pagination.');
							}
						?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<!-- Mail Setting -->
			<div class='default_form' <?php if (isset($_GET['temp_id']) || isset($_POST['mailbtn'])) { echo "style='display:block;'"; }else { echo "style='display:none;'";}?>>
			<form id="defaultform" action="" method="post" enctype="multipart/form-data">
				<?php 
				if (isset($_GET['temp_id'])) {
					//$delete = $wpdb->query($wpdb->prepare("DELETE FROM epicwin_feed WHERE id=" . $_GET['id'],1,1));
					$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM epicwin_feed WHERE id=" . $_GET['temp_id'],1,1));
					//echo "data :".$result;
					if(!empty($result))
						{
						$uid = $result->email;
						}
				}
				if(isset($_POST['mailbtn']))
					{
						if(isset($_POST['cid']))
							{
								foreach($_POST['cid'] as $eid)
									{
									$result = $wpdb->get_row($wpdb->prepare("SELECT * FROM epicwin_feed WHERE id=" . $eid,1,1));
									$result1 .= $result->email.',';
								}
							$uid = rtrim($result1,',');
						}	
					}
					
				?>
				<h3><?php _e('Default Email Template Settings'); ?></h3>
			
				<?php //settings_fields('yourthemepick_def_settings_group'); ?>
				
				<table class="user-form-table tess" style="width: 980px">
					<tbody>
						<tr>
							<td><label for="email_from"><?php _e('To'); ?>: </label> </td>
							<td><input class="regular-text" type="text" id="test_email_from" name="yourthemepick_def_email_from" value="<?php echo (isset($uid)) ? $uid : " "; ?>" /> <span class="description"><?php _e('If you leave this blank it will use the administrators info'); ?>.</span></td>
						</tr>
						<tr>
							<td><label for="email_subject"><?php _e('Subject'); ?>: </label> </td>
							<td><input class="regular-text" type="text" id="test_email_subject" name="yourthemepick_def_email_subject" value="<?php echo (get_option('yourthemepick_def_email_subject')) ? get_option('yourthemepick_def_email_subject') : 'test'; ?>" /> <span class="description"><?php _e('If you want the post name to be the subject just leave this blank'); ?>.</span></td>
						</tr>
						<tr><td><label>Attachment:</label></td>
						<td>
							<div class="items">
								<div class="form-group">
									<input id="a_email" class="form-control" name="attchfile" type="file" />
								</div>
							</div>
							
						</td>
						</tr>
						<tr>
							<td valign="top"><label for="email_message"><?php _e('Message'); ?>: </label></td>
							<td>
								<?php 
									$content = "";
									$editor_id = 'test_email_message1';

									//wp_editor( $content, $editor_id, array('textarea_name' => 'yourthemepick_def_email_message2','editor_class' => 'default_email_message1', 'tinymce' => true));
									?>
								<textarea name="yourthemepick_def_email_message2" class="default_email_message1"></textarea>	
								<!--textarea class="large-text" rows="10" cols="25" id="user_email_message" name="yourthemepick_user_email_message"><?php echo get_option('yourthemepick_test_email_message'); ?></textarea--><span class="description"><?php _e('Use the tag {link} to display the post link in the email. You may use HTML tags to format the message. Ex: "New post from Wordpress Blog! Click on the following link to see it: {link}"'); ?></span></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<!--p class="submit"><input type="submit" value="Save Changes" name="user_submit" class="button-primary" /></p-->
								<p class="submit"><input type="submit" value="Send Mail" name="mail_btn" class="button-primary" /></p>
								<img alt="yourthemepick-loading" src="<?php echo WP_PLUGIN_URL ;?>/epicwin-subscribers/ajax-loader.gif" height="20" width="20" style="display:none;" class="loading2"/>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			<div class="epic_results2"></div>

			</div>	
			<!-- End -->
			
			<h3><?php _e('Email Settings') ?></h3>
			<form action="options.php" method="post">
				<?php settings_fields('epicwin_settings_group'); ?>
				<table class="form-table" style="width: 980px">
					<tbody>
						<tr>
							<td><label for="email_from"><?php _e('From') ?>: </label> </td>
							<td><input class="regular-text" type="text" id="email_from" name="epicwin_email_from" value="<?php echo (get_option('epicwin_email_from')) ? get_option('epicwin_email_from') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>'; ?>" /> <span class="description"><?php _e('If you leave this blank it will use the administrators info') ?>.</span></td>
						</tr>
						<tr>
							<td><label for="email_subject"><?php _e('Subject') ?>: </label> </td>
							<td><input class="regular-text" type="text" id="email_subject" name="epicwin_email_subject" value="<?php echo (get_option('epicwin_email_subject')) ? get_option('epicwin_email_subject') : ''; ?>" /> <span class="description"><?php _e('If you want the post name to be the subject just leave this blank') ?>.</span></td>
						</tr>
						<tr>
							<td valign="top"><label for="email_message"><?php _e('Message') ?>: </label></td>
							<td>
								
								
								
								<?php 
									$content = get_option('epicwin_email_message');
									$editor_id = 'email_message';

									wp_editor( $content, $editor_id, array('textarea_name' => 'epicwin_email_message', 'tinymce' => true));
									?>
								
<!--
								<textarea class="large-text" rows="10" cols="25" id="email_message" name="epicwin_email_message"><?php echo get_option('epicwin_email_message'); ?></textarea>
-->
								
								
								
								<span class="description"><?php _e('Use the tag {link} to display the post link in the email. You may use HTML tags to format the message. Ex: "New post from Wordpress Blog! Click on the following link to see it: {link}"') ?></span></td>
						</tr>
						<!---08/04/16--->
							
						<!---08/04/16--->
						
						<tr>
							<td>&nbsp;</td>
							<td>
								<p class="submit"><input type="submit" value="Save Changes" name="submit" class="button-primary" /></p>
							</td>
						</tr>
						<!--**************** Added Date 13th Dec 2015(Mail to admin when new user subscribed)***********************-->
						<tr>
							<td colspan="2">
								<h3><?php _e('Email Settings - For Admin On New Subscription') ?></h3>
							</td>
						</tr>
						<tr>
							<td><label for="email_from"><?php _e('From') ?>: </label> </td>
							<td><input class="regular-text" type="text" id="email_from_notify_admin" name="epicwin_email_from_notify_admin" value="<?php echo (get_option('epicwin_email_from_notify_admin')) ? get_option('epicwin_email_from_notify_admin') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>'; ?>" /> <span class="description"><?php _e('If you leave this blank it will use the administrators info') ?>.</span></td>
						</tr>
						<tr>
							<td><label for="email_subject"><?php _e('Subject') ?>: </label> </td>
							<td><input class="regular-text" type="text" id="email_subject_notify_admin" name="epicwin_email_subject_notify_admin" value="<?php echo (get_option('epicwin_email_subject_notify_admin')) ? get_option('epicwin_email_subject_notify_admin') : ''; ?>" /></td>
						</tr>
						<tr>
							<td valign="top"><label for="email_message"><?php _e('Message') ?>: </label></td>
							<td>
								<?php 
									$content = get_option('epicwin_email_message_notify_admin');
									$editor_id = 'email_message_notify_admin';
						
									wp_editor( $content, $editor_id, array('textarea_name' => 'epicwin_email_message_notify_admin', 'tinymce' => true));
									?>
								
<!--
								<textarea class="large-text" rows="10" cols="25" id="email_message_notify_admin" name="epicwin_email_message_notify_admin"><?php echo get_option('epicwin_email_message_notify_admin'); ?></textarea>
								
-->
								</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<p class="submit"><input type="submit" value="Save Changes" name="submit" class="button-primary" /></p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			
		</div>
		
		<!-- -->
			<script>
			jQuery(document).ready(function(){
				jQuery('.email_temp').on('click',function(){
						jQuery('.default_form').css('display','block');
					});	
				jQuery("#allcheck").change(function () {
					jQuery(".mailids:checkbox").prop('checked', jQuery(this).prop("checked"));
				});
				
			tinymce.init({
				selector: ".default_email_message1",
				height: 500,
				statusbar: true,
				menubar: false,
				plugins:"charmap,colorpicker,hr,lists,code, media,paste,tabfocus,textcolor,fullscreen,wordpress,wpautoresize,wpeditimage,wpemoji,wpgallery,wplink,wpdialogs,wptextpattern,wpview,wpembed",
				toolbar: 'undo redo | styleselect fontselect  | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect | link code',
				fontsize_formats: "8px 10px 12px 14px 18px 24px 36px",
				setup: function (editor) {
					editor.on('change', function () {
						editor.save();
					});
				}
			});	
			jQuery("#defaultform").on('submit', function(e) {
				e.preventDefault();
				
				var sub_email = jQuery('#test_email_from').val();
				var sub_subject = jQuery('#test_email_subject').val();
				var sub_msg = jQuery('.default_email_message1').val();
				//var fileName = jQuery("input.a_email").val();   
				var formData = new FormData(this);
				//var imageDataa=jQuery('#a_email')[0].files[0];
				//var fileName = jQuery("input.a_email").val();              
				
					//formData.append('file_upload', jQuery('input[type=file]')[0].files[0]);
				 
				formData.append('action', 'sent_default_msg');
				//alert(sub_msg);
				jQuery.ajax({
					url:"<?php echo esc_url( home_url( '/' ) ); ?>wp-admin/admin-ajax.php",
					type:'POST',
					data: formData,
					
					//~ data: {
						  //~ sub_email:sub_email,
						  //~ sub_subject:sub_subject,
						  //~ sub_msg:sub_msg,
						  //~ data2: new FormData(this),
						  //~ action:'sent_default_msg'
						  //~ },
					contentType: false,
					cache: false,  
					processData: false,
					success:function(results)
					{
						jQuery('.epic_results2').html(results);						
					},
					 complete:function(){
						jQuery('.loading2').hide();
						jQuery('.epic_results2').show();
					},
					beforeSend:function(){
						jQuery('.loading2').show();
						jQuery('.epic_results2').hide();
					}
				});

			});
		});
		</script>
	<?php
	}

}
add_action('wp_ajax_sent_default_msg', 'sent_default_msg');
add_action('wp_ajax_nopriv_sent_default_msg', 'sent_default_msg');

	function sent_default_msg()
	{
		//~ echo 'hello'.$_REQUEST['yourthemepick_def_email_message2'];
		//~ die();
		if (empty($_POST['yourthemepick_def_email_from'])) {
			$errors[] = 'Please type in a valid email';
		} else {
			$sub_email = $_POST['yourthemepick_def_email_from'];
		}
		
		if (empty($_POST['yourthemepick_def_email_subject'])) {
			$errors[] = 'Please type subject';
		} else {
			$sub_subject = strip_tags($_POST['yourthemepick_def_email_subject']);
		}
		
		if ($_REQUEST['yourthemepick_def_email_message2'] == null) {
			$errors[] = 'Please type Message';
		} else {
			$sub_msg = $_REQUEST['yourthemepick_def_email_message2'];
		}

		if ($errors) {
			echo '<div class="errors">';

			foreach ($errors as $error) {
				echo '<p class="error"> ' . $error . '</p>';
			}
			echo '</div>';

		}	else {
			//~ if(!empty($process)){
					//~ unset($process[sizeof($process)-1]);
			//~ }
				if($_FILES['attchfile']['name']!=null)
					{
					$sourcePath = $_FILES['attchfile']['tmp_name'];
					//Setup our new file path\$targetPath
					$targetPath  = WP_PLUGIN_DIR."/epicwin-subscribers/uploadFiles/" . $_FILES['attchfile']['name'];
					move_uploaded_file($sourcePath,$targetPath) ;
										
					$bcc = $sub_email;
					//~ $random_hash = md5(date('r', time()));
					//~ $boundary="PHP-mixed-".$random_hash; 
					$random_hash = md5(date('r', time()));
					$boundary="PHP-mixed-".$random_hash;
					$toarray = explode(",",$sub_email);
					//$to = $toarray[0];
					$subject = $sub_subject;
					$body = '<html><head><title>' . $subject . '</title></head><body><div>';
					$body .= $sub_msg;
					$body .= '</div></body></html>';
									
					$headers[] = 'Content-Type: text/html; charset=UTF-8';
					$headers[] = 'From:Beacon <info@beacon.co.in> ' . "\r\n";
										
					$attachments = array($targetPath);
					foreach($toarray as $to)
					{
						wp_mail($to, $subject, $body, $headers,$attachments);
					}
					echo "Mail successfully Send.";
				}
				else {
					$bcc = $sub_email;
					$toarray = explode(",",$sub_email);
					
					$subject = $sub_subject;
					$body = '<html><head><title>' . $subject . '</title></head><body><div>';
					$body .= $sub_msg;
					$body .= '</div></body></html>';
					//~ $headers  = 'MIME-Version: 1.0' . "\r\n";
					//~ $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					//$headers = "MIME-Version: 1.0\r\n";
					//$headers .= "Content-Type: multipart/mixed; boundary = ".$boundary."\r\n\r\n"; 
					
					$headers[] = 'Content-Type: text/html; charset=UTF-8';
					$headers[] = 'From: Beacon <info@beacon.co.in> ' . "\r\n";
					 
					foreach($toarray as $to)
					{
						wp_mail($to, $subject, $body, $headers);
					}
					echo "Mail successfully Send.";
				}
				//wp_mail($to, $subject, $body, $headers);
				
		}
		//die();
	exit(1);
	}

// Create the settings menu in the admin area:
function create_epicwin_menu() {
	add_menu_page('Epicwin Settings', 'Epicwin Settings', 'administrator', 'epicwin-subscribers', 'epicwin_settings_page', WP_PLUGIN_URL . '/epicwin-subscribers/generic.png');
}
add_action('admin_menu', 'create_epicwin_menu');

// Function to run when someone unsubscribes to the email list:
function unsubscribe() {
	global $wpdb;

	if ($_GET['action'] == 'unsubscribe'): ?>
		<div id="unsubscribe">
			<form action="<?php echo currentUrl() ?>" method="get">
				<p><?php _e('Enter your email bellow') ?></p>
				<p><input size="10" type="text" name="unsub_email" /></p>
				<p>
					<input type="submit" value="Unsubscribe" />
					<input type="hidden" value="yes" name="unsub" />
				</p>
			</form>
		</div>
	<?php endif; ?>

	<?php if(isset($_GET['unsub_email']) && $_GET['unsub'] == 'yes'): ?>
		<?php $queryResult = $wpdb->query($wpdb->prepare("UPDATE epicwin_feed SET opt_in=0 WHERE email='" . $_GET['unsub_email'] . "'"));
		if ($queryResult > 0): ?>
			<div id="unsubscribe">
				<p><?php _e('You have been removed form our mailing list. If you would like to join the mailing list in the future, just fill in the subscribe box again') ?>.</p>
				<a href="#" class="close" onclick="document.getElementById('unsubscribe').style.visibility='hidden'">Close</a>
			</div>
		<?php else: ?>
			<div id="unsubscribe">
				<p><?php _e('You have either already unsubscribed or we could not find your email in our recrods') ?>.</p>
				<a href="#" class="close" onclick="document.getElementById('unsubscribe').style.visibility='hidden'">Close</a>
			</div>
		<?php endif;
	endif;

}
add_action('wp_footer', 'unsubscribe');

// Create the sidebar widget for the plugin:
class Epicwin_Widget extends WP_Widget {

	function Epicwin_Widget() {
		parent::WP_Widget(false, $name = 'Epicwin Widget');
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget='<div class="footer-info">';
		if ($title)  echo $before_title . $title . $after_title;
		get_epicwin_box();
		echo $after_widget='</div>';
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$title = esc_attr($instance['title']); ?>
		<p><label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title: ') ?></label><input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo $title ?>" /></p>
		<?php
	}

}

// Send an email message to alert all subscribers who have an Opt-In status when a new post has been made:
function new_post_alert() {
	global $posts;
	global $wpdb;

	if ($_POST['original_post_status'] !== 'publish' && $_POST['post_type'] == 'post' && $_REQUEST['screen'] !== 'edit-post' && $_POST['publish'] == 'Publish') {
		$query = $wpdb->get_results("SELECT id, email FROM epicwin_feed WHERE opt_in=1");
		query_posts(array('posts_per_page' => 1, post_type => 'post'));

		if (have_posts()): while (have_posts()): the_post();
			$emails = array();

			if (count($query) > 0) {
				foreach($query as $entry) {
					$emails[]= $entry->email;
				}

				$bcc = implode(',', $emails);

				$epicwin_title = (get_the_title()) ? get_the_title() : 'Click Here';
				$from = get_option('epicwin_email_from') ? get_option('epicwin_email_from') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
				$subject = (get_option('epicwin_email_subject')) ? get_option('epicwin_email_subject') : get_the_title();
				$body = '<html><head><title>' . $subject . '</title></head><body><div>';
				$body .= (get_option('epicwin_email_message')) ? get_option('epicwin_email_message') : 'New post from ' . get_bloginfo('name') . '. Click the link bellow to view it: <br><a href="' . get_permalink() . '">' . $epicwin_title . '</a><br><br>';
				$body .= 'You may unsubscribe at any time using the following link: <a href="' .  get_bloginfo('url') . '/index.php?action=unsubscribe">Unsubscribe</a></div></body></html>';
				$body = preg_replace('/\{link\}/', '<a href="' . get_permalink() . '">' . $epicwin_title . '</a>', $body);

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= "From: $from" . "\r\n";
				$headers .= "Bcc: $bcc" . "\r\n";
				
				wp_mail($from, $subject, $body, $headers);
			}
		endwhile; endif; wp_reset_query();
	}
}
add_filter('publish_post', 'new_post_alert');

// Send an email message to alert all subscribers who have an Opt-In status when a new post has been made:
function new_post_alert1() {
	global $posts;
	global $wpdb;

	if ($_POST['original_post_status'] !== 'publish' && $_POST['post_type'] == 'news' && $_REQUEST['screen'] !== 'edit-post' && $_POST['publish'] == 'Publish') {
		$query = $wpdb->get_results($wpdb->prepare("SELECT id, email FROM epicwin_feed WHERE opt_in=1"));
		query_posts(array('posts_per_page' => 1, post_type => 'news'));

		if (have_posts()): while (have_posts()): the_post();
			$emails = array();

			if (count($query) > 0) {
				foreach($query as $entry) {
					$emails[]= $entry->email;
				}

				$bcc = implode(',', $emails);

				$epicwin_title = (get_the_title()) ? get_the_title() : 'Click Here';
				$from = get_option('epicwin_email_from') ? get_option('epicwin_email_from') : get_userdata(1)->user_firstname . ' ' . get_userdata(1)->user_lastname . ' <' . get_userdata(1)->user_email . '>';
				$subject = (get_option('epicwin_email_subject')) ? get_option('epicwin_email_subject') : get_the_title();
				$body = '<html><head><title>' . $subject . '</title></head><body><div>';
				$body .= (get_option('epicwin_email_message')) ? get_option('epicwin_email_message') : 'New post from ' . get_bloginfo('name') . '. Click the link bellow to view it: <br><a href="' . get_permalink() . '">' . $epicwin_title . '</a><br><br>';
				$body .= 'You may unsubscribe at any time using the following link: <a href="' .  get_bloginfo('url') . '/index.php?action=unsubscribe">Unsubscribe</a></div></body></html>';
				$body = preg_replace('/\{link\}/', '<a href="' . get_permalink() . '">' . $epicwin_title . '</a>', $body);

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= "From: $from" . "\r\n";
				$headers .= "Bcc: $bcc" . "\r\n";
				
				wp_mail($from, $subject, $body, $headers);
			}
		endwhile; endif; wp_reset_query();
	}
}
add_filter('publish_news', 'new_post_alert1');
?>