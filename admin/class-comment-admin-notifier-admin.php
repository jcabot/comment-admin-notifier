<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://jordicabot.com
 * @since      0.1.0
 *
 * @package    Comment_Admin_Notifier
 * @subpackage Comment_Admin_Notifier/admin
 * @author     Jordi Cabot <jcabotsagrera@gmail.com>
 */
class Comment_Admin_Notifier_Admin {

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
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-comment-admin-notifier-settings.php';

    }
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/comment-admin-notifier-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/comment-admin-notifier-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function comment_post_action_callback($comment_ID, $comment_approved) {

        //we first check if the option to alert admins has been checked or not

        if( 1 === $comment_approved ){
            //Retrieve the author of the post where the comment has been approved
            // WP_Comment_Query arguments
            $args = array(
                'id'             => $comment_ID,
            );
             // The Comment Query
            $comment_query = new WP_Comment_Query( $args );
            $comments = $comment_query->query( $args );
            // Comment Loop
            if ( $comments ) {
                foreach ( $comments as $comment ) {
                    echo '<p>' . $comment->comment_content . '</p>';
                    
                }
        }

    }



    /**
     * Get email addresses of all admin users except for "fake" users created by hosting companies to manage your site
     *
     * @since    1.0.0
     */
    private function getAdminsToAlert(){
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
