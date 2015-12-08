<?php
/*
Plugin Name: NextGEN Download Gallery
Plugin URI: http://shop.webaware.com.au/downloads/nextgen-download-gallery/
Description: Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries
Version: 1.5.3-dev
Author: WebAware
Author URI: http://webaware.com.au/
Text Domain: nextgen-download-gallery
Domain Path: /languages/
*/

/*
copyright (c) 2012-2015 WebAware Pty Ltd (email : support@webaware.com.au)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

This program incorporates some code that is copyright by Photocrati Media 2012
under the GPLv2. Please see the readme.txt file distributed with NextGEN Gallery
for more information: https://wordpress.org/plugins/nextgen-gallery/
*/

if (!defined('ABSPATH')) {
	die('No direct access allowed');
}

define('NGG_DLGALL_PLUGIN_ROOT', dirname(__FILE__) . '/');
define('NGG_DLGALL_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('NGG_DLGALL_PLUGIN_FILE', __FILE__);
define('NGG_DLGALL_PLUGIN_VERSION', '1.5.3-dev');

define('NGG_DLGALL_OPTIONS', 'ngg_dlgallery');

require NGG_DLGALL_PLUGIN_ROOT . 'includes/class.NextGENDownloadGallery.php';
NextGENDownloadGallery::run();
