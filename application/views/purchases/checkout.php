<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	
	<script type="text/javascript">
	  	// This identifies your website in the createToken call below
	  	Stripe.setPublishableKey('pk_test_cUl5sdJklHnM8KNXYJ4lq2t4');

	  	var stripeResponseHandler = function(status, response) {
      		var $form = $('#payment-form');

      		if (response.error) {
        		// Show the errors on the form
		        $form.find('.payment-errors').text(response.error.message);
		        $form.find('button').prop('disabled', false);
      		} 
      		else {
        		// token contains id, last4, and card type
        		var token = response.id;
        		$form.append($('<input type="hidden" name= "stripeToken" />').val(token));
        		$form.get(0).submit();
      		}
    	}

	  	jQuery(function($) {
	  		$('#payment-form').submit(function(e) {
	    		var $form = $(this);

	    		$form.find('button').prop('disabled', true);

	    		Stripe.card.createToken($form, stripeResponseHandler);
	    		
				\Stripe\Stripe::setApiKey("sk_test_s3Cmf0hP6WkH3Kyz2uLKjrZq");

				$token = $_POST['stripeToken'];

				try {
					$charge = \Stripe\Charge::create(array(
					  "amount" => 1000,
					  "currency" => "usd",
					  "source" => $token,
					  "card" => $_POST['stripeToken'],
					  "description" => "Example charge")
					);
					} catch(Stripe_CardError $e) {
					   echo "card declined";die();
					}
				});
			});
	</script>

	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/purchases.css">
	<title>H&H Supplies - Checkout</title>
</head>
<body>
	<?php include('partials/purchases_nav.php'); ?>

	<div class="container-fluid">	

		<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$final_price = 0;
				$cart_items = $this->session->userdata('cart_items');
				if(!empty($cart_items)){
				foreach($products as $product){ 
					if($cart_items[$product['id']] !== 0) {	?>
					<tr>
						<td><?= $product['name']; ?></td>
						<td>$<?= $product['price']; ?></td>
						<td><?=$cart_items[$product['id']];
								$id=$product['id']; ?>
							<a href = "/purchases/delete_item_from_cart/<?= $id ?>">
								<img class="checkout icon pull-right" 
								src="/assets/img/trashcan.png"></a>
							<a href="/purchases/get_product_by_id/<?=$product['id']?>"
								 class="pull-right">update</a></td>
						<td>$<? $sub_total = $cart_items[$product['id']] * $product['price'];
							$final_price += $sub_total;
							echo $sub_total ?></td>
					</tr> 
				<?php } } } ?>
			</tbody>
		</table>
		<div class="row">
			<p class="pull-right"><strong>$<?= $final_price; $this->session->set_userdata('price', $final_price); ?></strong></p>
		</div>
		<div class="row">
			<form class="form form-horizontal" role="form" action="/purchases/index" method="post">
				<input type="submit" class="btn btn-success pull-right" value="Continue Shopping">
			</form>
		</div>
		<form id = "payment-form" class="form form-horizontal" action="/purchases/validate_billing" role="form" method="post">
			<h2>Shipping Information</h2>
			<div class="form-group">
				<label for="first_name" class="control-label col-md-2 col-sm-2 col-xs-2">First Name:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_first_name'); ?>
					<input type="text" class="form-control" name="ship_first_name" value="<?php echo set_value('ship_first_name'); ?>"> 
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="control-label col-md-2 col-sm-2 col-xs-2">Last Name:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_last_name'); ?>
					<input type="text" class="form-control" name="ship_last_name" value="<?php echo set_value('ship_last_name'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="control-label col-md-2 col-sm-2 col-xs-2">Address:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_address'); ?>
					<input type="text" class="form-control" name="ship_address" value="<?php echo set_value('ship_address'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="control-label col-md-2 col-sm-2 col-xs-2">City:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_city'); ?>
					<input type="text" class="form-control" name="ship_city" value="<?php echo set_value('ship_city'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="control-label col-md-2 col-sm-2 col-xs-2">State:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_state'); ?>
					<input type="text" class="form-control" name="ship_state" value="<?php echo set_value('ship_state'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="control-label col-md-2 col-sm-2 col-xs-2">Zipcode:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('ship_zipcode'); ?>
					<input type="text" class="form-control" name="ship_zipcode" value="<?php echo set_value('ship_zipcode'); ?>">
				</div>
			</div>

			<h2>Billing Information</h2>

			<div class="form-group">
				<div class="col-md-3 col-sm-5 col-xs-7">
					<div class="checkbox">
						<label><input type="checkbox">Same as Shipping</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="control-label col-md-2 col-sm-2 col-xs-2">First Name:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('first_name'); ?>
					<input type="text" class="form-control" name="first_name" value="<?php echo set_value('first_name'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="control-label col-md-2 col-sm-2 col-xs-2">Last Name:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('last_name'); ?>
					<input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="control-label col-md-2 col-sm-2 col-xs-2">Address:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('address'); ?>
					<input type="text" class="form-control" name="address" value="<?php echo set_value('address'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="control-label col-md-2 col-sm-2 col-xs-2">City:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('last_name'); ?>
					<input type="text" class="form-control" name="city" value="<?php echo set_value('city'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="control-label col-md-2 col-sm-2 col-xs-2">State:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('state'); ?>
					<input type="text" class="form-control" name="state" value="<?php echo set_value('state'); ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="control-label col-md-2 col-sm-2 col-xs-2">Zipcode:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<?php echo form_error('zipcode'); ?>
					<input type="text" class="form-control" name="zipcode" value="<?php echo set_value('zipcode'); ?>">
				</div>
			</div><br>

		<!-- 	<span class="payment-errors"></span>

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-2">Card:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<input type="text" class="form-control" data-stripe="number">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-2">Security Code:</label>
				<div class="col-md-3 col-sm-5 col-xs-7">
					<input type="text" class="form-control" data-stripe="cvc">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-2 col-sm-2 col-xs-2">Expiration:</label>
				<div class="col-md-1 col-sm-1 col-xs-1">
					<input type="text" class="form-control" 
					 	placeholder="(mm)" data-stripe="exp-month">
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					<input type="text" class="form-control" 
						 placeholder="(yyyy)" data-stripe="exp-year">
				</div>
			</div> -->
			 <script
    			src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    			data-key= "pk_test_cUl5sdJklHnM8KNXYJ4lq2t4"
			    data-name= "H & H"
			    data-zip-code= "true"
			    data-amount="<?php echo ($final_price * 100) ?> ">
			  </script>
			<!-- <input type="submit" class="btn btn-primary col-md-offset-8 col-sm-offset-8 col-xs-offset-8" value="Pay"> -->
		</form>
		
	</div>
</body>
</html>