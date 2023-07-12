<?php
$url = $_SERVER["REQUEST_URI"];
$slugEN = strpos($url, '/en/') !== false;
?>

<div class="bg-danger w-100 py-2 position-fixed lazy blog-menu z-top d-none d-lg-block">
    <div class="custom-container">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'headerMenuLocation',
                'menu_class' => 'navbar-nav pe-0 list-unstyled text-center fs-6 flex-row gap-5 ' . ( $slugEN ? 'header-en' : ''),
                'container' => false,
                'menu_id' => 'navbarMenu',
                'item_class' => 'nav-item',
                'link_class' => 'nav-link hover-text'. ($slugEN ? ' text-lg-end ' : 'text-lg-start'),
                'depth' => 2,
            ));
            ?>
            <div class=" z-top text-center py-2">
                <a class="navbar-brand" href="<?php echo esc_url(get_home_url()) ?>">
                    <?php
                    $logo = get_field('site_logo', 'option');
                    ?>
                    <img class="lazy" width="170" src="<?= $logo['url'] ?>" alt="<?= get_bloginfo('name'); ?>">
                </a>
            </div>
        </div>
    </div>
</div>
<div class="d-block d-lg-none">
    <?php get_template_part('template-parts/layout/header/index'); ?>
</div>
