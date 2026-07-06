<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$emp_count = $conn->query("SELECT COUNT(*) as total FROM employees")->fetch(PDO::FETCH_ASSOC)['total'];
$proj_count = $conn->query("SELECT COUNT(*) as total FROM projects")->fetch(PDO::FETCH_ASSOC)['total'];
$ann_count = $conn->query("SELECT COUNT(*) as total FROM announcements")->fetch(PDO::FETCH_ASSOC)['total'];
$user_count = $conn->query("SELECT COUNT(*) as total FROM users")->fetch(PDO::FETCH_ASSOC)['total'];

$ann_result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 仪表盘</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <h2>管理系统</h2>
            <ul class="nav">
                <li><a href="dashboard.php" class="active">仪表盘</a></li>
                <li><a href="employees.php">员工管理</a></li>
                <li><a href="projects.php">项目管理</a></li>
                <li><a href="announcements.php">公告板</a></li>
                <li><a href="file_manager.php">文件管理</a></li>
                <li><a href="system_tools.php">系统工具</a></li>
                <li><a href="profile.php">个人中心</a></li>
                <li><a href="logout.php">退出登录</a></li>
            </ul>
            <div class="user-info">
                欢迎, <?php echo $_SESSION['username']; ?>
            </div>
        </div>
        <div class="main-content">
            <h1>系统仪表盘</h1>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>员工总数</h3>
                    <p class="stat-number"><?php echo $emp_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3>项目数量</h3>
                    <p class="stat-number"><?php echo $proj_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3>公告数量</h3>
                    <p class="stat-number"><?php echo $ann_count; ?></p>
                </div>
                <div class="stat-card">
                    <h3>用户数量</h3>
                    <p class="stat-number"><?php echo $user_count; ?></p>
                </div>
            </div>
            <div class="section">
                <h2>最新公告</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th>作者</th>
                            <th>发布时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $ann_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>