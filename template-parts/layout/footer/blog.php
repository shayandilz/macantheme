<div class="bg-danger">
    <div class="custom-container">
        <div class="row gy-5 gy-lg-0 text-center text-lg-start py-lg-5 pb-3">
            <div class="col-lg-3 col-6">
                <h5 class="fw-semibold mb-2 text-white">خدمات</h5>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footerLocationOne',
                    'menu_class' => 'navbar-nav gap-3 pe-0 text-white list-unstyled text-center text-lg-start fs-6 fw-light',
                    'container' => false,
                    'item_class' => 'nav-item',
                    'link_class' => '',
                    'depth' => 2,
                ));
                ?>
            </div>
            <div class="col-lg-3 col-6">
                <h5 class="fw-semibold mb-2 text-white">بلاگ</h5>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footerLocationTwo',
                    'menu_class' => 'navbar-nav gap-3 pe-0 text-white list-unstyled text-center text-lg-start fs-6 fw-light',
                    'container' => false,
                    'item_class' => 'nav-item',
                    'link_class' => '',
                    'depth' => 2,
                ));
                ?>
                <div class="col-12 d-lg-none pt-5">
                    <h5 class="fw-semibold mb-2 text-white">نمونه کار</h5>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footerLocationThree',
                        'menu_class' => 'navbar-nav gap-3 pe-0 text-white list-unstyled text-center text-lg-start fs-6 fw-light',
                        'container' => false,
                        'item_class' => 'nav-item',
                        'link_class' => '',
                        'depth' => 2,
                    ));
                    ?>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <h5 class="fw-semibold mb-2 text-white">نمونه کار</h5>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footerLocationThree',
                    'menu_class' => 'navbar-nav gap-3 pe-0 text-white list-unstyled text-center text-lg-start fs-6 fw-light',
                    'container' => false,
                    'item_class' => 'nav-item',
                    'link_class' => '',
                    'depth' => 2,
                ));
                ?>
            </div>
            <div class="col-lg-3 d-flex flex-column align-items-lg-start align-items-center gap-3">
                <h5 class="fw-semibold mb-0 text-white">آدرس</h5>
                <div class="d-flex flex-column gap-3">
                    <?php if (have_rows('address', 'option')): ?>
                        <?php while (have_rows('address', 'option')): the_row();
                            $addressText = get_sub_field('text');
                            $addressURL = get_sub_field('url');
                            ?>
                            <a class="lh-lg" href="<?php echo esc_url($addressURL) ?>">
                                <?= $addressText; ?>
                            </a>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php ?>
                <a class="text-center text-lg-start" href="tel:<?= get_field('phone_number', 'option'); ?>">
                    <?= get_field('phone_number', 'option'); ?>
                </a>
                <ul class="list-unstyled d-flex mb-0 social_icons gap-2">
                    <?php
                    if (have_rows('social_list', 'option')):
                        $first = true; // Variable to track the first <li> element
                        while (have_rows('social_list', 'option')) : the_row();
                            $icon_class = get_sub_field('icon_class');
                            $title = get_sub_field('social_title');
                            $url = get_sub_field('link'); ?>
                            <li class="<?php if (!$first) echo 'p-1'; ?>">
                                <a title="<?= $title; ?>" href="<?= esc_url($url); ?>">
                                    <span class="<?= $icon_class; ?> lh-base"></span>
                                </a>
                            </li>
                            <?php
                            $first = false;
                        endwhile;
                    endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>