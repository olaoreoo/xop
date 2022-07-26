<?php require_once "../config/phpconfig.php";  ?>
<?php
if (isset($_SESSION['cart_id'])) {
    $cart_id = trim($_SESSION['cart_id']);
	}
try {

    $stmt = $user->runQuery("
		SELECT id 
		FROM tbl_cart 
		WHERE cart_id=:cart_id
		");
    $stmt->execute(array(":cart_id"=>$cart_id,));
    $cart_items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $c_count=$stmt->rowCount();
	if ($c_count==1) {echo $c_count." Order";}else{echo $c_count." Orders";}
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>
