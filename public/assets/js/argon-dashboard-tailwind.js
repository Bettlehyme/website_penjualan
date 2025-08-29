/*!
=========================================================
* Argon Dashboard Tailwind - v1.0.1 (Laravel Compatible)
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
*/

// Always point to public/assets
const assets = {
  css: {
    perfectScrollbar: "/assets/css/perfect-scrollbar.css",
    tooltips: "/assets/css/tooltips.css",
  },
  js: {
    perfectScrollbar: "/assets/js/plugins/perfect-scrollbar.min.js",
    carousel: "/assets/js/carousel.js",
    navbarCollapse: "/assets/js/navbar-collapse.js",
    tooltips: "/assets/js/tooltips.js",
    navPills: "/assets/js/nav-pills.js",
    dropdown: "/assets/js/dropdown.js",
    fixedPlugin: "/assets/js/fixed-plugin.js",
    navbarSticky: "/assets/js/navbar-sticky.js",
    sidenavBurger: "/assets/js/sidenav-burger.js",
    charts: "/assets/js/charts.js",
  }
};

// Load base scripts
loadStylesheet(assets.css.perfectScrollbar);
loadJS(assets.js.perfectScrollbar, true);

// Conditional loading based on DOM
if (document.querySelector("[slider]")) {
  loadJS(assets.js.carousel, true);
}

if (document.querySelector("nav [navbar-trigger]")) {
  loadJS(assets.js.navbarCollapse, true);
}

if (document.querySelector("[data-target='tooltip']")) {
  loadJS(assets.js.tooltips, true);
  loadStylesheet(assets.css.tooltips);
}

if (document.querySelector("[nav-pills]")) {
  loadJS(assets.js.navPills, true);
}

if (document.querySelector("[dropdown-trigger]")) {
  loadJS(assets.js.dropdown, true);
}

if (document.querySelector("[fixed-plugin]")) {
  loadJS(assets.js.fixedPlugin, true);
}

if (document.querySelector("[navbar-main]") || document.querySelector("[navbar-profile]")) {
  if (document.querySelector("[navbar-main]")) {
    loadJS(assets.js.navbarSticky, true);
  }
  if (document.querySelector("aside")) {
    loadJS(assets.js.sidenavBurger, true);
  }
}

if (document.querySelector("canvas")) {
  loadJS(assets.js.charts, true);
}

if (document.querySelector(".github-button")) {
  loadJS("https://buttons.github.io/buttons.js", true);
}

// Helpers
function loadJS(FILE_URL, async = true) {
  let dynamicScript = document.createElement("script");
  dynamicScript.setAttribute("src", FILE_URL);
  dynamicScript.setAttribute("type", "text/javascript");
  dynamicScript.setAttribute("async", async);
  document.head.appendChild(dynamicScript);
}

function loadStylesheet(FILE_URL) {
  let dynamicStylesheet = document.createElement("link");
  dynamicStylesheet.setAttribute("href", FILE_URL);
  dynamicStylesheet.setAttribute("type", "text/css");
  dynamicStylesheet.setAttribute("rel", "stylesheet");
  document.head.appendChild(dynamicStylesheet);
}
