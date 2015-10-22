<?php
/**
 * Kamino back compat functionality
 *
 * Prevents Kamino from running on WordPress versions prior to 4.2,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.2.
 *
 * @package Kamino
 */

/**
 * Prevent switching to Kamino on old versions of WordPress.
 *
 * Switches to the default theme.
 */
function kamino_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'kamino_upgrade_notice' );
}

add_action( 'after_switch_theme', 'kamino_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Kamino on WordPress versions prior to 4.2.
 */
function kamino_upgrade_notice() {
	$message = sprintf( esc_html__( 'Kamino requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'kamino' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.2.
 */
function kamino_customize() {
	wp_die( sprintf( esc_html__( 'Kamino requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'kamino' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}

add_action( 'load-customize.php', 'kamino_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.2.
 */
function kamino_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Kamino requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'kamino' ), $GLOBALS['wp_version'] ) );
	}
}

add_action( 'template_redirect', 'kamino_preview' );
