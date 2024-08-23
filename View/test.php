<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
        }

        #sidebar.active {
            margin-left: -250px;
        }

        #sidebarCollapse {
            background-color: #007bff; /* Ganti dengan warna yang diinginkan */
            border: none;
            color: #fff; /* Warna ikon */
        }

        #sidebarCollapse:hover {
            background-color: #0056b3; /* Ganti dengan warna hover */
        }

        #sidebar ul.components {
            padding: 20px 0;
            list-style: none;
        }

        #sidebar ul li a {
            padding: 10px 15px;
            font-size: 1.1em;
            display: block;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
            border-radius: 8px;
            /* Rounded corners */
            margin: 5px 10px;
        }

        #sidebar ul li a:hover {
            color: #343a40;
            background: #fff;
        }

        #sidebar ul li.active>a {
            background: #007bff;
            color: #fff;
        }

        #sidebar ul li a i {
            margin-right: 10px;
        }

        #sidebar ul li a.collapsed+ul {
            display: none;
        }

        #sidebar ul ul {
            list-style: none;
            padding-left: 20px;
        }

        #sidebar ul ul li a {
            padding: 10px;
            font-size: 0.9em;
        }

        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        #content.active {
            width: 100%;
            margin-left: 0;
        }

        .navbar {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .navbar-nav .nav-item {
            position: relative;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-menu a {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header p-3">
                <h3>Admin Dashboard</h3>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fas fa-user"></i> Users</a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li>
                            <a href="#" class="nav-link">View Users</a>
                        </li>
                        <li>
                            <a href="#" class="nav-link">Add User</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cogs"></i> Settings</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-user-circle"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fas fa-align-left"></i>
                    </button>

                    <form class="d-flex ms-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="notificationsDropdown">
                                <li><a class="dropdown-item" href="#">Notification 1</a></li>
                                <li><a class="dropdown-item" href="#">Notification 2</a></li>
                                <li><a class="dropdown-item" href="#">Notification 3</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="messagesDropdown">
                                <li><a class="dropdown-item" href="#">Message 1</a></li>
                                <li><a class="dropdown-item" href="#">Message 2</a></li>
                                <li><a class="dropdown-item" href="#">Message 3</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <h2>Main Content Area</h2>
            <p>This is the main content area where you can place your dashboard content.</p>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <script type="text/javascript">
        document.getElementById('sidebarCollapse').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
    </script>

</body>

</html>
