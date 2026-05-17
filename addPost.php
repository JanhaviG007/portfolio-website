<?php
/**
 * Add Post Processing Script
 * 
 * This script handles the insertion of new blog posts into the MySQL database.
 * It receives data from addEntry.php, validates it, and inserts it with date/time information.
 * After successful insertion, it redirects to viewBlog.php.
 * 
 * Assessment Criteria 6: Blog entry insertion into database
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connect.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get form data
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $body = isset($_POST['post']) ? trim($_POST['post']) : '';
    
    // Validate input
    if (empty($title) || empty($body)) {
        header("Location: addEntry.php?error=Please fill in all fields");
        exit();
    }
    
    // Get current date and time
    $post_date = date('Y-m-d');
    $post_time = date('H:i:s');
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, body, post_date, post_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $body, $post_date, $post_time);
    
    if ($stmt->execute()) {
        // Success - redirect to viewBlog.php
        header("Location: viewBlog.php?success=Post published successfully");
        exit();
    } else {
        // Error - redirect back to addEntry with error message
        header("Location: addEntry.php?error=Error publishing post: " . $conn->error);
        exit();
    }
    
    $stmt->close();
} else {
    // If not POST request, redirect to addEntry
    header("Location: addEntry.php");
    exit();
}

$conn->close();
?>
