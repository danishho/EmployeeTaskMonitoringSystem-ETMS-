<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar with Expand Icons</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 260px;
            color: white;
            background-color: #0f172a;
            border-right: 1px solid #334155;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-header,
        .sidebar-footer {
            padding: 20px;
            border-bottom: 1px solid #334155;
        }
        .sidebar-footer {
            border-top: 1px solid #334155;
            border-bottom: none;
        }
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .profile img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
        }
        .profile-details {
            display: flex;
            flex-direction: column;
        }
        .menu {
            padding: 20px;
        }
        .menu-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 15px;
        }
        .menu-item,
        .expandable {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .expandable:hover,
        .logout-button:hover {
            background-color: #1e293b;
            color: white;
        }
        .expandable i:first-child {
            margin-right: 10px;
        }
        .submenu {
            display: none;
            margin-left: 15px;
            margin-top: 5px;
            background-color: #1e293b;
            border-radius: 8px;
            padding: 8px;
        }
        .submenu a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            font-size: 13px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 5px;
        }
        .submenu a:hover {
            color: white;
            background-color: #334155;
        }
        .logout-button {
            width: 100%;
            background-color: darkred;
            border: none;
            color: #cbd5e1;
            text-align: left;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout-button:hover{
            background-color: crimson;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
</head>
<body>
<aside class="sidebar">
    <div>
        <div class="sidebar-header">
            <div class="profile">
                <img src="/lovable-uploads/edc7f283-273e-4edb-a348-5f976b3ac923.png" alt="Profile" />
                <div class="profile-details">
                    <span>Admin User</span>
                    <small style="color: #94a3b8;">System Administrator</small>
                </div>
            </div>
        </div>

        <div class="menu">
            <div class="menu-title">ETMS - Employee Task Monitoring</div>
            <a href="/" class="menu-item"><i class="bi bi-house-door"></i> Dashboard</a>

            <div class="expandable" onclick="toggleSubMenu('employee')">
                <span><i class="bi bi-people"></i> Employee Management</span>
                <i id="icon-employee" class="bi bi-chevron-down"></i>
            </div>
            <div id="submenu-employee" class="submenu">
                <a href="/employees"><i class="bi bi-list-ul"></i> Employee List</a>
                <a href="/user/add"><i class="bi bi-plus-circle"></i> Add User</a>
                <a href="/departments"><i class="bi bi-diagram-3"></i> Departments</a>
            </div>

            <div class="expandable" onclick="toggleSubMenu('task')">
                <span><i class="bi bi-clipboard-check"></i> Task Management</span>
                <i id="icon-task" class="bi bi-chevron-down"></i>
            </div>
            <div id="submenu-task" class="submenu">
                <a href="/tasks"><i class="bi bi-clipboard-data"></i> All Tasks</a>
                <a href="/tasks/create"><i class="bi bi-plus-square"></i> Create Task</a>
                <a href="/tasks/categories"><i class="bi bi-tags"></i> Task Categories</a>
            </div>

            <div class="expandable" onclick="toggleSubMenu('reports')">
                <span><i class="bi bi-bar-chart"></i> Reports & Analytics</span>
                <i id="icon-reports" class="bi bi-chevron-down"></i>
            </div>
            <div id="submenu-reports" class="submenu">
                <a href="/reports/performance"><i class="bi bi-speedometer2"></i> Performance Reports</a>
                <a href="/reports/time"><i class="bi bi-clock"></i> Time Tracking</a>
                <a href="/reports/analytics"><i class="bi bi-graph-up"></i> Productivity Analytics</a>
            </div>

            <div class="expandable" onclick="toggleSubMenu('settings')">
                <span><i class="bi bi-gear"></i> Settings</span>
                <i id="icon-settings" class="bi bi-chevron-down"></i>
            </div>
            <div id="submenu-settings" class="submenu">
                <a href="/settings/system"><i class="bi bi-hdd-stack"></i> System Settings</a>
                <a href="/settings/preferences"><i class="bi bi-sliders"></i> User Preferences</a>
                <a href="/settings/notifications"><i class="bi bi-bell"></i> Notifications</a>
            </div>
        </div>
    </div>

    <div class="sidebar-footer">
        <button class="logout-button">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>
</aside>

<main class="main-content">
    <!-- Example content for dashboard -->
    <h1>Dashboard</h1>
    <p>Welcome to the Employee Task Monitoring System. Select a menu to begin.</p>
</main>

<script>
    function toggleSubMenu(id) {
        var submenu = document.getElementById('submenu-' + id);
        var icon = document.getElementById('icon-' + id);
        var isVisible = submenu.style.display === 'block';

        submenu.style.display = isVisible ? 'none' : 'block';
        icon.className = isVisible ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
    }
</script>
</body>
</html>
