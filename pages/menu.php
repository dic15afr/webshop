<nav class="meny">
	<a href="?page=home">Home</a>
	<a href="?page=products">Products</a>
	
	<?php if(isset($_SESSION['login'])){ 
	echo '<a href="pages/logout.php">Sign out</a>';
	}else{
	echo '<a href="?page=register">Register</a>
	<a href="?page=login">Sign in</a>';
	} ?>
	
	<div style="float: right;">
	<a href="?page=feedback">Feedback</a>
	<a href="?page=shoppingcart">Shopping cart</a>
	</div>
</nav>