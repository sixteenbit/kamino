<?php
/**
 * Theme Options Customizer Implementation.
 *
 * Implement the Theme Customizer for Theme Settings.
 *
 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function kamino_register_customizer_settings( $wp_customize ) {

	/*
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}

	/**
	 * Site Logo setting.
	 *
	 * - Setting: Site Logo
	 * - Control: WP_Customize_Image_Control
	 * - Sanitization: image
	 *
	 * Uses the media manager to upload and select an image to be used as the site logo.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
	// $id
		'site_logo',
		// $args
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'kamino_sanitize_image'
		)
	);

	/**
	 * Center Branding setting.
	 *
	 * - Setting: Center Branding
	 * - Control: checkbox
	 * - Sanitization: checkbox
	 *
	 * Uses a checkbox to configure the display of the site branding in header.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
	// $id
		'center_branding',
		// $args
		array(
			'default'           => false,
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'kamino_sanitize_checkbox'
		)
	);

	/**
	 * Footer Copyright Text setting example.
	 *
	 * - Setting: Footer Copyright Text
	 * - Control: text
	 * - Sanitization: html
	 *
	 * Uses a text field to configure the user's copyright text displayed in the site footer.
	 *
	 * @uses $wp_customize->add_setting() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_setting/
	 * @link $wp_customize->add_setting() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_setting
	 */
	$wp_customize->add_setting(
	// $id
		'footer_copyright_text',
		// $args
		array(
			'default'           => sprintf( __( '&copy; %s. All rights reserved.', 'kamino' ), date( 'Y' ) . ' ' . esc_html( get_bloginfo( 'name' ) ) ),
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'kamino_sanitize_html'
		)
	);
}

// Settings API options initilization and validation.
add_action( 'customize_register', 'kamino_register_customizer_settings' );

/**
 * Theme Options Customizer Implementation
 *
 * Implement the Theme Customizer for Theme Settings.
 *
 * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function kamino_register_customizer_controls( $wp_customize ) {

	/**
	 * Failsafe is safe
	 */
	if ( ! isset( $wp_customize ) ) {
		return;
	}

	/**
	 * Image Upload control.
	 *
	 * Control: Image Upload
	 * Setting: Site Logo
	 * Sanitization: image
	 *
	 * Register "WP_Customize_Color_Control" to be used to configure the Link Color setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 *
	 * @uses WP_Customize_Image_Control() https://developer.wordpress.org/reference/classes/wp_customize_image_control/
	 * @link WP_Customize_Image_Control() https://codex.wordpress.org/Class_Reference/WP_Customize_Image_Control
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		// $wp_customize object
			$wp_customize,
			// $id
			'site_logo',
			// $args
			array(
				'settings'    => 'site_logo',
				'section'     => 'title_tagline',
				'label'       => __( 'Site Logo', 'kamino' ),
				'description' => __( 'Select the image to be used for the site logo.', 'kamino' ),
				'priority'    => '70'
			)
		)
	);

	/**
	 * Basic Checkbox control.
	 *
	 * - Control: Basic: Checkbox
	 * - Setting: Center Branding
	 * - Sanitization: checkbox
	 *
	 * Register the core "checkbox" control to be used to configure the Center Branding setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
	// $id
		'center_branding',
		// $args
		array(
			'settings' => 'center_branding',
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'label'    => __( 'Center Site Branding', 'kamino' ),
			'priority' => '80'
		)
	);

	/**
	 * Basic Text control.
	 *
	 * - Control: Basic: Text
	 * - Setting: Footer Copyright Text
	 * - Sanitization: html
	 *
	 * Register the core "text" control to be used to configure the Footer Copyright Text setting.
	 *
	 * @uses $wp_customize->add_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/add_control/
	 * @link $wp_customize->add_control() https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_control
	 */
	$wp_customize->add_control(
	// $id
		'footer_copyright_text',
		// $args
		array(
			'settings'    => 'footer_copyright_text',
			'section'     => 'title_tagline',
			'type'        => 'text',
			'label'       => __( 'Footer Copyright Text', 'kamino' ),
			'description' => __( 'Copyright or other text to be displayed in the site footer. HTML allowed.', 'kamino' ),
			'priority'    => '90'
		)
	);

}

// Settings API options initilization and validation.
add_action( 'customize_register', 'kamino_register_customizer_controls' );