<?php
/**
 * File Name: class-cf-plugin-admin-acf-input-counter.php
 * Description:
 * Version:
 * Author: Nick Makris
 * Author URI: buildsomething@cliquestudios.com
 *
 */

class ACF_Input_Counter
{

	private $plugin_name;

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
		?>
		<span class="char-count">
					<?php
					echo $display;
					?>
				</span>
		<?php
	} // end public function render_field

	private function check( $allow, $exist ) {
		// if there is anything in $allow
		// see if any of those values are in $exist
		$intersect = array_intersect( $allow, $exist );
		if ( count( $intersect ) ) {
			return true;
		}

		return false;
	} // end private function check

}
