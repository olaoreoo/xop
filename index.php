<?php require_once "config/phpconfig.php";  ?>
<?php
if (isset($_SESSION['cart_id'])) {
    $cart_id = trim($_SESSION['cart_id']);
} else {
    $newcart_id =  $user->create_cart_id(8);
    $_SESSION['cart_id']=$cart_id=$newcart_id;
}
    if (isset($_SESSION['cust_name']) || isset($_SESSION['cust_tel'])) {
        $greet = trim($_SESSION['cust_name']) || $greet = trim($_SESSION['cust_tel']);
    } else {
        $greet =  "Guest";
    }
  ?>
<!DOCTYPE html>
<html class="no-js">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>XXV On Point Resorts</title>

	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.css">
	<!-- bootstrap.min css -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Font-awesome.min css -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Main Stylesheet -->
	<link rel="stylesheet" href="css/animate.min.css">

	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="library/select2/css/select2.css">
	<!-- Responsive Stylesheet -->
	<link rel="stylesheet" href="css/responsive.css">
	<link rel="stylesheet" href="css/custom.css">
	<!-- Js -->
	<script src="js/vendor/modernizr-2.6.2.min.js"></script>
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
	<script>
		window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')
	</script>
</head>

<body>
	<!--
	header-img start 
	============================== -->
	<section id="hero-area">
		<img class="img-responsive" src="images/header.jpg" alt="">
	</section>
	<!--
    Header start 
	============================== -->
	<nav id="navigation">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<nav class="navbar navbar-default">
							<div class="container-fluid">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									<button type="button" class="navbar-toggle collapsed viewcart"
										data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
										cart_id="<?php echo $cart_id; ?>">
										<span class="sr-only">Toggle navigation</span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</button>
									<!--<a class="navbar-brand" href="#">
                                    <img src="images/logo.png" alt="Logo">
                                  </a>-->
									<div class="">
										<div><span class="greeting" id="greeting"></span><span class="btn greet"><?php echo $greet; ?></span>
										</div>
										<div> <span class="btn">My Cart </span>
											<span id="cart_tot" name="cart_tot" class="cart_tot_well"></span>
											<span id="cart_val" name="cart_val" class="cart_val_well"></span>
										</div>
										<div id="msg_box" name="msg_box" class="msg_box ">
											<div id="msg_cont" name="msg_cont" class=" msg_cont">
											</div>
										</div>

									</div>
								</div>

								<!-- Collect the nav links, forms, and other content for toggling -->
								<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
									<div id="cart_cont" name="cart_cont" class="hide"></div>
								</div>
								<!-- /.navbar-collapse -->
							</div><!-- /.container-fluid -->
						</nav>
					</div>
				</div><!-- .col-md-12 close -->
			</div><!-- .row close -->
		</div><!-- .container close -->
	</nav><!-- header close -->
	<!--
    Slider start
    
    ============================== -->
	<!-- slider close -->
	<div id="search_cont" name="search_cont" class=""></div>
	<div id="menu_cont" name="menu_cont" class=""></div>
	<div id="chops_cont" name="chops_cont" class=""></div>

	<?php require_once "components/menu.php";  ?>
	<?php  require_once "components/menu_chops.php";  ?>
	<?php  require_once "components/menu_drinks.php";  ?>
	<?php require_once "components/footer.php";  ?>


	<script src="js/jquery.nav.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/custom.js"></script>
	<script src="library/select2/js/select2.full.js"></script>

</body>

</html>