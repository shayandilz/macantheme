<div class="col-lg-6 g-2 row px-5 flex-row-reverse justify-content-center align-content-center mb-5 z-1 order-2 order-lg-1 pt-4 pt-lg-0">
    <h1 class="text-center text-white fs-3"
        data-aos="fade-down"
        data-aos-delay="100">
        <?= get_the_title(); ?>
    </h1>
    <div class="text-white text-start lh-lg"
         data-aos="fade-down"
         data-aos-delay="300">
        <?php the_content(); ?>
    </div>
    <?php get_template_part('template-parts/services/icons'); ?>
</div>
<div class="col-lg-6 position-relative order-1 order-lg-2">
    <div class="d-none d-lg-block position-absolute bottom-0 end-0 w-100">
        <?php
        $slider = get_field('slider_field');
        echo do_shortcode('' . $slider); ?>
    </div>
    <div class="d-lg-none d-block">
        <?php
        $slider_mobile = get_field('slider_field_mobile');
        echo do_shortcode('' . $slider_mobile); ?>
    </div>
</div>
