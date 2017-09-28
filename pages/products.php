<h1>Products</h1> 
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
    <table> 
        <tr> 
            <th>Image</th> 
            <th>Name</th>
			<th>Description</th>
            <th>Price (SEK)</th> 
			<th>Quantity</th>
        </tr> 
		<?php 		
		
		require 'connect.php';
		$result = $db->query("SELECT * FROM products");
		if(isset($_POST['search'])){
			$search = $_POST['searchField'];
			if($search != "") {
				if($secure) {
				    $result = $db->prepare("SELECT * FROM Products WHERE Name LIKE ? COLLATE NOCASE");
				    $result->execute(array($search . "%"));
					
				} else {
					$sql = "SELECT * FROM products WHERE Name LIKE'".$search."' COLLATE NOCASE";
					$result = $db->query($sql);
				}
			}
		}
		if($result){
			
		    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$Name = $row['Name'];
			$Image = $row['Pic'];
			$Price = $row['Price'];
			$Description = $row['Description'];
			echo "<tr><td>";
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $Image ).'" style="width:100px;height:100px;"/>';
			echo "</td>";
			echo "<td>".str_replace("_"," ",$Name)."</td>";
			echo "<td>".$Description."</td>";
			echo "<td>".$Price."</td>";
			echo "<td><form method=\"POST\">";
			echo "<input type= text name='".$Name.$Name."' size=3/>";
			echo "   ";
			echo "<input type=\"submit\" value=\"Add to cart\" name=\"".$Name."\"/></form></td></td></tr>";
			if(isset($_POST[$Name])){
				if (isset($_SESSION['login'])) {
					$username = "$_SESSION[username]";
					$quantity = $_POST[$Name.$Name];
					if (is_numeric($quantity)) {
					    $stmt = $db->prepare("SELECT * FROM shopping_cart WHERE User = ? AND Product = ? LIMIT 1");
					    $stmt->execute(array($username,$Name));
					    $row = $stmt->fetch(PDO::FETCH_ASSOC);
						$current_quantity = 0;
						
						if(!empty($row)){
							$current_quantity = $row['Quantity'];
							$update = $db->prepare("UPDATE shopping_cart SET Quantity = ? WHERE User = ? AND Product = ?");
							$succ = $update->execute(array($current_quantity + $quantity,$username,$Name));
						}else{
						    $insert = $db->prepare("INSERT INTO shopping_cart(Product,Price,User,Quantity) VALUES(?, ?, ?, ?)");
						    $succ = $insert->execute(array($Name,$Price,$username,$quantity));
						}
	
						if($succ){
							echo "$Name has been added to your cart";
						}else{
							echo "Error";
						}
					} else {
						echo "Quantity must be a number!";
					}
				}else {
					echo "You need to sign in in order to add new products to your cart!";
				}
			}
		}
	} else {
		echo "Error! Please try again!.";
	} 
?>

    </table>
	<br>
	<br>
</body>
