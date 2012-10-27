<?php
require_once 'headers/h1.php';

if (isset($_SESSION['username']))
	{
		$loginname = $_SESSION['username'];
		echo "<span style='word-spacing:180px'> </span>
				<a href='/textboard/scripts/logout.php'>Logout</a>
				<fieldset style='width:400px;height:340px'><legend>
				<lengend><b>Account Info:</b></legend>";
		echo "<br>Welcome, $loginname";
		echo "</fieldset>";
	}

else
	{
		echo "
			<fieldset style='width:220px;height:360px;'>
			<legend><b>Login to Continue</b></legend>
			<form action='' method='POST'>
			<div class='inputform'>
				<br>Username: <input type='text' name='username' maxlength=12>
				<br>
				<br>Password: <input type='password' name='password' maxlength=25>
			</div><br>
			<span style='margin-left:132px'><input type='submit' value='Sign In'></span>
			</form>
			<br><br>
			<div class='inputform'>
				<a href='register.php'>Create account</a><br>
				<a href='resetpass.php'>Reset password</a>
			</div>";

		if (isset($_POST['username']) && !empty($_POST['username']))
			{
				$username = mysql_real_escape_string(strtolower(htmlentities($_POST['username'])));
				if (strlen($username) < 3 || strlen($username) > 12)
					exit("<span style='margin-left:10px'>Invalid login</span></fieldset>");

				else if (isset($_POST['password']) && !empty($_POST['password']))
					{
						require_once 'headers/h2.php';
						connect_database();
						$user_query = mysql_query("SELECT USERNAME, PASSWORD, ACCOUNT, BOARD FROM userlogin WHERE USERNAME='{$username}'");

						if (mysql_num_rows($user_query) == 1)
						{
							$storedpass = htmlentities($_POST['password']);
							$query_data = mysql_fetch_assoc($user_query);
							$query_password =  $query_data['PASSWORD'];
							$account_type = $query_data['ACCOUNT'];
							$user_board = $query_data['BOARD'];
							$password = crypt($storedpass, $query_password);

							if ($password == $query_password)
								{
									$_SESSION['username'] = $username;
									$_SESSION['account'] = $account_type;
									$_SESSION['board_id'] = $user_board;
									$_SESSION['current_board'] = '0';
									header("Location: index.php");
								}

							else
								exit("<span style='margin-left:10px'>Incorrect password</span></fieldset>");
						}

						else
							exit("<span style='margin-left:10px'>Incorrect login</span></fieldset>");
					}

				else
					exit("<span style='margin-left:10px'>Incorrect login</span></fieldset>");
			}
	}
	echo "</fieldset>";

require_once "headers/hend.php";
?>
