<?php
 require "../../config/phpconfig.php";
    //include configuration file
        $table="tbl_cart";
if (isset($_POST['entry_id'])) {
    $entry_id=trim($_POST['entry_id']);
//
    $waiter_id=$_SESSION['waiter_id'];
    $cur_editid=$waiter_id;
    $pay_stat=1;
        $db = getDB();
		//
    try {
        $stmt = $db->prepare("UPDATE {$table} SET 
				pay_stat=:pay_stat, staff_id=:staff_id
				WHERE id=:entry_id ");
        $stmt->bindParam("pay_stat", $pay_stat, PDO::PARAM_STR);
        $stmt->bindParam("staff_id", $waiter_id, PDO::PARAM_STR);
        $stmt->bindParam("entry_id", $entry_id, PDO::PARAM_STR);
//
    if ($stmt->execute()) {
        $response['update_db'] = 'success';
        $response['update_msg'] = 'Entry edited succussfully!';
    } else {
        $response['update_db'] = 'error';
        $response['update_msg'] = 'Entry edit error!';
    }  
	
	  } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    //
    echo json_encode($response);
    return;
}