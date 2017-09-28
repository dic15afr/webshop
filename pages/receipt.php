<div>
<style>
table {
    border-collapse: collapse;
    border: 1px solid black;
	style: text-align:center;
}
</style>
	<table bgcolor="#fff">
		<?php
		require 'connect.php';
		if($result = $db->query("SELECT * FROM shopping_cart")){
		    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
			$total = 0;
			$username = "$_SESSION[username]";
			
			echo "<tr>", "<td>","</td>";
			echo "<td>", "<br>", "<b>" , "Receipt", "</b>", "<br>", "</td>";
			echo "<td>", "</td>", "</tr>";
			
			echo "<tr>", "<td>","</td>";
			echo "<td>", "<br>", "<b>", "Webshop Deluxe", "</b>", "<br>", "</td>";
			echo "<td>", "</td>", "</tr>";
			
			echo "<tr>", "<td>","</td>";
			echo "<td>", "<br>", $username, "<br><br>", "</td>";
			echo "<td>", "</td>", "</tr>";
			
			echo "<tr>", "<td>", "<b>", "Order details: ", "</b>", "<br><br>", "</td>";
			echo "<td>", "</td>";
			echo "<td>", "</td>", "</tr>";
			foreach($rows as $row) {
				if($row['User'] == $username) {
					$price = $row['Price'];
					$quantity = $row['Quantity'];
					$product = $row['Product'];
					echo "<tr>";
					echo "<td>".$product."</td>";
					echo "<td>"."x".$quantity."</td>";
					echo "<td>"."Price: ".$price." kr"."</td>";
					echo "</tr>";
					$total = $total + ($price * $quantity);
				}
			}
			echo "<tr>", "<td>","</td>";
			echo "<td>", "<br>", "<b>","Amount paid: ", $total, " SEK", "</b>", "<br>", "</td>";
			echo "<td>", "</td>", "</tr>";
			
			echo "<tr>", "<td>","</td>";
			echo "<td>", "<br>", "Receipt number: ", rand(100000,999999), "<br><br>", "</td>";
			echo "<td>", "</td>", "</tr>";
		}	
		$sql = "DELETE FROM shopping_cart WHERE User='".$username."'";
		if($db->query($sql) == FALSE){
			echo "ERROR".$db->error;
		}
		?>
	</table>
	<?php echo "<br>"; ?>
	<input type="submit" value="Print" name="print" style="height:50px; width:100px"/>
</div>