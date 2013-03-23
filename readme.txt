=== NextGEN Download Gallery ===
Contributors: webaware
Plugin Name: NextGEN Download Gallery
Plugin URI: http://snippets.webaware.com.au/wordpress-plugins/nextgen-download-gallery/
Author URI: http://www.webaware.com.au/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=P3LPZAJCWTDUU
Tags: nextgen, gallery, download
Requires at least: 3.2.1
Tested up to: 3.5.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries

== Description ==

Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries. [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) is one of the best gallery plugins for WordPress because it is very flexible and has a nice, simple admin. This plugin adds a new gallery template that lets you select multiple images from the gallery to be downloaded as a ZIP archive.

This plugin is targetted at creating "Trade/Media" areas on websites, allowing journalists to easily download multiple product images.

= Credits =

This program incorporates some code that is copyright by Photocrati Media 2012 under the GPLv2. Some PHP code was copied from NextGEN Gallery and altered, so that the `nggtags` shortcode could be extended as `nggtags_ext` and specify a gallery template.


== Installation ==

1. Install [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) and create galleries/albums
2. Upload this plugin to your /wp-content/plugins/ directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Specify the gallery template as "download"

= From a gallery shortcode =

When using a shortcode to show a NextGEN gallery, you can make it a download gallery by specifying the gallery template:

`[nggallery id=1 template=download]`

= From an album shortcode =

When using a shortcode to show a NextGEN album, you can make it show download galleries by specifying the gallery template:

`[album id=1 gallery=download]`

= From a tags shortcode =

The standard `nggtags` shortcode doesn't allow you to specify the gallery template, so this plugin adds an extended version of that shortcode.

`[nggtags_ext gallery="frogs,lizards" template=download]`

== Frequently Asked Questions ==

= Will this plugin work without NextGEN Gallery? =

No. [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) is doing all the work. This plugin is only adding a new gallery template and the ZIP download functionality.

= Can I make an album use the download template? =

Yes, the album shortcode has separate parameters for album and gallery templates. The "template" parameter tells it which template to use for the album, and the "gallery" parameter tells it which template to use for the gallery. e.g.

`[album id=1 template=compact gallery=download]`

= Can I make the tags shortcode use the download template? =

Not directly; the `nggtags` shortcode doesn't support a template parameter, but this plugin adds a new shortcode that does.

`[nggtags_ext gallery="frogs,lizards" template=download]`

= I don't like the download template; can I customise it? =

Yes. Copy the template from the templates folder in the plugin, into a folder called nggallery in your theme's folder. You can then edit your copy of the template to get the pretty.

= You've translated my language badly / it's missing =

The initial translations were made using Google Translate, so it's likely that some will be truly awful! Please help by editing the .po file for your language and tell me about it in the support forum.

== Screenshots ==

1. example download gallery

== Changelog ==

= 1.2.1 [2013-03-23] =
* fixed: download gallery title is "tagged: {taglist}" when using shortcode `nggtags_ext`; was using gallery title from first image (NextGEN Gallery bug)
* added: filter 'ngg_dlgallery_tags_gallery_title' for changing gallery title when using shortcode `nggtags_ext`

= 1.2.0 [2013-03-23] =
* fixed: template was HTML-encoding the gallery title & description when they are already HTML-encoded
* added: shortcode `nggtags_ext` to extend `nggtags` so that you can specify a gallery template

= 1.1.1 [2012-12-07] =
* fixed: submit list of images to download via POST, to prevent list length errors and truncation

= 1.1.0 [2012-10-14] =
* added: "select all" button on download gallery template (only visible if JavaScript enabled)
* changed: no longer require Zip extension, uses WordPress-supplied PclZip class

= 1.0.2 [2012-08-22] =
* fixed: sanitize the Zip filename, removing spaces and special characters, so that downloaded files are received correctly on Firefox and others

= 1.0.1 [2012-07-26] =
* fixed: provide ZipArchive error message when zip create fails
* fixed: use WordPress function `get_temp_dir()` to get temporary file directory, which can be specified by setting `WP_TEMP_DIR` in wp-config.php if required (thanks, WP-Spezialist)

= 1.0.0 [2012-07-06] =
* initial public release

= 0.0.1 [2012-06-14] =
* private release
