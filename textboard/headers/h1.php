<?php
	
	// Important site information
	session_start();

	date_default_timezone_set('America/New_York');
	$time = time();
	$monthyear = date('m-Y', $time);
	$date = date('m-d-Y (h:i:s A)', $time);
	$year = date('Y', $time);

	// User information
	$username = 'Guest';
	$account_type = 'guest';
	
	// Textboard Information
	$current_board = '1';
	$board_id = 0;
	$user_dir = '';
	$user_board = '';
	$readonly = '';
	$filesizelimit = 3145728;

	// Log Information
	$public_log_dir = "files/logs_00/$year/";
	$announce_log_dir = "files/logs_01/$year/";

	// Authenticate user session
	if (isset($_SESSION['username']) && isset($_SESSION['account']))
	{
		$current_board = $_SESSION['current_board'];
		$username = $_SESSION['username'];
		$account_type = $_SESSION['account'];
		$board_id   = $_SESSION['board_id'];
	}

	function checkEmail( $email )
	{	
    	return filter_var( $email, FILTER_VALIDATE_EMAIL );
	}

?>
<!DOCTYPE HTML>
<html>
<head>

	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="/textboard/headers/style.css" />
	<title>
		Textboard - <?php echo $username; ?>
	</title>
	<link rel="icon" type="image/png" href="/textboard/files/textboard2.ico">

</head>

<body id="wrapper">
<a class="logo" href="index.php">_Textboard_</a>