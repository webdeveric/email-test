<?php
/*
Plugin Name: Email Test
Description: This plugin sends a simple test message to the admin or an email address of your choice.
Author: Eric King
Version: 0.2
Author URI: http://webdeveric.com/
*/

function email_test_menu(){
	$settings_page = add_options_page( __('Email Test'), __('Email Test'), 'manage_options', 'email-test', 'email_test_page' );
}
add_action( 'admin_menu', 'email_test_menu' );


function email_test_page(){

	$message = '';

	$admin_email = get_option('admin_email');
	$email = $admin_email;

	if( isset( $_POST['action'] ) && $_POST['action'] == 'send-test' ){

		if( filter_has_var( INPUT_POST, 'email' ) )
			$email = $_POST['email'];

		$valid_email = filter_var( $email, FILTER_VALIDATE_EMAIL );

		if( $valid_email === false ){
			$message = sprintf('<pre class="message">Invalid email address: %s</pre>', $email );
		} else {
			$ok = wp_mail( $valid_email, $_SERVER['HTTP_HOST'] . ' - Server Email Test', 'this is only a test.');
			$message = sprintf('<pre class="message">Email sent = %s</pre>', print_r( $ok, true ) );
		}

	}
?>

<h1>Email Test</h1>

<?php echo $message; ?>

<form action="" method="post">
	<input type="hidden" name="action" value="send-test" />
	<input type="email" name="email" id="email" placeholder="email address" value="<?php echo $email; ?>" style="width:200px;" />
	<button type="submit" class="button-primary">Send Test Email</button>
</form>

<?php
}