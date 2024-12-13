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

function getFirstNameByID($pdo, $first_name) {
	$sql = "SELECT * FROM user_accounts WHERE first_name = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function editUser($pdo, $email, $first_name, $last_name, $gender, $company, $user_id) {

	$sql = "UPDATE user_accounts
				SET email = ?,
					first_name = ?,
					last_name = ?, 
					gender = ?,
					company = ?
				WHERE user_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$email, $first_name, $last_name, $gender, $company, $user_id]);
	
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
					job_posts.company AS company,
					job_posts.date_added AS date_added
				FROM job_posts
				JOIN user_accounts 
				ON job_posts.created_by = user_accounts.user_id
				WHERE job_posts.post_id = ?
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
					job_posts.company AS company,
					job_posts.date_added AS date_added
				FROM job_posts
				JOIN user_accounts 
				ON job_posts.created_by = user_accounts.user_id
				";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute();

		if ($executeQuery) {
			return $stmt->fetchAll();
		}

	}
}


function getJobPostByUser($pdo, $user_id) {
    $sql = "SELECT 
                CONCAT(user_accounts.first_name, ' ', user_accounts.last_name) AS user,
                user_accounts.company AS company,
                job_posts.post_id AS post_id,
                job_posts.post AS post,
                job_posts.date_added AS date_added
            FROM job_posts
            JOIN user_accounts 
            ON job_posts.created_by = user_accounts.user_id
            WHERE job_posts.created_by = ?
			ORDER BY 
                job_posts.date_added DESC
			";

        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$user_id]);

        if ($executeQuery) {
            return $stmt->fetchAll();
        } else {
			echo "No posts yet.";
		}
}

// ---------------------------------------------------------------------------------------------------------------------------------

function getApplicationFormByJobPostID($pdo, $post_id) {
    $query = "SELECT 
                application_form.form_id,
                application_form.first_name,
                application_form.last_name,
                application_form.resume_path,
                application_form.status,
                application_form.date_added,
                job_posts.company,
                application_form.position,
				application_form.additionaltext
            FROM 
                application_form
            JOIN 
                job_posts ON application_form.post_id = job_posts.post_id
            WHERE 
                application_form.post_id = ?
				AND application_form.status IN ('Pending', 'Accepted')
            ORDER BY 
                application_form.date_added DESC
        ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$post_id]);

    return $stmt->fetchAll();
}

function acceptApplication($pdo, $form_id) {
    $query = "UPDATE application_form SET status = 'Accepted' WHERE form_id = ?";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$form_id]);
}

function rejectApplication($pdo, $form_id) {
    $query = "UPDATE application_form SET status = 'Rejected' WHERE form_id = ?";
    $stmt = $pdo->prepare($query);
    return $stmt->execute([$form_id]);
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

// ---------------------------------------------------------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------------------------


function insertJobPost($pdo, $post, $created_by) {
	$sql = "INSERT INTO job_posts (post, created_by) VALUES(?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$post, $created_by]);
	if ($executeQuery) {
		return true;
	}
}





// ---------------------------------------------------------------------------------------------------------------------------------
