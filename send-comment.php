<?php
// send-comment.php

// Allow requests from your domain
header("Access-Control-Allow-Origin: *"); // Replace * with your domain in production
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Get the submitted data
$inputData = json_decode(file_get_contents('php://input'), true);

// Check if data is valid
if (!isset($inputData['name']) || !isset($inputData['email']) || !isset($inputData['comment'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Validate email format
if (!filter_var($inputData['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Sanitize inputs to prevent injection attacks
$name = htmlspecialchars($inputData['name']);
$email = htmlspecialchars($inputData['email']);
$comment = htmlspecialchars($inputData['comment']);

// Your email address where you want to receive comments
$to = "atoxonovsobirbek6@gmail.com"; // Replace with your actual email

// Email subject
$subject = "New Comment from Website";

// Email body
$body = "Name: $name\n";
$body .= "Email: $email\n\n";
$body .= "Comment:\n$comment";

// Email headers
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($to, $subject, $body, $headers)) {
    // Email sent successfully
    echo json_encode(['success' => true, 'message' => 'Comment sent successfully']);
} else {
    // Failed to send email
    echo json_encode(['success' => false, 'message' => 'Failed to send comment']);
}
?>
