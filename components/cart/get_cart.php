<?php require "../../config/phpconfig.php";
//
if (isset($_SESSION['waiter_id'])) {
$waiter_id = $_SESSION['waiter_id']; $pay_stat=0;  $cart_id = $_SESSION['cart_id'];}
$stmt = $user->runQuery('SELECT * FROM tbl_cart WHERE cart_id=:cart_id AND pay_stat=:pay_stat  AND prod_id <>"" ORDER BY add_time DESC');
$stmt->execute(array(":cart_id"=>$cart_id, ":pay_stat"=>$pay_stat));
$w_results=$stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

$wcartTotal=$user->get_twaitercart($waiter_id);
$waiter_name=$user->getWaiterName($waiter_id);
 if (!isset($_SESSION['payee_label'] ) ||  ($_SESSION['payee_label'] =="")) {  $payee_label="Guest"; $_SESSION['payee_label']=$payee_label; }			

// return $cart_id;
?>
<div class="modal-header"  id="cartModal">
  <div class="row">
    <div class="col-sm-12">
      <h4 class="modal-title" id="cartModalLabel"> <span class="nawell"> <?php echo $waiter_name;?>'</span>  <!--<span class="nbwell"><?php echo $wcartTotal;?></span>--> <span class="nowell"> <?php echo $_SESSION['payee_label'];?> - Orders </span></h4>
      <div class="dropcart">
        <?php if ($count > 0) { 		?>
       <br />

        <table width="100%" class="responsive cart__table cart-table" >
<tr class="cart-table__row">
            <th width="15.33%" class="cart-table__column cart-table__column--label">Table</th>
            <th width="22.33%" class="cart-table__column cart-table__column--label">Label</th>
            <th width="35.33%" class="cart-table__column cart-table__column--product">Product</th>
            <th width="5.33%" class="cart-table__column cart-table__column--quantity">Qty</th>
            <th  width="20.33%" class="cart-table__column cart-table__column--total">Total</th>
            <th width="5.33%" class="cart-table__column cart-table__column--remove"></th>
          </tr>
          
          <tbody class="cart-table__body">
            <?php 
	  			$s_total=0; $grand_total=0; 
		        foreach ($w_results as $row) { 
		$id=$row['id'];
		$cart_id = $row['cart_id'];
		$label = $row['label'];
		$payee_label = $row['tlabel'];
		$prod_id=$row['prod_id'];
		$waiter_id=$row['waiter_id'];
		$dev_stat=$row['dev_stat'];
		
		$stmt = $user->runQuery("SELECT * FROM tbl_products WHERE id=:prod_id");
        $stmt->execute(array(":prod_id"=>$prod_id));
        $relRow=$stmt->fetch(PDO::FETCH_ASSOC);
		$prod_price=$relRow['prod_price'];
		$prod_name=$relRow['prod_name'];	
		// 
			   $qty=$row['qty']; 
			   $item_tot=($prod_price*$qty);	   $item_totdisp=number_format($item_tot,0); //number_format($grand_total,0)
			   $prod_val=$item_tot;
				$prod_tot =$s_total + $prod_val ;
				$grand_total=$grand_total + $prod_tot ;
				//$gt_disp=$user->fmtCur($grand_total); flag_itemid
		?>
<form  method="post" id="qty_frm<?php echo $cart_id;?>" name="<?php echo $cart_id;?>">
    <input name="rec_id" type="hidden" id="rec_id"  value="<?php echo $cart_id;?>"><input name="grand_total" type="hidden"  id="grand_total" value="<?php $user->fmtCur($grand_total); ?>"  >
    <input name="waiter_id" type="hidden"  id="waiter_id"  value="<?php echo $waiter_id;?>" ><input name="cart_id" type="hidden"  id="cart_id"  value="<?php echo $cart_id;?>" >
    <input name="prod_id<?php echo $cart_id; ?>" type="hidden"  id="prod_id<?php echo $cart_id; ?>"  value="<?php echo $prod_id; ?>" class="form-control">
    <input name="prod_price<?php echo $cart_id;?>" type="hidden" id="prod_price<?php echo $cart_id;?>" value="<?php echo $prod_price;?>" disabled="disabled">
    <input   name="prod_tot<?php echo $cart_id;?>" size="2" type="hidden" class="form-control " id="prod_tot<?php echo $cart_id;?>" value="<?php echo $prod_tot;?>" >
    <input name="flag_itemid" type="hidden"   id="flag_itemid" value="<?php echo $id;?>" >
            <tr class="cart-table__row">
              <td class=""><?php echo $label; ?></td>
              <td class=""><input name="payee_label" type="text" id="payee_label"  value="<?php echo $payee_label;?>" class="form-control"><?php //echo $tlabel; ?></td>
              <td class=""><?php echo $prod_name; ?></td>
              <td class="" data-title="Quantity"><?php echo $qty;?></td>
              <td class="" ><?php echo $item_totdisp; ?></td>
              <td class="">
			  <?php if ($dev_stat=="Submission") {?>
                <a href="#"
                	class="tooltip-error item_remove" data-rel="tooltip" title="Remove"
                    id="<?php echo $id; ?>"
                    name="<?php echo $id; ?>"> <span class="red"> <i class="ace-icon fa fa-trash-o bigicon"></i> </span>
               </a>
                <?php } ?>
              </td>
            </tr>
          </form>
          <?php } ?>
            </tbody>
          
          <tfoot class="cart-table__foot">
            <tr class="cart-table__row">
              <td colspan="1" class="cart-table__column cart-table__column--product"></td>
              <td colspan="2" class="cart-table__column cart-table__column--product"><span class="pull-right"> Grand Total  </span></td>
              <td  colspan="2" class="cart-table__column cart-table__column--total"><span class="pull-right nawell"> <?php $user->fmtCur($grand_total); ?> </span></td>
                     <td colspan="1" class="cart-table__column cart-table__column--product"></td>
     </tr>
          </tfoot>
        </table>
        <div id="cont_msg" name="cont_msg" class="modal-footer">
<button type="button" class="btn btn-primary" >Print</button>
          <button id="closecart" name="closecart" type="button" class="btn btn-secondary close-cart" data-dismiss="modal" >Close</button>
        </div>
        <?php }  else { ?>
        <div>       <br />
          <div class="display_check text-warning" >You have not made an order!</div>
          <p>Please scroll down to choose a combo or customize your meal.</p>
        </div>
        <div id="cont_cart" name="cont_cart" class="">
          <button type="button" class="btn btn-secondary closemod" data-dismiss="modal">Close</button>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
