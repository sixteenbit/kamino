<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kamino
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kamino' ); ?></a>

	<div class="contain-to-grid fixed">
		<nav id="site-navigation" class="main-navigation top-bar" data-topbar role="navigation">
			<ul class="title-area">
				<li class="name"></li>
				<li class="toggle-topbar toggle-icon">
					<a href="#"><span><?php echo esc_html( 'Menu' , 'kamino' ); ?></span></a>
				</li>
			</ul><!-- .title-area -->

			<section class="top-bar-section">
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<?php
					wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_id'        => 'social-menu',
							'menu_class'     => 'social-navigation right',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
							'container'      => '',
							'depth'          => '1'
						)
					); ?>
				<?php endif; ?>

				<?php topbar_search(); ?>

				<?php kamino_navigation(); ?>
			</section><!-- .top-bar-section -->
		</nav><!-- #site-navigation -->
	</div>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="site-branding">
				<hgroup>
					<?php if( is_front_page() || is_archive() || 'video' == get_post_format() || 'image' == get_post_format() || '' == get_the_title() ) { ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php } else { ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php } // end if ?>
					<p class="site-description"><?php bloginfo( 'description' ); ?></p>
				</hgroup>
			</div><!-- .site-branding -->
		</div><!-- .container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
