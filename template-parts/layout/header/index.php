<div class="position-custom position-absolute z-top w-100 text-center py-2">
    <a class="navbar-brand"
       data-aos="zoom-in-down"
       data-aos-delay="150"
       data-aos-disable
       href="<?php echo esc_url(get_home_url()) ?>">
        <?php
        $logo = get_field('site_logo', 'option');
        ?>
        <img class="lazy"
             height="auto"
             width="150"
             src="<?= $logo['url'] ?>"
             alt="<?= get_bloginfo('name'); ?>">
    </a>
</div>

<div class="menu-toggle position-fixed d-block" data-bs-toggle="modal" data-bs-target="#headerModal">
    <a class="d-none" href="#">menu</a>
    <div class="lines-button x d-inline-flex align-items-center justify-content-center lazy text-center p-0 m-0">
        <span class="lines bg-white d-inline-block p-0 m-0 position-relative"></span>
    </div>
</div>

<!-- Modal -->
<div class="modal fade overflow-y-hidden" id="headerModal" tabindex="-1" aria-labelledby="headerModalLabel"
     aria-hidden="true">
    <div class="menu-toggle-close position-absolute d-block z-top" data-bs-dismiss="modal" aria-label="Close">
        <div class="lines-button-close x d-inline-flex align-items-center justify-content-center lazy text-center p-0 m-0">
            <span class="lines-close d-inline-block p-0 m-0 position-relative"></span>
        </div>
    </div>

    <nav class="modal-dialog modal-dialog-centered bg-transparent modal-xl menu d-flex justify-content-start flex-column">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'headerMenuLocation',
            'menu_class' => 'navbar-nav pe-0 text-white list-unstyled text-center fs-3 w-100 mb-0',
            'container' => false,
            'menu_id' => 'navbarTogglerMenu',
            'item_class' => 'nav-item',
            'link_class' => 'nav-link',
            'depth' => 2,
        ));
        ?>
        <div class="social_icons position-absolute bottom-0">
            <div>
                <ul class="list-unstyled d-flex align-items-center justify-content-center mb-0">
                    <?php
                    if (have_rows('social_list', 'option')):
                        $first = true; // Variable to track the first <li> element
                        while (have_rows('social_list', 'option')) : the_row();
                            $icon_class = get_sub_field('icon_class');
                            $url = get_sub_field('link'); ?>
                            <li class="<?php if (!$first) echo 'p-1'; ?>">
                                <a title="<?= $icon_class; ?>" href="<?= esc_url($url); ?>">
                                    <span class="<?= $icon_class; ?>"></span>
                                </a>
                            </li>
                            <?php
                            $first = false;
                        endwhile;
                    endif; ?>
                </ul>
            </div>
            <div>
                <a class="" href="tel:<?= get_field('phone_number', 'option'); ?>">
                    <?= get_field('phone_number', 'option'); ?>
                    <i class="bi bi-telephone-fill"></i></a>
            </div>
        </div>
    </nav>

</div>

<button class="bg-transparent border-0 btn position-absolute top-0 end-0 pt-3 pe-3"
        type="button"
        aria-labelledby="search"
        aria-label="Search"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasTop"
        aria-controls="offcanvasTop"
        style="z-index: 1000">
    <i class="bi bi-search text-white fs-4"></i>
</button>
