<?php
require_once "../../config/phpconfig.php";

$cart_id = $_POST['trans_id'];// echo $cart_id;
$prod_qty = $_POST['trans_val']; //echo $prod_qty;
$prod_tot = $_POST['prod_tot']; //echo $prod_tot;
$prod_id = $_POST['prod_id']; //echo $cart_id;
$prod_price = $_POST['prod_price']; //echo $cart_id;

//update database
$db = getDB();
$stmt = $db->prepare("UPDATE tbl_cart SET qty={$prod_qty}, prod_tot={$prod_tot} WHERE id={$cart_id}  ");
if ($stmt->execute()) {
    //
    $data['cart_id'] = $cart_id;
    $data['prod_qty'] = $prod_qty;
    $data['prod_tot'] =   number_format($prod_tot,0);
    $data['success_db'] = "success";
    $data['message_db'] = "Order successfully submitted";
} else {
    $data['prod_qty'] = $prod_qty;
    $data['success_db'] = "error";
    $data['message_db'] = "There was an error with your order";
}


//
$cust_id = $_SESSION['cust_id']; //echo $cart_id;

				$stmt = $user->runQuery("SELECT * FROM tbl_cart WHERE cust_id={$cust_id} ");
				$stmt->execute();
				$gt_result=$stmt->fetchAll(PDO::FETCH_ASSOC);
$grand_total=0;
      foreach ($gt_result as $row) { 
	  $prod_tot=$row['prod_tot'];
	  $grand_total=$grand_total+$prod_tot;
	      //$data['grand_total'] =  number_format($grand_total);
	      $data['grand_total'] =  number_format($grand_total,0);
	  }
$db = null;
echo json_encode($data);
return;