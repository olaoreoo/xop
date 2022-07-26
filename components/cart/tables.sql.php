<?php require "../../config/phpconfig.php";
if (isset($_SESSION['waiter_id'])) {
    $waiter_id = $_SESSION['waiter_id'];
    $pay_stat=0;
    $wcartTotal=$user->wcartTotal($waiter_id);
    $waiter_name=$user->getWaiterName($waiter_id);
	
 try {
        $stmt = $user->runQuery("
			SELECT * 
			FROM _waiter_clients 
			WHERE waiter_id={$waiter_id} 
			GROUP BY cart_id");
        $stmt->bindParam("cart_id", $cart_id, PDO::PARAM_STR);
        $stmt->execute();
        $table_result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $table_count = $stmt->rowCount();

//insert code for rowCount to var
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
}


