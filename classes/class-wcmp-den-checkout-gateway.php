<?php

class WCMP_Den_Checkout_Gateway {
	public $plugin_url;
    public $plugin_path;
    public $version;
    public $token;
    public $text_domain;
    private $file;
    public $license;
    public $connect_den;
    public $den_admin;

    public function __construct($file) {
	    $this->file = $file;
	    $this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
	    $this->plugin_path = trailingslashit(dirname($file));
	    $this->token = WCMP_DEN_CHECKOUT_GATEWAY_PLUGIN_TOKEN;
	    $this->text_domain = WCMP_DEN_CHECKOUT_GATEWAY_TEXT_DOMAIN;
	    $this->version = WCMP_DEN_CHECKOUT_GATEWAY_PLUGIN_VERSION;

	    require_once $this->plugin_path . 'classes/class-wcmp-den-checkout-payment.php';        
	    add_action('init', array(&$this, 'init'), 0);
	}

	/**
	* initilize plugin on WP init
	*/
	function init() {
	    // Init Text Domain
	    $this->load_plugin_textdomain();

	    if (class_exists('WCMp')) {
	        require_once $this->plugin_path . 'classes/class-wcmp-gateway-den-pay.php';
	        $this->connect_den = new WCMp_Gateway_Den();

	        require_once $this->plugin_path . 'classes/class-wcmp-den-checkout-gateway-admin.php';
	        $this->den_admin = new WCMP_Den_Checkout_Gateway_Admin();

	        add_filter('wcmp_payment_gateways', array(&$this, 'add_wcmp_den_payment_gateway'));
	    }
	}

	public function add_wcmp_den_payment_gateway($load_gateways) {
	    $load_gateways[] = 'WCMp_Gateway_Den';
	    return $load_gateways;
	}

	/**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present
     *
     * @access public
     * @return void
     */
    public function load_plugin_textdomain() {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters('plugin_locale', $locale, 'wcmp-den-checkout-gateway');
        load_textdomain('wcmp-den-checkout-gateway', WP_LANG_DIR . '/wcmp-den-checkout-gateway/wcmp-den-checkout-gateway-' . $locale . '.mo');
        load_plugin_textdomain('wcmp-den-checkout-gateway', false, plugin_basename(dirname(dirname(__FILE__))) . '/languages');
    }

}

