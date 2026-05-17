<?php
/**
 * Login Processing Script
 * 
 * This script handles user login by validating credentials against the database.
 * If credentials are correct, a session is started and the user is redirected to addEntry.php.
 * If credentials are incorrect, the user is redirected back to login.html with an error message.
 * 
 * Assessment Criteria 1 & 2: Login form validation and session management
 */

// Start session at the beginning
session_start();

// Include database connection
require_once 'db_connect.php';

// Initialize error message
$error_message = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Validate input
    if (empty($email) || empty($password)) {
        $error_message = 'Email and password are required.';
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct - start session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                // Redirect to addEntry.php
                header("Location: addEntry.php");
                exit();
            } else {
                // Password is incorrect
                $error_message = 'Invalid email or password.';
            }
        } else {
            // User not found
            $error_message = 'Invalid email or password.';
        }
        
        $stmt->close();
    }
}

$conn->close();

// If there's an error, redirect back to login with error message
if (!empty($error_message)) {
    header("Location: login.php?error=" . urlencode($error_message));
    exit();
}
?>
