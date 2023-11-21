<div>
<?php
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, '/en/');
?>
    <?php if (comments_open()) {
        $req = get_option('require_name_email') ?>
        <div class="my-4">
            <p class="h2 normal-md-down fs-2 m-0">
                <?php comment_form_title($slugEN ? 'Post a Comment' : 'افزودن نظر' ,  $slugEN ? 'Answer to s%' : 'پاسخ به %s'); ?>
            </p>
        </div>
        <form id="commentform" method="post" action="<?= get_option('siteurl') ?>/wp-comments-post.php">
            <div class="row gx-1 gy-4">
                <?php do_action('comment_form_before_fields'); ?>
                <?php if (!is_user_logged_in()) { ?>

                    <div class="col-md-6 col-12">
                        <div class="form-floating">
                            <input id="name" name="author" type="text" placeholder="<?php echo $slugEN ? 'Full Name' : 'نام و نام خانوادگی'; ?>"
                                   class="form-control rounded-0" required="">
                            <label class="ps-4"  for="name"><?php echo $slugEN ? 'Full Name' : 'نام و نام خانوادگی'; ?></label>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating">
                            <input id="email" type="text" placeholder="<?php echo $slugEN ? 'Email' : 'ایمیل'; ?>" name="email"
                                   class="form-control rounded-0" required="">
                            <label class="ps-4"  for="email"><?php echo $slugEN ? 'Email' : 'ایمیل'; ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                                        <textarea id="message" placeholder="<?php echo $slugEN ? 'Text...' : 'پیام...'; ?>" rows="10" name="comment"
                                                  class="form-control rounded-0" required=""></textarea>
                            <label class="ps-4"  for="message"><?php echo $slugEN ? 'Text...' : 'پیام...'; ?></label>
                        </div>
                    </div>

                <?php } else { ?>
                    <p class="h6 mb-0">
                        <?php echo $slugEN ? 'Posted By ' : 'ارسال دیدگاه به عنوان'; ?>
                        <span> <?= $GLOBALS['user_identity'] ?> </span>
                        <span class="mx-1">|</span>
                        <a class="link-primary small" href="<?php echo wp_logout_url(get_permalink()) ?>">
                            <?php echo $slugEN ? 'Logout ' : 'خروج'; ?>
                        </a>
                    </p>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea id="message"
                                      placeholder="<?php echo $slugEN ? 'Text...' : 'پیام...'; ?>"
                                      rows="5" name="comment"
                                      class="form-control rounded-0"
                                      required="">
                            </textarea>
                            <label class="ps-4" for="message">
                                <?php echo $slugEN ? 'Text...' : 'پیام...'; ?>
                            </label>
                        </div>
                    </div>

                <?php } ?>
                <?php do_action('comment_form_after_fields'); ?>
                <div class="mt-4 d-flex justify-content-end px-0">
                    <button type="submit" class="btn btn-danger d-flex align-items-center rounded-0 <?php echo $slugEN ? 'flex-row-reverse' : ''; ?>">
                        <?php echo $slugEN ? 'Submit' : 'ثبت نظر'; ?>
                        <i class="bi bi-arrow-left-circle-fill fs-4 ms-2"></i>
                    </button>
                </div>
                <div class="invisible d-block" >
                    <label for="honeypot">Leave this field empty</label>
                    <input type="text" name="honeypot" id="honeypot" tabindex="-1" autocomplete="off">
                </div>


                <?php comment_id_fields();
                add_action('comment-form', $post->id) ?>
            </div>
        </form>

    <?php } ?>
</div>