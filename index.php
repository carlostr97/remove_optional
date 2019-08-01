
<?php
/*
Plugin Name: Remove_Optional_fields
Description: Un semplice plugin per rimuovere la voce "(oprtional)" dalle fields in checkout di WooCommerce
Author: Carlo Stringaro
Version: 1.0
Author URI: http://www.carlostringaro.it
*/


// Rimuove ("optional") dalle field 
add_filter( 'woocommerce_form_field' , 'remove_checkout_optional_fields_label', 10, 4 );
function remove_checkout_optional_fields_label( $field, $key, $args, $value ) {
    // Solo nella pagina di checkout
    if( is_checkout() && ! is_wc_endpoint_url() ) {
        $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
        $field = str_replace( $optional, '', $field );
    }
    return $field;
}


add_filter( 'woocommerce_billing_fields', 'wc_optional_billing_fields', 10, 1 );
function wc_optional_billing_fields( $address_fields ) {
    $address_fields['billing_address_1']['required'] = true;
    $address_fields['billing_postcode']['required'] = true;
    $address_fields['billing_city']['required'] = true;

    return $address_fields;
}
// Funzione in JQuery per eliminare ("optional") dal form di checkout di WooCommerce
add_filter( 'wp_footer' , 'remove_checkout_optional_fields_label_script' );
function remove_checkout_optional_fields_label_script() {
    // Only on checkout page
    if( ! ( is_checkout() && ! is_wc_endpoint_url() ) ) return;

    $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
    ?>
    <script>
    jQuery(function($){
        // On "update" checkout form event
        $(document.body).on('update_checkout', function(){
            $('#billing_country_field label > .optional').remove();
            $('#billing_address_1_field label > .optional').remove();
            $('#billing_city_field label > .optional').remove();
            $('#billing_postcode_field label > .optional').remove();
            $('#billing_state_field label > .optional').remove();
            $('#shipping_city_field label > .optional').remove();
            $('#shipping_country_field label > .optional').remove();
            $('#shipping_address_1_field label > .optional').remove();
            $('#shipping_postcode_field label > .optional').remove();
            $('#shipping_state_field label > .optional').remove();
            jQuery('label[for="billing_city"]').append('&nbsp;<abbr class="required"</abbr>');
            jQuery('label[for="billing_postcode"]').append('&nbsp;<abbr class="required"</abbr>');
            jQuery('label[for="billing_address_1"]').append('&nbsp;<abbr class="required"</abbr>');
        });
    });
    </script>
    <?php
}
