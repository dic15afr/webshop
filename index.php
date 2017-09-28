<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<title>Webshop</title>
<link href="pages/stilmall.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div id="wrapper">

<header>
Webshop Deluxe
</header>

<?php include ('pages/menu.php'); ?>

<article>
<?php
$page = 'start';
if(isset($_GET['page'])){
	$page = $_GET['page'];
}
$secure = TRUE;
switch($page){
	case 'home': include('pages/home.php');
	break;
	
	case 'products': include ('pages/products.php');
	break;
	
	case 'login': include('pages/login.php');
	break;
	
	case 'register': include('pages/register.php');
	break;
	
	case 'shoppingcart': include('pages/shoppingcart.php');
	break;
	
	case 'receipt': include('pages/receipt.php');
	break;
	
	case 'feedback': include('pages/feedback.php');
	break;
	
	default: include('pages/home.php');
	break;
}	
?>
</article>

<footer>
<?php if(isset($_SESSION['login'])){echo "Signed in as: $_SESSION[username] <br/>";}?>
Webshop by: Albin Fridh, Ahmed Abbas, Carl Dahl, Christian Golcic
</footer>

</div>

</body>
</html>