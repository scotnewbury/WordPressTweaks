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
 * Overwrites the 'Howdy' greeting by setting the account title 
 * to the user's display name directly.
 *
 * @param WP_Admin_Bar $wp_admin_bar The Admin Bar object.
 */
function remove_howdy_admin_bar($wp_admin_bar)
{

  // Grab the actual user data for the display name
  $current_user = wp_get_current_user();

  // Safety checik: do we have a valid user
  if ( 0 === $current_user->ID ) {
    return;
  }

  // Grab the display name
  $display_name = $current_user->display_name;

  // Update the node with only the display name
  // Grab the node first
  $account_node = $wp_admin_bar->get_node('my-account');
  if ( $account_node ) {
    $wp_admin_bar->add_node([
      'id'    => 'my-account',
      'title' => $display_name,
    ]);
  }

  // Target and replace the the user-info node
  $info_node = $wp_admin_bar->get_node('user-info');
  if ( $info_node ) {
    $wp_admin_bar->add_node([
      'id'    => 'user-info',
      'title' => $display_name,
    ]);
  }
}
add_action('admin_bar_menu', __NAMESPACE__ . '\\remove_howdy_admin_bar', 9999);


/**
 * This funciton add the 'Post ID' column to the front of the post table in the Admin section of WordPress
 *
 * @param Array $columns
 * @return void
 */
function add_post_id_column($columns)
{

  $columns_before = array_slice($columns, 0, 1);
  $columns_after = array_slice($columns, 1);

  $columns = $columns_before +
    array(
      'post_id' => __('Post ID'),
    ) +
    $columns_after;

  return $columns;
}
add_filter('manage_post_posts_columns', __NAMESPACE__ . '\\add_post_id_column');

/**
 * This funciton places the post id number in the proper column
 *
 * @param String $column
 * @param String $post_id
 * @return void
 */
function add_post_ids($column, $post_id)
{
  if ('post_id' == $column) {
    echo $post_id;
  }
}
add_action('manage_posts_custom_column', __NAMESPACE__ . '\\add_post_ids', 10, 2);
