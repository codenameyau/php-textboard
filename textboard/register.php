<?php

require_once "headers/h1.php";

function checkEmail( $email )
{
    return filter_var( $email, FILTER_VALIDATE_EMAIL );
}

if (isset($_SESSION['username']))
	header("Location: index.php");

else
{
	$reg_user = '';
	$reg_email = '';
	
	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
		$reg_user = $_POST['USERNAME'];
	if (isset($_POST['EMAIL']) && !empty($_POST['EMAIL']))
		$reg_email = $_POST['EMAIL'];

	require_once "headers/h2.php";
	echo "<fieldset style='width:240px;height:450px;margin-top:10px''>
			<legend><b>Login Registration</b></legend>
			<form action='' method='POST'>
			<div class='inputform'>
			Username: <input type='text' name='USERNAME' value='$reg_user' maxlength=12><br>
			Email Address: <input type='text' name='EMAIL' value='$reg_email' maxlength=40><br>
			Password: <input type='password' name='PASSWORD1' maxlength=25><br>
			Confirm Password: &nbsp;&nbsp;<input type='password' name='PASSWORD2' maxlength=25></div><br><br>
			<span style='margin-left:120px;'><input type='submit' value='Submit'></span>
			<br><br></form>";

	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
	{
		$reg_user = strtolower(mysql_real_escape_string($_POST['USERNAME']));
		$reg_pass = mysql_real_escape_string($_POST['PASSWORD1']);
		$reg_pass2 = mysql_real_escape_string($_POST['PASSWORD2']);
		$reg_email = mysql_real_escape_string($_POST['EMAIL']);

		if (strlen($reg_user) > 12 || strlen($reg_user) < 4)
			exit("*Invalid username</fieldset>");
		if (!checkEmail($reg_email))
			exit("*Invalid email address</fieldset>");
		if (strlen($reg_pass) < 4)
			exit("*Password is too short</fieldset>");
		if (strlen($reg_pass) > 25)
			exit("*Password is too long</fieldset>");
		if ($reg_pass != $reg_pass2)
			exit("*Passwords do not match</fieldset>");

		if (ctype_alnum($reg_user) && ctype_alnum($reg_pass))
		{
			connect_database();

			if ($result = mysql_query("SELECT USERNAME FROM userlogin WHERE USERNAME='{$reg_user}'"))
			{
				if (mysql_num_rows($result) >= 1)
					exit("*Username already exists</fieldset>");

				else
				{
					$hashpass = crypt($reg_pass, sha1($salt1.$reg_pass.$salt2));
					
					$insert = "INSERT INTO `phplearn`.`userlogin` 
						VALUES (NULL, '{$reg_user}', '{$hashpass}', 'user', '{$reg_email}', CURRENT_TIMESTAMP)";
					
					if (mysql_query($insert) or exit(mysql_error()))
						header("Location: session.php");
				}
			}
		}
		else
			exit("*Invalid input data</fieldset>");

	}
	echo "</fieldset>";
}

require_once "headers/hend.php";
?>