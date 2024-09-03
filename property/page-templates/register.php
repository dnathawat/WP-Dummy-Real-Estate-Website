<?php
/* Template Name:Register */

if (is_user_logged_in()) {

    wp_redirect('http://property.loc');
    exit;

}



if (isset($_POST['submit'])) {
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];



    if (username_exists($username)) {
        $errors[] = 'Username already exists.';
    }
    if (!is_email($email)) {
        $errors[] = 'Invalid email address.';
    }
    if (email_exists($email)) {
        $errors[] = 'Email already registered.';
    }
    if (empty($password)) {
        $errors[] = 'Password cannot be empty.';
    }
    if (empty($errors)) {
        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            wp_redirect(home_url('/my-account'));
            exit;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }

    if (!empty($errors)) {
        echo '<ul class="registration-errors">';
        foreach ($errors as $error) {
            echo '<li>' . esc_html($error) . '</li>';
        }
        echo '</ul>';
    }
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo get_stylesheet_uri(); ?>/img/favicon.ico" type="image/x-icon">
    <?php wp_head(); ?>





    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<section id="aa-signin">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-signin-area">
                    <div class="aa-signin-form">
                        <div class="aa-signin-form-title">
                            <a class="aa-property-home" href="index.html">Property Home</a>
                            <h4>Create your account and Stay with us</h4>
                        </div>
                        <?php if (isset($_POST['submit'])) {
                            foreach ($errors as $err) {
                                echo $err . "<br>";
                            }
                        } ?>
                        <form class="contactform" method="post" action="">
                            <div class="aa-single-field">
                                <label for="name">Name <span class="required">*</span></label>
                                <input type="text" required="required" aria-required="true" id="username"
                                    name="username">
                            </div>
                            <div class="aa-single-field">
                                <label for="email">Email <span class="required">*</span></label>
                                <input type="email" required="required" aria-required="true" id="email" name="email">
                            </div>
                            <div class="aa-single-field">
                                <label for="password">Password <span class="required">*</span></label>
                                <input type="password" name="password" id="password">
                            </div>

                            <div class="aa-single-submit">
                                <input type="submit" value="Create Account" name="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php wp_footer(); ?>

</body>

</html>