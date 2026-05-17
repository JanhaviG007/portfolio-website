<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Janhavi Gavali</title>
    <meta name="description" content="Log in to manage your blog posts on Janhavi Gavali's portfolio website." />
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
                    <li><a href="index.php#blog-section">Blog</a></li>
                </ul>
            </nav>
        </div>
    </header>


    <!-- Login page content -->
    <main class="login-page">

        <section class="login-page-section">

            <!-- CSS Grid: login form on left, info panel on right -->
            <div class="login-grid">

                <!-- Left: login form card wrapped in article for semantic structure -->
                <article class="login-page-card">
                    <h1 class="login-page-title">Login</h1>

                        <!-- Error Message Display (Phase 2) -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="login-error-message" style="background-color: rgba(255, 107, 107, 0.1); border: 1px solid #ff6b6b; color: #ff6b6b; padding: 0.8rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.85rem; text-align: center;">
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
                        <?php endif; ?>

                    <!-- Login form - action points to loginProcess.php (Phase 2) -->
                    <!-- HTML5 validation: type="email" and required attributes used -->
                    <form class="login-form" action="loginProcess.php" method="POST">

                        <!-- Email field with HTML5 email validation -->
                        <div class="form-group">
                            <label for="email" class="sr-only">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                placeholder="Email"
                                required
                            />
                        </div>

                        <!-- Password field with required and minlength validation -->
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <div class="password-wrap">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Password"
                                    required
                                    minlength="6"
                                />
                                <span class="pw-icon">?</span>
                            </div>
                        </div>

                        <button type="submit" class="login-btn">Login</button>

                    </form>

                    <!-- Back link to homepage -->
                    <p class="login-back">
                        <a href="index.php" class="login-back-link">&larr; Back to portfolio</a>
                    </p>
                </article>

                <!-- Right: info panel (aside for supplementary content) -->
                <aside class="login-info-panel">
                    <p class="login-info-title">Welcome Back!</p>
                    <p class="login-info-text">
                        Log in to add new posts to your blog. Only the site owner
                        can post entries.
                    </p>
                    <ul class="login-info-list">
                        <li>Use your registered email address</li>
                        <li>Password must be at least 6 characters</li>
                        <li>Session is remembered until you log out</li>
                    </ul>
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

</body>
</html>
