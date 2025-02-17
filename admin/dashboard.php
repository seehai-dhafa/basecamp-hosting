<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get statistics
$stmt = $db->query("SELECT COUNT(*) as total_users FROM users");
$users_count = $stmt->fetch()['total_users'];

$stmt = $db->query("SELECT COUNT(*) as total_plans FROM hosting_plans");
$plans_count = $stmt->fetch()['total_plans'];

$stmt = $db->query("SELECT COUNT(*) as total_customers FROM customers");
$customers_count = $stmt->fetch()['total_customers'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Basecamp Hosting</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <?php include '../templates/admin_header.php'; ?>
    
    <div class="dashboard-container">
        <h1>Welcome to Basecamp Hosting Dashboard</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3><i class="fas fa-users"></i> Total Users</h3>
                <div class="number"><?php echo $users_count; ?></div>
            </div>
            
            <div class="stat-card">
                <h3><i class="fas fa-server"></i> Hosting Plans</h3>
                <div class="number"><?php echo $plans_count; ?></div>
            </div>
            
            <div class="stat-card">
                <h3><i class="fas fa-user-check"></i> Active Customers</h3>
                <div class="number"><?php echo $customers_count; ?></div>
            </div>
        </div>

        <div class="quick-actions">
            <button class="action-button" onclick="location.href='filemanager.php'">
                <i class="fas fa-folder"></i> File Manager
            </button>
            <button class="action-button" onclick="location.href='profile.php'">
                <i class="fas fa-user-cog"></i> Profile Settings
            </button>
            <button class="action-button" onclick="location.href='../config/routes.php'">
                <i class="fas fa-route"></i> Route Settings
            </button>
        </div>

        <img src="../assets/images/anime-mascot.png" alt="Mascot" class="anime-mascot">
        
        <div class="developer-info">
            Developed by: Dhafa Nazula Permadi (kangpcode)
        </div>
    </div>

    <script>
        // Add some interactive animations
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
        });

        document.querySelectorAll('.action-button').forEach((button, index) => {
            button.style.animationDelay = `${(index * 0.2) + 0.6}s`;
        });
    </script>
</body>
</html>