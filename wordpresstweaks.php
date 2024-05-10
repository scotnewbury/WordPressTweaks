<?php

/**
 * Plugin Name: WordPress Tweaks
 * Description: A group of tweaks for the WordPress admin sections
 * Author:      Scot Newbury
 * Requires     PHP: 7.4
 * Version:     0.1
 */

namespace ScotNewbury\WordPressTweaks;

/**
 *  Stop execution of the plugin if it's call directly.
 */
if (!defined('ABSPATH')) {
  exit;
}

/**
 * This function will remove the 'Howdy,' from the admin bar
 *
 * @param object $wp_admin_bar
 * @return void
 */
function remove_howdy_admin_bar($wp_admin_bar)
{
  $user_account = $wp_admin_bar->get_node('my-account');
  $remove_title = str_replace('Howdy,', '', $user_account->title);
  $wp_admin_bar->add_node(array('id' => 'my-account', 'title' => $remove_title));
}
add_filter('admin_bar_menu', 'ScotNewbury\WordPressTweaks\remove_howdy_admin_bar', 25);
