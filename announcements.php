<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];
    
    $conn->exec("INSERT INTO announcements (title, content, author) VALUES ('$title', '$content', '$author')");
    header('Location: announcements.php');
    exit;
}

$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 公告板</title>
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
                <li><a href="announcements.php" class="active">公告板</a></li>
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
            <h1>公告板</h1>
            <button class="btn btn-success" onclick="showAddForm()">发布公告</button>
            <div id="addForm" style="display:none;" class="form-container">
                <h3>发布新公告</h3>
                <form method="post">
                    <div class="form-group">
                        <label>标题</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>内容</label>
                        <textarea name="content" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">发布</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">取消</button>
                </form>
            </div>
            <div class="announcement-list">
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="announcement-card">
                    <div class="announcement-header">
                        <h3><?php echo $row['title']; ?></h3>
                        <div class="announcement-meta">
                            <span>作者: <?php echo $row['author']; ?></span>
                            <span>时间: <?php echo $row['created_at']; ?></span>
                        </div>
                    </div>
                    <div class="announcement-body">
                        <?php echo $row['content']; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <script>
        function showAddForm() {
            document.getElementById('addForm').style.display = 'block';
        }
        function hideAddForm() {
            document.getElementById('addForm').style.display = 'none';
        }
    </script>
</body>
</html>