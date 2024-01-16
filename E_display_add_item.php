<?php
error_reporting ( E_ALL );
session_start ();
$customerId = $_SESSION ["customerId"];
$orderId = $_SESSION ["orderId"];
$orddate = $_SESSION ["orddate"];
$custmsg = $_SESSION ["custmsg"];
$msg = "";
if (isset ( $_POST ["submit"] ))
{
	$txtqty = $_POST ["txtqty"];
	if (trim ( $txtqty ) == "")
		$msg = "**Quantity cannot be empty**";
	else
	{
		$txtqty = trim ( $txtqty );
		if (is_numeric ( $txtqty ) == false)
			$msg = "**Quantity must be a number**";
		else
			{
				session_start ();
				$_SESSION ["txtqty"] = $txtqty;
				$_SESSION ["selItem"] = $_POST ["selItem"];
				header ( 'Location:F_add_item_db.php' );
				exit ();
			}
		}
	}
else
{
	$txtqty = "";
	$msg = "";
}

$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );

?>
<!DOCTYPE html>
<html>

<body>

	<h2 style='background:aquamarine'>Trimarco's Term Project </h2>
	<div id='allowMargins'>
			
			<h3>A1-Caterers</h3>

			<p>Welcome to A1-Caterers. Adding order items for Order # <?php echo $orderId?></p>
			<h3>Order date: <?php echo $orddate?></h3>
			<p >Enter details for order item in the order.</p>
			<form action="E_display_add_item.php" method="post">	  
<?php
// ----Create an inventory table ---
$sql_string = "select * from inventory";

$result = mysqli_query ( $connection, $sql_string );
if ($result == false)
{
	echo "Bad value, $result<br/>";
	exit ();
}

$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
?>
  <br />
		<table border="1" style="border-collapse: collapse;">
			<tr>
				<th style='background:orchid'>Select Item</th>
				<th style='background:orchid'>Part Id</th>
				<th style='background:orchid'>Part Description</th>
				<th style='background:orchid'>Sales Cost</th>
				<th style='background:orchid'>Quantity<br />On hand</th>
			</tr>
<?php
$colors = array ("snow", "white");
$rn = 0;
while ( $row != NULL )
{
	$rn ++;
	$partId = $row ["partId"];
	$partDescription = $row ["partDescription"];
	$partSalesCost = $row ["partSalesCost"];
	$partQty = $row ["partQty"];
	$csub = $rn % 2;
echo "
    <tr style='background:$colors[$csub]'>
    		<td><input type='radio' name='selItem' value='$partId'checked='checked'/></td>							
    		<td>$partId</td>
        	<td>$partDescription</td>
			<td>$partSalesCost</td>
			<td>$partQty</td>
    </tr>";
	$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
}
mysqli_close ( $connection );
?> 
</table>
		<p>Enter Quantity: <input type='text' name='txtqty' size='4' value='
<?php if(isset($_POST["submit"])) echo $txtqty ?>' />
<?php if(isset($_POST["submit"])) echo "<span class='small_text_red'>$msg</span>"; ?>
       </p>
<p></p>
	<input type='submit' value='Add item & return' name="submit" />
  </form>
<p></p>
<a href="index.php">Trimarco's Term Project Home Page</a>

</div>
</body>
</html>