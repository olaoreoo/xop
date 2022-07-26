<?php //require_once "config/phpconfig.php";
                        try { // select products by category
                        $user=new USER;
                            $stmt = $user->runQuery("SELECT * 
			FROM tbl_products 
			WHERE prod_cat='Drinks'
			AND prod_class='Wine'
			ORDER BY prod_name ASC ");
                            $stmt->execute();
                            $getDrinks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $getDrinksCount=$stmt->RowCount();
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
						<h3>Featured <span>Drinks</span> <span class="sectionwell"><?php echo $getDrinksCount; ?></span></h3>
					</div>
					<div id="owl-drinks" class="owl-carousel">
						<?php

       foreach ($getDrinks as $data) {
           $id=$data['id'];
           $name=$data['prod_name'];
           $price=$data['prod_price'];
           $desc=$data['prod_desc'];
                                   
           $img_check='components/pics_drinks/'.$id.'.jpg';
           if (is_file($img_check)) {
               $img_desc= $img_check;
           } else {
               $img_desc='components/pics_drinks/default.png';
           } ?>
						<div class="item ">
							<div class="food-item "><a class="drinks_select"
									id="<?php echo $id; ?>"
									pval="<?php echo $price; ?>"
									href="javascript:;"><img
										src="<?php echo $img_desc; ?>"
										height="50px"
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