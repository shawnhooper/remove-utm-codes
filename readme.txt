=== Remove UTM Codes ===
Contributors: shooper
Donate link: https://www.paypal.com/paypalme/shawnhooperwp
Tags: UTM, bulk, wp-cli, import
Requires at least: 6.0.0
Tested up to: 6.1
Requires PHP: 7.4.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a WP-CLI command that removes UTM codes from all links in your post content.

== Description ==

This plugin adds a WP-CLI command that removes UTM codes from all links in your post content.

After installing and activating this plugin, run:

wp remove-utm-codes

If you want to do a dry-run to see what the plugin would do before changing your data, run:

wp remove-utm-codes --dry-run

== Changelog ==

= 1.0.0 =
* Remove links from all posts on the site
* Include dry-run functionality