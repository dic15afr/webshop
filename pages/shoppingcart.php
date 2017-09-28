<div style="width:100%;">
    <div style="width:400px; float: left;">
		<h1>Shopping cart</h1>
		<br/>
		<table border = 1 style = 'text-align:center'>

			<?php
			require 'connect.php';
			
			$total = 0;

				if(isset($_SESSION['login'])){
					$username = "$_SESSION[username]";
					
					if($result = $db->query("SELECT * FROM shopping_cart WHERE User='$username'")){
					    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
					    echo "<th><b>Product</b></th>";
					    echo "<th><b>Price (SEK)</b></th>";
					    echo "<th><b>Quantity</b></th>";
					    foreach($rows as $row) {
					        $price = $row['Price'];
					        $quantity = $row['Quantity'];
					        $product = $row['Product'];
					        echo "<tr>";
					        echo "<td>".$product."</td>";
					        echo "<td>".$price."</td>";
					        echo "<td>".$quantity."</td>";
					        echo "<td>"."<form method=POST><input type= submit value=  X  name=$product></form>"."</td>";
					        echo "</tr>";
					        $total = $total + ($price * $quantity);
					        if(isset($_POST[$product])){
					            $sql = "DELETE FROM shopping_cart WHERE Product='".$product."' AND User='".$username."'";
					            if($db->query($sql)){
					                header("Refresh:0");
					            } else {
					                echo "ERROR".$db->error;
					            }
					        }
					    }
					    echo "Total cost: ", $total, " SEK", "<br>";
					}
					
				} else {
					echo 'Please sign in to proceed';
				}

			
			?>
		</table>
	</div>
    <div style="width:400px; float: right;">
		<h1>Payment</h1>
		<?php if($total == 0) {
			echo "<br>You don't have any items to pay for!";
		}else{?>
		<form method="POST" action="index.php?page=shoppingcart">
		Card number:<br/>
		<input type="text" name="cardnumber" size="25" autofocus/><br/>
		Name on card:<br/>
		<input type="text" name="nameoncard" size="25"/><br/>
		Valid to (mm/yy):<br/>
		<input type="text" name="validto" size="25"/><br/><br/>
		<input type="submit" value="Make payment" name="pay"/>
		</form>
		<br/><br/>
		<?php
		}
			if(isset($_POST['cardnumber'])){
				if(empty($_POST['cardnumber']) || empty($_POST['nameoncard']) || empty($_POST['validto'])){
					echo "Please enter all fields";
				} else {
					header("Location: index.php?page=receipt");
				}
			}
		?>
	</div>
</div>


