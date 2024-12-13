<?php
// download.php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['file'])) {
    // The file name from the query string
    $fileName = $_GET['file'];
    $uploadDir = '../uploads/'; // Directory where resumes are stored
    $filePath = $uploadDir . basename($fileName);

    // Validate file existence
    if (file_exists($filePath)) {
        // Set headers for file download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Read the file and output its content
        readfile($filePath);
        exit;
    } else {
        echo "<p>Error: File not found.</p>";
        exit;
    }
} else {
    echo "<p>Error: Invalid request.</p>";
    exit;
}
