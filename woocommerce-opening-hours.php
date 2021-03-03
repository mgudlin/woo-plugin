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
        add_action('woocommerce_settings_opening_hours', array($this, 'add_settings'), 50);
        add_action('woocommerce_update_options_opening_hours', array($this, 'update_settings'), 50);
        add_action('wp', array($this, 'maybe_disable_checkout'));
      }

      // add a settings tab
        public function add_settings_tab($settings_tabs) {
          $settings_tabs['opening_hours'] = __('Opening Hours', 'woocommerce-opening-hours');
          return $settings_tabs;
        }
        // add a settings
          public function add_settings() {
            woocommerce_admin_fields(
              self::get_settings()
            );
          }

          // save/update a settings
            public function update_settings() {
              woocommerce_update_options(
                self::get_settings()
              );
            }

            public function maybe_disable_checkout() {
              $disable_checkout = get_option('wc_settings_closed_saturdays') == 'yes' ? true:false;

              //check if the setting is checked and it's saturdays
              // TODO actually check that it's saturday
              if($disable_checkout && TRUE && is_checkout()) {
                wp_safe_redirect(get_permalink(126));
              }
            }

          // get a settings
            public function get_settings() {
              $settings = array (
                'section_title' => array(
                  'name'  =>  __('Opening Hours', 'woocommerce_opening_hours'),
                  'type'  =>  'title',
                  'description' => '',
                  'id' => ''
                ),

                'closed saturdays' => array(
                  'name'  =>  __('Closed on Saturdays', 'woocommerce_opening_hours'),
                  'type'  =>  'checkbox',
                  'desc' => __('Disable the checkout on Saturdays', 'woocommerce_opening_hours'),
                  'id' => 'wc_settings_closed_saturdays'
                ),
                'section_end' => array(
                  'type'  =>  'sectioned',
                  'id' => 'wc_settings_opening_hours_section_end'
                )
              );
              return $settings;
              }
            }

    $GLOBALS['wc_opening_hours'] = new WC_Opening_Hours();
  }
}
