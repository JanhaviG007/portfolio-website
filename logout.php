<?php
/**
 * Logout Script
 * 
 * This script ends the user session and redirects to the homepage.
 * 
 * Assessment Criteria 3: Logout functionality
 */

// Start session
session_start();

// Destroy all session data
session_destroy();

// Clear session variables
$_SESSION = array();

// Redirect to homepage
header("Location: index.php");
exit();
?>
