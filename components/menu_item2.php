<?php require_once "../config/phpconfig.php";  
				        try { // select products by category
						if(isset($_SESSION['cart_id'])){ $cart_id=$_SESSION['cart_id']; }
						if(isset($_GET['prod_id'])){ $prod_id=$_GET['prod_id']; }
						$user=new USER;
						
            $stmt = $user->runQuery("SELECT * 
			FROM tbl_products 
			WHERE id={$prod_id}
			ORDER BY prod_name ASC ");
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
			$getAllCount=$stmt->RowCount();
					$id=$data['id'];
                   $name=$data['prod_name'];
                   $price=$data['prod_price'];
                   $desc=$data['prod_desc'];
                   
                          $prod_cat=$data['prod_cat'];
		   switch ($prod_cat) {
  case 'Food':
                   $img_check='components/pics_food/'.$prod_id.'.jpg';
				         $pwidth="400px";
                        $pheight="210px";

    break;
  case 'Drinks':
                   $img_check='components/pics_drinks/'.$prod_id.'.jpg';
				         $pwidth="auto";
                        $pheight="60px";
						  break;
  case 'Chops':
                   $img_check='components/pics_chos/'.$prod_id.'.jpg';
				   		$pwidth="400px";
                        $pheight="210px";

    break;

  default:
                   $img_check="components/pics_food/default.jpg";
				   	$pwidth="auto";
                        $pheight="auto";

}
              
				 //  echo $img_url;

if (@getimagesize($img_check)) {
//echo  "image exists ";
} else {
//echo  "image does not exist ";
}
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="block wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
        <div class="item text-center ">
          <hr />
          <?php // if (is_file($img_check)) { ?>
          <div align="center">
          <a class="combo_select"
                      id="<?php echo $id; ?>"
                     pval="<?php echo $price; ?>"
                      href="javascript:;">
                      <img
                        class="img-responsive"
                        src="<?php echo $img_check; ?>"
                        width="<?php echo $pwidth; ?>"
                        height="<?php echo $pheight; ?>"
                        alt="<?php echo $name; ?>" 
                        title="<?php echo $id; ?>"
                        ></a>
          </div> <?php //}?><hr />

         <div class=""> 
            <input name="prod_qty"
                        type="text" class="price_in text-center col-md-1"
                        id="prod_qty" value="1"
                        size="2" maxlength="2"
placeholder="1"  
onfocus="this.value = '' "  
onblur="this.placeholder='1'"                         >
            <input name="cart_id"
                        type="hidden" class="form-control"
                        id="cart_id"
                        value="<?php echo $cart_id; ?>"><span><a class="btn-sm  order_item"
                          id="<?php echo $id; ?>"
                          prod_id="<?php echo $id; ?>"
                          name="order_item"
                          price_val="<?php echo $price; ?>"
                          href="javascript:;">Add</a></span>
            <!--<a class="btn-sm btn-danger order_item"
                          id="<?php echo $id; ?>"
                          name="order_item"
                          cart_id="<?php echo $cart_id; ?>"
							price_val="<?php echo $price; ?>"

                          href="javascript:;">Add to Cart!</a>-->
          </div> <div class="price"><?php echo  $user->fmtCur($price); ?> </div>
          
        </div>
      </div>
    </div>
    <!-- .col-md-12 close --> 
  </div>
  <!-- .row close --> 
</div>
<!-- .container close -->