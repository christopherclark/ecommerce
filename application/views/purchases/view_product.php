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
		<a href="/">Go Back</a>
		<!-- PRODUCT INF0 SECTION -->
		<h1><?=$product['name']?></h1>
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
				<div class="row">
					<p> <?=$product['description'];?> 
					</p>
				</div>
				<div class="row">
					<form class="form-inline col-md-offset-6 col-md-4 col-sm-offset-6 col-sm-4 col-xs-offset-6 col-xs-4" 
							action="/purchases/add_to_cart" method="post">
						<div class="form-group">
							<select name="quantity">
								<?php for ($q=1; $q<=10; $q++) { ?>
								<option value="<?=$q?>"><?=$q?> ($<?=($product['price']*$q)?>)</option>
								<?php } ?>
							</select>
						</div>
						<input type = "hidden" name = "id" value = "<?= $id?>">
						<input type="submit" value="Add to Cart">
					</form>
				</div>
				<div class="row">
					<p class="success col-md-offset-6 col-md-4 col-sm-offset-6 col-sm-4 col-xs-offset-6 col-xs-4" id = "item_added"><?php echo $this->session->flashdata("success_message") ?></p>
				</div>
			</div> <!-- closes right third -->
		</div>
		<!-- SIMILAR ITEMS SECTION -->
		<h4>Similar Items</h4>
		<div class="row">
			<?php for ($p=1; $p<7; $p++) { ?>
			<div class="col-xs-2">
				<a href="/products/show/<?=$p?>">
				<div class="thumbnail">
					<img src="/assets/img/used_horseshoe.png" alt="thumbnail">
					<div class="caption">
						<p>product #<?=$p?></p>
					</div>
				</div>
				</a>
			</div>
			<?php } ?>
		</div>


   	</div>
</body>
</html>