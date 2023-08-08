<?php
/*
	Plugin Name: Custom CTA
	Description: Custom CTA
	Version: 1.0
	Author: Andriy
	*/

function generate_custom_cta($atts)
{
    $atts = shortcode_atts(
        array(
            'title' => '',
            'button_text' => '',
			'button_url' => '',
            'image' => '',
        ),
        $atts
    );
    
    $title = $atts['title'];
    $button_text = $atts['button_text'];
	$button_url = $atts['button_url'];
    $image = $atts['image'];

    $cta .= '<div class="wrap">
    <div class="cta">
    <div class="content_conteiner"><h4>' . $title . '</h4> <a href="' . $button_url . '">'. $button_text . '</a> </div>
    <img src="' . $image . '">
    </div>
    </div>';

    return  $cta;
}

add_shortcode('custom_cta', 'generate_custom_cta');

function my_cta_styles()
{
    wp_enqueue_style('cta_style', plugin_dir_url(__FILE__) . 'custom_cta_style.css');
}

add_action('wp_enqueue_scripts', 'my_cta_styles');
