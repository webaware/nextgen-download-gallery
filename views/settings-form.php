<?php
// settings form

if (!defined('ABSPATH')) {
	exit;
}
?>

<?php settings_errors(); ?>

<div class="wrap">

	<h1><?php esc_html_e('NextGEN Download Gallery', 'nextgen-download-gallery'); ?></h1>

	<form action="<?= esc_url(admin_url('options.php')); ?>" method="POST">
		<?php settings_fields(NGG_DLGALL_OPTIONS); ?>

		<p>
			<input name="ngg_dlgallery[enable_all]" id="ngg_dlgallery_enable_all" type="checkbox" value="1" <?php checked($options['enable_all'], 1); ?> />
			<label for="ngg_dlgallery_enable_all"><?php esc_html_e('download all images', 'nextgen-download-gallery'); ?></label>
		</p>

		<?php submit_button(); ?>
	</form>

</div>
