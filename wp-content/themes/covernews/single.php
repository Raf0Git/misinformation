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
                        while (have_posts()) : the_post();
							//controlla se la notizia è bloccata per l'utente corrente
							$bloccato = getBloccato(get_the_ID(), get_current_user_id());
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class('af-single-article'); ?>>
                                <div class="entry-content-wrap">
                                    <?php 
									//nasconde una notizia bloccata
									if (!$bloccato) {
										//covernews_get_block('header');
										get_template_part('template-parts/content', get_post_type());
									} else {?>
										<p style="text-align:center; font-weight: bold;">Notizia bloccata. Clicca su <a style="text-decoration: underline;" href="http://localhost/progetti/misinformation/blocchi/"> Lista Blocchi </a> per sbloccarla.</p>
									<?php
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
                        <?php

                        endwhile; // End of the loop.
                        ?>

                    </main><!-- #main -->
                </div><!-- #primary -->
                <?php ?>
                <?php
                get_sidebar(); ?>
            </div>
<?php
get_footer();