<?php require "../config/phpconfig.php";
if (!isset($_POST['prod_id'])) {
    //$user->redirect('../../menu.php?action=cart&ctext=noitemid');
} else {
    $prod_id=trim($_POST['prod_id'], "");
    $qty_val=trim($_POST['qty_val'], "");
    $price_val=trim($_POST['price_val'], "");
	 if (isset($_POST['cart_id'] )) { $cart_id=$_POST['cart_id']; } else { $cart_id=$_SESSION['cart_id'];  }
    //
    $nprod_tot=($price_val*$qty_val);
    //
    $data['prod_id'] = $prod_id;
    $data['qty_val'] = $qty_val;
    $data['cart_id'] = $cart_id;
    $data['price_val'] = $price_val;
    $data['nprod_tot'] = $nprod_tot;

    //echo $prod_id;
    if ($prod_id!==null || $prod_id!=="") {
        try {
            // check if item already exists in cart
            $stmt = $user->runQuery("
			SELECT * 
			FROM tbl_cart 
			WHERE cart_id=:cart_id  
			AND prod_id=:prod_id  
			LIMIT 1
			");
 			$stmt->bindParam("cart_id", $cart_id, PDO::PARAM_STR);
           $stmt->bindParam("prod_id", $prod_id, PDO::PARAM_STR);
            
            $stmt->execute();
            $ordRow=$stmt->fetch(PDO::FETCH_ASSOC);
            $count = $stmt->rowCount();
            $data['count'] = $count;
			
            if ($count>0) {
                $ord_id  = $ordRow['prod_id'];
                $ord_tot=$ordRow['prod_tot'];
                $ord_qty=$ordRow['qty'];
            }
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
            
        if ($count==0 || $count==null) {
            $data['exists'] = "no";
            //
            try {
                $pay_stat=0;
                $sql ="INSERT INTO tbl_cart (
		 `cart_id`,
		 `prod_id`,
		 `qty`,
	     `prod_price`,
		 `prod_tot`,
		 `pay_stat`
		  ) 
         VALUES (
		 '" . $cart_id . "',
		 '" . $prod_id . "',
		 '" . $qty_val . "',
		 '" . $price_val . "',
		 '" . $nprod_tot . "',
		 '" . $pay_stat . "'
		 )";

                $stmt = $db->prepare($sql);
                if ($stmt->execute()) {
                    $data['success_db'] = 'success';
                    $data['message_db'] = 'Item added to cart!';
                    //              get the last inserted in (null values) and delete entry
                    $null_entry=$user->lasdID();
                //echo $null_entry;
                } else {
                    $data['success_db'] = 'error';
                    $data['message_db'] = 'Entry addition error!';
                    //               return;
                }
            } catch (PDOException $e) {
                echo '{"error":{"text":' . $e->getMessage() . '}}';
            }
        } elseif ($count >= 1) {
            $data['exists'] = "yes";
            $data['ctotal'] =$count;

            try {
                $new_qty=($ord_qty+$qty_val);
                $new_prodtot= ($ord_tot + $nprod_tot);
                $data['new_qty'] =$new_qty;
                $data['new_prodtot'] =$new_prodtot;

                $stmt = $db->prepare("
				UPDATE tbl_cart 
				SET  qty=:new_qty, prod_tot=:new_prodtot 
				WHERE cart_id=:cart_id 
				AND prod_id=:prod_id
				");
                $stmt->bindParam("new_qty", $new_qty, PDO::PARAM_STR);
                $stmt->bindParam("new_prodtot", $new_prodtot, PDO::PARAM_STR);
                $stmt->bindParam("cart_id", $cart_id, PDO::PARAM_STR);
                $stmt->bindParam("prod_id", $prod_id, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $data['success_db'] = 'success';
                    $data['message_db'] = 'Your cart is updated!';
                } else {
                    $data['success_db'] = 'error';
                    $data['message_db'] = 'Sorry, a problem posting the order!';
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            return;
        }
    } else {
        $data['exists'] = "?";
		 $data['success_db'] = 'error';
         $data['message_db'] = 'Sorry, please try again later!';
    }
    echo json_encode($data);
    return;
}
