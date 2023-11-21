<?php
/** Template Name: Blog Page */
$url = $_SERVER["REQUEST_URI"];
$categories_before = array();
$categories_last = array();
$slugEN = strpos($url, 'en/');
get_header(); ?>
<script>
    const categoryId = parseInt(localStorage.getItem('categoryID'));
    document.addEventListener('DOMContentLoaded', function () {
        // Check if categoryID is not null and has a length
        if (categoryId && categoryId.toString().length > 0) {
            // Add 'active' class to the selected tab
            const selectedTab = document.getElementById(`${categoryId}`);
            selectedTab.classList.add('active');
            // Add 'active show' classes to the corresponding tab pane
            const tabPane = document.getElementsByName(`${categoryId}`)[0];
            tabPane.classList.add('active', 'show');
        } else {
            // If categoryID is false or has no length, activate the 'show_all' tab
            const showAllTab = document.getElementById('allCategory');
            showAllTab.classList.add('active');

            // Add 'active show' classes to the 'show_all' tab pane
            const showAllTabPane = document.getElementById('show_all');
            showAllTabPane.classList.add('active', 'show');
        }
    })
</script>


<div class="py-5 min-vh-100 <?php echo $slugEN ? 'lang-en' : ''; ?>">
    <h1 class="pt-5 text-center mb-0 text-danger fw-bold"><?= $slugEN ? get_the_title(13257) : get_the_title(9761); ?></h1>
    <?php
    $children = get_categories(array(
        'taxonomy' => 'category',
        'orderby' => 'name',
        'pad_counts' => false,
        'hierarchical' => 1,
        'hide_empty' => true
    )); ?>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <?php
            $categories_last = array();
            $categories_before = array();

            if ($children) {
                foreach ($children as $key => $subcat) {
                    if ($subcat->term_id == 1 || $subcat->term_id == 23) {
                        $categories_last[] = $subcat;
                    } else {
                        $categories_before[] = $subcat;
                    }
                }
            }
            ?>

            <nav id="myTab" class="category-tabs nav-fill nav justify-content-lg-center align-items-center bg-white z-1 overflow-x-scroll position-fixed flex-nowrap justify-content-start px-0">
                <a data-bs-toggle="pill" data-aos="zoom-in" id="allCategory" class="w-auto button-dark button px-2 py-3 px-lg-4" href="#show_all">
                    <?php echo $slugEN ? 'Show All' : ' همه مقالات'; ?>
                </a>

                <?php
                // Display categories before the last ones
                foreach ($categories_before as $key => $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true);
                    ?>

                    <a data-bs-toggle="pill" id="<?= $subcat->term_id;?>" data-aos="zoom-in" class="button-dark button w-auto px-2 py-3 px-lg-4" href="#<?= $subcat->slug; ?>">
                        <?= $subcat->name; ?>
                    </a>
                <?php } ?>

                <?php
                // Display categories with ID 1 and 23 as the last tabs
                foreach ($categories_last as $key => $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true); ?>
                    <a data-bs-toggle="pill" id="<?= $subcat->term_id;?>" data-aos="zoom-in" class="button-dark button px-2 py-3 px-lg-4" href="#<?= $subcat->slug; ?>">
                        <?= $subcat->name; ?>
                    </a>
                <?php } ?>

            </nav>
            <div class="category-content tab-content p-3 pt-5">
                <div class="tab-pane fade" id="show_all">
                    <div class="row w-100 g-2 mx-0">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => '-1',
                        );
                        $loop = new WP_Query($args);

                        if ($loop->have_posts()) {
                            while ($loop->have_posts()) : $loop->the_post(); ?>
                                <div class="col-lg-4 col-md-6">
                                    <?php get_template_part('template-parts/archive-blog-card'); ?>
                                </div>
                            <?php endwhile;
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <?php
                // Display categories with ID 1 and 23 as the last tabs
                foreach ($categories_last as $key => $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true); ?>
                 <div class="tab-pane fade" name="<?= $subcat->term_id;?>" id="<?= $subcat->slug; ?>">
                        <div class="row w-100 g-2 mx-0">
                            <?php
                            $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'posts_per_page' => '-1',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'term_id',
                                        'terms' => $subcat->term_taxonomy_id,
                                        'operator' => 'IN'
                                    )
                                )
                            );
                            $loop = new WP_Query($args);

                            if ($loop->have_posts()) {
                                while ($loop->have_posts()) : $loop->the_post(); ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php get_template_part('template-parts/archive-blog-card'); ?>
                                    </div>
                                <?php endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php }
                // Display categories before the last ones
                foreach ($categories_before as $key => $subcat) {
                    $thumbnail_id = get_term_meta($subcat->term_id, 'thumbnail_id', true); ?>
                <div class="tab-pane fade" name="<?= $subcat->term_id;?>" id="<?= $subcat->slug; ?>">
                        <div class="row w-100 g-2 mx-0">
                            <?php
                            $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'posts_per_page' => '-1',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'term_id',
                                        'terms' => $subcat->term_taxonomy_id,
                                        'operator' => 'IN'
                                    )
                                )
                            );
                            $loop = new WP_Query($args);

                            if ($loop->have_posts()) {
                                while ($loop->have_posts()) : $loop->the_post(); ?>
                                    <div class="col-lg-4 col-md-6">
                                        <?php get_template_part('template-parts/archive-blog-card'); ?>
                                    </div>
                                <?php endwhile;
                            }
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
<?php get_footer(); ?>
