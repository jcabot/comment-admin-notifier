<?php


/**
 * The public-facing functionality of the plugin in charge of sending the email after a
 *
 * @since      1.0.0
 * @package    Comment_Admin_Notifier\public
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
     * Callback function for the comment_post action. If the plugin settings are checked, it sends an email to all admins
     *
     * @since    1.0.0
     */

    public function comment_post_action_callback( $comment_id, $comment_approved ) {

        //if the admins want to be alerted and the comment is approved
        if(get_option('email_comment_admin_alert') && 1===$comment_approved)
        {

            $comment = WP_Comment::get_instance($comment_id);

            if ( $comment) {
                $comment_on_post=$comment->comment_post_ID;
                $post_author=$this->get_post_author($comment_on_post);

                $admins_to_email= $this->get_admins_to_alert();
                foreach ($admins_to_email as $admin_to_email)
                {
                    if( ($admin_to_email->ID != $post_author) && ($admin_to_email->ID != $comment->user_id)) { //Post authors can already get a  notification
                        $to = $admin_to_email->user_email;
                        $subject = 'New comment in the post ' . $comment->post_name;
                        $body = 'Post ' . $comment->post_name . ' has a new approved comment. Check it out!: ';
                        $body = $body . get_permalink( $comment->comment_post_ID );
                        wp_mail($to, $subject, $body);
                    }
                }
            }
        }

    }



    /**
     * Get email addresses of all admin users except for "fake" users created by some hosting companies to manage your site
     *
     * @since    1.0.0
     */
    public function get_admins_to_alert(){
        // WP_User_Query arguments to identify the "fake" users
        $args_hosting_users = array(
            'role'           => 'Administrator',
            'search'         => 'wpengine',
            'search_columns' => array('user_login'),
            'fields'          => array('ID'),
        );

        // The User Query
        $user_query_hosting_users = new WP_User_Query( $args_hosting_users );
        $users_to_exclude = array();
        // The User Loop
        if ( ! empty( $user_query_hosting_users->results ) ) {
            $users_to_exclude=$user_query_hosting_users->results;
            foreach ($users_to_exclude as $user_to_exclude) {
                $users_ids[] = $user_to_exclude->ID; //adding the new id at the end of the previous ones.
            }
        }


        // WP_User_Query arguments to select all admin except for those returned in the previous query
        $args = array(
            'role'           => 'Administrator',
            'exclude'        => $users_ids,
            'fields'         => array( 'ID', 'user_nicename', 'user_login', 'user_email' ),
        );
        $user_query = new WP_User_Query( $args );

        return $user_query->results;

    }

    /**
     * Get the post author from the post ID
     *
     * @since    1.0.0
     */
    public function get_post_author($post_id)
    {
        $post = WP_Post::get_instance($post_id);
        if (!empty($post)) {
            return $post->post_author;
        }
        return 0;
    }
}
