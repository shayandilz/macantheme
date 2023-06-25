<?php
get_header();
$portfolio = array(
    'post_type' => 'portfolio',
    'post_status' => 'publish',
    'posts_per_page' => '-1',
    'ignore_sticky_posts' => true
);
$loop_portfolio = new WP_Query($portfolio);
?>

    <section class="py-5 container-fluid min-vh-100 aos-remover">
        <ul class="nav nav-tabs border-bottom-0 justify-content-center gap-4 py-2 mt-5 mb-2"
            id="myTab"
            role="tablist">

            <?php
            $args_cat = array(
                'taxonomy' => 'portfolio_categories',
//            'hide_empty'=> false,
                'orderby' => 'name',
                'order' => 'ASC'
            );
            $cats = get_categories($args_cat);
            foreach ($cats as $key => $cat) {
                $term_ids[] = $cat->term_taxonomy_id;
            }
            // Add a new category object at the beginning for "Show All" option
            array_unshift($cats, (object)array('name' => 'مشاهده همه', 'term_taxonomy_id' => $term_ids));
            $s = 0;
            $i = 0;
            foreach ($cats as $key => $cat) { ?>
                <li class="nav-item" role="presentation">
                    <button class="filterPortfolio lazy text-white text-center position-relative d-inline-block px-4 py-2 nav-link <?php if ($i == 0) {$i = 1;echo 'active';} ?>"
                            id="cat-<?php echo $key ?>-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#cat-<?php echo $key ?>"
                            style="width: max-content"
                            type="button" role="tab"
                            aria-controls="cat-<?php echo $key ?>"
                            aria-selected="true">
                        <?php echo $cat->name; ?>
                    </button>
                </li>
                <?php $s++;
            }
            wp_reset_postdata() ?>
        </ul>

        <div class="tab-content row justify-content-center align-items-center" id="myTabContent" role="tablist">
            <?php
            $b = 0;
            foreach ($cats as $key => $cat) {
                ?>
                <div class="tab-pane col-lg-8 col-md-11 fade <?php if ($key == 0) {
                    echo 'show active';
                } ?>" id="cat-<?php echo $key; ?>" role="tabpanel"
                     aria-labelledby="cat-<?php echo $key; ?>-tab">
                    <div class="row g-2 grid" id="my-custom-post-type-container">
                        <?php
                        $args = array(
                            'post_type' => 'portfolio',
                            'orderby' => 'date',
                            'order' => 'ASC',
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'portfolio_categories',
                                    'field' => 'term_id',
                                    'terms' => $cat->term_taxonomy_id,
                                    'operator' => 'IN'
                                )
                            )
                        );
                        $loop = new WP_Query($args);
                        if ($loop->have_posts()) {
                            while ($loop->have_posts()) : $loop->the_post();
                                $b++;
                                $category_ids = get_the_terms(get_the_ID(), 'portfolio_categories');
                                if ($category_ids[0]->term_id == 18){ ?>
                                    <div class="col-lg-4 col-md-6 col-12 grid-item">
                                        <?php get_template_part('template-parts/website-hover-card'); ?>
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-lg-4 col-md-6 col-12 grid-item"">
                                        <?php get_template_part('template-parts/hover-card'); ?>
                                    </div>
                                <?php } ?>

                            <?php endwhile;
                        }
                        wp_reset_postdata() ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>

<?php get_footer();
