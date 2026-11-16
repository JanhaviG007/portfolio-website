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
    <title>Janhavi Gavali | Computer Science Student</title>
    <meta name="description" content="Janhavi Gavali is a second-year Computer Science student at Queen Mary University of London, building software projects and developing experience in technology." />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Janhavi Gavali | Computer Science Student" />
    <meta property="og:description" content="Portfolio of Janhavi Gavali, second-year Computer Science student at Queen Mary University of London." />
    <!-- Reset stylesheet -->
    <link rel="stylesheet" href="css/reset.css" />
    <!-- Main stylesheet -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/summer-theme.css" />
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
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#experience">Experience</a></li>
                    <li><a href="#leadership">Leadership</a></li>
                    <li><a href="html/skills.html">Skills</a></li>
                    <li><a href="html/education.html">Education</a></li>
                    <li><a href="#awards">Awards</a></li>
                    <li><a href="html/portfolio.html">Projects</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#blog-section">Blog</a></li>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <li class="nav-welcome">Welcome, <?php echo htmlspecialchars(explode('@', $_SESSION['user_email'])[0]); ?></li>
                        <li><a href="addEntry.php">Add Post</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
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

        <!-- Portfolio introduction and visitor actions -->
        <div class="hero-content">
            <p class="hero-eyebrow">Queen Mary University of London</p>
            <h1 class="hero-title">Janhavi Gavali</h1>
            <p class="hero-role">Second-Year Computer Science Student <span aria-hidden="true">|</span> Developer</p>
            <p class="hero-intro">
                I build useful software and explore how data and technology can solve real-world problems. My experience spans development, research, student leadership and community volunteering.
            </p>
            <div class="hero-actions">
                <a href="#portfolio-projects" class="hero-btn hero-btn-primary">View Projects</a>
                <a href="https://github.com/JanhaviG007" class="hero-btn" target="_blank" rel="noopener noreferrer">GitHub</a>
                <a href="https://www.linkedin.com/in/janhavi-gavali/" class="hero-btn" target="_blank" rel="noopener noreferrer">LinkedIn</a>
                <a href="#contact" class="hero-btn">Get in Touch</a>
            </div>
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
                    <p class="about-subtitle">Second-year BSc Computer Science student at Queen Mary University of London.</p>
                    <p class="about-body">
                        I’m a second-year BSc Computer Science student at Queen Mary University of London, interested in building useful software and exploring data-led solutions. Through projects, a software development internship and student leadership, I’ve developed a practical, collaborative approach to problem-solving.
                    </p>

                    <div class="attributes-row">
                        <span class="attr-box">Software Development</span>
                        <span class="attr-box">Web Development</span>
                        <span class="attr-box">Research &amp; Data</span>
                        <span class="attr-box">Problem Solving</span>
                    </div>
                </article>

            </div>

        </section>


        <!-- Work experience -->
        <section id="experience" class="page-section experience-section">
            <h2 class="section-title">EXPERIENCE</h2>
            <div class="section-rule"></div>

            <div class="exp-grid">

                <article class="exp-card">
                    <h3 class="exp-company">Software Development Intern</h3>
                    <p class="exp-role-title">ESDS Software Solution Limited</p>
                    <ul class="exp-list">
                        <li>Developed software solutions using Python and PHP.</li>
                        <li>Worked with clients and cross-functional teams to understand requirements and deliver solutions.</li>
                        <li>Prepared technical documentation for implemented systems.</li>
                    </ul>
                </article>

                <article class="exp-card">
                    <h3 class="exp-company">Invigilator</h3>
                    <p class="exp-role-title">LONdon IT Training · September 2026</p>
                    <ul class="exp-list">
                        <li>Supported exam sessions with candidate checks, seating and room supervision.</li>
                        <li>Managed examination materials, attendance and incident records in line with procedures.</li>
                    </ul>
                </article>

            </div>
        </section>

        <section id="leadership" class="page-section leadership-section">
            <h2 class="section-title">LEADERSHIP &amp; VOLUNTEERING</h2>
            <div class="section-rule"></div>
            <div class="leadership-grid">
                <article class="leadership-item">
                    <h3 class="leadership-role">Secretary General</h3>
                    <p class="leadership-org">QM Bollywood Dance Society · 2026–Present</p>
                    <p>Coordinate rehearsals, performances and events for 30+ members, and manage society communications.</p>
                </article>
                <article class="leadership-item">
                    <h3 class="leadership-role">President</h3>
                    <p class="leadership-org">QM North Star Society · Sep 2025–Jun 2026</p>
                    <p>Led a multicultural society of 25+ members and planned inclusive events with QMSU and the committee.</p>
                </article>
            </div>
            <article class="volunteering-card">
                <p class="volunteering-summary">QMSU Volunteer Champion · Community and STEM outreach</p>
                <p class="volunteering-body">
                    My volunteering includes customer and mobility support at Queen Elizabeth Olympic Park,
                    retail support at St Joseph’s Hospice, STEM outreach as a STEM Ambassador, and community
                    activities with GOSH Charity, Solidarity Sports and Mile End parkrun. I have also supported
                    QMSU Language Speaking Practice through informal English and Hindi conversation with international students.
                </p>
            </article>
        </section>

        <section id="skills" class="page-section skills-section">
            <h2 class="section-title">SKILLS</h2>
            <div class="section-rule"></div>

            <div class="skills-detail-grid">
                <article class="skill-category">
                    <h3 class="inner-card-title">Languages</h3>
                    <ul class="skill-list">
                        <li>Java</li><li>Python</li><li>JavaScript</li><li>PHP</li><li>SQL</li>
                    </ul>
                </article>
                <article class="skill-category">
                    <h3 class="inner-card-title">Web Development</h3>
                    <ul class="skill-list">
                        <li>HTML</li><li>CSS</li><li>JavaScript</li><li>React</li>
                    </ul>
                </article>
                <article class="skill-category">
                    <h3 class="inner-card-title">Database</h3>
                    <ul class="skill-list">
                        <li>MySQL</li><li>Supabase</li>
                    </ul>
                </article>
                <article class="skill-category">
                    <h3 class="inner-card-title">Tools</h3>
                    <ul class="skill-list">
                        <li>Git</li><li>GitHub</li><li>VS Code</li><li>Vite</li><li>REST APIs</li>
                    </ul>
                </article>
                <article class="skill-category">
                    <h3 class="inner-card-title">Concepts</h3>
                    <ul class="skill-list">
                        <li>Object-Oriented Programming</li><li>Algorithms &amp; Data Structures</li>
                        <li>Database Design</li><li>Software Development</li><li>Problem Solving</li>
                    </ul>
                </article>
            </div>
        </section>


        <!-- Education -->
        <section id="education" class="page-section education-section">
            <h2 class="section-title">EDUCATION</h2>
            <div class="section-rule"></div>

            <div class="edu-grid">

                <article class="edu-card edu-light">
                    <h3 class="edu-institution">Queen Mary University of London</h3>
                    <p class="edu-degree"><strong>BSc Computer Science</strong></p>
                    <p class="edu-dates">September 2025 - 2028 · Expected</p>
                    <p class="edu-modules">
                        Relevant modules: Object-Oriented Programming, Computer Systems and Networks,
                        Logic and Discrete Structures, Fundamentals of Web Technology, Automata and Formal
                        Languages, Information System Analysis, Procedural Programming and Software Engineering.
                    </p>
                </article>

            </div>
        </section>


        <section id="awards" class="page-section awards-section">
            <h2 class="section-title">AWARDS</h2>
            <div class="section-rule"></div>
            <ul class="awards-list">
                <li>Gold Medalist (2×) · International Mathematics Olympiad</li>
                <li>Bronze Medalist (2×) · National Science Olympiad</li>
                <li>Ranked 1st at school level · International English Olympiad</li>
            </ul>
        </section>

        <!-- Projects -->
        <section id="portfolio-projects" class="page-section projects-section">
            <h2 class="section-title">PROJECTS</h2>
            <div class="section-rule"></div>

            <div class="projects-grid">

                <article class="project-card project-card-featured">
                    <div class="project-tag">Featured · Full-stack web application</div>
                    <h3 class="project-title">GroupTrip Planner</h3>
                    <p class="project-desc">
                        A group trip management application for organising trips and shared expenses.
                        Users can authenticate, create and view trips, manage trip details and members,
                        record and split expenses, and review budget summaries. It uses Supabase for
                        database integration and an Edge Function for protected user lookup.
                    </p>
                    <ul class="project-tech-list" aria-label="Technologies used">
                        <li>React</li><li>Vite</li><li>JavaScript</li><li>Supabase</li>
                    </ul>
                    <a href="https://github.com/JanhaviG007/grouptrip-planner" target="_blank" rel="noopener noreferrer" class="project-link project-action">View on GitHub <span aria-hidden="true">&rarr;</span></a>
                </article>

                <article class="project-card project-card-research">
                    <div class="project-tag">Women in STEM Hackathon · Data analysis and NLP</div>
                    <h3 class="project-title">Wikipedia × ChatGPT Topic Intelligence</h3>
                    <p class="project-desc">
                        Worked in Team HackMates to investigate reader navigation after Wikipedia’s ChatGPT
                        article, analysing 50,000+ clickstream records across 28 articles. Applied TF-IDF,
                        LDA topic modelling, Ridge regression and network analysis to identify topic clusters
                        and influential pages.
                    </p>
                    <ul class="project-tech-list" aria-label="Methods used">
                        <li>Python</li><li>TF-IDF</li><li>LDA</li><li>Ridge Regression</li><li>PageRank</li><li>HITS</li>
                    </ul>
                    <p class="project-desc">Identified 7 latent topic clusters (R² = 0.41) and analysed a network of 7,343 graph edges.</p>
                </article>

                <article class="project-card">
                    <div class="project-tag">Java · Desktop application</div>
                    <h3 class="project-title">Typing Race Simulator</h3>
                    <p class="project-desc">
                        A Java typing-race simulation with a graphical interface, race setup and
                        live race display. The project includes screens for race results and personal
                        bests, with attention to clear interaction and interface design.
                    </p>
                    <a href="https://github.com/JanhaviG007/TypingRaceSimulator" target="_blank" rel="noopener noreferrer" class="project-link">View on GitHub <span aria-hidden="true">&rarr;</span></a>
                </article>

                <article class="project-card">
                    <div class="project-tag">Web Development</div>
                    <h3 class="project-title">Portfolio Website</h3>
                    <p class="project-desc">
                        A university web-development project demonstrating frontend development,
                        PHP backend functionality, MySQL database integration and responsive design.
                    </p>
                    <ul class="project-tech-list" aria-label="Technologies used">
                        <li>HTML</li><li>CSS</li><li>JavaScript</li><li>PHP</li><li>MySQL</li>
                    </ul>
                    <a href="html/portfolio.html" class="project-link">Project details <span aria-hidden="true">&rarr;</span></a>
                </article>

                <article class="project-card">
                    <div class="project-tag">Java</div>
                    <h3 class="project-title">Simple Quiz</h3>
                    <p class="project-desc">
                        A command-line Java quiz with multiple-choice questions, score tracking
                        and a final result summary.
                    </p>
                    <a href="https://github.com/JanhaviG007/simple-quiz-java" target="_blank" rel="noopener noreferrer" class="project-link">View on GitHub <span aria-hidden="true">&rarr;</span></a>
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
                                            <button type="button" class="delete-btn" onclick="deletePost(<?php echo $post['id']; ?>)" title="Delete this post" aria-label="Delete this post">×</button>
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
                        <span class="contact-label">Email:</span>
                        <a href="mailto:janhavii.gavali01@gmail.com" class="contact-link">janhavii.gavali01@gmail.com</a>
                    </p>
                    <p class="contact-item">
                        <span class="contact-label">LinkedIn:</span>
                        <a href="https://www.linkedin.com/in/janhavi-gavali/" class="contact-link" target="_blank" rel="noopener noreferrer">linkedin.com/in/janhavi-gavali</a>
                    </p>
                    <p class="contact-item">
                        <span class="contact-label">GitHub:</span>
                        <a href="https://github.com/JanhaviG007" class="contact-link" target="_blank" rel="noopener noreferrer">github.com/JanhaviG007</a>
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
                <a href="#about">About</a>
                <a href="#experience">Experience</a>
                <a href="#leadership">Leadership</a>
                <a href="html/skills.html">Skills</a>
                <a href="html/education.html">Education</a>
                <a href="#awards">Awards</a>
                <a href="html/portfolio.html">Projects</a>
                <a href="#contact">Contact</a>
                <a href="#blog-section">Blog</a>
            </nav>

        </div>
    </footer>

    <!-- External JavaScript file for blog delete and expand functionality -->
    <script src="js/blog.js"></script>

</body>
</html>
