<?php
session_start ();
session_unset ();
?>

<!DOCTYPE html>
<html>

<body>

	<h2 style='background:aquamarine'>Trimarco's Term Project - Home page</h2>
	<div id='allowMargins'>
			<h3>A1-Caterers</h3>
			<p>Welcome to A1-Caterers! Click customer's name to check your
				orders, change existing orders and place new orders.</p>
 <?php
	
	$connection = mysqli_connect ( "localhost", "cis261920_09", "crpv", "cis261920_09" );
	
	$sql_string = "select * from customers order by customerId";
	
	$result = mysqli_query ( $connection, $sql_string );
	if ($result == false)
	{
		echo "Bad value, $result<br/>";
		exit ();
	}
	
	$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
?>
<form action='A_display_orders.php' method='post'>

				<table border="2" style="border-collapse: collapse;">					
						<tr>
							<th style='background:orchid'>Select</th>
							<th style='background:orchid'>Company Name</th>
							<th style='background:orchid'>Phone</th>
						</tr>					
<?php
$colors = array ("snow", "white");
$rn = 0;
while ( $row != NULL )
{
	$rn ++;
	$customerId = $row ["customerId"];
	$companyName = $row ["companyName"];
	$phone = $row ["phone"];
	$csub = $rn % 2;
	echo "
    <tr style='background:$colors[$csub]'>
    		<td><input type='radio' name='selcustomer' value='$customerId'checked='checked'/></td>							
    		<td>$companyName</td>
        <td>$phone </td>
    </tr>
    ";
	$row = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
}
mysqli_close ( $connection );
?>
</table>
				<p></p>
				<input type='submit' value='Retrieve Orders' />
			</form>
			<p></p>

</div>
</body>

</html>