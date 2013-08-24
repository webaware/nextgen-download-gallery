<?php
/*
Plugin Name: NextGEN Download Gallery
Plugin URI: http://snippets.webaware.com.au/wordpress-plugins/nextgen-download-gallery/
Description: Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries
Version: 1.3.1
Author: WebAware
Author URI: http://www.webaware.com.au/
Text Domain: nextgen-download-gallery
Domain Path: /languages
*/

/*
copyright (c) 2012-2013 WebAware Pty Ltd (email : rmckay@webaware.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

This program incorporates some code that is copyright by Photocrati Media 2012
under the GPLv2. Please see the readme.txt file distributed with NextGEN Gallery
for more information: http://wordpress.org/plugins/nextgen-gallery/

*/

if (!defined('NGG_DLGALL_PLUGIN_ROOT')) {
	define('NGG_DLGALL_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('NGG_DLGALL_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
}

class NextGENDownloadGallery {

	protected static $taglist = false;				// for recording taglist when building gallery for nggtags_ext shortcode

	/**
	* hook WordPress to handle script and style fixes
	*/
	public static function run() {
		add_action('init', array(__CLASS__, 'init'));

		// register AJAX actions
		add_action('wp_ajax_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));
		add_action('wp_ajax_nopriv_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));
	}

	/**
	* initialise plugin, after other plugins have loaded
	*/
	public static function init() {
		add_action('wp_enqueue_scripts', array(__CLASS__, 'enqueueScripts'));
		add_filter('plugin_row_meta', array(__CLASS__, 'addPluginDetailsLinks'), 10, 2);

		// load gettext domain
		load_plugin_textdomain('nextgen-download-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');

		// NextGEN Gallery integration
		add_filter('ngg_render_template', array(__CLASS__, 'nggRenderTemplate'), 10, 2);

		// custom shortcodes
		add_shortcode('nggtags_ext', array(__CLASS__, 'shortcodeTags'));

		// work-arounds for NGG2
		if (defined('NEXTGEN_GALLERY_PLUGIN_VERSION')) {
			add_filter('query_vars', array(__CLASS__, 'addNgg2QueryVars'));
		}
	}

	/**
	* add back some missing query vars that NextGEN Gallery 2.0 has dropped
	* @param array $query_vars
	* @return array
	*/
	public function addNgg2QueryVars($query_vars) {
		$query_vars[] = 'gallerytag';

		return $query_vars;
	}

	/**
	* enqueue any scripts we need
	*/
	public static function enqueueScripts() {
		wp_enqueue_script('jquery');
	}

	/**
	* extend the nggtags shortcode to permit template specification
	* @param array $attrs
	* @param string $content
	* @return string
	*/
	public static function shortcodeTags($attrs, $content = '') {
		$template = isset($attrs['template']) ? $attrs['template'] : '';
		$images = isset($attrs['images']) ? $attrs['images'] : false;

        if (!empty($attrs['album']))
            $out = self::nggShowAlbumTags($attrs['album'], $template, $images);
        else
            $out = self::nggShowGalleryTags($attrs['gallery'], $template, $images);

        return $out;
	}

	/**
	* nggShowGalleryTags() - create a gallery based on the tags
	* copyright (c) Photocrati Media 2012, modified to permit a template specification
	* @param string $taglist list of tags as csv
	* @param string $template the template to use, if any
	* @param int $images how many images per page, defaults to all
	* @return string
	*/
	protected static function nggShowGalleryTags($taglist, $template, $images = false) {

		// $_GET from wp_query
		$pid    = get_query_var('pid');
		$pageid = get_query_var('pageid');

		// NextGEN Gallery 2 can show gallery of tags with template
		if (defined('NEXTGEN_GALLERY_PLUGIN_VERSION')) {
			$params = array (
				'display_type' => 'photocrati-nextgen_basic_thumbnails',
				'tag_ids' => $taglist,
				'template' => $template,
			);
			$registry = C_Component_Registry::get_instance();
			$renderer = $registry->get_utility('I_Displayed_Gallery_Renderer');
			$out = $renderer->display_images($params);
		}

		// and now for NextGEN Gallery 1.9.x:
		else {
			// get now the related images
			$picturelist = nggTags::find_images_for_tags($taglist , 'ASC');

			// look for ImageBrowser if we have a $_GET('pid')
			if ( $pageid == get_the_ID() || !is_home() ) {
				if (!empty( $pid ))  {
					$out = nggCreateImageBrowser($picturelist, $template);
					return $out;
				}
			}

			// go on if not empty
			if ( empty($picturelist) )
				return;

			// show gallery
			if ( is_array($picturelist) ) {
				// record taglist and set filter to override gallery title with taglist
				self::$taglist = $taglist;
				add_filter('ngg_gallery_object', array(__CLASS__, 'nggGalleryObjectTagged'));

				// process gallery using selected template
				$out = nggCreateGallery($picturelist, false, $template, $images);

				// remove filter for gallery title
				remove_filter('ngg_gallery_object', array(__CLASS__, 'nggGalleryObjectTagged'));
			}
		}

		$out = apply_filters('ngg_show_gallery_tags_content', $out, $taglist);
		return $out;
	}

	/**
	* nggShowAlbumTags() - create a gallery based on the tags
	* copyright (c) Photocrati Media 2012, modified to permit a template specification
	* @param string $taglist list of tags as csv
	* @param string $template the template to use, if any
	* @param int $images how many images per page, defaults to all
	* @return string
	*/
	protected static function nggShowAlbumTags($taglist, $template, $images = false) {
		global $nggRewrite;

		// NextGEN Gallery 2.0.7 defines class nggRewrite but doesn't instantiate it
		if (class_exists('nggRewrite') && !isset($nggRewrite))
			$nggRewrite = new nggRewrite();

		// $_GET from wp_query
		$tag            = get_query_var('gallerytag');
		$pageid         = get_query_var('pageid');

		// look for gallerytag variable
		if ( $pageid == get_the_ID() || !is_home() )  {
			if (!empty( $tag ))  {
				$slug = esc_attr( $tag );
				$term = get_term_by('name', $slug, 'ngg_tag');
				$tagname = $term->name;
				$out  = '<div id="albumnav"><span><a href="' . get_permalink() . '" title="' . __('Overview', 'nggallery') .' ">'.__('Overview', 'nggallery').'</a> | '.$tagname.'</span></div>';
				$out .=  self::nggShowGalleryTags($slug, $template, $images);
				return $out;
			}
		}

		// get now the related images
		$picturelist = nggTags::get_album_images($taglist);

		// go on if not empty
		if ( empty($picturelist) )
			return;

		// re-structure the object that we can use the standard template
		foreach ($picturelist as $key => $picture) {
			$picturelist[$key]->previewpic  = $picture->pid;
			$picturelist[$key]->previewname = $picture->filename;
			$picturelist[$key]->previewurl  = site_url() . '/' . $picture->path . '/thumbs/thumbs_' . $picture->filename;
			$picturelist[$key]->counter     = $picture->count;
			$picturelist[$key]->title       = $picture->name;
			$picturelist[$key]->pagelink    = $nggRewrite->get_permalink(array('gallerytag' => $picture->slug));
		}

		// TODO: Add pagination later
		$navigation = '<div class="ngg-clear"></div>';

		// create the output
		$out = nggGallery::capture('album-compact', array('album' => 0, 'galleries' => $picturelist, 'pagination' => $navigation));

		$out = apply_filters('ngg_show_album_tags_content', $out, $taglist);

		return $out;
	}

	/**
	* override gallery title with taglist
	* @param stdClass $gallery
	* @return stdClass
	*/
	public static function nggGalleryObjectTagged($gallery) {
		if (self::$taglist) {
			$title = 'tagged: ' . self::$taglist;
			$gallery->title = apply_filters('ngg_dlgallery_tags_gallery_title', $title, self::$taglist);
		}

		return $gallery;
	}

	/**
	* tell NextGEN about our custom template
	* @param string $custom_template the path to the custom template file (or false if not known to us)
	* @param string $template_name name of custom template sought
	* @return string
	*/
	public static function nggRenderTemplate($custom_template, $template_name) {
		if ($template_name == 'gallery-download') {
			// see if theme has customised this template
			$custom_template = locate_template("nggallery/$template_name.php");
			if (!$custom_template) {
				// no custom template so set to the default
				$custom_template = NGG_DLGALL_PLUGIN_ROOT . "templates/$template_name.php";
			}
		}

		return $custom_template;
	}

	/**
	* AJAX call for downloading a bunch of NextGEN gallery images as a ZIP archive
	*/
	public static function ajaxDownloadZip() {
		global $nggdb;

		$images = $_REQUEST['pid'];
		$gallery = trim(stripslashes($_REQUEST['gallery']));

		if (is_array($images) && count($images) > 0) {
			// allow a long script run for pulling together lots of images
			set_time_limit(60 * 60);

			// stop/clear any output buffering
			while (ob_get_level()) {
				ob_end_clean();
			}

			// turn off compression on the server
			if (function_exists('apache_setenv'))
				@apache_setenv('no-gzip', 1);
			@ini_set('zlib.output_compression', 'Off');

			if (!class_exists('PclZip')) {
				require ABSPATH . 'wp-admin/includes/class-pclzip.php';
			}

			$filename = tempnam(get_temp_dir(), 'zip');
			$zip = new PclZip($filename);
			$files = array();

			foreach ($images as $image) {
				$image = $nggdb->find_image($image);
				if ($image) {
					$files[] = apply_filters('ngg_dlgallery_image_path', $image->imagePath, $image);
				}
			}

			if (count($files) > 0) {
				// create the Zip archive, without paths or compression (images are generally already compressed)
				$properties = $zip->create($files, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_NO_COMPRESSION);
				if (!is_array($properties)) {
					die($zip->errorInfo(true));
				}
				unset($zip);

				// send the Zip archive to the browser
				$zipName = apply_filters('ngg_dlgallery_zip_filename', sanitize_file_name($gallery) . '.zip', $gallery);
				header('Content-Description: File Transfer');
				header('Content-Type: application/zip');
				header('Content-Disposition: attachment; filename=' . $zipName);
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($filename));

				$chunksize = 64 * 1024;
				$file = @fopen($filename, 'rb');
				while (!feof($file)) {
					echo @fread($file, $chunksize);
					flush();
				}
				fclose($file);

				// check for bug in some old PHP versions, close a second time!
				if (is_resource($file))
					fclose($file);

				// delete the temporary file
				@unlink($filename);

				exit;
			}
		}
	}

	/**
	* action hook for adding plugin details links
	*/
	public static function addPluginDetailsLinks($links, $file) {
		if ($file == NGG_DLGALL_PLUGIN_NAME) {
			$links[] = '<a href="http://wordpress.org/support/plugin/nextgen-download-gallery">' . __('Get help', 'nextgen-download-gallery') . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/nextgen-download-gallery/">' . __('Rating', 'nextgen-download-gallery') . '</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=P3LPZAJCWTDUU">' . __('Donate', 'nextgen-download-gallery') . '</a>';
		}

		return $links;
	}
}

NextGENDownloadGallery::run();
