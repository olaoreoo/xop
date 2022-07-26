<?php require_once "../components/userdata.php";  ?>
<?php
if (isset($_SESSION['cart_id'])) {
    $cart_id = $_SESSION['cart_id'];
} else {
    $newcart_id =  $user->create_cart_id(8);
    $_SESSION['cart_id']=$cart_id=$newcart_id;
}

try {
    $stmt = $user->runQuery("
		SELECT * 
		FROM tbl_cart 
		WHERE cart_id=:cart_id
		ORDER BY add_time DESC
		");
    $stmt->execute(array(":cart_id"=>$cart_id,));
    $cart_items=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $c_count=$stmt->rowCount();
    
    if ($c_count>0) {
        $cart_total_val=0;
        $prod_total_val=0;
        foreach ($cart_items as $data) {
            $cart_total_val=$cart_total_val+$prod_total_val;
        }
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
 ?>
<!--<hr />-->
<?php if ($c_count>0) {?>
<table class="responsive" width="100%">
	<?php $prod_total=0;  $cart_total_val=0;
     foreach ($cart_items as $data) {
         $id=$data['id'];
         $prod_id=$data['prod_id'];
         $prod_name=$user->getProdName($prod_id);
         $prod_qty=$data['qty'];
         $prod_tot=$data['prod_tot'];
         $prod_total=$prod_total+$prod_tot;
         //get_prod_total_value();?>

	<tr>
		<td width="79%" nowrap="nowrap">(<?php echo $prod_qty; ?>)<span> <?php echo $user->read_more($prod_name); ?></span></td>
		<td width="20%" align="right"><span align="right"><?php echo $user->fmtCurDisp($prod_tot); ?></span></td>
		<td width="1%"><span align="right" id="<?php echo $id; ?>"
				cart_id="<?php echo $cart_id; ?>"
				class="rem_item rem_well"><a href="javascript:;" title="Remove Item">Del</a></span></td>
	</tr>
	<?php
     } ?>
	<br />
	<tr></tr>
	<tr>
		<td>Total Orders - <?php echo $c_count; ?>
		</td>
		<td align="right" nowrap="nowrap"><strong><span align="right"><?php echo $user->fmtCurDisp($prod_total); ?></span></strong>
		</td>
		<td width="1%"><span align="right" id="clear_cart"
				cart_id="<?php echo $cart_id; ?>"
				class=" rem_well"><a href="javascript:;" title="Empty Cart">Clear</a></span></td>
	</tr>
</table>
<div class="border-bottom"></div>
<?php } else { ?>
<div class=" itemlist"><br />
	<table class="responsive" width="100%">
		<tr>
			<td><span>No items selected!</span></td>
		</tr>
	</table><br />
</div>
<?php } ?>
<hr />