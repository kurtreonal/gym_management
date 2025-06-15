<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Gym Management System</title>
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

    <section id="home" class="hero">
        <div class="slider">
            <img src="./assets/L-Men.jpeg" class="slide active" alt="Slide 1">
            <img src="./assets/gym interior.png" class="slide" alt="Slide 2">
            <img src="./assets/gym interior.webp" class="slide" alt="Slide 3">
            <img src="./assets/gym dressingroom.png" class="slide" alt="Slide 4">
            <img src="./assets/gym shop.png" class="slide" alt="Slide 5">

            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>

            <div class="hero-content">
                <h1>PHILIPPINES</h1>
                <h1>NO.1 PERSONAL</h1>
                <h1>FITNESS GYM</h1>
            </div>
        </div>
    </section>

    <section id="utility" class="section-util utility-section">
        <div class="utility-overlay">
            <div class="utility-text">
                <h2 class="uh2">UTILITY ACCESS</h2>
                <h3 class="uh3">Access to ALL utilities</h3>
                <p class="up">We at the Fighters Club believe that fitness should be accessible, effective and focused on achieving results. Therefore, each membership includes unlimited access to all of our latest gym equipments.</p>

                <h3 class="uh3">What sets us apart?</h3>
                <p class="up">We at the Fighters Club believe that fitness should be accessible, effective and focused on achieving results. Therefore, each membership includes unlimited access to all of our latest gym equipments.</p>
            </div>
        </div>
    </section>

    <section id="videos" class="section videos">
    <h2>VIDEOS</h2>
    <p class="vp">Watch our training sessions and client testimonials.</p>

    <div class="video-grid">
        <div class="video-thumbnail" onclick="goToVideo('samplevidmitt.mp4')">
            <img src="./thumbnails/mitt.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>
        <div class="video-thumbnail" onclick="goToVideo('embedvid1.mp4')">
            <img src="./thumbnails/embed1.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>
        <div class="video-thumbnail" onclick="goToVideo('samplevidember.mp4')">
            <img src="./thumbnails/ember.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>
        <div class="video-thumbnail" onclick="goToVideo('embedvid2.mp4')">
            <img src="./thumbnails/embed2.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('sampleviddaniel.mp4')">
            <img src="./thumbnails/daniel(fake).png" alt="Video i forgot her name">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('drunkobasan.mp4')">
            <img src="./thumbnails/drunkobasan.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('embedvid2.mp4')">
            <img src="./thumbnails/ztwotnail.jpg" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('embedvid2.mp4')">
            <img src="./thumbnails/ztwotnail.jpg" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('embedvid2.mp4')">
            <img src="./thumbnails/ztwotnail.jpg" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>

        <div class="video-thumbnail" onclick="goToVideo('dog.mp4')">
            <img src="./thumbnails/dog.png" alt="Video 1">
            <div class="play-icon">
                <svg viewBox="0 0 60 60" fill="white" width="60" height="60">
                    <path d="M41.5,30l-17,10V20L41.5,30z"></path>
                </svg>
            </div>
        </div>
    </div>
    </section>

    <section id="method" class="section image">
        <h1 class="font-edit">#OURMETHOD</h1>
        <div class="overlay">
            <div class="image-text">
                <p class="paragraph-style">Every training session at our gym is designed with a specific goal—no wasted movements, no overtraining, and no room for lost motivation.
                <span class="highlight">Regardless of your level of experience or inexperience, our skilled coaches are dedicated to helping you advance through discipline and focus.</span>
                To help you train like an athlete—strong, confident, and goal-driven—each session is designed with customized routines, intelligent progression, and practical instruction.
                <br><br>
                All of our trainers complete more than 100 hours of in-house training centered on strength conditioning, perfect form, program design, and client-specific methods for
                coaching to guarantee quality in every workout. Our head coach created this special training program, which raises the bar for the industry and provides all members
                with access to the same top-notch training.</p>
            </div>
        </div>
        <div class="image-grid">
            <div class="grid-item"><img src="./assets/L-Men.jpeg"></div>
            <div class="grid-item"><img src="./assets/L-Men.jpeg"></div>
            <div class="grid-item"><img src="./assets/L-Men.jpeg"></div>
            <div class="grid-item"><img src="./assets/L-Men.jpeg"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
        </div>
    </section>

    <section id="shop" class="section shop">
    <div class="shop-header">
        <h2>Shop the Look</h2>
        <p>Explore our curated selection of fitness apparel and accessories.</p>
    </div>
    </section>

    <!-- Modal Structure -->
    <div id="product-modal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h3 id="modal-product-name"></h3>
        <p id="modal-product-description"></p>
        <p><strong>Price:</strong>
            <span id="modal-product-price">2500</span>
        </p>
        <p><strong>Quantity:</strong>
            <span id="modal-product-quantity">15</span>
        </p>
    </div>
    </div>

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
