// // Icon initialization
// lucide.createIcons();

// // Mobile Menu Toggle
// const menuToggle = document.getElementById("menu-toggle");
// const mobileMenu = document.getElementById("mobile-menu");

// menuToggle.addEventListener("click", () => {
//   mobileMenu.classList.toggle("hidden");
//   const icon = menuToggle.querySelector("i");
//   const isOpen = !mobileMenu.classList.contains("hidden");
//   icon.setAttribute("data-lucide", isOpen ? "x" : "menu");
//   lucide.createIcons();
// });


// Mobile menu toggle
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  let open = false;

  toggleBtn.addEventListener("click", () => {
    open = !open;
    mobileMenu.classList.toggle("hidden", !open);

    toggleBtn.innerHTML = open
      ? '<i data-lucide="x" class="h-6 w-6"></i>'
      : '<i data-lucide="menu" class="h-6 w-6"></i>';

    lucide.createIcons();
  });
});
