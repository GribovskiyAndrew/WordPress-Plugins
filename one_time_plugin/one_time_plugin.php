<?php
/*
	Plugin Name: One Time
	Description: One Time
	Version: 1.0
	Author: Andriy
	*/

function one_time_plugin($content)
{
    $parent_page_id = wp_get_post_parent_id(get_the_ID());

    if ($parent_page_id == 25517) {

        $tags = get_the_tags();

        if (count($tags) == 1) {

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
            libxml_use_internal_errors(false);

            $xpath = new DOMXPath($dom);
            $elements = $xpath->query("//a[span/span[contains(text(), 'Get in touch')]]");

            $elements[0]->setAttribute('href', 'https://califoriahrtclinic.com/contact/');

            $spans = $xpath->query("//span[contains(text(), '0 800 555 44 33')]");

            $spans[0]->nodeValue = "(213) 592-2595";

            return $dom->saveHTML();

            // $post_data = array(
            //     'ID'           => get_the_ID(),
            //     'post_content' => $dom->saveHTML(),
            // );

            // wp_update_post($post_data);
        }
    }

    return $content;
}

add_filter('the_content', 'one_time_plugin');



function one_time_plugin_activate()
{
    $args = array(
        'child_of' => 25517,
    );
    $child_pages = get_pages($args);

    foreach ($child_pages as $child_page) {

        $tags = wp_get_post_tags($child_page->ID);

        if (count($tags) == 1) {

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML(mb_convert_encoding($child_page->post_content, 'HTML-ENTITIES', 'UTF-8'));
            libxml_use_internal_errors(false);

            $xpath = new DOMXPath($dom);
            $elements = $xpath->query("//a[span/span[contains(text(), 'Get in touch')]]");

            $elements[0]->setAttribute('href', 'https://califoriahrtclinic.com/contact/');

            $spans = $xpath->query("//span[contains(text(), '0 800 555 44 33')]");

            $spans[0]->nodeValue = "(213) 592-2595";

            //return $dom->saveHTML();

            $post_data = array(
                'ID'           => get_the_ID(),
                'post_content' => $dom->saveHTML(),
            );

            wp_update_post($post_data);
        }
    }
}

register_activation_hook(__FILE__, 'one_time_plugin_activate');
