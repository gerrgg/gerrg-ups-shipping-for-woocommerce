<?php
/**
 * Plugin Name:       GERRG UPS Shipping for Woocommerce
 * Plugin URI:        https://github.com/gerrgg/gerrg-ups-shipping-for-woocommerce
 * Description:       Use the UPS API for luxeries like tracking a package or getting time in transit.
 * Version:           0.01
 * Author:            Greg "GERRG" Bastianelli
 * Author URI:        https://gerrg.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gupsfw
 * Domain Path:       /languages
 */

require_once( __DIR__ . '/lib/vendor/autoload.php' );

 class GERRG_ups_shipping_for_woocommerce
 {

   function __construct(){
       add_action('admin_menu', array( $this, 'options_menu' ) );
       add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'shipping_estimate_html' ), 10, 2 );
   }

   public function shipping_estimate_html( $label, $method ){
        
       return $label;
   }

   public function options_menu(){
       /**
        * Add like to options page to the admin menu
        */
        add_menu_page('GERRG UPS Shipping Options', 'UPS Shipping Options', 'administrator', __FILE__, array( $this, 'options_page' ) , plugins_url('/images/icon.png', __FILE__) );
        add_action( 'admin_init', array( $this, 'register_ups_shipping_settings' ) );
   }

   public function register_ups_shipping_settings(){
       /**
        * Register options settings
        */
        register_setting( 'gerrg-ups-shipping-settings-group', 'gerrg_ups_api_key' );
        register_setting( 'gerrg-ups-shipping-settings-group', 'gerrg_ups_username' );
        register_setting( 'gerrg-ups-shipping-settings-group', 'gerrg_ups_password' );
        register_setting( 'gerrg-ups-shipping-settings-group', 'gerrg_ups_account' );
    }

    public function options_page() {
        /**
         * Options page for inputing all relevant UPS information
         */
        ?>
        <div class="wrap">
        <h1>GERRG UPS Shipping for Woocommerce</h1>
        <p>Enter your UPS API key, username and password below to start using the plugin.</p>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'gerrg-ups-shipping-settings-group' ); ?>
            <?php do_settings_sections( 'gerrg-ups-shipping-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                <th scope="row">UPS API Key</th>
                <td><input type="text" name="gerrg_ups_api_key" value="<?php echo esc_attr( get_option('gerrg_ups_api_key') ); ?>" /></td>
                </tr>
                 
                <tr valign="top">
                <th scope="row">UPS Username</th>
                <td><input type="text" name="gerrg_ups_username" value="<?php echo esc_attr( get_option('gerrg_ups_username') ); ?>" /></td>
                </tr>
                
                <tr valign="top">
                <th scope="row">UPS Password</th>
                <td><input type="password" name="gerrg_ups_password" value="<?php echo esc_attr( get_option('gerrg_ups_password') ); ?>" /></td>
                </tr>
                <tr valign="top">
                <th scope="row">UPS Account Number</th>
                <td><input type="text" name="gerrg_ups_account" value="<?php echo esc_attr( get_option('gerrg_ups_account') ); ?>" /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        
        </form>
        </div> 
        <?php
    }
}


/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    new GERRG_ups_shipping_for_woocommerce();
}
