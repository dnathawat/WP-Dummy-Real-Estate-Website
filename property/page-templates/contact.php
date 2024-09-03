<?php

$propertyid = $_GET['propertyid'];
$author_id = get_post_field('post_author', $propertyid);
$propertyemail = get_the_author_meta('email', $author_id);

if (isset($_POST['form_submitted']) && !empty($_POST['form_submitted'])) {




    $errors = [];
    $errorMessage = '';



    // Sanitize form inputs
    $cctname = sanitize_text_field($_POST['cctname']);
    $cctphone = sanitize_text_field($_POST['cctphone']);
    $cctemail = sanitize_email($_POST['cctemail']);
    $cctmessage = sanitize_textarea_field($_POST['cctmessage']);

    // Validate required fields
    if (empty($cctname)) {
        $errors[] = 'Name is empty';
    }
    if (empty($cctphone)) {
        $errors[] = 'Phone is empty';
    }
    if (empty($cctemail)) {
        $errors[] = 'Email is empty';
    } elseif (!is_email($cctemail)) {
        $errors[] = 'Email is invalid';
    }
    if (empty($cctmessage)) {
        $errors[] = 'Message is empty';
    }

    // Send email if no errors
    if (empty($errors)) {
        if ($propertyemail) {
            $toEmail = $propertyemail;
        } else {
            $toEmail = 'codechk@gmail.com';
        }

        $emailSubject = 'New email from your contact form';
        $headers = ['From' => $cctemail, 'Reply-To' => $cctemail, 'Content-Type' => 'text/html; charset=utf-8'];
        $body = "<strong>Name:</strong> {$cctname}<br><strong>Email:</strong> {$cctemail}<br><strong>Phone Number:</strong> {$cctphone}<br><strong>Message:</strong> {$cctmessage}";

        if (wp_mail($toEmail, $emailSubject, $body, $headers)) {
            $success = "Mail sent successfully.";
        } else {
            $errorMessage = 'Oops, something went wrong. Please try again later.';
        }

    } else {
        $allErrors = join('<br>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";



    }



}

?>
<?php

/* Template Name:Contact */
get_header();

?>





<!-- About us -->
<section id="aa-about-us ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-about-us-area">

                    <div class="container">
                        <div id="wrap">

                            <form action="" method="POST">

                                <label for="name">Name:</label>
                                <input type="text" name="cctname" id="cctname">

                                <label for="phone">Phone:</label>
                                <input type="text" name="cctphone" id="cctphone">

                                <label for="email">Email:</label>
                                <input type="email" name="cctemail" id="cctemail">

                                <label for="message">Message:</label>
                                <textarea name="cctmessage" id="cctmessage"></textarea>

                                <input type="submit" name="form_submitted" value="Send Message">

                                <?php if (!empty($errorMessage)): ?>
                                    <div><?php echo $errorMessage; ?></div>
                                <?php elseif (!empty($success)): ?>
                                    <div><?php echo $success; ?></div>
                                <?php endif; ?>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / About us -->
<!-- Latest property -->


<!-- / Latest property -->
<?php
get_footer();

?>