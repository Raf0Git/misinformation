<?php
function display_fact_check_button($content) {
  // Verifica se si tratta di un articolo singolo
  if (is_single()) {
    $url=get_post_meta(get_the_ID(), 'link', true);
	
	// Ottieni l'attendibilità della notizia
	$fact_check_result = get_evaluation($url);

	$content .= $fact_check_result;
  }

  return $content;
}
add_filter('the_content', 'display_fact_check_button');

// Funzione per verificare l'attendibilità della notizia
function verifyFactCheck($url) {
	$apiUrl = "https://factchecktools.googleapis.com/v1alpha1/claims:search";
    $apiKey = 'AIzaSyC9vvEK6tvlyVeRrCH5SO61TP6qyQaadX8'; // Inserisci la tua chiave API qui
	
	$params = array(
		"key" => $apiKey,
		"query" => $url
	);

	$queryString = http_build_query($params);
	$requestUrl = $apiUrl . "?" . $queryString;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $requestUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($curl);
	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	curl_close($curl);

	if ($status == 200) {
		$data = json_decode($response, true);

		if (!empty($data['claims'])) {
			$claim = $data['claims'][0];
			$text = $claim['text'];
			$rating = $claim['claimReview'][0]['textualRating'];

			return trim($rating); //"L'attendibilità della notizia è: " . 
		} else {
			return "Nessun risultato";
		}
	} else {
		return "Richiesta fallita con codice " . $status . ": " . $response;
	}
}

function display_blocco_button($content) {
  // Verifica se si tratta di un articolo singolo
  if (is_singular('post') && is_user_logged_in()) {
    //controlla se la notizia è bloccata per l'utente corrente
	$bloccato = getBloccato(get_the_ID(), get_current_user_id());
	
	// Aggiungi il pulsante alla fine del contenuto dell'articolo
	$content .= '<form action="http://localhost/progetti/misinformation/blocco/" method="post" name="' . get_the_ID() . '" enctype="multipart">';
	$content .= '<input type="hidden" name="notizia-id" value="' . get_the_ID() . '" />';
	$content .= '<input type="hidden" name="user-id" value="' . get_current_user_id() . '" />';
	$content .= '<input type="submit" value="' . ($bloccato ? 'Sblocca notizia' : 'Blocca notizia') . '" /></form>';
  }

  return $content;
}
add_filter('the_content', 'display_blocco_button');

//restituisce una valutazione unica tra 1 e 5 unendo tutte le singole valutazioni
function get_evaluation($url) {
	//vettore con le valutazioni
  	$valutazioni=array('1'=>'Notizia inaffidabile', '2'=>'Notizia probabilmente inaffidabile', '3'=>'Notizia né affidabile né inaffidabile', '4'=>'Notizia probabilmente affidabile', '5'=>'Notizia affidabile');
	
	//vettore con i pesi dei vari metodi
	$pesi=array('google'=>30, 'blacklist'=>20);
	$tot_val=array_sum($pesi);
	$val=0;
	$result='';
	
	$google=get_fact_check_evaluation($url); //valore 30
	if ($google==0) $tot_val -= $pesi['google'];
	$blacklist=get_blacklist_evaluation($url); //valore 20
	if ($blacklist==0) $tot_val -= $pesi['blacklist'];
	
	if($tot_val!=0) {
		$val=$google*($pesi['google']/$tot_val)+$blacklist*($pesi['blacklist']/$tot_val);
	}
	
	
	// Aggiungi il risultato alla fine del contenuto dell'articolo
	if($val == 0) {
		$result .= '<div class="fact-check-result" style="text-align:center; font-weight: bold;">Nessuna informazione sull\'attendibilità della notizia trovata</div>';
	} else {
		$result .= '<div class="fact-check-result" style="text-align:center; font-weight: bold;">Valutazione: ' . $val . ' su 5. ' . $valutazioni[$val] . '</div>';
	}
	return $result;
}

function get_fact_check_evaluation($url) {
	$google=strtolower(verifyFactCheck($url));
	
	$result=0;
	//possibili valutazioni ottenibili dai seguenti siti: https://www.open.online/, https://facta.news/, https://www.bufale.net/
	$map = array('falso' => 1, 'alterat' => 1, 'notizia falsa' => 1, 'immagine modificata' => 1, 'video modificato' => 1, 'disinformazione' => 1, 'allarmismo' => 1, 'complottismo' => 1, 'non condividere' => 1, 'truffa' => 1, 'smentit' => 1, 'fake news' => 1, 'parzialmente fals' => 2, 'satira' => 2, 'notizia satirica' => 2, 'satir' => 2, 'senza prove' => 2, 'nessuna fonte' => 2, 'nessuna prova' => 2, 'nessuna fonte' => 2, 'nì' => 2, 'contesto mancante' => 3, 'fuori contesto' => 3, 'notizia imprecisa' => 3, 'notizia vecchia' => 3, 'precisazioni' => 4, 'vero' => 5, 'notizia vera' => 5, 'fact checking' => 0, 'editoriale' => 0, 'approfondimento' => 0, 'analisi in corso' => 0, 'indagini in corso' => 0, 'versioni a confronto' => 0, "nessun risultato" => 0, 'richiesta fallita con codice' => 0);
	foreach ($map as $keyword => $value) {
		if (strpos($google, $keyword) !== false) {
			$result=$value;
			break;
		}
	}
	
	return $result;
}

function get_blacklist_evaluation($url) {
	create_Blacklist();
	
	if (inBlacklist($url)) {
		return 2;
	} else {
		return 4;
	}
}

function create_Blacklist() {
	$blacklist_file='blacklist.json';
	if (file_exists($blacklist_file))
		return true;
	
	$blacklist = 'https://www.bufale.net/the-black-list-la-lista-nera-del-web/';
	$page = file_get_contents($blacklist); // Fetch the HTML content of the page
	
	//estraggo i link
	preg_match_all('/<li><a href="([^"]*)"/', $page, $links);
	$links=$links[1];
	//elimino http, https e prendo solo il dominio
	foreach ($links as &$link) {
		$link = preg_replace('/^http[s]*:\/\//', "", $link);

		//prendo solo il dominio
		$dominio = explode("/", $link)[0];
		if($dominio != "www.facebook.com" && $dominio != "twitter.com") {
			$link=$dominio;
		}
	}
	
	//salvo i link su un file
	return file_put_contents($blacklist_file, json_encode($links, JSON_PRETTY_PRINT));
}

function inBlacklist($url) {
	$blacklist_file='blacklist.json';
	$links=json_decode(file_get_contents($blacklist_file), true);
	foreach ($links as $link) {
		if (str_contains($url, $link)) {
			return true;
		}
	}
	return false;
}

function getBloccato($post, $user) {
	$bloccato=false;
	$blocchi = get_post_meta($post, '_bloccato', false);
	foreach ($blocchi as $blocco) {
		if ($blocco == $user) {
			$bloccato=true;
			break;
		}
	}
	return $bloccato;
}

function nascondiNotizie($where) {
	$user=get_current_user_id();
	return $where .= " AND wp_posts.ID NOT IN (SELECT post_id FROM wp_postmeta WHERE meta_key='_bloccato' and meta_value='$user')";
}
add_filter('posts_where', 'nascondiNotizie');
//add_filter('search_link', 'nascondiNotizie');

// // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Define Theme Constants.
 */

defined('ESHF_COMPATIBILITY_TMPL') or define('ESHF_COMPATIBILITY_TMPL', 'covernews');

/**
 * CoverNews functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package CoverNews
 */

if (!function_exists('covernews_setup')):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
    /**
     *
     */
    /**
     *
     */
    function covernews_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on CoverNews, use a find and replace
	 * to change 'covernews' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('covernews', get_template_directory().'/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

        // Add featured image sizes


        add_image_size('covernews-slider-full', 1115, 715, true); // width, height, crop
        add_image_size('covernews-slider-center', 800, 500, true); // width, height, crop
        add_image_size('covernews-featured', 1024, 0, false ); // width, height, crop
        add_image_size('covernews-medium', 540, 340, true); // width, height, crop
        add_image_size('covernews-medium-square', 400, 250, true); // width, height, crop

    /*
     * Enable support for Post Formats on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/post-formats/
     */
    add_theme_support( 'post-formats', array( 'image', 'video', 'gallery' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(array(
			'aft-primary-nav' => esc_html__('Primary Menu', 'covernews'),
			'aft-top-nav' => esc_html__('Top Menu', 'covernews'),
			'aft-social-nav' => esc_html__('Social Menu', 'covernews'),
			'aft-footer-nav' => esc_html__('Footer Menu', 'covernews'),
		));

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

	// Set up the WordPress core custom background feature.
	add_theme_support('custom-background', apply_filters('covernews_custom_background_args', array(
				'default-color' => 'f7f7f7',
				'default-image' => '',
			)));

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support('custom-logo', array(
			'flex-width'  => true,
			'flex-height' => true,
		));

        /*
         * Add theme support for gutenberg block
          */
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );



    }
endif;
add_action('after_setup_theme', 'covernews_setup');


/**
 * function for google fonts
 */
if (!function_exists('covernews_fonts_url')):

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function covernews_fonts_url() {

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Oswald, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Source Sans Pro font: on or off', 'covernews')) {
            $fonts[] = 'Source+Sans+Pro:400,700';
        }

        /* translators: If there are characters in your language that are not supported by Lato, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Lato font: on or off', 'covernews')) {
            $fonts[] = 'Lato:400,700';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), 'https://fonts.googleapis.com/css');
        }
        return $fonts_url;
    }
endif;


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function covernews_content_width() {
	$GLOBALS['content_width'] = apply_filters('covernews_content_width', 640);
}
add_action('after_setup_theme', 'covernews_content_width', 0);




/**
 * Enqueue scripts and styles.
 */
function covernews_scripts() {

	$min = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG? '':'.min';
    $fonts_url = covernews_fonts_url();
    $covernews_version =  wp_get_theme()->get( 'Version' );
	
	wp_enqueue_style('covernews-icons', get_template_directory_uri() . '/assets/covernews-icons/style.css');
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/bootstrap/css/bootstrap'.$min.'.css');
	

    if (!empty($fonts_url)) {
        wp_enqueue_style('covernews-google-fonts', $fonts_url, array(), null);
    }

    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style('covernews-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css');
    }
	
	wp_enqueue_style('covernews-style', get_template_directory_uri().'/style'.$min.'.css', array(), $covernews_version);

	wp_enqueue_script('covernews-navigation', get_template_directory_uri().'/js/navigation.js', array(),  $covernews_version, true);
	wp_enqueue_script('covernews-skip-link-focus-fix', get_template_directory_uri().'/js/skip-link-focus-fix.js', array(),  $covernews_version, true);

	
	
	wp_enqueue_script('matchheight', get_template_directory_uri().'/assets/jquery-match-height/jquery.matchHeight'.$min.'.js', array('jquery'), $covernews_version, true);

    
    
$disable_sticky_header_option = covernews_get_option('disable_sticky_header_option');
    if($disable_sticky_header_option == false ){ 
    wp_enqueue_script('covernews-fixed-header-script', get_template_directory_uri().'/assets/fixed-header-script.js', array('jquery'),  $covernews_version, 1);
}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

    if ( is_page_template('tmpl-front-page.php') || is_front_page() || is_home()) {

        $show_main_news_section = covernews_get_option('show_main_news_section');
        $show_flash_news_section = covernews_get_option('show_flash_news_section');

        if($show_main_news_section){
            wp_enqueue_style('slick', get_template_directory_uri() . '/assets/slick/css/slick.css', array(), $covernews_version);
            wp_enqueue_script('slick', get_template_directory_uri() . '/assets/slick/js/slick' . $min . '.js', array('jquery'), $covernews_version, true);                    
            wp_enqueue_script('bootstrap', get_template_directory_uri().'/assets/bootstrap/js/bootstrap'.$min.'.js', array('jquery'), $covernews_version, true);     
        }

        if($show_flash_news_section){
            wp_enqueue_script('marquee', get_template_directory_uri() . '/assets/marquee/jquery.marquee.js', array('jquery'), $covernews_version, true);  
        }
        
          
    }
    
    wp_enqueue_script('covernews-script', get_template_directory_uri().'/assets/script.js', array('jquery'),  $covernews_version, 1);
	
}
add_action('wp_enqueue_scripts', 'covernews_scripts');



/**
 * Enqueue admin scripts and styles.
 *
 * @since CoverNews 1.0.0
 */
function covernews__admin_scripts($hook){
    if ('widgets.php' === $hook) {
        wp_enqueue_media();
        wp_enqueue_script('covernews-widgets', get_template_directory_uri() . '/assets/widgets.js', array('jquery'), '4.0.0', true);
    }

    wp_enqueue_style('covernews-notice', get_template_directory_uri().'/assets/css/notice.css');
}
add_action('admin_enqueue_scripts', 'covernews__admin_scripts');



/**
 * Custom template tags for this theme.
 */
require get_template_directory().'/inc/template-tags.php';

/**
 * Custom Multi Author tags for this theme.
 */
require get_template_directory() . '/inc/multi-author.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory().'/inc/template-images.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory().'/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/customizer/customizer.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory().'/inc/custom-header.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/init.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/ocdi.php';



/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory().'/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Descriptions on Header Menu
 * @author AF themes
 * @param string $item_output, HTML outputp for the menu item
 * @param object $item, menu item object
 * @param int $depth, depth in menu structure
 * @param object $args, arguments passed to wp_nav_menu()
 * @return string $item_output
 */
function covernews_header_menu_desc( $item_output, $item, $depth, $args ) {

    if( 'aft-primary-nav' == $args->theme_location  && $item->description )
        $item_output = str_replace( '</a>', '<span class="menu-description">' . $item->description . '</span></a>', $item_output );

    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'covernews_header_menu_desc', 10, 4 );

add_action( 'after_setup_theme', 'covernews_transltion_init');

function covernews_transltion_init() {
    load_theme_textdomain( 'covernews', false, get_template_directory()  . '/languages' );
}

