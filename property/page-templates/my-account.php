<?php
if (!is_user_logged_in()) {

    wp_redirect(home_url());
    exit;

}
/* Template Name:My Account */
get_header(); ?>

<?php
$successmessage = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $postTitle = sanitize_text_field($_POST['post_title']);
    $postContent = wp_kses_post($_POST['post']);
    $cat = intval($_POST['cat']); // Ensure it's an integer
    $postPrice = sanitize_text_field($_POST['post_price']);
    global $user_ID;

    // Prepare post data
    $new_post = array(
        'post_title' => $postTitle,
        'post_content' => $postContent,
        'post_status' => 'publish',
        'post_date' => current_time('mysql'),
        'post_author' => $user_ID,
        'post_type' => 'property',
        'tax_input' => array('property_type' => array($cat)), // Custom taxonomy
    );

    // Insert the post
    $post_id = wp_insert_post($new_post, true);
    if (!empty($_POST['post_price'])) {
        $post_price = sanitize_text_field($_POST['post_price']);
        update_post_meta($post_id, 'post_price', $post_price);
    }
    if (is_wp_error($post_id)) {
        echo 'Error: ' . $post_id->get_error_message();
    } else {
        // Handle featured image upload
        if (isset($_FILES['featured_image']) && !empty($_FILES['featured_image']['name'])) {
            // Include the necessary files for handling uploads
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            $attachment_id = media_handle_upload('featured_image', $post_id);
            if (is_wp_error($attachment_id)) {
                echo 'Error uploading image: ' . $attachment_id->get_error_message();
            } else {
                set_post_thumbnail($post_id, $attachment_id);
                $successmessage = 'Post created successfully.';
            }
        } else {
            $successmessage = 'Post created successfully.';
        }
    }
}
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
                                <div class="aa-single-field">
                                    <label for="post_title">Post Title</label>
                                    <input id="post_title" name="post_title" type="text" required />
                                </div>
                                <div class="aa-single-field">
                                    <label for="post_price">Post Price</label>
                                    <input id="post_price" name="post_price" type="text" required />
                                </div>
                                <div class="aa-single-field">
                                    <label for="post">Content</label>
                                    <textarea id="post" name="post" cols="50" rows="6" required></textarea>
                                </div>
                                <div class="aa-single-field">
                                    <label for="category">Category</label>
                                    <?php
                                    wp_dropdown_categories(array(
                                        'taxonomy' => 'property_type', // Custom taxonomy
                                        'hide_empty' => 0,
                                        'name' => 'cat', // Name should match in PHP handling code
                                        'id' => 'category'
                                    ));
                                    ?>
                                </div>
                                <div class="aa-single-field">
                                    <label for="featured_image">Featured Image</label>
                                    <input id="featured_image" name="featured_image" type="file" accept="image/*" />
                                </div>
                                <div class="aa-single-submit">
                                    <input name="submit" type="submit" value="Add Property" />
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
<!-- / About us -->
<!-- Latest property -->

<section id="aa-latest-property">
    <div class="container">
        <div class="aa-latest-property-area">
            <div class="aa-title">
                <h2>Listed Properties</h2>
            </div>
            <div class="aa-latest-properties-content">
                <?php
                $user = wp_get_current_user();
                $query_args = array(
                    'post_type' => 'property',
                    'author' => $user->ID,
                    $taxonomy = 'property_type'
                );
                $query = new WP_Query($query_args);

                if ($query->have_posts()) { ?>
                    <div class="row">
                        <table style="width:100%">
                            <thead>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Type</th>

                                <th>Action</th>
                            </thead>
                            <tbody>

                                <?php $i = 1;
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $post = $query->post; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $post->post_title; ?></td>
                                        <td><?php $prices = get_post_meta(get_the_ID(), 'post_price', true);
                                        if ($prices) { ?>
                                                $<?php echo $prices;
                                        } ?></td>
                                        <td><?php $terms = get_object_term_cache($post->ID, $taxonomy);
                                        $output = '';
                                        foreach ($terms as $term) {
                                            echo $term->name;
                                        }
                                        ?></td>
                                        <td><a
                                                href="http://property.loc/edit-page/?post_id=<?php echo get_the_ID(); ?>">Edit</a>
                                            <?php
                                            if (get_current_user_id() == $post->post_author || current_user_can('delete_post', $post->ID)): ?>
                                                <a href="<?php echo esc_url(add_query_arg(array('action' => 'delete_post', 'post_id' => $post->ID, '_wpnonce' => wp_create_nonce('delete_post_' . $post->ID)), home_url('/my-account'))); ?>"
                                                    onclick="return confirm('Are you sure you want to delete this post?');">
                                                    Delete Post
                                                </a>
                                            <?php endif; ?>



                                        </td>
                                    </tr>


                                    <?php $i++;
                                }

                                wp_reset_postdata();
                                ?>

                            </tbody>
                        </table>
                    </div>
                <?php } else {
                    echo 'No posts found.';
                } ?>
            </div>
        </div>
    </div>
</section>
<!-- / Latest property -->
<?php get_footer(); ?>