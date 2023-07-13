<?php get_header(); ?>

<?php get_template_part('template-parts/contact-popup/contact'); ?>

<section class="hero-section">
    <?php
    $random_photo_args = array(
        'post_type' => 'photo',
        'orderby' => 'rand',
        'posts_per_page' => 1,
    );
    $random_photo_query = new WP_Query($random_photo_args);
    if ($random_photo_query->have_posts()) :
        while ($random_photo_query->have_posts()) :  $random_photo_query->the_post();
    ?>
            <div class="random-image">
                <?php the_post_thumbnail(); ?>
                <h1 class="title">Photographe event</h1>
            </div>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</section>

<?php

$photo_args = array(
    'post_type' => 'photo',
    'posts_per_page' => -1
);

$photo_query = new WP_Query($photo_args);
if ($photo_query->have_posts()) :
?>

    <section class="photo-list">
        <div class="photos-wrapper">
            <?php
            while ($photo_query->have_posts()) : $photo_query->the_post();
                $categories = wp_get_post_terms(get_the_ID(), 'ctg');
            ?>
                <?php get_template_part('template-parts/content/photos'); ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </section>
<?php endif;
?>

<?php get_footer(); ?>