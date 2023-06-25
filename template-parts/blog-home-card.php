<article class="position-relative overflow-hidden" title="<?php the_title(); ?>">
    <?php $category_detail = get_the_terms(get_the_ID(), 'category');
    foreach ($category_detail as $term) {
        $category_url = get_category_link($term->term_id);
        ?>
        <span data-category-id="<?= $term->term_id; ?>"  class="d-inline-block position-absolute bg-dark bg-opacity-50 top-0 end-0 z-top p-2 small text-white category-button">
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
                <p class="title text-center text-white position-absolute bottom-0 start-0 end-0 lazy">
                    <?php the_title(); ?>
                </p>
                <p class="excerpt position-absolute bottom-0 start-0 end-0 mb-4 fs-6 text-white lazy px-3">
                    <?= wp_trim_words(get_the_content(), 10); ?>
                </p>
            </div>
        </div>
    </a>
</article>