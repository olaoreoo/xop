<?php require_once "../config/phpconfig.php";  ?>
<section id="search">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block wow fadeInUp" data-wow-duration="500ms" data-wow-delay="300ms">
          <div class="title">
            <h3>Quick <span>Search</span></h3>
          </div>
<select name="search_box" size="1" class="form-control  orderselect select2" id="search_box" >
            <option class="btn-secondary" value="">Search...</option>
            <?php
				        try { // select products by category
            $stmt = $user->runQuery("SELECT * 
			FROM tbl_products 
			ORDER BY prod_name ASC ");
            $stmt->execute();
            $getAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }

       foreach ($getAll as $data) {
           $prod_id=$data['id'];
           $prod_name=$data['prod_name'];
           $prod_price=$data['prod_price'];
           $avail=$data['avail'];
				if ($avail=="Available") {
				$trans_type="Debit";
				} else {
				$trans_type="Credit";
				} 
           $stk_amt=$data['stk_amt'];
           $stk_low=$data['stk_low'];
			   if (($stk_amt>=$stk_low) &&  ($avail=="Available")) {
				   $avail_lbl='text-secondary';
			   } else {
				   $avail_lbl='text-danger';
			   } 
			   
			   
		   ?>
            <option id="<?php echo $prod_id; ?>"
                  aname="<?php echo $prod_price; ?>"
                  value="<?php echo $prod_price; ?>"
                  class="<?php echo $avail_lbl ?>"> <?php //echo $prod_id.' - '; ?> <?php echo $prod_name; ?>
            <?php //echo $prod_price; ?>
            </option>
            <?php
       } ?>
          </select>
        </div>
        <div id="search_result" name="search_result" class="block wow fadeInUp " data-wow-duration="500ms" data-wow-delay="300ms">
          <div id="result_cont" name="result_cont" class="" align="center"></div>
        </div>
      </div>
      <!-- .col-md-12 close --> 
    </div>
    <!-- .row close --> 
  </div>
  <!-- .container close --> 
</section>
<script>
//
$(function(){
	$(".orderselect").select2();
	});
//
    </script>