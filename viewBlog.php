<?php
/**
 * View Blog Page
 * 
 * This page displays all blog posts with the most recent first.
 * Uses a PHP-driven sorting algorithm (not SQL ORDER BY) to sort entries.
 * Includes archive/filter functionality by month.
 * 
 * Assessment Criteria 7, 8, 11, 12: Blog sorting, extra features, design consistency, responsiveness
 */

session_start();

// Include database connection
require_once 'db_connect.php';

// Get all blog posts from database
$query = "SELECT id, title, body, post_date, post_time FROM blog_posts";
$result = $conn->query($query);

$blog_posts = array();

if ($result->num_rows > 0) {
    // Fetch all posts into an array
    while ($row = $result->fetch_assoc()) {
        $blog_posts[] = $row;
    }
} else {
    // Mandatory Requirement: Redirect to login.php if there is no entry
    header("Location: login.php");
    exit();
}

// PHP-driven sorting algorithm: Sort by date and time (most recent first)
// Using usort() to implement custom sorting logic
usort($blog_posts, function($a, $b) {
    // Combine date and time for comparison
    $dateTimeA = strtotime($a['post_date'] . ' ' . $a['post_time']);
    $dateTimeB = strtotime($b['post_date'] . ' ' . $b['post_time']);
    
    // Return negative if $a is more recent, positive if $b is more recent
    return $dateTimeB - $dateTimeA;
});

// Get selected month filter (if any)
$selected_month = isset($_GET['month']) ? $_GET['month'] : '';

// Filter posts by month if selected
$filtered_posts = $blog_posts;
if (!empty($selected_month)) {
    $filtered_posts = array_filter($blog_posts, function($post) use ($selected_month) {
        return substr($post['post_date'], 0, 7) === $selected_month;
    });
}

// Build array of available months from all posts
$available_months = array();
foreach ($blog_posts as $post) {
    $month = substr($post['post_date'], 0, 7); // Format: YYYY-MM
    if (!in_array($month, $available_months)) {
        $available_months[] = $month;
    }
}
sort($available_months, SORT_STRING);
$available_months = array_reverse($available_months); // Most recent first

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog - Janhavi Gavali</title>
    <meta name="description" content="Read the latest blog posts from Janhavi Gavali on web development, AI, and cybersecurity." />
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
</head>
<body>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner">
            <a href="index.php" class="logo-wrap">
                <span class="logo-icon">
                    <svg width="20" height="20" viewBox="0 0 22 22" fill="none">
                        <rect x="1" y="1" width="20" height="16" rx="2" stroke="#b47fe8" stroke-width="1.5"/>
                        <line x1="1" y1="20" x2="21" y2="20" stroke="#b47fe8" stroke-width="1.5"/>
                        <line x1="11" y1="17" x2="11" y2="20" stroke="#b47fe8" stroke-width="1.5"/>
                        <path d="M7 9L10 12L15 7" stroke="#b47fe8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="logo-script">JG</span>
            </a>
            <nav class="main-nav" aria-label="Primary navigation">
                <ul class="nav-list">
                    <li><a href="index.php">About me</a></li>
                    <li><a href="index.php#experience">Experience</a></li>
                    <li><a href="html/skills.html">Skills</a></li>
                    <li><a href="html/education.html">Education</a></li>
                    <li><a href="index.php#interests">Interests</a></li>
                    <li><a href="html/portfolio.html">Projects</a></li>
                    <li><a href="index.php#blog-section" class="nav-active">Blog</a></li>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li><a href="addEntry.php">Add Post</a></li>
                        <li><a href="logout.php" style="color: #b47fe8;">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>


    <!-- Main content -->
    <main class="blog-page">

        <section class="page-section blog-section">
            <h2 class="section-title">BLOG</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: blog posts on left, sidebar on right -->
            <div class="blog-grid">

                <!-- Left: blog posts list -->
                <article class="blog-main">
                    
                    <?php if (count($blog_posts) > 0): ?>
                        
                        <!-- Archive/Filter dropdown -->
                        <div class="blog-filter-container">
                            <label for="month-filter" class="blog-filter-label">Filter by Month:</label>
                            <select id="month-filter" class="blog-filter-select" onchange="filterByMonth()">
                                <option value="">All Posts</option>
                                <?php foreach ($available_months as $month): ?>
                                    <?php
                                        $date_obj = DateTime::createFromFormat('Y-m', $month);
                                        $month_display = $date_obj->format('F Y');
                                    ?>
                                    <option value="<?php echo $month; ?>" <?php echo ($selected_month === $month) ? 'selected' : ''; ?>>
                                        <?php echo $month_display; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <?php if (count($filtered_posts) > 0): ?>
                            <!-- Display filtered blog posts -->
                            <?php foreach ($filtered_posts as $post): ?>
                                <article class="blog-post-card">
                                    <div class="blog-post-header">
                                        <h3 class="blog-post-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                        <p class="blog-post-date">
                                            <?php 
                                                $date_obj = DateTime::createFromFormat('Y-m-d', $post['post_date']);
                                                echo $date_obj->format('F j, Y');
                                            ?>
                                            at <?php echo date('g:i A', strtotime($post['post_time'])); ?>
                                        </p>
                                    </div>
                                    <div class="blog-post-body">
                                        <?php echo nl2br(htmlspecialchars($post['body'])); ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="blog-empty">No posts found for the selected month.</p>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <p class="blog-empty">No blog posts yet. Be the first to add one!</p>
                    <?php endif; ?>

                </article>

                <!-- Right: add blog aside -->
                <aside class="blog-aside">
                    <div class="blog-aside-box">
                        <h3 class="blog-aside-title">Add a Post</h3>
                        <p class="blog-aside-text">Have something to share? Click below to write a new blog entry.</p>
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <a href="addEntry.php" class="add-post-link">+ Add New Blog Post</a>
                        <?php else: ?>
                            <a href="login.php" class="add-post-link">+ Login to Add Post</a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (count($blog_posts) > 0): ?>
                        <div class="blog-aside-box">
                            <h3 class="blog-aside-title">Total Posts</h3>
                            <p class="blog-aside-text"><?php echo count($blog_posts); ?> post<?php echo (count($blog_posts) !== 1) ? 's' : ''; ?> published</p>
                        </div>
                    <?php endif; ?>
                </aside>

            </div>

        </section>

    </main>


    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            <a href="index.php" class="footer-logo">
                <span class="logo-script small">JG</span>
                <span class="footer-name">Janhavi Gavali</span>
            </a>
            <p class="footer-copy">&copy; 2026 Janhavi Gavali. All rights reserved.</p>
            <nav class="footer-nav">
                <a href="index.php">About</a>
                <a href="html/skills.html">Skills</a>
                <a href="html/education.html">Education</a>
                <a href="html/portfolio.html">Projects</a>
                <a href="index.php#blog-section">Blog</a>
            </nav>
        </div>
    </footer>

    <!-- External JavaScript file for archive/filter by month functionality -->
    <script src="js/viewBlog.js"></script>

</body>
</html>
