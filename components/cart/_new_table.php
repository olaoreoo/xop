<?php require "../../config/phpconfig.php";
//
if (isset($_SESSION['waiter_id'])) {
	$waiter_id = $_SESSION['waiter_id']; $pay_stat=0;
	$wcartTotal=$user->wcartTotal($waiter_id);
	$waiter_name=$user->getWaiterName($waiter_id);
	$cart_id= $user->accountCode(8);
	
	$stable= $user->createTableName(6);
	//$sname= $user->createTableName(8);

	  }
 ?>
<div class="row">
  <div class="col-sm-12">
<div id="frm_addtable" name="frm_addtable" class="">
  <tr class="cart-table__row ">
    <td class=""><div class="row">
        <div class="col-lg-12">
          <div class="col-lg-8">
            <input name="waiter_id" type="hidden" id="waiter_id"  value="<?php echo $waiter_id; ?>" >
            <label for="new_table">- Click to add a table name -</label>
            <input name="new_table" type="text" id="new_table"  value="<?php echo $stable; ?>" placeholder="Table Name" class="form-control" onfocus="this.value='' ">
            <button type="button" class="btn btn-primary btn-sm" id="confirm_addtable">Add Table</button>
            <button type="button" class="btn btn-primary btn-sm hide_addtable" id="hide_addtable"  data-dismiss="modal">Cancel</button>
          </div>
          <div class="col-lg-4"> </div>
        </div>
      </div>
      </td>
  </tr>
</div>    
<div class="col-lg-12">
          <div id="cont_addclient" name="cont_addclient" class="col-lg-8 hide"></div>
          <div class="col-lg-4"> </div>
        </div>    
  </div>
</div>

<div id="show_tables" name="show_tables" class=""></div>
