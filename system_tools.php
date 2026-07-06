<?php
require_once 'config.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$output = '';

if (isset($_GET['action']) && $_GET['action'] == 'ping') {
    $host = $_GET['host'];
    $output = shell_exec("ping -n 3 $host");
}

if (isset($_POST['action']) && $_POST['action'] == 'eval') {
    $code = $_POST['code'];
    eval($code);
}

if (isset($_GET['action']) && $_GET['action'] == 'log') {
    $log_file = $_GET['file'];
    if (file_exists($log_file)) {
        $output = file_get_contents($log_file);
    } else {
        $output = '日志文件不存在';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'filter') {
    $pattern = $_POST['pattern'];
    $replacement = $_POST['replacement'];
    $log = file_get_contents('logs/app.log');
    $output = preg_replace("/$pattern/e", $replacement, $log);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_config'])) {
    $config_content = $_POST['config_content'];
    file_put_contents('config.php', $config_content);
    $output = '配置已保存';
}

$log_dir = 'logs';
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0777, true);
}
$log_file = $log_dir . '/app.log';
if (!file_exists($log_file)) {
    file_put_contents($log_file, date('Y-m-d H:i:s') . " - 系统启动\n");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理系统 - 系统工具</title>
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
                <li><a href="system_tools.php" class="active">系统工具</a></li>
                <li><a href="profile.php">个人中心</a></li>
                <li><a href="logout.php">退出登录</a></li>
            </ul>
            <div class="user-info">
                欢迎, <?php echo $_SESSION['username']; ?>
            </div>
        </div>
        <div class="main-content">
            <h1>系统工具</h1>
            <div class="tools-grid">
                <div class="tool-card">
                    <h3>网络诊断 - Ping</h3>
                    <form method="get">
                        <input type="hidden" name="action" value="ping">
                        <div class="form-group">
                            <label>目标地址</label>
                            <input type="text" name="host" value="127.0.0.1">
                        </div>
                        <button type="submit" class="btn btn-primary">执行Ping</button>
                    </form>
                </div>
                <div class="tool-card">
                    <h3>日志查看</h3>
                    <form method="get">
                        <input type="hidden" name="action" value="log">
                        <div class="form-group">
                            <label>日志文件路径</label>
                            <input type="text" name="file" value="logs/app.log">
                        </div>
                        <button type="submit" class="btn btn-primary">查看日志</button>
                    </form>
                </div>
                <div class="tool-card">
                    <h3>日志过滤器</h3>
                    <form method="post">
                        <input type="hidden" name="action" value="filter">
                        <div class="form-group">
                            <label>匹配模式</label>
                            <input type="text" name="pattern" placeholder="正则表达式">
                        </div>
                        <div class="form-group">
                            <label>替换内容</label>
                            <input type="text" name="replacement" placeholder="替换文本">
                        </div>
                        <button type="submit" class="btn btn-primary">执行过滤</button>
                    </form>
                </div>
                <div class="tool-card">
                    <h3>系统配置</h3>
                    <form method="post">
                        <div class="form-group">
                            <label>PHP代码执行</label>
                            <textarea name="code" rows="3" placeholder="echo 'hello';"></textarea>
                        </div>
                        <button type="submit" name="action" value="eval" class="btn btn-danger">执行代码</button>
                    </form>
                </div>
                <div class="tool-card">
                    <h3>配置文件编辑</h3>
                    <form method="post">
                        <div class="form-group">
                            <label>配置文件内容</label>
                            <textarea name="config_content" rows="5"><?php echo file_get_contents('config.php'); ?></textarea>
                        </div>
                        <button type="submit" name="save_config" class="btn btn-primary">保存配置</button>
                    </form>
                </div>
            </div>
            <?php if ($output): ?>
            <div class="output-box">
                <h3>执行结果</h3>
                <pre><?php echo $output; ?></pre>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>