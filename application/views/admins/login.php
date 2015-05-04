<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/admins.css">
	<title>H&H Supplies - Admin Login</title>
	<style type="text/css">
		h2 {
			text-align: center;
			margin-top: 2em;
		}
		form {
			width: 20em;
			margin: 3em auto;
		}
		input[type=submit] {
			margin-left: 15em;
		}
	</style>
</head>
<body>
	<h2>Admin Login Page</h2>
	<form>
		<div class='form-group'>
			<label for='email'>Email: </label>
			<input type='text' class='form-control' name='email' id='email'>
		</div>
		<div class='form-group'>
			<label for='password'>Password: </label>
			<input type='password' class='form-control' name='password' id='password'>
		</div>
		<input type='submit' class='btn btn-primary' value='Login'> 
	</form>
</body>
</html>