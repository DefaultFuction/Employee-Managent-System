<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$upload_dir = UPLOAD_DIR;

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $filename = $_FILES['file']['name'];
    $filesize = $_FILES['file']['size'];
    
    if ($filesize <= MAX_FILE_SIZE) {
        $dest = $upload_dir . $filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $dest);
        header('Location: file_manager.php');
        exit;
    } else {
        $error = '文件大小超过限制';
    }
}

if (isset($_GET['download'])) {
    $file = $_GET['download'];
    $filepath = $upload_dir . $file;
    if (file_exists($filepath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($filepath);
        exit;
    }
}

if (isset($_GET['delete'])) {
    $file = $_GET['delete'];
    $filepath = $upload_dir . $file;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    header('Location: file_manager.php');
    exit;
}

$files = array_diff(scandir($upload_dir), array('.', '..'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 文件管理</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <h2>管理系统</h2>
            <ul class="nav">
                <li><a href="dashboard.php">仪表盘</a></li>
                <li><a href="employees.php">员工管理</a></li>
                <li><a href="projects.php">项目管理</a></li>
                <li><a href="announcements.php">公告板</a></li>
                <li><a href="file_manager.php" class="active">文件管理</a></li>
                <li><a href="system_tools.php">系统工具</a></li>
                <li><a href="profile.php">个人中心</a></li>
                <li><a href="logout.php">退出登录</a></li>
            </ul>
            <div class="user-info">
                欢迎, <?php echo $_SESSION['username']; ?>
            </div>
        </div>
        <div class="main-content">
            <h1>文件管理</h1>
            <div class="upload-form">
                <form method="post" enctype="multipart/form-data">
                    <input type="file" name="file" required>
                    <button type="submit" class="btn btn-primary">上传文件</button>
                </form>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>文件名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                    <tr>
                        <td><?php echo $file; ?></td>
                        <td>
                            <a href="file_manager.php?download=<?php echo $file; ?>" class="btn btn-sm btn-primary">下载</a>
                            <a href="file_manager.php?delete=<?php echo $file; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除？')">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($files)): ?>
                    <tr>
                        <td colspan="2" class="text-center">暂无文件</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>