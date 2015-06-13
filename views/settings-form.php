<?php
// settings form

global $wp_version;
?>

<?php settings_errors(); ?>

<div class="wrap">
	<?php if (version_compare($wp_version, '3.8', '<')) screen_icon('options-general'); ?>
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
