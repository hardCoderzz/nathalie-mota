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
                    <?php get_template_part('template-parts/content/photos') ?>
                <?php
                endwhile;
                ?>
            </div>

        </section>
        <div class="all-pics">
            <a href="<?php echo home_url(); ?>">
                <button>Toutes les photos</button>
            </a>

        </div>

<?php
        wp_reset_postdata();
    endif;
}
?>