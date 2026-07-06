<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    
    $conn->exec("UPDATE employees SET name='$name', email='$email', phone='$phone', department='$department', position='$position', salary='$salary' WHERE id=$id");
    header('Location: employees.php');
    exit;
}

$row = $conn->query("SELECT * FROM employees WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 编辑员工</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <h2>管理系统</h2>
            <ul class="nav">
                <li><a href="dashboard.php">仪表盘</a></li>
                <li><a href="employees.php" class="active">员工管理</a></li>
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
            <h1>编辑员工</h1>
            <form method="post" class="form-container">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label>姓名</label>
                        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>邮箱</label>
                        <input type="email" name="email" value="<?php echo $row['email']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>电话</label>
                        <input type="text" name="phone" value="<?php echo $row['phone']; ?>">
                    </div>
                    <div class="form-group">
                        <label>部门</label>
                        <input type="text" name="department" value="<?php echo $row['department']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>职位</label>
                        <input type="text" name="position" value="<?php echo $row['position']; ?>">
                    </div>
                    <div class="form-group">
                        <label>薪资</label>
                        <input type="number" step="0.01" name="salary" value="<?php echo $row['salary']; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">保存修改</button>
                <a href="employees.php" class="btn btn-secondary">返回</a>
            </form>
        </div>
    </div>
</body>
</html>