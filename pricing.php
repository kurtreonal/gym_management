<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's current membership status
$stmt = $con->prepare("SELECT membership_id FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userResult = $stmt->get_result()->fetch_assoc();
$has_membership = !empty($userResult['membership_id']);

// Fetch all plans
$plans_stmt = $con->prepare("SELECT * FROM membership_plan ORDER BY is_highlighted DESC, membership_price ASC");
$plans_stmt->execute();
$plans = $plans_stmt->get_result();

// Handle membership plan purchase
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan_id']) && !$has_membership) {
    $plan_id = intval($_POST['plan_id']);

    // Get duration
    $stmt = $con->prepare("SELECT duration_days FROM membership_plan WHERE membership_id = ?");
    $stmt->bind_param("i", $plan_id);
    $stmt->execute();
    $plan = $stmt->get_result()->fetch_assoc();

    if ($plan) {
        $validation_date = date("Y-m-d");
        $expiry_date = date("Y-m-d", strtotime("+{$plan['duration_days']} days"));

        // Update membership info
        $stmt = $con->prepare("UPDATE users SET membership_id = ?, validation_date = ?, expiry_date = ? WHERE user_id = ?");
        $stmt->bind_param("issi", $plan_id, $validation_date, $expiry_date, $user_id);
        $stmt->execute();

        // Get user info
        $stmt = $con->prepare("SELECT fcid, first_name, last_name FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        // Generate FCID if not present
        if (empty($user['fcid'])) {
            $firstInitial = strtoupper($user['first_name'][0] ?? 'X');
            $lastInitial = strtoupper($user['last_name'][0] ?? 'X');
            $datePart = date("dm"); // Day + Month
            $randomDigits = mt_rand(1000, 9999);
            $fcid = $firstInitial . $lastInitial . $datePart . $plan_id . $randomDigits;

            $stmt = $con->prepare("UPDATE users SET fcid = ? WHERE user_id = ?");
            $stmt->bind_param("si", $fcid, $user_id);
            $stmt->execute();
        }

        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pricing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="./styles/homepage.css"/>
</head>
<body>
    <!-- HEADER -->
    <?php $is_logged_in = isset($_SESSION['user_id']); ?>
    <header>
        <nav class="navbar">
            <div class="menu-toggle" id="menuToggle">
                <!-- Hamburger Icon -->
                <svg width="24" height="24" fill="none" stroke="currentColor">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
            <div class="logo">The Fighters Club</div>
            <div class="nav-drawer" id="navDrawer">
                <button class="close-drawer" id="closeNavDrawer">
                    <svg width="24" height="24" fill="none" stroke="currentColor">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <ul class="nav-links">
                    <li><a href="homepage.php#home">HOME</a></li>
                    <li><a href="homepage.php#utility">UTILITY ACCESS</a></li>
                    <li><a href="homepage.php#videos">VIDEOS</a></li>
                    <li><a href="homepage.php#method">OUR METHOD</a></li>
                    <li><a href="pricing.php">PRICING</a></li>
                    <li><a href="homepage.php#shop">SHOP</a></li>
                    <li><a href="homepage.php#contact">CONTACT</a></li>
                </ul>
            </div>
            <div class="navbar-icons">
                <a href="<?= $is_logged_in ? 'dashboard.php' : 'sign-in.php'; ?>" class="signup-btn">
                    <svg width="24" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                        <path d="M16.125 8.75c-.184 2.478-2.063 4.5-4.125 4.5s-3.944-2.021-4.125-4.5c-.187-2.578 1.64-4.5 4.125-4.5 2.484 0 4.313 1.969 4.125 4.5Z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.017 20.747C3.783 16.5 7.922 14.25 12 14.25s8.217 2.25 8.984 6.497" stroke-width="1.6"/>
                    </svg>
                </a>
            </div>
        </nav>
    </header>

    <!-- MEMBERSHIP PLANS -->
    <section class="pricing-section pricing">
        <div class="pricing-container">
            <h2>Our Membership Plans</h2>
            <p>Choose the plan that suits your goals!</p>
            <div class="pricing-cards">
                <?php while ($row = $plans->fetch_assoc()): ?>
                    <div class="pricing-card <?= $row['is_highlighted'] ? 'popular' : '' ?>">
                        <h3><?= htmlspecialchars($row['plan_name']) ?></h3>
                        <div class="price">₱<?= number_format($row['membership_price']) ?> / <?= $row['duration_days'] ?> day<?= $row['duration_days'] > 1 ? 's' : '' ?></div>
                        <ul>
                            <?php foreach (explode("\n", $row['plan_details']) as $feature): ?>
                                <li><?= htmlspecialchars(trim($feature)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <form method="POST" onsubmit="<?= $has_membership ? "alert('You already have a membership.'); return false;" : '' ?>">
                            <input type="hidden" name="plan_id" value="<?= $row['membership_id'] ?>">
                            <button type="submit" class="btn<?= $row['is_highlighted'] ? '-popular' : '' ?>">
                                <?= $has_membership ? 'Join Now' : 'Join Now' ?>
                            </button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="section contact" style="background-color: #111;">
        <div class="contact-container">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=...your_map_link_here..." width="100%" height="300" style="border:0;" allowfullscreen loading="lazy"></iframe>
            </div>
            <div class="info-container">
                <h2 style="color: #fff;">WHERE ARE WE?</h2>
                <p style="color: #ccc;">2/F, Wings Building, 110-116 Queens Road, Central</p>
                <p style="color: #ccc;">Phone: +639628378792</p>
                <p style="color: #ccc;">Email: info@thefightersclub.com</p>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank"><img src="https://www.google.com/s2/favicons?domain=facebook.com"></a>
                    <a href="https://youtube.com" target="_blank"><img src="https://www.google.com/s2/favicons?domain=youtube.com"></a>
                    <a href="https://instagram.com" target="_blank"><img src="https://www.google.com/s2/favicons?domain=instagram.com"></a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 The Fighters Club</p>
    </footer>
    <script src="./script/test.js"></script>
</body>
</html>
