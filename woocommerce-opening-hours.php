<?php
/*
Plugin Name: Woo Opening Hours
Plugin URI: https://wordpress.org/
Description: Control when your Woo store is open
Version: 1.0.0
Author: Matija Gudlin
Text Domain: woocommerce-example-plugin
Domain Path: /languages
*/


// check to make sure woo is active

if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
  if(!class_exists('WC_Opening_Hours')) {
    class WC_Opening_Hours{
      public function __construct() {
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);
      }

      // add a settings tab
        public function add_settings_tab($settings_tabs) {
          $settings_tabs['opening-hours'] = __('Opening Hours', 'woocommerce-opening-hours');
          return $settings_tabs;
        }
    }

    $GLOBALS['wc_opening_hours'] = new WC_Opening_Hours();
  }
}
