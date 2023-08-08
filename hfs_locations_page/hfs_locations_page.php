<?php
/*
	Plugin Name: HFS Clinic Locations
	Description: HFS Clinic Locations
	Version: 1.0
	Author: Andriy
	*/

function generate_location_page()
{

    $subtitles = get_field('subdomain_item', 'option');

    $output .= '<div class="table-of-contents">';
    $content .= '<div class="content-container">';
    $drop_down .= '<div class="select-container">' . '<select onchange="scrollToSection(this.value)">' . '<option value="">Select a state</option>';

    $groupedArray = [];
    foreach ($subtitles as $item) {
        $subdomainState = $item['subdomain_stait'];
        $groupedArray[$subdomainState][] = $item;
    }

    foreach ($groupedArray as $state => $links) {

        $heading_id = sanitize_title($state);

        $output .= '<a  class="location-button" href="#' . $heading_id . '">' . $state . '</a>';

        $drop_down .= '<option value="' . $heading_id . '">' . $state . '</option>';

        $content .= '<div class="content-child" id="' . $heading_id . '">' . '<h2>' . $state . '</h2>' . '<div>';

        foreach ($links as $link) {
            $content .= '<a href="' . $link['subdomain_url'] . '">' . $link['subdomain_city'] . '</a>' . '<p> | </p>';
        }
      
        $content = substr($content, 0, -10);
        $content .= '</div>' . '</div>';
    }
  
    $drop_down .= '</select>' . '</div>';
    $content .= '</div>';
    $output .= '</div>';


    if (wp_is_mobile()) {
        return  $drop_down . $content;
    } else {
        return  $output . $content;
    }
}

add_shortcode('location_page', 'generate_location_page');

function my_plugin_style_hfs_locations()
{
    wp_enqueue_style('location_style', plugin_dir_url(__FILE__) . 'custom_style_hfs_locations.css');
}

add_action('wp_enqueue_scripts', 'my_plugin_style_hfs_locations');

function your_plugin_script_hfs_locations()
{
    wp_enqueue_script('custom_script_hfs_locations', plugin_dir_url(__FILE__) . 'custom_script_hfs_locations.js');
}
add_action('wp_enqueue_scripts', 'your_plugin_script_hfs_locations');
