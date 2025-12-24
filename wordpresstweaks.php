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
add_filter('admin_bar_menu', __NAMESPACE__ . '\remove_howdy_admin_bar', 25);


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
add_filter('manage_post_posts_columns', 'ScotNewbury\WordPressTweaks\add_post_id_column');

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
add_action('manage_posts_custom_column', 'ScotNewbury\WordPressTweaks\add_post_ids', 10, 2);
