# Custom Functions Plugin

The purpose of this plugin is to provide developers with a location to include SITE specific functions that by best practices, should live independently of the theme. This plugin offers support for modular structure in the case of a location for admin functionality and public or frontend functionality. This plugin can be extended to allow for even further organization within each of those directories based on the developers necessities.

This plugin contains a `gulpfile.js` which includes a `sass`, and `js` compiler and watcher. This will output files within their respected director, `admin` or `public` based on which file is being edited. The `gulpfile.js` also support `ES6`, and `React` for Gutenberg block building. Included for the `js` compiler is an `.eslintrc` and `.eslintignore` which is setup and optimized for Gutenberg development, but can be adjusted as needed.

## Uses
 
#### For:

* Custom Post Types
* Custom Taxonomies
* Custom Meta Fields
* Custom Functionality for other plugins
* Adding Custom Gutenberg blocks
* Custom Options Pages

#### Not For:
* Theme support functions: `add_theme_support()`, `add_image_size()`, etc.
* Registering Sidebars and Navigation Menus
* Registering JavaScript or CSS files, including external files for "fonts."

## Folders

### Root
In the root of this plugin has a couple files that can be adjusted. They are:
* `.eslintrc`
* `.eslintignore`
* `gulpfile.js`
* `package.json`
* `cf-plugin.php`
* `uninstall.php`

##### Root Files
`.estlintrc` & `.eslintignore` - Used for the `gulp` script's javascript linter

`gulpfile.js` - The file responsible for running the compiler and watcher for the plugins javascript and sass files.

`cf-plugin.php` - This file is responsible for the registration and running of the entire plugin. There should be very little, if any, work done within this file.

`uninstall.php` - This file is similar to the `class-cf-plugin-deactivator.php` file in the `inculdes/` directory, with the exception that it's contents will only be activated upon the `Delete` action within the `wp-admin`. Be careful what goes in here, as it is meant to be a destructive file. It's best to keep items out of functions, and include any database cleanup within here for custom post types, custom taxonomies, and custom meta fields.

### Public
This folder is reserved for the front facing portion of the site. What this can be used for is anything from creating the front-end Nav Walker to customizing actions or filters for content. Generally if the functionality you're adding affects the front end, it should live here in either the `class-cf-plugin-public.php` or within a respected, relative `.php` file in this folder.

#### Public Folders

`css` - This is where the SASS stylesheets reside.

`js` - In here is a `cf-public.js` which can remain blank, and you can create folders as you want, and insert your js files within.

`partials` - Supposedly reserved for `HTML` markup for the front-end, but usually reserved for plugins with one goal. May remove in the future if remains unsued.

`templates` - If you use shortcodes, you can place your templates within here for easier organization and use of the plugins `CF_Template_Loader` class.

#### Public Files
`class-cf-plugin-public.php` - This is where you can include all your public/front-end functionality. You do not need to organize all the functions into appropriate classes, but organization can be helpful.

`class-gamajo-template-loader.php` & `class-cf-plugin-template-loader.php` - These classes drive the ability to mimic the **WooCommerce**, **bbPress**, **Event Calendar Pro** plugin template override functionality. Within `class-cf-plugin-template-loader.php` adjust the variables within to suit your needs.  

### Admin
This folder is reserved for the admin or back-end of the site. What this is reserved for is anything relative to the admin such as custom post type, custom taxonomies, custom meta fields, etc. If the functionality that you're adding to the site requires integration/interaction within the admin, it should live here. They can live all within the `class-cf-plugin-admin.php` file or with a respected, relative `.php` file in this folder.

#### Admin Folders
`css` - This is where the SASS stylesheets reside.

`js` - In here is a `cf-admin.js` which can remain blank, and you can create folders as you want, and insert your js files within.

`options-page` - See **Options-Page Directory** for file listings, but this folder is used to maintain your option page(s).

`partials` - Supposedly reserved for `HTML` markup for the admin, but usually reserved for plugins with one goal. May remove in the future if remains unsued.

#### Admin Files
`class-cf-plugin-admin.php` - This is where you can include your admin functionality. You do not need to organize all the functions into appropriate classes, but organization can be helpful.

`class-cf-plugin-admin-custom-post-types` - This is where you should register all your custom post types. Be sure to include the action in `class-cf-plugin.php`

`class-cf-plugin-admin-custom-taxonomies` - This is where you should register all your custom taxonomies. Be sure to include the action in `class-cf-plugin.php`

##### Options-Page Directory
`main-menu.php` - This page is needed to declare a menu page. You can adjust the denial text there.

`options-fields.php` - This page is where the input fields are registered for your options page.

`options-page.php` - This page is where you create your options page, and can set the markup within.

`options-sections.php` - This is where you set the `switch` statement for your sections.

##### Includes

This folder should not include any additional files other than the following:
* `class-cf-plugin.php`
* `class-cf-plugin-activator.php`
* `class-cf-plugin-deactivator.php`
* `class-cf-plugin-i18n.php`
* `class-cf-plugin-loader.php`
* `index.php`

If there are any other files added to here, please investigate and migrate them accordingly.

##### Includes Files

`class-cf-plugin.php` - This file will be the most commonly worked in file. This is where you will integrate your `actions` and `filters` needed within the admin and public class files. You will also declare any new `.php` files within the admin or public folders here.

`class-cf-plugin-activator.php` - This file is self explanatory. You should include all actions that needed to be fired upon plugin activation here.

`class-cf-plugin-deactivator.php` - This file is self explanatory. You should include all actions that needed to be fired upon plugin deactivation here.

`class-cf-plugin-i18n.php` - This file is responsible for internationalization of strings within your plugin. The plugin is self-internationalized, but if you wish, you may include the `cf-plugin` slug to any declarations of internationalization.

`class-cf-plugin-loader.php` - This file is where the declared uses of actions and filters defined in `class-cf-plugin.php` are located. You can expand upon this if necessary. 

## Getting Started

### Gulp
Run the following command within the plugins root

`npm install` 

This will install all the necessary components needed to compile and watch our `js` and `sass` files. After the install, you can simply type in `gulp` to run the compiler and watcher.

Additionally, the following `gulp` commands are available:
* `js`      - compile admin and public javascript files
* `css`     - compile admin and public sass files
* `admin`   - compile admin javascript and sass files
* `public`  - compile public javascript and sass files
* `watcher` - start the javascript and sass file watcher
