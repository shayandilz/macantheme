<article class="position-relative overflow-hidden" title="<?php the_title(); ?>">
    <?php $category_detail = get_the_terms(get_the_ID(), 'category');
    foreach ($category_detail as $term) {
        $category_url = get_category_link($term->term_id);
        ?>
        <span data-category-id="<?= $term->term_id; ?>" class="d-inline-block position-absolute top-0 end-0 z-top p-2 small text-white category-button"
           style="background-color: rgba(0, 0, 0, .5) !important">
            <?= $term->name; ?>

        </span>

    <?php } ?>
    <a href="<?php echo get_permalink(); ?>">
        <div class="ratio ratio-16x9">
            <img src="<?php echo get_the_post_thumbnail_url() ?>"
                 class="object-fit"
                 alt="<?php the_title(); ?>">
        </div>
        <div class="position-absolute bottom-0 start-0 h-100 w-100 d-flex justify-content-center align-items-end ">
            <div class="textBlog h-100 w-100 text-center lazy">
                <h6 class="text-center text-white position-absolute bottom-0 start-0 end-0 lazy">
                    <?php the_title(); ?>
                </h6>
                <p class="position-absolute bottom-0 start-0 end-0 mb-4 fs-6 text-white lazy">
                    <?= wp_trim_words(get_the_content(), 10); ?>
                </p>
            </div>
        </div>
    </a>
</article>