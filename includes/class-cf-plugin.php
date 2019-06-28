<?php

	/**
	 * The file that defines the core plugin class
	 *
	 * A class definition that includes attributes and functions used across both the
	 * public-facing side of the site and the admin area.
	 *
	 * @link       https://cliquestudios.com/
	 * @since      1.0.0
	 *
	 * @package    CF_Plugin
	 * @subpackage CF_Plugin/includes
	 */

	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    CF_Plugin
	 * @subpackage CF_Plugin/includes
	 * @author     Clique Studios <buildsomething@cliquestudios.com>
	 */
	class CF_Plugin
	{

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      CF_Plugin_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $plugin_name The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string $version The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct()
		{

			if (defined('CF_PLUGIN_VERSION'))
			{
				$this->version = CF_PLUGIN_VERSION;
			}
			else
			{
				$this->version = '1.0.0';
			}
			$this->plugin_name = 'cf-plugin';

			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - CF_Plugin_Loader. Orchestrates the hooks of the plugin.
		 * - CF_Plugin_i18n. Defines internationalization functionality.
		 * - CF_Plugin_Admin. Defines all hooks for the admin area.
		 * - CF_Plugin_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies()
		{

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cf-plugin-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cf-plugin-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cf-plugin-admin.php';

			/**
			 * The class responsible for defining all custom post types
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cf-plugin-admin-custom-post-types.php';

			/**
			 * The class responsible for defining all custom taxonomies
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cf-plugin-admin-custom-taxonomies.php';

			/**
			 * The class responsible for TinyMCE items
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cf-plugin-admin-tinymce.php';

			/**
			 * This class adds a counter to the textarea box if a char limit is defined
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cf-plugin-admin-acf-input-counter.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-cf-plugin-public.php';

			$this->loader = new CF_Plugin_Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the CF_Plugin_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function set_locale()
		{

			$plugin_i18n = new CF_Plugin_i18n();

			$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks()
		{

			// This is for the ACF Input Counter that informs front end users their current char_count vs max_char_count
			$plugin_admin_acf_input = new ACF_Input_Counter($this->get_plugin_name(), $this->get_version());

			if (!class_exists('ACF'))
			{
				$this->loader->add_action('acf/render_field/type=text', $plugin_admin_acf_input, 'render_field', 20, 1);
				$this->loader->add_action('acf/render_field/type=textarea', $plugin_admin_acf_input, 'render_field', 20, 1);
			}

			/**
			 * Our basic functions, script and style enqueues, and the plugin's options page
			 *
			 * @file class-cf-plugin-admin.php
			 */
			$team_cpt_option = get_option('cf_team_cpt');
			$plugin_admin    = new CF_Plugin_Admin($this->get_plugin_name(), $this->get_version());

			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
			$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
			// Options
			$this->loader->add_action('admin_menu', $plugin_admin, 'add_menu_page');
			$this->loader->add_action('admin_init', $plugin_admin, 'options_sections');
			$this->loader->add_action('admin_init', $plugin_admin, 'options_fields');
			// Team Metabox
			if (is_array($team_cpt_option) && in_array('enable', $team_cpt_option))
			{
				$this->loader->add_action('add_meta_boxes', $plugin_admin, 'team_metabox');
				$this->loader->add_action('save_post', $plugin_admin, 'save_team_meta_fields');
			}

			/**
			 * Our custom post types
			 *
			 * @file class-cf-plugin-admin-custom-post-types.php
			 */
			$plugin_admin_cpt = new CF_Plugin_Admin_CPT($this->get_plugin_name(), $this->get_version());
			if (is_array($team_cpt_option) && in_array('enable', $team_cpt_option))
			{
				$this->loader->add_action('init', $plugin_admin_cpt, 'team_post_type', 1);
			}

			/**
			 * Our custom taxonomies
			 *
			 * @file class-cf-plugin-admin-custom-taxonomies.php
			 */
			$plugin_admin_ctax = new CF_Plugin_Admin_CTax($this->get_plugin_name(), $this->get_version());

			/**
			 * Our TinyMCE functions. Checks if Classic Editor plugin is installed
			 * Uncomment to activate the function needed
			 *
			 * @TODO Update this function to incorporate settings for activation
			 */
			$plugin_admin_tinymce = new CF_Plugin_Admin_TinyMCE($this->get_plugin_name(), $this->get_version());

			if (class_exists('Classic_Editor')) :
				// $this->loader->add_filter('mce_buttons', $plugin_admin_tinymce, 'mce_row_two_shift');
				// $this->loader->add_filter('tiny_mce_before_init', $plugin_admin_tinymce,'mce_custom_styles');
				// $this->loader->add_filter('mce_buttons', $plugin_admin_tinymce,'mce_remove_row_one_btns');
				// $this->loader->add_filter('mce_buttons_2', $plugin_admin_tinymce,'mce_remove_row_two_btns');
			endif;
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks()
		{

			$plugin_public = new CF_Plugin_Public($this->get_plugin_name(), $this->get_version());

			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
			$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run()
		{

			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @return    string    The name of the plugin.
		 * @since     1.0.0
		 */
		public function get_plugin_name()
		{

			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @return    CF_Plugin_Loader    Orchestrates the hooks of the plugin.
		 * @since     1.0.0
		 */
		public function get_loader()
		{

			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @return    string    The version number of the plugin.
		 * @since     1.0.0
		 */
		public function get_version()
		{

			return $this->version;
		}

	}
