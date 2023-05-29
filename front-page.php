<?php /* Template Name: Home */
/**
 * Front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package pandplus
 */
if (have_posts()) {
    the_post();
    get_header(); ?>

    <!-- Slider main container -->
    <div class="swiper swiper1">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide" data-hash="Slides">
                <?php
                //    <!--Hero -->
                get_template_part('template-parts/homepage/section1');
                ?>
            </div>
            <div class="swiper-slide" data-hash="Service">
                <?php
                //    <!--Services -->
                get_template_part('template-parts/homepage/section2');
                ?>
            </div>
            <div class="swiper-slide bg-body" data-hash="Portfolio">
                <?php
                //    <!--Services -->
                get_template_part('template-parts/homepage/section3');
                ?>
            </div>
            <div class="swiper-slide bg-body" data-hash="Blog">
                <?php
                //    <!--Services -->
                get_template_part('template-parts/homepage/section4');
                ?>
            </div>
            <div class="swiper-slide bg-body" data-hash="Clients">
                <?php
                //    <!--Services -->
                get_template_part('template-parts/homepage/section5');
                ?>
            </div>
        </div>
        <!-- If we need pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <?php
}
get_footer();