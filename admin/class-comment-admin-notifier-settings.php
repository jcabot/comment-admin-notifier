<?php

/**
 * The settings of the plugin.
 *
 * @link       http://jordicabot.com
 * @since      1.0.0
 *
 * @package    Comment_Admin_Notifier
 * @subpackage Comment_Admin_Notifier/admin
 */

/**
 * Class Comment_Admin_Notifier_Settings
 *
 */
class Comment_Admin_Notifier_Settings {

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

	}

	/**
	 * This function introduces the plugin options into the a  new options menu and page 'Comment Admin Notifier Options' .
	 */
	/**public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_options_page(
			'Comment Admin Notifier Options', 					// The title to be displayed in the browser window for this page.
			'Comment Admin Notifier Options',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item, aiming at admin users only
			'comment_admin_notifier_options',			// The unique ID - that is, the slug - for this menu item
            array( $this, 'render_settings_page_content')		// The name of the function to call when rendering this menu's page
		);

	} */


	/**
	 * This function introduces the plugin options as a new section in the Settings -> Discussion page  .
	 */
	public function setup_plugin_options_section() {
		add_settings_section(
			'comment_admin_notifier_settings_section',         // ID used to identify this section and with which to register options
			'Comment admin notifier options',                  // Title to be displayed on the administration page
			array($this, 'render_settings_page_content'), // Callback used to render the description of the section
			'discussion'                           // Page on which to add this section of options
		);
        //register_setting( 'discussion', 'comment_admin_notifier_settings_section' );

        // Next, we will introduce the fields for toggling the email alert feature.
        add_settings_field(
            'email_comment_admin_alert',                      // ID used to identify the field throughout the theme
            'Email alert',                           // The label to the left of the option interface element
            array($this, 'render_settings_field_content'),   // The name of the function responsible for rendering the option interface
            'discussion',                          // The page on which this option will be displayed
            'comment_admin_notifier_settings_section',         // The name of the section to which this field belongs
            array(                              // The array of arguments to pass to the callback. In this case, just a description.
                'Activate this setting to get an email every time a new comments gets published.'
            )
        );


        // Finally, we register the field with WordPress
        register_setting(
            'discussion',
            'email_comment_admin_alert'
        );
        
	}


	/**
	 * Renders a simple page to display for the  menu defined above.
	 */
	public function render_settings_page_content()
    {


    }

    /**
     * This function renders the interface elements for toggling the email alert of the header element.
     * It accepts an array of arguments and expects the first element in the array to be the description
     * to be displayed next to the checkbox.
     */
    public function render_settings_field_content($args) {

        // Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field


        $html = '<input type="checkbox" id="email_comment_admin_alert" name="email_comment_admin_alert" value="1" ' . checked(1, get_option('email_comment_admin_alert'), false) . '/>';

        // Here, we will take the first argument of the array and add it to a label next to the checkbox
        $html .= '<label for="email_comment_admin_alert"> '  . $args[0] . '</label>';

        echo $html;



    }










}