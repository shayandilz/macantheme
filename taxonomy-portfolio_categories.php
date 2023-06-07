<?php
/** Template Name: Portfolio Category Page */

get_header(); ?>

    <section class="container py-5 min-vh-100 ">
        <div class="row g-4 mt-5">
            <h1 class="text-white"><?php single_cat_title(); ?></h1>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
            <?php if (have_posts()) :
                $b = 0;
                while (have_posts()) :
                    the_post();
                    $b++;
                    $category_ids = get_the_terms(get_the_ID(), 'portfolio_categories');
                    if ($category_ids[0]->term_id == 18) { ?>
                        <div class="col-lg-4 col-md-6 col-12 aos-animate aos" data-aos="zoom-in"
                             data-aos-delay="<?= $b; ?>00">
                            <?php get_template_part('template-parts/website-hover-card'); ?>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-4 col-md-6 col-12 aos-animate aos" data-aos="zoom-in"
                             data-aos-delay="<?= $b; ?>00">
                            <?php get_template_part('template-parts/hover-card'); ?>
                        </div>
                    <?php } ?>
                <?php endwhile;
            endif;
            ?>
            <div class="mt-5 py-5 w-100">
                <?php
                $links = paginate_links(array(
                    'type' => 'array',
                    'prev_next' => false,

                ));
                if ($links) : ?>

                    <nav aria-label="age navigation example text-dark">
                        <?php echo '<ul class="pagination gap-3 justify-content-center align-items-center flex-row-reverse mb-0">';
                        // get_previous_posts_link will return a string or void if no link is set.
                        if ($prev_posts_link = get_previous_posts_link(__('>'))) :
                            echo '<li class="prev-list-item page-item">';
                            echo $prev_posts_link;
                            echo '</li>';
                        endif;
                        echo '<li class="page-item">';
                        echo join('</li><li class="page-item">', $links);
                        echo '</li>';

                        // get_next_posts_link will return a string or void if no link is set.
                        if ($next_posts_link = get_next_posts_link(__('<'))) :
                            echo '<li class="next-list-item page-item">';
                            echo $next_posts_link;
                            echo '</li>';
                        endif;
                        echo '</ul>';
                        ?>
                    </nav>

                <?php endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>