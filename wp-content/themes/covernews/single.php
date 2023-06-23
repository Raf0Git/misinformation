<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package CoverNews
 */

get_header(); ?>
        <div class="section-block-upper row">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">

                  <?php
while (have_posts()) {
    the_post();
    $bloccato = get_post_meta(get_the_ID(), '_bloccato', true);

    if ($bloccato && $bloccato == get_current_user_id()) {
        // Notizia bloccata per l'utente corrente, visualizza solo il titolo e il messaggio
        echo '<h1>' . get_the_title() . '</h1>';
        echo '<p class="notizia-bloccata">Notizia bloccata. Devi sbloccarla nella pagina Lista Blocchi per visualizzarne il contenuto.</p>';
    } else {
        // Notizia non bloccata, visualizza il contenuto completo
        the_title('<h1>', '</h1>');
        the_content();
    }
}
?>

                                </div>
                                <?php
                                $show_related_posts = esc_attr(covernews_get_option('single_show_related_posts'));
                                if ($show_related_posts):
                                    if ('post' === get_post_type()) :
                                        covernews_get_block('related');
                                    endif;
                                endif;
                                ?>

                                <?php
                                // If comments are open or we have at least one comment, load up the comment template.
                                if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif;


                                ?>
                            </article>
                        

                    </main><!-- #main -->
                </div><!-- #primary -->
                <?php ?>
                <?php
                get_sidebar(); ?>
            </div>
<?php
get_footer();
