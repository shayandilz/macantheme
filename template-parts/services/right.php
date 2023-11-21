<?php
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, '/en/') !== false;
?>

<div class="col-lg-6 position-relative <?php echo $slugEN ? ' order-1 order-lg-2 ' : ' '; ?>">
    <div class="position-absolute start-0 w-100 bottom-0 d-none d-lg-block">
        <?php
        $slider = get_field('slider_field');
        echo do_shortcode('' . $slider); ?>
    </div>
    <div class="d-lg-none d-block">
        <?php
        $slider_mobile = get_field('slider_field_mobile');
        echo do_shortcode('' . $slider_mobile);
        ?>
    </div>
</div>
<div class="col-lg-6 row justify-content-center align-content-center mb-5 z-1 pt-4 pt-lg-0 z-2 <?php echo $slugEN ? 'order-2 order-lg-1 ' : ' '; ?>">
    <h1 class="text-center text-white fs-3"
        data-aos="fade-down"
        data-aos-delay="100">
        <?= get_the_title(); ?>
    </h1>
    <div class="text-white <?php echo $slugEN ? 'text-end' : 'text-start'; ?> lh-lg"
         data-aos="fade-down"
         data-aos-delay="300">
        <?php the_content(); ?>
    </div>
    <?php get_template_part('template-parts/services/icons'); ?>
</div>
