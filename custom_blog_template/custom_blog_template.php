<?php
/*
	Plugin Name: Custom blog tamplate
	Description: Custom blog tamplate
	Version: 1.0
	Author: Andriy
	*/

function add_subtitle()
{
	if (is_single()) {

		$subtitle = get_field('post_subtitle_field');

		$subtitle = '<p class="subtitle">' . $subtitle . '</p>';

		echo $subtitle;
	}
}

add_action('asclepius_action_after_post_title', 'add_subtitle');

function add_heading_ids($content)
{

	if (is_single()) {

		$pattern = '/<h([2-3])(.*?)>(.*?)<\/h[2-3]>/i';
		$content = preg_replace_callback($pattern, function ($matches) {
			$heading_level = $matches[1];
			$heading_attributes = $matches[2];
			$heading_text = $matches[3];

			$heading_id = sanitize_title($heading_text);

			$heading_with_id = '<h' . $heading_level . $heading_attributes . ' id="' . $heading_id . '">' . $heading_text . '</h' . $heading_level . '>';

			return $heading_with_id;
		}, $content);
	}

	return $content;
}

add_filter('the_content', 'add_heading_ids');

function generate_table_of_content()
{
	$content = get_the_content();

	$headings = array();

	if (is_single()) {

		$pattern = '/<h([2])(.*?)>(.*?)<\/h[2]>/i';
		preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

		foreach ($matches as $match) {
			$heading_text = strip_tags($match[3]);

			$headings[] = array(
				'text' => $heading_text
			);
		}

		$output .= '<div class="blog-table-of-contents">';
		foreach ($headings as $heading) {

			$text = $heading['text'];

			$output .= '<a href="#' . sanitize_title($text) . '">' . $text . '</a>';
		}

		$output .= '</div>';
	}

	echo $output;
}

add_action('asclepius_action_after_post_title', 'generate_table_of_content');

function custom_blog_styles()
{
	wp_enqueue_style('custom_blog_style', plugin_dir_url(__FILE__) . 'custom_blog_template.css');
}

add_action('wp_enqueue_scripts', 'custom_blog_styles');
