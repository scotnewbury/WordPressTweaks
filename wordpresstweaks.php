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
 * Overwrites the 'Howdy' greeting by setting the account title 
 * to the user's display name directly.
 *
 * @param WP_Admin_Bar $wp_admin_bar The Admin Bar object.
 */
function remove_howdy_admin_bar($wp_admin_bar)
{
  $options = get_option( 'sn_tweaks_options' );

  // If the checkbox isn't checked, exit
  if ( empty( $options['remove_howdy'])) {
    return;
  }

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
 * This funciton add the 'Post ID' column to the front of the post and page tables in the Admin section of WordPress
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
* Injecting a bit of CSS code to shrink the ID column width
*/
function style_post_id_column() {
  $screen = get_current_screen();

  // Only load if we are on a list table (e.g., edit-post or edit-page)
  if ( ! $screen || 'edit' !== $screen->base ) {
      return;
  }  
  echo '<style>
      .fixed .column-' . POST_ID_KEY . ' { 
          width: 60px; 
          text-align: center;
      }
  </style>';
}
add_action('admin_head', __NAMESPACE__ . '\\style_post_id_column');

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

/**
 * Create Settings Page and its Fields - register it
 */
function register_tweaks_settings() {
    // Create the setting entry in the wp_options table
    register_setting( 'sn_tweaks_group', 'sn_tweaks_options' );

    // Add a section for "General Tweaks"
    add_settings_section( 'sn_tweaks_section_admin', 'Admin Dashboard Tweaks', null, 'sn-tweaks-admin' );

    // Add the individual checkbox fields
    add_settings_field( 'remove_howdy', 'Remove "Howdy"', __NAMESPACE__ . '\\render_checkbox', 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'remove_howdy' ] );
    add_settings_field( 'show_post_ids', 'Show Post IDs', __NAMESPACE__ . '\\render_checkbox', 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'show_post_ids' ] );
    add_settings_field( 'silence_health', 'Silence Health Warnings', __NAMESPACE__ . '\\render_checkbox', 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'silence_health' ] );
}
add_action( 'admin_init', __NAMESPACE__ . '\\register_tweaks_settings' );

/**
 * Render the Checkbox HTML
 */
function render_checkbox( $args ) {
    $options = get_option( 'sn_tweaks_options' );
    $id = $args['label_for'];
    $checked = isset( $options[$id] ) ? checked( 1, $options[$id], false ) : '';
    echo "<input type='checkbox' id='$id' name='sn_tweaks_options[$id]' value='1' $checked />";
}

/**
 * Add the Menu Item to Settings
 */
function add_tweaks_menu() {
    add_options_page( 'WP Tweaks Settings', 'WP Tweaks', 'manage_options', 'sn-tweaks-admin', __NAMESPACE__ . '\\render_settings_page' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\add_tweaks_menu' );

/**
 * Render the Settings Page HTML
 */
function render_settings_page() {
    ?>
    <div class="wrap">
        <h1>WordPress Tweaks Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'sn_tweaks_group' );
            do_settings_sections( 'sn-tweaks-admin' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}