<?php
function wpfc_activate_plugin() {
    /* Check WordPress version */

    if( version_compare( get_bloginfo( 'version' ), WPFC_WP_VERSION, '<' ) ) {
        wp_die( __( 'You have to upgrade your WordPress version before you can use this plugin', 'wpfc' ) );
    }

    // Save default options
    $wpfc_options                   = get_option( 'wpfc-options' );

    if( !$wpfc_options ) {
        $opts                           = [
            'display'                   => 'yes',
            'columns'                   => 'two-columns',
            'icons'                     => 'show',
            'colors'                    => [
                'background'            => '#f9f9f9',
                'border'                => '#e5e5e5',
                'content'               => '#222222',
                'icons'                 => '#ededed',
                'title'                 => '#222222'
            ],
            'fonts'                     => [
                'title'                 => 'default',
                'content'               => 'default',
            ]
        ];

        add_option( 'wpfc-options', $opts );
    }

    // Flush rewrite rules
    wpfc_post_types();
    flush_rewrite_rules();
}