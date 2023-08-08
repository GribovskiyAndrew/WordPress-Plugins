<?php
/*
	Plugin Name: Microdata Plugin
	Description: Microdata Plugin
	Version: 1.0
	Author: Andriy
	*/

function insert_post_how_to($content)
{
    if (is_singular('post')) {

        $post_content = get_the_content();

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHTML($post_content);

        $xpath = new DOMXPath($dom);

        $h2Elements = $xpath->query('//h2[contains(text(), "How to")]');

        $microdata = array();

        foreach ($h2Elements as $h2) {

            $microdata_element = array(
                '@context' => 'https://schema.org',
                '@type' => 'HowTo',
                'name' => $h2->nodeValue,
            );

            array_push($microdata, $microdata_element);
        }

        $microdata_json = json_encode($microdata);

        $content = '<script type="application/ld+json">' . $microdata_json . '</script>' . $content;
    }

    return $content;
}

add_filter('the_content', 'insert_post_how_to');
