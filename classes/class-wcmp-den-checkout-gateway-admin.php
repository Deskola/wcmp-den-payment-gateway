<?php

class WCMP_Den_Checkout_Gateway_Admin {

	public function __construct() {
        add_filter( 'automatic_payment_method', array( $this, 'admin_den_payment_mode'), 20);
        add_filter( 'wcmp_vendor_payment_mode', array( $this, 'vendor_den_payment_mode' ), 20);
        add_filter("settings_vendors_payment_tab_options", array( $this, 'wcmp_setting_den_account_id' ), 90, 2 );
        add_action( 'settings_page_payment_den_tab_init', array( &$this, 'payment_den_init' ), 10, 2 );
        add_filter('wcmp_tabsection_payment', array( $this, 'wcmp_tabsection_payment_den' ) );
        add_filter('wcmp_vendor_user_fields', array( $this, 'wcmp_vendor_user_fields_for_den' ), 10, 2 );
        add_action('wcmp_after_vendor_billing', array($this, 'wcmp_after_vendor_billing_for_den'));
    }

    public function wcmp_after_vendor_billing_for_den() {
        global $WCMp;
        $user_array = $WCMp->user->get_vendor_fields( get_current_user_id() );
        ?>
        <div class="payment-gateway payment-gateway-den <?php echo apply_filters('wcmp_vendor_paypal_email_container_class', ''); ?>">
            <div class="form-group">
                <label for="vendor_den_account_id" class="control-label col-sm-3 col-md-3"><?php esc_html_e('Den Account Id', 'wcmp-den-checkout-gateway'); ?></label>
                <div class="col-md-6 col-sm-9">
                    <input id="vendor_den_account_id" class="form-control" type="text" name="vendor_den_account_id" value="<?php echo isset($user_array['vendor_den_account_id']['value']) ? $user_array['vendor_den_account_id']['value'] : ''; ?>"  placeholder="<?php esc_attr_e('Den Account Id', 'wcmp-den-checkout-gateway'); ?>">
                </div>
            </div>
        </div>
        <?php
    }

    public function wcmp_vendor_user_fields_for_den($fields, $vendor_id) {
        $vendor = get_wcmp_vendor($vendor_id);
        $fields["vendor_den_account_id"] = array(
            'label' => __('Den Route Account Id', 'wcmp-den-checkout-gateway'),
            'type' => 'text',
            'value' => $vendor->den_account_id,
            'class' => "user-profile-fields regular-text"
        );
        return $fields;
    }

    public function admin_den_payment_mode( $arg ) {
        unset($arg['den_block']);
        $admin_payment_mode_select = array_merge( $arg, array( 'den' => __('den', 'wcmp-den-checkout-gateway') ) );
        return $admin_payment_mode_select;
    }

    public function vendor_den_payment_mode($payment_mode) {
        $payment_admin_settings = get_option('wcmp_payment_settings_name');

        if (isset($payment_admin_settings['payment_method_den']) && $payment_admin_settings['payment_method_den'] = 'Enable') {
            $payment_mode['den'] = __('den', 'wcmp-den-checkout-gateway');
        }
        return $payment_mode;
    }

    public function wcmp_setting_den_account_id( $payment_tab_options, $vendor_obj ) {
        $payment_tab_options['vendor_den_account_id'] = array('label' => __('Account Number', 'wcmp-den-checkout-gateway'), 'type' => 'text', 'id' => 'vendor_den_account_id', 'label_for' => 'vendor_den_account_id', 'name' => 'vendor_den_account_id', 'value' => $vendor_obj->den_account_id, 'wrapper_class' => 'payment-gateway-den payment-gateway');
        return $payment_tab_options;
    }

    public function payment_den_init( $tab, $subsection ) {
        global $WCMP_Den_Checkout_Gateway;
        require_once $WCMP_Den_Checkout_Gateway->plugin_path . 'admin/class-wcmp-settings-payment-den.php';
        new WCMp_Settings_Payment_den( $tab, $subsection );
    }

    public function wcmp_tabsection_payment_den($tabsection_payment) {
        if ( 'Enable' === get_wcmp_vendor_settings( 'payment_method_den', 'payment' ) ) {
            $tabsection_payment['den'] = array( 'title' => __( 'Den Payment', 'wcmp-den-checkout-gateway' ), 'icon' => 'dashicons-admin-settings' );
        }
        return $tabsection_payment;
    }
	
}