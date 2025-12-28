=== WordPress Tweaks ===
Contributors: scotnewbury
Tags: admin, posts, pages, howdy, post id, tweaks
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WordPress Tweaks is a curated collection of admin enhancements designed for developers and site managers. This plugin provides a lightweight way to clean up the WordPress dashboard and surface essential data without adding bloat.

Key features:
* **Independent ID Columns**: Display the database ID for Posts and Pages in their respective list tables. Toggles are independent so you can curate exactly what you see.
* **Howdy Greeting Removal**: Replaces the "Howdy, [user]" greeting in the admin bar with the user's display name for a more professional look.
* **Site Health Silence**: Optionally removes background update warnings from Site Health if you manage updates manually via constants.
* **Resource Efficient**: Uses conditional hooking—if a feature is disabled, the code never runs.

== Installation ==

1. Upload the `wp-tweaks` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to **Settings > WP Tweaks** to configure your preferred settings.

== Screenshots ==

1. The independent toggle settings page.
2. The compact ID column in the Posts list table.

== Changelog ==

= 1.0.0 =
* Initial Release.
* Added independent Post and Page ID columns.
* Added "Howdy" removal logic.
* Added Site Health silence toggle.
* Implemented Namespacing and PSR-4 style organization.

== Upgrade Notice ==

= 1.0.0 =
Initial version release.