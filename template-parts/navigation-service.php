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

$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, '/en/') !== false;

if ($slugEN){
    //    first Item in Farsi
    if (empty($previous_post) && !empty($next_post)){
        $navigationStyle = 'flex-row-reverse justify-content-start';
        $flexDirectionPrev = 'flex-row-reverse';
        $chevronPrev = 'right';
    }
    elseif (!empty($previous_post) && empty($next_post)){
//        last Item in Farsi
        $navigationStyle = 'flex-row-reverse justify-content-end';
        $flexDirectionNext = 'flex-row';
        $chevronNext = 'left';
    }else{
        $navigationStyle = 'flex-row justify-content-between';
        $flexDirectionNext = 'flex-row';
        $flexDirectionPrev = 'flex-row-reverse';
        $chevronNext = 'left';
        $chevronPrev = 'right';
    }
}else{
//    first Item in Farsi
    if (empty($previous_post) && !empty($next_post)){
        $navigationStyle = 'flex-row justify-content-end';
        $flexDirectionPrev = 'flex-row-reverse';
        $chevronPrev = 'left';
    }
    elseif (!empty($previous_post) && empty($next_post)){
//        last Item in Farsi
        $navigationStyle = 'flex-row justify-content-start';
        $flexDirectionNext = 'flex-row';
        $chevronNext = 'right';
    }else{
        $navigationStyle = 'flex-row justify-content-between';
        $flexDirectionNext = 'flex-row';
        $flexDirectionPrev = 'flex-row-reverse';
        $chevronNext = 'right';
        $chevronPrev = 'left';
    }
}

?>
<div class="position-absolute bottom-0 w-100 d-inline-flex pb-2 mb-4 z-top px-3 <?= $navigationStyle; ?>">
    <?php if (!empty($previous_post_id)) :
        $prev_title = $previous_post->post_title;
        ?>
        <a href="<?php echo get_permalink($previous_post_id); ?>"
           class="previous-post d-inline-flex text-end gap-1 align-items-center justify-content-center <?= $flexDirectionNext; ?>">
            <i class="bi bi-chevron-<?= $chevronNext; ?> d-flex justify-content-center align-items-center"></i>
            <h6 class="mb-0 lh-base pt-1"><?php echo esc_html($prev_title); ?></h6>
        </a>
    <?php endif;

    if (!empty($next_post_id)) :
        $next_title = $next_post->post_title;
        ?>
        <a href="<?php echo get_permalink($next_post_id); ?>"
           class="next-post d-inline-flex text-end gap-1 align-items-center justify-content-center <?= $flexDirectionPrev; ?>">
            <i class="bi bi-chevron-<?= $chevronPrev; ?> d-flex justify-content-center align-items-center"></i>
            <h6 class="mb-0 lh-base pt-1"><?php echo esc_html($next_title); ?></h6>

        </a>
    <?php endif; ?>
</div>
