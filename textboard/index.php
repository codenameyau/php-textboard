<?php
require_once "headers/h1.php";

// Public Board
if ($current_board == 0)
{
	$textboardfile = 'files/textboards/public.txt';
	$editlogfile = 'files/textboard_logs/editlog'.$monthyear.'.txt';

	if ($account_type != 'admin' && $account_type != 'user')
		$readonly = 'readonly';

	if (!is_dir('files/textboard_logs'))
		mkdir('files/textboard_logs');

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
}

// Announcements Board
else if ($current_board == 1)
{
	$textboardfile = 'files/textboards/announcements.txt';
	$editlogfile = 'files/announce_logs/editlog'.$monthyear.'.txt';

	if ($account_type != 'admin')
		$readonly = 'readonly';

	// Create textboard and log files
	if (!is_dir('files/announce_logs'))
		mkdir('files/announce_logs');

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
}

// Userboard
else
{
	// if GET url_supplied


	// if no Get url
	$user_dir   = substr($board_id, 6, 20);
	$user_board = substr($board_id, 0, 5);

	$textboardfile = "boards/$user_dir/$user_board.txt";
	$editlogfile = "boards/$user_dir/logs/editlog'.$monthyear.'.txt";

	if ($account_type != 'admin' || $account_type != 'user')
		$readonly = 'readonly';

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
}


if (isset($_POST['button']) && $username != 'Guest')
	{
		if ($_POST['button'] == 'update')
			{
				$textdata = $_POST['edittext'];
				$txt1 = fopen($textboardfile, 'w');
				$edittxt = fopen($editlogfile, 'a');
				fwrite($txt1, $textdata);
				$white_spaces = str_repeat(' ', 14-strlen($username));
				fwrite($edittxt, "$username$white_spaces@ $date\n");
				fclose($txt1);
				fclose($edittxt);
				header("Location: {$_SERVER['SCRIPT_NAME']}");
			}
	}

$txtfile = fopen($textboardfile, 'r');
$filecontents = fread($txtfile, filesize($textboardfile)+1);

if ($account_type == 'admin')
	echo 	"<span class='menu'>
				<a href='session.php'>$username</a>
				<a href='logs.php' target='_blank'>logs</a>
				<a href='database.php'>database</a>
			<form action='' method='POST' style='display: inline;'>
			<select name='select_board'>
				<option value='public'>public</option>
				<option value='announcements'>announcements</option>
				<option value='user'>$username</option>
			</select>
			<input type='submit' class='button' name='button' value='update'>
			</span>
			<textarea rows='30' name='edittext' spellcheck='false' $readonly>$filecontents</textarea>
			</form>";

else if ($account_type == 'user')
	echo 	"<span class='menu'>
				<a href='session.php'>$username</a>
				<form action='' method='POST' style='display: inline;'>
				<select name='select_board'>
					<option value='public'>public</option>
					<option value='announcements'>announcements</option>
					<option value='user'>$username</option>
				</select>
				<input type='submit' class='button' name='button' value='update'>
			</span>
			<textarea rows='30' name='edittext' spellcheck='false' $readonly>$filecontents</textarea>
			</form>";

else
	echo 	"<span class='menu'>
				<a href='session.php'>$username</a>
			</span>
			<textarea rows='30' spellcheck='false' $readonly>$filecontents</textarea>";

?>
<br>
<?php
require_once "headers/hend.php";
?>