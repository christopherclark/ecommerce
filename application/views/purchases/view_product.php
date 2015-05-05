<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/purchases.css">
	<title>H&H Supplies - Product Info</title>
</head>
<body>
	<?php include('partials/purchases_nav.php'); ?>
   	<div class="container-fluid">

		<!-- PRODUCT INF0 SECTION -->
		<h1>Used Horseshoe</h1>
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-4"> <!-- left third -->
				<img src="/assets/img/used_horseshoe.png" width="100%" alt="thumbnail">
				<div class="row">
					<?php for ($i=0; $i<4; $i++) { ?>
					<div class="col-md-3 col-sm-3 col-xs-3">
						<img src="/assets/img/used_horseshoe.png" width="100%" alt="thumbnail">
					</div>
					<?php } ?>
				</div>
			</div> <!-- closes left third -->
			<div class="col-md-8 col-sm-8 col-xs-8"> <!-- right third -->
				<p> <?php for ($i=0; $i<20; $i++) { ?>
					Description about the product... 
					<?php } ?>
				</p>
				<form class="form-inline col-md-offset-8 col-md-4 col-sm-offset-8 col-sm-4 col-xs-offset-8 col-xs-4" 
						action="/purchases/add_to_cart" method="post">
					<div class="form-group">
						<select name="quantity">
							<option value="1">1 ($19.99)</option>
							<option value="2">2 ($39.98)</option>
							<option value="3">3 ($59.97)</option>
						</select>
					</div>
					<input type = "hidden" name = "id" value = "<?= $id?>">
					<input type="submit" value="Add to Cart">
				</form>
				<p id = "item_added"><?php echo $this->session->flashdata("success_message") ?></p>
			</div> <!-- closes right third -->
		</div>
		<!-- SIMILAR ITEMS SECTION -->
		<h4>Similar Items</h4>
		<div class="row">
			<?php for ($i=0; $i<6; $i++) { ?>
			<div class="col-xs-2">
				<div class="thumbnail">
					<img src="/assets/img/used_horseshoe.png" alt="thumbnail">
					<div class="caption">
						<p>prod name</p>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>


   	</div>
</body>
</html>