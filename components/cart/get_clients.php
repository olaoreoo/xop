<?php require "../../config/phpconfig.php";
//
if (isset($_SESSION['waiter_id'])) {
	 $waiter_id = $_SESSION['waiter_id']; $pay_stat=0; }

try {
$waiter_id=$_SESSION['waiter_id'];
$q = "SELECT * FROM tbl_cart WHERE waiter_id={$waiter_id}  AND pay_stat={$pay_stat} GROUP BY cart_id";
$query = $db->prepare($q);
$query->execute();
$c_result = $query->fetchAll(PDO::FETCH_ASSOC);
$c_count=$query->rowCount();
//
 if (!isset($_SESSION['payee_label'] ) ||  ($_SESSION['payee_label'] =="")) {  $payee_label="Guest"; $_SESSION['payee_label']=$payee_label; }			

//insert code for rowCount to var
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
				
		$wcartTotal=$user->get_twaitercart($waiter_id);
		$waiter_name=$user->getWaiterName($waiter_id);

 ?>

<div class="modal-header"  id="cclientsModal">
  <div class="row">
    <div class="col-sm-12">
            <h4 class="modal-title" id="cartModalLabel"> <span class="nawell"> <?php echo $waiter_name;?>'</span>  <!--<span class="nbwell"><?php echo $wcartTotal;?></span>--> <span class="nowell"> <?php echo $_SESSION['payee_label'];?> - Orders </span></h4>
    </div>
    <div class="dropcart">
      <?php if ($c_count > 0) { 		?>
      <hr />
      <table id="cart-table" class="table table-striped table-hover" width="100%">
          <tr>
            <th class="col" width="10.83%">Cart ID</th>
            <th class="col" width="70.83%">Tabel ID</th>
            <th class="col" width="20.83%">Total</th>
          </tr>
        <tbody>
          <?php  //use 
$sg_total=0;    
foreach ($c_result as $data) {
$id=$data['id'];
$cart_id=$data['cart_id'];
$label=$data['label'];
$waiter_id=$data['waiter_id'];  
$add_time=$data['add_time'];
$staff_id=$data['staff_id'];
//
$grand_total=0; $s_total=0;
$s = "SELECT * FROM tbl_cart WHERE cart_id='{$cart_id}' AND pay_stat=0  ";
$query = $db->prepare($s);
$query->execute();
$s_result = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($s_result as $data) {
$prod_price=$data['prod_price'];
$prod_qty=$data['qty'];
$prod_tot=$data['prod_tot'];
$pay_stat=$data['pay_stat'];
//$dev_stat=$data['qty'];			   
$item_tot=$prod_price*$prod_qty;
$grand_total=$grand_total + $item_tot ;
}
$sg_total=$sg_total+$grand_total ;
//
?>
          <tr>
            <td><span class="smlabel"><?php echo $cart_id; ?></span></td>
            <td><strong><a href="javascript:;" id="<?php echo $id; ?>" name="<?php echo $cart_id; ?>" class="edit_sentry"><?php echo $label; ?></a></strong> <span class="smlabel">(View)</span>| <a href="cartCreate.php?cid=<?php echo $cart_id; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="vew_sentry">(Go to Table)</a></td>
            <td><?php $user->fmtCurDisp($grand_total); ?></td>
          </tr>
          <tr>
            <div class="hide" id="show_cont<?php echo $id; ?>" name="show_cont<?php echo $id; ?>"></div>
          </tr>
          <?php } ?>
        </tbody>
        <tr>
          <td></td>
          <td class=""><span class="pull-right">Grand Total:</span></td>
          <td class=""><strong>
            <?php $user->fmtCurDisp($sg_total);  ?>
            </strong></td>
        </tr>
      </table>
      <div id="cont_msg" name="cont_msg" class="modal-footer">
<button type="button" class="btn btn-primary" >Print</button>
          <button id="closecart" name="closecart" type="button" class="btn btn-secondary close-cart" data-dismiss="modal" >Close</button>
        </div>
      <?php }  else { ?>
      <div>
      <hr />
        <div class="display_check text-warning" >You have no clients!</div>
        <p>Please take an order!</p>
      </div>
      <div id="cont_cart" name="cont_cart" class="modal-footer">
        <button type="button" class="btn btn-secondary closemod" data-dismiss="modal">Close</button>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
