<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    
    if (!empty($new_password)) {
        $conn->exec("UPDATE users SET email='$email', password='$new_password' WHERE id=$user_id");
    } else {
        $conn->exec("UPDATE users SET email='$email' WHERE id=$user_id");
    }
    header('Location: profile.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 个人中心</title>
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
                <li><a href="file_manager.php">文件管理</a></li>
                <li><a href="system_tools.php">系统工具</a></li>
                <li><a href="profile.php" class="active">个人中心</a></li>
                <li><a href="logout.php">退出登录</a></li>
            </ul>
            <div class="user-info">
                欢迎, <?php echo $_SESSION['username']; ?>
            </div>
        </div>
        <div class="main-content">
            <h1>个人中心</h1>
            <div class="form-container">
                <h3>个人信息</h3>
                <form method="post">
                    <div class="form-group">
                        <label>用户名</label>
                        <input type="text" value="<?php echo $user['username']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>角色</label>
                        <input type="text" value="<?php echo $user['role']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input type="email" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label>新密码（留空不修改）</label>
                        <input type="password" name="new_password">
                    </div>
                    <button type="submit" class="btn btn-primary">保存修改</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>