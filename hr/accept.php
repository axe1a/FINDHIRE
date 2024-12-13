<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 

$form_id = $_GET['form_id'] ?? 0;

if ($form_id) {
    if (acceptApplication($pdo, $form_id)) {
        header("Location: applications.php?post_id=" . $_GET['post_id']);
        exit();
    } else {
        echo "Failed to accept the application.";
    }
}