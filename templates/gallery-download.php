<?php
/**
Template for the NextGEN Download Gallery
Based on basic template (gallery.php) with a few custom additions

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

**/

if (!defined ('ABSPATH'))
	die ('No direct access allowed');

if (!empty($gallery)):
?>

<div class="ngg-galleryoverview ngg-download" id="<?php echo $gallery->anchor ?>">

<h3><?php echo $gallery->title; ?></h3>

<?php if (!empty($gallery->description)): ?>
<p><?php echo $gallery->description; ?></p>
<?php endif; ?>

<?php if (!empty($gallery->show_slideshow)) { ?>
	<div class="slideshowlink">
		<a class="slideshowlink" href="<?php echo $gallery->slideshow_link ?>">
			<?php echo $gallery->slideshow_link_text ?>
		</a>
	</div>
<?php } ?>

<?php if (!empty($gallery->show_piclens)) { ?>
	<div class="piclenselink">
		<a class="piclenselink" href="<?php echo $gallery->piclens_link ?>">
			<?php _e('[View with PicLens]','nextgen-download-gallery'); ?>
		</a>
	</div>
<?php } ?>

	<!-- Thumbnails -->
	<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="<?php echo $gallery->anchor ?>-download-frm" class="ngg-download-frm">
		<input type="hidden" name="action" value="ngg-download-gallery-zip" />
		<input type="hidden" name="gallery" value="<?php echo $gallery->title; ?>" />

		<?php $i = 0; foreach ( $images as $image ) : ?>

		<div id="ngg-image-<?php echo $image->pid ?>" class="ngg-gallery-thumbnail-box" <?php echo $image->style ?> >
			<div class="ngg-gallery-thumbnail" >
				<a href="<?php echo $image->imageURL ?>" title="<?php echo esc_attr($image->description) ?>" <?php echo $image->thumbcode ?> >
					<?php if ( !$image->hidden ) { ?>
					<img title="<?php echo esc_attr($image->alttext) ?>" alt="<?php echo esc_attr($image->alttext) ?>" src="<?php echo $image->thumbnailURL ?>" <?php echo $image->size ?> />
					<?php } ?>
				</a>
				<label><input type="checkbox" name="pid[]" value="<?php echo $image->pid ?>" /><span><?php echo esc_html($image->alttext) ?></span></label>
			</div>
		</div>

		<?php if ( $image->hidden ) continue; ?>
		<?php if ( $gallery->columns > 0 && (++$i % $gallery->columns) == 0 ) { ?>
			<br style="clear: both" />
		<?php } ?>

		<?php endforeach; ?>

		<hr class="ngg-download-separator" />
		<input class="button ngg-download-selectall" type="button" style="display:none" value="<?php _e('select all', 'nextgen-download-gallery'); ?>" />
		<input class="button ngg-download-download downloadButton" type="submit" value="<?php _e('download selected images', 'nextgen-download-gallery'); ?>" />
		<?php
		// get gallery ID for downloading all images, or false if not configured to do so
		$ngg_dlgallery_all_id = NextGENDownloadGallery::getDownloadAllId($gallery);
		if ($ngg_dlgallery_all_id):
		?>
		<input class="button ngg-download-everything" type="submit" name="download-all" style="display:none" value="<?php _e('download all images', 'nextgen-download-gallery'); ?>" />
		<input type="hidden" name="all-id" value="<?php echo esc_attr($ngg_dlgallery_all_id); ?>" />
		<?php endif; ?>
	</form>

	<!-- Pagination -->
 	<?php echo $pagination ?>

</div>

<?php endif; ?>
