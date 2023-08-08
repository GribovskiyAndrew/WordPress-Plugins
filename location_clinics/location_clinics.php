<?php
/*
	Plugin Name: Location clinics
	Description: Other locations in this county
	Version: 1.0
	Author: Andriy
	*/

function location_clinics_after_content($content)
{
    $parent_page_id = wp_get_post_parent_id(get_the_ID());

    if ($parent_page_id == 25517) {

        $tags = get_the_tags();

        if (count($tags) == 1) {
            
            $location_tag = $tags[0];

            $content .= get_html_output_for_location($location_tag->slug);
        }
    }

    return $content;
}

add_filter('the_content', 'location_clinics_after_content');

function get_html_output_for_location($tag_name)
{

    $current_page_id = get_the_ID();
    $output = "";
    $args = array(
        'post_type' => 'page',
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'post_tag',
                'field'    => 'slug',
                'terms'    => $tag_name,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
		
		if($query->found_posts > 1){
		$output .= '<h2 class="location-title">Other locations in this county</h2>';
		}
		
		$output .=  '<div class="locations-conteiner">';
		
        while ($query->have_posts()) {
            $query->the_post();

            if ($current_page_id != get_the_ID()) {

                $page_title = get_the_title();
                $page_link = get_permalink();

                $output .= '<h3 class="location-child"><a href="' . $page_link . '">' . $page_title . '</a></h3>';
            }
        }

        wp_reset_postdata();
    } else {
        echo 'No pages found with the specified tag.';
    }

    $output .= '</div>';

    return $output;
}


function location_clinics_function($atts)
{
    $a = shortcode_atts(array(
        'tag' => 'default value'
    ), $atts);

    $tag_value = $a['tag'];

    return get_html_output_for_location($tag_value);
}

add_shortcode('location_clinics', 'location_clinics_function');

function my_plugin_enqueue_styles()
{
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('location_clinic_style', $plugin_url . 'custom_style.css');
}
add_action('wp_enqueue_scripts', 'my_plugin_enqueue_styles');
