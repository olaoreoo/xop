<?php require_once "../config/phpconfig.php";  ?>
<?php
if (isset($_SESSION['cart_id'])) {
    $cart_id = trim($_SESSION['cart_id']);
	}
try {

    $stmt = $user->runQuery("
		SELECT *
		FROM tbl_cart 
		WHERE cart_id=:cart_id
		");
    $stmt->execute(array(":cart_id"=>$cart_id,));
    $cart_items=$stmt->fetchAll(PDO::FETCH_ASSOC);
$prod_total_val=0;
	foreach ($cart_items as $data) { 	
	$prod_id=$data['id'];
	$prod_price=$data['prod_price'];
	$prod_total=$data['prod_tot'];
	$prod_total_val=$prod_total_val+$data['prod_tot'];
	}
	echo $user->fmtCurDisp($prod_total_val); 
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>
