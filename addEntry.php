<?php
/**
 * Add Blog Entry Page
 * 
 * This page allows logged-in users to add new blog entries.
 * It includes form validation, clear button functionality, and preview feature.
 * 
 * Assessment Criteria 4, 5, 8: Clear button, form validation, and extra features
 */

session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Blog Entry - Janhavi Gavali</title>
    <meta name="description" content="Add a new blog post to Janhavi Gavali's portfolio website." />
    <link rel="stylesheet" href="css/reset.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/summer-theme.css" />
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
                    <li><a href="index.php#home">Home</a></li>
                    <li><a href="index.php#about">About</a></li>
                    <li><a href="index.php#experience">Experience</a></li>
                    <li><a href="index.php#leadership">Leadership</a></li>
                    <li><a href="html/skills.html">Skills</a></li>
                    <li><a href="html/education.html">Education</a></li>
                    <li><a href="index.php#awards">Awards</a></li>
                    <li><a href="html/portfolio.html">Projects</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    <li><a href="index.php#blog-section" class="nav-active">Blog</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>


    <!-- Main content -->
    <main class="add-entry-page">

        <section class="add-entry-page-section">

            <!-- article wraps the main blog entry content area -->
            <article>

                <!-- Page heading and description -->
                <div class="add-entry-page-header">
                    <h1 class="section-title">ADD BLOG ENTRY</h1>
                    <div class="section-rule"></div>
                    <p class="add-entry-intro">
                        Write your new blog post below. Click <strong>Post</strong> to publish it,
                        <strong>Preview</strong> to see how it will look, or <strong>Clear</strong> to reset the form.
                    </p>
                </div>

                <!-- CSS Grid: form on left, tips panel on right -->
                <div class="add-entry-grid">

                    <!-- Left: blog entry form -->
                    <aside>
                        <div class="add-entry-card-full">
                            <h2 class="section-title" style="color: #0e0a17; font-size: 1.2rem; margin-bottom: 1.5rem;">Add Blog</h2>

                            <!-- Form for adding blog entries -->
                            <form class="add-entry-form-full" id="addEntryForm" action="addPost.php" method="POST" onsubmit="validateForm(event)">

                                <!-- Title field -->
                                <div class="form-group">
                                    <label for="post-title" class="entry-label">Title</label>
                                    <input
                                        type="text"
                                        id="post-title"
                                        name="title"
                                        class="entry-input"
                                        placeholder="Enter your blog title"
                                        required
                                    />
                                    <span class="field-error" id="title-error" style="display: none; color: #ff6b6b; font-size: 0.8rem; margin-top: 0.3rem;">Title is required</span>
                                </div>

                                <!-- Post body field -->
                                <div class="form-group">
                                    <label for="post-body" class="entry-label">Post</label>
                                    <textarea
                                        id="post-body"
                                        name="post"
                                        class="entry-textarea"
                                        placeholder="Enter your text here"
                                        rows="10"
                                        required
                                    ></textarea>
                                    <span class="field-error" id="post-error" style="display: none; color: #ff6b6b; font-size: 0.8rem; margin-top: 0.3rem;">Post content is required</span>
                                </div>

                                <!-- Post, Preview, and Clear buttons -->
                                <div class="add-entry-btns">
                                    <button type="submit" class="btn-post">Post</button>
                                    <button type="button" class="btn-preview" onclick="previewPost()">Preview</button>
                                    <button type="button" class="btn-clear" onclick="clearForm()">Clear</button>
                                </div>

                            </form>
                        </div>
                    </aside>

                    <!-- Right: writing tips panel -->
                    <div class="add-entry-tips">
                        <p class="add-entry-tips-title">Writing Tips</p>
                        <ul>
                            <li>Keep your title short and clear</li>
                            <li>Write about topics related to your field</li>
                            <li>Share what you have learned or experienced</li>
                            <li>Posts appear most recent first on the blog page</li>
                            <li>Use Clear only if you want to discard your work</li>
                            <li>Use Preview to see how your post will look</li>
                        </ul>
                    </div>

                </div>

                <!-- Back link -->
                <p class="entry-back">
                    <a href="index.php#blog-section" class="login-back-link">&larr; Back to Blog</a>
                </p>

            </article>

        </section>

    </main>


    <!-- Preview Modal -->
    <div id="previewModal" class="preview-modal" style="display: none;">
        <div class="preview-modal-content">
            <div class="preview-modal-header">
                <h2 class="preview-modal-title">Preview Your Post</h2>
                <button class="preview-close" onclick="closePreview()">&times;</button>
            </div>
            <div class="preview-modal-body">
                <div class="preview-post-card">
                    <h3 id="previewTitle" class="preview-post-title"></h3>
                    <p id="previewBody" class="preview-post-body"></p>
                    <p class="preview-post-date" id="previewDate"></p>
                </div>
            </div>
            <div class="preview-modal-footer">
                <button class="btn-post" onclick="submitForm()">Publish Post</button>
                <button class="btn-clear" onclick="closePreview()">Back to Edit</button>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            <a href="index.php" class="footer-logo">
                <span class="logo-script small">JG</span>
                <span class="footer-name">Janhavi Gavali</span>
            </a>
            <p class="footer-copy">&copy; 2026 Janhavi Gavali. All rights reserved.</p>
            <nav class="footer-nav">
                <a href="index.php#about">About</a>
                <a href="index.php#experience">Experience</a>
                <a href="index.php#leadership">Leadership</a>
                <a href="html/skills.html">Skills</a>
                <a href="html/education.html">Education</a>
                <a href="index.php#awards">Awards</a>
                <a href="html/portfolio.html">Projects</a>
                <a href="index.php#contact">Contact</a>
                <a href="index.php#blog-section">Blog</a>
            </nav>
        </div>
    </footer>

    <!-- External JavaScript file for form validation, clear button, and preview feature -->
    <script src="js/addEntry.js"></script>

</body>
</html>
