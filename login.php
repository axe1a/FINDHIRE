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
			echo "<h3 style='color: white; background-color:#7093c2; align-items:center;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h3 style='color: white; background-color:#7093c2; align-items:center;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
<br> <br> <br> <br>
    <div class="container-reg">
           
            <form action="core/handleForms.php" method="POST">
            <input type="hidden" name="first_name" value="<?php echo isset($_GET['first_name']) ?>">
                <div class="form">
                    <div class="details">

                    <div class="inputAuth">
                    <p>
                       <input type="text" name="email" placeholder="Email" required>
                    </p></div>
                    <div class="inputAuth">
                    <p>
                        <input type="password" name="password" placeholder="Password" required>
                    </p></div>

                    <div class="button-container">
                    <input type="submit" name="loginUserBtn" value="Login" class="btn">
                    <a href="register.php" class="link">Register</a>
                    </div>
                </div>
            </form>
            
        
    </div>
</body>
</html>