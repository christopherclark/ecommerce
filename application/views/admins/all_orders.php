<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - Orders</title>
	<script type="text/javascript">
		$(document).ready(function(){

			$.get('/admins/get_order_status',function(response){
				$('#status_form').html(response);
			});

			$(document).on('submit', 'form', function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(response){
						$('#status_form').html(response);
					})
				return false;
			});

			$(document).on('change', '.update_form', function(){
				$(this).submit();
			});
		})
	</script>
	<style type="text/css">
		.pages {
			display: inline-block;
			margin: 0em;
			color: blue;
		}
		.pages input[type='submit'] {
			background-color: white;
			border: none;
		}
		#pagination {
			text-align: center;
		}
	</style>
</head>
<body>
	<?php include('partials/admins_nav.php'); ?>
	<div class='container' id='status_form'>
	</div>
</body>
</html>