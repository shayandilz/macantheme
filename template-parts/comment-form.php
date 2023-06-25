<div>

    <?php if (comments_open()) {
        $req = get_option('require_name_email') ?>
        <div class="mb-4">
            <p class="h2 normal-md-down fs-2 m-0">
                <?php comment_form_title('افزودن نظر', 'پاسخ به %s'); ?>
            </p>
        </div>
        <form id="commentform" method="post" action="<?= get_option('siteurl') ?>/wp-comments-post.php">
            <div class="row g-4">
                <?php do_action('comment_form_before_fields'); ?>
                <?php if (!is_user_logged_in()) { ?>

                    <div class="col-md-6 col-12">
                        <div class="form-floating">
                            <input id="name" name="author" type="text" placeholder="نام و نام خانوادگی"
                                   class="form-control" required="">
                            <label for="name">نام و نام خانوادگی </label>
                        </div>

                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating">
                            <input id="email" type="text" placeholder="ایمیل" name="email"
                                   class="form-control" required="">
                            <label for="email">شماره تماس</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                                        <textarea id="message" placeholder="پیام..." rows="5" name="comment"
                                                  class="form-control" required=""></textarea>
                            <label for="message">پیام...</label>
                        </div>
                    </div>

                <?php } else { ?>
                    <p class="h6 mb-0">
                        ارسال دیدگاه به عنوان
                        <span> <?= $GLOBALS['user_identity'] ?> </span>
                        <span class="mx-1">|</span>
                        <a class="link-primary small" href="<?php echo wp_logout_url(get_permalink()) ?>">
                            خروج
                        </a>
                    </p>
                    <div class="col-12">
                        <div class="form-floating">
                                        <textarea id="message" placeholder="پیام..." rows="5" name="comment"
                                                  class="form-control" required=""></textarea>
                            <label for="message">پیام...</label>
                        </div>
                    </div>

                <?php } ?>
                <?php do_action('comment_form_after_fields'); ?>
                <div class="mt-4">
                    <button type="submit" class="btn btn-gold ms-auto">ثبت نظر
                        <i class="bi bi-arrow-left-circle-fill fs-4 ms-1"></i>
                    </button>
                </div>

                <?php comment_id_fields();
                add_action('comment-form', $post->id) ?>
            </div>
        </form>

    <?php } ?>
</div>