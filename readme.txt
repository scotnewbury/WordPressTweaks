=== WordPress Tweaks ===
Contributors: scotnewbury
Tags: admin, dashboard, tweaks, menu sort, post ids
Requires at least: 5.8
Tested up to: 6.9.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A lightweight, professionally coded plugin to clean up, sort, and optimize the WordPress admin dashboard.

== Description ==

WordPress Tweaks is a simple, highly optimized utility plugin designed to make the WordPress admin area cleaner and easier to navigate for developers and site managers. 

Instead of adding bloat, this plugin gives you a simple settings panel (Settings > WP Tweaks) to toggle specific quality-of-life improvements:

* **Sort Admin Menu:** Automatically alphabetize the left-hand admin menu (keeping Dashboard at the top) so you can easily find your plugins.
* **Show Post & Page IDs:** Adds a sortable "ID" column back to your Post and Page tables.
* **Remove "Howdy":** Replaces the default "Howdy" greeting in the admin bar with just the user's name.
* **Silence Site Health:** Hides the background update warning in the Site Health dashboard (perfect for managed hosts or source-controlled environments).

== Installation ==

1. Download the latest release `.zip` file.
2. Log in to your WordPress Admin dashboard.
3. Navigate to **Plugins > Add New > Upload Plugin**.
4. Upload the `.zip` file and click **Install Now**.
5. Click **Activate**.
6. Navigate to **Settings > WP Tweaks** to toggle your desired features.

== Frequently Asked Questions ==

= Will this slow down my admin dashboard? =
No. The plugin is built using modern Object-Oriented PHP and strictly loads its assets only when necessary. If a feature is toggled off, its code is never executed.

== Changelog ==

= 1.0.0 =
* Feature: Added alphabetical sorting for the main admin menu.
* Under the Hood: Complete refactor to Object-Oriented Programming (OOP).
* Under the Hood: Implemented PSR-4 style file organization and PHP namespacing.

= 0.3.0 =
* Initial release of basic procedural dashboard tweaks.