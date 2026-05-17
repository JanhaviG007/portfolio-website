<?php
/**
 * Delete Blog Post Script
 * 
 * This script allows logged-in users to delete their blog posts.
 * It checks if the user is logged in and if the post ID is valid.
 * 
 * Extra Feature: Delete functionality
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'db_connect.php';

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = intval($_GET['id']);

// Delete the post from database
$delete_query = "DELETE FROM blog_posts WHERE id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $post_id);

if ($stmt->execute()) {
    // Redirect back to homepage with success message
    header("Location: index.php?deleted=1");
    exit();
} else {
    // Redirect back with error message
    header("Location: index.php?error=Could not delete post");
    exit();
}

$stmt->close();
$conn->close();
?>
