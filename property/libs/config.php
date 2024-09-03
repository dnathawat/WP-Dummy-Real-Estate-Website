<?php

$theme_data = wp_get_theme();

// Core
define('THEME_NAME', $theme_data->Name);
define('THEME_VERSION', $theme_data->Version);

define('THEME_URI', get_template_directory_uri());
define('THEME_DIR', get_template_directory());

define('THEME_FRAMEWORK_URI', THEME_URI . '/libs');
define('THEME_FRAMEWORK_DIR', THEME_DIR . '/libs');

define('THEME_CUSTOM_ASSETS_IMAGES', THEME_URI . '/assets/images');
define('THEME_CUSTOM_ASSETS_SCTIPT', THEME_URI . '/assets/js');
define('THEME_CUSTOM_ASSETS_STYLE', THEME_URI . '/assets/css');

if (!function_exists('fridaymasala_setup')):
    function fridaymasala_setup()
    {

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
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        //add_image_size('team_boat', 65, 65, true );
        //add_image_size('blog_post', 540, 365, true );
        add_image_size('blog_post_thumb', 330, 200, true);
        add_image_size('testimonial_thumb', 146, 146, true);


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
                'script',
                'style',
            )
        );


        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /*
         * Adds `async` and `defer` support for scripts registered or enqueued
         * by the theme.
         */
        // $loader = new Script_Loader();
        // add_filter( 'script_loader_tag', array( $loader, 'filter_script_loader_tag' ), 10, 2 );

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        /*add_theme_support( 'post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'status',
            'audio',
            'chat',
        ) );*/

        // Add support for responsive embedded content.
        add_theme_support('responsive-embeds');
    }
endif; // fridaymasala_setup
add_action('after_setup_theme', 'fridaymasala_setup');


/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function fridaymasala_menus()
{

    $locations = array(
        'primary' => __('Primary Menu', 'fridaymasala'),
        'footer' => __('Footer Menu', 'fridaymasala'),
    );

    register_nav_menus($locations);
}

add_action('init', 'fridaymasala_menus');


function add_custom_user_role()
{
    add_role(
        'dealer',
        'Dealer',
        array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => true,
            'publish_posts' => true,
            'upload_files' => true,
        )
    );
}
add_action('init', 'add_custom_user_role');

function restrict_wp_admin_access()
{
    // Check if the user is logged in
    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // If the user is not an administrator
        if (!in_array('administrator', (array) $user->roles)) {
            // Hide the admin bar for non-admin users


            // Redirect non-admin users to the My Account page
            wp_redirect(home_url('/my-account'));
            exit; // Ensure no further code is executed
        }

    }
}
add_action('admin_init', 'restrict_wp_admin_access');

function hide_wordpress_admin_bar($hide)
{
    if (!current_user_can('administrator')) {
        return false;
    }
    return $hide;
}
add_filter('show_admin_bar', 'hide_wordpress_admin_bar');


add_action('init', function () {
    register_post_type('property', [
        'label' => __('Property', 'txtdomain'),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail', 'type', 'custom-fields'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'property'],
        'labels' => [
            'singular_name' => __('property', 'txtdomain'),
            'add_new_item' => __('Add new property', 'txtdomain'),
            'new_item' => __('New property', 'txtdomain'),
            'view_item' => __('View property', 'txtdomain'),
            'not_found' => __('No propertys found', 'txtdomain'),
            'not_found_in_trash' => __('No propertys found in trash', 'txtdomain'),
            'all_items' => __('All propertys', 'txtdomain'),
            'insert_into_item' => __('Insert into property', 'txtdomain')
        ],
    ]);
});
add_action('init', function () {
    register_taxonomy('property_type', ['property'], [
        'label' => __('Types', 'txtdomain'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'property-type'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Type', 'txtdomain'),
            'all_items' => __('All Types', 'txtdomain'),
            'edit_item' => __('Edit Type', 'txtdomain'),
            'view_item' => __('View Type', 'txtdomain'),
            'update_item' => __('Update Type', 'txtdomain'),
            'add_new_item' => __('Add New Type', 'txtdomain'),
            'new_item_name' => __('New Type Name', 'txtdomain'),
            'search_items' => __('Search Types', 'txtdomain'),
            'popular_items' => __('Popular Types', 'txtdomain'),
            'separate_items_with_commas' => __('Separate Types with comma', 'txtdomain'),
            'choose_from_most_used' => __('Choose from most used Types', 'txtdomain'),
            'not_found' => __('No Types found', 'txtdomain'),
        ]
    ]);
});