<?php
/*
Plugin Name: NextGEN Download Gallery
Plugin URI: http://snippets.webaware.com.au/wordpress-plugins/nextgen-download-gallery/
Description: Add a template to NextGEN Gallery to provide multiple-file downloads for trade/media galleries
Version: 1.0.0
Author: WebAware
Author URI: http://www.webaware.com.au/
*/

/*
copyright (c) 2012 WebAware Pty Ltd (email : rmckay@webaware.com.au)

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
*/

class NextGENDownloadGallery {

	/**
	* hook WordPress to handle script and style fixes
	*/
	public static function run() {
		// load gettext domain
		load_plugin_textdomain('nextgen-download-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');

		add_action('wp_print_scripts', array(__CLASS__, 'actionScripts'));
		add_filter('ngg_render_template', array(__CLASS__, 'filterNggRenderTemplate'), 10, 2);

		// register AJAX actions
		add_action('wp_ajax_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));
		add_action('wp_ajax_nopriv_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));
	}

	/**
	* enqueue any scripts we need
	*/
	public static function actionScripts() {
		if (!is_admin()) {
			wp_enqueue_script('jquery');
		}
	}

	/**
	* tell NextGEN about our custom template
	* @param string $custom_template the path to the custom template file (or false if not known to us)
	* @param string $template_name name of custom template sought
	* @return string
	*/
	public static function filterNggRenderTemplate($custom_template, $template_name) {
		if ($template_name == 'gallery-download') {
			// see if theme has customised this template
			$custom_template = locate_template("nggallery/$template_name.php");
			if (!$custom_template) {
				// no custom template so set to the default
				$custom_template = dirname(__FILE__) . "/templates/$template_name.php";
			}
		}

		return $custom_template;
	}

	/**
	* AJAX call for downloading a bunch of NextGEN gallery images as a ZIP archive
	*/
	public static function ajaxDownloadZip() {
		global $nggdb;

		$images = $_GET['pid'];
		$gallery = trim(stripslashes($_GET['gallery']));

		if (is_array($images) && count($images) > 0) {
			$zip = new ZipArchive();
			$filename = tempnam(sys_get_temp_dir(), 'zip');

			if ($zip->open($filename, ZIPARCHIVE::CREATE) !== true) {
				die("Can't create ZIP archive: $filename");
			}

			foreach ($images as $image) {
				$image = $nggdb->find_image($image);
				if ($image)
					$zip->addFile($image->imagePath, $image->filename);
			}
			$zip->close();

			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename=' . $gallery . '.zip');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filename));
			readfile($filename);

			// delete the temporary file
			unlink($filename);

			exit;
		}
	}
}

NextGENDownloadGallery::run();
