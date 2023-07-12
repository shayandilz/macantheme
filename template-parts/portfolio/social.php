<?php
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en');

if (get_field('row_width') == 'col-lg-3') {
    $col_class = 'col-lg-3';
} elseif(get_field('row_width') == 'col-md-5') {
    $col_class = 'col-md-5';
}
?>
<div class="<?= $col_class; ?> py-5 text-center <?php echo $slugEN ? 'lang-en' : ''; ?>">
    <?php
    get_template_part('template-parts/portfolio/gallery');
    ?>

    <div class="row align-items-center justify-content-center py-3">
        <div class="col-lg-6 pb-3 pb-lg-0 social_border">
            <div class="text-white lh-2">
                <img width="90px" src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?= get_the_title(); ?>" title="<?= get_the_title(); ?>">
            </div>
        </div>
        <hr class="border-white border-1 w-25 opacity-100 d-lg-none" >
<!--        <div class="h-100 border-start border-1 border-w"></div>-->
        <div class="col-lg-6">
            <h1 class="fs-4 text-white">
                <?php the_title(); ?>
            </h1>
            <?php $category_detail = get_field('date'); ?>
            <span class="text-white">
                <?= $category_detail; ?>
            </span>
        </div>

    </div>

</div>