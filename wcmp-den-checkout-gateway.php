<?php
/**
 * Plugin Name: WCMp Den Payment
 * Plugin URI: https://wc-marketplace.com/addons/
 * Description: WCMp Den Checkout Gateway is a payment gateway for pay with woocommerce as well as split payment with WCMp multivendor marketplace.
 * Author: Den
 * Version: 0.1.0
 * Author URI: https://wc-marketplace.com/
 * Text Domain: wcmp-den-checkout-gateway
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) )
{
    exit; // Exit if accessed directly
}

if (!class_exists('WCMP_Den_Checkout_Gateway_Dependencies')) {
    require_once 'classes/class-wcmp-den-checkout-gateway-dependencies.php';
}
require_once 'includes/wcmp-den-checkout-gateway-core-functions.php';
require_once 'wcmp-den-checkout-gateway-config.php';

if (!defined('WCMP_DEN_CHECKOUT_GATEWAY_PLUGIN_TOKEN')) {
    exit;
}
if (!defined('WCMP_DEN_CHECKOUT_GATEWAY_TEXT_DOMAIN')) {
    exit;
}

if(!WCMP_Den_Checkout_Gateway_Dependencies::woocommerce_active_check()){
    add_action('admin_notices', 'woocommerce_inactive_notice');
}

// if(WCMP_Den_Checkout_Gateway_Dependencies::others_razorpay_plugin_active_check()){
//     add_action('admin_notices', 'others_razorpay_plugin_inactive_notice');
// }

if (!class_exists('WCMP_Den_Checkout_Gateway') && WCMP_Den_Checkout_Gateway_Dependencies::woocommerce_active_check()) {
    require_once( 'classes/class-wcmp-den-checkout-gateway.php' );
    global $WCMP_Den_Checkout_Gateway;
    $WCMP_Den_Checkout_Gateway = new WCMP_Den_Checkout_Gateway(__FILE__);
    $GLOBALS['WCMP_Den_Checkout_Gateway'] = $WCMP_Den_Checkout_Gateway;
}
