<?php

require_once "headers/h1.php";

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
	echo "<fieldset style='width:220px;height:480px'>
			<legend><b>Login Registration</b></legend>
		<form action='' method='POST'>
			<div class='inputform'>
				Username: <input type='text' name='USERNAME' value='$reg_user' maxlength=12><br>
				Email Address: <input type='text' name='EMAIL' value='$reg_email' maxlength=40><br><br>
				Password: <input type='password' name='PASSWORD1' maxlength=25><br>
				Confirmation: <input type='password' name='PASSWORD2' maxlength=25><br><br>
				Enter code below: <input type='password' name='CAPTCHA' maxlength=5><br>
				<img src='scripts/captcha.php' style='margin-left:-7px'><br>
			</div>
			<span style='margin-left:130px;'><input type='submit' value='Submit'></span>
		</form><br>";

	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
	{
		$reg_user = strtolower(mysql_real_escape_string($_POST['USERNAME']));
		$reg_pass = mysql_real_escape_string($_POST['PASSWORD1']);
		$reg_pass2 = mysql_real_escape_string($_POST['PASSWORD2']);
		$reg_email = mysql_real_escape_string($_POST['EMAIL']);
		$reg_code = strtolower(htmlentities(($_POST['CAPTCHA'])));
		$check_code = $_SESSION['secure_captcha'];
		echo "<span style='margin-left:10px;'>";

		if (strlen($reg_user) > 12 || strlen($reg_user) < 3)
			exit("Invalid username</fieldset>");
		if (!checkEmail($reg_email))
			exit("Invalid email address</fieldset>");
		if (strlen($reg_pass) < 4)
			exit("Password is too short</fieldset>");
		if (strlen($reg_pass) > 25)
			exit("Password is too long</fieldset>");
		if ($reg_pass != $reg_pass2)
			exit("Passwords do not match</fieldset>");
		if ($reg_code != $check_code)
			exit("Code does not match</fieldset>");

		if (ctype_alnum($reg_user))
		{
			connect_database();

			if ($result = mysql_query("SELECT USERNAME FROM userlogin WHERE USERNAME='{$reg_user}'"))
			{
				if (mysql_num_rows($result) >= 1)
					exit("Username already exists</fieldset>");

				else
				{
					$boardhash = "58290f405e3f221df197a71f58450192";
					while (true)
					{
						$textboard_id = str_shuffle(substr(sha1($reg_user.$boardhash), 0, 20));
						$board_id = substr($textboard_id, 6, 20);
						if (!is_dir("boards/$board_id"))
							break;
					}
					
					$userboard_id = substr($textboard_id, 0, 5);
					mkdir("boards/$board_id");
					$user_board = fopen("boards/$board_id/$userboard_id.txt", 'w');
					fwrite($user_board, gzcompress("Welcome, $reg_user! This is your private textboard. Enjoy!", 3));
					fclose($user_board);

					$hashpass = crypt($reg_pass, sha1($salt1.$reg_pass.$salt2));
					
					$insert = "INSERT INTO `phplearn`.`userlogin` 
						VALUES (NULL, '{$reg_user}', '{$hashpass}', 'user', '{$reg_email}', '{$textboard_id}',CURRENT_TIMESTAMP)";
					
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