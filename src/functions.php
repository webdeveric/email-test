<?php

namespace webdeveric\EmailTest;

function adminMenu()
{
    \add_management_page(
        'Email Test',
        'Email Test',
        'manage_options',
        'email-test',
        __NAMESPACE__ . '\emailTestPage'
    );
}

function emailTestPage()
{
    $message = '';
    $email = (wp_get_current_user())->user_email;
    $nonceAction = 'send-test-email';
    $nonceField = 'email-test-nonce';
    $nonce = filter_input(INPUT_POST, $nonceField);

    if ( $nonce && wp_verify_nonce( $nonce, $nonceAction ) ) {
        if (filter_has_var(INPUT_POST, 'email')) {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        }

        if (! $email) {
            $message = sprintf('<div class="error"><p>Invalid email address: %s</p></div>', \esc_html(filter_input(INPUT_POST, 'email')));
        } else {
            $ok = \wp_mail( $email, 'Email Test', sprintf('wp_mail() test from %s.', filter_input(INPUT_SERVER, 'HTTP_HOST')));
            $message = sprintf('<div class="updated"><p>Email sent = %s</p></div>', $ok ? 'true' : 'false');
        }
    }
    ?>

    <h1>Email Test</h1>

    <?php echo $message; ?>

    <form action="" method="post">
        <?php \wp_nonce_field($nonceAction, $nonceField); ?>
        <input class="regular-text" type="email" name="email" id="email" placeholder="email address" value="<?php echo \esc_attr(filter_var($email, FILTER_SANITIZE_EMAIL)); ?>" required />
        <button type="submit" class="button-primary">Send Test Email</button>
    </form>

    <?php
}
