document.addEventListener("DOMContentLoaded", function () {
  const navbar = document.querySelector("[navbar-main]");
  if (!navbar) return;

  const whiteElements = navbar.querySelectorAll(".text-white");
  const whiteBgElements = navbar.querySelectorAll("[sidenav-trigger] i.bg-white");
  const whiteBeforeElements = navbar.querySelectorAll(".before\\:text-white");

  function stickyNav() {
    const scrolled = window.scrollY >= 5;

    // Navbar container
    navbar.classList.toggle("sticky", scrolled);
    navbar.classList.toggle("top-[1%]", scrolled);
    navbar.classList.toggle("backdrop-saturate-200", scrolled);
    navbar.classList.toggle("dark:bg-slate-850/80", scrolled);
    navbar.classList.toggle("dark:shadow-dark-blur", scrolled);
    navbar.classList.toggle("backdrop-blur-2xl", scrolled);
    navbar.classList.toggle("bg-[hsla(0,0%,100%,0.8)]", scrolled);
    navbar.classList.toggle("shadow-blur", scrolled);
    navbar.classList.toggle("z-110", scrolled);

    // Text color switch
    whiteElements.forEach(el => {
      el.classList.toggle("text-white", !scrolled);
      el.classList.toggle("dark:text-white", scrolled);
    });

    // Background color switch (icons/buttons)
    whiteBgElements.forEach(el => {
      el.classList.toggle("bg-white", !scrolled);
      el.classList.toggle("dark:bg-white", scrolled);
      el.classList.toggle("bg-slate-500", scrolled);
    });

    // ::before pseudo-element text
    whiteBeforeElements.forEach(el => {
      el.classList.toggle("before:text-white", !scrolled);
      el.classList.toggle("dark:before:text-white", scrolled);
    });
  }

  // Run on load + on scroll
  if (navbar.getAttribute("navbar-scroll") === "true") {
    window.addEventListener("scroll", stickyNav);
    stickyNav();
  }
});