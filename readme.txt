=== Menu Cart Divi===
Contributors: themeythemes
Tags: divi, cart, menu cart, woocommerce
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 5.6
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Enhance your Divi Builder with the 'Menu Cart Module Divi' plugin. It adds a new module to display a cart icon with item count and price, improving your e-commerce user experience.

== Description ==

Divi Menu Cart plugin is a powerful addition to your Divi Builder. This plugin is designed to enhance your e-commerce website's functionality by adding a new module that displays a cart icon, item count, and total price. It is specifically designed to work with WooCommerce, so please ensure you have WooCommerce installed and active on your site.

It offers easy configuration options, including the ability to show or hide the cart icon, item count, and price as per your needs.

== Features ==

* **Icon Customization**: Adjust the icon's font size and color to match your site's design.

* **Font Customization**: Customize the fonts for different elements of the cart menu. You can set distinct fonts for the cart menu, item count, and price, allowing for a highly personalized appearance.

* **Single Item Text**: Specify the text to display when there is only one item in the cart. This allows you to tailor the language to your audience and brand.

* **Multiple Item Text**: Specify the text to display when there are multiple items in the cart.

* **Show/Hide Icon**: Choose whether to display the cart icon.

* **Show Item Count**: Decide whether to display the number of items in the cart.

* **Hide Item Text**: Choose whether to hide the text indicating the number of items in the cart.

* **Show Price**: Opt to display the total price of items in the cart.

To configure the plugin, navigate to the **Dashboard > Divi Menu Cart**. This is where you'll find the primary settings for the plugin. However, to customize the appearance of specific elements such as the price, item text, and icon, you'll need to go to the module settings. The module settings offer more granular control over the look and feel of these elements, allowing you to tailor them to your site's design. Remember, the Divi Menu Cart is a module, so its settings are split between the main settings page and the module's own settings.

**Useful Links for the Plugin**

* [Divi Menu Cart Plugin Page](https://www.learnhowwp.com/divi-menu-cart/): Visit the official plugin page for an overview and features of the Divi Menu Cart.
* [Divi Menu Cart Documentation](https://www.learnhowwp.com/documentation/menu-cart-divi/): Access the comprehensive documentation for detailed instructions on how to install, configure, and use the plugin.
* [Add Cart Icon With Item Count and Price In Theme Builder with Divi Menu Cart Module](https://www.learnhowwp.com/divi-cart-icon-number-price-theme-builder/): Check out this getting started guide to learn how to add a cart icon with item count and price in the Theme Builder using the Divi Menu Cart module.

**More Free Divi Plugins**

* [Divi Contact Form DB](https://wordpress.org/plugins/contact-form-db-divi/)
* [Divi Post Carousel Module](https://wordpress.org/plugins/post-carousel-divi/)
* [Divi Overlay on Images Module](https://wordpress.org/plugins/overlay-image-divi-module/)
* [Divi Breadcrumbs Module](https://wordpress.org/plugins/breadcrumbs-divi-module/)
* [Divi Flip Cards Module](https://wordpress.org/plugins/flip-cards-module-divi/)
* [Divi Breadcrumbs Module](https://wordpress.org/plugins/breadcrumbs-divi-module/)
* [Divi Image Carousel](https://wordpress.org/plugins/image-carousel-divi/)

If you have any questions or feature ideas please create a new thread in Support.

== Installation ==
1. Ensure you have WooCommerce installed and active.
2. Upload .zip file to the `/wp-content/plugins/` directory
3. Activate the plugin through the `Plugins` page in your `WordPress Dashboard`.

== Frequently Asked Questions ==

= Where can I access the module? =

After you activate the plugin a module should automaically appear in the module list. The name of the module is Menu Cart. You will also see a new top level menu item in your dashboard by the name of Divi Menu Cart. Check the screenshot.

= What if I can't find a specific feature or setting in the plugin? =

The Divi Menu Cart plugin is a free plugin and comes with a set number of features. If you can't find a specific feature or setting, it's likely that it wasn't included in the initial development of the plugin. In such cases, you're welcome to open a feature request on the support page. All the features provided by this plugin are listed in the plugin description.

= How can I set the text to display when there is only one item in the cart? =

You can set the text to display when there is only one item in the cart by navigating to the module settings in the Divi Menu Cart plugin. Look for the "Single Item Text" option.

= How can I show or hide the item count in the Divi Menu Cart plugin? =

You can show or hide the item count by navigating to the module settings in the Divi Menu Cart plugin. Look for the "Show Item Count" option.

= How can I show the total price of items in the cart? =

You can set the text to display when there is only one item in the cart by navigating to the module settings in the Divi Menu Cart plugin. Look for the "Single Item Text" option.

= How can I show or hide the item count in the Divi Menu Cart plugin? =

You can show or hide the item count by navigating to the module settings in the Divi Menu Cart plugin. Look for the "Show Item Count" option.

= How can I show the total price of items in the cart? =

You can show the total price of items in the cart by navigating to the module settings in the Divi Menu Cart plugin. Look for the "Show Price" option.

== Changelog ==

=1.2=
* Added functionality to check for WooCommerce at the start of render.
* Improved code formatting for better readability and maintenance.
* Introduced an option to hide item text.
* Implemented functionality to refresh cart on page load, to avoid issue of outdated layout being after plugin settings were changed.
* Modularized rating notice functionality into its own class for better code organization.
* Added custom CSS fields to module for increased customization options.

=1.1=
* Set default values for the content. The content, price and item count will be displayed if options are not saved in database.

=1.0.0=
* First Commit