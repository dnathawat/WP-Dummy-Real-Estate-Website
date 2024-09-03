<?php
/* Template Name:Login */
?><?php
$error_message = '';
if (isset($_POST['login'])) {
    $creds = array(
        'user_login' => $_POST['username'],
        'user_password' => $_POST['password'],
        'remember' => true,
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        $error_message = $user->get_error_message();
    } else {
        wp_redirect(home_url('/my-account'));
        exit;
    }
}
wp_head(); ?>

<section id="aa-signin">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-signin-area">
                    <div class="aa-signin-form">
                        <div class="aa-signin-form-title">
                            <a class="aa-property-home" href="index.html">Property Home</a>
                            <h4>Sign in to your account</h4>
                        </div>
                        <?php
                        echo '<p class="error">' . $error_message . '</p>';
                        ?>
                        <form class="contactform" method="post">
                            <div class="aa-single-field">
                                <label for="username">Username or Email <span class="required">*</span></label>
                                <input type="text" name="username" id="username">
                            </div>
                            <div class="aa-single-field">
                                <label for="password">Password <span class="required">*</span></label>
                                <input type="password" name="password" id="password">
                            </div>

                            <div class="aa-single-submit">
                                <input type="submit" value="Login" class="aa-browse-btn" name="login">
                                <p>Don't Have A Account Yet? <a href="<?php echo esc_url(get_permalink(8)); ?>">CREATE
                                        NOW!</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
wp_footer(); ?>

</body>