<?php
require_once "headers/h1.php";

if ($account_type == 'admin')
{

	if (isset($_POST['submit']))
	{
		$selected_date = $_POST['log_date'];
		$_SESSION['view_log'] = $selected_date;

		if ($_POST['textboard_log'] == '00')
			header("Location: scripts/log_00.php");

		else if ($_POST['textboard_log'] == '01')
			header("Location: scripts/log_01.php");
	}

	$select_dir = $public_log_dir;

	echo "<span style='word-spacing:180px'> </span>
			<fieldset style='width:250px;height:250px'><legend>
			<lengend><b>View Logs: $year</b></legend><br>
			<form action='' target='_blank' method='POST'>
				Select Textboard:<br>
				<select name='textboard_log'>
					<option value='00'>public</option>
					<option value='01'>announcements</option>
				</select><br><br>Select Log Date:
				<select name='log_date'>";

	if ($opendir = opendir($select_dir))
		{
			while ($openfile = readdir($opendir))
				if ($openfile != '.' && $openfile != '..')
				{
					$info = pathinfo($openfile);
					$log_date =  basename($openfile,'.'.$info['extension']);
					echo "<option value='$log_date'>$log_date</option>";
				}
		}

	echo "</select><br><br><br>
			<input type='submit' name='submit' value='View'>
			</form></fieldset>";

	require_once "headers/hend.php";
}

else header("Location: index.php");
?>

