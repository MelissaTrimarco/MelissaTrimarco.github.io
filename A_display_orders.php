<?php
error_reporting ( E_ALL );
session_start ();
if (isset ( $_SESSION ["customerId"] ))
	$customerId = $_SESSION ["customerId"];
else
	$customerId = $_REQUEST ["selcustomer"];

$_SESSION ["customerId"] = $customerId;
$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

//---Customer information---
$sql_string = "select * from customers where customerId =$customerId";

$result = mysqli_query ( $connection, $sql_string );
if ($result == false)
{
	echo "Bad value, $result<br/>";
	exit ();
}

$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );

while ( $row != NULL )
{
	$companyName = $row ["companyName"];
	$address = $row ["address"];
	$city = $row ["city"];
	$state = $row ["state"];
	$zipcode = $row ["zipcode"];
	$phone = $row ["phone"];
	$custmsg = "$companyName<br/>$address<br/>$city, $state $zipcode<br/>$phone<br/>
				Customer ID: $customerId";
	$_SESSION ["custmsg"] = $custmsg;
	$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
}
?>
<!DOCTYPE html>
<html>

<body>

	<h2 style='background:aquamarine' >Trimarco's Term Project - List of Orders</h2>
	<div id='allowMargins'>
			
			<h3>A1-Caterers</h3>
			<p><?php echo $custmsg?></p>						
			<form action='B_process_order.php' method='post'>
				<p>Here are the list of all the orders you have placed.
					Select an order for modification or deletion, or add a new order.</p>
<?php						
// ---Customer order list---
	$sql_string = "select * from customers c, ordermaster om where c.customerId =$customerId and c.customerId = om.customerId ";
	$result = mysqli_query ( $connection, $sql_string );
    if ($result == false)
		{
		    echo "Bad value, $result<br/>";
		    exit ();
		}
						
		$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
		echo "<table border='2' cellpadding='7px' style='border-collapse: collapse;'>
				<tr>
					<th style='background:orchid'>Select </th>
					<th style='background:orchid'>Order Id</th>
					<th style='background:orchid'>Order Date</th>
		        </tr>";
    $colors = array ("snow","white");
    $rn = 0;
	while ( $row != NULL )
		{
		    $rn ++;
			$orderId = $row ["orderId"];
			$orderDate = $row ["orderDate"];
			$csub = $rn % 2;
	     echo "
   		 		<tr style='background:$colors[$csub]'>
    				<td><input type='radio' name='selOrder' value='$orderId'checked='checked'/></td>
						<td>$orderId</td>
        				<td>$orderDate</td>
    			</tr>  ";
	     $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
		}
		mysqli_close ( $connection );
		echo "</table><p></p>"
?>

		<table border="2" style="border-collapse: collapse;">
			<tr>
				<td><input type="radio" name="orderAction" value="VM"
					checked="checked" />View/Modify Order&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><input type="radio" name="orderAction" value="A" />Add new
					Order&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><input type="radio" name="orderAction" value="D" />Delete
					Order&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
	</table>
<p></p>
<input type="submit" />
		</form>
		<p></p>
<a  href="index.php">Trimarco's Term Project Home Page</a>

<p></p>

</div>
</body>

</html>