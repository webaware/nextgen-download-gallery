<?php
// settings form

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php settings_errors(); ?>

<div class="wrap">

	<h2>NextGEN Download Gallery</h2>

	<form action="<?php echo esc_url(admin_url('options.php')); ?>" method="POST">
		<?php settings_fields(NGG_DLGALL_OPTIONS); ?>

		<label>
			<input name="ngg_dlgallery[enable_all]" type="checkbox" value="1" <?php checked($options['enable_all'], 1); ?> />
			<?php esc_html_e('download all images', 'nextgen-download-gallery'); ?>
		</label>

		<?php submit_button(); ?>
	</form>

</div>
