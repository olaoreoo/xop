<?php

if (!$user->is_logged_in()) {
$user->redirect('account.php?action=login&prevUrl=menu');
} 
             if (isset($_SESSION['waiter_id'])) {
                 $waiter_id=$_SESSION['waiter_id'];
             }
			 
			 
if (isset($_SESSION['cart_id'])) {
				 	
	if (isset($_GET['cart_id'])) {$_SESSION['cart_id'] =$cart_id = trim($_GET['cart_id']);
} elseif (isset($_SESSION['cart_id'])) {    $cart_id=$_SESSION['cart_id']; }

if (isset($_GET['table_name'])) { $_SESSION['table_name'] =$table_name = trim($_GET['table_name']);
} elseif (isset($_SESSION['table_name'])) { $table_name=$_SESSION['table_name'];
} else {$table_name=""; }

if (isset($_GET['client_name'])) { $_SESSION['client_name'] =$client_name = trim($_GET['client_name']);
} else { 

if (isset($_SESSION['client_name'])) {
	
	$client_name=$_SESSION['client_name'];
}
}

/////////////////////////////////////////////////////////// get  clients list

//$_SESSION['client_name']=null;
try {
//
    $stmt = $user->runQuery('
	SELECT * 
	FROM _waiter_clients 
	WHERE waiter_id=:waiter_id
	AND cart_id=:cart_id
	
	');
    
    $stmt->execute(array(":waiter_id"=>$waiter_id, ":cart_id"=>$cart_id));
    $w_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $w_count=$stmt->rowCount();
    //
if (isset($_REQUEST['cart_id']))  {
    $stmt = $user->runQuery('
		SELECT * 
	FROM tbl_cart 
	WHERE waiter_id=:waiter_id
	AND label=:label
	AND cart_id=:cart_id
	AND tlabel=:tlabel	
	');
    $stmt->execute(array(":waiter_id"=>$waiter_id, ":cart_id"=>$cart_id, ":label"=>$table_name, ":tlabel"=>$client_name));
    $o_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $o_count=$stmt->rowCount();	
	}

	
	
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
			 
				 } else {
					  $cart_id=null; 
					  $client_name=null; 
					 }
			 



////////////////////////////////////////////////////////////waiter information
try {
$q = "SELECT * FROM tbl_cart WHERE waiter_id={$waiter_id}  GROUP BY cart_id";
$query = $db->prepare($q);
$query->execute();
$c_result = $query->fetchAll(PDO::FETCH_ASSOC);
//
$waiter_id = $_SESSION['waiter_id'];
$waiter_name=$user->getWaiterName($waiter_id);
$wcartTotal=$user->get_twaitercart($waiter_id);

//insert code for rowCount to var
} catch (PDOException $ex) {
echo $ex->getMessage();
}


         try {
             $stmt = $user->runQuery('
	SELECT * 
	FROM tbl_cart 
	WHERE waiter_id=:waiter_id
	');
    
             $stmt->execute(array(":waiter_id"=>$waiter_id,));
             $o_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
             $o_count=$stmt->rowCount();
             //
         } catch (PDOException $ex) {
             echo $ex->getMessage();
         }
     
/////////////////////////////////////////////////////////// for  tables list & count
try {
$q = "
SELECT * 
FROM _waiter_clients 
WHERE waiter_id={$waiter_id} 
GROUP BY cart_id ";
$query = $db->prepare($q);
$query->execute();
$table_result = $query->fetchAll(PDO::FETCH_ASSOC);
$table_count=$query->rowCount();
//
$q = "
SELECT * 
FROM _waiter_clients 
WHERE waiter_id={$waiter_id} 
 ";
$query = $db->prepare($q);
$query->execute();
$client_result = $query->fetchAll(PDO::FETCH_ASSOC);
$client_count=$query->rowCount();

//insert code for rowCount to var
} catch (PDOException $ex) {
echo $ex->getMessage();
}

				 
				 
				 
				 
