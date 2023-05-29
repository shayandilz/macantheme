<?php global $post; ?>

<a href="<?php the_permalink(); ?>" class="card h-100  rounded-0 single-post-img bg-white border-0 text-bg-dark lazy">
    <div class="position-relative rounded-0 overflow-hidden">
        <img src="<?php echo get_the_post_thumbnail_url() ?>" class="card-img rounded-0 lazy" alt="<?php the_title(); ?>">
    </div>
    <h6 class="card-title text-dark fw-bold px-2 pt-5 pb-3 mb-0">
        <?php the_title(); ?>
    </h6>
</a>