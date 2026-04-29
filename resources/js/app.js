import './bootstrap';
import "./sidebar";
import '../css/app.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// import carousel from './js/carousel';
// Alpine.data('carousel', carousel);
// console.log("Vite JS working!");
 



// Lazy Animation Trigger (NO PERFORMANCE HIT)
document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".animate-on-view");

  if (!("IntersectionObserver" in window)) {
    items.forEach(el => el.classList.remove("opacity-0"));
    return;
  }

  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove("opacity-0");
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );

  items.forEach(el => observer.observe(el));
});
