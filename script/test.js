document.addEventListener('DOMContentLoaded', () => {
  // Smooth scrolling
  document.querySelectorAll('.nav-links a[href^="#"]').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href').slice(1);
      const target = document.getElementById(targetId);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });

  // Image slider
  let slideIndex = 0;
  const slides = document.querySelectorAll(".slide");
  const next = document.querySelector(".next");
  const prev = document.querySelector(".prev");

  const showSlide = (index) => {
    slides.forEach(slide => slide.classList.remove("active"));
    slides[index].classList.add("active");
  };

  const nextSlide = () => {
    slideIndex = (slideIndex + 1) % slides.length;
    showSlide(slideIndex);
  };

  const prevSlide = () => {
    slideIndex = (slideIndex - 1 + slides.length) % slides.length;
    showSlide(slideIndex);
  };

  let autoSlide;
  if (slides.length) {
    showSlide(slideIndex);
    autoSlide = setInterval(nextSlide, 5000);
  }

  const resetAutoSlide = () => {
    clearInterval(autoSlide);
    autoSlide = setInterval(nextSlide, 5000);
  };

  if (next && prev) {
    next.addEventListener("click", () => {
      nextSlide();
      resetAutoSlide();
    });

    prev.addEventListener("click", () => {
      prevSlide();
      resetAutoSlide();
    });
  }

  // Modal popup for product cards
  const modal = document.getElementById("product-modal");
  const closeBtn = document.querySelector(".close-button");
  const productCards = document.querySelectorAll(".product-card");

  if (modal && closeBtn && productCards.length) {
    productCards.forEach(card => {
      card.addEventListener("click", () => {
        modal.querySelector("#modal-product-name").textContent = card.dataset.name;
        modal.querySelector("#modal-product-description").textContent = card.dataset.description;
        modal.querySelector("#modal-product-price").textContent = card.dataset.price;
        modal.querySelector("#modal-product-quantity").textContent = card.dataset.quantity;
        modal.style.display = "block";
      });
    });

    closeBtn.addEventListener("click", () => {
      modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
      if (e.target === modal) modal.style.display = "none";
    });

    window.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && modal.style.display === "block") {
        modal.style.display = "none";
      }
    });
  }

  // Video redirection functions
  window.goToVideo = (videoFile) => {
    window.location.href = `videopage.php?src=${encodeURIComponent(videoFile)}`;
  };

  window.goBack = () => {
    window.history.back();
  };
});

// Get elements
const menuToggle = document.getElementById('menuToggle');
const navDrawer = document.getElementById('navDrawer');
const closeNavDrawer = document.getElementById('closeNavDrawer');

// Toggle nav drawer open/close
menuToggle.addEventListener('click', () => {
  navDrawer.classList.toggle('open');
});

// Also close nav drawer when clicking the close button
closeNavDrawer.addEventListener('click', () => {
  navDrawer.classList.remove('open');
});

// Optional: close nav drawer if user clicks outside the drawer (on the navbar)
document.addEventListener('click', (e) => {
  if (!navDrawer.contains(e.target) && !menuToggle.contains(e.target)) {
    navDrawer.classList.remove('open');
  }
});


// Optional: close menu when link is clicked (mobile only)
document.querySelectorAll('.nav-links a').forEach(link => {
  link.addEventListener('click', () => {
    if (window.innerWidth <= 768) {
      const nav = document.getElementById("nav-links");
      nav.style.left = "-100%";
      nav.classList.remove('active');
    }
  });
});

  document.addEventListener('DOMContentLoaded', function () {
    const cartToggle = document.getElementById('cartToggle');
    const cartDrawer = document.getElementById('cartDrawer');
    const closeCart = document.getElementById('closeCart');

    cartToggle.addEventListener('click', function (e) {
      e.preventDefault();
      cartDrawer.classList.toggle('open');
    });

    closeCart.addEventListener('click', function () {
      cartDrawer.classList.remove('open');
    });

    document.addEventListener('click', function (e) {
      if (!cartDrawer.contains(e.target) && !cartToggle.contains(e.target)) {
        cartDrawer.classList.remove('open');
      }
    });
  });