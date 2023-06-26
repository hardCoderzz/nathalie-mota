<?php
function theme_enqueue_scripts() {
    wp_register_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('parent-style');
}


function nathalie_theme_supports(){
    add_theme_support('title-tag');
    add_theme_support('menus');
    register_nav_menu('header', 'En tête du menu');
    register_nav_menu('footer', 'Pied de page');
}

add_action('after_setup_theme', 'nathalie_theme_supports');
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

?>