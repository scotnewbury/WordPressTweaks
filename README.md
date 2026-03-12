# WordPress Tweaks

A lightweight, developer-friendly WordPress plugin designed to clean up and optimize the WordPress admin dashboard. 

Built with modern PHP, this plugin focuses on performance and clean architecture, utilizing an Object-Oriented structure and PSR-4 style file organization to ensure zero global namespace pollution.

## Motivation

I created this plugin to fix what I feel are some of the most frustrating parts of the WordPress admin experience - like cluttered and confusing menus, and things like missing Post IDs. What started as a solution for my own workflow also became an opportunity to transition to a modern, PSR-4 compliant, object-oriented codebase. The result is a lightweight, install-and-forget plugin that improves the dashboard without adding bloat.

## Features

- **Alphabetical Menu Sorting:** Automatically sorts the left-hand admin menu alphabetically (keeping the Dashboard at the top) to tame plugin clutter.
- **Reveal Post & Page IDs:** Reintroduces the highly requested "ID" column to the Posts and Pages list tables for easier development and reference.
- **Admin Bar Cleanup:** Replaces the informal "Howdy, [Name]" greeting with a clean, professional display name.
- **Site Health Silencing:** Suppresses the "Background updates are not working as expected" Site Health warning for environments where core updates are intentionally disabled via `wp-config.php`.

## Architecture & Under the Hood

This plugin was recently refactored from a procedural script into a modern Object-Oriented design adhering to the Single Responsibility Principle (SRP). 

The codebase is split into distinct, scoped classes:
- **`WordPressTweaks.php` (The Core Engine):** Handles all WordPress hooks, filters, and state modifications. It reads the user's preferences and applies the tweaks without touching the UI.
- **`SettingsPage.php` (The UI):** Exclusively handles the registration of the WordPress settings API, rendering the admin dashboard page, and managing form state. 

## Installation

1. Download the latest release `.zip` file.
2. Log in to your WordPress Admin dashboard.
3. Navigate to **Plugins > Add New > Upload Plugin**.
4. Upload the `.zip` file and click **Install Now**.
5. Click **Activate**.
6. Navigate to **Settings > WP Tweaks** to toggle your desired features.

## Changelog

### [1.0.0] - 2026-03-12
- **Added:** Alphabetical sorting feature for the main admin menu.
- **Changed:** Completely re-architected the plugin into an Object-Oriented (OOP) structure.
- **Changed:** Implemented PSR-4 style directory organization (`/src` folder) and namespacing.
- **Removed:** All global variables and procedural functions to prevent conflicts.

### [0.3.0]
- Initial procedural release with basic dashboard tweaks (Howdy removal, Post/Page IDs, Site Health silencing).