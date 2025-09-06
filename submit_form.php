<?php
// Set headers to allow Cross-Origin Resource Sharing (CORS) if needed.
// This is important if your HTML and PHP files are on different servers.
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "contact_form_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get form data from the POST request
$name = $_POST['name'] ?? '';
$phone = $_POST['number'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Basic server-side validation to ensure required fields aren't empty
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit();
}

// Use prepared statements to prevent SQL injection attacks
$stmt = $conn->prepare("INSERT INTO messages (name, phone_number, email, message) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'SQL prepare failed: ' . $conn->error]);
    exit();
}

// Bind the parameters to the statement
$stmt->bind_param("ssss", $name, $phone, $email, $message);

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>