<?php
/**
 * Kamino functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kamino
 */

if ( ! function_exists( 'kamino_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function kamino_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Kamino, use a find and replace
		 * to change 'kamino' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'kamino', KAMINO_TEMPLATE_URL . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'kamino' ),
			'social'  => esc_html__( 'Social Menu', 'kamino' )
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'kamino_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( 'assets/css/editor-style.css', kamino_fonts_url() ) );
	}
endif;

add_action( 'after_setup_theme', 'kamino_setup' );

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

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kamino_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kamino_content_width', 640 );
}

add_action( 'after_setup_theme', 'kamino_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kamino_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'kamino' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'kamino_widgets_init' );

if ( ! function_exists( 'kamino_fonts_url' ) ) :
	/**
	 * Register Google fonts for Nolan.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function kamino_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Source Sans Pro font: on or off', 'kamino' ) ) {
			$fonts[] = 'Source Sans Pro:400,300,600,700,400italic';
		}

		/*
		 * Translators: If there are characters in your language that are not supported
		 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
		 */
		if ( 'off' !== _x( 'on', 'Source Code Pro font: on or off', 'kamino' ) ) {
			$fonts[] = 'Source Code Pro:400,700';
		}

		/*
		 * Translators: To add an additional character subset specific to your language,
		 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'kamino' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' == $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;

/**
 * Enqueue scripts and styles.
 */
function kamino_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'kamino-fonts', kamino_fonts_url(), array(), null );

	// Load our main stylesheet.
	wp_enqueue_style( 'kamino-main', KAMINO_TEMPLATE_URL . '/assets/css/main.css', false, KAMINO_VERSION, null );

	// Load our main stylesheet if child theme.
	if ( is_child_theme() ) {
		wp_enqueue_style( 'kamino-child', KAMINO_URL . '/assets/css/main.css', false, KAMINO_VERSION, null );
	}

	wp_enqueue_script( 'kamino-modernizr', KAMINO_TEMPLATE_URL . '/assets/js/vendor/modernizr.js', array(), KAMINO_VERSION, false );
	wp_enqueue_script( 'kamino-scripts', KAMINO_TEMPLATE_URL . '/assets/js/scripts.js', array( 'jquery' ), KAMINO_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'kamino_scripts' );
