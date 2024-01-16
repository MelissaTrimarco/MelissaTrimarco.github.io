<?php
error_reporting ( E_ALL );
session_start ();
$customerId = $_SESSION ["customerId"];
$orderId = $_SESSION ["orderId"];
$custmsg=$_SESSION ["custmsg"];
// retrieve order date
$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

// --- Customer information ---
$sql_string = "select orderDate from ordermaster where orderId =$orderId";

$result = mysqli_query ( $connection, $sql_string );
if ($result == false)
{
	echo "Bad value, $result<br/>";
	exit ();
}
$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );

while ( $row != NULL )
{
	$orddate = $row ["orderDate"];
	$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
}
$_SESSION ["orddate"] = $orddate;
?>

<!DOCTYPE html>
<html>
<body>

	<h2 style='background:aquamarine'>Trimarco's Term Project</h2>
	<div id='allowMargins'>

		<h3>A1-Caterers</h3>
		<p>
			<?php echo $custmsg?>
		</p>
		<p>
			Details of Order #
			<?php echo $orderId?>
		</p>
		<form action='D_delete_item_db.php' method='post'>
			
<?php
// ------Customer order list----
$sql_string = "select i.partDescription, od.orderitemNum, od.partQtyOrdered from inventory i, orderdetail od
			  where od.orderId=$orderId and od.partId=i.partId ";
$result = mysqli_query ( $connection, $sql_string );
if ($result == false)
    {
		echo "Bad value, $result<br/>";
		exit ();
	}
$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
?>
	<table border='2' style='border-collapse: collapse;'>
		<tr>
			<th style='background:orchid'>Select Order Item <br />Delete</th>
			<th style='background:orchid'>Order Item #</th>
			<th style='background:orchid'>Item Description</th>
			<th style='background:orchid'>Quantity</th>
		</tr>
<?php
$colors =array ("snow", "white");	
$rn = 0;
while ( $row != NULL )
{
	$rn ++;
	$orderitemNum = $row ["orderitemNum"];
	$desc = $row ["partDescription"];
	$qty = $row ["partQtyOrdered"];
	$csub = $rn % 2;
	echo "
		<tr style='background:$colors[$csub]'>
			<td><input type='radio' name='delOrderitem' value='$orderitemNum'checked='checked'/></td>
			<td>$orderitemNum</td>
			<td>$desc</td>
			<td>$qty</td>
		</tr>
		";
    $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
}
	mysqli_close ( $connection );
?>
    </table>
   <p></p>
  <input type="submit" value="Delete Order Item" />
</form>
    <form action="E_display_add_item.php">
        <input type="submit" value="Add order item" />
    </form>
<p></p>
    <form action="A_display_orders.php" method="post">
		<input type="submit" value="Go back to Customer Orders" />
	</form>
<p></p>
		<a href="index.php">Trimarco's Term Project Home Page</a>

	</div>
</body>
</html>
