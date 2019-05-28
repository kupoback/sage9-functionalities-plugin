<?php
/**
 * File Name: options-page.php
 * Description: The options page surrounding markup
 */

if ( !current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] )
	admin_notice();

function admin_notice() { ?>
	<div class="notice notice-success is-dismissible">
		<p>Your settings have been updated!</p>
	</div>
<?php }


settings_errors( 'cf_plugin_messages' );
?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<form action="options.php" method="post" class="<?php echo CF_PLUGIN_SLUG; ?>-settings">

		<?php
		settings_fields( 'cf_plugin_fields' );
		do_settings_sections( 'cf_plugin_fields' );
		submit_button(); ?>

	</form>
</div>