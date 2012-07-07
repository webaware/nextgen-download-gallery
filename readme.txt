=== NextGEN Download Gallery ===
Contributors: webaware
Plugin Name: NextGEN Download Gallery
Plugin URI: http://snippets.webaware.com.au/wordpress-plugins/nextgen-download-gallery/
Author URI: http://www.webaware.com.au/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=P3LPZAJCWTDUU
Tags: nextgen, gallery
Requires at least: 3.0.1
Tested up to: 3.4.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a template to NextGEN Gallery to provide multiple-file downloads for trade/media galleries

== Description ==

[NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) is one of the best gallery plugins for WordPress because it is very flexible and has a nice, simple admin. This plugin adds a new template for galleries that lets you select multiple images from the gallery to be downloaded as a ZIP archive.

This plugin is targetted at creating "Trade/Media" areas on websites, allowing journalists to easily download multiple product images.

== Installation ==

1. Upload this plugin to your /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Specify the gallery template as "download"

= From a gallery shortcode =

When using a shortcode to show a NextGEN gallery, you can make it a download gallery by specifying the gallery template:

`[nggallery id=1 template=download]`

= From an album shortcode =

When using a shortcode to show a NextGEN album, you can make it show download galleries by specifying the gallery template:

`[album id=1 gallery=download]`

== Frequently Asked Questions ==

= Will this plugin work without NextGEN Gallery? =

No. [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) is doing all the work. This plugin is only adding a new gallery template and the ZIP download functionality.

= Can I make an album use the download template? =

Yes, the album shortcode has separate parameters for album and gallery templates. The "template" parameter tells it which template to use for the album, and the "gallery" parameter tells it which template to use for the gallery. e.g.

`[album id=1 template=compact gallery=download]`

= I don't like the download template; can I customise it? =

Yes. Copy the template from the templates folder of the plugin, into a folder called nggallery in your theme's folder. You can then edit your copy of the template to get the pretty.

= You've translated my language badly / it's missing =

The initial translations were made using Google Translate, so it's likely that some will be truly awful! Please help by editing the .po file for your language and tell me about it in the support forum.

== Screenshots ==

1. example download gallery

== Changelog ==

= 1.0.0 [2012-07-06] =
* initial public release

= 0.0.1 [2012-06-14] =
* private release
