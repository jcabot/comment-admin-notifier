<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Comment_Admin_Notifier
 * @subpackage Comment_Admin_Notifier/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Comment_Admin_Notifier
 * @subpackage Comment_Admin_Notifier/public
 * @author     Jordi Cabot <jcabotsagrera@gmail.com>
 */
class Comment_Admin_Notifier_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/comment-admin-notifier-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/comment-admin-notifier-public.js', array( 'jquery' ), $this->version, false );

	}

    public function comment_post_action_callback( $comment_id, $comment_approved ) {

        //we first check if the option to alert admins has been checked or not
        if(get_option('email_comment_admin_alert') && $comment_approved)
        {
            //Retrieve all data of the comment -  WP_Comment_Query arguments
            // WP_Comment_Query arguments
            $args = array(
                'id'             => $comment_id,
            );

            // The Comment Query
            $comment_query = new WP_Comment_Query( $args );
            if ( $comment_query ) {
                $comment= $comment_query[0];

                $admins_to_email= $this->get_admins_to_alert();
                foreach ($admins_to_email as $admin_to_email)
                {
                    $to = $admin_to_email->user_email;
                    $subject = 'New comment in the post '. $comment->post_name ;
                    $body = 'Post '. $comment->post_name . ' has a new approved comment. Check it out!';
                    wp_mail( $to, $subject, $body );
                }
            }
        }

    }



    /**
     * Get email addresses of all admin users except for "fake" users created by hosting companies to manage your site
     *
     * @since    1.0.0
     */
    public function get_admins_to_alert(){
        // WP_User_Query arguments to identify the "fake" users
        $args_hosting_users = array(
            'role'           => 'Administrator',
            'search'         => 'wpengine',
            'search_columns' => array( 'user_login' ),
            'fields'          => array( 'ID'),
        );

        // The User Query
        $user_query_hosting_users = new WP_User_Query( $args_hosting_users );
        $users_to_exclude = array();
        // The User Loop
        if ( ! empty( $user_query_hosting_users->results ) ) {
            $users_to_exclude=$user_query_hosting_users['ID'];
        }


        // WP_User_Query arguments to select all admin except for those returned in the previous query
        $args = array(
            'role'           => 'Administrator',
            'exclude'        => $users_to_exclude,
            'fields'         => array( 'user_nicename', 'user_login', 'user_email' ),
        );
        $user_query = new WP_User_Query( $args );

        return $user_query;

    }
}
