<?php
/* Template Name:Home */
get_header(); ?>




<!-- Advance Search -->
<section id="aa-advance-search">
    <div class="container">
        <div class="aa-advance-search-area">
            <div class="form">
                <div class="aa-advance-search-top ">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="aa-single-advance-search">
                                <input type="text" id="custom-search-input" placeholder="Type Your Location">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="aa-single-advance-search">
                                <select id="custom-search-taxonomy">
                                    <option value="">Select Type</option>
                                    <?php
                                    $terms = get_terms(array(
                                        'taxonomy' => 'property_type',
                                        'hide_empty' => false,
                                    ));
                                    foreach ($terms as $term) {
                                        echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="aa-single-advance-search">
                                <input id="custom-search-button" class="aa-search-btn" type="submit" value="Search">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- / Advance Search -->



<!-- Latest property -->
<section id="aa-latest-property">
    <div class="container">
        <div class="aa-latest-property-area">
            <div class="aa-title">
                <h2>Latest Properties</h2>

            </div>
            <div class="aa-latest-properties-content">
                <div id="custom-search-results" class="row">
                    <?php
                    $args = array(
                        'post_type' => 'property',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        $taxonomy = 'property_type'
                    );
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()):
                        while ($the_query->have_posts()):
                            $the_query->the_post();

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
                                        For <?php $terms = get_object_term_cache($post->ID, $taxonomy);
                                        $output = '';
                                        foreach ($terms as $term) {
                                            echo $term->name;
                                        }
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
                                            <a href="contact-us/?propertyid=<?php echo get_the_ID(); ?>"
                                                class="aa-secondary-btn">Contact Us</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                    endif;

                    ?>






                </div>
            </div>
        </div>
    </div>
</section>


<!-- / Latest property -->












<?php get_footer(); ?>