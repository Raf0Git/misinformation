<?php
function wpfc_save_settings() {
    $response                       = [ 
        'status'                    => 1,
        'message'                   => __( 'An error occured while saving settings', 'wpfc' )
    ];
    
    $wpfc_options                   = get_option( 'wpfc-options' );
    $opts                           = [
        'display'                   => sanitize_text_field( $_POST['wpfc_show_details'] ),
        'columns'                   => sanitize_text_field( $_POST['wpfc_columns'] ),
        'icons'                     => sanitize_text_field( $_POST['wpfc_icons'] ),
        'colors'                    => [
            'background'            => sanitize_hex_color( $_POST['wpfc_background_color'] ),
            'border'                => sanitize_hex_color( $_POST['wpfc_border_color'] ),
            'content'               => sanitize_hex_color( $_POST['wpfc_content_color'] ),
            'icons'                 => sanitize_hex_color( $_POST['wpfc_icon_color'] ),
            'title'                 => sanitize_hex_color( $_POST['wpfc_title_color'] ),
        ],
        'fonts'                     => [
            'title'                 => sanitize_text_field( $_POST['wpfc_title_font'] ),
            'content'               => sanitize_text_field( $_POST['wpfc_content_font'] ),
        ]
    ];
    
    update_option( 'wpfc-options', $opts );

    $response['status']             = 2;
    $response['message']            = __( 'Settings were successfully saved', 'wpfc' );

    wp_send_json( $response );
}