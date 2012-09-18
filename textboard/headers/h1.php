<?php
	
	// Important site information
	session_start();

	date_default_timezone_set('America/New_York');
	$time = time();
	$monthyear = date('-m-Y', $time);
	$date = date('m-d-Y (h:i:s A) T', $time);

	// User information
	$username = 'Guest';
	$account_type = 'guest';

	// Authenticate user session
	if (isset($_SESSION['username']) && isset($_SESSION['account']))
	{	
		$username = $_SESSION['username'];
		$account_type = $_SESSION['account'];
	}

	// Password hashing salts
	$salt1 = 'haetg7hxi20us1b5mocd3nws07tljep3';
	$salt2 = 'wf5sd0ak826bs2rv3nbqet0bzhlma3o4';

?>
<!DOCTYPE HTML>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="/textboard/headers/style.css" />
	<title>
		Textboard
	</title>
	<link rel="icon" type="image/png" href="/textboard/files/textboard2.ico">

</head>

<body>
<a class="logo" href="index.php">_Textboard_</a>