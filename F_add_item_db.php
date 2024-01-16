<?php
error_reporting(E_ALL);
session_start();
$customerId=$_SESSION["customerId"];
$orderId = $_SESSION["orderId"];
$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );
$partId=$_SESSION["selItem"];
$qty=$_SESSION["txtqty"];
//---Get max value of orderid from ordermaster ---
$sql_string="SELECT MAX(orderitemNum) as 'orderitemNum' FROM orderdetail where orderId=$orderId ";

$result = mysqli_query($connection, $sql_string);
$row_cnt = mysqli_num_rows($result);

if($result==false)
{
	echo "Bad value, $result<br/>"; 
	exit;
}
	
if($row_cnt==0)
{
	$orderitemNum = 1;
}
else
{	
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

	while($row != NULL)
	{   
    	$orderitemNum = $row["orderitemNum"];
    	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	}
	$orderitemNum++;
}
//---Insert into orderdetail table ---
$sql_string="INSERT INTO orderdetail VALUES ($orderId, $orderitemNum,$partId,$qty)";
$result = mysqli_query($connection, $sql_string);

//---Refresh inventory table---
$sql_string="update inventory set partQty=partQty-$qty where partId=$partId";
$result = mysqli_query($connection, $sql_string);
mysqli_close($connection);  
header('Location:C1_display_one.php');
?>
