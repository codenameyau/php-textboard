<?php
require_once 'headers/h1.php';
require_once 'headers/h2.php';

if (isset($_SESSION['username']))
	{
		$loginname = $_SESSION['username'];
		echo "<span style='word-spacing:180px'> </span><a href='/textboard/scripts/logout.php'>Logout</a>
				<fieldset style='width:400px;height:340px;margin-top:10px'><legend>
				<lengend><b>Account Info:</b></legend>";
		echo "<br>Welcome, $loginname";
	}

else
	{
		echo "<form action='' method='POST'>
		<fieldset style='width:210px;height:340px;margin-top:10px'><legend>
		<lengend><b>Login to Continue</b></legend>
		<div class='inputform' style='margin-top:10px;'
		<br>Username: <input type='text' name='username' maxlength=12>
		<br>
		<br>Password: <input type='password' name='password' maxlength=25>
		</div>
		<br><span style='margin-left:132px'><input type='submit' value='Sign In'></span>
		<br><br><br>
		<span style='margin-left:10px'>
		<a href='register.php'>Create account</a>
		</span>
		<br>
		<span style='margin-left:10px'>
		<a href='resetpass.php'>Reset password</a>
		</span>
		</form><br><br>";

		if (isset($_POST['username']) && !empty($_POST['username']))
			{
				$username = mysql_real_escape_string(strtolower(htmlentities($_POST['username'])));
				if (strlen($username) < 3 || strlen($username) > 12)
					exit("<span style='margin-left:10px'>*Invalid Login</span></fieldset>");

				else if (isset($_POST['password']) && !empty($_POST['password']))
					{
						connect_database();
						$user_query = mysql_query("SELECT USERNAME, PASSWORD, ACCOUNT FROM userlogin WHERE USERNAME='{$username}'");

						if (mysql_num_rows($user_query) == 1)
						{
							$storedpass = htmlentities($_POST['password']);
							$password = crypt($storedpass, sha1($salt1.$storedpass.$salt2));
							$query_data = mysql_fetch_assoc($user_query);
							$query_password =  $query_data['PASSWORD'];
							$account_type = $query_data['ACCOUNT'];

							if ($password == $query_password)
								{
									$_SESSION['username'] = $username;
									$_SESSION['account'] = $account_type;
									header("Location: index.php");
								}

							else
								exit("<span style='margin-left:10px'>*Incorrect Password</span></fieldset>");
						}

						else
							exit("<span style='margin-left:10px'>*Incorrect Login</span></fieldset>");
					}

				else
					exit("<span style='margin-left:10px'>*Incorrect Login</span></fieldset>");
			}
	}

require_once "headers/hend.php";
?>
