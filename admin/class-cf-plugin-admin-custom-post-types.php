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
	class CF_Plugin_Admin_CPT
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

		public function team_post_type()
		{

			if (!post_type_exists('team'))
			{

				$labels     = [
					'name'                  => _x('Team Members', 'Post Type General Name', 'team-members'),
					'singular_name'         => _x('Team', 'Post Type Singular Name', 'team-members'),
					'menu_name'             => __('Team Members', 'team-members'),
					'name_admin_bar'        => __('Team', 'team-members'),
					'archives'              => __('Team Members', 'team-members'),
					'attributes'            => __('Team Attributes', 'team-members'),
					'parent_item_colon'     => __('', 'team-members'),
					'all_items'             => __('All Members', 'team-members'),
					'add_new_item'          => __('Add New Member', 'team-members'),
					'add_new'               => __('Add New Member', 'team-members'),
					'new_item'              => __('New Member', 'team-members'),
					'edit_item'             => __('Edit Member', 'team-members'),
					'update_item'           => __('Update Member', 'team-members'),
					'view_item'             => __('View Member', 'team-members'),
					'view_items'            => __('View Team', 'team-members'),
					'search_items'          => __('Search Team', 'team-members'),
					'not_found'             => __('Not found', 'team-members'),
					'not_found_in_trash'    => __('Not found in Trash', 'team-members'),
					'featured_image'        => __('Headshot', 'team-members'),
					'set_featured_image'    => __('Set headshot', 'team-members'),
					'remove_featured_image' => __('Remove headshot', 'team-members'),
					'use_featured_image'    => __('Use as headshot', 'team-members'),
					'insert_into_item'      => __('Insert into team member', 'team-members'),
					'uploaded_to_this_item' => __('Uploaded to this team member', 'team-members'),
					'items_list'            => __('Teamlist', 'team-members'),
					'items_list_navigation' => __('Team list navigation', 'team-members'),
					'filter_items_list'     => __('Filter team list', 'team-members'),
				];
				$supports   = [
					'title',
					'editor',
					// 'author',
					'thumbnail',
					// 'excerpt',
					// 'trackbacks',
					// 'custom-fields',
					// 'comments',
					// 'revisions',
					'page-attributes',
					// 'post-formats'
				];
				$taxonomies = [
					// 'offices',
					// 'locations'
				];

				$args = [
					'label'               => __('Team', 'team-members'),
					'description'         => __('Team Members Post Type', 'team-members'),
					'labels'              => $labels,
					'supports'            => $supports,
					'taxonomies'          => $taxonomies,
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'menu_position'       => 25,
					'menu_icon'           => 'dashicons-groups',
					'show_in_admin_bar'   => true,
					'show_in_nav_menus'   => true,
					'can_export'          => true,
					'has_archive'         => false,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'capability_type'     => 'page',
					'show_in_rest'        => true,
				];
				register_post_type('team', $args);
			}
		}

	}
