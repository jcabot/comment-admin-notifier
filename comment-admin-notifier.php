<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://jordicabot.com
 * @since             1.0.0
 * @package           Comment_Admin_Notifier
 *
 * @wordpress-plugin
 * Plugin Name:       Comment Admin Notifier
 * Plugin URI:        http://jordicabot.com/comment-admin-notifier/
 * Description:       Enables admin users to be notified about all new published comments (even if they're not the authors of the posts)
 * Version:           0.1.0
 * Author:            Jordi Cabot
 * Author URI:        http://jordicabot.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       comment-admin-notifier
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_comment_admin_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-comment-admin-notifier-activator.php';
	Comment_Admin_Notifier::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_comment_admin_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-comment-admin-notifier-deactivator.php';
	Comment_Admin_Notifier_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_comment_admin_notifier' );
register_deactivation_hook( __FILE__, 'deactivate_comment_admin_notifier' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-comment-admin-notifier.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_comment_admin_notifier() {

	$plugin = new Comment_Admin_Notifier();
	$plugin->run();

}
run_plugin_name();
