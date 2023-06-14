<?php
if (have_rows('section_3')):
    while (have_rows('section_3')): the_row();
        $tab_name = get_sub_field('tab_name');
        $section_title = get_sub_field('section_title');
        $section_link = get_sub_field('section_link');
        $image = get_sub_field('background_image');
        $color = get_sub_field('background_color');
        $list_services = get_sub_field('select_portfolio');
        ?>
        <section class="h-100 w-100 position-relative row py-5 py-lg-0 px-0 mx-0 justify-content-lg-between justify-content-center mobile-section-bg overflow-hidden"
                 style="background-color: <?php echo esc_attr($color); ?>"
                 data-name="<?= $tab_name; ?>">
            <div class="col-lg-5">
                <img data-aos="fade-up-left" data-aos-duration="3000" data-aos-disable
                     class="position-absolute bottom-0 start-0 w-75 section3"
                     src="<?php echo esc_url($image['url']); ?>"
                     alt="<?php echo esc_url($image['alt']); ?>"
                >
            </div>
            <div class="col-lg-7 g-2 row flex-row-reverse justify-content-center align-content-center mb-5 z-top">
                <h2 class="text-center text-white" data-aos="fade-down" data-aos-delay="100">
                    <?= $section_title; ?>
                </h2>
                <div class="text-center mt-2 ">
                    <a class="MoreLink position-relative d-inline-block lazy fs-6"
                       data-aos="fade-down" data-aos-delay="300"
                       href="<?php echo get_post_type_archive_link('portfolio'); ?>">
                        <?= $section_link; ?>
                    </a>
                </div>
                <ul class="nav nav-fill my-4 px-5"
                    id="myTab" role="tablist">
                    <?php
                    $terms = array();
                    $post_terms = get_terms( array(
                        'taxonomy' => 'portfolio_categories',
                        'hide_empty' => false, // set to true if you only want to retrieve categories that have posts assigned to them
                    ) );

                    if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
                        foreach ( $post_terms as $term ) {
                            $terms[$term->term_id] = $term;
                        }
                    }

                    $i = 0;
                    // Iterate through the unique set of terms to generate the tab buttons
                    foreach ($terms as $term) {
                        $i++;
                        $category_id = $term->term_id; ?>
                        <li class="nav-item" role="presentation">
                            <button class="button button-white <?php if ($i == 1) {
                                echo 'active';
                            }
                            ?>" id="cat-<?= $category_id; ?>-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#cat-<?= $category_id; ?>" type="button" role="tab"
                                    aria-controls="cat-<?= $category_id; ?>" aria-selected="true">
                                <?= $term->name; ?>
                            </button>
                        </li>
                    <?php } ?>
                </ul>

                <div class="tab-content row justify-content-center" id="myTabContent">

                    <?php
                    $b = 0;
                    $s = 0;
                    foreach ($terms as $term) {
                        $s++;
                        $category_id = $term->term_id; ?>
                        <div class="tab-pane col-lg-10 fade <?php if ($s == 1) {
                            echo 'show active';
                        }
                        ?>" id="cat-<?= $category_id; ?>" role="tabpanel"
                             aria-labelledby="cat-<?= $category_id; ?>-tab">
                            <div class="row g-2">
                                <?php
                                $args = array(
                                    'post_type' => 'portfolio',
                                    'ignore_sticky_posts' => 1,
                                    'posts_per_page' => 4,
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'portfolio_categories',
                                            'field' => 'term_id',
                                            'terms' => $category_id,
                                            'operator' => 'IN'
                                        )
                                    )
                                );
                                $loopPortfolio = new WP_Query($args);
                                if ($loopPortfolio->have_posts()) {
                                    while ($loopPortfolio->have_posts()) : $loopPortfolio->the_post(); $b++;
                                        $category_ids = get_the_terms(get_the_ID(), 'portfolio_categories');
                                        if ($category_ids[0]->term_id == 18){ ?>
                                            <div class="col-lg-6 col-12 aos-animate aos" data-aos="zoom-in"
                                                 data-aos-delay="<?= $b; ?>00">
                                                <?php get_template_part('template-parts/website-hover-card'); ?>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="col-lg-6 col-12 aos-animate aos" data-aos="zoom-in"
                                                 data-aos-delay="<?= $b; ?>00">
                                                <?php get_template_part('template-parts/hover-card'); ?>
                                            </div>
                                        <?php } ?>

                                    <?php endwhile;
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>
        </section>
    <?php
    endwhile;
endif; ?>
