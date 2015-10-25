<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kamino
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php edit_post_link( __( 'Edit', 'kamino' ), '<span class="edit-link">', '</span>' ); ?>

		<div class="entry-content">

			<?php if ( is_single() ) :
				the_title( sprintf( '<h1 class="entry-title"><a href="%s">', esc_url( kamino_get_link_url() ) ), '</a></h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( kamino_get_link_url() ) ), '</a></h2>' );
			endif; ?>

			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kamino' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
	</header><!-- .entry-header -->

	<footer class="entry-footer">
		<?php kamino_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
