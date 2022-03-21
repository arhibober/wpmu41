<?php
/**
 * Blue River functions and definitions
 *
 * @package Blue River
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'blue_river_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function blue_river_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Blue River, use a find and replace
	 * to change 'blue-river' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'blue-river', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size ( 250, 250 );
	add_image_size( 'post-img', 999, 999 );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'blue-river' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'blue_river_custom_background_args', array(
		'default-color' => '17769B',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
}
endif; // blue_river_setup
add_action( 'after_setup_theme', 'blue_river_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function blue_river_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'blue-river' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'blue_river_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function blue_river_scripts() {
	wp_enqueue_style( 'blue-river-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'blue-river-open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600');
	
	wp_enqueue_style( 'blue-river-berkshire-swash', 'http://fonts.googleapis.com/css?family=Berkshire+Swash');

	wp_enqueue_script( 'blue-river-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'blue-river-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_script( 'blue-river-shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blue_river_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



  //  Ajax Login
  function ajax_login_init(){
    
	/* Подключаем скрипт для авторизации */
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    
	/* Локализуем параметры скрипта */
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      'redirecturl' => $_SERVER['REQUEST_URI'],
      'loadingmessage' => __('Переверяються дані, секундочку...')
    ));

    // Разрешаем запускать функцию ajax_login() пользователям без привелегий
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
  }

  // Выполняем авторизацию только если пользователь не вошел
  if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
  }

  function ajax_login(){

    // Первым делом проверяем параметр безопасности
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Получаем данные из полей формы и проверяем их
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
      echo json_encode(array('loggedin'=>false, 'message'=>__('Невірний логін або пароль!')));
    } else {
      echo json_encode(array('loggedin'=>true, 'message'=>__('Відмінно! Йде перенаправлення...')));
    }

    die();
  }
