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

include 'styles/navbar.php'; 

?><br><br><br><br><br><br><br>
<h2 class="job-posts-title">Profile</h2><br><br>
	<div class="container-reg">


<?php $getUserByID = getUserByID($pdo, $_SESSION['user_id']); ?>
<form action="core/handleForms.php?user_id=<?php echo $_SESSION['user_id']; ?>" method="POST">
			<div class="form"><br>
			<div class="details">
			
			<div class="fields">
	<div class="inputUser"><p>
		<label for="email">Email</label><br>
		<input type="text" name="email" value="<?php echo $getUserByID['email'];?>" readonly>
	</p></div>
	<div class="inputUser"><p>
		<label for="first_name">First Name</label><br>
		<input type="text" name="first_name" value="<?php echo $getUserByID['first_name'];?>">
	</p></div>
	<div class="inputUser"><p>
		<label for="last_name">Last Name</label><br>
		<input type="text" name="last_name" value="<?php echo $getUserByID['last_name'];?>">
	</p></div>
	<div class="inputUser"><p>
		<label for="gender">Gender</label><br>
		<input type="text" name="gender" value="<?php echo $getUserByID['gender'];?>"required>
	</p></div>
	<div class="inputUser"><p>
		<label for="company">Company</label><br>
		<input type="text" name="company" value="<?php echo $getUserByID['company'];?>" required>
		
	</p></div>
	<input type="submit" name="editUserBtn">

</form>
</div>
</div>
</div>
</div>
</body>
</html>