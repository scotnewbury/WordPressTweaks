<?php

namespace ScotNewbury\WordPressTweaks;

if (!defined('ABSPATH')) {
  exit;
}

class SettingsPage {

    private $options;

    public function __construct() 
    {
        // We need the options here too, so the checkboxes know if they are checked!
        $this->options = get_option( 'sn_tweaks_options' );

        // Hook into WordPress admin initialization
        add_action( 'admin_init', [$this, 'register_tweaks_settings'] );
        add_action( 'admin_menu', [$this, 'add_tweaks_menu'] );
    }

    public function register_tweaks_settings() 
    {
        // Paste your register_setting, add_settings_section, and add_settings_field code here.
        // HINT: Watch out for those namespace strings! You'll need to update them to [$this, 'render_checkbox']
      // Create the setting entry in the wp_options table
    register_setting( 'sn_tweaks_group', 'sn_tweaks_options' );

    // Add a section for "General Tweaks"
    add_settings_section( 'sn_tweaks_section_admin', 'Admin Dashboard Tweaks', null, 'sn-tweaks-admin' );

    // Add the individual checkbox fields
    add_settings_field( 'remove_howdy', 'Remove "Howdy"', [$this, 'render_checkbox'], 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'remove_howdy' ] );
    add_settings_field( 'show_post_ids_posts', 'Show Post IDs', [$this, 'render_checkbox'], 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'show_post_ids_posts' ] );
    add_settings_field( 'show_post_ids_pages', 'Show Page IDs', [$this, 'render_checkbox'], 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'show_post_ids_pages' ] );
    add_settings_field( 'silence_health', 'Silence Health Warnings', [$this, 'render_checkbox'], 'sn-tweaks-admin', 'sn_tweaks_section_admin', [ 'label_for' => 'silence_health' ] );
    }

    public function render_checkbox( $args ) 
    {
      // Paste your checkbox rendering HTML here.
      // HINT: You don't need to call get_option() in here anymore, just use $this->options!
      $id = $args['label_for'];
      $checked = isset( $this->options[$id] ) ? checked( 1, $this->options[$id], false ) : '';
      echo "<input type='checkbox' id='$id' name='sn_tweaks_options[$id]' value='1' $checked />";
    }

    public function add_tweaks_menu() 
    {
        // Paste your add_options_page code here.
        // HINT: Update the namespace string to [$this, 'render_settings_page']
        // Add the menu item to Settings
        add_options_page( 'WP Tweaks Settings', 'WP Tweaks', 'manage_options', 'sn-tweaks-admin', [$this, 'render_settings_page'] );
    }

    public function render_settings_page() 
    {
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
}