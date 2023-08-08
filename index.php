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
$categories = get_terms(array(
    'taxonomy' => 'ctg',
    'hide_empty' => false,
));

$formats = get_terms(array(
    'taxonomy' => 'format',
    'hide_empty' => false,
));
?>

<section class="filter-section">
    <div class="filter-container">
        <div class="filters-wrapper">
            <div class="filter">
                <div class="category">
                    <h3>Catégorie</h3>
                    <img class="chevron-categories" src="<?php echo get_template_directory_uri() . '/assets/images/chevron-down.png' ?>" alt="Chevron bas" class="chevron-down">
                </div>
                <ul class="category-list">
                    <?php
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            echo '<li data-category="' . $category->slug . '">' . $category->name . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="filter">
                <div class="format">
                    <h3>Format</h3>
                    <img class="chevron-format" src="<?php echo get_template_directory_uri() . '/assets/images/chevron-down.png' ?>" alt="Chevron bas" class="chevron-down">
                </div>
                <ul class="format-list">
                    <?php
                    if (!empty($formats)) {
                        foreach ($formats as $format) {
                            echo '<li data-format="' . $format->slug . '">' . $format->name . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="sort-filter">
            <div class="sort-order">
                <h3>Trier</h3>
                <img class="chevron-sort" src="<?php echo get_template_directory_uri() . '/assets/images/chevron-down.png' ?>" alt="Chevron bas" class="chevron-down">
            </div>
            <ul class="sort-order-list">
                <li data-sort-order="desc">le + récent</li>
                <li data-sort-order="asc">le + ancien</li>
            </ul>

        </div>
    </div>

</section>

<?php

$photos = array(
    'post_type' => 'photo',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
);

$photos_query = new WP_Query($photos);
if ($photos_query->have_posts()) :
?>
    <section class="photo-list">
        <div class="photos-wrapper">
            <?php
            while ($photos_query->have_posts()) : $photos_query->the_post();
                // $categories = wp_get_post_terms(get_the_ID(), 'ctg');
            ?>
                <?php get_template_part('template-parts/content/photos'); ?>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <div class="btn__wrapper">
            <a href="#!" class="btn btn__primary" id="load-more">Charger plus</a>
        </div>
    </section>
    <?php
    ?>
<?php endif;
?>


<?php get_footer(); ?>