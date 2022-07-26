<?php require "../../config/phpconfig.php";
//

if (isset($_REQUEST['cart_id'])) {
    $_SESSION['cart_id'] =$cart_id = trim($_REQUEST['cart_id']);
} else {
    $cart_id=$_SESSION['cart_id'];
}
if (isset($_REQUEST['table_name'])) {
    $_SESSION['table_name'] =$table_name = trim($_REQUEST['table_name']);
} else {
    $table_name=$_SESSION['table_name'];
}
if (isset($_REQUEST['client_name'])) {
    $_SESSION['client_name'] =$client_name = trim($_REQUEST['client_name']);
} else {
    $client_name=$_SESSION['client_name'];
}

try {

    $stmt = $user->runQuery("
		SELECT * 
		FROM tbl_cart 
		WHERE tlabel=:client_name
		AND dev_stat!='Closed'
		ORDER BY add_time DESC

		");
    $stmt->execute(array(":client_name"=>$client_name,));
    $cart_items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $c_count=$stmt->rowCount();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
 ?>
<div id="section_orders" class="dropcart">
  <?php if ($c_count > 0) { 		?>
  
  <div align="left">      <!--<span class="table_waiter_well"><?php echo $client_name;?></span>-->
  <span class="table_tbls_well" align="right"> <?php echo $c_count;?> Order(s)</span><span><a class=" btn btn-tb btn-warning"
            href="_shop.php?cid=<?php echo $cart_id; ?>&amp;client_name=<?php echo $client_name; ?>">Add Item </a></span> 
<span><a class=" btn btn-tb btn-danger close_client_cart"
            href="javascript:;" ci="<?php echo $cart_id; ?>" tn="<?php echo $table_name; ?>" cn="<?php echo $client_name; ?>">Close</a></span>
<span><a class=" btn btn-tb btn-danger print_bill"
            href="javascript:;" ci="<?php echo $cart_id; ?>" tn="<?php echo $table_name; ?>" cn="<?php echo $client_name; ?>">Print</a></span>
                      

<span class="pull-right"><button id="closeorders" name="closeorders" type="button" class=" btn-secondary btn-sm close_orders"   >Close</button></span>             </div>

            
            
  <table id="tables-table" class="table table-striped table-hover " width="100%">
    <tr>
      <th class="col" width="1.83%"><div align="center">Stat</div></th>
      <th class="col" width="60.83%">
        <div align="left"><strong><?php echo $client_name; ?>'s Orders</strong></div>
      </th>
      <th class="col" width="25.83%"><div align="right">Value</div></th>
      <th class="col" width="15.83%"><div align="right"><?php //echo $dev_stat; ?></div></th>
    </tr>
    <tbody class="cart-table__body">
      <?php
            $item_cnt=0; $all_val=0; $s_total=0; $grand_total=0;   $item_tot=0;
    foreach ($cart_items as $row) {
        $order_stat=$row['order_stat'];
        $dev_stat=$row['dev_stat'];
        $pay_stat=$row['pay_stat'];
		        switch ($order_stat) {
                    case '0': 
					$orderstat="<div class='red'>Not Paid</div>";
                    break;
                    case '1': 
					$orderstat="Paid";
                    break;
                    case '2': $orderstat="Credit";
                    break;
                default: $orderstat="Undetermined";
            }

			        switch ($pay_stat) {
                    case '0': 
					$orderstat="<div class='red'>Not Paid</div>";
					$pay_style="red";
                    break;
                    case '1': 
					$orderstat="Paid";
					$pay_style="green";
                    break;
                    case '2': $orderstat="Credit";
                    break;
                default: $orderstat="Undetermined";
    					$pay_style="blue";
            }
						        switch ($dev_stat) {
                    case 'Processing': 
					$stat='<img src="modules/icon_exclaim.gif" width="14" height="14" />';
					$stat_style='';
                    break;
                    case 'Delivered': 
					$stat='<img src="modules/icon_cool.gif" width="14" height="14" />';
					$stat_style='';

                    break;
                    case 'Submission': 
					$stat='<img class="red" src="modules/icon_question.gif" width="14" height="14" />';
					$stat_style='';
                    break;

                default: $orderstat="Undetermined";
					$stat='<img class="red" src="modules/icon_confused.gif" width="14" height="14" />';
					$stat_style='';
            }
        $id = $row['id'];
        $cart_id = $row['cart_id'];
        $prod_id = $row['prod_id'];

        $stmt = $user->runQuery("SELECT * FROM tbl_products WHERE id=:prod_id");
        $stmt->execute(array(":prod_id"=>$prod_id));
        $prodRow=$stmt->fetch(PDO::FETCH_ASSOC);
        $prod_price=$prodRow['prod_price'];
        $prod_name=$prodRow['prod_name'];
        $add_time=$row['add_time'];
        $trns_time=$user->get_time_ago($add_time).'<br>';
        
        $prod_tot=$row['prod_tot'];
        $prod_price=$row['prod_price'];
        $prod_qty=$row['qty'];
        
        $tot_val=$prod_price*$prod_qty;
        $all_val=$all_val+$tot_val;
        $item_cnt++;
        $item_tot=$item_tot+$prod_qty;
//
?>
      <tr class="">
      <td>
        <div  style="background-color:<?php echo $stat_style;?>" align="center"><?php echo $stat;?></div></td>
        <td>          <div align="left">  (<strong><?php echo $prod_qty; ?></strong>) <span><?php echo $prod_name; ?></span></div></td>
        <td class="<?php echo $pay_style; ?>"><div align="right">
            <?php $user->fmtCurDisp($tot_val); ?>
          </div></td>
        <td class=""><?php //}?>
          <?php  if ($pay_stat!=1) {?>
          <a href="javascript:;" class="tooltip-error btn-sm order_rem" data-rel="tooltip" title="Delete Order"
            id="<?php echo $id; ?>"
            name="<?php echo $id; ?>"
            tn="<?php echo $table_name; ?>"
            cn="<?php echo $client_name; ?>"
            > <span class="red"> <i
                class="ace-icon fa fa-trash-o "></i> </span> </a>
          <?php   }?></td>
      </tr>
      <?php
    } ?>
    </tbody>
    <tr>
      <th class="col"><div align="right"># <?php echo $item_tot;?> </div></th>
     <th colspan="2" class="col "><div align="right"><?php $user->fmtCurDisp($all_val); ?></div></th>
            <th class="col"><div align="right"><?php //echo $item_tot;?> </div></th>

    </tr>
  </table>
  
  <?php } else { ?>
<table id="" class="table table-striped table-hover " width="100%">
      <tr class="">
        <td colspan="3"><div align="left" class=" "><strong> <?php echo $client_name; ?></strong> has no orders!  </div></td>
        <td colspan="1"><div align="right"><button id="btn_cli_order" name="btn_cli_order" type="button" class="btn btn-tb btn-warning btn_cli_order" data-name="btn_cli_order"
         ci="<?php echo $cart_id; ?>" tn="<?php echo $table_name; ?>" cn="<?php echo $client_name; ?>">Order
</button></div></td>
      </tr>
    </table>
  <?php } ?>
</div>
