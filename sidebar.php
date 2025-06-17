<!-- Sidebar Toggle Button -->
<button id="mobileToggle" class="mobile-toggle" aria-label="Toggle Menu">
    <!-- Hamburger icon -->
    <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" width="24" height="24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <!-- Close icon (hidden by default) -->
    <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" width="24" height="24" style="display: none;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>


<aside class="_aside-wrapper_vfr6c_96" id="sidebar">
    <div class="_aside-container_vfr6c_107">
        <a href="homepage.php">
            <h2 class="_header_t5b5j_79">Central Account</h2>
        </a>
        <nav class="_tabs_1dhjg_79">
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <a class="_tab_1n4dr_79" href="dashboard.php"><h4>Dashboard</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">About me</div>
                    <a class="_tab_1n4dr_79 _active_1n4dr_101" href="account_settings.php"><h4>Account Settings</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">Manage Profiles</div>
                    <a class="_tab_1n4dr_79" href="profile.php"><h4>Athlete Profile</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">Billing</div>
                    <a class="_tab_1n4dr_79" href="orders.php"><h4>Order History</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">Resources</div>
                    <a class="_tab_1n4dr_79" href="https://www.crossfit.com/faq" target="_blank"><h4>Help</h4></a>
                    <a class="_tab_1n4dr_79" href="https://www.crossfit.com/contact-us" target="_blank"><h4>Contact Us</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">Logout</div>
                    <a class="_tab_1n4dr_79" href="logout.php"><h4>Sign Out?</h4></a>
                </div>
            </div>
            <div class="_tab-group_t5b5j_88">
                <div class="_tab-group-content">
                    <div class="_desktop-label_t5b5j_103">@TheFightersClub | group1-2025</div>
                </div>
            </div>
        </nav>
    </div>
</aside>


<script>
    const toggleBtn = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const closeIcon = document.getElementById('closeIcon');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        const isOpen = sidebar.classList.contains('show');
        hamburgerIcon.style.display = isOpen ? 'none' : 'block';
        closeIcon.style.display = isOpen ? 'block' : 'none';
    });
</script>


