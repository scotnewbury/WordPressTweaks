<?php

/**
 * Plugin Name: WordPress Tweaks
 * Description: A group of tweaks for the WordPress admin sections
 * Author:      Scot Newbury
 * Requires     PHP: 7.4
 * Version:     1.0.0
 */

// Set the namespace
namespace ScotNewbury\WordPressTweaks;

// Stop execution of the plugin if it's call directly.
if (!defined('ABSPATH')) {
  exit;
}

// Pull the class files in
require_once __DIR__ . '/src/WordPressTweaks.php';
require_once __DIR__ . '/src/SettingsPage.php';

// Initialize the core engine
new WordPressTweaks();

// Initialize the settings UI (only if we are in the admin dashboard
if ( is_admin() ) {
  new SettingsPage();
}
