<?php
/**
 * Database Initialization Script
 * 
 * This script creates the necessary database tables and inserts sample data
 * for testing the blog and authentication system.
 * 
 * Run this script once to set up the database.
 */

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'portfolio_blog';

// Create connection to MySQL (without database)
$conn = new mysqli($db_host, $db_user, $db_password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($db_name);

// Create users table
$users_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

if ($conn->query($users_table) === TRUE) {
    echo "Users table created successfully or already exists.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create blog_posts table
$blog_posts_table = "
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    body LONGTEXT NOT NULL,
    post_date DATE NOT NULL,
    post_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
";

if ($conn->query($blog_posts_table) === TRUE) {
    echo "Blog posts table created successfully or already exists.<br>";
} else {
    echo "Error creating blog_posts table: " . $conn->error . "<br>";
}

// Create comments table
$comments_table = "
CREATE TABLE IF NOT EXISTS comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
)
";

if ($conn->query($comments_table) === TRUE) {
    echo "Comments table created successfully or already exists.<br>";
} else {
    echo "Error creating comments table: " . $conn->error . "<br>";
}

// Insert sample user (if not already exists)
$sample_email = 'janhavii.gavali01@gmail.com';
$sample_password = password_hash('password123', PASSWORD_DEFAULT);

$check_user = "SELECT * FROM users WHERE email = '$sample_email'";
$result = $conn->query($check_user);

// Update/Insert sample user password to ensure it matches 'password123'
if ($result->num_rows == 0) {
    $insert_user = "INSERT INTO users (email, password) VALUES ('$sample_email', '$sample_password')";
    if ($conn->query($insert_user) === TRUE) {
        echo "Sample user created successfully.<br>";
    } else {
        echo "Error creating sample user: " . $conn->error . "<br>";
    }
} else {
    $update_user = "UPDATE users SET password = '$sample_password' WHERE email = '$sample_email'";
    if ($conn->query($update_user) === TRUE) {
        echo "Sample user password updated to 'password123'.<br>";
    } else {
        echo "Error updating sample user: " . $conn->error . "<br>";
    }
}
echo "Email: $sample_email<br>";
echo "Password: password123<br>";

// Insert sample blog posts (if not already exists)
$check_posts = "SELECT COUNT(*) as count FROM blog_posts";
$result = $conn->query($check_posts);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    // The essay from the Automata module
    $essay_body = "When I started the Automata and Formal Languages module, I was not entirely sure why any of it mattered. Drawing state diagrams, writing out transition functions, proving closure properties, it all felt like it belonged to some other world. What changed that feeling was gradually realising that these models are not just mathematical exercises. They are the foundations on which much of modern software is built. This essay traces those connections across finite state automata, context-free grammars, pushdown automata, and Turing machines, and reflects on how studying them has shaped the way I think about computing.\n\nFINITE STATE AUTOMATA AND REGULAR LANGUAGES\nThe first major topic was finite state automata (FSAs) and regular languages. An FSA is defined by a finite set of states, an input alphabet, a transition function, a start state, and a set of accepting states. Despite its simplicity, it can process input strings efficiently without needing any memory beyond the current state. The most direct real-world application is regular expression matching. Every time a developer writes a regex in Python or JavaScript, the engine compiles that pattern into a deterministic finite automaton and simulates it over the input. The equivalence between regular expressions and finite automata, proved formally in lectures, is not just a neat theorem. It is the engineering reason why regex engines are so fast. FSAs also appear in network security, where deep packet inspection tools use finite state machines to track connection states and flag suspicious sequences. TCP itself is modelled as a finite state machine, with states like LISTEN, SYN-RECEIVED, and ESTABLISHED. A less obvious application is in game development, where enemy behaviour, switching between idle, patrol, chase, and attack, is implemented as a finite state machine running in a game loop.\n\nOne topic I took a while to get comfortable with was converting epsilon-NFAs to DFAs from our lab sheets. The epsilon closure process felt mechanical at first. The moment it clicked was when I stopped seeing epsilon transitions as special cases and started seeing them as a notational convenience. The subset construction then collapses all the nondeterminism into an equivalent deterministic machine. Once I understood that NFAs and DFAs recognise the same class of languages, the conversion felt logical rather than arbitrary.\n\nCONTEXT-FREE GRAMMARS AND PARSING\nThe second major topic was context-free grammars (CFGs). A CFG extends the expressive power of regular expressions through recursive production rules, making it possible to describe hierarchically nested structures that finite automata cannot handle. The most important application is in compilers. The syntax of virtually every programming language is defined by a context-free grammar, and parsers built on algorithms like CYK, covered in the module, or LALR(1), used by tools like yacc in industry, all derive directly from CFG theory. CFGs also define HTML, XML, JSON, and SQL, meaning every web request and database query passes through grammar-based parsing. What is worth noting critically is that Chomsky originally developed CFGs partly to model natural human language, yet it turns out human language is not fully context-free. Some constructions require greater expressive power. It is a useful reminder that these models are powerful approximations, not perfect mirrors of reality, and knowing their limits matters as much as knowing their uses.\n\nPUSHDOWN AUTOMATA\nPushdown automata (PDAs) correspond exactly to context-free grammars, extended with a stack for memory. We proved the equivalence between PDAs and CFGs in both directions during the module, which was one of the more satisfying results because it connected two ideas that had previously felt separate. PDAs are not just theoretical. The call stack of any running program is literally a pushdown memory. Every function call pushes a frame, and every return pops one, meaning recursive algorithms are pushdown computations in a precise formal sense. It also explains stack overflows: the physical memory allocated for the call stack is finite, even though the PDA model assumes an unbounded one. Understanding this gave me a much clearer picture of why tail call optimisation matters in languages that support it, since it avoids growing the stack at all.\n\nTURING MACHINES AND COMPUTABILITY\nThe most powerful model we studied was the Turing machine, introduced by Alan Turing in 1936 as a mathematical definition of computation. The Church Turing thesis holds that a Turing machine can compute any function computable by any physical process. The universal Turing machine, which simulates any other machine described it on its tape, is the conceptual ancestor of every general-purpose computer ever built. But what struck me most was what Turing machines cannot do. The halting problem, deciding whether an arbitrary program will halt on a given input, is undecidable. No Turing machine can solve it in general, and this is not a temporary gap waiting for a smarter algorithm. It is a permanent, proven boundary. It explains why no tool can automatically verify all software for correctness, why antivirus checks are fundamentally incomplete, and why program analysis will always have edge cases it cannot handle. There is something almost humbling about this. We have built an entire civilisation on computers, yet the model that defines what a computer is also tells us exactly what computers can never do.\n\nCONCLUSION\nTaking this module has genuinely changed how I think about software. Finite state automata explain why regex is fast and how game AI is structured. Context-free grammars explain how compilers read code and why human language is harder to formalise than it looks. Pushdown automata explain why recursion works and sometimes does not. Turing machines explain both the universality of computation and its hard limits. These are not abstract curiosities. They are the theoretical skeleton beneath almost everything we build, and understanding them makes you a sharper thinker about what software can and cannot do. I came into this module unsure why it was on the syllabus. I am leaving it, thinking it should probably be taught earlier.";

    $sample_posts = [
        [
            'title' => 'From Theory to Technology: Real-World Applications of Formal Languages and Automata',
            'body' => $essay_body,
            'date' => date('Y-m-d', strtotime('-8 days')),
            'time' => '08:00:00'
        ]
    ];

    foreach ($sample_posts as $post) {
        $title = $conn->real_escape_string($post['title']);
        $body = $conn->real_escape_string($post['body']);
        $date = $post['date'];
        $time = $post['time'];

        $insert_post = "INSERT INTO blog_posts (title, body, post_date, post_time) 
                        VALUES ('$title', '$body', '$date', '$time')";
        if ($conn->query($insert_post) === TRUE) {
            echo "Sample post '{$post['title']}' created successfully.<br>";
        } else {
            echo "Error creating sample post: " . $conn->error . "<br>";
        }
    }
} else {
    echo "Sample blog posts already exist.<br>";
}

$conn->close();
echo "<br>Database initialization complete!<br>";
?>
