<?php
function wpfc_deactivate_plugin() {
    $wpfc_options       = get_option( 'wpfc-options' );

    if( $wpfc_options ) {
        delete_option( 'wpfc-options' );
    }
}