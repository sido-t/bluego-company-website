<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Set default page
$page = isset($_GET['page']) ? sanitizeInput($_GET['page']) : 'home';

// Redirect logic for authenticated users
if (isset($_SESSION['user_id'])) {
    if ($page === 'login' || $page === 'register') {
        header("Location: user/dashboard.php");
        exit();
    }
} elseif (isset($_SESSION['admin_id'])) {
    if ($page === 'login' || $page === 'register') {
        header("Location: admin/dashboard.php");
        exit();
    }
} else {
    // Redirect guests away from protected pages
    $protected_pages = ['dashboard', 'profile', 'surveys', 'videos', 'ads', 'reviews', 'marketplace', 'referrals', 'transactions'];
    if (in_array($page, $protected_pages)) {
        header("Location: auth/login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueGo Company - <?php echo ucfirst($page); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php if (isset($_SESSION['admin_id'])): ?>
        <link rel="stylesheet" href="assets/css/admin.css">
    <?php endif; ?>
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <div class="logo">
                <a href="index.php">
                    <img src="assets/images/logo/bluego-logo.png" alt="BlueGo Logo">
                    <span>BlueGo</span>
                </a>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="user/dashboard.php" <?php echo ($page === 'dashboard') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-home"></i> Dashboard
                        </a></li>
                        <li><a href="user/profile.php" <?php echo ($page === 'profile') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-user"></i> Profile
                        </a></li>
                        <li><a href="auth/logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a></li>
                    <?php elseif (isset($_SESSION['admin_id'])): ?>
                        <li><a href="admin/dashboard.php" <?php echo ($page === 'admin') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-tachometer-alt"></i> Admin
                        </a></li>
                        <li><a href="auth/logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a></li>
                    <?php else: ?>
                        <li><a href="index.php?page=home" <?php echo ($page === 'home') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-home"></i> Home
                        </a></li>
                        <li><a href="auth/login.php" <?php echo ($page === 'login') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a></li>
                        <li><a href="auth/register.php" <?php echo ($page === 'register') ? 'class="active"' : ''; ?>>
                            <i class="fas fa-user-plus"></i> Register
                        </a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <div class="mobile-menu-toggle" id="mobile-menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <ul>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="user/dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="user/profile.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php elseif (isset($_SESSION['admin_id'])): ?>
                <li><a href="admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Admin</a></li>
                <li><a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="index.php?page=home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="auth/login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                <li><a href="auth/register.php"><i class="fas fa-user-plus"></i> Register</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php
            // Load the appropriate page content
            switch ($page) {
                case 'home':
                    if (isset($_SESSION['user_id'])) {
                        header("Location: user/dashboard.php");
                        exit();
                    } elseif (isset($_SESSION['admin_id'])) {
                        header("Location: admin/dashboard.php");
                        exit();
                    } else {
                        include 'templates/home.php';
                    }
                    break;
                    
                case 'dashboard':
                    include 'user/dashboard.php';
                    break;
                    
                case 'profile':
                    include 'user/profile.php';
                    break;
                    
                case 'login':
                    include 'auth/login.php';
                    break;
                    
                case 'register':
                    include 'auth/register.php';
                    break;
                    
                case 'surveys':
                    include 'user/surveys.php';
                    break;
                    
                case 'videos':
                    include 'user/videos.php';
                    break;
                    
                case 'ads':
                    include 'user/ads.php';
                    break;
                    
                case 'reviews':
                    include 'user/reviews.php';
                    break;
                    
                case 'marketplace':
                    include 'user/marketplace.php';
                    break;
                    
                case 'referrals':
                    include 'user/referrals.php';
                    break;
                    
                case 'transactions':
                    include 'user/transactions.php';
                    break;
                    
                case 'admin':
                    include 'admin/dashboard.php';
                    break;
                    
                default:
                    include 'templates/404.php';
            }
            ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>About BlueGo</h3>
                    <p>Earn money by completing simple tasks, watching videos, and referring friends.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="auth/register.php">Register</a></li>
                        <li><a href="auth/login.php">Login</a></li>
                        <li><a href="user/dashboard.php">Dashboard</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-envelope"></i> support@bluego.com</p>
                    <p><i class="fas fa-phone"></i> +254 706 033527</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> BlueGo Company. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <?php if (isset($_SESSION['admin_id'])): ?>
        <script src="assets/js/admin.js"></script>
    <?php endif; ?>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('active');
        });
        
        // Auto-close mobile menu when clicking a link
        const mobileLinks = document.querySelectorAll('#mobile-menu a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.remove('active');
            });
        });
    </script>
</body>
</html>