<?php require "../../config/phpconfig.php";
//
if (isset($_SESSION['waiter_id'])) {
	 $waiter_id = $_SESSION['waiter_id']; $pay_stat=0;
		$wcartTotal=$user->wcartTotal($waiter_id);
		$waiter_name=$user->getWaiterName($waiter_id);
		$cart_id=$_SESSION['cart_id'];
	  }

try {
$waiter_id=$_SESSION['waiter_id'];
//$q = "SELECT * FROM tbl_cart WHERE _waiter_clients={$waiter_id}  AND AND cart_id='{$cart_id}' GROUP BY cart_id";
$q = "SELECT * FROM _waiter_clients WHERE waiter_id={$waiter_id}  ";
$query = $db->prepare($q);
$query->execute();
$c_result = $query->fetchAll(PDO::FETCH_ASSOC);
//

//insert code for rowCount to var
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
				

 ?>
<div class="row">
<div class="dropcart">
    <hr />
    <table id="tables-table" class="table table-striped table-hover responsive" width="100%">
      <tr>
        <th class="col" width="10.83%">Cart ID</th>
        <th class="col" width="60.83%">Tabel ID</th>
        <th class="col" width="30.83%">Total</th>
      </tr>
      <tbody>
        <?php  //use 
$sg_total=0;    
foreach ($c_result as $data) {
$id=$data['id'];
$cart_id=$data['cart_id'];
$table_name=$data['table_name'];
$waiter_id=$data['waiter_id'];  
//$add_time=$data['add_time'];
//az$staff_id=$data['staff_id'];
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
          <td><strong><a href="javascript:;" id="<?php echo $id; ?>" name="<?php echo $cart_id; ?>" class="view_tbl_clients"><?php echo $table_name; ?></a></strong><!--<a href="cartCreate.php?cid=<?php echo $cart_id; ?>" id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="vew_sentry">(Go to Table)</a>--></td>
          <td><?php $user->fmtCurDisp($grand_total); ?></td>
        </tr>
        <tr>
<!--          <div class="hide" id="show_cont<?php echo $id; ?>" name="show_cont<?php echo $id; ?>"></div>--> 
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
      <button id="btn_addclient" name="btn_addclient" type="button" class="btn btn-primary btn-sm btn_addclient" >New Client</button><!--data-dismiss="modal" -->
               <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>

    </div>
<div id="frm_addtable" name="frm_addtable" class="hide">
    <tr class="cart-table__row ">
        <td class="">
        <div class="row">
        <div class="col-lg-12">
                <div class="col-lg-8">
                <input name="waiter_id" type="hidden" id="waiter_id"  value="<?php echo $waiter_id; ?>" >
        <input name="new_table" type="text" id="new_table"  value="Guest" placeholder="Table Name" class="form-control" onfocus="this.value='' ">
</div>
                <div class="col-lg-4"><button type="button" class="btn btn-primary btn-sm" id="confirm_addtable">Add</button></div>
        </div>
        </div>
        </td>

      </tr>
  </div>
  
  <div  id="load_table"  name="load_table" class="drop cart modal-footer hide">    
   <div id="tbl_client_list" name="tbl_client_list"></div>
  </div>
<!--<div class="drop cart modal-footer " role="document">
      <h5>You have no tables! </h5>
  </div>-->
    
</div>

</div>
</div>
