<?php
session_start();
header("Content-Type: text/plain");
$account_type = $_SESSION['account'];

if ($account_type == 'admin' && isset($_SESSION['view_log']))
{
	date_default_timezone_set('America/New_York');
	$time = time();
	$year = date('Y');

	$public_log_dir = "../files/logs_01/$year/";
	$log_date = $_SESSION['view_log'];

	$monthalpha = date('F Y', $time);

	$txtfile = "$public_log_dir$log_date.txt";
	if (filesize($txtfile) > 0)
		$txtfiledata = gzuncompress(file_get_contents($txtfile));
	else exit("No logs recorded yet.");

	echo "Announcements: $monthalpha\n";
	echo $txtfiledata;
}

else header("Location: index.php");
?>

