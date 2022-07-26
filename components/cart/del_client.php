<?php
 require "../../config/phpconfig.php";
 $cart_id=$_REQUEST['cart_id'];
 $table_name=$_REQUEST['table_name'];
 $client_name=$_REQUEST['client_name'];
 $waiter_id=$_SESSION['waiter_id'];
$tableid="_waiter_clients";

	  
	      $stmt = $user->runQuery('
	SELECT * 
	FROM _waiter_clients
	WHERE waiter_id=:waiter_id
	AND table_name=:table_name
	AND client_name=:client_name
	');
    
    $stmt->execute(array(":waiter_id"=>$waiter_id, ":table_name"=>$table_name, ":client_name"=>$client_name));
    $oresults=$stmt->fetch(PDO::FETCH_ASSOC);
    $ocount=$stmt->rowCount();
	$del_id=$oresults['id'];
	$cart_id=$oresults['cart_id'];
	  //
    if ($ocount == 1) {
  try {
	      $stmt = $user->runQuery('
	DELETE 
	FROM _waiter_clients
	WHERE id=:del_id
	AND cart_id=:cart_id
	');
	      if ($stmt->execute(array(":del_id"=>$del_id,":cart_id"=>$cart_id))) {
          $data['success_db'] = 'success';
          $data['message_db'] = 'Client successfully removed!';
      }
  } catch (PDOException $e) {
      echo '{"error":{"text":' . $e->getMessage() . '}}';
  }
      } else {
          $data['success_db'] = 'error';
          $data['message_db'] = 'Entry not found!!!';
    }
		        $db = null;
		  echo json_encode($data);
	  	  return;



//

