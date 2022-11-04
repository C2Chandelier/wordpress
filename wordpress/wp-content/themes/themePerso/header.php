<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body> 
    <p><?php echo get_bloginfo(); ?></p>
    <p><?php echo get_bloginfo('description'); ?></p>
    <p class="test">Je suis le header</p>