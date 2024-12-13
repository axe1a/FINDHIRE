<?php  

require_once 'dbConfig.php';

function checkIfUserExists($pdo, $email) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE email = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$email])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $email, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $email); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (email, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$email, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_accounts WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function insertJobPost($pdo, $post, $created_by) {
	$sql = "INSERT INTO job_posts (post, created_by) VALUES (?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$post, $created_by]);
	if ($executeQuery) {
		return true;
	}
}

function getAllJobPost($pdo, $post_id=NULL) {
	if (!empty($post_id)) {
		$sql = "SELECT 
					CONCAT(user_accounts.first_name, ' ', user_accounts.last_name) AS user,
					user_accounts.company AS company,
					job_posts.post_id AS post_id,
					job_posts.post AS post,
					job_posts.date_added AS date_added
				FROM job_posts
				JOIN user_accounts 
				ON job_posts.created_by = user_accounts.user_id
				WHERE job_posts.post_id = ?
				ORDER BY post_id DESC; 
				";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$post_id]);

		if ($executeQuery) {
			return $stmt->fetch();
		}

	}
	else {
		$sql = "SELECT 
					CONCAT(user_accounts.first_name, ' ', user_accounts.last_name) AS user,
					user_accounts.company AS company,
					job_posts.post_id AS post_id,
					job_posts.post AS post,
					job_posts.date_added AS date_added
				FROM job_posts
				JOIN user_accounts 
				ON job_posts.created_by = user_accounts.user_id
				ORDER BY post_id DESC;
				";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute();

		if ($executeQuery) {
			return $stmt->fetchAll();
		}

	}
}

function editUser($pdo, $email, $first_name, $last_name, $gender, $contact_number, $user_id) {

	$sql = "UPDATE user_accounts
				SET email = ?,
					first_name = ?,
					last_name = ?, 
					gender = ?,
					contact_number = ?
				WHERE user_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$email, $first_name, $last_name, $gender, $contact_number, $user_id]);
	
	if ($executeQuery) {
		return true;
}

}


function insertApplication($pdo, $post_id, $user_id, $email, $first_name, $last_name, $gender, $contact_number, $position, $resume_path, $additionaltext, $status = 'Pending', $company) {
    $query = "INSERT INTO application_form (form_id, post_id, user_id, email, first_name, last_name, gender, contact_number, position, resume_path, additionaltext, status, company)
              VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([
        $post_id,
        $user_id,
        $email,
        $first_name,
        $last_name,
        $gender,
		$contact_number,
		$position,
        $resume_path,
		$additionaltext,
        $status,
		$company,
    ]);
}


function getApplicationFormByID($pdo, $user_id) {

    $query = "SELECT 
                application_form.form_id,
				application_form.post_id,
                application_form.first_name,
                application_form.last_name,
                application_form.resume_path,
                application_form.status,
                application_form.date_added,
				application_form.date_added,
                application_form.company,
                application_form.position,
				application_form.additionaltext
            FROM 
                application_form
            JOIN 
                job_posts ON application_form.post_id = job_posts.post_id
            WHERE 
                application_form.user_id = ?
            ORDER BY 
                application_form.date_added DESC
        ";

        $stmt = $pdo->prepare($query);
        $executeQuery = $stmt->execute([$user_id]);

		if ($executeQuery) {
			return $stmt->fetchAll();
		}

}
// ---------------------------------------------------------------------------------------------------------------------------------

function insertIntoMessages($pdo, $form_id, $sender_id, $message_content) {
    $sql = "INSERT INTO messages (form_id, sender_id, message_content) 
            VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);

    $executeQuery = $stmt->execute([$form_id, $sender_id, $message_content]);

        if ($executeQuery) {
            return true;
        } 
 
}




function getMessageByApplicationID($pdo, $form_id){
    $sql = "SELECT
                messages.message_id,
                messages.form_id,
                messages.sender_id,
                messages.message_content,
                messages.date_sent,
                CONCAT(user_accounts.first_name, ' ', user_accounts.last_name) AS sender_name
            FROM 
                messages
            JOIN
                user_accounts ON messages.sender_id = user_accounts.user_id
            WHERE 
                messages.form_id = ?"; 
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$form_id]); 

    if ($executeQuery) {
        return $stmt->fetchAll(); 
    }

    return [];
}
