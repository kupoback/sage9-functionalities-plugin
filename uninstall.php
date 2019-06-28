<?php

	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * When populating this file, consider the following flow
	 * of control:
	 *
	 * - This method should be static
	 * - Check if the $_REQUEST content actually is the plugin name
	 * - Run an admin referrer check to make sure it goes through authentication
	 * - Verify the output of $_GET makes sense
	 * - Repeat with other user roles. Best directly by using the links/query string parameters.
	 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
	 *
	 * This file may be updated more in future version of the Boilerplate; however, this is the
	 * general skeleton and outline for how the file should work.
	 *
	 * For more information, see the following discussion:
	 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
	 *
	 * @link       https://cliquestudios.com/
	 * @since      1.0.0
	 *
	 * @package    cf_Plugin
	 */

	// If uninstall not called from WordPress, then exit.
	if (!defined('WP_UNINSTALL_PLUGIN'))
	{
		exit;
	}

	global $wpdb;
	$plugin_options = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'cf_%'");
	$team_cpt_option = get_option('team_cpt');

	// Delete Team Post Type if enabled.
	if (is_array($team_cpt_option) && in_array('enable', $team_cpt_option))
	{
		$args         = [
			'post_type'      => 'team',
			'post_status'    => 'any',
			'posts_per_page' => - 1,
		];
		$plugin_posts = get_posts($args);

		foreach ($plugin_posts as $post)
		{
			wp_delete_post($post->ID, true);
		}
	}

	// Delete our options
	foreach ($plugin_options as $option_field)
	{
		delete_option($option_field->option_name);
	}

	flush_rewrite_rules();
