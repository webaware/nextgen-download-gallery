<?php
/**
Template Page for the Trade/Media gallery, with a download form
Based on basic template (gallery.php) with a few custom additions

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>

<div class="ngg-galleryoverview" id="<?php echo $gallery->anchor ?>">

<h3><?php echo $gallery->title; ?></h3>

<?php if (!empty($gallery->description)): ?>
<p><?php echo $gallery->description; ?></p>
<?php endif; ?>

<?php if ($gallery->show_slideshow) { ?>
	<!-- Slideshow link -->
	<div class="slideshowlink">
		<a class="slideshowlink" href="<?php echo $gallery->slideshow_link ?>">
			<?php echo $gallery->slideshow_link_text ?>
		</a>
	</div>
<?php } ?>

<?php if ($gallery->show_piclens) { ?>
	<!-- Piclense link -->
	<div class="piclenselink">
		<a class="piclenselink" href="<?php echo $gallery->piclens_link ?>">
			<?php _e('[View with PicLens]','nggallery'); ?>
		</a>
	</div>
<?php } ?>

	<!-- Thumbnails -->
	<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" id="ngg-download-frm">
		<input type="hidden" name="action" value="ngg-download-gallery-zip" />
		<input type="hidden" name="gallery" value="<?php echo $gallery->title; ?>" />

		<?php $i = 0; foreach ( $images as $image ) : ?>

		<div id="ngg-image-<?php echo $image->pid ?>" class="ngg-gallery-thumbnail-box" <?php echo $image->style ?> >
			<div class="ngg-gallery-thumbnail" >
				<a href="<?php echo $image->imageURL ?>" title="<?php echo htmlspecialchars($image->description) ?>" <?php echo $image->thumbcode ?> >
					<?php if ( !$image->hidden ) { ?>
					<img title="<?php echo htmlspecialchars($image->alttext) ?>" alt="<?php echo htmlspecialchars($image->alttext) ?>" src="<?php echo $image->thumbnailURL ?>" <?php echo $image->size ?> />
					<?php } ?>
				</a>
				<label><input type="checkbox" name="pid[]" value="<?php echo $image->pid ?>" /><span><?php echo htmlspecialchars($image->alttext) ?></span></label>
			</div>
		</div>

		<?php if ( $image->hidden ) continue; ?>
		<?php if ( $gallery->columns > 0 && (++$i % $gallery->columns) == 0 ) { ?>
			<br style="clear: both" />
		<?php } ?>

		<?php endforeach; ?>

		<hr />
		<input class="button ngg-download-selectall" type="button" style="display:none" value="<?php _e('select all', 'nextgen-download-gallery'); ?>" />
		<input class="button downloadButton" type="submit" value="<?php _e('download selected images', 'nextgen-download-gallery'); ?>" />
	</form>

	<!-- Pagination -->
 	<?php echo $pagination ?>

</div>

<script>
jQuery(function($) {

<?php /* make sure that at least one image is selected before submitting form for download */ ?>
	$("#ngg-download-frm").submit(function(event) {
		if ($("input[name='pid[]']:checked", this).length == 0) {
			event.preventDefault();
			alert("<?php _e('Please select one or more images to download', 'nextgen-download-gallery'); ?>");
		}
	});

<?php /* reveal "select all" button and active it */ ?>
	$("input.ngg-download-selectall").show().click(function() {
		$(this.form).find("input[name='pid[]']").prop({checked: true});
	});

});
</script>

<?php endif; ?>
