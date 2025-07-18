<?php
/**
 * Plugin Name: Social Profile Links
 * Plugin URI: https://github.com/insertapps/social-profile-links
 * Description: Adds social media profile fields to user profiles and displays them on the front-end. Lightweight and developer-friendly.
 * Version: 1.0.0
 * Author: InsertApps
 * Author URI:  https://insertapps.com/plugins/social-profile-links
 * License: MIT
 * Text Domain: social-profile-links
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include necessary files.
require_once plugin_dir_path( __FILE__ ) . 'inc/social-profile-links-display.php';

// Initialize the plugin.
class Social_Profile_Links {

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		// Add social media fields to user profile.
		add_filter( 'user_contactmethods', array( $this, 'add_contact_methods' ) );

		// Register the shortcode to display social media links.
		add_shortcode( 'social_profile_links', array( $this, 'social_links_shortcode' ) );

		// Add settings link to the plugin.
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'add_settings_link' ) );

		// Make the function available globally
		add_action( 'init', array( $this, 'register_global_function' ) );
	}

	/**
	 * Add social media contact methods to user profile.
	 *
	 * @param array $methods Old contact methods.
	 * @return array New contact methods.
	 */
	public function add_contact_methods( $methods ) {
		$default_methods = array(
			'facebook'  => __( 'Facebook', 'social-profile-links' ),
			'twitter'   => __( 'X/Twitter', 'social-profile-links' ),
			'linkedin'  => __( 'LinkedIn', 'social-profile-links' ),
			'instagram' => __( 'Instagram', 'social-profile-links' ),
			'youtube'   => __( 'YouTube', 'social-profile-links' ),
			'tiktok'    => __( 'TikTok', 'social-profile-links' ),
			'donate'    => __( 'Donate', 'social-profile-links' ),
			'linktree'  => __( 'Linktree', 'social-profile-links' ),
		);

		// Filter to add/change platform
		 $custom_methods = apply_filters( 'social_profile_links_platforms', $default_methods );
		
		return array_merge( $methods, $custom_methods );
	}

	/**
	 * Shortcode to display social media links.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML content for social media links.
	 */
	public function social_links_shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'user_id' => get_the_author_meta( 'ID' ),
		), $atts, 'social_profile_links' );

		return $this->get_social_profile_links( $atts['user_id'] );
	}

	/**
	 * Get social profile links HTML.
	 *
	 * @param int $user_id User ID to get social links for. Default is current user.
	 * @return string HTML content for social media links.
	 */
	public function get_social_profile_links( $user_id = 0 ) {
		if ( ! $user_id ) {
			$user_id = get_the_author_meta( 'ID' );
		}
		
		return display_social_links( $user_id );
	}

	/**
	 * Add settings link to the plugin action links.
	 *
	 * @param array $links Existing links.
	 * @return array Modified links.
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'profile.php' ) . '">' . __( 'Settings', 'social-profile-links' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Register the global function.
	 */
	public function register_global_function() {
		if ( ! function_exists( 'get_social_profile_links' ) ) {
			function get_social_profile_links( $user_id = 0 ) {
				return Social_Profile_Links::get_instance()->get_social_profile_links( $user_id );
			}
		}
	}
}

// Initialize the plugin.
Social_Profile_Links::get_instance();