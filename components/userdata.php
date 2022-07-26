<?php require_once "../config/phpconfig.php";  ?>
<?php
if (isset($_SESSION['cart_id'])) {
    $cart_id = trim($_SESSION['cart_id']);
} else {
    $newcart_id =  $user->create_cart_id(8);
	$_SESSION['cart_id']=$cart_id=$newcart_id;
	}

try {

    $stmt = $user->runQuery("
		SELECT * 
		FROM tbl_cart 
		WHERE cart_id=:cart_id
		ORDER BY add_time DESC
		");
    $stmt->execute(array(":cart_id"=>$cart_id,));
    $cart_items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $c_count=$stmt->rowCount();
	$prod_total=$c_count;
	
	if ($c_count>0) {
		
			$cart_total_val=0; 			$prod_total_val=0; 
	foreach ($cart_items as $data) { 
	$cart_total_val=$cart_total_val+$prod_total_val;
	
	$prod_id=$data['id'];
	$prod_price=$data['prod_price'];
	$prod_total_val=$data['prod_tot'];
	$cart_total_val=$prod_total*$prod_price;
	}
	} else {
		$cart_total_val=0;
	}
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>
