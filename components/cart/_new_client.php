<?php require "../../config/phpconfig.php"; ?>
<?php
    if (isset($_SESSION['waiter_id'])) {
        if (!isset($_SESSION['cart_id'])) {
            $waiter_id = $_SESSION['waiter_id'];
            $cart_id=$_SESSION['cart_id']= $user->accountCode(8);
            $stable=$_SESSION['table_name']= $user->createTableName(6);
            $sname=$_SESSION['client_name']= $user->createTableName(4);
        } else {
            $cart_id=$_SESSION['cart_id'];
            $cart_id=$_SESSION['cart_id'];
            $stable=$_SESSION['table_name'];
            $sname= $user->createTableName(4);
        }
    }?>

<div class="row">
  <div id="frm_addclient" name="frm_addclient" class="">
    <div class="col-md-10 ">
      <input name="waiter_id" type="hidden" id="waiter_id" value="<?php if (isset($_SESSION['waiter_id'])) {
        echo $_SESSION['waiter_id'];
    } ?>">
      <input name="table_name" type="hidden" id="table_name" value="<?php if (isset($_SESSION['table_name'])) {
        echo $_SESSION['table_name'];
    } ?>">
      <label for="new_client">- Click to add a new client to table - <strong><?php if (isset($_SESSION['table_name'])) {
        echo $_SESSION['table_name'];
    } ?>
        </strong></label>
      <input name="new_client" type="text" id="new_client"
        value="<?php echo $sname; ?>" placeholder="Client Name"
        class="form-control" onfocus="this.value='' ">
      <button type="button" class="btn btn-primary btn-sm confirm_addclient" id="confirm_addclient">Add Client</button>
      <!--<button type="button" class="btn btn-primary btn-sm  hide_addclient" id="hide_addclient" name="<?php echo $_SESSION['cart_id']; ?>"
      >Cancel</button>-->
    </div>
  </div>
</div>