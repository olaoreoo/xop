<?php
 require "../../config/phpconfig.php";
$entry_id=$_REQUEST['itemid'];
$table_id="tbl_cart";
      $db = getDB();
//
    $stmt = $db->prepare("SELECT * FROM  {$table_id}  WHERE id={$entry_id} ");
        $stmt->execute();
            $count = $stmt->rowCount();
        //echo json_encode($count);
    if ($count == 1) {
  try {
      $sql ="DELETE FROM {$table_id}   WHERE id={$entry_id}";
      $stmt = $db->prepare($sql);
      if ($stmt->execute()) {
          $data['success_db'] = 'success';
          $data['message_db'] = 'Entry was successfully deleted !';
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

