<?php
// Declare metaboxes
function wpfc_meta_boxes() {
    add_meta_box( 
		  'wpfc_factcheck_claim',
		  __( 'Claim', 'wpfc' ),
		  'wpfc_display_metabox_claim',
		  'wpfc-fact-checking',
		  'advanced'
    );
    
    add_meta_box( 
		'wpfc_factcheck_verdict',
		__( 'Verdict', 'wpfc' ),
		'wpfc_display_metabox_verdict',
		'wpfc-fact-checking',
		'advanced'
    );
}

// Display metaboxes
function wpfc_display_metabox_claim( $post ){
    $wpfc_claim         = get_post_meta( $post->ID, '_wpfc_claim', true );
    $wpfc_author        = get_post_meta( $post->ID, '_wpfc_author', true );
    $wpfc_author_type   = get_post_meta( $post->ID, '_wpfc_author_type', true );
    $wpfc_source        = get_post_meta( $post->ID, '_wpfc_source', true );
    $wpfc_verdict       = get_post_meta( $post->ID, '_wpfc_verdict', true );
    $wpfc_explainer     = get_post_meta( $post->ID, '_wpfc_explainer', true );
    ?>
  
  <div class="wpfc-box">
        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Claim', 'wpfc' ); ?>
                    </div>
                </div>
                <div class="wpfc-col right-col"><textarea name="wpfc-claim" id="wpfc-claim" rows="4"><?php echo esc_textarea( $wpfc_claim ); ?></textarea>
                </div>
            </div>
        </div>
    
        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Author', 'wpfc' ); ?>
                    </div>
                </div>
                <div class="wpfc-col right-col"><input type="text" name="wpfc-author" id="wpfc-author" value="<?php echo esc_attr( $wpfc_author ); ?>" />
                </div>
            </div>
        </div>

        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Author Type', 'wpfc' ); ?></div>
                </div>
                <div class="wpfc-col right-col">
                  <select name="wpfc-author-type" id="wpfc-author-type">
                    <option value="Person" <?php selected( $wpfc_author_type, 'Person', true ); ?>> <?php esc_html_e( 'Person', 'wpfc' ); ?></option>
                    <option value="Organization" <?php selected( $wpfc_author_type, 'Organization', true ); ?>> <?php esc_html_e( 'Organisation', 'wpfc' ); ?></option>
                  </select>
                  </div>
            </div>
        </div>

        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Source/URL', 'wpfc' ); ?></div>
                </div>
                <div class="wpfc-col right-col">
                  <input type="text" name="wpfc-source" id="wpfc-source" value="<?php echo esc_attr( $wpfc_source ); ?>" />
                  </div>
            </div>
        </div>
    </div>
	<?php
}

function wpfc_display_metabox_verdict( $post ){
    $wpfc_verdict       = get_post_meta( $post->ID, '_wpfc_verdict', true );
    $wpfc_explainer     = get_post_meta( $post->ID, '_wpfc_explainer', true );

    $verdicts           = [
      '',
      __( 'Incorrect', 'wpfc' ),
      __( 'Mostly Incorrect', 'wpfc' ),
      __( 'Partially Correct', 'wpfc' ),
      __( 'Mostly Correct', 'wpfc' ),
      __( 'Correct', 'wpfc' )
    ];
	  ?>
    <div class="wpfc-box">
        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Verdict', 'wpfc' ); ?></div>
                </div>
                
                <div class="wpfc-col right-col">
                  <select name="wpfc-verdict" id="wpfc-verdict">
                    <option value=""><?php esc_html_e( 'Choose a verdict', 'wpfc' ) ?></option>
                    <?php
                    for( $i=1; $i < sizeof($verdicts); $i++ ) {
                      ?>
                      <option value="<?php echo $i ?>" <?php selected( $wpfc_verdict, $i, true ); ?>><?php esc_html_e( $verdicts[$i] ); ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
          </div>
        </div>

        <div class="wpfc-row">
            <div class="wpfc-inner-row">
                <div class="wpfc-col left-col">
                    <div class="wpfc-title"><?php esc_html_e( 'Explainer', 'wpfc' ); ?></div>
                </div>
                
                <div class="wpfc-col right-col">
                  <textarea name="wpfc-explainer" id="wpfc-explainer" rows="4"><?php echo $wpfc_explainer; ?></textarea>
                  </div>
            </div>
        </div>
    </div>
	<?php
}

// Save metaboxes
function wpfc_save_metaboxes( $post_id ) {
	  if( isset( $_POST['wpfc-claim'] ) ) {
		  update_post_meta( $post_id, '_wpfc_claim', sanitize_textarea_field( $_POST['wpfc-claim'] ) );
    }

    if( isset( $_POST['wpfc-author'] ) ) {
      update_post_meta( $post_id, '_wpfc_author', sanitize_text_field( $_POST['wpfc-author'] ) );
    }

    if( isset( $_POST['wpfc-author-type'] ) ) {
      update_post_meta( $post_id, '_wpfc_author_type', sanitize_text_field( $_POST['wpfc-author-type'] ) );
    }
    
    if( isset( $_POST['wpfc-source'] ) ) {
		  update_post_meta( $post_id, '_wpfc_source', sanitize_text_field( $_POST['wpfc-source'] ) );
    }
    
    if( isset( $_POST['wpfc-verdict'] ) ) {
		  update_post_meta( $post_id, '_wpfc_verdict', sanitize_text_field( $_POST['wpfc-verdict'] ) );
    }
    
    if( isset( $_POST['wpfc-explainer'] ) ) {
		  update_post_meta( $post_id, '_wpfc_explainer', sanitize_textarea_field( $_POST['wpfc-explainer'] ) );
	  }
}
