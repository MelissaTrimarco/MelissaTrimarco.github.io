<?php
error_reporting(E_ALL);
session_start();
$orderitemNum=$_SESSION["delOrderitem"];
$orderId=$_SESSION["orderId"];
$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

//---Get max value of orderid from ordermaster ---
$sql_string="DELETE FROM orderdetail where orderitemNum=$orderitemNum and orderid=$orderId";

$result = mysqli_query($connection, $sql_string);
if($result==false)
{
	echo "Bad value, $result<br/>"; 
	exit;
}	

//---Save orderid and orderdate in session variables ---
mysqli_close($connection);  
header('Location:C1_display_one.php');
?>
