<?php
/**
 * Homepage with integrated blog posts
 * Shows blog posts if they exist, and allows logged-in users to add/delete posts
 */

session_start();
require_once 'db_connect.php';

// Fetch all blog posts
$query = "SELECT id, title, body, post_date, post_time FROM blog_posts";
$result = $conn->query($query);

$blog_posts = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $blog_posts[] = $row;
    }
}

// Sort blog posts by date and time (most recent first) using PHP algorithm
usort($blog_posts, function($a, $b) {
    $dateTimeA = strtotime($a['post_date'] . ' ' . $a['post_time']);
    $dateTimeB = strtotime($b['post_date'] . ' ' . $b['post_time']);
    return $dateTimeB - $dateTimeA;
});

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Janhavi Gavali - Portfolio</title>
    <meta name="description" content="Portfolio of Janhavi Gavali, BSc Computer Science student at Queen Mary University of London, specialising in AI, machine learning and cybersecurity." />
    <!-- Reset stylesheet -->
    <link rel="stylesheet" href="css/reset.css" />
    <!-- Main stylesheet -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
</head>
<body>

    <!-- Header -->
    <header class="site-header">
        <div class="header-inner">

            <!-- Logo - clicking it returns to the home page -->
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

            <!-- Navigation links -->
            <nav class="main-nav" aria-label="Primary navigation">
                <ul class="nav-list">
                    <li><a href="index.php">About me</a></li>
                    <li><a href="index.php#experience">Experience</a></li>
                    <li><a href="html/skills.html">Skills</a></li>
                    <li><a href="html/education.html">Education</a></li>
                    <li><a href="index.php#interests">Interests</a></li>
                    <li><a href="html/portfolio.html">Projects</a></li>
                    <li><a href="index.php#blog-section">Blog</a></li>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li style="color: #b47fe8; margin-left: auto;">Welcome, <?php echo htmlspecialchars(explode('@', $_SESSION['user_email'])[0]); ?></li>
                        <li><a href="addEntry.php">Add Post</a></li>
                        <li><a href="logout.php" style="color: #b47fe8;">Logout</a></li>
                    <?php else: ?>
                        <li style="margin-left: auto;"><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </header>


    <!-- Hero / welcome section -->
    <section class="hero" id="home">

        <!-- Decorative circuit pattern - right side -->
        <div class="circuit-right">
            <svg viewBox="0 0 280 600" xmlns="http://www.w3.org/2000/svg">
                <line x1="200" y1="0"   x2="200" y2="600" stroke="#b47fe8" stroke-width="1"/>
                <line x1="240" y1="0"   x2="240" y2="600" stroke="#b47fe8" stroke-width="1"/>
                <line x1="260" y1="100" x2="260" y2="500" stroke="#b47fe8" stroke-width="1"/>
                <line x1="160" y1="80"  x2="200" y2="80"  stroke="#b47fe8" stroke-width="1"/>
                <line x1="160" y1="200" x2="240" y2="200" stroke="#b47fe8" stroke-width="1"/>
                <line x1="160" y1="320" x2="260" y2="320" stroke="#b47fe8" stroke-width="1"/>
                <line x1="160" y1="440" x2="240" y2="440" stroke="#b47fe8" stroke-width="1"/>
                <circle cx="200" cy="80"  r="4" fill="#b47fe8"/>
                <circle cx="240" cy="200" r="4" fill="#b47fe8"/>
                <circle cx="260" cy="320" r="4" fill="#b47fe8"/>
                <circle cx="240" cy="440" r="4" fill="#b47fe8"/>
                <circle cx="200" cy="560" r="4" fill="#b47fe8"/>
            </svg>
        </div>

        <!-- Decorative circuit pattern - left side -->
        <div class="circuit-left">
            <svg viewBox="0 0 200 500" xmlns="http://www.w3.org/2000/svg">
                <line x1="40" y1="0"   x2="40"  y2="500" stroke="#b47fe8" stroke-width="1"/>
                <line x1="80" y1="100" x2="80"  y2="500" stroke="#b47fe8" stroke-width="1"/>
                <line x1="40" y1="120" x2="140" y2="120" stroke="#b47fe8" stroke-width="1"/>
                <line x1="40" y1="260" x2="120" y2="260" stroke="#b47fe8" stroke-width="1"/>
                <line x1="40" y1="400" x2="140" y2="400" stroke="#b47fe8" stroke-width="1"/>
                <circle cx="40" cy="120" r="4" fill="#b47fe8"/>
                <circle cx="80" cy="260" r="4" fill="#b47fe8"/>
                <circle cx="40" cy="400" r="4" fill="#b47fe8"/>
            </svg>
        </div>

        <!-- Logo, welcome title, login button -->
        <div class="hero-content">

            <!-- figure and figcaption are semantic HTML5 elements -->
            <figure class="hero-logo">
                <span class="hero-icon">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <rect x="2" y="2" width="32" height="24" rx="3" stroke="#b47fe8" stroke-width="1.8"/>
                        <line x1="2"  y1="30" x2="34" y2="30" stroke="#b47fe8" stroke-width="1.8"/>
                        <line x1="18" y1="26" x2="18" y2="30" stroke="#b47fe8" stroke-width="1.8"/>
                        <path d="M12 14L17 19L24 11" stroke="#b47fe8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <figcaption class="hero-script">Janhavi Gavali</figcaption>
            </figure>

            <h1 class="hero-title">Welcome to my portfolio</h1>

            <!-- Login button -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="addEntry.php" class="hero-btn">ADD POST</a>
            <?php else: ?>
                <a href="login.php" class="hero-btn">LOGIN</a>
            <?php endif; ?>

        </div>

        <!-- Social media icon links -->
        <div class="hero-socials">

            <!-- Instagram -->
            <a href="https://www.instagram.com/janhavii._fr/" target="_blank" class="social-link" aria-label="Instagram">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5"/>
                    <circle cx="12" cy="12" r="5"/>
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                </svg>
            </a>

            <!-- Facebook -->
            <a href="https://www.facebook.com/profile.php?id=100015959791867" target="_blank" class="social-link" aria-label="Facebook">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5"/>
                    <path d="M15 2h-2a4 4 0 0 0-4 4v3H7v4h2v8h4v-8h3l1-4h-4V6a1 1 0 0 1 1-1h3z"/>
                </svg>
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/in/janhavi-gavali-717537388/" target="_blank" class="social-link" aria-label="LinkedIn">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5"/>
                    <path d="M8 11v5M8 8v.01M12 16v-5M12 11a3 3 0 0 1 6 0v5"/>
                </svg>
            </a>

            <!-- GitHub -->
            <a href="https://github.com/JanhaviG007" target="_blank" class="social-link" aria-label="GitHub">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
                </svg>
            </a>

        </div>

    </section>


    <!-- Main content -->
    <main>

        <!-- About me -->
        <section id="about" class="page-section about-section">

            <!-- CSS Grid: 2 columns (photo | text) -->
            <div class="about-grid">

                <!-- Profile photo placeholder (figure + figcaption) -->
                <figure class="about-figure">
                    <div class="about-photo-placeholder">
                        <img src="me.jpg" alt="Profile photo of Janhavi Gavali" class="about-photo"/>
                    </div>
                    <figcaption class="about-caption">It's me!</figcaption>
                </figure>

                <!-- About text inside an article element -->
                <article>
                    <h2 class="section-title">ABOUT</h2>
                    <div class="section-rule"></div>
                    <p class="about-subtitle"><em>BSc Computer Science student at Queen Mary University of London.</em></p>
                    <p class="about-body">
                        Motivated BSc Computer Science student at Queen Mary University of London with
                        strong interests in artificial intelligence, machine learning, and cybersecurity.
                        Experienced in software development through an industry internship, with proven
                        problem-solving, teamwork, and communication skills. Actively seeking opportunities
                        to apply technical knowledge in real-world and international academic or professional
                        environments.
                    </p>

                    <!-- Personal attributes displayed as small boxes -->
                    <div class="attributes-row">
                        <span class="attr-box">Proactive &amp; Self-motivated</span>
                        <span class="attr-box">Ethical</span>
                        <span class="attr-box">Analytical</span>
                        <span class="attr-box">Team-Oriented</span>
                    </div>
                </article>

            </div>

        </section>


        <!-- Work experience -->
        <section id="experience" class="page-section experience-section">
            <h2 class="section-title">EXPERIENCE</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: 3 columns -->
            <div class="exp-grid">

                <article class="exp-card">
                    <h3 class="exp-company">ESDS Software Solution Limited</h3>
                    <p class="exp-role-title">Intern - Software Division Department</p>
                    <ul class="exp-list">
                        <li>Developed and deployed software solutions using Python and PHP.</li>
                        <li>Interacted with clients to understand technical requirements and deliver effective solutions.</li>
                        <li>Collaborated with cross-functional teams to meet project goals and deadlines.</li>
                        <li>Prepared technical documentation for implemented systems.</li>
                        <li>Gained exposure to emerging technologies through internal training sessions.</li>
                    </ul>
                </article>

                <article class="exp-card">
                    <h3 class="exp-company">Queen Mary University of London</h3>
                    <p class="exp-role-title">President - QM North Star Society (2025 - Present)</p>
                    <ul class="exp-list">
                        <li>Lead and manage a student society, organising events and activities for members.</li>
                        <li>Coordinate with QMSU and committee members to plan initiatives and promote engagement.</li>
                        <li>Developed leadership, organisation, and communication skills in a multicultural setting.</li>
                    </ul>
                </article>

                <article class="exp-card">
                    <h3 class="exp-company">Volunteering &amp; Community</h3>
                    <p class="exp-role-title">University Events &amp; Mile End Park Run</p>
                    <ul class="exp-list">
                        <li>Supported university-led volunteering initiatives, contributing to community-focused events.</li>
                        <li>Assisted with event setup, coordination, and participant support during Mile End Park Run.</li>
                        <li>Demonstrated teamwork, reliability, and commitment to community engagement.</li>
                    </ul>
                </article>

            </div>
        </section>


        <!-- Skills bar chart -->
        <section id="skills" class="page-section skills-section">
            <h2 class="section-title">SKILLS</h2>
            <div class="section-rule"></div>

            <div class="skills-chart-wrap">

                <!-- Y-axis labels -->
                <div class="skills-y-axis">
                    <span>expert -</span>
                    <span>advanced -</span>
                    <span>intermediate -</span>
                    <span>beginner -</span>
                </div>

                <!-- Bar chart (Flexbox row) -->
                <div class="skills-chart">

                    <!-- Programming: 7 bars (Python, Java, PHP, HTML, CSS, JS, MySQL) -->
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 90%;"></div>
                        <span class="skill-name">Python</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 50%;"></div>
                        <span class="skill-name">Java</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 70%;"></div>
                        <span class="skill-name">PHP</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 92%;"></div>
                        <span class="skill-name">HTML</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 90%;"></div>
                        <span class="skill-name">CSS</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 80%;"></div>
                        <span class="skill-name">JS</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 75%;"></div>
                        <span class="skill-name">MySQL</span>
                    </div>

                    <!-- Programming category label -->
                    <div class="skills-divider prog-divider">Programming</div>

                    <!-- Professional: 4 bars -->
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 80%;"></div>
                        <span class="skill-name">Problem Solving</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 65%;"></div>
                        <span class="skill-name">Teamwork</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 90%;"></div>
                        <span class="skill-name">Time Mgmt</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 60%;"></div>
                        <span class="skill-name">Tech Docs</span>
                    </div>

                    <!-- Professional category label -->
                    <div class="skills-divider prof-divider">Professional</div>

                    <!-- Personal: 3 bars -->
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 60%;"></div>
                        <span class="skill-name">Leadership</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 80%;"></div>
                        <span class="skill-name">Analytical</span>
                    </div>
                    <div class="skill-bar-group">
                        <div class="skill-bar" style="height: 55%;"></div>
                        <span class="skill-name">Communication</span>
                    </div>

                    <!-- Personal category label -->
                    <div class="skills-divider pers-divider">Personal</div>

                </div>
            </div>
        </section>


        <!-- Education -->
        <section id="education" class="page-section education-section">
            <h2 class="section-title">EDUCATION</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: 3 columns -->
            <div class="edu-grid">

                <article class="edu-card edu-light">
                    <h3 class="edu-institution">Queen Mary University of London</h3>
                    <p class="edu-degree"><strong>BSc Computer Science</strong></p>
                    <p class="edu-dates">September 2025 - Present</p>
                </article>

                <article class="edu-card edu-light">
                    <h3 class="edu-institution">PM Shri Kendriya Vidyalaya Nasik Road Camp</h3>
                    <p class="edu-degree"><strong>12th Science (PCM, CS)</strong></p>
                    <p class="edu-dates">2025</p>
                </article>

                <article class="edu-card edu-light">
                    <h3 class="edu-institution">PM Shri Kendriya Vidyalaya Nasik Road Camp</h3>
                    <p class="edu-degree"><strong>10th Standard</strong></p>
                    <p class="edu-dates">2023</p>
                </article>

            </div>
        </section>


        <!-- Interests -->
        <section id="interests" class="page-section interests-section">
            <h2 class="section-title">INTERESTS</h2>
            <div class="section-rule"></div>

            <!-- Flexbox row of interest cards -->
            <div class="interests-grid">

                <div class="interest-card">
                    <span class="interest-icon">&#128111;</span>
                    <p class="interest-name">Dance</p>
                </div>

                <div class="interest-card">
                    <span class="interest-icon">&#128218;</span>
                    <p class="interest-name">Reading</p>
                </div>

                <div class="interest-card">
                    <span class="interest-icon">&#9917;</span>
                    <p class="interest-name">Sports</p>
                </div>

                <div class="interest-card">
                    <span class="interest-icon">&#127760;</span>
                    <p class="interest-name">Net Surfing</p>
                </div>

                <div class="interest-card">
                    <span class="interest-icon">&#127939;</span>
                    <p class="interest-name">Running</p>
                </div>

            </div>
        </section>


        <!-- Projects -->
        <section id="portfolio-projects" class="page-section projects-section">
            <h2 class="section-title">PROJECTS</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: 3 columns -->
            <div class="projects-grid">

                <article class="project-card">
                    <div class="project-tag">Web Dev</div>
                    <h3 class="project-title">Portfolio Website</h3>
                    <p class="project-desc">A personal portfolio site built with HTML5, CSS and PHP showcasing skills, experience and a blog. Developed as part of the ECS417U module at QMUL.</p>
                    <a href="https://github.com/JanhaviG007" target="_blank" class="project-link">View on GitHub &rarr;</a>
                </article>

                <article class="project-card">
                    <div class="project-tag">Java</div>
                    <h3 class="project-title">Simple Quiz - Java</h3>
                    <p class="project-desc">A command-line quiz application built in Java. Tests the user with multiple-choice questions, tracks the score, and displays the final result at the end.</p>
                    <a href="https://github.com/JanhaviG007/simple-quiz-java" target="_blank" class="project-link">View on GitHub &rarr;</a>
                </article>

                <article class="project-card">
                    <div class="project-tag">Data Analysis</div>
                    <h3 class="project-title">Wikipedia Clickstream &amp; ChatGPT Trends</h3>
                    <p class="project-desc">Data analysis project exploring Wikipedia clickstream patterns and changes in ChatGPT search trends over time, using Python for data processing and visualisation.</p>
                    <a href="https://github.com/JanhaviG007/Wikipedia-Clickstream" target="_blank" class="project-link">View on GitHub &rarr;</a>
                </article>

            </div>
        </section>


        <!-- Blog -->
        <section id="blog-section" class="page-section blog-section">
            <h2 class="section-title">BLOG</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: blog posts on left, add entry link on right -->
            <div class="blog-grid">

                <!-- Left: blog posts list (article element) -->
                <article class="blog-main">
                    <?php if (count($blog_posts) > 0): ?>
                        <?php foreach ($blog_posts as $post): ?>
                            <?php 
                                // Truncate body to 300 characters for preview
                                $preview_length = 300;
                                $full_body = $post['body'];
                                $preview_body = strlen($full_body) > $preview_length ? substr($full_body, 0, $preview_length) . '...' : $full_body;
                                $has_more = strlen($full_body) > $preview_length;
                            ?>
                            <article class="blog-post-card">
                                <div class="blog-post-header">
                                    <div class="blog-post-title-row">
                                        <h3 class="blog-post-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                                            <button class="delete-btn" onclick="deletePost(<?php echo $post['id']; ?>)" title="Delete this post">×</button>
                                        <?php endif; ?>
                                    </div>
                                    <p class="blog-post-date">
                                        <?php 
                                            $date_obj = DateTime::createFromFormat('Y-m-d', $post['post_date']);
                                            echo $date_obj->format('F j, Y');
                                        ?>
                                        at <?php echo date('g:i A', strtotime($post['post_time'])); ?>
                                    </p>
                                </div>
                                <div class="blog-post-body">
                                    <?php echo nl2br(htmlspecialchars($preview_body)); ?>
                                </div>
                                <div class="blog-post-actions">
                                    <?php if ($has_more): ?>
                                        <button class="view-more-btn" onclick="expandPost(this, <?php echo htmlspecialchars(json_encode($full_body)); ?>)">View More ↓</button>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
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
                </aside>

            </div>

        </section>


        <!-- Contact details -->
        <section id="contact" class="page-section contact-section">
            <h2 class="section-title">CONTACT</h2>
            <div class="section-rule"></div>

            <!-- CSS Grid: 2 columns -->
            <div class="contact-grid">
                <article class="contact-info">
                    <p class="contact-item">
                        <span class="contact-label">Phone:</span>
                        <span>+44 7767 520590</span>
                    </p>
                    <p class="contact-item">
                        <span class="contact-label">Email:</span>
                        <a href="mailto:janhavii.gavali01@gmail.com" class="contact-link">janhavii.gavali01@gmail.com</a>
                    </p>
                    <p class="contact-item">
                        <span class="contact-label">Location:</span>
                        <span>Mile End, London (currently)</span>
                    </p>
                </article>
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

    <!-- External JavaScript file for blog delete and expand functionality -->
    <script src="js/blog.js"></script>

</body>
</html>
