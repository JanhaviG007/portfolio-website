<?php
/**
 * Database Connection File
 * 
 * This file establishes a connection to the MySQL database used for
 * the blog and user authentication system.
 * 
 * @package Portfolio Blog
 * @author Janhavi Gavali
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'portfolio_blog';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Return connection object for use in other files
?>
