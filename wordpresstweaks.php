<?php

/**
 * Plugin Name: WordPress Tweaks
 * Description: A group of tweaks for the WordPress admin sections
 * Author:      Scot Newbury
 * Requires     PHP: 7.4
 * Version:     0.3
 */

/**
 * Scope the namespance and set up some variables to prevent clashes
 */
namespace ScotNewbury\WordPressTweaks;

/**
 *  Stop execution of the plugin if it's call directly.
 */
if (!defined('ABSPATH')) {
  exit;
}

// Pull the class files in
require_once __DIR__ . '/src/WordPressTweaks.php';
require_once __DIR__ . '/src/SettingsPage.php';

new WordPressTweaks();
if ( is_admin() ) {
  new SettingsPage();
}
