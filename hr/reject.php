<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 

$form_id = $_GET['form_id'] ?? 0;

if ($form_id) {
    if (rejectApplication($pdo, $form_id)) {
        header("Location: applications.php?job_post_id=" . $_GET['job_post_id']);
        exit();
    } else {
        echo "Failed to reject the application.";
    }
}