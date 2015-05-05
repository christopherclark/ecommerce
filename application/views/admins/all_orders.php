<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - Orders</title>
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
						<select>
							<option value='show all'>Show all</option>
							<option value='order in process'>Order in process</option>
							<option value='shipped'>Shipped</option>
							<option value='cancelled'>Cancelled</option>
						</select>
					</div>
				</form>
			</div>
		</div>
		<table class='table table-striped table-bordered'>
			<thead>
				<tr>
					<td>Order ID</td>
					<td>Name</td>
					<td>Date</td>
					<td>Billing Address</td>
					<td>Total</td>
					<td>Status</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orders as $order) { ?>
				<tr>
					<td><a href="/admins/get_order_by_id/<?=$order['id']?>"><?= $order['id']?></a></td>
					<td><?php echo $order['billing_first'] . " " . $order['billing_last']?></td>
					<td><?php echo $order['created_at']?></td>
					<td><?php echo $order['billing_address'] . " " . $order['billing_city'] . ", " . $order['billing_state'] . " " . $order['billing_zip']?></td>
					<td><?= $order['total_price']?></td>
					<td>

						<form action='' method='post'>
							<select name='status'>
								<option value='<?=$order["status"]?>'><?=$order['status']?></option>
								<?php if ($order['status'] == 'Order in process') { ?>
									<option value='Shipped'>Shipped</option>
									<option value='Cancelled'>Cancelled</option>
								<?php } else if ($order['status'] == 'Shipped') { ?>
									<option value='Order in process'>Order in process</option>
									<option value='Cancelled'>Cancelled</option>
								<?php } else { ?>
									<option value='Order in process'>Order in process</option>
									<option value='Shipped'>Shipped</option>
								<?php } ?>
							</select>
						</form>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<div id='pagination'>
		</div>
	</div>
</body>
</html>