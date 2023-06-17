<?php
function wpfc_content_factcheck( $the_content ) {
    global $post;
    $wpfc_options   = get_option( 'wpfc-options' );

    if( !is_singular( 'wpfc-fact-checking' ) ) {
        return $the_content;
    }

    if( $wpfc_options['display'] == 'no' ) {
        return $the_content;
    }

    $wpfc_claim     = get_post_meta( $post->ID, '_wpfc_claim', true );
    $wpfc_author    = get_post_meta( $post->ID, '_wpfc_author', true );
    $wpfc_source    = get_post_meta( $post->ID, '_wpfc_source', true );
    
    $wpfc_verdict   = get_post_meta( $post->ID, '_wpfc_verdict', true );
    $wpfc_explainer = get_post_meta( $post->ID, '_wpfc_explainer', true );

    switch( $wpfc_verdict ) {
        case 1:
            $wpfc_alternate_name    = __( 'Incorrect', 'wpfc' );
            $wpfc_verdict_class      = "wpfc-incorrect";
            break;
        
        case 2:
            $wpfc_alternate_name = __( 'Mostly Incorrect', 'wpfc' );
            $wpfc_verdict_class      = "wpfc-incorrect";    
        break;

        case 3:
            $wpfc_alternate_name = __( 'Partially Correct', 'wpfc' );
            $wpfc_verdict_class      = "wpfc-unknown";    
        break;

        case 4:
            $wpfc_alternate_name = __( 'Mostly Correct', 'wpfc' );
            $wpfc_verdict_class      = "wpfc-correct";    
        break;

        case 5:
            $wpfc_alternate_name = __( 'Correct', 'wpfc' );
            $wpfc_verdict_class      = "wpfc-correct";    
        break;

        default:
            $wpfc_alternate_name = '';
            $wpfc_verdict_class      = "wpfc-unknown";
            break;
    }

    return '
        <div class="wpfc-factcheck">
            <div class="wpfc-column">
                <div class="wpfc-claim">
                    <div class="wpfc-column-content">
                        <div class="wpfc-column-title">' . esc_html__( 'Claim', 'wpfc' ) . '</div>
                        <p>' . $wpfc_claim . '</p>
                        <div class="wpfc-column-title">' . esc_html__( 'Author', 'wpfc' ) . '</div>
                        ' . $wpfc_author . '
                    </div>
                </div>
            </div>

            <div class="wpfc-column">
                <div class="wpfc-verdict '.$wpfc_verdict_class.'">
                    <div class="wpfc-column-content">
                        <div class="wpfc-column-title">' . esc_html__( 'Verdict', 'wpfc' ) . '</div>
                        <div class="wpfc-rating">' . $wpfc_alternate_name . '</div>
                        '.$wpfc_explainer.'
                    </div>
                </div>
            </div>
        </div>'
        . $the_content;
}