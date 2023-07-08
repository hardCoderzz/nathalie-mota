<?php

/**
 * Template Name: Single Photo
 * Template Post Type: photo
 */

 ?>

<?php
get_header();
?>

<section class="container">
    <div class="wrapper">
        <div class="photo-info-box">
            <?php
            $args = array(
                'post_type' => 'photo',
                'posts_per_page' => 1
            );

            $single_post_query = new WP_Query($args);

            if ($single_post_query->have_posts()) :
                while ($single_post_query->have_posts()) : $single_post_query->the_post();
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
                    <div class="separator"></div>

                    <?php ?>
             
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
        
        <div class="arrows-wrapper">
            <div class="thumbnail-box">
                <?php
                $previous_post = get_previous_post();
                $next_post = get_next_post();

                if ($previous_post) {
                    echo get_the_post_thumbnail($previous_post->ID, 'thumbnail', array('class' => 'previous-thumbnail'));
                } elseif ($next_post) {
                    echo get_the_post_thumbnail($next_post->ID, 'thumbnail', array('class' => 'next-thumbnail'));
                } else {
                    echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
                }
                ?>
            </div>
            <div class="arrows">
                <div class="arrow-wrapper">
                    <div class="arrow-left">
                    <?php
                        $previous_post = get_previous_post();
                        var_dump($previous_post);
                        if ($previous_post) {
                            $previous_post_link = get_permalink($previous_post);
                            echo '<a href="' . $previous_post_link . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-left.png" alt="Arrow left"></a>';
                        }
                        ?>
                    </div>
                    <div class="arrow-right">
                        <?php
                        $next_post = get_next_post();
                        if ($next_post) {
                            $next_post_link = get_permalink($next_post);
                            echo '<a href="' . $next_post_link . '"><img src="' . get_template_directory_uri() . '/assets/images/arrow-right.png" alt="Arrow right"></a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php
$current_post_id = get_the_ID();

$categories = wp_get_post_terms($current_post_id, 'ctg');
if (!empty($categories)) {
    $category = $categories[0];

    $related_posts_args = array(
        'post_type' => 'photo',
        'posts_per_page' => 2,
        'tax_query' => array(
            array(
                'taxonomy' => 'ctg',
                'field' => 'term_id',
                'terms' => $category->term_id
            )
        ),
        'post__not_in' => array($current_post_id)
    );

$related_posts_query = new WP_Query($related_posts_args);

if ($related_posts_query->have_posts()) :
    ?>
    <section class="related-posts">
        <h2>Vous aimerez aussi</h2>
        <div class="related-posts-wrapper">
            <?php
            while ($related_posts_query->have_posts()) : $related_posts_query->the_post();
                ?>
                <div class="related-post">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php
            endwhile;
            ?>
        </div>
    </section>
<?php
    wp_reset_postdata();
endif;
}
?>
            <?php 
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>


<?php get_footer(); ?>
