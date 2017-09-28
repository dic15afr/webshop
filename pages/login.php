<div class="center">
<h1>Sign in</h1>
<br/>

<form method="POST" action="index.php?page=login">
Username:<br/>
<input type="text" name="username" size="25" autofocus /><br/>
Password:<br/>
<input type="password" name="password" size="25" /><br/><br/>
<input type="submit" value="Sign in" name="loggin" />
</form>
<br/><br/>


<?php
$time_passed = 0;
if(isset($_POST['loggin'])){
	if(empty($_POST['username']) || empty($_POST['password'])){
		echo "Please enter all fields";
	}else{
		include_once('connect.php');
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$saltedPW =  $password . strtolower($username);
		$hashedPW = hash('sha256', $saltedPW);
		
		$stmt = $db->prepare("SELECT * FROM users WHERE username = ? COLLATE NOCASE");
		$stmt->execute(array($username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if(!empty($row)){
			$locked = $row['Locked'];
			$time_passed = time() - $locked;
			//TODO for future development check date as well.
			if($time_passed > 15) {
				$time_passed = 0;

				
				if($row['Password'] == $hashedPW){
					$stmt = $db->prepare("UPDATE users SET Attempts = 0, Locked = 0 WHERE Username = ?");
					$stmt->execute(array($username));
					$_SESSION['username'] = $row['Username'];
					$_SESSION['login'] = true;
					header("Location: index.php");
				} else {
					echo "The password you entered is incorrect!\n";
					
					$failed_attempts = $row['Attempts'] + 1;
					$sql = "UPDATE users SET Attempts = ?, Locked = ? WHERE Username = ?";
					$time = 0;
					
					if($failed_attempts > 2) {
						echo "<br>"."Your account have been locked for 15 seconds!";
						$sql = "UPDATE users SET Attempts = ?, Locked = ? WHERE Username = ?";
						$time = time();
					}
					
					$stmt = $db->prepare($sql);
					$stmt->execute(array($failed_attempts, $time, $username));
					$stmt->execute();
				}
				
			} else {
				echo "Your account is still locked!";
			}
		}else{
			echo "User ".$username." does not exist!";
		}
	}
}
?>


<p id="lock" style="text-align: center;"></p>
</div>
<script>
	var period = "<?php echo 15 - $time_passed ?>";
	if(period != 15 ) {
		var x = setInterval(function() {
			document.getElementById("lock").innerHTML = "Locked for " + period + " seconds";
			period = period - 1;
			if (period < 0) {
				clearInterval(x);
				document.getElementById("lock").innerHTML = "You can try again now.";
			}
		}, 1000);
	}
</script>