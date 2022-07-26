// JavaScript Document
$(document).ready(function () {

	msg_box = $('#msg_box');
	msg_cont = $('#msg_cont');
	//
function timedmsg(){
	msg_cont.html('<span class="text-primary"><strong class="text-warning">Hi</strong>, its so nice having you here.');
}
	setInterval(timedmsg, 15000);
	msg_cont.html('<span class="text-primary"><strong class="text-warning">Welcome!</strong> What can we offer you?</span>');

	function loadui(){
		search_cont = $('#search_cont');
		var load_url = "components/search.php";
		search_cont.load(load_url);
		//
		chops_cont = $('#chops_cont');
		var load_url = "components/menu_chops.php";
		//chops_cont.load(load_url);

		//
		menu_cont = $('#menu_cont');
		var load_url = "components/menu.php";
		//menu_cont.load(load_url);

	}
loadui();
	//
	const greeting = document.getElementById("greeting");
	const hour = new Date().getHours();
	const welcomeTypes = ["Good morning", "Good afternoon", "Good evening"];
	let welcomeText = "";

	if (hour < 12) welcomeText = welcomeTypes[0];
	else if (hour < 18) welcomeText = welcomeTypes[1];
	else welcomeText = welcomeTypes[2];

	greeting.innerHTML = welcomeText;


	function clear_msgs() {
		//msg_cont.addClass('hide');
		return;
	}
	//clear_msgs();

	function loadcartlist(){
		cart_cont = $('#cart_cont');
		var load_url = "components/mycart.php?cart_id=" + cart_id;
		cart_cont.load(load_url);
		console.log('-client cart loaded');
	}

	function get_prod_total() {
		var cart_tot_well = $(".cart_tot_well");
		var load_url = "components/get_total_items.php?";
		cart_tot_well.load(load_url);
		return;
	}

	get_prod_total();
	function get_prod_total_value() {
		var cart_val_well = $(".cart_val_well");
		var load_url = "components/get_total_items_value.php?";
		cart_val_well.load(load_url);
		return;
	}

	get_prod_total_value();
	function reload_cart() {
		get_prod_total();
		get_prod_total_value();
		console.log(' counts reloaded');
		return;
	}

	function startreload() {
		console.log('auto reload started');
		prod_total = setInterval(get_prod_total, 1000);
		prod_value = setInterval(get_prod_total_value, 1000);
		setTimeout(clear_msgs, 1000);
		return;
	}

	function URLRedirect(URLStr) {
		location = URLStr;
	}

	$(document).on("change", "#search_box", function (event) {
		event.preventDefault();
		sel_id = this.id;
		console.log(sel_id);
		prod_id = $('option:selected', this).attr('id');
		console.log('prod_id = ' + prod_id);
		prod_val = $('option:selected', this).attr('value');
		console.log("prod_val = " + prod_val);
		//
		var result_cont = $("#result_cont");
		var load_url = "components/menu_item.php?prod_id="+prod_id;
		result_cont.load(load_url);
//
		//$('#search_result').toggleClass('hide');
		console.log("search results shown");
		//
		return;
	});

	
	// initiate order
	$(document).on("click", ".order_item", function (event) {
		event.preventDefault();
		sect_id = this.id;
		console.log(sect_id);
		console.log(" order made");
		qty_val = $('#prod_qty'+sect_id).val();
		console.log(qty_val);
		price_val = $(this).attr('price_val');
		cart_id = $(this).attr('cart_id');
		console.log(cart_id);

		msg_cont.html("Submiting your order...");

		if (typeof sect_id == 'undefined') {
			alert("You have not selected an item!");
			return false;
		}

		var posturl = "components/post_cart.php";

		var formData = {
			prod_id: sect_id,
			price_val: price_val,
			qty_val: qty_val,
			cart_id: cart_id,
		};

		$.ajax({
			type: "POST",
			url: posturl,
			data: formData,
			cache: false,
			dataType: "JSON",
		}).done(function (data) {
			if (data.success_db == "success") {
				console.log(data);
				$('#cart_tot').val(data.ctotal);
				$('#cart_val').val(data.cartval);
				msg_cont.html("Order successful. ");
			} else if (data.stockcheck_db == 0) {
				console.log(data);
				alert("Sorry, not enough in stock!");
				var nexturl = "index.php";
			} else {
				console.log(data);
				alert("Sorry, there was an error !");
				var nexturl = "index.php";
			}
			//
			reload_cart();
			loadcartlist();
			msg_cont.append('<span class="text-primary"> Need something else? </span>');
			//setTimeout(clear_msgs, 3000);
			//alert(data.message_db);

			var search_cont = $("#search_cont");
			var load_url = "components/search.php?";
			search_cont.load(load_url);
			nexturl="index.php";
			loadui();

			//URLRedirect(nexturl);
		});
	});

	$(document).on("click", ".viewcart", function (event) {
		event.preventDefault();
		msg_cont.html("Hope you are not leaving now?");

		console.log('-request to view cart');
		cart_id = $(this).attr('cart_id');
		console.log(cart_id);

		cart_cont = $('#cart_cont');
		var load_url = "components/mycart.php?cart_id=" + cart_id;
		cart_cont.load(load_url);
		$(cart_cont).toggleClass('hide');
		return;
	});

	// remove item from cart in client list view
	$(document).on("click", ".rem_item", function (event) {
		event.preventDefault();
		item_id = this.id;
		console.log(item_id);
		cart_id = $(this).attr('cart_id');
		console.log(cart_id);
		msg_cont.html("Removing item..");

		var posturl = "components/del_cartitem.php?item_id=" + item_id + "&cart_id=" + cart_id;
		var formData = {
			itemid: item_id,
			cart_id: cart_id,
		};
		$.ajax({
			type: "POST",
			url: posturl,
			data: formData,
			cache: false,
			dataType: "JSON",
		}).done(function (data) {
			if (data.success_db == "success") {
				console.log(data.message_db);

			} else {
				console.log(data.message_db);
			}
			cart_cont = $('#cart_cont');
			var load_url = "components/mycart.php";
			cart_cont.load(load_url);
			$(cart_cont).removeClass('hide');
			$(msg_cont).html("Order removed. ");
			$(msg_cont).append('<span class="text-primary">Want something else?</span>');
			reload_cart();
			return;
		});
	});

	$(document).on("click", "#clear_cart", function (event) {
		event.preventDefault();
		console.log('-request to clear cart');

		cart_id = $(this).attr('cart_id');
		console.log(cart_id);

		var posturl = "components/del_cart.php?cart_id=" + cart_id;
		var formData = {
			cart_id: cart_id,
		};
		$.ajax({
			type: "POST",
			url: posturl,
			data: formData,
			cache: false,
			dataType: "JSON",
		}).done(function (data) {
			if (data.success_db == "success") {
				console.log(data.message_db);
			} else {
				console.log(data.message_db);
			}
			cart_cont = $('#cart_cont');
			var load_url = "components/mycart.php";
			cart_cont.load(load_url);
			$(cart_cont).removeClass('hide');

			reload_cart();
			$(msg_cont).html("We are ready to take another?");
			console.log('-client orders loaded');
			nexturl = "index.php";
			URLRedirect(nexturl);
			return;
		});
	});
})