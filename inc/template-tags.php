<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Kamino
 */

if ( ! function_exists( 'kamino_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function kamino_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'kamino' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'kamino' ),
			'<span class="author"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'kamino_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function kamino_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'kamino' ) );
			if ( $categories_list && kamino_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'kamino' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'kamino' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'kamino' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'kamino' ), esc_html__( '1 Comment', 'kamino' ), esc_html__( '% Comments', 'kamino' ) );
			echo '</span>';
		}
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function kamino_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'kamino_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'kamino_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so kamino_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so kamino_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in kamino_categorized_blog.
 */
function kamino_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'kamino_categories' );
}

add_action( 'edit_category', 'kamino_category_transient_flusher' );
add_action( 'save_post', 'kamino_category_transient_flusher' );

/**
 * Build Top Bar
 */
function kamino_navigation() {
	if ( has_nav_menu( 'primary' ) ) {
		echo wp_nav_menu( array(
			'menu_id'        => 'primary-menu',
			'theme_location' => 'primary',
			'menu_class'     => 'left',
			'walker'         => new kamino_topbar_walker(),
			'container'      => ''
		) );
	} else {
		echo '<ul class="left">';
		echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html( 'Add a menu', 'kamino' ) . '</a></li>';
		echo '</ul>';
	}
}

/**
 * Add Search to Top Bar
 */
function topbar_search() {
	echo '<ul class="right">' . "\n";
	echo '<li class="has-form">' . "\n";
	echo '' . get_search_form() . '' . "\n";
	echo '</li>' . "\n";
	echo '</ul>' . "\n";
}

if ( ! function_exists( 'kamino_get_link_url' ) ) :
	/**
	 * Return the post URL.
	 *
	 * Falls back to the post permalink if no URL is found in the post.
	 *
	 *
	 * @see get_url_in_content()
	 *
	 * @return string The Link format URL.
	 */
	function kamino_get_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
endif;
