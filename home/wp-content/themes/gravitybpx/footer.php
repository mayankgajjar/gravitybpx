<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
</div><!-- #content -->
<footer id="colophon" class="site-footer" role="contentinfo">
	
	<div class="upper_footer section-gapping">
		<div class="main-row-container">
			<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );
				//~ get_template_part( 'template-parts/footer/site', 'info' );
			?>
		</div>		
	</div>		
	<div class="lower_footer">
		<div class="main-row-container">
			
			<div class="social_links_footer">
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
					if ( $social_media_icons ) {
					  foreach ( $social_media_icons as $key=>$icon ) {
						if ( $social_media_channels[$icon['name']] ) {
						  echo "<li class='social-media-icon'><a class='".strtolower($social_media_icons[$key]['name'])."' target='_blank' href='" . $icon['href'] . "'><i class='" . $social_media_channels[$icon['name']] . "'></i></a></li>";
						}
					  }
					}
				  ?>
				</ul>
			</div>
			<div class="site_info">
				<p>&#9400; <?php echo date(" Y "); echo "<a href='".site_url()."'>".get_bloginfo()."</a>" ?>. All Rights Reserved.</p>
			</div>
		</div>
		<span class="scrolltop" style="display:none;"></span>
	</div>
</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
<!--
	<div class="sign_up_form" style="display:none">
		<?php //echo do_shortcode('[wpuf_profile type="registration" id="89"]'); ?>
	</div>
	<div class="sign_in_form" style="display:none">
		<?php //echo do_shortcode('[wpuf-login]'); ?>
	</div>
-->
	
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>