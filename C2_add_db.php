<?php
error_reporting(E_ALL);
session_start();
$customerId=$_SESSION["customerId"];

$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

//--- Get max value of orderid from ordermaster ---

$sql_string="SELECT MAX(orderid) as 'orderId' FROM ordermaster";

$result = mysqli_query($connection, $sql_string);
if($result==false)
{
	echo "Bad value, $result<br/>";
	exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

while($row != NULL)
{
	$orderId = $row["orderId"];
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
}
$orderId++;
//---Create today's date as orderdate---
$today=mktime();
$orddate=date("Y-d-m");
//---Store orderdate and orderid
$_SESSION["orderId"] = $orderId;
$_SESSION["orddate"] = $orddate;

$sql_string="INSERT INTO ordermaster
VALUES ($orderId, $customerId, '$orddate')";
$result = mysqli_query($connection, $sql_string);
mysqli_close($connection);
header('Location:E_display_add_item.php');
?>
