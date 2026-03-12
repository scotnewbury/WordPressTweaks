<?php

namespace ScotNewbury\WordPressTweaks;

if (!defined('ABSPATH')) {
  exit;
}

class WordPressTweaks {

  private $options;
  const POST_ID_KEY = 'sn_wp_tweaks_post_id';

  public function __construct() 
      {
          // Pull the database options and store them
          $this->options = get_option( 'sn_tweaks_options' );

          // Set up WordPress hooks
          $this->init_hooks();
      }

  private function init_hooks() 
    {
        // We access the options we stored in the constructor using $this->options
        if ( ! empty( $this->options['remove_howdy'] ) ) {
          // IMPORTANT: In OOP, WordPress hooks need an array instead of a string.
          // [$this, 'method_name'] tells WP: "Look in THIS class for the method."
          add_action('admin_bar_menu', [$this, 'remove_howdy_admin_bar'], 9999);
        }

        // Toggle IDs on post table
        if ( ! empty( $this->options['show_post_ids_posts'] ) ) {
          add_filter( 'manage_post_posts_columns', [$this, 'add_post_id_column'] );
          add_action( 'manage_posts_custom_column', [$this, 'add_post_ids'], 10, 2 );
          add_action( 'admin_head', [$this, 'style_post_id_column'] );
        }

        // Toggle IDs for pages table
        if ( ! empty( $this->options['show_post_ids_pages'] ) ) {
          add_filter( 'manage_pages_columns', [$this, 'add_post_id_column'] );
          add_action( 'manage_pages_custom_column', [$this, 'add_post_ids'], 10, 2 );
          add_action( 'admin_head', [$this, 'style_post_id_column'] );
        }

        // Toggle alphabetical menu sorting
        if ( ! empty( $this->options['sort_menu'] ) ) {
            add_filter( 'custom_menu_order', '__return_true' );
            add_filter( 'menu_order', [$this, 'sort_admin_menu_alphabetically'] );
        }

        // Toggle health check
        if ( ! empty ( $this->options['silence_health'] ) ) {
          add_filter( 'site_status_tests', [$this, 'remove_background_update_check'] );
        }
    }

  
  // Overwrites the 'Howdy' greeting by setting the account title 
  // to the user's display name directly.
  public function remove_howdy_admin_bar( $wp_admin_bar ) 
    {
      // Grab the actual user data for the display name
      $current_user = wp_get_current_user();

      // Safety checik: do we have a valid user
      if ( 0 === $current_user->ID ) {
        return;
      }

      // Grab the display name
      $display_name = esc_html ( $current_user->display_name );

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
  
    /**
    * This funciton add the 'Post ID' column to the front of the post and page tables in the Admin section of WordPress
    */
    public function add_post_id_column($columns)
    {

      $columns_before = array_slice($columns, 0, 1);
      $columns_after = array_slice($columns, 1);

      $columns = $columns_before +
        array(
          self::POST_ID_KEY => __('ID'),
        ) +
        $columns_after;

      return $columns;
    }

    /**
    * This funciton places the post id number in the proper column
    */
    public function add_post_ids($column, $post_id)
    {
      if (self::POST_ID_KEY == $column) {
        echo '<code>' . (int) $post_id . '</code>';
      }
    }

    /**
    * Injecting a bit of CSS code to shrink the ID column width
    */
    public function style_post_id_column() {
      $screen = get_current_screen();

      // Only load if we are on a list table (e.g., edit-post or edit-page)
      if ( ! $screen || 'edit' !== $screen->base ) {
          return;
      }  
      echo '<style>
          .fixed .column-' . self::POST_ID_KEY . ' { 
              width: 60px; 
              text-align: center;
          }
      </style>';
    }

    
    // Sorts the main WordPress admin menu alphabetically, keeping Dashboard at the top.
        public function sort_admin_menu_alphabetically( $menu_order ) 
    {
        if ( ! $menu_order ) {
            return true;
        }

        // Bring in the global WordPress menu array
        global $menu;
        $sorted_menu = $menu;

        // Sort the menu array alphabetically by the menu title (which is index 0)
        usort( $sorted_menu, function ( $a, $b ) {
            // Strip HTML tags in case plugins inject span tags into their titles (e.g., notification bubbles)
            $titleA = wp_strip_all_tags( $a[0] );
            $titleB = wp_strip_all_tags( $b[0] );
            
            return strcasecmp( $titleA, $titleB );
        });

        // Rebuild the order array using the menu slugs (index 2)
        $new_menu_order = [];
        foreach ( $sorted_menu as $item ) {
            $new_menu_order[] = $item[2]; 
        }

        // Make sure "Dashboard" stays at the very top where it belongs
        $dashboard_key = array_search( 'index.php', $new_menu_order, true );
        if ( $dashboard_key !== false ) {
            unset( $new_menu_order[$dashboard_key] );
            array_unshift( $new_menu_order, 'index.php' );
        }

        return $new_menu_order;
    }

    /**
     * Removes the 'Background updates are not working as expected' check from Site Health.
     * Since WP_AUTO_UPDATE_CORE is intentionally false, hide the warning to keep the dashboard clean.
     */
    public function remove_background_update_check( $tests ) {
        // Background updates are part of the asynchronous tests in the Site Health suite.
        if ( isset( $tests['async']['background_updates'] ) ) {
            unset( $tests['async']['background_updates'] );
        }
        return $tests;
    }    
    
}