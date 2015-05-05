<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - View Order</title>
	<style type="text/css">
		#bordered {
			border: 0.2em solid black;
			padding: 1em 1em;
		}
		#lower {
			margin-top: 5em;
		}
		#small-bordered {
			border: 0.2em solid black;
		}
		#blue {
			background-color: lightblue;
			border: 0.2em solid black;
			padding: 0.5em;
		}
		#green {
			background-color: lightgreen;
			border: 0.2em solid black;
			padding: 0.5em;
		}
		#red {
			background-color: red;
			color: white;
			border: 0.2em solid black;
			padding: 0.5em;
		}
	</style>
</head>

<body>
	<?php include('partials/admins_nav.php'); ?>
	<div class='container-fluid'>
		<div class='row'>
			<div id='bordered' class='col-md-3 col-md-offset-1'>
				<p>Order ID: <?= $order['id']?></p><br>
				<p>Customer shipping info:</p>
				<p>Name: <?= $order['shipping_first']?> <?=$order['shipping_last']?></p>
				<p>Address: <?= $order['shipping_address']?></p>
				<p>City: <?= $order['shipping_city']?></p>
				<p>State: <?= $order['shipping_state']?></p>
				<p>Zip: <?= $order['shipping_zip']?></p><br>
				<p>Customer billing info: </p>
				<p>Name: <?= $order['billing_first']?> <?= $order['billing_last']?></p>
				<p>Address: <?= $order['billing_address']?></p>
				<p>City: <?= $order['billing_city']?></p>
				<p>State: <?= $order['billing_state']?></p>
				<p>Zip: <?= $order['billing_zip']?></p>
			</div>
			<div class='col-md-6 col-md-offset-1'>
				<table class='table table-striped table-bordered'>
					<thead>
						<tr>
							<td>ID</td>
							<td>Item</td>
							<td>Price</td>
							<td>Quantity</td>
							<td>Total</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($products as $product) { ?>
							<tr>
								<td><?=$product['id']?></td>
								<td><?=$product['name']?></td>
								<td>$<?=$product['price']?></td>
								<td><?=$product['quantity']?></td>
								<td>$<?php echo $product['price']*$product['quantity']?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<div class='row' id='lower'>
					<div class='col-md-5'>
						<?php if($order['status']=='Order in process') { ?>
							<p id='blue'>Status: <?=$order['status']?></p>
						<?php } else if($order['status']=='Shipped') { ?>
							<p id='green'>Status: <?=$order['status']?></p>
						<?php } else { ?>
							<p id='red'>Status: <?=$order['status']?></p>
						<?php } ?>
					</div>
					<div class='col-md-4 col-md-offset-2' id='small-bordered'>
						<p>Subtotal: $<?php $sum = 0;
							foreach ($products as $product) {
							$sum += $product['quantity']*$product['price'];
							}
							echo $sum;?></p>
						<p>Shipping: $1.00</p>
						<p>Total Price: $<?php echo $sum + 1;?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>