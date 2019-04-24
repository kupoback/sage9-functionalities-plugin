<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cliquestudios.com/
 * @since      1.0.0
 *
 * @package    CF_Plugin
 * @subpackage CF_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CF_Plugin
 * @subpackage CF_Plugin/admin
 * @author     Clique Studios <buildsomething@cliquestudios.com>
 */
class CF_Plugin_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/cf-admin.min.css', [], $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/cf-admin.min.js', ['jquery'], $this->version, true);

	}

	/**
	 * Function Name: add_menu_page
	 * Description: Creates a location within the wp-admin for the options page OR the location to add the sub_options page
	 *
	 * @since 1.0.0
	 */
	public function add_menu_page()
	{
		$icon = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/PjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+PHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgNTIyLjQ2OCA1MjIuNDY5IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCAyMCAyMCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGRlZnM+PHN0eWxlPi5ncmV5e2ZpbGw6I2EwYTVhYTt9PC9zdHlsZT48L2RlZnM+PHBhdGggY2xhc3M9ImdyZXkiIGQ9Ik0zMjUuNzYyLDcwLjUxM2wtMTcuNzA2LTQuODU0Yy0yLjI3OS0wLjc2LTQuNTI0LTAuNTIxLTYuNzA3LDAuNzE1Yy0yLjE5LDEuMjM3LTMuNjY5LDMuMDk0LTQuNDI5LDUuNTY4TDE5MC40MjYsNDQwLjUzIGMtMC43NiwyLjQ3NS0wLjUyMiw0LjgwOSwwLjcxNSw2Ljk5NWMxLjIzNywyLjE5LDMuMDksMy42NjUsNS41NjgsNC40MjVsMTcuNzAxLDQuODU2YzIuMjg0LDAuNzY2LDQuNTIxLDAuNTI2LDYuNzEtMC43MTIgYzIuMTktMS4yNDMsMy42NjYtMy4wOTQsNC40MjUtNS41NjRMMzMyLjA0Miw4MS45MzZjMC43NTktMi40NzQsMC41MjMtNC44MDgtMC43MTYtNi45OTkgQzMzMC4wODgsNzIuNzQ3LDMyOC4yMzcsNzEuMjcyLDMyNS43NjIsNzAuNTEzeiIvPjxwYXRoIGNsYXNzPSJncmV5IiBkPSJNMTY2LjE2NywxNDIuNDY1YzAtMi40NzQtMC45NTMtNC42NjUtMi44NTYtNi41NjdsLTE0LjI3Ny0xNC4yNzZjLTEuOTAzLTEuOTAzLTQuMDkzLTIuODU3LTYuNTY3LTIuODU3IHMtNC42NjUsMC45NTUtNi41NjcsMi44NTdMMi44NTYsMjU0LjY2NkMwLjk1LDI1Ni41NjksMCwyNTguNzU5LDAsMjYxLjIzM2MwLDIuNDc0LDAuOTUzLDQuNjY0LDIuODU2LDYuNTY2bDEzMy4wNDMsMTMzLjA0NCBjMS45MDIsMS45MDYsNC4wODksMi44NTQsNi41NjcsMi44NTRzNC42NjUtMC45NTEsNi41NjctMi44NTRsMTQuMjc3LTE0LjI2OGMxLjkwMy0xLjkwMiwyLjg1Ni00LjA5MywyLjg1Ni02LjU3IGMwLTIuNDcxLTAuOTUzLTQuNjYxLTIuODU2LTYuNTYzTDUxLjEwNywyNjEuMjMzbDExMi4yMDQtMTEyLjIwMUMxNjUuMjE3LDE0Ny4xMywxNjYuMTY3LDE0NC45MzksMTY2LjE2NywxNDIuNDY1eiIvPjxwYXRoIGNsYXNzPSJncmV5IiBkPSJNNTE5LjYxNCwyNTQuNjYzTDM4Ni41NjcsMTIxLjYxOWMtMS45MDItMS45MDItNC4wOTMtMi44NTctNi41NjMtMi44NTdjLTIuNDc4LDAtNC42NjEsMC45NTUtNi41NywyLjg1N2wtMTQuMjcxLDE0LjI3NSBjLTEuOTAyLDEuOTAzLTIuODUxLDQuMDktMi44NTEsNi41NjdzMC45NDgsNC42NjUsMi44NTEsNi41NjdsMTEyLjIwNiwxMTIuMjA0TDM1OS4xNjMsMzczLjQ0MiBjLTEuOTAyLDEuOTAyLTIuODUxLDQuMDkzLTIuODUxLDYuNTYzYzAsMi40NzgsMC45NDgsNC42NjgsMi44NTEsNi41N2wxNC4yNzEsMTQuMjY4YzEuOTA5LDEuOTA2LDQuMDkzLDIuODU0LDYuNTcsMi44NTQgYzIuNDcxLDAsNC42NjEtMC45NTEsNi41NjMtMi44NTRMNTE5LjYxNCwyNjcuOGMxLjkwMy0xLjkwMiwyLjg1NC00LjA5NiwyLjg1NC02LjU3IEM1MjIuNDY4LDI1OC43NTUsNTIxLjUxNywyNTYuNTY1LDUxOS42MTQsMjU0LjY2M3oiLz48L3N2Zz4=';
		add_menu_page(
			'Settings', //$page_title
			'Settings',//$menu_title
			'manage_options', //capability
			'cf-plugin-settings', // $menu_slug
			[$this, 'options_page'], // $function
			'', // $icon
			25 // $position
		);

		//		add_submenu_page(
		//			'', // $parent_slug
		//			'', // $page_title
		//			'', // $menu_title
		//			'manage_options', // $capability
		//			'', // $menu_slug
		//			[$this, ''] // $function
		//		);
	}

	/**
	 * Function Name: options_sections
	 * Description: Declaration of each section on the Options Page
	 *
	 * @since 1.0.0
	 */
	public function options_sections()
	{
		$sections = [
			[
				'id'       => 'options_section_one',
				'title'    => '',
				'callback' => [
					$this,
					'options_sections_callback',
				],
				'function' => 'options_fields',
			],
		];

		// Run through each section and register them
		foreach ($sections as $section) {
			add_settings_section(
				$section['id'],
				$section['title'],
				$section['callback'],
				$section['function']
			);
		}
	}

	/**
	 * Function Name: options_fields
	 * Description: The declaration of fields to be used within an options page
	 *
	 * @since   1.0.0
	 *
	 * @link    Tutorial https://github.com/rayman813/smashing-custom-fields/blob/master/smashing-fields-approach-1/smashing-fields.php
	 *
	 */
	public function options_fields()
	{
		/**
		 * Field Parameters
		 *
		 * @uid         string          unique ID for field
		 * @title       string          title for the
		 * @label_for   string          usually the @uid
		 * @section     string          the section this field belongs to
		 * @type        string          type of field - be sure to register it in options-field.php text, password, number, textarea, select, multiselect, checkbox, radio, page_link, file, image
		 * @options     array           used for radio, checkbox, select and multiselect fields use $fields ['default'] as an array
		 * @default     string|array    the default value of the field
		 * @helper      string          the helper text that appears below the input
		 */
		$fields = [];

		if (!empty($fields)) {
			foreach ($fields as $field) {
				add_settings_field(
					$field['uid'],
					$field['title'],
					[
						$this,
						'options_fields_callback',
					],
					'cf_plugin_fields',
					$field['section'],
					$field
				);

				register_setting('cf_plugin_fields', $field['uid']);

			}
		}
	}

	/**
	 * Function Name: main_menu
	 * Description: Grabs the menu page
	 *
	 * @since 1.0.0
	 */
	public function main_menu()
	{
		include(plugin_dir_path(__FILE__) . '/options-page/main-menu.php');
	}

	/**
	 * Function Name: options_page
	 * Description: Grabs the options page
	 *
	 * @since 1.0.0
	 */
	public function options_page()
	{
		include(plugin_dir_path(__FILE__) . '/options-page/options-page.php');
	}

	/**
	 * Function Name: options_sections_callback
	 * Description: Creates the sections
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 *
	 */
	private function options_sections_callback($args)
	{
		include(plugin_dir_path(__FILE__) . '/options-page/options-sections.php');
	}

	/**
	 * Function Name: options_fields_callback
	 * Description: Creates the fields
	 *
	 * @param $args
	 *
	 * @since 1.0.0
	 *
	 */
	private function options_fields_callback($args)
	{
		include(plugin_dir_path(__FILE__) . '/options-page/options-fields.php');
	}

}
