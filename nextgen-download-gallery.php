<?php
/*
Plugin Name: NextGEN Download Gallery
Plugin URI: http://snippets.webaware.com.au/wordpress-plugins/nextgen-download-gallery/
Description: Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries
Version: 1.1.0
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

if (!defined('NGG_DLGALL_PLUGIN_ROOT')) {
	define('NGG_DLGALL_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('NGG_DLGALL_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
}

class NextGENDownloadGallery {

	/**
	* hook WordPress to handle script and style fixes
	*/
	public static function run() {
		// load gettext domain
		load_plugin_textdomain('nextgen-download-gallery', false, dirname(plugin_basename(__FILE__)) . '/languages');

		add_action('wp_enqueue_scripts', array(__CLASS__, 'actionScripts'));
		add_filter('ngg_render_template', array(__CLASS__, 'filterNggRenderTemplate'), 10, 2);

		// register AJAX actions
		add_action('wp_ajax_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));
		add_action('wp_ajax_nopriv_ngg-download-gallery-zip', array(__CLASS__, 'ajaxDownloadZip'));

		// hooks for admin screens
		add_filter('plugin_row_meta', array(__CLASS__, 'addPluginDetailsLinks'), 10, 2);
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

		$images = $_GET['pid'];
		$gallery = trim(stripslashes($_GET['gallery']));

		if (is_array($images) && count($images) > 0) {
			if (!class_exists('PclZip')) {
				require ABSPATH . 'wp-admin/includes/class-pclzip.php';
			}

			$filename = tempnam(get_temp_dir(), 'zip');
			$zip = new PclZip($filename);
			$files = array();

			foreach ($images as $image) {
				$image = $nggdb->find_image($image);
				if ($image) {
					$files[] = $image->imagePath;
				}
			}

			if (count($files) > 0) {
				// create the Zip archive, without paths or compression (images are already compressed)
				$properties = $zip->create($files, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_NO_COMPRESSION);
				if (!is_array($properties)) {
					die($zip->errorInfo(true));
				}

				// send the Zip archive to the browser
				header('Content-Description: File Transfer');
				header('Content-Type: application/zip');
				header('Content-Disposition: attachment; filename=' . sanitize_file_name($gallery) . '.zip');
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

	/**
	* action hook for adding plugin details links
	*/
	public static function addPluginDetailsLinks($links, $file) {
		// add donations link
		if ($file == NGG_DLGALL_PLUGIN_NAME) {
			$links[] = '<a href="http://wordpress.org/support/plugin/nextgen-download-gallery">' . __('Support') . '</a>';
			$links[] = '<a href="http://wordpress.org/extend/plugins/nextgen-download-gallery/">' . __('Rating') . '</a>';
			$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=P3LPZAJCWTDUU">' . __('Donate') . '</a>';
		}

		return $links;
	}

	/**
	* display an error message (already HTML-conformant)
	* @param string $msg HTML-encoded message to display inside a paragraph
	*/
	public static function showError($msg) {
		echo "<div class='error'><p><strong>$msg</strong></p></div>\n";
	}
}

NextGENDownloadGallery::run();
