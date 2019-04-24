<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cliquestudios.com/
 * @since      1.0.0
 *
 * @package    CF_Plugin
 * @subpackage CF_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CF_Plugin
 * @subpackage CF_Plugin/includes
 * @author     Clique Studios <buildsomething@cliquestudios.com>
 */
class CF_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		/**
		 * Usually best to flush the rewrite rules as a precaution,
		 * especially if one is including custom post types or taxonomies
		 */
		flush_rewrite_rules();
	}

}
