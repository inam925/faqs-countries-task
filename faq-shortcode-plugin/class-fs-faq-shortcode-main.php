<?php
/**
 * Plugin Name:       FAQ Shortcode Plugin
 * Description:       Display FAQ's with shortcode
 * Version:           1.0.0
 * Author:            Inam Ul Haq
 * Developed By:      Inam Ul Haq
 * Author URI:        https://github.com/inam925
 * Support:           https://github.com/inam925
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       faq_textdomain
 * WC requires at least: 7.0.0
 * WC tested up to: 8.*.*
 *
 * @package FAQ_Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Fs_FAQ_Shortcode_Main' ) ) {
	/**
	 * This class initializes and manages the core functionality.
	 */
	class Fs_FAQ_Shortcode_Main {
		/**
		 * Initialize the plugin.
		 */
		public function __construct() {
			$this->fs_initialize_constants();
			add_action( 'after_setup_theme', array( $this, 'fs_textdomain' ) );
			add_action( 'init', array( $this, 'fs_create_custom_post_type' ) );

			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'af_eic_plugin_action_links' ) );

			if ( is_admin() ) {
				include_once FS_SHORTCODE_PATH . 'includes/admin/class-fs-faq-shortcode-admin.php';
			} else {
				include_once FS_SHORTCODE_PATH . 'includes/front/class-fs-faq-shortcode-front.php';
			}
		}

		/**
		 * Initialize plugin constants.
		 */
		public function fs_initialize_constants() {
			if ( ! defined( 'FS_SHORTCODE_PATH' ) ) {
				define( 'FS_SHORTCODE_PATH', plugin_dir_path( __FILE__ ) );
			}
			if ( ! defined( 'FS_SHORTCODE_URL' ) ) {
				define( 'FS_SHORTCODE_URL', plugin_dir_url( __FILE__ ) );
			}
		}

		/**
		 * Loads the translation text domain for enabling localization and translation of the plugin's strings.
		 */
		public function fs_textdomain() {
			if ( function_exists( 'load_plugin_textdomain' ) ) {
				load_plugin_textdomain( 'faq_textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			}
		}

		/**
		 * Create a custom post type.
		 */
		public function fs_create_custom_post_type() {
			$supports = array(
				'title',
			);
			$labels   = array(
				'name'           => _x( 'Frequently Asked Questions', 'plural', 'faq_textdomain' ),
				'singular_name'  => _x( 'FAQ', 'singular', 'faq_textdomain' ),
				'menu_name'      => _x( 'FAQ\'s', 'admin menu', 'faq_textdomain' ),
				'name_admin_bar' => _x( 'FAQ\'s', 'admin bar', 'faq_textdomain' ),
				'add_new'        => _x( 'Add New', 'add new', 'faq_textdomain' ),
				'add_new_item'   => __( 'Add new FAQ', 'faq_textdomain' ),
				'new_item'       => __( 'New FAQ', 'faq_textdomain' ),
				'edit_item'      => __( 'Edit FAQ', 'faq_textdomain' ),
				'view_item'      => __( 'View FAQ', 'faq_textdomain' ),
				'all_items'      => __( 'Frequently Asked Questions', 'faq_textdomain' ),
				'search_items'   => __( 'Search FAQs', 'faq_textdomain' ),
				'not_found'      => __( 'No FAQ found.', 'faq_textdomain' ),
				'attributes'     => __( 'FAQ Priority', 'faq_textdomain' ),
			);
			$args     = array(
				'supports'            => $supports,
				'labels'              => $labels,
				'query_var'           => true,
				'hierarchical'        => false,
				'show_ui'             => true,
				'menu_position'       => 50,
				'public'              => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'has_archive'         => false,
				'rewrite'             => array( 'slug' => 'faqs' ),
			);
			register_post_type( 'fs_faq_cpt', $args );
		}

		/**
		 * Add custom action links on plugin screen.
		 *
		 * @param mixed $actions Plugin Actions Links.
		 * @return array
		 */
		public function af_eic_plugin_action_links( $actions ) {
			$custom_actions = array(
				'settings' => sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=fs_faq_cpt' ), __( 'Settings', 'faq_textdomain' ) ),
			);
			return array_merge( $custom_actions, $actions );
		}
	}
	new Fs_FAQ_Shortcode_Main();
}
