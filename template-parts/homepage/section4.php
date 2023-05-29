<?php
if (have_rows('section_4')):
    while (have_rows('section_4')): the_row();
        $tab_name = get_sub_field('tab_name');
        $section_title = get_sub_field('section_title');
        $section_link = get_sub_field('section_link');
        $image = get_sub_field('background_image');
        $color = get_sub_field('background_color');
        ?>
        <section class="h-100 w-100 py-5 py-lg-0 overflow-hidden position-relative d-flex justify-content-center align-items-center mobile-section-bg"
                 style="background-color: <?php echo esc_attr($color); ?>"
                 data-name="<?= $tab_name; ?>">
            <div class="container">
                <div class="row px-0 mx-0 justify-content-between">
                    <div class="col-lg-7 g-2 row flex-row-reverse justify-content-center align-content-center mb-5 z-top">
                        <h2 class="text-center text-white" data-aos="fade-down" data-aos-delay="100">
                            <?= $section_title; ?>
                        </h2>
                        <div class="text-center mt-2 ">
                            <a class="MoreLink position-relative d-inline-block lazy small"
                               data-aos="fade-down" data-aos-delay="300"
                               href="<?php echo get_post_type_archive_link('post'); ?>">
                                <?= $section_link; ?>
                            </a>
                        </div>
                        <div class="row g-2">
                            <?php
                            $c = 0;
                            $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => '4',
                                'ignore_sticky_posts' => true
                            );
                            $loopPortfolio = new WP_Query($args);
                            if ($loopPortfolio->have_posts()) {
                                while ($loopPortfolio->have_posts()) : $loopPortfolio->the_post();
                                    $c++; ?>
                                    <div class="col-lg-6 aos-animate aos2" data-aos="zoom-in"
                                         data-aos-delay="<?= $c; ?>00">
                                        <?php get_template_part('template-parts/blog-home-card'); ?>
                                    </div>
                                <?php endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img data-aos="fade-up-right" data-aos-duration="3000" data-aos-disable
                             class="position-absolute bottom-0 end-0 w-75 section4"
                             alt="<?php echo esc_url($image['alt']); ?>"
                             src="<?php echo esc_url($image['url']); ?>">
                    </div>
                </div>
            </div>

        </section>
    <?php
    endwhile;
endif; ?>
