<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cliquestudios.com/
 * @since             1.0.0
 * @package           cf_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Functionality Plugin
 * Plugin URI:        #
 * Description:       This plugin is used for a replacement of what one would find in a themes function file, which relates to a
 * sites functionality over that of a themes functionality.
 * Version:           1.0.0
 * Author:            Nick Makris | Clique Studios
 * Author URI:        https://cliquestudios.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CF_PLUGIN_VERSION', '1.0.0');
define('CF_PLUGIN_SLUG', 'cf_plugin');
define('CF_PLUGINS_PATH', plugin_dir_path(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf-plugin-activator.php
 */
function activate_cf_plugin()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-cf-plugin-activator.php';
	cf_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf-plugin-deactivator.php
 */
function deactivate_cf_plugin()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-cf-plugin-deactivator.php';
	cf_Plugin_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_cf_plugin');
register_deactivation_hook(__FILE__, 'deactivate_cf_plugin');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-cf-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf_plugin()
{
	$plugin = new cf_Plugin();
	$plugin->run();

}

run_cf_plugin();
