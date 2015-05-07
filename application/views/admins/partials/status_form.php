<div>
	<div class='row'>
		<div class='col-md-3'>
			<form action='/admins/search_orders' method='post' class='update_form'>
				<input type='hidden' name='page_no' value='<?=$page_no?>'>
				<input type='hidden' name='statuses' value='<?=$statuses?>'>
				<div class='form-group'>
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					<input type='text' name='search' placeholder='search'>
				</div>
			</form>
		</div>
		<div class='col-md-offset-10'>
			<form action='/admins/filter_by_status' method='post' class='update_form'>
				<input type='hidden' name='page_no' value='<?=$page_no?>'>
				<div class='form-group'>
					<select name='statuses'>
						<?php if($statuses == 'show all') { ?>
							<option value='show all'>Show all</option>
							<option value='order in process'>Order in process</option>
							<option value='shipped'>Shipped</option>
							<option value='cancelled'>Cancelled</option>
						<?php } else if($statuses == 'order in process') { ?>
							<option value='order in process'>Order in process</option>
							<option value='show all'>Show all</option>
							<option value='shipped'>Shipped</option>
							<option value='cancelled'>Cancelled</option>
						<?php } else if($statuses == 'shipped') { ?>
							<option value='shipped'>Shipped</option>
							<option value='show all'>Show all</option>
							<option value='order in process'>Order in process</option>
							<option value='cancelled'>Cancelled</option>
						<?php } else { ?>
							<option value='cancelled'>Cancelled</option>
							<option value='show all'>Show all</option>
							<option value='order in process'>Order in process</option>
							<option value='shipped'>Shipped</option>
						<?php } ?>
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
				<td><form action='/admins/update_order_status' method='post' class='update_form'>
						<input type='hidden' name='id' value='<?=$order["id"]?>'>
						<input type='hidden' name='statuses' value='<?=$statuses?>'>
						<input type='hidden' name='page_no' value='<?=$page_no?>'>
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
	<?php $num = ceil(intval($count['count']) / 8);
		for ($page = 1; $page<=$num; $page++) { ?>
			<form class='pages' action='/admins/filter_by_status' method='post'>
				<input type='hidden' name='page_no' value='<?php echo $page -1 ?>'>
				<input type='hidden' name='statuses' value='<?=$statuses?>'>
				<input type='submit' value='<?=$page?>'>
			</form>
		<?php } ?>
	</div>
</div>