<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 * @package    Comment_Admin_Notifier\admin
  */
class Comment_Admin_Notifier_Admin {

	private $plugin_name;

	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        $this->load_dependencies();
    }

    /**
     * Load the required dependencies for the Admin facing functionality.
     *
     * Include the following files that make up the plugin:
     *
     * - Comment_Admin_Notifier_Settings. Registers the admin settings and page.
     *
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for adding the new setting in the Discussion page
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-comment-admin-notifier-settings.php';
    }





}
