<?php
/**
 * File Name: class-cf-plugin-template-loader.php
 * Description:
 * Version:
 * Author: Nick Makris
 * Author URI: buildsomething@cliquestudios.com
 *
 */

class CF_Template_Loader extends Gamajo_Template_Loader {

	protected $filter_prefix = 'cf';

	protected $theme_template_directory = 'views/cf-templates';

	protected $plugin_directory = CF_PLUGINS_PATH;

	protected $plugin_template_directory = 'public/templates';

}