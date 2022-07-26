<?php 
require_once "../../config/phpconfig.php";
require "../../modules/menu/prod_data.php";
require "waiter_cart.php";
	?>
<div class="dropcart">
  <?php  if ($table_count > 0) { 		?>
  <hr />
  <!--<span class="table_waiter_well"><?php echo $waiter_name;?></span>-->
  <span><span class="table_tbls_well"><?php echo $table_count;?> Table(s)</span>
  <span class="table_clts_well"><?php echo $client_count;?> Client(s)</span>
  <span id="tables_tbl_msgs" name="tables_tbl_msgs" class="tbl_msgs"></span>
  <button type="button" class="btn btn-secondary btn-sm pull-right" data-dismiss="modal">Close</button>
  </span>
  <table id="tables-table" class="table table-striped table-hover responsive" width="100%">
    <tbody class="cart-table__body">
      <tr>
        <!--<th class="col" width="8.83%">Cart</th>-->
        <th class="col" wid="12.83%">Table</th>
        <th class="col" width="5.83%"><div align="center">Clients</div></th>
        <th class="col" width="5.83%"><div align="center">Items</div></th>
        <th class="col" width="50.83%"><div align="right">Total</div></th>
        <th class="col" width="10.83%"><div align="right"></div></th>
      </tr>
    </tbody>
    <?php  //use
$grand_total=0; $curr_bill=0;
foreach ($table_result as $data) {
    $id=$data['id'];
    $cart_id=$data['cart_id'];
    $table_name=$data['table_name'];
    $waiter_id=$data['waiter_id'];
    $client_name=$data['client_name'];

    //get no of clients in  table
    //replace with proper count query or preferably class method
	    $stmt = $user->runQuery("
		SELECT * 
		FROM _waiter_clients 
		WHERE table_name=:table_name
		");
    $stmt->execute(array(":table_name"=>$table_name,));
    $tbl_clients=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $no_tbl_clients=$stmt->rowCount();
    //replace with proper count query or preferably class method
	
    //total bill of all clients in table
	    //replace with proper count query or preferably class method
	    $stmt = $user->runQuery("
		SELECT * 
		FROM tbl_cart 
		WHERE label=:table_name
		");
    $stmt->execute(array(":table_name"=>$table_name, ));
    $allcurr_bill=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $curr_bill=$stmt->rowCount();
		// sum prod_tot column
		$prod_tot=0; $cbill=0;   $item_tot=0;
		    foreach ($allcurr_bill as $row) {
				$prod_tot=$row['prod_tot'];
				$cbill=$cbill+$prod_tot;
				$item_tot++;
			}
			$grand_total=$grand_total+$cbill;
    //total bill of all clients in table
	?>
    <tr>
      <!--<td><span class="smlabel"><?php echo $cart_id; ?></span></td>-->
      <td><strong><a href="javascript:;" id="<?php echo $id; ?>"
              name="<?php echo $cart_id; ?>" class="view_tbl_clients"
              tn="<?php echo $table_name; ?>"><?php echo $table_name; ?></a></strong></td>
      <td><div align="center"><?php echo $no_tbl_clients; ?></div></td>
      <td><div align="center"><?php echo $item_tot; ?></div></td>
      <td><div align="right"><?php $user->fmtCurDisp($cbill); ?></div></td>
      <td><div align="right">
      <a href="javascript:;" id="<?php echo $id; ?>" name="<?php echo $cart_id; ?>" class=" btn btn-tb view_tbl_clients"
              tn="<?php echo $table_name; ?>">View</a></div></td>
    </tr>
    <tr> </tr>
    <?php
} ?>
      </tbody>
      
    <tr>
      <!--<td></td>-->
      <td colspan="2" class=""><div align="right">Grand Total:</div></td>
      <td colspan="2" class=""><div align="right"><strong><?php $user->fmtCurDisp($grand_total); ?></strong></div></td>
      <td colspan="1" class=""><div align="right">:</div></td>
    </tr>
  </table>
  <div id="cont_msg" name="cont_msg" class=""></div>
  <div id="frm_addtable" name="frm_addtable" class="hide">
    <tr class="cart-table__row ">
      <td class=""><div class="row">
          <div class="col-lg-12">
            <div class="col-lg-8">
              <input name="waiter_id" type="hidden" id="waiter_id"
                  value="<?php echo $waiter_id; ?>">
              <input name="new_table" type="text" id="new_table" value="" placeholder="Table Name"
                  class="form-control" onfocus="this.value='' ">
            </div>
            <div class="col-lg-4">
              <button type="button" class="btn btn-primary btn-sm confirm_addtable"
                  id="confirm_addtable" name="">Add</button>
            </div>
          </div>
        </div></td>
    </tr>
  </div>
    <?php } else { ?>
  <table id="" class="table table-striped table-hover " width="100%">
    <tr class="">
      <td colspan="3"><div align="left" class=" "><strong> You have no tables! </strong> <span align="right"><a class=" btn-secondary btn-sm"  href="javascript:;" data-dismiss="modal">Close</a></span></div></td>
      <td colspan="1"></td>
    </tr>
  </table>
  <?php  } ?>
    
<div id="cont_addclient" name="cont_addclient" class="hide"></div>
<div id="cont_clientlist" name="cont_clientlist" class="drop_cart modal-footer hide"> </div>
<div id="cont_orders" name="cont_orders" class="hide"></div>
<div id="cont_addclient" name="cont_addclient" class="col-md-4 hide"></div>
</div>
