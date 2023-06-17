<?php
/*
 * Plugin Name: WP Factcheck
 * Description: Create fact-checking articles with the possibility to add other useful information, like the claim, its source, the verdict and the explainer.
 * Author: Fotso Fonkam
 * Author URI: http://www.iamfotso.cm/a-propos/
 * Plugin URI: http://www.iamfotso.cm/projects/wp-factcheck/
 * Text Domain: wpfc
 * Version: 1.1.2
 * Licence: GLP2+
 * Keywords: factchecking, fact check, fact-check, fake news, verify, claim, verdict, explainer, correct, fake, exaggerated, structured, data
 */

if( !function_exists( 'add_action' ) ) {
    echo "Hi there! I'm just a plugin, not much I can do when called directly.";
    exit;
}

// SETUP
define( 'WPFC_PREFIX', 'wpfc_' );
define( 'WPFC_PLUGIN_URL', __FILE__ );
define( 'WPFC_DEV_MODE', true );
define( 'WPFC_WP_VERSION', '5.8' );

// INCLUDES
include( 'inc/activate.php' );
include( 'inc/deactivate.php' );
include( 'inc/enqueue.php' );
include( 'inc/custom-post-type.php' );
include( 'inc/meta-boxes.php' );
include( 'inc/filters.php' );
include( 'inc/structured-data.php' );
include( 'inc/menu.php' );
include( 'inc/save-settings.php' );
include( 'inc/textdomain.php' );

// HOOKS
register_activation_hook( __FILE__, 'wpfc_activate_plugin' );
register_deactivation_hook( __FILE__,'wpfc_deactivate_plugin' );
add_action( 'admin_enqueue_scripts', 'wpfc_admin_enqueue' );
add_action( 'wp_enqueue_scripts', 'wpfc_enqueue' );
add_action( 'init', 'wpfc_post_types' );
add_action( 'wp_head', 'wpfc_struct_data' );
add_action( 'admin_menu', 'wpfc_menu' );
add_action( 'add_meta_boxes', 'wpfc_meta_boxes' );
add_action( 'save_post', 'wpfc_save_metaboxes' );
add_filter( 'the_content', 'wpfc_content_factcheck' );
add_action( 'plugins_loaded', 'wpfc_load_textdomain' );
add_action( 'wp_ajax_wpfc_save_settings', 'wpfc_save_settings' );