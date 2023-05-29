<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package baloochy
 */
get_header();
?>

    <section class="container py-5 min-vh-100">
        <div class="row g-2">
            <h4 class="py-4 text-white">
                <?php printf(esc_html__(' نتایج جستجو: %s ', 'macan'), get_search_query()); ?>
            </h4>
            <?php if (have_posts()) : ?>
            <?php
            /* Start the Loop */
            while (have_posts()) :
                the_post(); ?>


                <div class="col-lg-3 col-md-4">
                    <?php get_template_part('template-parts/blog-home-card'); ?>
                </div>


            <?php endwhile; ?>
            <div class="pb-5 pt-3 w-100">
                <?php
                $links = paginate_links(array(
                    'type' => 'array',
                    'prev_next' => false,

                ));
                if ($links) : ?>

                    <nav aria-label="age navigation example text-dark">
                        <?php echo '<ul class="pagination gap-3 justify-content-center align-items-center flex-row-reverse mb-0">';
                        // get_previous_posts_link will return a string or void if no link is set.
                        if ($prev_posts_link = get_previous_posts_link(__('قبلی'))) :
                            echo '<li class="prev-list-item page-item">';
                            echo $prev_posts_link;
                            echo '</li>';
                        endif;
                        echo '<li class="page-item">';
                        echo join('</li><li class="page-item">', $links);
                        echo '</li>';

                        // get_next_posts_link will return a string or void if no link is set.
                        if ($next_posts_link = get_next_posts_link(__('بعدی'))) :
                            echo '<li class="next-list-item page-item">';
                            echo $next_posts_link;
                            echo '</li>';
                        endif;
                        echo '</ul>';
                        ?>
                    </nav>

                <?php endif;
                wp_reset_postdata();
                endif;
                ?>
            </div><!-- #main -->
    </section>

<?php
get_footer();
