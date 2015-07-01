<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/purchases.css">
	<title>H&H Supplies - Checkout</title>
	<style>
		h2{text-align: center;}
		p{text-align: center;}
	</style>
</head>
<body>
	<?php include('partials/purchases_nav.php'); ?>
	<h2>Customers who purchased this item also bought:</h2><br>
	<form id = "selfie" action = "/purchases/selfie"   method = "post">
		Item #:<input type = "text" name= "id">
	</form>

<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<tr>
					<th>Item</th>
					<th>Price</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$also_bought = ?;
				if(!empty($also_bought)){
				foreach($ids as $id){ ?>
					<tr>
						<td><?= $product['name']; ?></td>
						<td>$<?= $product['price']; ?></td>
					</tr> 
				<?php } } } ?>
			</tbody>
		</table>

</body>
<html>