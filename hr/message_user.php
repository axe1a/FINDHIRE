<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 
session_start();

if (!isset($_SESSION['email'])) {
	header("Location: login.php");
}

$getUserByID = getUserByID($pdo, $_SESSION['user_id']);

if ($getUserByID['is_hr'] == 0) {
	header("Location: ../index.php");
}

$user_id = $_SESSION['user_id'];
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
    <h2 class="job-posts-title">Message an Applicant</h2>
    <br>
    <div class="job-posts-list">
        <?php 
        $getMessageByApplicationID = getMessageByApplicationID($pdo, $_GET['form_id']);
        ?>
        <div class="message-card">
            <?php foreach ($getMessageByApplicationID as $row) { ?>
                <div class="<?php echo ($_SESSION['user_id'] == $row['sender_id']) ? 'sender' : 'receiver'; ?>">
                    <h3 class="company-name"> <?php echo htmlspecialchars($row['sender_name']); ?></h3>
                    <div class="job-post-details">
                        <p class="submitted"> <?php echo htmlspecialchars($row['date_sent']); ?></p>
                    </div>
                    <p class="job-post-company"> <?php echo htmlspecialchars($row['message_content']); ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

                
    <section>

    <form class="chatbox" action="core/handleForms.php" method="POST">

            <input type="hidden" name="form_id" value="<?php echo isset($_GET['form_id']) ? htmlspecialchars($_GET['form_id']) : ''; ?>">
            <input type="text" class="message-area" name="message_content" placeholder="Aa" required>
            <input class="chat-btn" type="submit" name="sendMessage" value="Send">

    </form>
   
</section>

<script>
    const messagesContainer = document.querySelector('.message-card');

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    // Automatically scroll to the bottom when the page loads
    scrollToBottom();
</script>

</body>
</html>