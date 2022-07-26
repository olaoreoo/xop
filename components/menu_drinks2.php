<?php require_once "config/phpconfig.php";  
				        try { // select products by category
						$user=new USER;
            $stmt = $user->runQuery("SELECT * 
			FROM tbl_products 
			WHERE prod_cat='Drinks'
			ORDER BY prod_name ASC ");
            $stmt->execute();
            $getAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$getAllCount=$stmt->RowCount();
			
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
?>
<section id="slider">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
          <div class="title">
            <h3>Featured <span>Combos</span></h3>
          </div>
          <div id="owl-example" class="owl-carousel">
         <?php

       foreach ($getAll as $data) {
			   			                   $id=$data['id'];
                   $name=$data['prod_name'];
                   $price=$data['prod_price'];
                   $desc=$data['prod_desc'];
                   
                                   
                   $img_check='components/pics_food/'.$id.'.jpg';
                   if (is_file($img_check)) {
                       $img_desc= $img_check;
                   } else {
                       $img_desc='components/pics_food/default.png';
                   } 

		   ?>
<div class="item ">
            <div class="food-item "><a class="order_item"
                      id="<?php echo $id; ?>"
                      href="javascript:;"><img
                        src="<?php echo $img_desc; ?>"
                        alt="<?php echo $name; ?>" 
                        title="<?php echo $desc; ?>"></a>
              <div class="price"><?php echo  $user->fmtCur($price); ?>
              </div>
              
            </div>
          </div><?php } ?>
         <div class="text-content">
                <label for="add_qty">Quantity</label>
                <input name="<?php echo $id; ?>_qty"
                        type="text" class="form-control"
                        id="<?php echo $id; ?>_qty" value="1"
                        size="3" maxlength="3">
                <input name="<?php echo $id; ?>_price"
                        type="hidden" class="form-control"
                        id="<?php echo $id; ?>_price"
                        value="<?php echo $price; ?>">
                <input name="cart_id" type="hidden" class="form-control" id="cart_id"
                        value="<?php //echo $cart_id; ?>">
                <h4><?php echo $name; ?>
                </h4>
                <p><?php echo $desc; ?>
                </p>
                <div><a class="btn btn-danger order_item"
                          id="<?php echo $id; ?>" name="order_combo"
                          href="javascript:;">Order!</a></div>
              </div> </div>
        </div>
      </div>
      <!-- .col-md-12 close --> 
    </div>
    <!-- .row close --> 
  </div>
  <!-- .container close --> 
</section>
