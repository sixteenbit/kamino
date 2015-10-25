<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Kamino
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function kamino_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}

add_filter( 'body_class', 'kamino_body_classes' );

if ( 'video' == get_post_format( get_the_ID() ) ) {
	function kamino_embed_oembed_html( $html, $url, $attr, $post_id ) {
		return '<div class="flex-video widescreen">' . $html . '</div>';
	}

	add_filter( 'embed_oembed_html', 'kamino_embed_oembed_html', 99, 4 );
}