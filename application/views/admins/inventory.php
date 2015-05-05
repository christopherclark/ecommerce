<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - All Products</title>
	<style type="text/css">
		#delete_btn {
			background-color: white;
			color: blue;
			border: none;
			margin: 0em;
			margin-left: 0.5em;
			padding: 0em;
		}
		a {
			color: blue;
			display: inline-block;
		}
		#delete_form {
			display: inline-block;
		}
	</style>
</head>
<body>
	<?php include('partials/admins_nav.php'); ?>
		<div class='container'>
		<div class='row'>
			<div class='col-md-3'>
				<form action='' method='post'>
					<div class='form-group'>
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						<input type='text' name='search' placeholder='search'>
					</div>
				</form>
			</div>
			<div class='col-md-offset-10'>
				</form action='' method='post'>
					<div class='form-group'>
						<input type='submit' value='Add a new product' class='btn btn-primary'>
					</div>
				</form>
			</div>
		</div>
		<table class='table table-striped table-bordered'>
			<thead>
				<tr>
					<td>Picture</td>
					<td>ID</td>
					<td>Name</td>
					<td>Inventory Count</td>
					<td>Quantity Sold</td>
					<td>Action</td>
					
				</tr>
			</thead>
			<tbody>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td></td>
					<td><?= $product['id']?></td>
					<td><?= $product['name']?></td>
					<td><?= $product['in_stock']?></td>
					<td><?= $product['quantity_sold']?></td>
					<td><a href="/admins/get_product_by_id/<?= $product['id']?>">edit</a> 
						<form action="admins/delete_product" id='delete_form'>
							<input type='hidden' name='id' value='<?=$product["id"]?>'>
							<input type='submit' value='delete' id='delete_btn'>
						</form></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div id='pagination'>
		</div>
	</div>
</body>
</html>