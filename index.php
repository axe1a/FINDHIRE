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
	
	<?php include 'styles/navbar.php'; ?>
<br><br><br>
<div class="job-posts-container">
  <h2 class="job-posts-title">Job Posts</h2><br><br>
  <div class="job-posts-list">
    <?php $getAllJobPost = getAllJobPost($pdo); ?>
    <?php foreach ($getAllJobPost as $row) { ?>
    <div class="job-post-item">
      <h3 class="job-post-user"><?php echo $row['user']; ?></h3>
        <p class="job-post-company"><?php echo $row['company']; ?></p>
		<div class="job-post-details">
        <p class="job-post-date">Posted on <?php echo $row['date_added']; ?></p>
      </div>
      <p class="job-post-description"><?php echo $row['post']; ?></p><br>
	  <hr style="color:#333">
      <a href="application_form.php?post_id=<?php echo $row['post_id']; ?>" class="job-post-apply-link">Apply</a>
    </div>
    <?php } ?>
  </div>
</div>
	
	


</body>
</html>