
<a href="<?php echo get_permalink(); ?>"
   class="d-inline-block m-0 p-0 overflow-hidden position-relative h-100 w-100 direction-aware-hover">
    <div class="direction-aware-hover__left bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__right bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__top bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__bottom bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="position-relative website-hover-card h-100 w-100 ratio-16x9 ratio">
        <div class="imgBX position-absolute w-100 h-100 object-fit-cover" style="background: url('<?php echo get_the_post_thumbnail_url() ?>');"></div>
    </div>
    <div class="direction-aware-hover__content position-absolute start-0 end-0 p-0 end-0 w-100 h-100 d-flex justify-content-center align-items-center flex-column">
        <h4 class="text-center fs-5">
            <?php the_title(); ?>
        </h4>
        <span>
             <?php
             $category_detail = get_the_terms(get_the_ID(), 'portfolio_categories');
             foreach ($category_detail as $term) {
                 echo $term->name;
             } ?>
        </span>
    </div>
</a>