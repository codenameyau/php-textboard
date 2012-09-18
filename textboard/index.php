<?php
require_once "headers/h1.php";

$textboardfile = 'files/textboards/textboard1.txt';
$editlogfile = 'files/logs/editlog'.$monthyear.'.txt';

// Create textboard and log files
if (!file_exists($textboardfile))
	{
		$txt1 = fopen($textboardfile, 'a');
		fclose($txt1);
	}

if (!file_exists($editlogfile))
	{
		$edittxt = fopen($editlogfile, 'a');
		fclose($edittxt);
	}

if (isset($_POST['button']) && $username != 'Guest')
	{
		if ($_POST['button'] == 'Submit Changes')
			{
				$textdata = $_POST['edittext'];
				$txt1 = fopen($textboardfile, 'w');
				$edittxt = fopen($editlogfile, 'a');
				fwrite($txt1, $textdata);
				$white_spaces = str_repeat(' ', 14-strlen($username));
				fwrite($edittxt, "$username$white_spaces@ $date\n");
				fclose($txt1);
				fclose($edittxt);
			}
	}

$txtfile = fopen($textboardfile, 'r');
$filecontents = fread($txtfile, filesize($textboardfile)+1);

if ($account_type == 'admin')
	echo 	"<span style='margin-left:40px'>
				<a href='session.php'>$username</a>
			</span>
			<span style='margin-left:30px''>
			<a href='logs.php' target='_blank'>logs</a></span>
			<span style='margin-left:30px;margin-right:30px''>
			<a href='database.php' target='_blank'>database</a></span>
			<form action='' method='POST' style='display: inline;'>
			<input type='submit' name='button' value='Submit Changes'>
			<textarea rows='30' name='edittext'>$filecontents</textarea>
			</form>";

else if ($account_type == 'mod')
	echo 	"<span style='margin-left:40px'>
				<a href='session.php'>$username</a></span>
			<span style='margin-left:30px;margin-right:30px''>
			<a href='logs.php' target='_blank'>logs</a></span>
			<form action='' method='POST' style='display: inline;'>
			<input type='submit' name='button' value='Submit Changes'>
			<textarea rows='30' name='edittext'>$filecontents</textarea>
			</form>";

else if ($account_type == 'user')
	echo 	"<span style='margin-left:40px;margin-right:30px'>
			<a href='session.php'>$username</a></span>
			<form action='' method='POST' style='display: inline;'>
			<input type='submit' name='button' value='Submit Changes'>
			<textarea rows='30' name='edittext'>$filecontents</textarea>
			</form>";

else
	echo 	"<span style='margin-left:40px'>
			<a href='session.php'>$username</a>
			</span><form action='' method='POST'>
			<textarea rows='30' name='edittext' readonly>$filecontents</textarea></form>";

?>
<br>
<?php
require_once "headers/hend.php";
?>