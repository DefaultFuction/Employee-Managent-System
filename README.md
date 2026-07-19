# Employee Management System

<div align="center">
  <h3>A Lightweight PHP/MySQL EMS Solution</h3>
  <p>Simple • Powerful • Open Source</p>
  
  <img src="https://img.shields.io/badge/PHP-7.2+-777BB4?style=flat&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat&logo=mysql&logoColor=white" alt="MySQL Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/Version-1.0.0-blue.svg" alt="Version">
</div>


---

## 📋 Overview

CMS is a clean, lightweight Content Management System built with native PHP and MySQL. Designed for small websites and personal bloggers, it provides essential tools to manage website content efficiently.

---

## ✨ Features

| Module | Capabilities |
|--------|--------------|
| 🔐 **Authentication** | Secure admin login system with session management |
| 📊 **Dashboard** | Website statistics and quick overview |
| 👥 **Employee Management** | Manage staff profiles, departments, and positions |
| 📋 **Project Management** | Track projects, assign leaders, update status |
| 📢 **Announcement Board** | Publish and manage site announcements |
| 🖼️ **File Management** | Upload, download, and organize media files |
| ⚙️ **System Tools** | Network diagnostics, log viewer, and configuration |
| 👤 **User Center** | Profile editing and password management |

---

## 🚀 Quick Start

### Prerequisites

```bash
✓ PHP >= 7.2
✓ MySQL >= 5.7
✓ Web Server (Apache/Nginx)
✓ PDO PHP Extension
✓ GD Library (for image processing)
```

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/yourusername/cms.git
cd cms
```

**2. Import the database**

Open phpMyAdmin or MySQL CLI, create a new database and import the SQL file:

```bash
mysql -u root -p your_database_name < sql/init.sql
```

**3. Configure database connection**

Edit `config.php` and update your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'your_database_name');
```

**4. Set proper permissions**

```bash
chmod -R 755 uploads/
chmod -R 755 logs/
```

**5. Access the system**

Open your browser and navigate to:

```
http://your-server.com/index.php
```

**Default admin account:**

| Username | Password |
|----------|----------|
| admin | admin123 |
| test | 123456 |

---

## 🗂️ Project Structure

```
cms/
├── index.php              # Login page
├── register.php           # User registration
├── logout.php             # Logout handler
├── dashboard.php          # Main dashboard
├── employees.php          # Employee management
├── employee_edit.php      # Edit employee details
├── projects.php           # Project management
├── announcements.php      # Announcement board
├── file_manager.php       # File upload & download
├── system_tools.php       # System utilities
├── profile.php            # User profile settings
├── config.php             # Database & app configuration
├── db.php                 # Database connection (PDO)
├── css/
│   └── style.css          # Application styles
├── sql/
│   └── init.sql           # Database initialization script
├── uploads/               # Uploaded files directory
└── logs/                  # Application logs
```

---

## 🔧 Configuration

### Database Settings (`config.php`)

```php
define('DB_HOST', 'localhost');    // Database host
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password
define('DB_NAME', 'management_system'); // Database name
```

### File Upload Settings

```php
define('UPLOAD_DIR', 'uploads/');       // Upload directory
define('MAX_FILE_SIZE', 5242880);       // Max file size (5MB)
```

---

## 📸 Screenshots

| Page | Description |
|------|-------------|
| Login | Blue gradient login interface with form validation |
| Dashboard | Statistics overview with employee/project/announcement counts |
| Employees | CRUD table with search, pagination, and inline add form |
| Projects | Filterable project list with status badges |
| Announcements | Card-style announcement display with publish form |
| File Manager | File list with upload, download, and delete operations |
| System Tools | Ping diagnostic, log viewer, configuration editor |

---

## 🛠️ Built With

- **PHP** - Backend scripting language
- **MySQL** - Database management
- **PDO** - Database abstraction layer
- **HTML5 / CSS3** - Frontend structure and styling
- **JavaScript** - Frontend interactivity

---

## 🤝 Contributing

Contributions are welcome! Feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---


## 📧 Contact

My email: 2303473412@qq.com


---

<div align="center">
  <sub>Built with ❤️ for learning and sharing</sub>
</div>
