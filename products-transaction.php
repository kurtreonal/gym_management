<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
include 'connection.php';

// Fetch products added by the logged-in admin
$admin_id = $_SESSION['admin_id'] ?? null;
$products = [];

if ($admin_id) {
    $stmt = $con->prepare("SELECT product_name, product_details, price, quantity, category, product_image FROM products WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <li><a href="#home">HOME</a></li>
            <li><a href="#utility">UTILITY ACCESS</a></li>
            <li><a href="#videos">VIDEOS</a></li>
            <li><a href="#method">OUR METHOD</a></li>
            <li><a href="pricing.php" onclick="event.stopPropagation();">PRICING</a></li>
            <li><a href="#shop">SHOP</a></li>
            <li><a href="#contact">CONTACT</a></li>
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

    <div class="product-container">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
            <div class="product-page">
                <!-- Main Image (now using more space) -->
                <div class="product-image">
                    <?php if (!empty($product['product_image'])): ?>
                        <img
                            src="data:image/jpeg;base64,<?= base64_encode($product['product_image']) ?>"
                            alt="<?= htmlspecialchars($product['product_name']) ?>"
                        >

                    <?php else: ?>
                        <img src="product-main.jpg" alt="Main Product">
                    <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="product-details">
                    <h1><?= htmlspecialchars($product['product_name']) ?></h1>
                    <div class="category">Category: <?= htmlspecialchars($product['category']) ?></div>
                    <p class="description">
                        <?= htmlspecialchars($product['product_details']) ?>
                    </p>

                    <div class="transaction">
                        <label for="quantity">Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="<?= (int)$product['quantity'] ?>" value="1">
                    </div>

                    <div class="buy-now">
                        <button type="button">Buy Now – ₱<?= number_format($product['price'], 2) ?></button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding: 2rem; text-align: center; font-weight: bold;">
                No products found. Add products to display them here.
            </div>
        <?php endif; ?>
    </div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const hash = window.location.hash;
        if (hash) {
            const target = document.querySelector(hash);
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        }
    });
</script>
<script src="./script/test.js"></script>

</body>
</html>