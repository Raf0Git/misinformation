<?php
/*
Plugin Name: Blocco Notizie
Description: Plugin per bloccare e sbloccare notizie su tutti gli articoli del sito
Version: 1.0
Author: Alessia Mansueto
*/

// Aggiungi il tasto di blocco ad ogni articolo
function aggiungi_tasto_blocco($content) {
    if (is_singular('post') && is_user_logged_in()) {
        $bloccato = get_post_meta(get_the_ID(), '_bloccato', true);
        $tasto_blocco = '<button class="blocco-notizia" data-post-id="' . get_the_ID() . '" data-bloccato="' . ($bloccato ? 'true' : 'false') . '">' . ($bloccato ? 'Sblocca notizia' : 'Blocca notizia') . '</button>';
        $content .= $tasto_blocco;
    }
    return $content;
}
add_filter('the_content', 'aggiungi_tasto_blocco');

// Azione per bloccare una notizia
add_action('wp_ajax_blocco_notizia', 'blocco_notizia_callback');
add_action('wp_ajax_nopriv_blocco_notizia', 'blocco_notizia_callback');
function blocco_notizia_callback() {
    $postId = $_POST['postId'];
    $bloccato = $_POST['bloccato'];

    if ($bloccato === 'true') {
        update_post_meta($postId, '_bloccato', 'true');
    } else {
        delete_post_meta($postId, '_bloccato');
    }

    echo 'success';
    wp_die();
}

// Aggiungi la pagina Lista Blocchi
function crea_pagina_lista_blocchi() {
    $pagina = array(
        'post_title'    => 'Lista Blocchi',
        'post_content'  => '[lista_blocchi]',
        'post_status'   => 'publish',
        'post_type'     => 'page'
    );
    wp_insert_post($pagina);
}
register_activation_hook(__FILE__, 'crea_pagina_lista_blocchi');

// Aggiungi il shortcode per visualizzare la lista dei blocchi
function visualizza_lista_blocchi() {
    if (is_user_logged_in()) {
        $args = array(
            'post_type'      => 'post',
            'meta_key'       => '_bloccato',
            'meta_value'     => '1',
            'posts_per_page' => -1
        );
        $blocchi = new WP_Query($args);
        if ($blocchi->have_posts()) {
            $output = '<ul class="lista-blocchi">';
            while ($blocchi->have_posts()) {
                $blocchi->the_post();
                $output .= '<li>' . get_the_title() . ' - <button class="sblocca-notizia" data-post-id="' . get_the_ID() . '">Sblocca</button></li>';
            }
            $output .= '</ul>';
        } else {
            $output = 'Nessuna notizia bloccata.';
        }
        wp_reset_postdata();
        return $output;
    }
}
// Registra il tuo shortcode
add_shortcode('lista_blocchi', 'visualizza_lista_blocchi');


// Azione per sbloccare una notizia
add_action('wp_ajax_sblocca_notizia', 'sblocca_notizia_callback');
add_action('wp_ajax_nopriv_sblocca_notizia', 'sblocca_notizia_callback');
function sblocca_notizia_callback() {
    $postId = $_POST['postId'];

    delete_post_meta($postId, '_bloccato');

    echo 'success';
    wp_die();
}

// Verifica se la funzione aggiungi_script_e_css() esiste già
if (!function_exists('aggiungi_script_e_css')) {
    // Aggiungi gli script e i CSS necessari
    function aggiungi_script_e_css() {
      wp_enqueue_script('jquery');
      wp_enqueue_script('blocco-notizie-script', plugin_dir_url(__FILE__) . 'js/blocco-notizie.js', array('jquery'), '1.0', true);
      wp_enqueue_style('blocco-notizie-style', plugin_dir_url(__FILE__) . 'css/blocco-notizie.css');
    }
  }
  
  // Aggiungi l'azione solo se la funzione non è stata già definita
  if (!has_action('wp_enqueue_scripts', 'aggiungi_script_e_css')) {
    add_action('wp_enqueue_scripts', 'aggiungi_script_e_css');
  }
  
