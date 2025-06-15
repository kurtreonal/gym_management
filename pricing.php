<?php
    session_start();
    $is_logged_in = isset($_SESSION['user_id']);
?>
<?php
    include 'connection.php';
    $plans = $con->query("SELECT * FROM Membership_plan");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/homepage.css"/>
</head>
<body>
    <header>
        <nav class="navbar">
        <div class="menu-toggle" id="menuToggle" aria-label="Toggle menu" role="button" tabindex="0">
            <!-- Hamburger SVG -->
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </div>
        <div class="logo">The Fighters Club</div>

        <!-- Nav Drawer -->
        <div class="nav-drawer" id="navDrawer">
        <button class="close-drawer" id="closeNavDrawer" aria-label="Close menu">
            <!-- X icon SVG -->
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <ul class="nav-links" id="navLinks">
            <li><a href="homepage.php#home">HOME</a></li>
            <li><a href="homepage.php#utility">UTILITY ACCESS</a></li>
            <li><a href="homepage.php#videos">VIDEOS</a></li>
            <li><a href="homepage.php#method">OUR METHOD</a></li>
            <li><a href="pricing.php" onclick="event.stopPropagation();">PRICING</a></li>
            <li><a href="homepage.php#shop">SHOP</a></li>
            <li><a href="homepage.php#contact">CONTACT</a></li>
        </ul>
        </div>
        <div class="navbar-icons">
            <a href="<?php echo $is_logged_in ? 'dashboard.php' : 'sign-in.php'; ?>" class="signup-btn">
                <svg aria-hidden="true" fill="none" focusable="false" width="24" viewBox="0 0 24 24">
                    <path d="M16.125 8.75c-.184 2.478-2.063 4.5-4.125 4.5s-3.944-2.021-4.125-4.5c-.187-2.578 1.64-4.5 4.125-4.5 2.484 0 4.313 1.969 4.125 4.5Z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M3.017 20.747C3.783 16.5 7.922 14.25 12 14.25s8.217 2.25 8.984 6.497" stroke="currentColor" stroke-width="1.6" stroke-miterlimit="10"></path>
                </svg>
            </a>
            <div class="cart-container">
            <a href="#" class="cart-btn" aria-controls="cart-drawer" id="cartToggle">
                <span class="sr-only">Open cart</span>
                <svg aria-hidden="true" fill="none" focusable="false" width="24" class="icon icon-cart" viewBox="0 0 24 24">
                <path d="M4.75 8.25A.75.75 0 0 0 4 9L3 19.125c0 1.418 1.207 2.625 2.625 2.625h12.75c1.418 0 2.625-1.149 2.625-2.566L20 9a.75.75 0 0 0-.75-.75H4.75Zm2.75 0v-1.5a4.5 4.5 0 0 1 4.5-4.5v0a4.5 4.5 0 0 1 4.5 4.5v1.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>

            <div class="cart-drawer" id="cartDrawer">
                <div class="cart-drawer-header">
                <span class="cart-title">CART</span>
                <svg id="closeCart" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M6 6L18 18M6 18L18 6" stroke="#000" stroke-width="2" stroke-linecap="round"/>
                </svg>
                </div>
                <hr class="cart-divider">
                <div class="cart-drawer-content">
                <h2>Your cart is empty</h2>
                </div>
            </div>
            </div>
        </div>
        </nav>
    </header>

    <section class="pricing-section pricing">
        <div class="pricing-container">
            <h2>Our Membership Plans</h2>
            <p>Choose the plan that suits your goals!</p>

            <div class="pricing-cards">
            <?php while ($row = $plans->fetch_assoc()): ?>
            <div class="pricing-card <?= $row['is_highlighted'] ? 'popular' : '' ?>">
                <h3><?= htmlspecialchars($row['plan_name']) ?></h3>
                <div class="price">₱<?= number_format($row['membership_price']) ?>/Month</div>
                <ul>
                <?php foreach (explode("\n", $row['plan_details']) as $feature): ?>
                    <li><?= htmlspecialchars(trim($feature)) ?></li>
                <?php endforeach; ?>
                </ul>
                <a href="purchase_plan.php?plan_id=<?= $row['membership_id'] ?>"
                    class="btn<?= $row['is_highlighted'] ? '-popular' : '' ?>">
                    Join Now
                </a>

            </div>
            <?php endwhile; ?>
            </div>

        </div>
    </section>


    <section id="contact" class="section contact" style="background-color: #111;">
        <div class="contact-container">
            <!-- Left: Google Map -->
            <div class="map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.851092475408!2d114.15210247403121!3d22.283629843501878!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34040182b75f362b%3A0x67765ef184dbd5e7!2sTHE%20FIGHTERS%20CLUB%20HONG%20KONG!5e0!3m2!1sen!2sph!4v1748626392635!5m2!1sen!2sph"
                    width="100%"
                    height="300"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Right: Info and Links -->
            <div class="info-container">
                <h2 style="color: #fff;">WHERE ARE WE?</h2>
                <p style="color: #ccc;">2/F, Wings Building, 110-116 Queens Road, Central</p>
                <p style="color: #ccc;">Phone: +639628378792</p>
                <p style="color: #ccc;">Email: info@thefightersclub.com</p>
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank">
                        <img src="https://www.google.com/s2/favicons?sz=32&domain=facebook.com" alt="Facebook">
                    </a>
                    <a href="https://youtube.com" target="_blank">
                        <img src="https://www.google.com/s2/favicons?sz=32&domain=youtube.com" alt="YouTube">
                    </a>
                    <a href="https://instagram.com" target="_blank">
                        <img src="https://www.google.com/s2/favicons?sz=32&domain=instagram.com" alt="Instagram">
                    </a>
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