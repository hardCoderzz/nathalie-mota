    <?php wp_nav_menu([
        'theme_location' => 'footer',
        'container' => false,
        'menu_class' => 'footer-menu',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="copyright">Tous droits réservés</li></ul>'
    ])
    
    ?>
    <?php wp_footer() ?>

</body>
</html>