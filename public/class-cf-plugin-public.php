<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cliquestudios.com/
 * @since      1.0.0
 *
 * @package    CF_Plugin
 * @subpackage CF_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CF_Plugin
 * @subpackage CF_Plugin/public
 * @author     Clique Studios <buildsomething@cliquestudios.com>
 */
class CF_Plugin_Public
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
	 * @param string $plugin_name The name of the plugin.
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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/cf-public.min.css', ['wp-edit-blocks'], $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'dist/cf-public.min.js', ['jquery', 'wp-blocks', 'wp-i18n', 'wp-element'], $this->version, true);
	}

	public function cf_template_example()
	{
		$templates = new CF_Template_Loader();

		ob_start();
		$templates->get_template_part('cf', 'template');
		return ob_get_clean();

	}

}
