<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$where = '';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $where = " WHERE status = '$status'";
}

$result = $conn->query("SELECT * FROM projects$where ORDER BY created_at DESC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $leader = $_POST['leader'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $conn->exec("INSERT INTO projects (name, description, leader, start_date, end_date) VALUES ('$name', '$description', '$leader', '$start_date', '$end_date')");
    header('Location: projects.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->exec("DELETE FROM projects WHERE id = $id");
    header('Location: projects.php');
    exit;
}

if (isset($_GET['update_status'])) {
    $id = $_GET['update_status'];
    $new_status = $_GET['new_status'];
    $conn->exec("UPDATE projects SET status='$new_status' WHERE id=$id");
    header('Location: projects.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 项目管理</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <h2>管理系统</h2>
            <ul class="nav">
                <li><a href="dashboard.php">仪表盘</a></li>
                <li><a href="employees.php">员工管理</a></li>
                <li><a href="projects.php" class="active">项目管理</a></li>
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
            <h1>项目管理</h1>
            <div class="toolbar">
                <div class="filter-group">
                    <a href="projects.php" class="btn btn-sm <?php echo !isset($_GET['status']) ? 'btn-primary' : 'btn-secondary'; ?>">全部</a>
                    <a href="projects.php?status=pending" class="btn btn-sm <?php echo isset($_GET['status']) && $_GET['status'] == 'pending' ? 'btn-primary' : 'btn-secondary'; ?>">待开始</a>
                    <a href="projects.php?status=in_progress" class="btn btn-sm <?php echo isset($_GET['status']) && $_GET['status'] == 'in_progress' ? 'btn-primary' : 'btn-secondary'; ?>">进行中</a>
                    <a href="projects.php?status=completed" class="btn btn-sm <?php echo isset($_GET['status']) && $_GET['status'] == 'completed' ? 'btn-primary' : 'btn-secondary'; ?>">已完成</a>
                </div>
                <button class="btn btn-success" onclick="showAddForm()">新建项目</button>
            </div>
            <div id="addForm" style="display:none;" class="form-container">
                <h3>新建项目</h3>
                <form method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label>项目名称</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>负责人</label>
                            <input type="text" name="leader">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>项目描述</label>
                        <textarea name="description" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>开始日期</label>
                            <input type="date" name="start_date">
                        </div>
                        <div class="form-group">
                            <label>结束日期</label>
                            <input type="date" name="end_date">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">保存</button>
                    <button type="button" class="btn btn-secondary" onclick="hideAddForm()">取消</button>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>项目名称</th>
                        <th>描述</th>
                        <th>负责人</th>
                        <th>状态</th>
                        <th>开始日期</th>
                        <th>结束日期</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['leader']; ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $row['status']; ?>">
                                <?php 
                                $status_map = array('pending' => '待开始', 'in_progress' => '进行中', 'completed' => '已完成');
                                echo $status_map[$row['status']];
                                ?>
                            </span>
                        </td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td>
                            <a href="projects.php?update_status=<?php echo $row['id']; ?>&new_status=in_progress" class="btn btn-sm btn-primary">开始</a>
                            <a href="projects.php?update_status=<?php echo $row['id']; ?>&new_status=completed" class="btn btn-sm btn-success">完成</a>
                            <a href="projects.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除？')">删除</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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