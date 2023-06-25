<?php
$post_id = get_the_ID();

// Get the URL of the featured image
$image_url = get_the_post_thumbnail_url($post_id);

// Get the image metadata
$image_metadata = wp_get_attachment_metadata(get_post_thumbnail_id($post_id));

// Get the width and height from the metadata
$image_width = $image_metadata['width'];
$image_height = $image_metadata['height'];
// Calculate the ratio
$ratio = $image_width / $image_height;

// Use the ratio for custom bootstrap ratio
$custom_ratio = round($ratio, 2);
$custom_ratio_factor = 1.1; // Adjust this factor to increase the size

// Calculate the custom ratio with the factor
$custom_ratio_with_factor = $custom_ratio * $custom_ratio_factor;

?>

<a href="<?php echo get_permalink(); ?>"
   class="d-inline-block m-0 p-0 overflow-hidden position-relative direction-aware-hover ratio" style="--bs-aspect-ratio: <?php echo $custom_ratio_with_factor * 100; ?>%;">
    <div class="direction-aware-hover__left bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__right bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__top bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="direction-aware-hover__bottom bottom-0 start-0 end-0 top-0 p-0 position-absolute z-1"></div>
    <div class="website-hover-card h-100 w-100 " >
        <div class="imgBX position-absolute object-fit-cover w-100 h-100 img-fluid" style="background: url('<?php echo get_the_post_thumbnail_url() ?>');"></div>
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