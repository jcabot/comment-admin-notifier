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
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		add_options_page(
			'Comment Admin Notifier Options', 					// The title to be displayed in the browser window for this page.
			'Comment Admin Notifier Options',					// The text to be displayed for this menu item
			'manage_options',					// Which type of users can see this menu item, aiming at admin users only
			'comment_admin_notifier_options',			// The unique ID - that is, the slug - for this menu item
            array( $this, 'render_settings_page_content')		// The name of the function to call when rendering this menu's page
		);

	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_display_options() {

		$defaults = array(
			'show_header'		=>	'',
			'show_content'		=>	'',
			'show_footer'		=>	'',
		);

		return $defaults;

	}



	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'input_example'		=>	'default input example',
			'textarea_example'	=>	'',
			'checkbox_example'	=>	'',
			'radio_example'		=>	'2',
			'time_options'		=>	'default'
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the  menu defined above.
	 */
	public function render_settings_page_content() {
        echo "This is the comment admin notifier  Page";
	 /**
	    ?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'WPPB Demo Options', 'wppb-demo-plugin' ); ?></h2>
			<?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'social_options' ) {
				$active_tab = 'social_options';
			} else if( $active_tab == 'input_examples' ) {
				$active_tab = 'input_examples';
			} else {
				$active_tab = 'display_options';
			} // end if/else ?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=wppb_demo_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Display Options', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=wppb_demo_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=wppb_demo_options&tab=input_examples" class="nav-tab <?php echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Input Examples', 'wppb-demo-plugin' ); ?></a>
			</h2>

			<form method="post" action="options.php">
				<?php

				if( $active_tab == 'display_options' ) {

					settings_fields( 'wppb_demo_display_options' );
					do_settings_sections( 'wppb_demo_display_options' );

				} elseif( $active_tab == 'social_options' ) {

					settings_fields( 'wppb_demo_social_options' );
					do_settings_sections( 'wppb_demo_social_options' );

				} else {

					settings_fields( 'wppb_demo_input_examples' );
					do_settings_sections( 'wppb_demo_input_examples' );

				} // end if/else

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
      */
	}




	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options() {

		// If the theme options don't exist, create them.
		if( false == get_option( 'wppb_demo_display_options' ) ) {
			$default_array = $this->default_display_options();
			add_option( 'wppb_demo_display_options', $default_array );
		}


		add_settings_section(
			'general_settings_section',			            // ID used to identify this section and with which to register options
			__( 'Display Options', 'wppb-demo-plugin' ),		        // Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    // Callback used to render the description of the section
			'wppb_demo_display_options'		                // Page on which to add this section of options
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_header',						        // ID used to identify the field throughout the theme
			__( 'Header', 'wppb-demo-plugin' ),					// The label to the left of the option interface element
			array( $this, 'toggle_header_callback'),	// The name of the function responsible for rendering the option interface
			'wppb_demo_display_options',	            // The page on which this option will be displayed
			'general_settings_section',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'wppb-demo-plugin' ),
			)
		);

		add_settings_field(
			'show_content',
			__( 'Content', 'wppb-demo-plugin' ),
			array( $this, 'toggle_content_callback'),
			'wppb_demo_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the content.', 'wppb-demo-plugin' ),
			)
		);

		add_settings_field(
			'show_footer',
			__( 'Footer', 'wppb-demo-plugin' ),
			array( $this, 'toggle_footer_callback'),
			'wppb_demo_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the footer.', 'wppb-demo-plugin' ),
			)
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'wppb_demo_display_options',
			'wppb_demo_display_options'
		);

	} // end wppb-demo_initialize_theme_options





	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_input_examples() {
		//delete_option('wppb_demo_input_examples');
		if( false == get_option( 'wppb_demo_input_examples' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wppb_demo_input_examples', $default_array );
		} // end if

		add_settings_section(
			'input_examples_section',
			__( 'Input Examples', 'wppb-demo-plugin' ),
			array( $this, 'input_examples_callback'),
			'wppb_demo_input_examples'
		);

		add_settings_field(
			'Input Element',
			__( 'Input Element', 'wppb-demo-plugin' ),
			array( $this, 'input_element_callback'),
			'wppb_demo_input_examples',
			'input_examples_section'
		);

		add_settings_field(
			'Textarea Element',
			__( 'Textarea Element', 'wppb-demo-plugin' ),
			array( $this, 'textarea_element_callback'),
			'wppb_demo_input_examples',
			'input_examples_section'
		);

		add_settings_field(
			'Checkbox Element',
			__( 'Checkbox Element', 'wppb-demo-plugin' ),
			array( $this, 'checkbox_element_callback'),
			'wppb_demo_input_examples',
			'input_examples_section'
		);



		register_setting(
			'wppb_demo_input_examples',
			'wppb_demo_input_examples',
			array( $this, 'validate_input_examples')
		);

	}





}