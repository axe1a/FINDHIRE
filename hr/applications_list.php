<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 
session_start();

if (!isset($_SESSION['email'])) {
	header("Location: login.php");
}

$getUserByID = getUserByID($pdo, $_SESSION['user_id']);
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : null;

if ($getUserByID['is_hr'] == 0) {
	header("Location: .../index.php");
}

            
if ($post_id === null) {
    echo "<p>Error: No job post selected.</p>";
    exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>FindHire</title>
	<link rel="stylesheet" href="styles/styles.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="styles/navbar.php?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<?php include 'styles/navbar.php'; ?>
	<br><br><br>
	<div class="job-posts-container">
	<h2 class="job-posts-title">Submitted Applications</h2><br><br>
	<?php $getApplicationFormByJobPostID = getApplicationFormByJobPostID($pdo, $post_id); ?>
	<?php foreach ($getApplicationFormByJobPostID as $row) { ?>
		<div class="application-card">
			<h3 class="company-name"><?php echo $row['first_name']," " ,$row['last_name']; ?></h3>
			

			<div class="status <?php echo $statusClass; ?>">Status: <?php echo $row['status']; ?>
			
			

			
			</div>

			<p class="job"><?php echo "Position: ".$row['position']; ?></p>
			<p class="file">File: <a href="download.php?file=<?= urlencode($row['resume_path']) ?>" target="_blank">
                Download Resume
            </a></p>
            <p class="job-post-company"><?php echo "Why to hire them: ". $row['additionaltext']; ?></p>
			<p class="submitted"><?php echo "Submitted on: ". $row['date_added']; ?></p><br>
<?php
			if ($row['status'] === 'Pending') {
                echo "<div class='button-container'><a href='accept.php?form_id=" . $row['form_id'] . "' class='status-accept' '>Accept</a> <br>";
                echo "<a href='reject.php?form_id=" . $row['form_id'] . "' class='status-reject''>Reject</a> </div>";
				if ($row['status'] === "Pending") {
					$statusClass = "pending";
				} elseif ($row['status'] === "Accepted") {
					$statusClass = "accepted";

				}
			}?> 

<?php if ($row['status'] === 'Pending') {?>
			<br><hr>
				<a href="message_user.php?post_id=<?php echo $_GET['post_id']."&form_id=".$row['form_id']?>" class="job-post-apply-link">Message</a>
			<?php
			}
			?>

			</div>
	<?php } ?>
	</div>
</body>
</html>