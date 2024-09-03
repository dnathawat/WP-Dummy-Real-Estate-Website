<?php
if (!is_user_logged_in()) {

    wp_redirect(home_url());
    exit;

}


/* Template Name:Edit Property */
get_header(); ?>

<?php

?>

<?php if (is_user_logged_in()) {
    // Get the current user
    $current_user = wp_get_current_user();

    // Get the post ID from the query string
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

    // Fetch the post
    $post = get_post($post_id);

    $terms = wp_get_post_terms($post_id, 'property_type');

    // Assume there's only one term selected for this taxonomy
    $selected_term_id = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->term_id : '';
    $successmessage = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $postTitle = sanitize_text_field($_POST['post_title']);
        $postContent = wp_kses_post($_POST['post']);
        $cat = intval($_POST['cat']); // Ensure it's an integer
        $postPrice = sanitize_text_field($_POST['post_price']);
        global $user_ID;


        // Prepare post data
        wp_update_post([
            'ID' => $post_id,
            'post_title' => $postTitle,
            'post_content' => $postContent,
            'post_type' => 'property',
            'tax_input' => array('property_type' => array($cat)), // Custom taxonomy


            'post_author' => $user_ID,
        ]);


        // Insert the post

        if (!empty($_POST['post_price'])) {
            $post_price = sanitize_text_field($_POST['post_price']);
            update_post_meta($post_id, 'post_price', $post_price);
        }
        if (is_wp_error($post_id)) {
            echo 'Error: ' . $post_id->get_error_message();
        } else {
            $successmessage = 'Post Updated';
        }

    }
    if ($post && $post->post_author == $current_user->ID) {
        ?>
        <!-- About us -->
        <section id="aa-about-us ">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-about-us-area">
                            <h2 style=" margin-bottom: 20px; ">Welcome , <?php echo $current_user->display_name; ?></h2>
                            <div class="container">
                                <div id="wrap">

                                    <form class="contactform" action="" method="post" enctype="multipart/form-data"
                                        autocomplete="off">
                                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                                        <div class="aa-single-field">
                                            <label for="post_title">Post Title</label>
                                            <input id="post_title" name="post_title" type="text"
                                                value="<?php echo esc_attr($post->post_title); ?>" required />
                                        </div>
                                        <div class="aa-single-field">
                                            <label for="post_price">Post Price</label>
                                            <input id="post_price" name="post_price" value="<?php $prices = get_post_meta(get_the_ID(), 'post_price', true);
                                            if ($prices) { ?><?php echo $prices;
                                            } ?>" type="text" required />
                                        </div>
                                        <div class="aa-single-field">
                                            <label for="post">Content</label>
                                            <textarea id="post" name="post" cols="50" rows="6"
                                                required><?php echo esc_attr($post->post_content); ?></textarea>
                                        </div>
                                        <div class="aa-single-field">
                                            <label for="category">Category</label>
                                            <?php
                                            wp_dropdown_categories(array(
                                                'taxonomy' => 'property_type', // Custom taxonomy
                                                'hide_empty' => 0,
                                                'name' => 'cat',
                                                'id' => 'category',
                                                'selected' => $selected_term_id, // Set the selected value
                                            ));
                                            ?>
                                        </div>

                                        <div class="aa-single-submit">
                                            <input type="submit" name="submit" value="Update Post">
                                        </div>

                                    </form>
                                    <p><strong><?php echo $successmessage; ?></strong></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php }
} ?>
<!-- / About us -->
<!-- Latest property -->


<!-- / Latest property -->
<?php get_footer(); ?>