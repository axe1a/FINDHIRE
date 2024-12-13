<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 
session_start();

if (!isset($_SESSION['email'])) {
	header("Location: login.php");
}

$getUserByID = getUserByID($pdo, $_SESSION['user_id']);

if ($getUserByID['is_hr'] == 1) {
	header("Location: hr/index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FindHire</title>
	<link rel="stylesheet" href="/styles/styles.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="/styles/navbar.php?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="styles/styles.css">
	
</head>
<body>
	<?php include 'styles/navbar.php'; ?><br><br><br><br><br><br>
<h2 class="job-posts-title">Application Form</h2><br><br>
	<div class="container">
  	
			<?php 
            $getUserByID = getUserByID($pdo, $_SESSION['user_id']); 
            $post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;
            
            if ($post_id === null) {
                echo "<p>Error: No job post selected.</p>";
                exit;
            }
            
            $getAllJobPost = getAllJobPost($pdo, $post_id);?>
			
				<form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
				<h3 style="text-align:center;">Applying at: <h3 style="text-align:center; color:#074991"><?php echo $getAllJobPost['company']?></h3></h3>
				<div class="form"><br>
				<div class="details">
				
				<div class="fields">
                
                <input type="hidden" name="form_id">
                

                <?php foreach ($getAllJobPost as $row) { ?>
                <input type="hidden" name="company" value="<?php echo $getAllJobPost['company'] ?>">
                <input type="hidden" name="post_id" value="<?php echo $getAllJobPost['post_id'] ?>"> <?php } ?>

                <input type="hidden" name="user_id" value="<?php echo $getUserByID['user_id']; ?>">
					<div class="inputUser"><p>
						<label for="email">Email</label><br>
                       <input type="text" name="email" value="<?php echo $getUserByID['email'] ?>" readonly>
                    </p></div>
					<div class="inputUser"><p>
						<label for="first_name">First Name</label><br>
                       <input type="text" name="first_name" value="<?php echo $getUserByID['first_name'] ?>">
                    </p></div>
					<div class="inputUser"><p>
						<label for="last_name">Last Name</label><br>
                       <input type="text" name="last_name" value="<?php echo $getUserByID['last_name'] ?>">
                    </p></div>
					<div class="inputUser"><p>
						<label for="gender">Gender</label><br>
                       <input type="text" name="gender" value="<?php echo $getUserByID['gender'] ?>">
                    </p></div>
					<div class="inputUser"><p>
						<label for="contact_number">Contact Number</label><br>
                       <input type="text" name="contact_number" value="<?php echo $getUserByID['contact_number'] ?>">
                    </p></div>
					<div class="inputUser"><p>
						<label for="position">Applying for</label><br>
                       <input type="text" name="position" placeholder="Position">
                    </p></div>
					<div class="inputUser"><p>
						<label for="email">Attach File</label><br>
						<input type="file" name="resume">
						
                    </p></div>
					<div class="inputUser"><p>
						<label for="email">Tell us why you think you deserve the position.</label><br>
                       <input type="text" name="additionaltext" placeholder="Type here">
                    </p></div>
					<input type="submit" name="applyBtn">
					<a href="index.php" class="link">Back</a>

				</form>

				
			</div>
			</div>
			</div>
			</div>
	</div>

</body>
</html>