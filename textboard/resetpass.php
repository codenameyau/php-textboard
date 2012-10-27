<?php
require_once "headers/h1.php";

if ($account_type == 'guest')
{
	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
		$value_user  = $_POST['USERNAME'];
	else $value_user = '';

	if (isset($_POST['EMAIL']) && !empty($_POST['EMAIL']))
		$value_email = $_POST['EMAIL'];
	else $value_email = '';

	echo "<br><fieldset style='width:220px;height:390px'>
			<legend><b>Reset Password</b></legend>
			<div class='inputform'><form action='' method='POST'>
			Enter username:<br><input type='text' name='USERNAME' value='$value_user' maxlength=12><br><br>
			Enter email address:<br><input type='text' name='EMAIL' value ='$value_email' maxlength=40><br><br>
			Enter code below:<input type='password' name='CAPTCHA' maxlength=5><br>
			<img src='scripts/captcha.php' style='margin-left:-7px'><br></div>
			<span style='margin-left:130px;'><input type='submit' value='Submit'></span>
			<br><br></form>";

	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
	{
		$reset_user  = mysql_real_escape_string(htmlentities(strtolower($_POST['USERNAME'])));
		$reset_email = mysql_real_escape_string(htmlentities(strtolower($_POST['EMAIL'])));
		$reset_code  = htmlentities(strtolower($_POST['CAPTCHA']));
		$check_code  = $_SESSION['secure_captcha'];
		echo "<div style='margin-left:10px'>";
		if ($reset_code != $check_code)
			exit("Code does not match");
		if (!ctype_alnum($reset_user))
			exit("Invalid username");
		if (!checkEmail($reset_email))
			exit("Invalid email");


		require_once "headers/h2.php";
		connect_database();

		$email_query = mysql_query("SELECT ID, USERNAME, EMAIL FROM userlogin WHERE USERNAME='{$reset_user}'");

		if (mysql_num_rows($email_query) == 1)
		{
			$sql_data = mysql_fetch_assoc($email_query);
			$fetched_id    = $sql_data['ID'];
			$fetched_email = $sql_data['EMAIL'];
			$fetched_user  = $sql_data['USERNAME'];

			if ($fetched_email != $reset_email)
				exit("Incorrect email address");

			$chars = "ABCDEFGHIJKMNPQRSTUVWXYZaabbccddeeffghijkmnpqrstuvwxyz";
			$new_pass = substr(str_shuffle($chars), 0, 7);
			$hash_pass = crypt($new_pass);

 			$subject = "Textboard Password Reset";
 			$body = "Hello, you've requested a password reset from Textboard.\n
 					\nUsername: $fetched_user\nNew Password: $new_pass";

 			// Include header argument when hosted
			mail($fetched_email, $subject, $body);

			mysql_query("UPDATE userlogin SET PASSWORD='{$hash_pass}' WHERE ID='{$fetched_id}'");

			echo "Password sent to email";
		}

		else
			exit("'$reset_user' not found");

	}

	echo "</fieldset>";
	require_once "headers/hend.php";
}

else
	header("Location: index.php");

?>