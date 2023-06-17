<?php
function wpfc_menu() {
    add_submenu_page( 'edit.php?post_type=wpfc-fact-checking', __( 'Settings', 'wpfc' ), __( 'Settings', 'wpfc' ), 'manage_options', 'wpfc-settings', 'wpfc_settings_func' );
}

function wpfc_settings_func () {
    $wpfc_options           = get_option( 'wpfc-options' );
    
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Settings', 'wpfc' ); ?></h1>

        <div class="wpfc-settings">
            
            <div class="wpfc-setting-column">
                <div class="wpfc-option">
                    <h3 class="wpfc-option-title"><?php esc_html_e( 'Display Options', 'wpfc' ); ?></h3>
                    <div class="wpfc-option-content">
                        
                        <div class="wpfc-option-row">
                            <div>
                                Show Fact-check details
                                <div class="wpfc-option-details"><?php esc_html_e( 'Do you want to display the fact-check details above the post?', 'wpfc'); ?></div>
                            </div>
                            <div>
                                <label for="wpfc-show-details-yes"><?php esc_html_e( 'Yes', 'wpfc' ); ?></label> <input <?php checked( $wpfc_options['display'], 'yes', true ); ?> id="wpfc-show-details-yes" type="radio" class="wpfc-show-details" name="wpfc-show-details" value="yes"  />

                                <label for="wpfc-show-details-no"><?php esc_html_e( 'No', 'wpfc' ); ?></label> <input <?php checked( $wpfc_options['display'], 'no', true ); ?> id="wpfc-show-details-no" type="radio" class="wpfc-show-details" name="wpfc-show-details" value="no"  />
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Columns
                                <div class="wpfc-option-details"><?php esc_html_e( 'How do you want to display the fact-checking details?', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <select id="wpfc-display-columns">
                                    <option <?php selected( $wpfc_options['columns'], 'one-column', true ); ?> value="one-column">One column</option>
                                    <option <?php selected( $wpfc_options['columns'], 'two-columns', true ); ?> value="two-columns">Two columns</option>
                                </select>
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Icons
                                <div class="wpfc-option-details"><?php esc_html_e( 'Do you want to display icons?', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <select id="wpfc-show-icons">
                                    <option <?php selected( $wpfc_options['icons'], 'show', true ); ?> value="show">Show Icons</option>
                                    <option <?php selected( $wpfc_options['icons'], 'hide', true ); ?> value="hide">Hide Icons</option>
                                </select>
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Title Font
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose the font you want to use on titles.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <select id="wpfc-title-font">
                                    <option <?php selected( $wpfc_options['fonts']['title'], 'inherit', true ); ?> value="inherit">Default</option>
                                    <option <?php selected( $wpfc_options['fonts']['title'], 'Inter', true ); ?> value="Inter">Inter</option>
                                    <option <?php selected( $wpfc_options['fonts']['title'], 'Lora', true ); ?> value="Lora">Lora</option>
                                </select>
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Content Font
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose the font you want to use on content.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <select id="wpfc-content-font">
                                    <option <?php selected( $wpfc_options['fonts']['content'], 'inherit', true ); ?> value="inherit">Default</option>
                                    <option <?php selected( $wpfc_options['fonts']['content'], 'Inter', true ); ?> value="Inter">Inter</option>
                                    <option <?php selected( $wpfc_options['fonts']['content'], 'Lora', true ); ?> value="Lora">Lora</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="wpfc-setting-column">
                <div class="wpfc-option">
                    <h3 class="wpfc-option-title"><?php esc_html_e( 'Color Options', 'wpfc' ); ?></h3>
                    <div class="wpfc-option-content">

                        <div class="wpfc-option-row">
                            <div>
                                Background Color
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose a color for the background of the box.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <input type="text" id="wpfc-background-color" value="<?php echo esc_attr( $wpfc_options['colors']['background'] ); ?>" class="wpfc-color-picker" data-default-color="#f9f9f9" />
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Border Color
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose a color for the border of the box.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <input type="text" id="wpfc-border-color" value="<?php echo esc_attr( $wpfc_options['colors']['border'] ); ?>" class="wpfc-color-picker" data-default-color="#e5e5e5" />
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Title Color
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose a color for the titles.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <input type="text" id="wpfc-title-color" value="<?php echo esc_attr( $wpfc_options['colors']['title'] ); ?>" class="wpfc-color-picker" data-default-color="#777777" />
                            </div>
                        </div>

                        <div class="wpfc-option-row">
                            <div>
                                Content Color
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose a color for the content.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <input type="text" id="wpfc-content-color" value="<?php echo esc_attr( $wpfc_options['colors']['content'] ); ?>" class="wpfc-color-picker" data-default-color="#777777" />
                            </div>
                        </div>
                        
                        <div class="wpfc-option-row">
                            <div>
                                Icons Color
                                <div class="wpfc-option-details"><?php esc_html_e( 'Choose a color for the icons.', 'wpfc' ); ?></div>
                            </div>
                            <div>
                                <input type="text" id="wpfc-icon-color" value="<?php echo esc_attr( $wpfc_options['colors']['icons'] ); ?>" class="wpfc-color-picker" data-default-color="#ededed" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <input type="button" id="wpfc-submit" class="button button-primary" value="<?php esc_attr_e( 'Save Options', 'wpfc' ); ?>" />
    </div>
    <?php
}