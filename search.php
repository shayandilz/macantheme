<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package baloochy
 */
get_header();

$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en');
?>

    <section class="container py-5 min-vh-100">
        <div class="row g-2">
            <h4 class="py-4 text-white">
                <?php printf(esc_html__($slugEN ? 'Search Result for %s :' : ' نتایج جستجو: %s ', 'macan'), get_search_query()); ?>
            </h4>
            <?php if (have_posts()) {
            ?>
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
                        if ($prev_posts_link = get_previous_posts_link(__($slugEN ? 'Previous' : 'قبلی'))) :
                            echo '<li class="prev-list-item page-item">';
                            echo $prev_posts_link;
                            echo '</li>';
                        endif;
                        echo '<li class="page-item text-white">';
                        echo join('</li><li class="page-item text-white">', $links);
                        echo '</li>';

                        // get_next_posts_link will return a string or void if no link is set.
                        if ($next_posts_link = get_next_posts_link(__($slugEN ? 'Next' : 'بعدی'))) :
                            echo '<li class="next-list-item page-item">';
                            echo $next_posts_link;
                            echo '</li>';
                        endif;
                        echo '</ul>';
                        ?>
                    </nav>

                <?php endif;
                wp_reset_postdata();
                }else{ ?>
                    <div class="row px-0 justify-content-center align-items-center min-vh-50">
                        <div class="col-lg-8 d-flex flex-column justify-content-center text-center text-white">
                            <h4>
                                <?php echo $slugEN ? 'No Results' : 'متاسفانه نتیجه مورد نظر شما یافت نشد !'; ?>
                            </h4>
                            <p>
                                <?php echo $slugEN ? 'Use Search Field Below' : 'از طریق باکس زیر آن را جست‌وجو کنید :'; ?>

                            </p>
                            <form class="searchform w-100" role="search" method="get" action="https://macan.agency/">
                                <label for="search" class="screen-reader-text">Search:</label>
                                <input type="text"
                                       class="field searchform-s w-100 p-2"
                                       name="s"
                                       value=""
                                       placeholder="<?php echo $slugEN ? 'Type in ...' : 'عبارت مورد نظرتان را تایپ و دکمه&zwnj;ی اینتر را فشار دهید ...'; ?>">
                                <input type="submit" class="assistive-text searchsubmit d-none" value="Go!">
                                <a href="#go" class="submit"></a>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div><!-- #main -->
    </section>

<?php
get_footer();
