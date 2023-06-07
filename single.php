<?php get_header();

while (have_posts()) :
    the_post();
    ?>
    <div class="position-fixed blog-progress w-100 z-1">
        <progress class="w-100 lazy" max="100" value="0"></progress>
    </div>
    <section class="min-vh-100">
        <div class="bg-danger" style="padding-top: 120px">
            <div class="custom-container d-flex flex-column justify-content-center align-items-start">
                <?php
                $category_detail = get_the_category($post->ID);//$post->ID
                foreach ($category_detail as $category) {
                    $category_url = get_category_link($category->term_id); ?>
                    <span data-category-id="<?= $category->term_id; ?>"
                          class="text-white text-decoration-none fs-6 text-shadow category-button">
                        <?php echo $category->name ?>
                    </span>
                <?php } ?>
                <h1 class="fs-4 text-white my-3">
                    <?php the_title(); ?>
                </h1>
                <div class="d-inline-flex align-items-center gap-3 mb-3">
                    <div class="border-1 border-white border text-white d-flex align-items-center justify-content-center"
                         style="width: 60px;height: 60px">
                        <i class="bi bi-person fs-3 fw-light d-flex align-items-center justify-content-center"></i>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-start gap-3">
                        <span class="fw-normal text-white fw-lighter">
                            <?php echo get_the_author_meta('display_name', $post->post_author); ?>
                        </span>
                        <div class="d-inline-flex text-white gap-3 align-items-center fw-lighter">
                            <?php echo get_the_date('d  F , Y'); ?>
                            <div class="vr bg-white opacity-100"></div>
                            <span class="text-semi-light fs-6">
                        مدت زمان مطالعه               <?= reading_time(); ?> دقیقه
                            </span>
                        </div>
                    </div>
                </div>
                <div class="w-100" style="margin-bottom: -140px">
                    <?php
                    // Get the post ID
                    $post_id = get_the_ID();
                    // Get the featured image ID
                    $featured_image_id = get_post_thumbnail_id($post_id);
                    // Get the full-size image URL
                    $image_url = wp_get_attachment_image_src($featured_image_id, 'full');
                    // Check if the image URL is available
                    if ($image_url) { ?>
                        <img class="img-fluid w-100"
                             src="<?php echo $image_url[0]; ?>" alt="<?= the_title(); ?>" title="<?= the_title(); ?>">
                    <?php }
                    ?>

                </div>
            </div>
        </div>
        <div style="padding-top: 140px;background-color: #f4f4f4">
            <div class="custom-container min-vh-100 position-relative">
                <div class="row g-4 py-4">
                    <div class="col-lg-3 col-12">
                        <div class="sidebar-area shadow-sm">
                            <div class="bg-white px-4 shadow-sm">
                                <h3 class="py-3 text-dark">فهرست</h3>
                                <div class="d-flex align-items-center">
                                    <?php echo do_shortcode('[TOC]') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="col-lg-9 col-12 text-justify text-dark lh-lg sidebar-container">
                        <div class="bg-white p-3 h-100 shadow-sm gx-0">
                            <?php the_content(); ?>
                            <div class="text-center border-top border-1 border-danger">
                                <h5 class="mb-0 my-5">
                                    ارسال نظر
                                </h5>
                                <?php
                                if (comments_open() || get_comments_number()) :
                                    comments_template();
                                endif;
                                ?>
                            </div>
                        </div>

                    </article>
                </div>
            </div>
        </div>

        <div style="background-color: #f1f1f1">
            <div class="custom-container py-5">
                <div class="row justify-content-center align-items-stretch">
                    <div class="col-12 py-5">
                        <h6 class="pb-5 text-dark text-center fs-3 fw-bolder">مطالب مرتبط</h6>
                        <div class="row gap-2 gap-lg-0">
                            <?php
                            // Get the current post ID
                            $current_post_id = get_the_ID();

                            // Get the current post categories
                            $current_post_categories = wp_get_post_categories($current_post_id);

                            // Query related posts
                            $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 4, // Adjust the number of related posts you want to display
                                'post__not_in' => array($current_post_id), // Exclude the current post
                                'category__in' => $current_post_categories, // Show posts from the same categories
                            );

                            $related_posts_query = new WP_Query($args);
                            if ($related_posts_query->have_posts()) : $i = 0;
                                /* Start the Loop */
                                while ($related_posts_query->have_posts()) :
                                    $related_posts_query->the_post(); ?>
                                    <div class="col-lg-3 col-12">
                                        <?php get_template_part('template-parts/blog-post'); ?>
                                    </div>
                                <?php endwhile;
                            endif;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endwhile;
wp_reset_query();
get_footer(); ?>
