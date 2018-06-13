<?php
/*
 * Plugin Name: Smart Customize
*/


/* Restrict all page access except Home page Start */

add_action('wp', function()
{
    // Allow viewing of home/front_page
    if(is_home() or is_front_page()) 
    {
		return;
	}	
	else
	{
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
	}
});		
/* Restrict all page access except Home page Over */    
    
function theme_enqueue_styles() 
{
	wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style( 'googlefonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700');
	wp_enqueue_style( 'owlcss', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.css');

	wp_enqueue_style( 'customcss', get_stylesheet_directory_uri() . '/custom.css');
	wp_enqueue_style( 'fancyboxcss', get_stylesheet_directory_uri() . '/assets/css/jquery.fancybox.css');
	wp_enqueue_style( 'responsivecss', get_stylesheet_directory_uri() . '/responsive.css');
	wp_enqueue_style( 'mobileviewcss', get_stylesheet_directory_uri() . '/mobilestyle.css');
	
	wp_enqueue_script( 'owljs', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js');
	wp_enqueue_script( 'fancyboxjs', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.js');
	wp_enqueue_script( 'fancyboxjspack', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.pack.js');
	wp_enqueue_script( 'customjs', get_stylesheet_directory_uri() . '/assets/js/custom.js');
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles',100);

add_shortcode( 'my_epicwin', 'getepicwinbox1' );
add_filter('widget_text','do_shortcode');
function getepicwinbox1()
{
	ob_start();
	get_epicwin_box1();
	$output=ob_get_contents();
	ob_end_clean();
	return $output;	
}

// Custom post type for Testimonials.
function smart_testimonials_post() 
{
	$labels = array(
		'name' => _x('Testimonial', 'post type general name'),
		'singular_name' => _x('Testimonial', 'post type singular name'),
		'add_new' => _x('Add New Testimonial', 'portfolio item'),
		'add_new_item' => __('Add New Testimonial'),
		'edit_item' => __('Edit Testimonial'),
		'new_item' => __('New Testimonial'),
		'view_item' => __('View Testimonial'),
		'search_items' => __('Search Testimonial'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => array('title','editor','thumbnail')
	  ); 
	register_post_type( 'testimonial' , $args );
}
add_action( 'init', 'smart_testimonials_post' );

// Shortcode for Latest Testimonials.
function get_latest_testimonials( $atts ) {
ob_start();	
		$testimonials=query_posts('post_type=testimonial&posts_per_page=3&orderby=date&post_status=publish');
		
		$count=count($testimonials);
		echo "<input type='hidden' class='tcount' value=0 />";
		echo "<div class='testimonials-div owl-carousel count_".$count."'>";
			while (have_posts()) : the_post();
			$post = get_post();
			$tposition=get_post_meta($post->ID,"tposition",true);	
				echo "<div class='testimonials '>";
					echo "<div class='testi_img'>";
						echo "<div class='testimonials-img'>";
							$src=wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'thumbnail'));
							if($src!='')
							{
								echo "<img src=".$src." alt='testimonial-img'/>";
							}
							else
							{
								echo "<img height='180' width='180' alt='testimonial-img' src='".get_stylesheet_directory_uri()."/assets/images/default_pic.png' />";
							}	
						echo "</div>";
					echo "</div>";
					echo "<div class='testimonial-info'>";
						echo "<div class='news_description'><p>". get_the_content()."</p></div>";
						echo "<div class='testimonials-title'>- ". get_the_title()."</div>";
						if($tposition!='')
						{
							echo "<div class='testimonials-excerpt'> ".$tposition."</div>";
						}
					echo "</div>";	
				echo "</div>";
			endwhile;
		echo "</div>";	
		wp_reset_query();
$output=ob_get_contents();
ob_end_clean();
return $output;	
}
add_shortcode( 'latest_testimonials', 'get_latest_testimonials' );

// Custom post type for Logo.
function smart_logo() 
{
	$labels = array(
		'name' => _x('Client Logo', 'post type general name'),
		'singular_name' => _x('Client Logo', 'post type singular name'),
		'add_new' => _x('Add New logo', 'portfolio item'),
		'add_new_item' => __('Add New Logo'),
		'edit_item' => __('Edit Logo'),
		'new_item' => __('New Logo'),
		'view_item' => __('View Logo'),
		'search_items' => __('Search Logo'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => array('title','thumbnail')
	); 
	register_post_type( 'client-logo' , $args );
}
add_action( 'init', 'smart_logo' );

// Shortcode for Latest client-logo.
function get_smart_logo( $atts ) 
{
	ob_start();	
	query_posts('post_type=client-logo&posts_per_page=6&post_status=publish');
	echo "<div class='client-logo-div'>";
		while (have_posts()) : the_post();

			$post = get_post();
			
			$logo_url=get_post_meta($post->ID,"clogo_link",true);
			echo "<div class='client_logo'>";
				if($logo_url!='')
				{
					echo "<a target='_blank' href='".$logo_url."'><img alt=".strtolower(str_replace(" ","-",get_the_title()))." src=".wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail'))." /></a>";
				}
				else
				{	
					echo "<img height='180' width='180' alt=".strtolower(str_replace(" ","-",get_the_title()))." src=".wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail'))." />";
				}	
			echo "</div>";
		endwhile;
	echo "</div>";
	wp_reset_query();
	$output=ob_get_contents();
	ob_end_clean();
	return $output;	
}
add_shortcode( 'get_smart_logo', 'get_smart_logo' );

// Shortcode for Latest Post.
function get_all_post( $atts )
{
	ob_start();
	query_posts('post_type=post&posts_per_page=-1&orderby=date&post_status=publish');
	echo "<div class='latest-blog-div'>";
		while (have_posts()) : the_post();
			echo "<div class='latest-blog'>";
				echo "<div class='date-img-wrap'>";
					echo "<div class='latest_blog_date'>";
						echo "<span class='-blog-date-day'>". get_the_date( "d M", $post_id )."</span>";	
						echo "<span class='-blog-date-day'>". get_the_date( "Y", $post_id )."</span>";	
					echo "</div>";	
					$src=wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'thumbnail'));
					if($src!='')
					{
						echo "<img alt='blog-img' src=".wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') )." />";
					}
					else
					{
						echo "<img alt='blog-img' src='".get_stylesheet_directory_uri()."/assets/images/default_news_img.png' />";
					}	
					
				echo "</div>";	
				echo "<div class='btitle-desc-wrap'>";
					echo "<div class='latest-blog-title'>". get_the_title()."</div>";
					echo "<div class='latest-blog-description'><p>". get_the_excerpt()."</p></div>";
				echo "</div>";	
			echo "</div>";
			
		endwhile;
	echo "</div>";
	wp_reset_query();
	$output=ob_get_contents();
	ob_end_clean();
	return $output;	
}
add_shortcode( 'get_all_post', 'get_all_post' );

// Shortcode for footer_logo
function get_footer_logo() 
{
	ob_start();	
	if(ot_get_option("footer_logo")!='') 
	{ 
		echo '<a href="'.site_url().'"><img height="186" width="288" src="'.ot_get_option("footer_logo").'" alt="footer_logo" /></a>';
	} 
	$output=ob_get_contents();
	ob_end_clean();
	return $output;	
}
add_shortcode( 'get_footer_logo', 'get_footer_logo' );

// Extra footer Widget
function third_footer_widgets() 
{
	// Third footer widget area, located in the footer. Empty by default.
	register_sidebar( array
	(
		'name' => __( 'Footer 3', 'sidebar-4' ),
		'id' => 'sidebar-4',
		'description' => __( 'Third footer widget area', 'sidebar-4' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));	
}

// Register sidebars by running tutsplus_widgets_init() on the widgets_init hook.
add_action( 'widgets_init', 'third_footer_widgets' );

function get_new_testimonial_in_carousel() 
{
	ob_start();	
	
	global $wpdb;
	$pre=$wpdb->prefix;

	//$offset=$_POST["count"];
	$ppp = $_POST["count"];

	$args = array(
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => 'testimonial',
		'post_status' => 'publish',
		'posts_per_page' => $ppp,
		'offset' => 3,
	);
	
	$loop = new WP_Query($args);
	//$a=$loop->request;
	
	$count=$loop->found_posts;
	$html='';
		if ( $loop->have_posts() ) :
			while ( $loop->have_posts() ):
				$loop->the_post(); 
				$html .='<div class="testimonials owl-item"><div class="testi_img"><div class="testimonials-img">';
				$src=wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'thumbnail'));
				if($src!='')
				{
					$html .= "<img src=".$src." alt='testimonial-img'/>";
				}
				else
				{
					$html .= "<img alt='testimonial-img' src='".get_stylesheet_directory_uri()."/assets/images/default_pic.png' />";
				}	
				
				$html .='</div><div class="testimonial-info"><div class="news_description"><p>'.the_content().'</p></div><div class="testimonials-title">-'.the_title().'</div><div class="testimonials-excerpt">-'.get_the_excerpt().'</div></div></div></div>';
			wp_reset_postdata();
			endwhile;
		endif;
	wp_reset_query();
	//$output=ob_get_contents();
	ob_end_clean();
	
	$arr=array("html"=>$html,"count"=>$count);
	
	echo json_encode($arr);
	die;
}
add_action( 'wp_ajax_get_new_testimonial_in_carousel', 'get_new_testimonial_in_carousel' );    // If called from admin panel
add_action( 'wp_ajax_nopriv_get_new_testimonial_in_carousel', 'get_new_testimonial_in_carousel' ); 



/* Admin side customization Start*/
//Start custom admin login logo
function custom_login_logo() {
	
	if(function_exists( 'ot_get_option' ) ) 
	{
		$logo_dark = ot_get_option( 'logo' );
	}
	/*else 
	{
		$logo_dark = get_bloginfo('name');
	}*/

	echo '<style type="text/css">
	h1 a { background-image: url('.$logo_dark.') !important;width:auto !important; background-size: 100% !important; height: 15px !important;padding:30px 0 !important;}
	#login{ width:400px !important; }
	</style>';
}
//End custom admin login logo

// custom admin login logo URL
add_action('login_head', 'custom_login_logo');
function loginpage_custom_link() {
	return site_url();
}

// custom admin login logo Title
add_filter('login_headerurl','loginpage_custom_link');
function change_title_on_logo() {
	return '';
}

add_filter('login_headertitle', 'change_title_on_logo');

// custom disable Wordpress Version

function disable_version() {
   return '';
}
add_filter('the_generator','disable_version');

add_filter('admin_footer_text', 'kcr_remove_admin_footer_text', 1000);
 
function kcr_remove_admin_footer_text($footer_text =''){
    
    echo "<style>
	.option-tree-ui-button.button.button-secondary.left.reset-settings {
		  display: none;
		}</style>";
    return '';  
    
}
 
add_filter('update_footer', 'kcr_remove_admin_footer_text', 1000);
 
function kcr_remove_admin_footer_upgrade($footer_text =''){
    return '';  
}
remove_action('wp_head', 'wp_generator');

add_action('admin_menu','wphidenag');
function wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}
/* Admin customization Over */

add_action( 'wp_footer', 'jscripts_footer');
function jscripts_footer() 
{ 
	?>
	<script type="text/javascript">
		
		var https = "<?php echo $_SERVER['HTTPS']; ?>";
		<?php
			$total_testimonials=query_posts('post_type=testimonial&posts_per_page=-1&orderby=date&post_status=publish');
		?>	
		var tot_testimonials=<?php echo count($total_testimonials); ?>
			
		if(https == "on")
		{
			var ajaxurl = "<?php echo ((strpos(admin_url('admin-ajax.php'),"https") === false))?str_replace('http','https',admin_url('admin-ajax.php')):admin_url('admin-ajax.php'); ?>";
		}
		else
		{
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		}
		jQuery(window).on("load",function()
		{
				jQuery(".testimonials .owl-next").on("click",function()
				{
					var count=jQuery(".tcount").val();
			
			
					if(count != tot_testimonials)
					{
						var data = {'action': 'get_new_testimonial_in_carousel','count':count};
					
						jQuery.post(ajaxurl, data, function(response) 
						{
							//~ var jsns_r=JSON.parse(response);
							//~ //console.log(jsns_r.count);
							//~ //jQuery(".testimonials-div .owl-stage-outer .owl-stage").append(jsns_r.html);
							//~ jQuery(".testimonials-div").owlCarousel();
							//~ //jQuery(".testimonials-div").data('owlCarousel').addItem(jsns_r.html);
							//~ //jQuery(".testimonials-div.owl-carousel").data('owlCarousel').add(jsns_r.html);
							//~ 
							//~ phtml=jQuery('.testimonials-div.owl-carousel').trigger('prepared.owl.carousel', [jsns_r.html]).trigger('refresh.owl.carousel');
							//~ 
							//~ console.log(phtml);
							//~ //jQuery('.testimonials-div.owl-carousel').trigger('add.owl.carousel', [jsns_r.html]).trigger('refresh.owl.carousel');
							//~ jQuery('.tcount').val(parseInt(count)+parseInt(jsns_r.count));
						});
					}			
				});
		});	
	</script>	
<?php
}
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
function cd_meta_box_add()
{
add_meta_box( 'logo-link', 'Logo Link', 'cd_meta_box_cb', 'client-logo', 'normal', 'high' ); 
}

function cd_meta_box_cb($post)
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['clogo_link'] ) ? esc_attr( $values['clogo_link'][0] ) : "";
	// We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
   ?>
    <label for="clogo_link">Enter Logo Link</label>
    <input type="text" name="clogo_link" id="clogo_link" value="<?php echo $text; ?>"/>
    <?php
}
add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
     // Make sure your data is set before trying to save it
    if( isset( $_POST['clogo_link']))
        update_post_meta( $post_id, 'clogo_link', wp_kses( $_POST['clogo_link'], $allowed ));
}

add_action( 'add_meta_boxes', 'testimonial_meta_box_add' );
function testimonial_meta_box_add()
{
add_meta_box( 'position', 'Position', 'testimonial_meta_box_cb', 'testimonial', 'normal', 'high' ); 
}

function testimonial_meta_box_cb($post)
{
	$values = get_post_custom( $post->ID );
	$text = isset( $values['tposition'] ) ? esc_attr( $values['tposition'][0] ) : "";
	// We'll use this nonce field later on when saving.
    wp_nonce_field( 'tmy_meta_box_nonce', 'meta_box_nonce' );
   ?>
    <label for="tposition">Enter Position</label>
    <input type="text" name="tposition" id="tposition" value="<?php echo $text; ?>"/>
    <?php
}
add_action( 'save_post', 'testimonial_meta_box_save' );
function testimonial_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'tmy_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
     // Make sure your data is set before trying to save it
    if( isset( $_POST['tposition']))
        update_post_meta( $post_id, 'tposition', wp_kses( $_POST['tposition'], $allowed ));
}

?>