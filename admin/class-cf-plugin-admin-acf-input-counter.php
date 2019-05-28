<?php
/**
 * File Name: class-cf-plugin-admin-acf-input-counter.php
 * Description: Plugin merged in from @Hube2 with modifications
 * Version:
 * Author: @Hube2
 * Modified By: Nick Makris
 *
 * @link https://github.com/Hube2/acf-input-counter
 *
 */

class ACF_Input_Counter
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

	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	} // end public function __construct

	private function run() {
		// cannot run on field group editor or it will
		// add code to every ACF field in the editor
		$run = true;
		global $post;
		if ( $post && $post->ID && get_post_type( $post->ID ) == 'acf-field-group' ) {
			$run = false;
		}

		return $run;
	} // end private function run

	public function render_field( $field ) {
		//echo '<pre>'; print_r($field); echo '</pre>';
		if ( ! $this->run() || ! $field['maxlength'] || ( $field['type'] != 'text' && $field['type'] != 'textarea' ) ) {
			// only run on text and text area fields when maxlength is set
			return;
		}
		if ( function_exists( 'mb_strlen' ) ) {
			$len = mb_strlen( $field['value'] );
		} else {
			$len = strlen( $field['value'] );
		}
		$max = $field['maxlength'];

		$classes = apply_filters( 'acf-input-counter/classes', [] );
		$ids     = apply_filters( 'acf-input-counter/ids', [] );

		$insert = true;
		if ( count( $classes ) || count( $ids ) ) {
			$insert = false;

			$exist = [];
			if ( $field['wrapper']['class'] ) {
				$exist = explode( ' ', $field['wrapper']['class'] );
			}
			$insert = $this->check( $classes, $exist );

			if ( ! $insert && $field['wrapper']['id'] ) {
				$exist = [];
				if ( $field['wrapper']['id'] ) {
					$exist = explode( ' ', $field['wrapper']['id'] );
				}
				$insert = $this->check( $ids, $exist );
			}
		} // end if filter classes or ids

		if ( ! $insert ) {
			return;
		}
		$display = sprintf( __( '%1$s out of %2$s Characters allowed', 'acf-counter' ), '%%len%%', '%%max%%' );
		$display = apply_filters( 'acf-input-counter/display', $display );
		$display = str_replace( '%%len%%', '<span class="count">' . $len . '</span>', $display );
		$display = str_replace( '%%max%%', $max, $display );
		
		printf('<span class="char-count">%s</span>', $display);
		
	} // end public function render_field

	private function check( $allow, $exist ) {
		// if there is anything in $allow
		// see if any of those values are in $exist
		$intersect = array_intersect( $allow, $exist );
		
		return count ( $intersect ) ? true : false;
		
	} // end private function check

}
