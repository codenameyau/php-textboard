<?php
header("Content-Type: text/plain");
session_start();
$account_type = $_SESSION['account'];

if ($account_type == 'admin' || $account_type == 'mod')
{
	date_default_timezone_set('America/New_York');
	$time = time();
	$monthyear = date('-m-Y', $time);
	$monthalpha = date('F Y', $time);

	$txtfile = 'files/logs/editlog'.$monthyear.'.txt';
	$txtfiledata = fread(fopen($txtfile, 'r'), filesize($txtfile));

	echo "$monthalpha\n";
	echo $txtfiledata;
}

else header("Location: index.php");
?>

