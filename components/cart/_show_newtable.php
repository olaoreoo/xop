<?php require "../../config/phpconfig.php";
//
if (isset($_SESSION['waiter_id'])) {
	 $waiter_id = $_SESSION['waiter_id']; 
		$wcartTotal=$user->wcartTotal($waiter_id);
		$waiter_name=$user->getWaiterName($waiter_id);
	  }
		$cart_id=$_SESSION['cart_id'];

try {
	
	$stmt = $user->runQuery("SELECT * FROM _waiter_clients WHERE cart_id='$cart_id' ");
	$stmt->bindParam("cart_id", $cart_id, PDO::PARAM_STR);
	//$stmt->bindParam("table_name", $table_name, PDO::PARAM_STR);
	$stmt->execute();
	$tableNew=$stmt->fetch(PDO::FETCH_ASSOC);
	$count = $stmt->rowCount();
	
		$id=$tableNew['id'];  echo $id;
		$waiter_id=$tableNew['waiter_id'];  
		$cart_id=$tableNew['cart_id'];
		$table_name=$tableNew['table_name'];
		$grand_total=$tableNew['curr_bill'];  

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
        <tr>
          <td><span class="smlabel"><?php echo $cart_id; ?></span></td>
          <td><strong><a href="javascript:;" id="" name="<?php echo $cart_id; ?>" class="goto_table">
            <?php echo $table_name; ?>
            </a></strong></td>
          <td><?php $user->fmtCurDisp($grand_total);  ?></td>
        </tr>
        <tr> 
        </tr>
      </tbody>
      <tr>
        <td class=""></td>
        <td class=""></td>
        <td class=""></td>
      </tr>
    </table>
    <div id="cont_msg" name="cont_msg" class="modal-footer">
      <button id="btn_addclient" name="btn_addclient" type="button" class="btn btn-primary btn-sm btn_addclient" >New Client</button>
      <!--data-dismiss="modal" -->
      <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
    </div>
    <div id="frm_addtable" name="frm_addtable" class="hide">
      <tr class="cart-table__row ">
        <td class=""><div class="row">
            <div class="col-lg-12">
              <div class="col-lg-8">
                <input name="waiter_id" type="hidden" id="waiter_id"  value="<?php echo $waiter_id; ?>" >
                <input name="new_table" type="text" id="new_table"  value="Guest" placeholder="Table Name" class="form-control" onfocus="this.value='' ">
              </div>
              <div class="col-lg-4">
                <button type="button" class="btn btn-primary btn-sm" id="confirm_addtable">Add</button>
              </div>
            </div>
          </div></td>
      </tr>
    </div>
  </div>
</div>
</div>
