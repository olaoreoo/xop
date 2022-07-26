<?php require_once "phpconfig.php";
//$cart_id=$_SESSION['cart_id'];
                        try { // select products by category
                            $user=new USER;
                            $stmt = $user->runQuery("SELECT * 
			FROM tbl_products 
			WHERE prod_class='Combos'
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
						<h3>Featured <span>Combos</span> <span class="sectionwell"><?php echo $getAllCount; ?></span></h3>
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
           } ?>
						<div class="item ">
							<div class="food-item "><a class="combo_select"
									id="<?php echo $id; ?>"
									pval="<?php echo $price; ?>"
									href="javascript:;"><img
										src="<?php echo $img_desc; ?>"
										width="390px" height="210px"
										alt="<?php echo $name; ?>"
										title="<?php echo $id; ?>"></a>
								<div><span class="price"> @ <?php echo  $user->fmtCur($price); ?></span><span><a
											class="btn-sm  order_item"
											id="<?php echo $id; ?>"
											prod_id="<?php echo $id; ?>"
											name="order_item"
											cart_id="<?php echo $cart_id; ?>"
											price_val="<?php echo $price; ?>"
											href="javascript:;">Add</a></span>
									<span><input name="prod_qty<?php echo $id;?>" type="number" class="price_in text-center " id="prod_qty<?php echo $id;?>" value="1"
							 maxlength="2" onfocus="this.value = ''"></span>
								</div>
								<h5><?php echo $name; ?>
								</h5>
								<div class="row">
									<p><?php echo $desc; ?>
									</p>
									<br>

									<input name="cart_id" type="hidden" class="form-control" id="cart_id"
										value="<?php echo $cart_id; ?>">
								</div>
								<div></div>
							</div>
						</div>
						<?php
       } ?>
					</div>
				</div>
			</div>
			<!-- .col-md-12 close -->
		</div>
		<!-- .row close -->
	</div>
	<!-- .container close -->
</section>