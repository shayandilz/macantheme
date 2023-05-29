<?php
$taxonomy = 'portfolio_categories'; // change to your custom taxonomy name
$term_id = get_queried_object_id();
$previous_post = get_adjacent_post(true, '', true, $taxonomy);
$next_post = get_adjacent_post(true, '', false, $taxonomy);
?>
<div class="position-absolute bottom-0 w-100 d-inline-flex <?php echo empty($previous_post) ? 'justify-content-end' : 'justify-content-between' ?>  pb-2 mb-4"  >
    <?php
    if (!empty($previous_post)) :
        $prev_title = $previous_post->post_title;
        $prev_link = get_permalink($previous_post->ID);
        if (has_term('', $taxonomy, $previous_post)) : ?>
            <a href="<?php echo esc_url($prev_link); ?>"
               class="previous-post d-inline-flex text-end gap-3 align-items-center justify-content-center">
                <i class="bi bi-chevron-right d-flex justify-content-center align-items-center"></i>
                <h6 class="mb-0 lh-base pt-1 fade-in-navigation"><?php echo esc_html($prev_title); ?></h6>
            </a>
        <?php endif;
    endif;


    if (is_singular('portfolio')) { ?>
        <a href="<?php echo get_post_type_archive_link('portfolio'); ?>"
           class="text-white btn position-absolute start-50 translate-middle-x bottom-0">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </a>
    <?php }
    if (!empty($next_post)) :
        $next_title = $next_post->post_title;
        $next_link = get_permalink($next_post->ID);
        if (has_term('', $taxonomy, $next_post)) : ?>
            <a href="<?php echo esc_url($next_link); ?>"
               class="next-post d-inline-flex text-end gap-3 align-items-center justify-content-center">
                <h6 class="mb-0 lh-base pt-1 fade-in-navigation"><?php echo esc_html($next_title); ?></h6>
                <i class="bi bi-chevron-left d-flex justify-content-center align-items-center"></i>
            </a>
        <?php endif;
    endif;


    ?>
</div>
