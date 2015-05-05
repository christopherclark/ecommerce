<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - Edit Product</title>
</head>
<body>
	<div id='container-fluid'>
		<h2>Edit Product - ID <?= $product['id']?></h2>
		<div class='col-md-6'>
			<form class='form-horizontal' method='post' action='/admins/edit_product' enctype='multipart/form-data'>
				<div class='form-group'>
					<label for='name' class='col-md-2 control-label'>Name</label>
					<div class='col-md-10'>
						<input type='text' name='name' id = 'name' value = '<?= $product["name"]?>' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label for='description' class='col-md-2 control-label'>Description</label>
					<div class='col-md-10'>
						<textarea name='description' class='form-control' rows=5><?= $product["description"]?></textarea>
					</div>
				</div>
				<div class='form-group'>
					<label for='categories' class='col-md-2 control-label'>Categories</label>
					<div class='col-md-10'>
						<select name='categories' class='form-control'>
							<?php foreach ($categories as $category) { ?>
							<option value='<?=$category["name"]?>'><?=$category["name"]?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label for='category' class='col-md-2 control-label'>Or add a new category: </label>
					<div class='col-md-10'>
						<input type='text' name='category' id = 'category' class='form-control'>
					</div>
				</div>
				<input type='hidden' name='MAX_FILE_SIZE' value='2000000'>
				<input name='userfile' type='file' id='userfile'>
				<input class='btn btn-primary' type='submit' value='Update'>
			</form>
		</div>
	</div>
</body>
</html>
<?php  var_dump($product); var_dump($categories);?>