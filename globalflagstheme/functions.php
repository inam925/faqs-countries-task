<?php

/* Theme Support */
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
the_post_thumbnail('medium'); 

function gft_register_global_nav() {
	register_nav_menu('fs-global-nav', 'Global Nav Menu');
}
add_action('after_setup_theme', 'gft_register_global_nav');

/* Enqueue scripts and styles. */
function gft_global_enqueue_scripts() {
	wp_enqueue_style( 'simple-style', get_template_directory_uri() . '/assets/css/fs-front-style.css', '10000', 'all' );
	wp_enqueue_script( 'simple-js', get_template_directory_uri() . '/assets/js/fs-front-script.js', array(), '1.0.0');

	wp_enqueue_style( 'google_web_fonts', 'https://fonts.googleapis.com/css?family=Oxygen', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'gft_global_enqueue_scripts' );

add_filter('acf/format_value/type=textarea', 'do_shortcode');

/* Register Widget */
function gft_register_widget() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'smp' ),
		'id'            => 'gft-global-sidebar',
		'description'   => __( 'The main sidebar appears on the right on each page except the front page template.', 'smp' ),
		'before_widget' => '<div id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer', 'smp' ),
		'id'            => 'gft-global-footer',
		'description'   => __( 'The main footer appears on the bottom on each page except the front page template.', 'smp' ),
		'before_widget' => '<div id="%1$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'gft_register_widget' );

/* Disable wp-emoji */
function gft_disable_emojis() {
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'gft_disable_emojis' );

/* Disable wp-embed */
function gft_deregister_scripts() {
wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'gft_deregister_scripts' );

add_shortcode( 'display_countries', 'gft_display_countries_shortcode' );

function gft_display_countries_shortcode() {
	ob_start();
	$response       = wp_remote_get( 'https://restcountries.com/v3.1/all?fields=name,flags' );
	$countries_data = wp_remote_retrieve_body( $response );
	$countries_data = json_decode( $countries_data, true );

	if ( is_array( $countries_data ) ) {
		?>
			<div class="gft-countries-list">
			<?php foreach ( $countries_data as $country ) : ?>
					<div class="gft-single-country">
						<img src="<?php echo esc_attr( $country['flags']['png'] ); ?>" alt="<?php echo esc_attr( $country['name']['common'] ); ?> Flag">
						<p><?php echo esc_attr( $country['name']['common'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php
	} else {
		echo 'Error fetching data from the API.';
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
// $site_logo = get_field('site_logo');
// $site_address = get_field('address'); 
// $contact_number = get_field('contact_number'); 