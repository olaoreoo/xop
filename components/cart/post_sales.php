<?php
 require "../../config/phpconfig.php";
// get cart info from cart  table
        $db = getDB();
		//
		    if (isset($_GET['id'])) { 
	$staff_id=$_SESSION['waiter_id'];
	$sale_id=$_GET['id'];
	// get cart info
	        try {
            $q = "SELECT * FROM tbl_cart WHERE id=:sale_id ";
            $query = $db->prepare($q);
			$query->bindParam("sale_id", $sale_id, PDO::PARAM_STR);
            $query->execute();
              $cart_res = $query->fetch(PDO::FETCH_ASSOC);
           //  if ($query->rowCount() > 0) { 
		   if (isset($_POST['cart_id'])) { $cart_id = trim($_POST['cart_id']);  }

			$cust_id=$cart_res['cust_id'];
			$waiter_id=$cart_res['waiter_id'];
			$prod_id=$cart_res['prod_id'];
			$pay_stat=$cart_res['pay_stat'];
			$product_price=$cart_res['prod_price'];
			$product_qty=$cart_res['qty'];
			$entry_total=$cart_res['prod_tot'];
				 $product_name= trim($user->getProdName($prod_id));
				 
							//getclientFullName
 if ($waiter_id==0) {
	 $client=$cust_id;
	 $cust_name=$user->getclientFullName($client);
	 	 $highlight="<i class='ace-icon fa fa-user bigger-130 green'></i>";
	 } else if ($waiter_id!=0) {
		 	 $client=$waiter_id;
	 $cust_name=$user->getWaiterName($client);
	 	 $highlight="<i class='ace-icon fa fa-user bigger-130 red'></i>";

		 }
//		 
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
	 }
//
        try {
            $sql ="INSERT INTO tbl_sales (
		 `staff_id`,
		 `cust_name`,
		 `product_name`,
		 `pay_stat`,
		 `product_price`,
	     `product_qty`,
	     `entry_total`
		  ) 
         VALUES (
		 '" . $staff_id . "',
		 '" . $cust_name . "',
		 '" . $product_name . "',
		 '" . $pay_stat . "',
		 '" . $product_price . "',
		 '" . $product_qty . "',
		 '" . $entry_total . "'
		 )";
         
            $stmt = $db->prepare($sql);
            if ($stmt->execute()) {
                $data['success_db'] = 'success';
                $data['message_db'] = 'Entry posted succussfully!';
                echo json_encode($data);
                return;
            } else {
                $data['success_db'] = 'error';
                $data['message_db'] = 'Entry posting error!';
                $data['product_price'] = $product_qty ;
                echo json_encode($data);
                return;
            }
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }