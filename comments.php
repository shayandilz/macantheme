<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package baloochy
 */
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, 'en/');
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div class="my-4">
    <?php if (get_comments_number()) { ?>
        <div class="mb-4">
            <p class="h2 normal-md-down fs-2 m-0"><?php echo $slugEN ? 'Comments' : 'نظرات شما'; ?></p>
        </div>
        <p class="fs-6 text-muted mb-4">
            <?php comments_number($slugEN ? 'Your Comments' : 'یک دیدگاه ثبت شد.', $slugEN ? '% Comment being Posted.' : '% دیدگاه ثبت شد.'); ?>
        </p>
    <?php } ?>
</div>

<?php if (have_comments()) : ?>
    <ul class="media-list list-unstyled mb-0 pe-0">
        <?php wp_list_comments('callback=okcsComments'); ?>
    </ul>
<?php endif; ?>

<?php get_template_part('template-parts/comment-form') ?>
