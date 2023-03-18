<?php

namespace JobDesk\Classes;

class AdminPages {

  public static function dashboard() {
    echo "<link rel='stylesheet' type='text/css' href='" . plugin_dir_url(dirname( __FILE__ )) . "assets/css/admin-page.css' />";
    require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/views/dashboard.php' );
  }

  public static function shortcodes() {
    echo "<link rel='stylesheet' type='text/css' href='" . plugin_dir_url(dirname( __FILE__ )) . "assets/css/admin-page.css' />";
    require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/views/short-codes.php' );
  }

  public static function api_setup() {
    echo "<link rel='stylesheet' type='text/css' href='" . plugin_dir_url(dirname( __FILE__ )) . "assets/css/admin-page.css' />";
    require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/views/jobs-api-configurations.php' );
  }

  public static function apply_form() {
    echo "<link rel='stylesheet' type='text/css' href='" . plugin_dir_url(dirname( __FILE__ )) . "assets/css/admin-page.css' />";
    require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'includes/views/apply-form.php' );
  }

  public static function addAdminPages() {
    add_menu_page(
      'jobdesk®',
      'jobdesk®',
      'manage_options',
      'jobdesk-dashboard',
      [self::class, 'dashboard'],
      '',
      5
    );
    add_submenu_page(
      'jobdesk-dashboard',
      'Jobs API',
      'Jobs API',
      'manage_options',
      'jobdesk-api-setup',
      [self::class, 'api_setup'],
      6
    );
    add_submenu_page(
      'jobdesk-dashboard',
      'Apply Form',
      'Apply Form',
      'manage_options',
      'jobdesk-apply-form',
      [self::class, 'apply_form'],
      6
    );
    add_submenu_page(
      'jobdesk-dashboard',
      'Short Codes',
      'Short Codes',
      'manage_options',
      'jobdesk-shortcodes',
      [self::class, 'shortcodes'],
      6
    );
  }

  public static function init() {
    add_action('admin_menu', [self::class, 'addAdminPages']);
  }

}
