<?php /* Template Name: Contact */
get_header();
?>

    <section class="h-100 w-100 position-relative overflow-x-hidden overflow-y-hidden">
        <div class="container">
            <div class="row px-0 min-vh-100 justify-content-center align-items-center">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="position-absolute top-0 start-0 w-100 h-100 m-0 p-0">
                        <?php
                        if (has_post_thumbnail()) {
                            $thumbnail_url = get_the_post_thumbnail_url();
                            ?>
                            <img class="mh-100" src="<?php echo esc_url($thumbnail_url); ?>"
                                 alt="<?php the_title_attribute(); ?>">
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 d-flex flex-column align-items-start justify-content-start gap-3 border-start border-1 border-white py-3 z-top">
                    <?php if (have_rows('address', 'option')): ?>
                        <?php while (have_rows('address', 'option')): the_row();
                            $addressText = get_sub_field('text');
                            $addressURL = get_sub_field('url');
                            ?>
                            <a href="<?php echo esc_url($addressURL) ?>">
                                <?= $addressText; ?>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php ?>

                    <a class="" href="tel:<?= get_field('phone_number', 'option'); ?>">
                        <?= get_field('phone_number', 'option'); ?>
                    </a>
                    <ul class="list-unstyled d-flex align-items-center justify-content-center mb-0 social_icons gap-3">
                        <?php
                        if (have_rows('social_list', 'option')):
                            while (have_rows('social_list', 'option')) : the_row();
                                $icon_class = get_sub_field('icon_class');
                                $url = get_sub_field('link'); ?>
                                <li>
                                    <a title="<?= $icon_class; ?>" href="<?= esc_url($url); ?>">
                                        <span class="<?= $icon_class; ?> lh-base"></span>
                                    </a>
                                </li>
                            <?php endwhile;
                        endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </section>


<?php get_footer();

