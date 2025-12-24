=== WordPress Tweaks ===
Contributors: snewbury
Tags: admin, tweaks, howdy, post-id, site-health
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
A curated collection of functional tweaks for the WordPress admin dashboard.

Current features:
* Removes the 'Howdy,' greeting from the admin bar.
* Adds a 'Post ID' column to the top level of the Posts admin table.
* Silences the 'Background updates' critical warning in Site Health when updates are intentionally disabled via wp-config.

== Installation ==
1. Upload the `wordpresstweaks.zip` file via the 'Plugins > Add New > Upload' screen.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Changelog ==
= 0.2 =
* Added filter to silence Site Health background update warnings.
* Refactored hooks to use __NAMESPACE__ for better portability.

= 0.1 =
* Initial release with 'Howdy' removal and Post ID columns.
