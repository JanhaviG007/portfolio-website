# Janhavi Gavali — Portfolio

A PHP portfolio website for Janhavi Gavali, a second-year BSc Computer Science student at Queen Mary University of London. The site includes portfolio sections, project pages, and a PHP/MySQL-backed blog with owner login.

## Technologies

- HTML, CSS and JavaScript
- PHP sessions and MySQLi
- MySQL
- XAMPP for local development

## Project structure

```text
.
├── addEntry.php          # Owner-only new blog post form
├── addPost.php           # Validates and saves a blog post
├── db_connect.php        # MySQL connection used by the site
├── deletePost.php        # Owner-only blog post deletion
├── html/
│   ├── education.html    # Education page
│   ├── portfolio.html    # Project details
│   └── skills.html       # Skills by category
├── index.php             # Portfolio homepage and blog previews
├── init_database.php.disabled # Disabled local database initializer (not for deployment)
├── js/                   # Blog, preview and archive interactions
├── css/                  # Shared reset and site styles
├── login.php             # Owner login form
├── loginProcess.php      # Credential check and session setup
├── logout.php            # Ends the owner session
├── me.jpg                # Profile image
└── viewBlog.php          # Full blog and month archive
```

## Run locally with XAMPP

1. Install and start Apache and MySQL from the XAMPP Control Panel.
2. Place this project folder inside the XAMPP `htdocs` directory.
3. Create the `portfolio_blog` database and its `users` and `blog_posts` tables using your local SQL setup or an existing database backup. The initializer is deliberately disabled in this project copy and must not be exposed on a public deployment.
4. Configure `db_connect.php` for your local MySQL credentials.
5. Open `http://localhost/portfolio-website/` to view the portfolio.
6. Use the Login link to access the owner-only post form. The `users.password` column must contain a PHP `password_hash()` value because login uses `password_verify()`.

The database connection defaults in `db_connect.php` are configured for a local XAMPP MySQL installation. Change them only when configuring a different local or hosted database. The database initializer is disabled in this project copy. Do not re-enable or expose it on a public deployment.

## Blog functionality

- Logged-out visitors can read recent posts on the homepage and browse the month archive at `viewBlog.php`.
- The owner can log in, add a post with a preview, and delete posts.
- Blog posts are stored in the `blog_posts` MySQL table. The `users` table stores password hashes.
- The homepage and archive sort posts by date and time in PHP.

## External project links

Project cards link to the associated GitHub repositories. The GroupTrip Planner project has its own setup instructions and Supabase configuration requirements in its repository README.
