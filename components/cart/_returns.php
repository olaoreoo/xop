<?php require "../config/phpconfig.php"; ?>
<?php 
if (isset($_SESSION['waiter_id'])) { $waiter_id = $_SESSION['waiter_id']; 
if (!isset($_SESSION['cart_id'])) {
	$cart_id=$_SESSION['cart_id']= $user->accountCode(8);
	$stable=$_SESSION['table_name']= $user->createTableName(6);
	$sname=$_SESSION['client_name']= $user->createTableName(8);
	  } else { 
	$cart_id=$_SESSION['cart_id'];
 	$cart_id=$_SESSION['cart_id'];
$stable=$_SESSION['table_name'];
	$sname= $user->createTableName(8);

 }
		  
		  }?>