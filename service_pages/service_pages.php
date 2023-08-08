<?php
/*
Plugin Name: Service Pages
Description: Service Pages
Version: 1.0
Author: Andriy
*/

function service_page_type() {
    $labels = array(
        'name'               => 'Service Page',
        'singular_name'      => 'Service Page',
        'menu_name'          => 'Service Pages',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Service Page',
        'edit_item'          => 'Edit Service Page',
        'new_item'           => 'New Service Page',
        'view_item'          => 'View Service Page',
        'search_items'       => 'Search Service Pages',
        'not_found'          => 'No service pages found',
        'not_found_in_trash' => 'No service pages found in Trash',
        'parent_item_colon'  => '',
        'all_items'          => 'All Custom Posts'
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'products'),
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-admin-post',
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('service_page', $args);
}
add_action('init', 'service_page_type');

function custom_template_plugin_function($template) {
    if (is_singular('service_page')) {
        $new_template = plugin_dir_path(__FILE__) . 'templates/service_pages_template.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'custom_template_plugin_function');

