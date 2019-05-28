<?php

class CF_Plugin_Admin_TinyMCE {
	
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
	 * Function Name: cscf_row_two_shifts
	 * Description: Add the TinyMCE ID names to shift them out of their slot to place them
	 *              within another
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 */
	public function cscf_row_two_shifts($buttons) {
		array_unshift($buttons, 'hr');
		array_unshift($buttons, 'pastetext');
		array_unshift($buttons, 'removeformat');
		array_unshift($buttons, 'styleselect');
		return $buttons;
	}
	
	/**
	 * Function Name: cscf_mce_before_init
	 * Description: Custom Style Format items
	 *
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function cscf_mce_before_init($settings) {
		$style_formats = [];
		
		/**
		 * Original Styles for Paragraph tags, and Header 2 - 6 tags
		 * You can edit the style_formats to match the site if needed.
		 */
		$og_style_formats = [
			[
				'title'         => 'Paragraph',
				'block'         => 'p',
				'style_formats' => [
					'font-size'   => '16px',
					'line-height' => '24px',
				],
			],
			[
				'title'         => 'Header 2',
				'block'         => 'h2',
				'style_formats' => [
					'font-size'   => '42px',
					'line-height' => '48px',
				],
			],
			[
				'title'         => 'Header 3',
				'block'         => 'h3',
				'style_formats' => [
					'font-size'   => '30px',
					'line-height' => '40px',
				],
			],
			[
				'title'         => 'Header 4',
				'block'         => 'h4',
				'style_formats' => [
					'font-size'   => '22px',
					'line-height' => '30px',
				],
			],
			[
				'title'         => 'Header 5',
				'block'         => 'h5',
				'style_formats' => [
					'font-size'   => '18px',
					'line-height' => '28px',
				],
			],
			[
				'title'         => 'Header 6',
				'block'         => 'h6',
				'style_formats' => [
					'font-size'   => '16px',
					'line-height' => '28px',
				],
			],
		];
		
		/**
		 * * Add additional style options here. One is commented out for reference,
		 * or visit the link
		 * @link https://www.tiny.cloud/docs/configure/content-formatting/#formats
		 */
		$additional_styles = [
			//			[
			//				'title'         => 'Orange Button',
			//				'selector'      => 'a',
			//				'classes'       => 'round-red-btn',
			//				'style_formats' => [
			//					'color' => '#ff6036',
			//				],
			//			],
		];
		
		array_push($style_formats, $og_style_formats);
		array_push($style_formats, $additional_styles);
		
		$settings['style_formats'] = json_encode($style_formats);
		return $settings;
	}
	
	/**
	 * Function Name: cscf_remove_btns_row_one
	 * Description: This function removes items based on their ID from row 1
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 */
	function cscf_remove_btns_row_one($buttons) {
		$remove_buttons = [
			// format dropdown menu for <p>, headings, etc
			'formatselect',
			'fullscreen',
			'wp_adv',
		];
		foreach ($buttons as $button_key => $button_value) {
			if (in_array($button_value, $remove_buttons)) {
				unset($buttons[$button_key]);
			}
		}
		return $buttons;
	}
	
	/**
	 * Function Name: cscf_remove_btns_row_two
	 * Description: This function removes items based on their ID from row 2
	 *
	 * @param $buttons
	 *
	 * @return mixed
	 */
	public function cscf_remove_btns_row_two ($buttons) {
		$remove_buttons = [
			'underline',
			'hr',
			'alignjustify',
			//text color
			'forecolor',
			'strikethrough',
			//paste as text
			'pastetext',
			//clear formatting
			'removeformat',
			//special characters
			'charmap',
			'outdent',
			'indent',
			'undo',
			'redo',
			//keyboard shortcuts
			'wp_help',
		];
		foreach ($buttons as $button_key => $button_value) {
			if (in_array($button_value, $remove_buttons)) {
				unset($buttons[$button_key]);
			}
		}
		return $buttons;
	}
	
}
