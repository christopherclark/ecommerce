<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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

					foreach($products as $product){ ?>
				<tr> <php $id = $product['id']; ?>
				<td><?= $product['name']; ?></td>
				<td>$<?= $product['price']; ?></td>
				<td><?=$cart_items[$product['id']]; ?>
					<img class="checkout icon pull-right" src="/assets/img/trashcan.png">
					<a href="/purchases/get_product_by_id/<?=$product['id']?>" class="pull-right">update</a></td>
				<td>$<? $sub_total = $cart_items[$product['id']] * $product['price'];
					$final_price += $sub_total;
					echo $sub_total ?></td>
				</tr> 
					<?php } ?>
			</tbody>
		</table>
		<div class="row">
			<p class="pull-right"><strong>$<?= $final_price ?></strong></p>
		</div>
		<div class="row">
			<form class="form form-horizontal" role="form" action="/purchases/index" method="post">
				<input type="submit" class="btn btn-success pull-right" value="Continue Shopping">
			</form>
		</div>
		<form class="form form-horizontal" role="form">
			<h2>Shipping Information</h2>
			<div class="form-group">
				<label for="first_name" class="control-label col-md-2 col-sm-2 col-xs-2">First Name:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="first_name">
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="control-label col-md-2 col-sm-2 col-xs-2">Last Name:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="last_name">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="control-label col-md-2 col-sm-2 col-xs-2">Address:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="address">
				</div>
			</div>
			<div class="form-group">
				<label for="address2" class="control-label col-md-2 col-sm-2 col-xs-2">Address 2:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="address2">
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="control-label col-md-2 col-sm-2 col-xs-2">City:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="city">
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="control-label col-md-2 col-sm-2 col-xs-2">State:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="state">
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="control-label col-md-2 col-sm-2 col-xs-2">Zipcode:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="zipcode">
				</div>
			</div>

			<h2>Billing Information</h2>

			<div class="form-group">
				<div class="col-md-4 col-sm-6 col-xs-8">
					<div class="checkbox">
						<label><input type="checkbox">Same as Shipping</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="control-label col-md-2 col-sm-2 col-xs-2">First Name:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="first_name">
				</div>
			</div>
			<div class="form-group">
				<label for="last_name" class="control-label col-md-2 col-sm-2 col-xs-2">Last Name:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="last_name">
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="control-label col-md-2 col-sm-2 col-xs-2">Address:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="address">
				</div>
			</div>
			<div class="form-group">
				<label for="address2" class="control-label col-md-2 col-sm-2 col-xs-2">Address 2:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="address2">
				</div>
			</div>
			<div class="form-group">
				<label for="city" class="control-label col-md-2 col-sm-2 col-xs-2">City:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="city">
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="control-label col-md-2 col-sm-2 col-xs-2">State:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="state">
				</div>
			</div>
			<div class="form-group">
				<label for="zipcode" class="control-label col-md-2 col-sm-2 col-xs-2">Zipcode:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="zipcode">
				</div>
			</div>

			<div class="form-group">
				<label for="card" class="control-label col-md-2 col-sm-2 col-xs-2">Card:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="card">
				</div>
			</div>
			<div class="form-group">
				<label for="security_code" class="control-label col-md-2 col-sm-2 col-xs-2">Security Code:</label>
				<div class="col-md-4 col-sm-6 col-xs-8">
					<input type="text" class="form-control" name="security_code">
				</div>
			</div>

			<div class="form-group">
				<label for="expiration_month" class="control-label col-md-2 col-sm-2 col-xs-2">Expiration:</label>
				<div class="col-md-2 col-sm-2 col-xs-2">
					<input type="text" class="form-control" name="expiration_month" placeholder="(mm)">
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2">
					<input type="text" class="form-control" name="expiration_year" placeholder="(yyyy)">
				</div>
			</div>
			<input type="submit" class="btn btn-primary col-md-offset-8 col-sm-offset-8 col-xs-offset-8" value="Pay">
		</form>
	</div>

</body>
</html>