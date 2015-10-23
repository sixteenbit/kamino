<?php

/**
 * Kamino functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package Kamino
 */

// Useful global constants
define( 'KAMINO_VERSION', '0.1.0' );
define( 'KAMINO_URL', get_stylesheet_directory_uri() );
define( 'KAMINO_TEMPLATE_URL', get_template_directory_uri() );
define( 'KAMINO_PATH', get_template_directory() . '/' );
define( 'KAMINO_INC', KAMINO_PATH . 'inc/' );

/**
 * Kamino only works in WordPress 4.2 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.2', '<' ) ) {
	require KAMINO_TEMPLATE_URL . '/inc/back-compat.php';
}

// Includes
require_once KAMINO_INC . 'core.php';
require_once KAMINO_INC . 'customizer.php';
require_once KAMINO_INC . 'sanitization.php';
require_once KAMINO_INC . 'custom-header.php';
require_once KAMINO_INC . 'template-tags.php';
require_once KAMINO_INC . 'extras.php';
require_once KAMINO_INC . 'jetpack.php';
require_once KAMINO_INC . 'walker.php';