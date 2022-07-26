<?php
require_once "../../config/phpconfig.php";
//$cart_id = $_POST['cart_id'];
//$prod_id = $_POST['prod_id'];
$action_id = $_GET['action_id'];
//$prod_tot = $_POST['prod_tot' . $prod_id];
//$prod_pri = $_POST['prod_pri'];
//echo $action_id;
if ($action_id == "add") {
    $prod_qty = $_POST['pqty' . $prod_id] + 1;
    $prod_tot = $prod_tot + $prod_pri;
    $prod_totd = number_format($prod_tot);
} elseif ($action_id == "sub") {
    $prod_qty = $_POST['pqty' . $prod_id] - 1;
    $prod_tot = ($prod_tot - $prod_pri);
    $prod_totd = number_format($prod_tot);
} else {
    $prod_qty = $_POST['pqty' . $prod_id];
}
//update database
$db = getDB();
$stmt = $db->prepare("UPDATE tbl_cart SET qty='{$prod_qty}', prod_tot='{$prod_tot}' WHERE cart_id='{$cart_id}' AND prod_id='{$prod_id}'  ");
if ($stmt->execute()) {
    //
    $data['cart_id'] = $cart_id;
    $data['prod_id'] = $prod_id;

    $data['prod_qty'] = $prod_qty;
    $data['prod_tot'] = $prod_tot;
    $data['prod_totd'] = $prod_totd;
    $data['success_db'] = "success";
    $data['message_db'] = "Order successfully submitted";
} else {
    $data['prod_qty'] = $prod_qty;
    $data['success_db'] = "error";
    $data['message_db'] = "There was an error with your order";
}

$db = null;
echo json_encode($data);
return;
