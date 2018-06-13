<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="shortcut icon" type="image/png" href="<?php echo ot_get_option("fevicon_icon"); ?>"/>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<?php //get_template_part( 'template-parts/header/header', 'image' ); ?>
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<div class="logo">
						<?php if(ot_get_option("logo")!='') { ?>
							<a href="<?php echo site_url(); ?>"><img height='77' width='450' src="<?php echo ot_get_option("logo"); ?>" alt="logo" /></a>
						<?php } ?>
					</div>
					<div class="menu_wrapper">
						<div class="links_wrap">
							<?php
								  if ( function_exists( 'ot_get_option' ) ) {
									$social_media_channels = array(
									  "Facebook" => "fa fa-facebook",
									  "Twitter" => "fa fa-twitter",
									  "LinkedIn" => "fa fa-linkedin",
									  "Googleplus" => "fa fa-google-plus"
									);
									
									$social_media_icons = ot_get_option( 'social_links' );
								  };
							?>
							<ul class="social-media-icons">
							  <?php 
							  //~ echo "<pre>";
							  //~ print_r($social_media_icons);
								if ( $social_media_icons ) {
								  foreach ( $social_media_icons as $key=>$icon ) {
									if ( $social_media_channels[$icon['name']] ) {
									  echo "<li class='social-media-icon'><a class='".strtolower($social_media_icons[$key]['name'])."' target='_blank' href='" . $icon['href'] . "'><i class='" . $social_media_channels[$icon['name']] . "'></i></a></li>";
									}
								  }
								}
							  ?>
							</ul>
							
							<?php  
							if(!is_user_logged_in())
							{ 
								get_template_part( 'template-parts/navigation/navigation', 'top' ); 
							}
							else
							{ $current_user = wp_get_current_user();
							  if($current_user->display_name !='')
							  {
								  $welcome=$current_user->display_name;
							  }
							  else
							  {
								  $welcome=$current_user->user_email;
							  }		
								
							?>
								<ul id="top-menu" class="menu">
									<li>Welcome <?php echo $welcome; ?></li>
									<li><a href="<?php echo wp_logout_url(site_url()); ?>">LOGOUT</a></li>
								</ul>	
							<?php	
							}
							?>
						</div>
						<div class="call_us">
							<p><?php echo ot_get_option("call_us_section"); ?> </p>
						</div>
					</div>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; 
			//echo do_shortcode('[rev_slider alias="gravitybpxslider"]');
		?>
		
	</header><!-- #masthead -->

	<?php
	// If a regular post or page, and not the front page, show the featured image.
	if ( has_post_thumbnail() && ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) ) :
		echo '<div class="single-featured-image-header">';
		the_post_thumbnail( 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
	endif;
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">
			<?php
				if(is_front_page())
				{
					echo do_shortcode('[rev_slider alias="gravitybpxslider"]');
				}	
			?>