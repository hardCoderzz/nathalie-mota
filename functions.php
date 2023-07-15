<?php
function theme_enqueue_scripts()
{

    wp_register_script('contact-script', get_template_directory_uri() . '/assets/js/contact.js', array(), '1.0', true);
    wp_enqueue_script('contact-script');
    wp_register_script('prev-next-script', get_template_directory_uri() . '/assets/js/prev-next-post.js', array(), '1.0', true);
    wp_enqueue_script('prev-next-script');
    wp_register_script('load-more-script', get_template_directory_uri() . '/assets/js/load-more.js', array(), '1.0', true);
    wp_enqueue_script('load-more-script');

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
    $paged = $_POST['paged'];
    // error_log('$paged: ' . $paged);
    $posts_per_page = 12;

    $args = array(
        'post_type'      => 'photo',
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'paged'          => $paged,
    );

    $ajax_post = new WP_Query($args);

    $response = '';

    if ($ajax_post->have_posts()) {
        while ($ajax_post->have_posts()) {
            $ajax_post->the_post();
            $response .= get_template_part('template-parts/content/photos');
        }
    } else {
        $response = '';
    }

    echo $response;
    die();
}

function register_ajax_photos_load_more()
{
    add_action('wp_ajax_photos_load_more', 'photos_load_more');
    add_action('wp_ajax_nopriv_photos_load_more', 'photos_load_more');
}
add_action('init', 'register_ajax_photos_load_more');





/**
 * Proper ob_end_flush() for all levels
 *
 * This replaces the WordPress `wp_ob_end_flush_all()` function
 * with a replacement that doesn't cause PHP notices.
 */
// remove_action('shutdown', 'wp_ob_end_flush_all', 1);
// add_action('shutdown', function () {
//     while (@ob_end_flush());
// });
