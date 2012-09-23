<?php
require_once "headers/h1.php";

// Public Board
if ($current_board == '0')
{
	$textboardfile = 'files/textboards/public.txt';
	$editlogfile = "files/textboard_logs/log$monthyear.txt";
	$select_0 = 'selected';
	$select_1 = '';
	$select_2 = '';

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
else if ($current_board == '1')
{
	$textboardfile = 'files/textboards/announcements.txt';
	$editlogfile = "files/announce_logs/log$monthyear.txt";
	$select_0 = '';
	$select_1 = 'selected';
	$select_2 = '';

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
	$select_0 = '';
	$select_1 = '';
	$select_2 = 'selected';

	$use_board_id = $board_id;
	$user_dir   = substr($use_board_id, 6, 20);
	$user_board = substr($use_board_id, 0, 5);

	$textboardfile = "boards/$user_dir/$user_board.txt";

	if ($account_type != 'admin' && $account_type != 'user')
		$readonly = 'readonly';

	if (!file_exists($textboardfile))
		{
			$txt1 = fopen($textboardfile, 'a');
			fclose($txt1);
		}
}

if (isset($_POST['button']) && $username != 'Guest')
	{
		if ($_POST['select_board'] != $current_board)
		{
			$select_board = $_POST['select_board'];
			$_SESSION['current_board'] = $select_board;
			header("Location: {$_SERVER['SCRIPT_NAME']}");
		}

		if ($_POST['button'] == 'update' && $readonly == '')
		{
			$textdata = $_POST['edittext'];

			// Open Files
			$txt1 = fopen($textboardfile, 'w');
			$edittxt = fopen($editlogfile, 'a');
			
			fwrite($txt1, $textdata, $filesizelimit);
			
			$white_spaces = str_repeat(' ', 14-strlen($username));
			fwrite($edittxt, "$username$white_spaces@ $date\n");
			
			// Close files
			fclose($txt1);
			fclose($edittxt);
			
			header("Location: {$_SERVER['SCRIPT_NAME']}");
		}
	}

$filecontents = file_get_contents($textboardfile);

if ($account_type == 'admin')
	echo 	"<span class='menu'>
				<a href='session.php'>$username</a>
				<a href='logs.php' target='_blank'>logs</a>
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