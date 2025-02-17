<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Basecamp Hosting</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Basecamp Hosting</div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#plans">Hosting Plans</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="admin/dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home" class="hero">
            <h1>Welcome to Basecamp Hosting</h1>
            <p>Reliable hosting solutions for your business</p>
        </section>

        <section id="plans" class="hosting-plans">
            <!-- Add your hosting plans here -->
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Basecamp Hosting. All rights reserved.</p>
    </footer>
</body>
</html>