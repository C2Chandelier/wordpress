<?php
    function wpbootstrap_styles_scripts(){
        wp_enqueue_style('style', get_stylesheet_uri());
        wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('css_perso', './style.css');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jsAMoi', get_template_directory_uri() . '/theme.js', array(), 1 , true);
        wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), 1, true);
        wp_enqueue_script('boostrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery', 'popper'), 1, true);
    }
    add_action('wp_enqueue_scripts', 'wpbootstrap_styles_scripts');

function twentysixteen_widgets_init() {
        register_sidebar(
            array(
                'name'          => __( 'Sidebar', 'twentysixteen' ),
                'id'            => 'sidebar-1',
                'description'   => __('WPBeginner Widget', 'wpb_widget_domain'), 
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }
    add_action( 'widgets_init', 'twentysixteen_widgets_init' );

	add_theme_support( 'customize-selective-refresh-widgets' );