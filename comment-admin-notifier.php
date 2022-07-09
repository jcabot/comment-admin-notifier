<?php

/**
 *
 * @link              https://github.com/jcabot/comment-admin-notifier
 * @since             1.0.0
 * @package           Comment_Admin_Notifier
 *
 * @wordpress-plugin
 * Plugin Name:       Comment Admin Notifier
 * Plugin URI:        https://github.com/jcabot/comment-admin-notifier
 * Description:       Enables admin users to be notified about all new published comments (even if they're not the authors of the posts)
 * Version:           1.1.3
 * Author:            Jordi Cabot
 * Author URI:        https://seriouswp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       comment-admin-notifier
 * Domain Path:       /languages
 *
 * This plugin is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or  any later version.
 *
 * This plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COMMENT_ADMIN_NOTIFIER', '1.1.3' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_comment_admin_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-comment-admin-notifier-activator.php';
	Comment_Admin_Notifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_comment_admin_notifier() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-comment-admin-notifier-deactivator.php';
	Comment_Admin_Notifier_Deactivator::deactivate();
}

/**
 * Register the previous two functions as the functions to execute upon (de)activation of the plugin
 */
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

    /* class located in the class-comment-admin-notifier.php file */
	$plugin = new Comment_Admin_Notifier();
	$plugin->run();
}

run_comment_admin_notifier();
