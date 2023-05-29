<div class="col-lg-6 text-center d-flex flex-column align-items-start justify-content-center gap-4">
    <div>
        <img class="mb-5" src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?= get_the_title(); ?>" title="<?= get_the_title(); ?>">
        <div>
            <h1 class="fs-4 text-white">
                <?= the_field('subtitle_text'); ?>
            </h1>
            <span class="text-white">
                <?php the_field('date'); ?>
            </span>
            <div class="text-white lh-lg mt-5 px-3 px-lg-0">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>
<?php $count = count(get_field('gallery'));
// determine which class to use based on post index
if ($count <= 3) {
    $col_class = 'col-lg-3 py-5';
} else {
    $col_class = 'col-md-5';
}
?>
<div class="<?= $col_class; ?>">
    <?php
    get_template_part('template-parts/portfolio/gallery');
    ?>
</div>