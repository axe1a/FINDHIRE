<?php  
session_start();
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertNewUserBtn'])) {
	$email = trim($_POST['email']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($email) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $email, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$email = trim($_POST['email']);
	$first_name = trim($_POST['first_name']);
	$password = trim($_POST['password']);

	if (!empty($email) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $email);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$emailFromDB = $loginQuery['userInfoArray']['email'];
		$firstNameFromDB = $loginQuery['userInfoArray']['first_name'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['email'] = $emailFromDB;
			$_SESSION['first_name'] = $firstNameFromDB;
			$_SESSION['status'] = "200";
			header("Location: ../index.php");
			exit;
		}

		else {
			$_SESSION['message'] = "Email/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../login.php");
	}

}

if (isset($_POST['editUserBtn'])) {
	$email = trim($_POST['email']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$gender = trim($_POST['gender']);
	$company = trim($_POST['company']);
	
	$query = editUser($pdo, $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['gender'],$_POST['company'],$_GET['user_id'], );
	
	if ($query) {
		$_SESSION['status'] = "200";
		header("Location: ../profile.php");
	}

	else {
		echo "Edit failed";;
	}
}











if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['email']);
	header("Location: ../login.php");
}


// ---------------------------------------------------------------------------------------------------------------------------------

if (isset($_POST['sendMessage'])) {

    
    $form_id = $_POST['form_id'];
    $sender_id = $_SESSION['user_id'] ?? null; // Validate session
    $message_content = $_POST['message_content'] ?? null;

    // Validate sender_id and message_content
    if (!$sender_id) {
        die("Error: User is not logged in.");
    }
    if (!$message_content) {
        die("Error: Message content cannot be empty.");
    }

    // Check if form_id exists in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM application_form WHERE form_id = ?");
    $stmt->execute([$form_id]);
    if ($stmt->fetchColumn() == 0) {
        die("Error: Invalid form_id. No such form_id exists in application_form.");
    }

    // Insert the message
    $response = insertIntoMessages($pdo, $form_id, $sender_id, $message_content);

    // Handle response
    $_SESSION['message'] = $response['message'] ?? "Message sent!";
    $_SESSION['statusCode'] = $response['statusCode'] ?? 200;

    header("Location: ../message_user.php?post_id=" . $_GET['post_id'] . "&form_id=" . $_POST['form_id']);
    exit();
}


// ---------------------------------------------------------------------------------------------------------------------------------










// ---------------------------------------------------------------------------------------------------------------------------------


if (isset($_POST['insertJobPostBtn'])) {
	$post = $_POST['post'];
	$insertQuery = insertJobPost($pdo, $post, $_SESSION['user_id']);
	if ($insertQuery) {
		header("Location: ../index.php");
	}
}


// ---------------------------------------------------------------------------------------------------------------------------------
