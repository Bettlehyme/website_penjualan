// sidenav transition-burger
document.addEventListener("DOMContentLoaded", function () {
    var sidenav = document.querySelector("aside");
    var sidenav_trigger = document.querySelector("[sidenav-trigger]");
    var sidenav_close_button = document.querySelector("[sidenav-close]");

    if (!sidenav || !sidenav_trigger) return; // safety

    var burger = sidenav_trigger.firstElementChild;
    var top_bread = burger ? burger.firstElementChild : null;
    var bottom_bread = burger ? burger.lastElementChild : null;

    function toggleSidenav() {
        const expanded = sidenav.getAttribute("aria-expanded") === "true";

        sidenav.setAttribute("aria-expanded", !expanded);
        sidenav.classList.toggle("translate-x-0");
        sidenav.classList.toggle("ml-6");
        sidenav.classList.toggle("shadow-xl");

        // Animate burger bars if they exist
        if (top_bread && bottom_bread) {
            top_bread.classList.toggle("translate-x-[5px]");
            bottom_bread.classList.toggle("translate-x-[5px]");
        }
    }

    sidenav_trigger.addEventListener("click", toggleSidenav);

    if (sidenav_close_button) {
        sidenav_close_button.addEventListener("click", toggleSidenav);
    }

    // Close sidenav when clicking outside
    window.addEventListener("click", function (e) {
        if (
            sidenav.getAttribute("aria-expanded") === "true" &&
            !sidenav.contains(e.target) &&
            !sidenav_trigger.contains(e.target)
        ) {
            toggleSidenav();
        }
    });
});
