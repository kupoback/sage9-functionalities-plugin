<?php
/**
 * File Name: options-fields.php
 *
 * @link    Tutorial https://github.com/rayman813/smashing-custom-fields/blob/master/smashing-fields-approach-1/smashing-fields.php
 *
 */

$value = get_option($args['uid']);

if (!$value)
	$value = $args['default'];

$placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
$helper      = isset($args['helper']) ? $args['helper'] : '';

switch ($args['type']) {
	case 'text':
	case 'password':
	case 'number':
		printf(
			'<input class="regular-text" name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" autocomplete="off" aria-label="%5$s" />',
			$args['uid'],
			$args['type'],
			$placeholder,
			$value,
			$args['title']
		);
		break;
	case 'textarea':
		printf(
			'<textarea class="regular-text" name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
			$args['uid'],
			$placeholder,
			$value
		);
		break;
	case 'select':
	case 'multiselect':
		if (!empty ($args['options']) && is_array($args['options'])) {
			$attributes     = '';
			$options_markup = '';
			foreach ($args['options'] as $key => $label) {
				$options_markup .= sprintf(
					'<option value="%s" %s>%s</option>',
					$key,
					isset($value[0]) ? selected($value[array_search($key, $value, true)], $key, false) : '',
					$label
				);
			}
			if ($args['type'] === 'multiselect')
				$attributes = ' multiple="multiple" ';

			printf(
				'<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>',
				$args['uid'],
				$attributes,
				$options_markup
			);
		}
		break;
	case 'radio':
	case 'checkbox':
		if (!empty ($args['options']) && is_array($args['options'])) {
			$options_markup = '';
			$i              = 0;
			foreach ($args['options'] as $key => $label) {
				// $i ++;
				$options_markup .= sprintf(
					'<label for="%1$s"><input id="%1$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
					$args['uid'],
					$args['type'],
					$key,
					isset($value[0]) ? checked($value[array_search($key, $value, true)], $key, false) : '',
					$label
				// $i
				);
			}
			printf('<fieldset>%s</fieldset>', $options_markup);
		}
		break;
	case 'page_link':
	case 'file' :
	case 'image' :
		if (!empty($value)) {
			$image_attributes = wp_get_attachment_image_src($value);
			$src              = $image_attributes[0];
			$title            = get_the_title($value);
		}
		else {
			$src = $title = '';
		}
		?>
		<div class="<?php echo CF_PLUGIN_SLUG; ?>-media-container" id="cf_plugin_media-container">
			<input type="hidden" name="<?php echo $args['uid']; ?>" value="<?php echo $value; ?>" data-name="hidden-media" />
			<div class="has-value media-wrap hide <?php echo $args['type']; ?>-type">
				<?php if ($args['type'] === 'image') : ?>
					<span class="image"><img src="<?php echo $src; ?>" data-src="<?php echo $src; ?>" data-name="media" /></span>
				<?php elseif ($args['type'] === 'file') : ?>
					<p class="file-name" data-name="media"><b>File Name</b>: <span><?php echo $title; ?></span></p>
				<?php endif; ?>
				<div class="<?php echo CF_PLUGIN_SLUG; ?>-hover">
					<p id="<?php echo CF_PLUGIN_SLUG; ?>-edit" class="cf_plugin-icon -change" data-name="edit" title="Change"></p>
					<p id="<?php echo CF_PLUGIN_SLUG; ?>-remove" class="cf_plugin-icon -remove" data-name="remove" title="Remove"></p>
				</div>
			</div>
			<div class="no-value hide">
				<?php if ($args['type'] === 'image') : ?>
					<p><?php _e('No image selected'); ?></p>
					<p><input type="button" id="<?php echo CF_PLUGIN_SLUG; ?>-media-upload" class="button button-primary" value="Select Image" data-name="add"></p>
				<?php elseif ($args['type'] === 'file') : ?>
					<p><?php _e('No file selected'); ?></p>
					<p><input type="button" id="<?php echo CF_PLUGIN_SLUG; ?>-media-upload" class="button button-primary" value="Select File" data-name="add"></p>
				<?php endif; ?>
			</div>
		</div>
		<?php

		break;
}

if ($helper)
	printf('<span class="helper"> %s</span>', $helper);
//
//		if( $supplimental = $args['supplimental'] )
//			printf( '<p class="description">%s</p>', $supplimental );
