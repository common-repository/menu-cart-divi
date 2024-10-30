<?php
/*
Plugin Name: Menu Cart Module Divi
Plugin URI:  https://www.learnhowwp.com/divi-menu-cart/
Description: This plugins adds a new module in the Divi Builder. The module allows you add cart icon with item count and price.
Version:     1.2
Author:      learnhowwp.com
Author URI:  http://learnhowwp.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lwp-divi-module
Domain Path: /languages

Menu Cart Module Divi is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Menu Cart Module Divi is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Menu Cart Module Divi. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'lwpdm_initialize_menu_cart_extension' ) ) :
	/**
	 * Creates the extension's main class instance.
	 *
	 * @since 1.0.0
	 */
	function lwpdm_initialize_menu_cart_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/MenuCartModuleDivi.php';
	}
	add_action( 'divi_extensions_init', 'lwpdm_initialize_menu_cart_extension' );
endif;

if ( ! function_exists( 'lwpdm_cart_add_to_cart_fragment' ) ) :
	add_filter( 'woocommerce_add_to_cart_fragments', 'lwpdm_cart_add_to_cart_fragment' );

	function lwpdm_cart_add_to_cart_fragment( $fragments ) {

		$single_item_text   = '';
		$multiple_item_text = '';
		$show_icon          = '';
		$show_item_count    = '';
		$hide_item_text     = 'off';
		$show_price         = '';

		$options = get_option( 'lwp_menu_cart_options' );

		if ( false === $options ) {  // Show default content
			$show_icon       = 'on';
			$show_item_count = 'on';
			$hide_item_text  = 'off';
			$show_price      = 'on';
		} else {
			if ( isset( $options['show_item_count'] ) && 'on' === $options['show_item_count'] ) {
				$show_item_count = 'on';
			}

			if ( isset( $options['hide_item_text'] ) && 'on' === $options['hide_item_text'] ) {
				$hide_item_text = 'on';
			}

			if ( isset( $options['show_icon'] ) && 'on' === $options['show_icon'] ) {
				$show_icon = 'on';
			}

			if ( isset( $options['show_price'] ) && 'on' === $options['show_price'] ) {
				$show_price = 'on';
			}

			if ( isset( $options['single_item_text'] ) ) {
				$single_item_text = esc_html( $options['single_item_text'] );
			}

			if ( isset( $options['multiple_item_text'] ) ) {
				$multiple_item_text = esc_html( $options['multiple_item_text'] );
			}
		}

		$cartcount        = '';
		$carttotal        = '';
		$carturl          = '';
		$icon_output      = '';
		$carttotal_output = '';

		if ( 'on' === $show_icon ) {
			$icon_output = '<span class="image_wrap"><span class="lwp_cart_icon et-pb-icon">&#xe07a;</span></span>';
		}

		if ( function_exists( 'WC' ) && 'on' === $show_item_count && 'off' === $hide_item_text ) {

			$total = WC()->cart->get_cart_contents_count();

			if ( ! empty( $single_item_text ) && ! empty( $multiple_item_text ) ) {
				$single   = $total . ' ' . $single_item_text;
				$multiple = $total . ' ' . $multiple_item_text;

				if ( 1 === $total ) {
					$cartcount = $single;
				} else {
					$cartcount = $multiple;
				}
			} elseif ( ! empty( $single_item_text ) && 1 === $total ) {
				$single    = $total . ' ' . $single_item_text;
				$cartcount = $single;
			} elseif ( ! empty( $multiple_item_text ) && ( 0 === $total || $total > 1 ) ) {
				$multiple  = $total . ' ' . $multiple_item_text;
				$cartcount = $multiple;
			} else {
				$cartcount = sprintf( _n( '%d Item', '%d Items', WC()->cart->get_cart_contents_count(), 'lwp-divi-module' ), $total );
			}
		} elseif ( 'on' === $show_item_count && 'on' === $hide_item_text ) {
			$total     = WC()->cart->get_cart_contents_count();
			$cartcount = sprintf( '%d', $total );
		}

		if ( function_exists( 'WC' ) && 'on' === $show_price ) {
			$carttotal = WC()->cart->get_cart_total();
			if ( 'on' === $show_item_count ) {
				$carttotal_output = sprintf( '<span class="lwp_menu_cart_sep"> -</span> %1s', $carttotal );
			} else {
				$carttotal_output = sprintf( '%1s', $carttotal );
			}
		}

		if ( function_exists( 'wc_get_cart_url' ) ) {
			$carturl = wc_get_cart_url();
		}

		$output = sprintf(
			'
        <a  class="lwp_cart_module" href="%1s" title="Cart">
            %2s <span class="lwp_menu_cart_count">%3s</span> %4s
        </a>
    ',
			$carturl,
			$icon_output,
			$cartcount,
			$carttotal_output
		);

		global $woocommerce;

		ob_start();

		$allowed_html = array(
			'a'    => array(
				'class' => array(),
				'href'  => array(),
				'title' => array(),
			),
			'span' => array(
				'class' => array(),
			),
			'bdi'  => array(),
		);

		echo wp_kses( $output, $allowed_html );

		$fragments['a.lwp_cart_module'] = ob_get_clean();

		return $fragments;
	}
endif;


if ( ! function_exists( 'lwpdm_menu_cart_options_page' ) ) :
	// Menu
	add_action( 'admin_menu', 'lwpdm_menu_cart_options_page' );

	function lwpdm_menu_cart_options_page() {
		add_menu_page(
			'Divi Menu Cart',
			'Divi Menu Cart',
			'manage_options',
			'lwp_menu_cart',
			'lwpdm_menu_cart_options_page_output',
			'dashicons-cart'
		);
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_options_page_output' ) ) :
	// Menu Page
	function lwpdm_menu_cart_options_page_output() {
		?>
<div>
	<h2>Divi Menu Cart</h2>
		<?php settings_errors(); ?>
	<form action="options.php" method="post">
		<?php settings_fields( 'lwp_menu_cart_options' ); ?>
		<?php do_settings_sections( 'lwp_menu_cart' ); ?>
	<input class="button-primary" name="Submit" type="submit" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
	</form>
</div>
		<?php
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_admin_init' ) ) :
	// Register Setting, Section and Fields
	add_action( 'admin_init', 'lwpdm_menu_cart_admin_init' );

	function lwpdm_menu_cart_admin_init() {
		register_setting( 'lwp_menu_cart_options', 'lwp_menu_cart_options', 'lwpdm_menu_cart_options_validate' );

		add_settings_section( 'lwp_menu_cart_main_section', 'Main Settings', 'lwpdm_menu_cart_section_text', 'lwp_menu_cart' );

		add_settings_field( 'single_item_text', 'Single Item Text', 'lwpdm_menu_cart_single_item_text', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
		add_settings_field( 'multiple_item_text', 'Multiple Item Text', 'lwpdm_menu_cart_multiple_item_text', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
		add_settings_field( 'show_icon', 'Show Icon', 'lwpdm_menu_cart_show_icon', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
		add_settings_field( 'show_item_count', 'Show Item Count', 'lwpdm_menu_cart_show_item_count', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
		add_settings_field( 'hide_item_text', 'Hide Item Text', 'lwpdm_menu_cart_hide_item_text', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
		add_settings_field( 'show_price', 'Show Price', 'lwpdm_menu_cart_show_price', 'lwp_menu_cart', 'lwp_menu_cart_main_section' );
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_section_text' ) ) :
	// Description text for section
	function lwpdm_menu_cart_section_text() {
		echo '<p>You can set the content for Divi Menu Cart here. The styles can be set inside the Module Settings Design tab.</p>';
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_single_item_text' ) ) :
	// Output  of setting field
	function lwpdm_menu_cart_single_item_text() {

		$options = get_option( 'lwp_menu_cart_options' );
		echo "<input id='single_item_text' name='lwp_menu_cart_options[single_item_text]' type='text' placeholder='Item' value='";
		if ( isset( $options['single_item_text'] ) ) {
			echo esc_attr( $options['single_item_text'] );
		}
		echo "' />";
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_multiple_item_text' ) ) :
	function lwpdm_menu_cart_multiple_item_text() {

		$options = get_option( 'lwp_menu_cart_options' );
		echo "<input id='multiple_item_text' name='lwp_menu_cart_options[multiple_item_text]' type='text' placeholder='Items' value='";
		if ( isset( $options['multiple_item_text'] ) ) {
			echo esc_attr( $options['multiple_item_text'] );
		}
		echo "' />";
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_show_item_count' ) ) :
	function lwpdm_menu_cart_show_item_count() {

		$options = get_option( 'lwp_menu_cart_options' );

		echo "<input id='show_item_count' name='lwp_menu_cart_options[show_item_count]' type='checkbox' ";
		if ( isset( $options['show_item_count'] ) ) {
			echo 'checked';
		}
		echo ' />';
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_hide_item_text' ) ) :
	function lwpdm_menu_cart_hide_item_text() {
		$options = get_option( 'lwp_menu_cart_options' );
		echo "<input id='hide_item_text' name='lwp_menu_cart_options[hide_item_text]' type='checkbox' ";
		if ( isset( $options['hide_item_text'] ) ) {
			echo 'checked';
		}
		echo ' />';
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_show_icon' ) ) :
	function lwpdm_menu_cart_show_icon() {

		$options = get_option( 'lwp_menu_cart_options' );

		echo "<input id='show_icon' name='lwp_menu_cart_options[show_icon]' type='checkbox' ";
		if ( isset( $options['show_icon'] ) ) {
			echo 'checked';
		}
		echo ' />';
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_show_price' ) ) :
	function lwpdm_menu_cart_show_price() {

		$options = get_option( 'lwp_menu_cart_options' );

		echo "<input id='show_price' name='lwp_menu_cart_options[show_price]' type='checkbox' ";
		if ( isset( $options['show_price'] ) ) {
			echo 'checked';
		}
		echo ' />';
	}
endif;

if ( ! function_exists( 'lwpdm_menu_cart_options_validate' ) ) :
	function lwpdm_menu_cart_options_validate( $input ) {

		$output = array();

		if ( isset( $input['single_item_text'] ) ) {
			$output['single_item_text'] = sanitize_text_field( $input['single_item_text'] );
		}

		if ( isset( $input['multiple_item_text'] ) ) {
			$output['multiple_item_text'] = sanitize_text_field( $input['multiple_item_text'] );
		}

		if ( isset( $input['show_item_count'] ) && 'on' === $input['show_item_count'] ) {
			$output['show_item_count'] = sanitize_text_field( $input['show_item_count'] );
		}

		if ( isset( $input['hide_item_text'] ) && 'on' === $input['hide_item_text'] ) {
			$output['hide_item_text'] = sanitize_text_field( $input['hide_item_text'] );
		}

		if ( isset( $input['show_icon'] ) && 'on' === $input['show_icon'] ) {
			$output['show_icon'] = sanitize_text_field( $input['show_icon'] );
		}

		if ( isset( $input['show_price'] ) && 'on' === $input['show_price'] ) {
			$output['show_price'] = sanitize_text_field( $input['show_price'] );
		}

		return $output;
	}
endif;

// ======================================================================================

if ( ! function_exists( 'lwpdm_refresh_cart_on_page_load' ) ) :
	/**
	 * Refresh the WooCommerce fragment on page load.
	 */
	function lwpdm_refresh_cart_on_page_load() {
		?>
<script type="text/javascript" defer="defer">
	jQuery(document).ready(function($) {
		$(document.body).on('wc_fragments_loaded', function() {
			$(document.body).trigger('wc_fragment_refresh');
		});
	});
</script>
		<?php
	}
endif;

// ======================================================================================

require_once plugin_dir_path( __FILE__ ) . 'includes/class-lwp-menu-rating.php';
$lwp_menu_rating = new LWP_MENU_RATING();
register_activation_hook( __FILE__, array( $lwp_menu_rating, 'menu_cart_activation_time' ) );