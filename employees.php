<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$search = '';
$where = '';

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $where = " WHERE name LIKE '%$search%' OR department LIKE '%$search%'";
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$total = $conn->query("SELECT COUNT(*) as total FROM employees$where")->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total / $limit);

$result = $conn->query("SELECT * FROM employees$where ORDER BY id DESC LIMIT $offset, $limit");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    
    $conn->exec("INSERT INTO employees (name, email, phone, department, position, salary) VALUES ('$name', '$email', '$phone', '$department', '$position', '$salary')");
    header('Location: employees.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->exec("DELETE FROM employees WHERE id = $id");
    header('Location: employees.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 员工管理</title>
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
            <h1>员工管理</h1>
            <div class="toolbar">
                <form method="get" class="search-form">
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="搜索姓名或部门">
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>
                <button class="btn btn-success" onclick="showAddForm()">添加员工</button>
            </div>
            <div id="addForm" style="display:none;" class="form-container">
                <h3>添加新员工</h3>
                <form method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label>姓名</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>邮箱</label>
                            <input type="email" name="email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>电话</label>
                            <input type="text" name="phone">
                        </div>
                        <div class="form-group">
                            <label>部门</label>
                            <input type="text" name="department">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>职位</label>
                            <input type="text" name="position">
                        </div>
                        <div class="form-group">
                            <label>薪资</label>
                            <input type="number" step="0.01" name="salary">
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
                        <th>姓名</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>部门</th>
                        <th>职位</th>
                        <th>薪资</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['salary']; ?></td>
                        <td>
                            <a href="employee_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">编辑</a>
                            <a href="employees.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('确定删除？')">删除</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="employees.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
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