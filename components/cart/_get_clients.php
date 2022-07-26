<?php require "../../config/phpconfig.php";
// get/ set waiter details
if (isset($_SESSION['waiter_id'])) {
    $waiter_id = $_SESSION['waiter_id'];
    $pay_stat=0;
    $wcartTotal=$user->wcartTotal($waiter_id);
    $waiter_name=$user->getWaiterName($waiter_id);
}
//

    //replace with proper count query or preferably class method
	
	// get/ set client details
if (isset($_REQUEST['cart_id'])) {$_SESSION['cart_id'] =$cart_id = trim($_REQUEST['cart_id']);
} else {    $cart_id=$_SESSION['cart_id']; }
if (isset($_REQUEST['table_name'])) { $_SESSION['table_name'] =$table_name = trim($_REQUEST['table_name']);
} else { $table_name=$_SESSION['table_name'];
}
$_SESSION['client_name']=null;
try {
//
    $stmt = $user->runQuery("
	SELECT * 
	FROM _waiter_clients 
	WHERE waiter_id=:waiter_id
	AND cart_id=:cart_id
	");
    
    $stmt->execute(array(":waiter_id"=>$waiter_id, ":cart_id"=>$cart_id));
    $w_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $w_count=$stmt->rowCount();
    //
    $stmt = $user->runQuery("
	SELECT * 
	FROM tbl_cart 
	WHERE waiter_id=:waiter_id
	AND cart_id=:cart_id
			AND dev_stat!='Closed'
	");
    $stmt->execute(array(":waiter_id"=>$waiter_id, ":cart_id"=>$cart_id));
    $o_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $o_count=$stmt->rowCount();
    //


} catch (PDOException $ex) {
    echo $ex->getMessage();
}
 ?>

<div id="section_clients">
  <?php if ($w_count > 0) {	 ?>
  <div align="left">
<!--<span class="table_waiter_well"><?php echo $table_name;?></span>-->
<span class="table_tbls_well"><?php echo $w_count;?> Client(s)</span>
<span class="table_clts_well"><?php echo $o_count;?> Order(s)</span>
<span class="pull-right"><button id="close_clients" name="close_clients" type="button" class=" btn-secondary btn-sm">Close</button></span>
<span class="pull-right"><button id="btn_addclient" name="btn_addclient" type="button" class="btn btn-sm btn-warning btn_addclient">New Client</button></span>
      </div>
  <table id="tables-table" class="table table-striped table-hover " width="100%">
    <tr>
      <div id="cont_addclient" name="cont_addclient" class="col-md-4 hide"></div>
      <!--<th class="col" width="10.83%"><div align="left">Cart</div></th>-->
      <th class="col" width="8.83%"><div align="right">Clients</div></th>
      <th class="col" width="2.83%"><div align="center">Items</div></th>
      <th class="col" width="40.83%"><div align="right">Bill</div></th>
      <th class="col" width="30.83%">
        <div align="right">Actions</div>
      </th>
    </tr>
    <tbody class="cart-table__body">
      <?php
                $s_total=0;
     $grand_total=0;
     foreach ($w_results as $row) {
         $id=$row['id'];
         $waiter_id=$row['waiter_id'];
         $cart_id = $row['cart_id'];
         $table_name=$row['table_name'];
         $client_name=$row['client_name'];
         $curr_bill=$row['curr_bill'];
         //$dev_stat=$row['dev_stat'];
         
         //total bill of this client
         //replace with proper count query or preferably class method
         $stmt = $user->runQuery("
		SELECT * 
		FROM tbl_cart 
		WHERE label=:table_name
		AND tlabel=:client_name
		");
         $stmt->execute(array(":table_name"=>$table_name, ":client_name"=>$client_name));
         $allcurr_bill=$stmt->fetchAll(PDO::FETCH_ASSOC);
         $curr_bill_cnt=$stmt->rowCount();
         // sum prod_tot column
         $prod_cnt=0; $cbill=0;
         foreach ($allcurr_bill as $brow) {
 		         $prod_tot=$brow['prod_tot'];
            $prod_cnt++;
             $cprod_tot=$prod_tot;
             $cbill=$cbill+$cprod_tot;
         }
         $grand_total=$grand_total+$cbill;
         //total bill of all clients in table?>
      <tr class="">
        <!--<td>
          <div align="left"><span class="smlabel"><?php echo $cart_id; ?></span></div>
        </td>-->
        <td class="">       <div align="left"><a id="view_client" name="view_client"
            tn="<?php echo $table_name; ?>"
            cn="<?php echo $client_name; ?>"
            class=" btn btn-oc view_client" href="_shop.php?cart_id=<?php echo $cart_id; ?>&table_name=<?php echo $table_name; ?>&client_name=<?php echo $client_name; ?>"><?php echo $client_name; ?>
</a></div></td>
         <td class="col" width="12.83%"><div align="center"><?php echo $prod_cnt; ?></div></td>
        <td class=""><?php $user->fmtCurDisp($cbill); ?>
        </td>
        <td class="">
       <a id="view_client_orders" name="view_client_orders"
            tn="<?php echo $table_name; ?>"
            cn="<?php echo $client_name; ?>"
            class=" btn btn-tb view_client_orders" href="javascript:;">View</a>
            <!--<a class=" btn btn-tb"
            href="_shop.php?cart_id=<?php echo $cart_id; ?>&table_name=<?php echo $table_name; ?>&client_name=<?php echo $client_name; ?>">New</a>-->
            <!--<a class=" btn btn-tb btn-danger close_client_cart"
            href="javascript:;" ci="<?php echo $cart_id; ?>" tn="<?php echo $table_name; ?>" cn="<?php echo $client_name; ?>">Close</a>-->
            <!--<a class=" btn btn-tb client_rem"
            href="javascript:;">Del</a>-->
        
 <?php // if ($pay_stat!=1) {?>

 <?php } ?>
       
          
           <?php  //if ($item_tot) {?>
         <?php  // }?>
       
         
        </td>
      </tr>
      <?php //}?>
    </tbody>
  </table>
  <div id="section_orders" name="section_orders" class="hide"></div>
  <?php
 } else { ?>
  <table id="tables-table" class="table table-striped table-hover " width="100%">
    <tbody class="cart-table__body">
      <tr class="">
        <td colspan="3"><span align="left"><strong>You have no tables! </strong></span></td>
        <td colspan="1"> <span align="right"><button type="button" class="btn btn-secondary btn-sm"
              data-dismiss="modal">Close</button></span></td>
      </tr>
    </tbody>
  </table>
  <div class="display_check cart-table__body">
    <h5>You have no clients! </h5>
    <p> Click on 'New Client' to begin taking orders!</p>
  </div>
  <?php } ?>
</div>