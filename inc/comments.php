<?php

if (!function_exists('okcsComments')) {
    function okcsComments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; ?>
        <div class="comment-box pt-4 hstack border-bottom border-info align-items-start"
             id="comment-<?= comment_ID() ?>">
            <div class="d-md-block d-none">
                <i class="bi bi-person-circle display-6 text-opacity-75"></i>
            </div>
            <div class="ps-md-4 col text-start row justify-content-end">
                <h6 class="fw-normal mb-0">
                    <?= $GLOBALS['user_identity'] ?>
                    <span class="mx-2">
                          <svg width="5" height="5" viewBox="0 0 10 10" fill="none"
                               xmlns="http://www.w3.org/2000/svg">
                               <rect width="10" height="10" rx="5" fill="#BD9D3B"/>
                          </svg>
                    </span>
                    <?= comment_date() ?>
                </h6>
                <?php if (!$comment->comment_approved) { ?>
                    <div class="alert alert-gold mt-4 mb-0">دیدگاه شما در انتظار بررسی است.</div>
                <?php } ?>
                <div class="fs-6 py-2"><?php sanitize_text_field(comment_text()) ?></div>
                <div class="btn btn-simple text-gold fs-5 col-2 rounded-0 border border-danger border-opacity-25">
                    <?php get_template_part('template-parts/svg/undo') ?>
                    <?php comment_reply_link(array_merge($args, array(
                        'reply_text' => '<span>پاسخ</span>',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth']
                    ))); ?>
                </div>
            </div>
        </div>
    <?php }
}

if (!function_exists('custom_comment_reply_link')) {
    function custom_comment_reply_link($class)
    {
        return str_replace('comment-reply-link', 'text-muted  stretched-link', $class);
    }

    add_action('comment_reply_link', 'custom_comment_reply_link');
}