<?php global $post; ?>

<a target="_blank" href="<?php the_permalink(); ?>" class="card h-100  rounded-0 single-post-img bg-white border-0 text-bg-dark lazy">
    <div class="position-relative rounded-0 overflow-hidden">
        <img src="<?php echo get_the_post_thumbnail_url() ?>" class="card-img rounded-0 lazy" alt="<?php the_title(); ?>">
    </div>
    <div class=" px-2">
        <h6 class="card-title text-dark fw-bolder py-3 mb-0 fs-6">
            <?php the_title(); ?>
        </h6>
        <p class="text-dark lh-lg" style="font-size: 15px;"><?php echo wp_trim_words(get_the_content() , 20); ?></p>
    </div>

</a>