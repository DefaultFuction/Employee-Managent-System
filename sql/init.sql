CREATE DATABASE IF NOT EXISTS management_system;
USE management_system;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    department VARCHAR(50),
    position VARCHAR(50),
    salary DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    leader VARCHAR(100),
    status VARCHAR(20) DEFAULT 'pending',
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password, email, role) VALUES ('admin', 'admin123', 'admin@system.com', 'admin');
INSERT INTO users (username, password, email, role) VALUES ('test', '123456', 'test@system.com', 'user');

INSERT INTO employees (name, email, phone, department, position, salary) VALUES
('张三', 'zhangsan@company.com', '13800138001', '技术部', '高级工程师', 15000.00),
('李四', 'lisi@company.com', '13800138002', '市场部', '市场经理', 12000.00),
('王五', 'wangwu@company.com', '13800138003', '人事部', '人事主管', 10000.00),
('赵六', 'zhaoliu@company.com', '13800138004', '财务部', '财务专员', 9000.00),
('钱七', 'qianqi@company.com', '13800138005', '技术部', '初级工程师', 8000.00);

INSERT INTO projects (name, description, leader, status, start_date, end_date) VALUES
('内部管理系统开发', '公司内部管理系统二期开发', '张三', 'in_progress', '2026-01-01', '2026-06-30'),
('市场推广活动', '夏季产品推广方案', '李四', 'pending', '2026-03-01', '2026-05-31'),
('人事档案数字化', '员工档案电子化项目', '王五', 'completed', '2025-09-01', '2026-01-15');

INSERT INTO announcements (title, content, author) VALUES
('公司年会通知', '公司定于本月30日举行年度总结大会，请全体员工准时参加。', 'admin'),
('新员工入职培训', '下周将举行新员工入职培训，请各部门负责人安排时间。', 'admin');