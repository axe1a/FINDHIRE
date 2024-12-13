<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php  

    include 'styles/header.php'; 

	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<br> <br> <br> <br>
	<div class="container-reg">
	<form action="core/handleForms.php" method="POST">
		<div class="inputAuth">
			<label for="email">Email</label><br>
			<input type="text" name="email" required>
		</div>
		<div class="inputAuth">
			<label for="username">First Name</label>
			<input type="text" name="first_name" required>
		</div>
		<div class="inputAuth">
			<label for="username">Last Name</label>
			<input type="text" name="last_name" required>
		</div>
		<div class="inputAuth">
			<label for="username">Password</label>
			<input type="password" name="password" required>
		</div>
		<div class="inputAuth">
			<label for="username">Confirm Password</label>
			<input type="password" name="confirm_password" required>
		</div>
		<div class="button-container">
			<input type="submit" name="insertNewUserBtn" style="margin-top: 25px;">
			<a href="login.php" class="link">Back</a>
		</div>
	</form>
</body>
</html>