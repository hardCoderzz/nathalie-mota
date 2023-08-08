<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <?php wp_head() ?>
</head>

<body>
    <header class="nav-container">
        <nav class="nav-wrapper">
            <div class="logo">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png' ?>" alt="Logo">
            </div>
            <div class="navigation">
                <?php wp_nav_menu([
                    'theme_location' => 'header',
                    'container' => false,
                    'menu_class' => 'nav-menu',
                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="contact-btn">Contact</li></ul>'
                ])
                ?>
            </div>
            <button id="burger-btn" class="burger">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>
        </nav>
    </header>
    <div class="liens-mobile">
        <?php wp_nav_menu([
            'theme_location' => 'header',
            'container' => false,
            'menu_class' => 'mobile-menu',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li class="contact-btn">Contact</li></ul>'
        ])
        ?>
    </div>