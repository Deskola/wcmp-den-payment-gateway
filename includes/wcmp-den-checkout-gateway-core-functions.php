<?php

if (!function_exists('woocommerce_inactive_notice')) {

    function woocommerce_inactive_notice() {
        ?>
        <div id="message" class="error">
            <p><?php printf(__('%sWCMp Den Payment is inactive.%s The %sWooCommerce plugin%s must be active for the WCMp Den Payment to work. Please %sinstall & activate WooCommerce%s', 'wcmp-razorpay-checkout-gateway'), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . admin_url('plugins.php') . '">', '&nbsp;&raquo;</a>'); ?></p>
        </div>
        <?php
    }
}