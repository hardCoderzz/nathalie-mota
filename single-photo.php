<?php

/**
 * Template Name: Single Photo
 * Template Post Type: photo
 */

?>

<?php
get_header();

?>

<?php get_template_part('template-parts/contact-popup/contact'); ?>

<section class="container">
    <div class="wrapper">
        <div class="photo-info-box">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
            ?>
                    <h1><?php the_title(); ?></h1>
                    <?php
                    $reference_values = get_field('reference');
                    if ($reference_values) {
                        $reference = $reference_values;
                        echo '<p class="post-ref">Référence : ' . $reference . '</p>';
                    }

                    $categories = wp_get_post_terms(get_the_ID(), 'ctg');
                    if (!empty($categories)) {
                        echo '<p>Catégorie : ';
                        $category_names = array();
                        foreach ($categories as $category) {
                            $category_names[] = $category->name;
                        }
                        echo implode(', ', $category_names);
                        echo '</p>';
                    }

                    $formats = wp_get_post_terms(get_the_ID(), 'format');
                    if (!empty($formats)) {
                        echo '<p>Format : ';
                        $format_names = array();
                        foreach ($formats as $format) {
                            $format_names[] = $format->name;
                        }
                        echo implode(', ', $format_names);
                        echo '</p>';
                    }

                    $type_values = get_field('type');
                    if ($type_values) {
                        echo '<p>Type : ' . $type_values . '</p>';
                    }
                    ?>
                    <p>Année : <?php echo get_the_date('Y'); ?></p>

        </div>
        <div class="image-post">
            <?php the_post_thumbnail(); ?>
        </div>
</section>
<div class="secondary-container">
    <div class="photo-contact-wrapper">
        <div class="contact-container">
            <p>Cette photo vous intéresse ?</p>
            <button class="contact-single-btn">Contact</button>
        </div>
    </div>
    <div class="arrow-container">
        <div class="arrows">
            <div class="arrows-wrapper">
                <div class="arrow-left">
                    <?php
                    $previous_post = get_previous_post();
                    $next_post = get_next_post();

                    if ($previous_post) {
                        $previous_post_link = get_permalink($previous_post);
                        echo '<a href="' . $previous_post_link . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="Arrow left"></a>';
                    }
                    ?>
                </div>
                <div class="arrow-right">
                    <?php

                    if ($next_post) {
                        $next_post_link = get_permalink($next_post);
                        echo '<a href="' . $next_post_link . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="Arrow right"></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="thumbnail-box">
                <?php
                    if ($previous_post) {
                        echo '<div class="previous-thumbnail">' . get_the_post_thumbnail($previous_post->ID, 'thumbnail') . '</div>';
                    }
                    if ($next_post) {
                        echo '<div class="next-thumbnail">' . get_the_post_thumbnail($next_post->ID, 'thumbnail') . '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>


<?php get_template_part('template-parts/content/related-posts'); ?>

<?php
                endwhile;
                wp_reset_postdata();
            endif;
?>



<?php get_footer(); ?>