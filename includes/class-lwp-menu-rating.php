<?php
/**
 * Handles the rating functionality for the Menu Cart Divi plugin.
 *
 * This file defines the LWP_MENU_RATING class, which sets up the rating functionality
 * for the LWP Menu. It registers necessary WordPress hooks, sets the activation time
 * of the plugin, checks the installation time of the plugin, and handles the 'spare me'
 * functionality.
 *
 * @package    menu-cart-divi
 * @subpackage includes
 */

/**
 * Class LWP_MENU_RATING
 *
 * This class handles the rating functionality for the Menu Cart Divi.
 */
class LWP_MENU_RATING {

	/**
	 * LWP_MENU_RATING constructor.
	 *
	 * Registers the necessary WordPress hooks.
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'menu_cart_check_installation_time' ) );
		add_action( 'admin_init', array( $this, 'menu_cart_spare_me' ), 5 );
	}

	/**
	 * Sets the activation time of the plugin.
	 *
	 * This function is called when the plugin is activated.
	 */
	public function menu_cart_activation_time() {
		$get_activation_time = strtotime( 'now' );
		add_option( 'lwpdm_menu_cart_activation_time', $get_activation_time );
	}

	/**
	 * Checks the installation time of the plugin.
	 *
	 * This function is called on 'admin_init' hook.
	 */
	public function menu_cart_check_installation_time() {
		$install_date = get_option( 'lwpdm_menu_cart_activation_time' );
		$spare_me     = get_option( 'lwpdm_menu_cart_spare_me' );
		$past_date    = strtotime( '-7 days' );
		if ( false === $install_date ) {
			return;
		}
		if ( $past_date >= $install_date && false === $spare_me ) {
			add_action( 'admin_notices', array( $this, 'menu_cart_rating_admin_notice' ) );
		}
	}

	/**
	 * Displays a rating admin notice.
	 *
	 * This function is called when the plugin has been active for 7 days.
	 */
	public function menu_cart_rating_admin_notice() {
		$screen          = get_current_screen();
		$allowed_screens = array( 'dashboard', 'plugins' );
		if ( ! in_array( $screen->base, $allowed_screens, true ) ) {
			return;
		}

		$nonce        = wp_create_nonce( 'menu_cart_nonce' );
		$dont_disturb = esc_url( get_admin_url() . '?lwpdm_menu_cart_spare_me=1&menu_cart_nonce=' . $nonce );
		$dont_show    = esc_url( get_admin_url() . '?lwpdm_menu_cart_spare_me=1&menu_cart_nonce=' . $nonce );
		$plugin_info  = 'Divi Menu Cart';
		$reviewurl    = esc_url( 'https://wordpress.org/support/plugin/menu-cart-divi/reviews/?filter=5' );

        // phpcs:disable
        // All variables in the printf are escaped in the start of the function.
		printf(
			__(
				'<div class="wrap notice notice-info">
                        <div style="margin:10px 0px;">
                            <p>Hello! Seems like you are using <strong> %s </strong> plugin to build your Divi website. &#127775; If you\'ve found it helpful, could you take a moment to rate us 5 stars &#127775; on WordPress? It would mean the world to us and help others choose the right plugin. Thank you!</p>
                        </div>
                        <div class="button-group" style="margin:10px 0px;">
                            <a href="%2$s" class="button button-primary" target="_blank" style="margin-right:10px;">Ok,you deserve it</a>
                            <span class="dashicons dashicons-smiley"></span><a href="%3$s" class="button button-link" style="margin-right:10px; margin-left:3px;">I already did</a>
                            <a href="%4$s" class="button button-link"> Don\'t show this again.</a>
                        </div>
                    </div>',
				'lwp-divi-module'
			),
			$plugin_info,
			$reviewurl,
			$dont_disturb,
			$dont_show
		);
        // phpcs:enable
	}

	/**
	 * Handles the 'spare me' functionality which disables the rating admin notice.
	 *
	 * This function is called on 'admin_init' hook.
	 */
	public function menu_cart_spare_me() {
		if ( isset( $_GET['menu_cart_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['menu_cart_nonce'] ) ), 'menu_cart_nonce' ) ) {
			if ( ! empty( $_GET['lwpdm_menu_cart_spare_me'] ) ) {
				add_option( 'lwpdm_menu_cart_spare_me', true );
			}
		}
	}
}
