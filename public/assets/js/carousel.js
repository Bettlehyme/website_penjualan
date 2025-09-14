// "use strict";
// Select all slides
const slides = document.querySelectorAll("[slide]");

// current slide counter
let curSlide = 0;
// maximum number of slides
let maxSlide = slides.length - 1;

// --- initialize styles for crossfade ---
slides.forEach((slide, indx) => {
  slide.style.position = "absolute";
  slide.style.inset = "0"; // top:0; left:0; right:0; bottom:0;
  slide.style.opacity = indx === 0 ? "1" : "0";
  slide.style.transition = "opacity 0.6s ease-in-out";
  slide.style.zIndex = indx === 0 ? "1" : "0";
});

// function to show a slide
function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.style.opacity = i === index ? "1" : "0";
    slide.style.zIndex = i === index ? "1" : "0";
  });
}

// navigation
function next() {
  curSlide = (curSlide === maxSlide) ? 0 : curSlide + 1;
  showSlide(curSlide);
}

function prev() {
  curSlide = (curSlide === 0) ? maxSlide : curSlide - 1;
  showSlide(curSlide);
}

// buttons
const nextBtn = document.querySelector("[btn-next]");
const prevBtn = document.querySelector("[btn-prev]");

nextBtn?.addEventListener("click", () => {
  next();
  resetAutoSlide();
});

prevBtn?.addEventListener("click", () => {
  prev();
  resetAutoSlide();
});

// --- auto slide ---
let intervalTime = 4000; // 4 seconds
let autoSlide = setInterval(next, intervalTime);

function resetAutoSlide() {
  clearInterval(autoSlide);
  autoSlide = setInterval(next, intervalTime);
}
