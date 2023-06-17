<?php
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
    exit;
}

unregister_post_type( 'fact-checking' );
unregister_post_meta( 'fact-checking', '_wpfc_claim' );
unregister_post_meta( 'fact-checking', '_wpfc_source' );
unregister_post_meta( 'fact-checking', '_wpfc_verdict' );
unregister_post_meta( 'fact-checking', '_wpfc_explainer' );