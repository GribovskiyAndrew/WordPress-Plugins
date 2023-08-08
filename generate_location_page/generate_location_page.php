<?php
/*
	Plugin Name: Generate location page
	Description: Generate location page
	Version: 1.0
	Author: Andriy
	*/

function generate_location_page()
{

    $current_page_id = get_the_ID();
    $child_pages = get_pages(array(
        'child_of' => $current_page_id,
        'sort_column' => 'menu_order',
    ));

    $all_tags = array();
    foreach ($child_pages as $child_page) {
        $tags = wp_get_post_tags($child_page->ID);
        foreach ($tags as $tag) {
            $all_tags[] = $tag;
        }
    }

    $all_tags = array_unique($all_tags, SORT_REGULAR);

    $output .= '<div class="table-of-contents">';
    $content .= '<div class="content-container">';
    $drop_down .= '<div>' . '<select onchange="scrollToSection(this.value)">' . '<option value="">Select an county</option>';

    foreach ($all_tags as $tag) {

        $heading_id = sanitize_title($tag->name);

        $content .= get_html_locations($tag->name, $heading_id);

        $drop_down .= '<option value="' . $heading_id . '">' . $tag->name . '</option>';

        $output .= '<button class="location-button"><a href="#' . $heading_id . '">' . $tag->name . '</a></button>';
    }

    $drop_down .= '</select>' . '</div>';
    $output .= '</div>';
    $content .= '</div>';

    if (wp_is_mobile()) {
        return  $drop_down . $content;
    } else {
        return  $output . $content;
    }
}

function get_html_locations($tag_name, $heading_id)
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

        $output .= '<div class="content-child" id="' . $heading_id . '">' . '<h2>' . $tag_name . '</h2>' . '<div>';

        while ($query->have_posts()) {
            $query->the_post();

            if ($current_page_id != get_the_ID()) {

                $page_title = get_the_title();
                $page_link = get_permalink();

                $output .= '<p><a href="' . $page_link . '">' . $page_title . '</a></p>';
            }
        }

        $output .= '</div>' . '</div>';

        wp_reset_postdata();
    }

    return $output;
}

add_shortcode('location_page', 'generate_location_page');

function my_plugin_styles()
{
    wp_enqueue_style('location_style', plugin_dir_url(__FILE__) . 'custom_style_location.css');
}

add_action('wp_enqueue_scripts', 'my_plugin_styles');

function your_plugin_enqueue_scripts()
{
    wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'custom_script.js');
}
add_action('wp_enqueue_scripts', 'your_plugin_enqueue_scripts');
