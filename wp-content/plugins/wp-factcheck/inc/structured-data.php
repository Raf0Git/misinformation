<?php
function wpfc_struct_data() {
    global $post;
    
    // Check post type. Schema will only be added to fact-checking posts
    if( get_post_type( $post ) != 'wpfc-fact-checking' ) {
        return;
    }

    $wpfc_claim         = get_post_meta( $post->ID, '_wpfc_claim', true );
    $wpfc_author        = get_post_meta( $post->ID, '_wpfc_author', true );
    $wpfc_author_type   = get_post_meta( $post->ID, '_wpfc_author_type', true );
    $wpfc_source        = get_post_meta( $post->ID, '_wpfc_source', true );
    $wpfc_verdict       = get_post_meta( $post->ID, '_wpfc_verdict', true );
    
    switch( $wpfc_verdict ) {
        case 1:
            $wpfc_alternate_name = __( 'Incorrect', 'wpfc' );
            break;
        
        case 2:
            $wpfc_alternate_name = __( 'Mostly Incorrect', 'wpfc' );
            break;

        case 3:
            $wpfc_alternate_name = __( 'Partially Correct', 'wpfc' );
            break;

        case 4:
            $wpfc_alternate_name = __( 'Mostly Correct', 'wpfc' );
            break;

        case 5:
            $wpfc_alternate_name = __( 'Correct', 'wpfc' );
            break;

        default:
            $wpfc_alternate_name = '';
            break;
    }

    echo '
    <script type="application/ld+json">
    {
        "@context":         "http://schema.org",
        "@type":            "ClaimReview",
        "author":           {
            "@type":        "Organization",
            "url":          "'.get_bloginfo( 'url' ).'/",
            "sameAs":       "",
            "name":         "'.get_bloginfo( 'name' ).'"
        },
        
        "datePublished":    "'.get_the_date( 'Y-m-d', $post ).'",
        "dateModified":     "'.get_the_modified_date( 'Y-m-d', $post ).'",
        "url":              "'.get_the_permalink( $post ).'",
        "description":      "'.get_the_excerpt( $post ).'",
        "claimReviewed":    "'.$wpfc_claim.'",
        "itemReviewed":     {
            "@type":        "creativeWork",
            "author":       {
                "@type":    "'.$wpfc_author_type.'",
                "name":     "'.$wpfc_author.'",
                "sameAs":   ""
            },
            "url":          "'.$wpfc_source.'",
            "datePublished":""
        },
        "reviewRating":     {
            "@type":        "Rating",
            "alternateName":"'. $wpfc_alternate_name .'",
            "ratingValue":  '.$wpfc_verdict.',
            "worstRating":  1,
            "bestRating":   5
        }
    }
    </script>';
}