<div class="center">
<h1>Register new user</h1><br/>
	
<form method="POST" action="index.php?page=register">
Username:<br/>
<input type="text" name="username" size="25" autofocus /><br/>
Password:<br/>
<input type="password" name="password" size="25"/><br/><br/><br/>


Address:<br/>
<input type="text" name="address" size="25"/><br/>
Zip/Postal code:<br/>
<input type="text" name="zipcode" size="25"/><br/>
City:<br/>
<input type="text" name="city" size="25"/><br/><br/>
<input type="submit" value="Create Account!" name="add"/>
</form>
<br/><br/>

<?php	
	
if(isset($_POST['username'])){
	
	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['address']) || empty($_POST['zipcode']) || empty($_POST['city'])){
	    echo "Please enter all fields";
	}else{

	    include_once('connect.php');
		$username = $_POST['username'];
		$password = $_POST['password'];
		$address = $_POST['address'];
		$zipcode = $_POST['zipcode'];
		$city = $_POST['city'];
		
		$stmt = $db->prepare("SELECT Username FROM users WHERE Username = ? COLLATE NOCASE");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($row)){
		    echo "User already exists";
		}else{
		    if (preg_match('/^([a-zA-Z0-9+-@*#_]{6,30})$/', $password)){
		        $stmt = $db->prepare("SELECT password FROM blacklist WHERE password = ?");
		        $stmt->execute(array($password));
		        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		        
		        if(!empty($row)){
		            echo "Blacklisted password. Please select a different one";
		        }else{
		            $saltedPW =  $password . strtolower($username);
        		    $hashedPW = hash('sha256', $saltedPW);
        		    
                    $stmt = $db->prepare("INSERT INTO users(Username,Password,Address,Zip,City) VALUES(?, ?, ?, ?, ?)");
                    $test = $stmt->execute(array($username, $hashedPW, $address, $zipcode, $city));
        			
                    if($test){
                        header("Location: index.php?page=login");
                    }else{
                        echo "Error, try again";
                    }
		        }
		    }else{
		        echo "Password can only contain alfanumeric characters, +-@*#_ and must be between 6 and 30 characters long";
		    }
	   }
	   
    }
}
?>
</div>