<?php
session_start();
require_once 'models/db.php';
require_once 'models/UserModel.php';
require_once 'controllers/UserController.php';

// Připojení k databázi
$conn = new mysqli("localhost", "root", "root", "admin_interface");
$userModel = new UserModel($conn);
$userController = new UserController($userModel);

// Inicializace proměnných pro přihlašování
$isLoggedIn = isset($_SESSION['email']); // Changed from 'username' to 'email'
$email = $isLoggedIn ? $_SESSION['email'] : ''; // Changed from 'username' to 'email'
$isAdmin = isset($_SESSION['isAdmin']) ? $_SESSION['isAdmin'] : false;

// Zpracování odhlášení
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Zpracování přihlášení
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; 
    $password = $_POST['password'];

    // Připojení k databázi a ověření emailu a hesla
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Ověření hesla v otevřené podobě (bez hashe)
        if ($password == $user['password']) {
            // Nastavení session
            $_SESSION['email'] = $user['email']; // Uložení emailu do session
            $_SESSION['isAdmin'] = $user['is_admin'] == 1; // Nastavení isAdmin podle hodnoty is_admin v databázi

            // Přidání aktuálního času do sloupce last_login
            $lastLoginTime = date('Y-m-d H:i:s'); // Aktuální čas v požadovaném formátu
            $updateStmt = $conn->prepare("UPDATE users SET last_login = ? WHERE email = ?");
            $updateStmt->bind_param("ss", $lastLoginTime, $email);
            $updateStmt->execute();

            // Přesměrování na hlavní stránku
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid email or password"; 
        }
    } else {
        $error = "Invalid email or password"; 
    }
}


// Zpracování požadavků
$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'view';




?>

<!doctype html>
<html lang="en">
<head>
    <title>Simple Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/views/bootstrap.css">
    <link rel="stylesheet" href="/views/bootstrap-icons.css">
</head>
<body>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Simple Administration</a>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <?php if ($isLoggedIn): ?>
                <a class="nav-link px-3" href="?logout=true">Logout (<?= htmlspecialchars($email) ?>)</a>
            <?php else: ?>
                <a class="nav-link px-3" href="#loginModal" data-bs-toggle="modal">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="?controller=dashboard" class="nav-link <?= ($controller == 'dashboard') ? 'active' : '' ?>">
                            <span class="icon"><i class="bi bi-easel"></i></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?controller=items" class="nav-link <?= ($controller == 'items') ? 'active' : '' ?>">
                            <span class="icon"><i class="bi bi-card-list"></i></span>
                            Items
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?controller=others" class="nav-link <?= ($controller == 'others') ? 'active' : '' ?>">
                            <span class="icon"><i class="bi bi-box"></i></span>
                            Others
                        </a>
                    </li>
                    <?php if ($isAdmin): ?>
                        <li class="nav-item">
                            <a href="?controller=user&action=list" class="nav-link <?= ($controller == 'user') ? 'active' : '' ?>">
                                <span class="icon"><i class="bi bi-person-circle"></i></span>
                                Users
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">
            <?php if ($isLoggedIn): ?>
                <?php
                // Načítání odpovídajícího souboru podle URL parametrů
                $page = $_GET['controller'] ?? 'dashboard';
                $allowedPages = ['dashboard', 'items', 'others', 'user'];
                if (in_array($page, $allowedPages)) {
                    include "views/{$page}.php";
                } else {
                    echo '<h1>Page not found</h1>';
                }
                ?>
            <?php else: ?>
                <h1 class="pb-3 border-bottom">Please log in</h1>
                <p>You must be logged in to view the dashboard.</p>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <a href="#loginModal" data-bs-toggle="modal" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </main>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/views/bootstrap.js"></script>
</body>
</html>
