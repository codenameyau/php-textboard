<?php
require_once "headers/h1.php";

// Public Board
if ($current_board == '0')
{
	$textboardfile = 'files/textboards/public.txt';
	$editlogfile = $public_log_dir.$monthyear.'.txt';

	$select_0 = 'selected';
	$select_1 = '';
	$select_2 = '';

	if ($account_type != 'admin' && $account_type != 'user')
		$readonly = 'readonly';

	// Create textboard and log files
	if (!is_dir($public_log_dir))
		mkdir($public_log_dir);

	if (!file_exists($editlogfile))
		{
			$edittxt = fopen($editlogfile, 'a');
			fclose($edittxt);
		}
}

// Announcements Board
else if ($current_board == '1')
{
	$textboardfile = 'files/textboards/announcements.txt';
	$editlogfile = $announce_log_dir.$monthyear.'.txt';

	$select_0 = '';
	$select_1 = 'selected';
	$select_2 = '';

	if ($account_type != 'admin')
		$readonly = 'readonly';

	if (!is_dir($announce_log_dir))
		mkdir($announce_log_dir);

	if (!file_exists($editlogfile))
		{
			$edittxt = fopen($editlogfile, 'a');
			fclose($edittxt);
		}
}

// Userboard
else
{
	$select_0 = '';
	$select_1 = '';
	$select_2 = 'selected';

	$user_dir   = substr($board_id, 6, 20);
	$user_board = substr($board_id, 0, 5);

	if (!is_dir("boards/$user_dir"))
		mkdir("boards/$user_dir");

	$textboardfile = "boards/$user_dir/$user_board.txt";

	if ($account_type != 'admin' && $account_type != 'user')
		$readonly = 'readonly';
}

// Create textboard file if somehow deleted
if (!file_exists($textboardfile))
{
	$txt1 = fopen($textboardfile, 'a');
	fclose($txt1);
}

// Event Handlers for update button
if (isset($_POST['button']) && $username != 'Guest')
	{
		if ($_POST['select_board'] != $current_board)
		{
			$select_board = $_POST['select_board'];
			$_SESSION['current_board'] = $select_board;
			header("Location: {$_SERVER['SCRIPT_NAME']}");
		}

		else if ($_POST['button'] == 'update' && $readonly == '')
		{
			$textdata = gzcompress($_POST['edittext'], 3);

			// Saving to files
			$txt1 = fopen($textboardfile, 'w');
			fwrite($txt1, $textdata, $filesizelimit);
			fclose($txt1);

			if ($current_board == '0' || $current_board == '1')
			{
				$edittxt = fopen($editlogfile, 'a');
				$white_spaces = str_repeat(' ', 14-strlen($username));
				fwrite($edittxt, gzcompress("$username$white_spaces@ $date\n", 3));
				fclose($edittxt);
			}
			
			header("Location: {$_SERVER['SCRIPT_NAME']}");
		}
	}

$filecontents = gzuncompress(file_get_contents($textboardfile));

if ($account_type == 'admin')
	echo 	"<span class='menu'>
				<a href='session.php'>$username</a>
				<a href='logs.php'>logs</a>
				<a href='database.php'>database</a>
				<form action='' method='POST' style='display: inline;'>
				<select name='select_board'>
					<option value='0' $select_0>public</option>
					<option value='1' $select_1>announcements</option>
					<option value='$username' $select_2>$username</option>
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
					<option value='0' $select_0>public</option>
					<option value='1' $select_1>announcements</option>
					<option value='$username' $select_2>$username</option>
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