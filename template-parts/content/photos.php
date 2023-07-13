<div id="related-post" class="related-post">
    <?php the_post_thumbnail(); ?>

    <div class="overlay">
        <?php
        $categories = wp_get_post_terms(get_the_ID(), 'ctg');
        if (!empty($categories)) {
            echo '<p class="category-name">';
            $category_names = array();
            foreach ($categories as $category) {
                $category_names[] = $category->name;
            }
            echo implode(', ', $category_names);
            echo '</p>';
        }
        ?>
        <a href="<?php echo esc_url(get_permalink()); ?>">
            <img src="<?php echo get_template_directory_uri(get_the_ID()) . '/assets/images/view-icon.png' ?>" alt="View icon" class="view-icon">
        </a>
        <img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png' ?>" alt="Fullscreen icon" class="fullscreen-icon">

        <p class="reference-number">
            <?php echo get_field('reference') ?>
        </p>
    </div>
</div>