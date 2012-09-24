<?php
require_once "headers/h1.php";
require_once "headers/h2.php";

if ($account_type == 'admin')
{
	echo "<fieldset style='width:500px;height:450px;'>
			<legend><b>Search For User:</b></legend>
			<form action='' method='POST'><br>
			<input type='text' name='USERNAME' maxlength=12>
			<input type='submit' value='Search'>
			</form><br><br>";

	if (isset($_POST['USERNAME']) && !empty($_POST['USERNAME']))
	{
		$user = mysql_real_escape_string($_POST['USERNAME']);
		if (strlen($user) > 12)
			exit("<span style='margin:5px'>USERNAME: '$user' not found</span>");
		
		connect_database();

		if ($data = mysql_query("SELECT * FROM userlogin WHERE USERNAME='{$user}'"))
		{
			if ($info = mysql_fetch_assoc($data))
			{
				$username = $info['USERNAME'];
				$id = $info['ID'];
				$password = $info['PASSWORD'];
				$account_type = $info['ACCOUNT'];
				$email = $info['EMAIL'];
				$textboard_id = $info['BOARD'];
				$date_create = $info['DATE'];
				echo "<b>ID:</b> $id<br><br>
						<b>username:</b> $username<br><br>
						<b>account type:</b> $account_type<br><br>
						<b>email address:</b><br>$email<br><br>
						<b>textboard id:</b><br>$textboard_id<br><br>
						<b>date created:</b><br>$date_create<br>";
			}

			else exit("<span style='margin:5px'>User '$user' not found</span>");
		}

		else exit("<span style='margin:5px'>User '$user' not found</span>");
	}
	require_once "headers/hend.php";
}
else
	header("Location: index.php");

?>