<?php
/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since standbygolf 1.0
 */
function standbygolf_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'standbygolf'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'standbygolf'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));


}
add_action('widgets_init', 'standbygolf_widgets_init');