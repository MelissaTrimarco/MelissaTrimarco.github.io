<?php
error_reporting(E_ALL);
session_start();
$customerId=$_SESSION["customerId"];
$orderId=$_SESSION["orderId"];
$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

//---Get max value of orderid from ordermaster ---

$sql_string="DELETE FROM orderdetail where orderId=$orderId";

$result = mysqli_query($connection, $sql_string);
if($result==false)
{
	echo "Bad value, $result<br/>"; 
	exit;
}	
$sql_string="DELETE FROM ordermaster where orderId=$orderId";

$result = mysqli_query($connection, $sql_string);
if($result==false)
{
	echo "Bad value, $result<br/>"; 
	exit;
}
//---Save orderid and orderdate in session variables ---
mysqli_close($connection);  
header('Location:A_display_orders.php');
?>
