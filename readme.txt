=== NextGEN Download Gallery ===
Contributors: webaware
Plugin Name: NextGEN Download Gallery
Plugin URI: http://shop.webaware.com.au/downloads/nextgen-download-gallery/
Author URI: http://webaware.com.au/
Donate link: http://shop.webaware.com.au/donations/?donation_for=NextGEN+Download+Gallery
Tags: nextgen, gallery, download
Requires at least: 3.2.1
Tested up to: 4.3
Stable tag: 1.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries

== Description ==

Add a template to NextGEN Gallery that provides multiple-file downloads for trade/media galleries. [NextGEN Gallery](https://wordpress.org/plugins/nextgen-gallery/) is one of the best gallery plugins for WordPress because it is very flexible and has a nice, simple admin. This plugin adds a new gallery template that lets you select multiple images from the gallery to be downloaded as a ZIP archive.

NB: the Photocrati version of NextGEN Gallery can impact the performance of your server, and not all of the old plugin's functionality works. You might want to consider using [NextCellent Gallery](https://wordpress.org/plugins/nextcellent-gallery-nextgen-legacy/) instead -- it's a fork of the original NextGEN Gallery with continued support and compatibility, without the performance impacts.

NextGEN Download Gallery is targetted at creating "Trade/Media" areas on websites, allowing journalists to easily download multiple product images. It's apparently very popular with photographers too.

= Translations =

Many thanks to the generous efforts of our translators:

* Czech (cs-CZ) -- [Rudolf Klusal](http://www.klusik.cz/)
* Danish (da-DK) -- [Ligefrem](http://www.ligefrem.dk/)
* Dutch (nl-NL) -- [Ivan Beemster](http://www.lijndiensten.com/)
* French (fr-FR) -- Nicolas Sizun
* Portuguese (pt-BR) -- [Juliano Arantes](http://www.42fotografia.com.br/)

If you'd like to help out by translating this plugin, please [sign up for an account and dig in](https://translate.webaware.com.au/projects/nextgen-download-gallery).

== Installation ==

1. Install [NextGEN Gallery](https://wordpress.org/plugins/nextgen-gallery/) or [NextCellent Gallery](https://wordpress.org/plugins/nextcellent-gallery-nextgen-legacy/), and create galleries/albums
2. Upload this plugin to your /wp-content/plugins/ directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Specify the gallery template as "download"

= From a gallery shortcode =

When using a shortcode to show a NextGEN gallery, you can make it a download gallery by specifying the gallery template:

`[nggallery id=1 template=download]`

= From an album shortcode =

When using a shortcode to show a NextCellent Gallery album, you can make it show download galleries by specifying the gallery template:

`[nggalbum id=1 gallery=download]`

NB: NextGEN Gallery 2.0 still doesn't support this functionality, as at v2.0.66.17; see FAQ for work-around.

= From a tags shortcode =

The standard `nggtags` shortcode doesn't allow you to specify the gallery template, so this plugin adds an extended version of that shortcode.

`[nggtags_ext gallery="frogs,lizards" template=download]`

Or in NextGEN Gallery v2.0:

`[ngg_images tag_ids="frogs,lizards" template=download display_type="photocrati-nextgen_basic_thumbnails"]`

== Frequently Asked Questions ==

= Will this plugin work without NextGEN Gallery or NextCellent Gallery? =

No. [NextGEN Gallery](https://wordpress.org/plugins/nextgen-gallery/) / [NextCellent Gallery](https://wordpress.org/plugins/nextcellent-gallery-nextgen-legacy/) are doing all the work. This plugin is only adding a new gallery template and the ZIP download functionality.

= Can I make an album use the download template? =

Yes, in NextCellent Gallery the album shortcode has separate parameters for album and gallery templates. The "template" parameter tells it which template to use for the album, and the "gallery" parameter tells it which template to use for the gallery. e.g.

`[nggalbum id=1 template=compact gallery=download]`

NB: NextGEN Gallery v2.0 still doesn't support this functionality. Instead, you need to link a page to each gallery in Gallery > Manage Galleries, and use the `nggallery` shortcode on those pages to set the template as "download".

= Can I make the tags shortcode use the download template? =

In NextCellent Gallery, just add the template to the `nggtags` shortcode:

`[nggtags gallery="frogs,lizards" template=download]`

NextGEN Gallery v2.0 introduces a new shortcode, `ngg_images`; see the [Photocrati documentation for ngg_images](http://www.nextgen-gallery.com/nextgen-gallery-shortcodes/). This new shortcode can support a template parameter, like this:

`[ngg_images tag_ids="frogs,lizards" template=download display_type="photocrati-nextgen_basic_thumbnails"]`

= I don't like the download template; can I customise it? =

Yes. Copy the template from the templates folder in the plugin, into a folder called nggallery in your theme's folder. You can then edit your copy of the template to get the pretty.

= Why does it break when I select too many images? =

There can be several reasons, but the most common one is that your server is limiting the size of temporary files. You might be able to work around that by telling WordPress to use your uploads folder for temporary files. To do that, add this line to your wp-config.php file, just below the lines defining ABSPATH near the bottom of the file:

`define('WP_TEMP_DIR', ABSPATH . '/wp-content/uploads/');`

= You've translated my language badly / it's missing =

The initial translations were made using Google Translate, so it's likely that some will be truly awful! Please help by [registering to translate into your preferred language](https://translate.webaware.com.au/projects/nextgen-download-gallery).

= Can I change the image paths, to download a different image? =

If you have higher resolution images you'd like to download instead of the ones displayed, you can use a WordPress filter hook. See [this support post](https://wordpress.org/support/topic/linking-to-hr-images-again#post-4385317) for details. **NB:** this is advanced and requires some programming ability!

== Contributions ==

* [Translate into your preferred language](https://translate.webaware.com.au/projects/nextgen-download-gallery)
* [Fork me on GitHub](https://github.com/webaware/nextgen-download-gallery)

== Credits ==

This program incorporates a little code that is copyright by Photocrati Media 2012 under the GPLv2. Some PHP code was copied from NextGEN Gallery and altered, so that the `nggtags` shortcode could be extended as `nggtags_ext` and specify a gallery template.

== Screenshots ==

1. example download gallery

== Upgrade Notice ==

= 1.5.1 =

Fixes Download All button missing since NextGEN Gallery 2.1.7

== Changelog ==

= 1.5.1, 2015-08-13 =

* fixed: Download All button missing since NextGEN Gallery 2.1.7

= 1.5.0, 2015-06-13 =

* fixed: NextGEN Gallery no longer permits typing in download gallery template name; add our templates to list (pending NGG update)
* added: action hooks `ngg_dlgallery_zip_before_send` and `ngg_dlgallery_zip_after_send`
* changed: Download All handled via POST, not GET; more robust

= 1.4.4, 2014-10-27 =

* fixed: suppress errors on `set_time_limit()` to avoid download problems when that function has been disabled
* added: Czech translation (thanks, [Rudolf Klusal](http://www.klusik.cz/)!)

= 1.4.3, 2014-10-21 =

* fixed: Danish translation (thanks, [Ligefrem](http://www.ligefrem.dk/)!)

= 1.4.2, 2014-09-18 =

* fixed: French translation (thanks, Nicolas Sizun!)
* fixed: Portuguese for "select all" has wrong gender (thanks, [Juliano Arantes](http://www.42fotografia.com.br/)!)

= 1.4.1, 2014-06-25 =

* fixed: reverted to using admin-ajax.php for handling the ZIP request; admin-post.php was redirecting to the home page for non-admin users on at least one website (why? anybody know, please [tell me in the support forum](https://wordpress.org/support/topic/only-administrator-can-download)).

= 1.4.0, 2014-06-22 =

* fixed: zip file was getting name ".zip" when no gallery name set
* fixed: Dutch translation (thanks, [Ivan Beemster](http://www.lijndiensten.com/)!)
* fixed: Georgian translation (from Google Translate) renamed ka_GE so it might work now :)
* fixed: download gallery title is "tagged: {taglist}" when using shortcode `nggtags_ext` or `ngg_images` in NextGEN Gallery 2.0.x now too!
* added: support for downloading everything from a gallery all at once
* added: stylesheet to force HR to behave nicely in common themes ("Finally!" so say we all)
* added: filter `ngg_dlgallery_zip_pre_add` so that plugins/themes can supply a callback function name for PclZip `PCLZIP_CB_PRE_ADD` argument
* changed: select all button now toggles between selected and unselected
* changed: JavaScript now loaded as external script, not part of gallery template
* changed: process download action through admin-post.php, no need for AJAX logic (still supported for legacy customised templates)
* changed: [translations now updated online](https://translate.webaware.com.au/projects/nextgen-download-gallery), so .po files removed from plugin

= 1.3.1, 2013-08-25 =

* fixed: undeclared variable warning when number of columns set in Gallery settings
* fixed: download failures on some websites caused by theme or other plugins using output buffering early
* fixed: download failures on some websites when using readfile(), now use read/write/flush loop

= 1.3.0, 2013-08-16 =

* fixed: `nggtags_ext` works in NextGEN Gallery 2.0.7+
* changed: script timeout set to 300 seconds during download build, maybe this will help with large zip files on slow servers

= 1.2.3, 2013-07-05 =

* added: filter `ngg_dlgallery_image_path` for altering image path (e.g. to pick up a higher resolution version)
* added: filter `ngg_dlgallery_zip_filename` for altering name of ZIP download file

= 1.2.2, 2013-06-23 =

* added: shortcode `nggtags_ext` supports images attribute, for number of images to display per page
* changed: translation updates using Google Translate, which is to say: badly! Please help by [registering to translate into your preferred language](https://translate.webaware.com.au/projects/nextgen-download-gallery).

= 1.2.1, 2013-03-23 =

* fixed: download gallery title is "tagged: {taglist}" when using shortcode `nggtags_ext`; was using gallery title from first image (NextGEN Gallery bug)
* added: filter 'ngg_dlgallery_tags_gallery_title' for changing gallery title when using shortcode `nggtags_ext`

= 1.2.0, 2013-03-23 =

* fixed: template was HTML-encoding the gallery title & description when they are already HTML-encoded
* added: shortcode `nggtags_ext` to extend `nggtags` so that you can specify a gallery template

= 1.1.1, 2012-12-07 =

* fixed: submit list of images to download via POST, to prevent list length errors and truncation

= 1.1.0, 2012-10-14 =

* added: "select all" button on download gallery template (only visible if JavaScript enabled)
* changed: no longer require Zip extension, uses WordPress-supplied PclZip class

= 1.0.2, 2012-08-22 =

* fixed: sanitise the Zip filename, removing spaces and special characters, so that downloaded files are received correctly on Firefox and others

= 1.0.1, 2012-07-26 =

* fixed: provide ZipArchive error message when zip create fails
* fixed: use WordPress function `get_temp_dir()` to get temporary file directory, which can be specified by setting `WP_TEMP_DIR` in wp-config.php if required (thanks, WP-Spezialist)

= 1.0.0, 2012-07-06 =

* initial public release

= 0.0.1, 2012-06-14 =

* private release
