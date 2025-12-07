<?php $username = $_SESSION['username'] ?? ''; ?>

<div class="navbarContainerWrapper">
    <navbar class="desktop-menu">
        <!-- Hamburger -->
        <div class="hamburger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Logo -->
        <div class="logo">
            <a href="index.php?page=home">
                <img src="assets/logo2square.webp" alt="Logo">
            </a>
        </div>

        <!-- Navigation Links (desktop) -->
        <div class="links">
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=shop">Browse</a>
            <a href="index.php?page=categories">Categories</a>
            <a href="index.php?page=about">About</a>
        </div>
        <div>
            <a href="login.php" title="Login" class="dsk-login-btn">
                Login<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Door -->
                    <path d="M15 3h4v18h-4" />
                    <!-- Arrow entering -->
                    <path d="M10 17l5-5-5-5" />
                    <path d="M15 12H3" />
                </svg>
            </a>
        </div>
    </navbar>

    <!-- Slide-out mobile menu -->
    <div class="mobile-menu">
        <div class="links">
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=shop">Browse</a>
            <a href="index.php?page=categories">Categories</a>
            <a href="index.php?page=about">About</a>
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        const navbar = document.querySelector(".navbarContainerWrapper");
        navbar.classList.toggle("nav-open");

        const mobileMenu = document.querySelector(".mobile-menu");

        if (navbar.classList.contains("nav-open")) {
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
        } else {
            mobileMenu.style.maxHeight = "0";
        }
    }
</script>