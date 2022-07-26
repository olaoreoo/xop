<?php
 require "../config/phpconfig.php";
$cart_id=$_GET['cart_id'];
$table_id="tbl_cart";
      $db = getDB();
//
  try {
      $sql ="DELETE FROM tbl_cart WHERE cart_id='{$cart_id}'";
      $stmt = $db->prepare($sql);
      if ($stmt->execute()) {
          $data['success_db'] = 'success';
          $data['message_db'] = 'Entry was successfully deleted !';
      }   else {
          $data['success_db'] = 'error';
          $data['message_db'] = 'Entry not found!!!';
    }


  } catch (PDOException $e) {
      echo '{"error":{"text":' . $e->getMessage() . '}}';
  }
      $db = null;
		  echo json_encode($data);

session_destroy();
if ((function_exists('session_status')
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
}
    $newcart_id =  $user->create_cart_id(8);
	$_SESSION['cart_id']=$cart_id=$newcart_id;

	  	  return;

//

