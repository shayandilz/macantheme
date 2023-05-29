<?php
if (have_rows('section_5')):
    while (have_rows('section_5')): the_row();
        $tab_name = get_sub_field('tab_name');
        $section_title = get_sub_field('section_title');
        $image = get_sub_field('background_image');
        $color = get_sub_field('background_color');
        ?>
        <section class="h-100 w-100 py-5 py-lg-0 overflow-hidden position-relative d-flex justify-content-center align-items-center mobile-section-bg"
                 style="background-color: <?php echo esc_attr($color); ?>"
                 data-name="<?= $tab_name; ?>">
            <div class="container">
                <div class="row px-0 mx-0 justify-content-between">
                    <div class="col-lg-5">
                        <img data-aos="fade-up" data-aos-duration="3000" data-aos-disable
                             class="position-absolute bottom-0 start-0 w-75 section5"
                             alt="<?php echo esc_url($image['alt']); ?>"
                             src="<?php echo esc_url($image['url']); ?>">
                    </div>
                    <div class="col-lg-7 g-2 row flex-row-reverse justify-content-center align-content-center mb-5 z-top">
                        <h2 class="text-center text-white" data-aos="fade-down" data-aos-delay="100">
                            <?= $section_title; ?>
                        </h2>
                        <div class="row g-2">
                            <?php
                            $d = 0;
                            $args = array(
                                'post_type' => 'clients',
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                                'ignore_sticky_posts' => true
                            );
                            $loopClients = new WP_Query($args);
                            if ($loopClients->have_posts()) {
                                while ($loopClients->have_posts()) : $loopClients->the_post();
                                    $d++; ?>
                                    <div class="col-lg-3 col-4 aos-animate aos3" title="<?php the_title(); ?>" data-aos="zoom-in"
                                         data-aos-delay="<?= $d; ?>00">
                                        <?php
                                        $client_image = get_field('img_class', get_the_ID(), 'clients');
                                        $client_attr = get_field('client_attr', get_the_ID(), 'clients');
                                        if (!empty($client_attr)): ?>
                                            <img class="<?= $client_image; ?>"
                                                 src="<?php echo $client_attr; ?>"
                                                 alt="<?php the_title(); ?>"/>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <?php
    endwhile;
endif; ?>
