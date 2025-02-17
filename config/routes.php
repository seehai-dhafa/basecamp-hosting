<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Default routes configuration
$default_routes = [
    'landing_template' => 'default',
    'admin_template' => 'admin',
    'error_template' => 'error'
];

// Handle route update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_template = $_POST['landing_template'];
    
    // Validate template exists
    if (is_dir("../templates/$new_template")) {
        file_put_contents('../config/routes.json', json_encode([
            'landing_template' => $new_template
        ]));
        $success_message = "Routes updated successfully!";
    } else {
        $error_message = "Template directory does not exist!";
    }
}

// Get current routes
$current_routes = json_decode(file_get_contents('../config/routes.json'), true) ?? $default_routes;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Route Settings - Basecamp Hosting</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include '../templates/admin_header.php'; ?>
    
    <div class="container">
        <h2>Route Settings</h2>
        
        <?php if (isset($success_message)): ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="form">
            <div class="form-group">
                <label>Landing Page Template:</label>
                <select name="landing_template" class="form-control">
                    <?php 
                    $templates = array_diff(scandir('../templates'), array('.', '..'));
                    foreach ($templates as $template): 
                        if (is_dir("../templates/$template")):
                    ?>
                        <option value="<?php echo $template; ?>" 
                            <?php echo ($current_routes['landing_template'] == $template) ? 'selected' : ''; ?>>
                            <?php echo ucfirst($template); ?>
                        </option>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </select>
            </div>
            
            <button type="submit" class="action-button">Update Routes</button>
        </form>
    </div>
</body>
</html>