<?php
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}


/**
 * starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * 
 */

if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

if (!function_exists('starter_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function starter_setup()
    {
        /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on starter, use a find and replace
		 * to change 'starter' to the name of your theme in all the template files.
		 */
        load_theme_textdomain('starter', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
        add_theme_support('title-tag');

        /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'menu-1' => esc_html__('Primary', 'starter'),
                'lang-switch-menu' => esc_html__('Lang Switcher', 'starter'),
                'legal-links' => esc_html__('Legal Links', 'starter'),
            )
        );

        /*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'starter_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
endif;
add_action('after_setup_theme', 'starter_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starter_content_width()
{
    $GLOBALS['content_width'] = apply_filters('starter_content_width', 640);
}
add_action('after_setup_theme', 'starter_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function starter_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'starter'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'starter'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'starter_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function starter_scripts()
{
    wp_register_style('style', get_template_directory_uri() . '/dist/css/app.css', [], 1, 'all');
    wp_enqueue_style('style');

    wp_register_script('app', get_template_directory_uri() . '/dist/js/app.js', ['jquery'], 1, true);
    wp_enqueue_script('app');
}
add_action('wp_enqueue_scripts', 'starter_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

// Add Css to block editor
add_action('enqueue_block_editor_assets', 'ff_east_editor_styles');
function ff_east_editor_styles()
{
    wp_enqueue_style('ff_east_editor_styles', get_template_directory_uri() . '/dist/css/editor.css');
}
/**
 * Acf Blocks
 */

require get_template_directory() . '/inc/acf-blocks.php';

/**
 * Acf Options
 */

require get_template_directory() . '/inc/acf-options.php';


/**
 * Endpoints
 */

require get_template_directory() . '/inc/endpoints.php';

/**
 * Translation Strings
 */

require get_template_directory() . '/inc/translations.php';


/**
 * Newsletter Sign Up func
 */

require get_template_directory() . '/inc/newsletter.php';

/**
 * Core Block extensions
 */

require get_template_directory() . '/inc/block_extend.php';

/**
 * Crons
 */

require get_template_directory() . '/inc/crons.php';

/**
 * Job Applications Admin Page customizations
 */

require get_template_directory() . '/inc/job_applications_admin.php';


/**
 * Color Palette
 */

add_theme_support('editor-color-palette', array(
    array(
        'name' => __('Primary', 'ff-east'),
        'slug' => 'ff-primary',
        'color' => '#0D174A',
    ),
    array(
        'name' => __('Primary Gray', 'ff-east'),
        'slug' => 'ff-primary-gray',
        'color' => '#63666A',
    ),
    array(
        'name' => __('Accent01', 'ff-east'),
        'slug' => 'ff-accent-01',
        'color' => '#2D4E9C',
    ),
    array(
        'name' => __('Accent02', 'ff-east'),
        'slug' => 'ff-accent-02',
        'color' => '#64B5F6',
    ),
    array(
        'name' => __('Accent03', 'ff-east'),
        'slug' => 'ff-accent-03',
        'color' => '#4AA380',
    ),
    array(
        'name' => __('Accent04', 'ff-east'),
        'slug' => 'ff-accent-04',
        'color' => '#F6F4B6',
    ),

    array(
        'name' => __('Light Gray', 'ff-east'),
        'slug' => 'ff-light-gray',
        'color' => '#F8F7F7',
    ),
));

// Aligment full
add_theme_support('align-wide');

// Add extra padding options for group block
add_theme_support('custom-spacing');


// Disable file editor if not user id 1
if (get_current_user_id() !== 1) {
    define('DISALLOW_FILE_EDIT', true);
}


// Create taxonomies for post_type=job_applications based on the title of post_type=jobs.
function create_job_position_taxonomy()
{
    $labels = array(
        'name' => 'Job Positions',
        'singular_name' => 'Job Position',
        'search_items' => 'Search Job Positions',
        'all_items' => 'All Job Positions',
        'edit_item' => 'Edit Job Position',
        'update_item' => 'Update Job Position',
        'add_new_item' => 'Add New Job Position',
        'new_item_name' => 'New Job Position Name',
        'menu_name' => 'Job Positions',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job-position'),
    );
    register_taxonomy('job_position', array('job_applications'), $args);
}
add_action('init', 'create_job_position_taxonomy');


function create_job_position_taxonomy_and_term($post_id)
{
    $post_type = get_post_type($post_id);
    if ('job_applications' !== $post_type) {
        return;
    }
    $job_title = get_the_title($post_id);
    $term = term_exists($job_title, 'job_position');
    if (0 !== $term && null !== $term) {
        return;
    }
    wp_insert_term($job_title, 'job_position');
}
add_action('save_post', 'create_job_position_taxonomy_and_term');



// Add predefined sizes to the spacer block
add_filter('block_editor_settings', function ($settings) {
    $settings['spacing']['customPadding'] = true;
    $settings['spacing']['units'] = ['px', 'em', 'rem', 'vh', 'vw'];
    $settings['spacing']['customPadding'] = [
        [
            'name' => __('Small', 'ff-east'),
            'slug' => 'small',
            'value' => '20px',
        ],
        [
            'name' => __('Medium', 'ff-east'),
            'slug' => 'medium',
            'value' => '40px',
        ],
        [
            'name' => __('Large', 'ff-east'),
            'slug' => 'large',
            'value' => '60px',
        ],
        [
            'name' => __('X-Large', 'ff-east'),
            'slug' => 'x-large',
            'value' => '80px',
        ],
    ];
    return $settings;
});


function custom_excerpt_length($length)
{
    return 55; // Set the desired length of the excerpt here
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

function custom_excerpt_more($more)
{
    return '...'; // Set the desired ending symbol here
}
add_filter('excerpt_more', 'custom_excerpt_more');
