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
    <div class="logo">
        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/logo.png'?>" alt="Logo">
    </div>    
    <nav class="navigation">
        <?php wp_nav_menu([
        'theme_location' => 'header',
        'container' => false,
        'menu_class' => 'nav-menu',
    ])
    ?>
    </nav>
</header>




