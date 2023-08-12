<?php
function theme_enqueue_scripts()
{
    wp_enqueue_script('jquery');

    wp_register_script('mobile-burger-script', get_template_directory_uri() . '/assets/js/mobile-burger.js', array(), '1.0', true);
    wp_enqueue_script('mobile-burger-script');
    wp_register_script('contact-script', get_template_directory_uri() . '/assets/js/contact.js', array(), '1.0', true);
    wp_enqueue_script('contact-script');
    wp_register_script('prev-next-script', get_template_directory_uri() . '/assets/js/prev-next-post.js', array(), '1.0', true);
    wp_enqueue_script('prev-next-script');
    wp_register_script('load-more-script', get_template_directory_uri() . '/assets/js/load-more.js', array('jquery'), filemtime(get_stylesheet_directory() . '/assets/js/load-more.js'), true);
    wp_enqueue_script('load-more-script');
    wp_register_script('dropdown-script', get_template_directory_uri() . '/assets/js/dropdown-filter.js', array(), '1.0', true);
    wp_enqueue_script('dropdown-script');
    wp_register_script('lightbox-script', get_template_directory_uri() . '/assets/js/lightbox.js', array(), '1.0', true);
    wp_enqueue_script('lightbox-script');


    wp_register_style('filters-style', get_template_directory_uri() . '/assets/css/filters.css');
    wp_enqueue_style('filters-style');
    wp_register_style('mobile-menu-style', get_template_directory_uri() . '/assets/css/mobile-menu.css');
    wp_enqueue_style('mobile-menu-style');
    wp_register_style('lightbox-style', get_template_directory_uri() . '/assets/css/lightbox.css');
    wp_enqueue_style('lightbox-style');
    wp_register_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('parent-style');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


function nathalie_theme_supports()
{
    add_theme_support('title-tag');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    register_nav_menu('header', 'En tête du menu');
    register_nav_menu('footer', 'Pied de page');
}
add_action('after_setup_theme', 'nathalie_theme_supports');


function photos_load_more()
{
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $sortOrder = isset($_POST['sortOrder']) ? sanitize_text_field($_POST['sortOrder']) : 'DESC';
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 12;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => $sortOrder,
        'paged'          => $paged,
    );

    if ($category) {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            'taxonomy' => 'ctg',
            'field'    => 'slug',
            'terms'    => $category,
        );
    }

    if ($format) {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format,
        );
    }

    $ajax_post = new WP_Query($args);
    $output = '';
    if ($ajax_post->have_posts()) {
        ob_start();
        while ($ajax_post->have_posts()) : $ajax_post->the_post();
            get_template_part('template-parts/content/photos');
        endwhile;
        $output = ob_get_contents();
        ob_end_clean();
    }

    $result = [
        // 'max' => $ajax_post->max_num_pages,
        'html' => $output,
        'total_posts' => $ajax_post->found_posts,
    ];

    echo json_encode($result);
    die();
}
add_action('wp_ajax_photos_load_more', 'photos_load_more');
add_action('wp_ajax_nopriv_photos_load_more', 'photos_load_more');


function filter_posts()
{
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 12;
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $order = isset($_POST['sortOrder']) && in_array($_POST['sortOrder'], ['asc', 'desc']) ? sanitize_text_field($_POST['sortOrder']) : 'DESC';
    $args['order'] = $order;


    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => $order,
        'paged'          => $paged,
        'tax_query'      => array('relation' => 'AND'),
    );

    if (isset($_POST['category']) && !empty($_POST['category'])) {
        $category_slug = sanitize_text_field($_POST['category']);
        $args['tax_query'][] = array(
            'taxonomy' => 'ctg',
            'field'    => 'slug',
            'terms'    => $category_slug,
        );
    }

    if (isset($_POST['format']) && !empty($_POST['format'])) {
        $format_slug = sanitize_text_field($_POST['format']);
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'slug',
            'terms'    => $format_slug,
        );
    }

    if (isset($_POST['sortOrder']) && !empty($_POST['sortOrder'])) {
        $order = sanitize_text_field($_POST['sortOrder']);
        $args['order'] = $order;
    }



    $ajax_filters = new WP_Query($args);
    $response = '';

    if ($ajax_filters->have_posts()) {
        while ($ajax_filters->have_posts()) {
            $ajax_filters->the_post();
            ob_start();
            get_template_part('template-parts/content/photos');
            $response .= ob_get_clean();
        }
    }

    $result = [
        'html' => $response,
    ];

    echo json_encode($result);
    die();
}
add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');



/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
remove_action('shutdown', 'wp_ob_end_flush_all', 1);
add_action('shutdown', function () {
    while (@ob_end_flush());
});
