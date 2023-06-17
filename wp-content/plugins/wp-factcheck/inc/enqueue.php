<?php
function wpfc_admin_enqueue() {
    $uri                = plugin_dir_url( WPFC_PLUGIN_URL );
    $ver                = WPFC_DEV_MODE ? time() : null;

    wp_register_style( 'wpfc-factcheck', $uri . 'assets/css/fact-check.css', [], $ver );
    wp_register_style( 'wpfc-admin', $uri . 'assets/css/admin-style.css', [], $ver );
    
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'wpfc-font-inter' );
    wp_enqueue_style( 'wpfc-factcheck' );
    wp_enqueue_style( 'wpfc-admin' );

    wp_register_script( 'wpfc-color-picker', $uri . 'assets/js/color-picker.js', [ 'wp-color-picker' ], $ver, true );
    wp_register_script( 'wpfc-main', $uri . 'assets/js/main.js', [ 'jquery' ], $ver, true );

    wp_localize_script( 'wpfc-main', 'wpfc_obj', [
        'ajax_url'      => admin_url( 'admin-ajax.php' )
    ] );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'wpfc-color-picker' );
    wp_enqueue_script( 'wpfc-main' );
}

function wpfc_enqueue() {
    $uri                = plugin_dir_url( WPFC_PLUGIN_URL );
    $ver                = WPFC_DEV_MODE ? time() : null;

    $wpfc_options       = get_option( 'wpfc-options' );

    wp_register_style( 'wpfc-front-factcheck', $uri . 'assets/css/front-fact-check.css', [], $ver );
    wp_register_style( 'wpfc-font-icomoon', $uri . 'assets/font/icomoon/icomoon.css', [], $ver );
    wp_register_style( 'wpfc-font-linearicons', $uri . 'assets/font/linearicons/linearicons.css', [], $ver );

    // Inline Style
    // Columns
    if ( $wpfc_options['columns'] == 'one-column' ){
        wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck { display: block }' );
        wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-column:first-child { padding-bottom: 0; }' );
        wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-column:last-child { padding-top: 0; }' );   
    }

    // Colors
    wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck { background-color: '.$wpfc_options['colors']['background'].' }' );
    wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck { border-color: '.$wpfc_options['colors']['border'].' }' );
    wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-claim::before, .wpfc-factcheck .wpfc-author::before, .wpfc-factcheck .wpfc-verdict::before, .wpfc-factcheck .wpfc-explainer::before {
        color: '.$wpfc_options['colors']['icons'].';
    }' );

    // Icons
    if( $wpfc_options['icons'] != 'show' ) {
        wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-claim::before, .wpfc-factcheck .wpfc-author::before, .wpfc-factcheck .wpfc-verdict::before, .wpfc-factcheck .wpfc-explainer::before {
            display: none;
        }' );
    }

    // Fonts
    wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-column .wpfc-column-title {
        font-family: '.$wpfc_options['fonts']['title'].';
        color: '.$wpfc_options['colors']['title'].'; 
    }' );

    wp_add_inline_style( 'wpfc-front-factcheck', '.wpfc-factcheck .wpfc-column .wpfc-column-content, .wpfc-factcheck .wpfc-column .wpfc-column-content p { 
        font-family: '.$wpfc_options['fonts']['content'].'; 
        color: '.$wpfc_options['colors']['content'].';
    }' );
    
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'wpfc-font-icomoon' );
    wp_enqueue_style( 'wpfc-font-linearicons' );
    wp_enqueue_style( 'wpfc-font-inter' );
    wp_enqueue_style( 'wpfc-front-factcheck' );
}