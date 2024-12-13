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
		<h2 class="job-posts-title">Submitted Applications</h2><br><br>
		<div class="job-posts-list">
		<?php $getApplicationByID = getApplicationFormByID($pdo, $_SESSION['user_id']); ?>
		<?php foreach ($getApplicationByID as $row) { ?>
			<div class="application-card">
			<h3 class="company-name"><?php echo $row['company']; ?></h3>
			<div class="status <?php echo $statusClass; ?>">Status: <?php echo $row['status']; 
				if ($row['status'] === "Pending") {
					$statusClass = "pending";
				} elseif ($row['status'] === "Accepted") {
					$statusClass = "accepted";
				} elseif ($row['status'] === "Rejected") {
					$statusClass = "rejected";
				}
			?> 
			
			<script>
				document.querySelectorAll(".status").forEach((statusElement) => {
				const statusText = statusElement.textContent.split(": ")[1]?.trim();

				console.log("Status Detected:", statusText); // Debugging

				if (statusText === "Pending") {
					statusElement.classList.add("pending");
				} else if (statusText === "Accepted") {
					statusElement.classList.add("accepted");
				} else if (statusText === "Rejected") {
					statusElement.classList.add("rejected");
				}
			});

			</script>	
		</div>
				<p class="job"><?php echo "Position: ".$row['position']; ?></p>
				<p class="file">File: <a href="download.php?file=<?= urlencode($row['resume_path']) ?>" target="_blank">
					Download Resume
				</a></p>
				<p class="job-post-company"><?php echo "Why to hire you: ". $row['additionaltext']; ?></p>
				<div class="job-post-details">
				<p class="submitted"><?php echo "Submitted on: ". $row['date_added']; ?></p></div>
				
		</p>

				<?php if ($row['status'] === 'Pending') {?>
					<br><hr>
					<a href="message_hr.php?post_id=<?php echo $row['post_id']."&form_id=".$row['form_id']?>" class="job-post-apply-link">Message</a>


				<br>
				<?php
				}
				?>

			</div>					
		<?php } ?>
		</div>
	</div>
</body>
</html>
