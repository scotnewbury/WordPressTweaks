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
const POST_ID_KEY = 'sn_wp_tweaks_post_id';

/**
 *  Stop execution of the plugin if it's call directly.
 */
if (!defined('ABSPATH')) {
  exit;
}

/**
* Injecting a bit of CSS code to shrink the ID column width
*/
function style_post_id_column() {
    echo '<style>
        .fixed .column-' . POST_ID_KEY . ' { 
            width: 60px; 
            text-align: center;
        }
    </style>';
}
add_action('admin_head', __NAMESPACE__ . '\\style_post_id_column');

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
 */
function add_post_id_column($columns)
{
  $columns_before = array_slice($columns, 0, 1);
  $columns_after = array_slice($columns, 1);

  $columns = $columns_before +
    array(
      POST_ID_KEY => __('ID'),
    ) +
    $columns_after;

  return $columns;
}
add_filter('manage_post_posts_columns', __NAMESPACE__ . '\\add_post_id_column');
add_filter('manage_pages_columns', __NAMESPACE__ . '\\add_post_id_column');

/**
 * This funciton places the post id number in the proper column
 *
 * @param String $column
 * @param String $post_id
 * @return void
 */
function add_post_ids($column, $post_id)
{
  if (POST_ID_KEY == $column) {
    echo $post_id;
  }
}
add_action('manage_posts_custom_column', __NAMESPACE__ . '\\add_post_ids', 10, 2);
add_action('manage_pages_custom_column', __NAMESPACE__ . '\\add_post_ids', 10, 2);

/**
 * Removes the 'Background updates are not working as expected' check from Site Health.
 * Since WP_AUTO_UPDATE_CORE is intentionally false, hide the warning to keep the dashboard clean.
 */
function remove_background_update_check( $tests ) {
    // Background updates are part of the asynchronous tests in the Site Health suite.
    if ( isset( $tests['async']['background_updates'] ) ) {
        unset( $tests['async']['background_updates'] );
    }
    return $tests;
}
add_filter( 'site_status_tests', __NAMESPACE__ . '\\remove_background_update_check' );

