<?php


//
include_once(TEMPLATEPATH . '/libs/config.php');

//
include_once(TEMPLATEPATH . '/libs/enqueue.php');

//
include_once(TEMPLATEPATH . '/libs/widgets.php');

function handle_post_deletion_request()
{
	if (isset($_GET['action']) && $_GET['action'] === 'delete_post' && isset($_GET['post_id']) && isset($_GET['_wpnonce'])) {
		$post_id = intval($_GET['post_id']);
		$nonce = sanitize_text_field($_GET['_wpnonce']);

		// Verify the nonce
		if (!wp_verify_nonce($nonce, 'delete_post_' . $post_id)) {
			wp_die('Security check failed.');
		}

		// Get the post object
		$post = get_post($post_id);

		// Debugging: Verify post and user details
		if (!$post) {
			wp_die('Post not found.');
		}

		$current_user_id = get_current_user_id();
		$post_author_id = $post->post_author;

		// Check if the current user is the post author or has permission to delete the post
		if ($current_user_id == $post_author_id || current_user_can('delete_post', $post_id)) {
			wp_delete_post($post_id, true); // true to force delete, false to send to trash
			wp_redirect(home_url("/my-account")); // Redirect after deletion
			exit;
		} else {
			wp_die('You do not have permission to delete this post.');
		}
	}
}
add_action('template_redirect', 'handle_post_deletion_request');
