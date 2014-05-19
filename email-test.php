<?php
/*
Plugin Name: Email Test
Plugin Group: Utilities
Plugin URI: http://phplug.in/
Version: 0.2
Description: This plugin sends a simple test message to the admin or an email address of your choice.
Author: Eric King
Author URI: http://webdeveric.com/
*/


/*
@todo
- add wp nonce field instead of action send-test.
- update styles
*/

function email_test_menu()
{
    $settings_page = add_options_page('Email Test', 'Email Test', 'manage_options', 'email-test', 'email_test_page');
}
add_action( 'admin_menu', 'email_test_menu' );


function email_test_page()
{
    $message     = '';
    $admin_email = get_option('admin_email');
    $email       = $admin_email;

    if (isset($_POST['action']) && $_POST['action'] == 'send-test') {

        if (filter_has_var(INPUT_POST, 'email'))
            $email = $_POST['email'];

        $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if ($valid_email === false) {

            $message = sprintf('<div class="error"><p>Invalid email address: %s</p></div>', $email);

        } else {

            $ok = wp_mail( $valid_email, 'wp_mail test from ' . $_SERVER['HTTP_HOST'], 'this is only a test.');
            $message = sprintf('<div class="updated"><p>Email sent = %s</p></div>', print_r($ok, true));

        }
    }
    ?>

    <h1>Email Test</h1>

    <?php echo $message; ?>

    <form action="" method="post">
        <input type="hidden" name="action" value="send-test" />
        <input type="email" name="email" id="email" placeholder="email address" required value="<?php echo $email; ?>" />
        <button type="submit" class="button-primary">Send Test Email</button>
    </form>

    <?php
}
