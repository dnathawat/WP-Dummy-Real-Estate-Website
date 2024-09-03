<?php

/**
 * Register and Enqueue Styles.
 */
function standbygolf_register_styles()
{

    $theme_version = wp_get_theme()->get('Version');



    wp_enqueue_style('standbygolf-style', get_stylesheet_uri(), array(), $theme_version);
    wp_style_add_data('standbygolf-style', 'rtl', 'replace');

    wp_enqueue_style('standbygolf-font-awesom', get_template_directory_uri() . '/css/font-awesome.css', null, $theme_version);
    wp_enqueue_style('standbygolf-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', null, $theme_version);
    wp_enqueue_style('standbygolf-slick', get_template_directory_uri() . '/css/slick.css', null, $theme_version);
    wp_enqueue_style('standbygolf-nouislider', get_template_directory_uri() . '/css/nouislider.css', null, $theme_version);

    wp_enqueue_style('standbygolf-jquery-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', null, $theme_version);

    wp_enqueue_style('standbygolf-default-theme', get_template_directory_uri() . '/css/theme-color/default-theme.css', null, $theme_version);

    wp_enqueue_style('standbygolf-style1', get_template_directory_uri() . '/css/style.css', null, $theme_version);



}

add_action('wp_enqueue_scripts', 'standbygolf_register_styles');

/**
 * Register and Enqueue Scripts.
 */
function standbygolf_register_scripts()
{
    global $wp_query;
    $theme_version = wp_get_theme()->get('Version');

    if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('standbygolf-bootstrap', get_theme_file_uri('/js/bootstrap.js'), array('jquery'), $theme_version, true);






}

add_action('wp_enqueue_scripts', 'standbygolf_register_scripts');



function enqueue_custom_search_script()
{
    wp_enqueue_script('custom-search', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
    wp_localize_script('custom-search', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_search_script');


function custom_search_function()
{
    $search_term = isset($_POST['search_term']) ? sanitize_text_field($_POST['search_term']) : '';
    $search_taxonomy = isset($_POST['search_taxonomy']) ? sanitize_text_field($_POST['search_taxonomy']) : '';

    $args = array(
        'post_type' => 'property',
        's' => $search_term,
        'posts_per_page' => -1,
    );

    if (!empty($search_taxonomy)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $search_taxonomy,

            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $terms = get_the_terms($post_id, 'property_type');
            ?>
            <div class="col-md-4">
                <article class="aa-properties-item">
                    <a href="#" class="aa-properties-item-img">
                        <?php $post_img = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
                        <?php if ($post_img) { ?> <img src="<?php echo $post_img; ?>" alt="img">
                        <?php } else { ?>
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/item/1.jpg" alt="img">
                        <?php } ?>
                    </a>
                    <div class="aa-tag for-sale">
                        <?php
                        $term_names = array();
                        foreach ($terms as $term) {
                            $term_names[] = esc_html($term->name);
                        }
                        echo implode(', ', $term_names);
                        ?>
                    </div>
                    <div class="aa-properties-item-content">

                        <div class="aa-properties-about">
                            <h3><a href=" #"><?php the_title(); ?> </a></h3>

                        </div>
                        <div class="aa-properties-detial">
                            <span class="aa-price">
                                <?php $prices = get_post_meta(get_the_ID(), 'post_price', true);
                                if ($prices) { ?>
                                    $<?php echo $prices;
                                } ?>
                            </span>
                            <a href="#" class="aa-secondary-btn">View Details</a>
                        </div>
                    </div>
                </article>
            </div>
            <?php
        }
    } else {
        echo '<p>No properties found.</p>';
    }

    wp_reset_postdata();
    wp_die();
}

add_action('wp_ajax_custom_search', 'custom_search_function');
add_action('wp_ajax_nopriv_custom_search', 'custom_search_function');
