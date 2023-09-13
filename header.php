<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="keywords" content="<?= get_bloginfo('name'); ?>">
    <meta name="author" content="<?= get_bloginfo('author'); ?>">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-001CYNWEH4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-001CYNWEH4');
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Navbar STart -->
<header class="justify-content-between d-flex">
    <?php
    if (is_singular('post') || is_home()) {
        get_template_part('template-parts/layout/header/blog');
    } else {
        get_template_part('template-parts/layout/header/index');
    }
    ?>
    <?php
    $domain = $_SERVER['HTTP_HOST'];
    $path = $_SERVER['REQUEST_URI'];

    if (!is_single() && $domain === 'macan.agency' && strpos($path, '/en') === 0) {
        // Load template part for domain.com/en
        get_template_part('template-parts/preload/en');
    } elseif (!is_single() && $domain === 'macan.agency') {
        get_template_part('template-parts/preload/fa');
    }



    ?>
</header>

<main
    <?php
    if (is_post_type_archive('portfolio') || is_tax('portfolio_categories')) { ?>
        style="background-color: <?= get_field('portfolio_page_background', 'option') ?>"
    <?php }
    if (is_singular('portfolio')) { ?>
        style="background-color: <?= get_field('background_color', get_the_ID()) ?>;position: relative"
    <?php }
    if (is_singular('services')) { ?>
        style="background-color: <?= get_field('services_color_background', get_the_ID()) ?>"
    <?php }
    if (is_page_template('contact.php')) { ?>
        style="background-color: <?= get_field('contact_single_background', 'option') ?>"
    <?php }
    if (is_page_template('work.php')) { ?>
        style="background-color: <?= get_field('work_single_background', 'option') ?>"
    <?php }
    if (is_home() || is_category()) { ?>
        style="background-color: <?= get_field('blog_single_background', 'option') ?>"
    <?php }
    if (is_search()) { ?>
        style="background-color: <?= get_field('search_single_background', 'option') ?>"
    <?php }
    ?>
>




