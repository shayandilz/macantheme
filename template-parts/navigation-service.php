<?php
// Inside the single-services.php or single.php template

// Get the current post ID
$current_post_id = get_the_ID();

// Get the previous post ID
$previous_post = get_previous_post();
$previous_post_id = $previous_post ? $previous_post->ID : '';

// Get the next post ID
$next_post = get_next_post();
$next_post_id = $next_post ? $next_post->ID : '';

// Output the previous and next post links
?>
<div class="position-absolute bottom-0 w-100 d-inline-flex <?php echo empty($previous_post) ? 'justify-content-end' : 'justify-content-between' ?>  pb-2 mb-4 z-top px-3">
    <?php if (!empty($previous_post_id)) :
        $prev_title = $previous_post->post_title;
        ?>
        <a href="<?php echo get_permalink($previous_post_id); ?>"
           class="previous-post d-inline-flex text-end gap-1 align-items-center justify-content-center lazy">
            <i class="bi bi-chevron-right d-flex justify-content-center align-items-center"></i>
            <h6 class="mb-0 lh-base pt-1"><?php echo esc_html($prev_title); ?></h6>
        </a>
    <?php endif;

    if (!empty($next_post_id)) :
        $next_title = $next_post->post_title;
        ?>
        <a href="<?php echo get_permalink($next_post_id); ?>"
           class="next-post d-inline-flex text-end gap-1 align-items-center justify-content-center lazy">
            <h6 class="mb-0 lh-base pt-1"><?php echo esc_html($next_title); ?></h6>
            <i class="bi bi-chevron-left d-flex justify-content-center align-items-center"></i>
        </a>
    <?php endif; ?>
</div>
