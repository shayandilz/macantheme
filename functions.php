<?php
/**
 * Enqueue scripts and styles.
 */


require get_theme_file_path('/inc/search-route.php');
function theme_scripts()
{

    //    <!-- Icons -->
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/public/fonts/bootstrap/bootstrap-icons.css');
    wp_enqueue_style('font', get_template_directory_uri() . '/public/fonts/YekanBakh/fontface.css', array());
    wp_enqueue_style('font-en', get_template_directory_uri() . '/public/fonts/YekanBakh-en/fontface.css', array());
    wp_enqueue_style('social', get_template_directory_uri() . '/public/fonts/Macan-ic/fontface.css', array());
    wp_enqueue_style('custom', get_template_directory_uri() . '/public/custom/style.css', array());
    if (is_singular('services')) {
        wp_enqueue_style('services', get_template_directory_uri() . '/public/fonts/services-icons/fontface.css', array());
    }
// CSS files
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/public/css/style.css', array(),);

    $url = $_SERVER["REQUEST_URI"];
    $slugEN = strpos($url, 'en');
    if ($slugEN){
        wp_enqueue_style('ltr-style', get_stylesheet_directory_uri() . '/public/css/ltr.css', array(),);

    }

//    JS files
    wp_enqueue_script('main', get_template_directory_uri() . '/public/js/app.js', '1.0.0', true);

    if (is_front_page()) {
        wp_enqueue_script('homepage', get_template_directory_uri() . '/public/js/homepage/app.js', '1.0.0', true);
    }
    if (is_home()) {
        wp_enqueue_script('blog', get_template_directory_uri() . '/public/js/blog/app.js', '1.0.0', true);
    }
    if (is_singular('post')) {
        wp_enqueue_script('single-blog', get_template_directory_uri() . '/public/js/single-blog/app.js', '1.0.0', true);
    }
    if (is_singular('portfolio')){
        wp_enqueue_script('portfolio', get_template_directory_uri() . '/public/js/single-portfolio/app.js', '1.0.0', true);
    }
    global $template;

    if (basename($template) === 'landing.php'){
        wp_enqueue_script('landing', get_template_directory_uri() . '/public/js/landing.js', '1.0.0', true);
        wp_enqueue_style('landing', get_stylesheet_directory_uri() . '/public/css/landing.css');
    }
    $url = $_SERVER["REQUEST_URI"];
    $slugEN = strpos($url, 'en');
//  passing php values to javascript
    wp_localize_script('main', 'jsData', array(
        'root_url' => $slugEN !== false ? site_url('/en') : get_site_url(),
        'nonce' => wp_create_nonce('my-nonce')
    ));
    wp_localize_script('blog', 'jsData', array(
        'root_url' => $slugEN !== false ? site_url('/en') : get_site_url(),
        'nonce' => wp_create_nonce('my-nonce'),
    ));


}

function add_custom_honeypot_field() {
    if ( ! empty( $_POST['honeypot'] ) ) {
        // Honeypot field is filled, treat as spam
        exit;
    }
}
add_action( 'pre_comment_on_post', 'add_custom_honeypot_field' );


add_action('wp_enqueue_scripts', 'theme_scripts');

// Disable WordPress' automatic image scaling feature
add_filter('big_image_size_threshold', '__return_false');
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

// Add custom thumbnail image size
if (function_exists('add_image_size')) {
    add_image_size('150-thumbnail', 150, 150, true);
    add_image_size('300-thumbnail', 300, 300, true);
    add_image_size('600-thumbnail', 600, 600, true);
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function theme_setup()
{

    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
    register_nav_menu('headerMenuLocation', 'منوی اصلی');
    register_nav_menu('footerLocationOne', 'منوی اول فوتر');
    register_nav_menu('footerLocationTwo', 'منوی دوم فوتر');
    register_nav_menu('footerLocationThree', 'منوی سوم فوتر');
}

add_action('after_setup_theme', 'theme_setup');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/comments.php';

add_action('acf/render_field_settings/type=image', 'add_default_value_to_image_field');
function add_default_value_to_image_field($field)
{
    acf_render_field_setting($field, array(
        'label' => 'Default Image',
        'instructions' => 'Appears when creating a new post',
        'type' => 'image',
        'name' => 'default_value',
    ));
}

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{

    // Check function exists.
    if (function_exists('acf_add_options_page')) {

        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title' => __('Theme General Settings'),
            'menu_title' => __('Theme Settings'),
            'redirect' => false,
        ));

        // Add subpage
        $child = acf_add_options_page(array(
            'page_title' => __('Contact and Social'),
            'menu_title' => __('Contact and Social'),
            'parent_slug' => $parent['menu_slug'],
        ));
    }
}


function add_menu_link_class($classes, $item, $args)
{
    if (isset($args->link_class)) {
        $classes['class'] = $args->link_class;
    }

    return $classes;


}

add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

//populate gravity form
/**
 * Populate ACF select field options with Gravity Forms
 */
function acf_populate_gf_forms_ids($field)
{
    if (class_exists('GFFormsModel')) {
        $choices = [];

        foreach (\GFFormsModel::get_forms() as $form) {
            $choices[$form->id] = $form->title;
        }

        $field['choices'] = $choices;
    }

    return $field;
}

// add_filter('acf/load_field/name=gravity_choices', 'acf_populate_gf_forms_ids');


// helper function to find a menu item in an array of items
function wpd_get_menu_item($field, $object_id, $items)
{
    foreach ($items as $item) {
        if ($item->$field == $object_id) {
            return $item;
        }
    }

    return false;
}

function the_breadcrumb()
{
    global $post;
    echo '<ul class="breadcrumb my-0 py-4">';
    if (!is_home()) {
        echo '<li class="breadcrumb-item"><a class="text-decoration-none text-semi-light" href="';
        echo get_post_type_archive_link('post');
        echo '">';
        echo 'مقاله';
        echo '</a></li>';
        if (is_category() || is_single()) {
            echo '<li class="breadcrumb-item">';
            the_category(' </li><li class="breadcrumb-item"> ');
            if (is_single()) {
                echo '</li><li class="breadcrumb-item">';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $title = get_the_title();
                foreach ($anc as $ancestor) {
                    $output = '<li><a class="breadcrumb-item" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="' . $title . '"> ' . $title . '</strong>';
            } else {
                echo '<li><strong> ' . get_the_title() . '</strong></li>';
            }
        }
    }
    echo '</ul>';
}

/**
 * Disable the emoji's
 */
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}

add_action('init', 'disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 *
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        /** This filter is documented in wp-includes/formatting.php */
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}


add_filter('is_xml_preprocess_enabled', 'wpai_is_xml_preprocess_enabled', 10, 1);
function wpai_is_xml_preprocess_enabled($is_enabled)
{
    return false;
}


// table of contents
/**
 * Automatically add IDs to headings such as <h2></h2>
 */
function auto_id_headings($content)
{
    $content = preg_replace_callback('/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function ($matches) {
        if (!stripos($matches[0], 'id=')) {
            $matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title($matches[3]) . '">' . $matches[3] . $matches[4];
        }
        return $matches[0];
    }, $content);
    return $content;
}

add_filter('the_content', 'auto_id_headings');
function get_toc($content)
{
    // get headlines
    $headings = get_headings($content, 1, 6);

    // parse toc
    ob_start();
    echo "<div class='table-of-contents'>";
    echo "<!-- Table of contents by webdeasy.de -->";
    parse_toc($headings, 0, 0);
    echo "</div>";
    return ob_get_clean();
}

function parse_toc($headings, $index, $recursive_counter)
{
    // prevent errors

    if ($recursive_counter > 60 || !count($headings)) return;

    // get all needed elements
    $last_element = $index > 0 ? $headings[$index - 1] : NULL;
    $current_element = $headings[$index];
    $next_element = NULL;
    if ($index < count($headings) && isset($headings[$index + 1])) {
        $next_element = $headings[$index + 1];
    }

    // end recursive calls
    if ($current_element == NULL) return;

    // get all needed variables
    $tag = intval($headings[$index]["tag"]);
    $id = $headings[$index]["id"];
    $classes = $headings[$index]["classes"] ?? array();
    $name = $headings[$index]["name"];

    // element not in toc
    if (isset($current_element["classes"]) && $current_element["classes"] && in_array("nitoc", $current_element["classes"])) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
        return;
    }

    // parse toc begin or toc subpart begin
    if ($last_element == NULL) echo "<ul>";
    if ($last_element != NULL && $last_element["tag"] < $tag) {
        for ($i = 0; $i < $tag - $last_element["tag"]; $i++) {
            echo "<ul class='ms-2'>";
        }
    }

    // build li class
    $li_classes = " class='my-2'";
    if (isset($current_element["classes"]) && $current_element["classes"] && in_array("toc-bold", $current_element["classes"])) $li_classes = " class='bold'";

    // parse line begin
    echo "<li" . $li_classes . " data-id='" . $id . "'>";

    // only parse name, when li is not bold
    if (isset($current_element["classes"]) && $current_element["classes"] && in_array("toc-bold", $current_element["classes"])) {
        echo $name;
    } else {
        echo "<a class='text-decoration-none fs-6' href='#" . $id . "'>" . $name . "</a>";
    }
    if ($next_element && intval($next_element["tag"]) > $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }

    // parse line end
    echo "</li>";

    // parse next line
    if ($next_element && intval($next_element["tag"]) == $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }

    // parse toc end or toc subpart end
    if ($next_element == NULL || ($next_element && $next_element["tag"] < $tag)) {
        echo "</ul>";
        if ($next_element && $tag - intval($next_element["tag"]) >= 2) {
            echo "</li>";
            for ($i = 1; $i < $tag - intval($next_element["tag"]); $i++) {
                echo "</ul>";
            }
        }
    }

    // parse top subpart
    if ($next_element != NULL && $next_element["tag"] < $tag) {
        parse_toc($headings, $index + 1, $recursive_counter + 1);
    }
}

function get_headings($content, $from_tag = 1, $to_tag = 6)
{
    $headings = array();
    preg_match_all("/<h([" . $from_tag . "-" . $to_tag . "])([^<]*)>(.*)<\/h[" . $from_tag . "-" . $to_tag . "]>/", $content, $matches);

    for ($i = 0; $i < count($matches[1]); $i++) {
        $headings[$i]["tag"] = $matches[1][$i];
        // get id
        $att_string = $matches[2][$i];
        preg_match("/id=\"([^\"]*)\"/", $att_string, $id_matches);
        $headings[$i]["id"] = $id_matches[1];
        // get classes
        $att_string = $matches[2][$i];
        preg_match_all("/class=\"([^\"]*)\"/", $att_string, $class_matches);
        for ($j = 0; $j < count($class_matches[1]); $j++) {
            $headings[$i]["classes"] = explode(" ", $class_matches[1][$j]);
        }
        $headings[$i]["name"] = strip_tags($matches[3][$i]);
    }
    return $headings;
}

// TOC (from webdeasy.de)
function toc_shortcode()
{
    return get_toc(auto_id_headings(get_the_content()));
}

add_shortcode('TOC', 'toc_shortcode');
//estimated reading time

function reading_time()
{
    ob_start();
    the_content();
    $content = ob_get_clean();
    $readingtime = ceil(sizeof(explode(" ", utf8_decode($content))) / 200);

    return $readingtime;
}

function get_slider_revolution_slides()
{
    $choices = array();
    if (class_exists('RevSlider')) {
        $slider = new RevSlider();
        $arrSliders = $slider->getArrSliders();
        foreach ($arrSliders as $slider) {
            $slider_id = $slider->getID();
            $slider_name = $slider->getAlias();
            $slider = new RevSlider();
            $slider->initByID($slider_id);
            $shortcode = $slider->getShortcode();
            $slide_title = $slider->getTitle();
            $choices[$shortcode] = $slide_title;
        }
    }
    return $choices;
}


function acf_slider_revolution_slides($field)
{
    $field['choices'] = get_slider_revolution_slides();
    return $field;
}

add_filter('acf/load_field/name=slider_field', 'acf_slider_revolution_slides');


function load_posts()
{
    $page = $_POST['page'];
    $post_type = $_POST['portfolio'];

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 2,
        'paged' => $page
    );

    $query = new WP_Query($args);
    $b = 0;
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $b++ ?>
            <div class="col-lg-4 col-md-6 col-12 aos-animate aos" data-aos="zoom-in"
                 data-aos-delay="<?= $b; ?>00">
                <?php get_template_part('template-parts/hover-card.php'); ?>
            </div>
        <?php endwhile;
    endif;

    wp_reset_postdata();

    die();
}

add_action('wp_ajax_load_posts', 'load_posts');
add_action('wp_ajax_nopriv_load_posts', 'load_posts');

function add_font_mimes($mimes)
{
    $mimes['ttf'] = 'font/ttf';
    $mimes['otf'] = 'font/otf';
    $mimes['woff'] = 'font/woff';
    $mimes['woff2'] = 'font/woff2';
    $mimes['eot'] = 'application/vnd.ms-fontobject';
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'add_font_mimes');

add_action('rest_api_init', 'register_rest_images');
function register_rest_images()
{
    register_rest_field(array('post'),
        'fimg_url',
        array(
            'get_callback' => 'get_rest_featured_image',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

function get_rest_featured_image($object, $field_name, $request)
{
    if ($object['featured_media']) {
        $img = wp_get_attachment_image_src($object['featured_media'], 'app-thumb');
        return $img[0];
    }
    return false;
}

function searchfilter($query)
{

    if ($query->is_search && !is_admin()) {
        $query->set('post_type', array('post'));
    }

    return $query;
}

add_filter('pre_get_posts', 'searchfilter');

function custom_post_type_args( $args, $post_type ) {
    // Change 'project' to the slug of your custom post type
    if ( 'portfolio' === $post_type ) {
        // Set the with_front parameter to false
        $args['rewrite']['with_front'] = false;
    }
    if ( 'services' === $post_type ) {
        // Set the with_front parameter to false
        $args['rewrite']['with_front'] = false;
    }
    return $args;
}
add_filter( 'register_post_type_args', 'custom_post_type_args', 10, 2 );

function register_my_theme_with_wpml() {
    register_theme_directory( get_stylesheet_directory() );
}
add_action( 'after_setup_theme', 'register_my_theme_with_wpml' );






