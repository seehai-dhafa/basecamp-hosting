<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Set upload directory
$upload_dir = '../uploads/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $filename = basename($file['name']);
    $target_path = $upload_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        $success_message = "File uploaded successfully!";
        
        // Handle ZIP extraction
        if (pathinfo($filename, PATHINFO_EXTENSION) == 'zip') {
            $zip = new ZipArchive;
            if ($zip->open($target_path) === TRUE) {
                $zip->extractTo($upload_dir . pathinfo($filename, PATHINFO_FILENAME));
                $zip->close();
                $success_message .= " ZIP file extracted!";
            }
        }
    } else {
        $error_message = "Error uploading file!";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $file = $upload_dir . basename($_GET['delete']);
    if (file_exists($file) && unlink($file)) {
        $success_message = "File deleted successfully!";
    }
}

// Get file list
$files = array_diff(scandir($upload_dir), array('.', '..'));
?>

<!DOCTYPE html>
<html>
<head>
    <title>File Manager - Basecamp Hosting</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../templates/admin_header.php'; ?>
    
    <div class="container">
        <h2>File Manager</h2>
        
        <?php if (isset($success_message)): ?>
            <div class="alert success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <div class="upload-section">
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="file" required>
                <button type="submit">Upload File</button>
            </form>
        </div>
        
        <div class="files-list">
            <table>
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td><?php echo $file; ?></td>
                            <td><?php echo human_filesize(filesize($upload_dir . $file)); ?></td>
                            <td>
                                <a href="<?php echo $upload_dir . $file; ?>" download>Download</a>
                                <a href="?delete=<?php echo urlencode($file); ?>" 
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
function human_filesize($bytes, $decimals = 2) {
    $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
}
?>