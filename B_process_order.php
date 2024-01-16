<?php
error_reporting(E_ALL);
session_start();
$_SESSION["orderId"]=$_REQUEST["selOrder"];
$orderAction= $_REQUEST["orderAction"];
$location="";
switch($orderAction)
{
	case "VM":	$location="C1_display_one.php";
				break;
	case "A":	$location="C2_add_db.php";
				break;
	case "D":	$location="C3_delete_db.php";
				break;
}

header("Location:$location");
?>
