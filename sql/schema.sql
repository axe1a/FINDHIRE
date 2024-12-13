CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    form_id INT,
    sender_id INT,
    message_content TEXT,
    date_sent TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (form_id) REFERENCES application_form(form_id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES user_accounts(user_id) ON DELETE CASCADE
);


CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	password TEXT,
	gender VARCHAR(255),
	company VARCHAR(255),
	is_hr TINYINT(1) NOT NULL DEFAULT 0,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE application_form (
	form_id INT AUTO_INCREMENT PRIMARY KEY,
	user_id INT,
	email VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	gender VARCHAR(255),
	post_id INT,
	contact_number VARCHAR(255),
	company VARCHAR(255),
	resume_path VARCHAR(255),
	status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE job_posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    post TEXT NOT NULL,
    created_by INT,
	company VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE application_form 
ADD FOREIGN KEY (post_id) REFERENCES job_posts(post_id) ON DELETE CASCADE;
