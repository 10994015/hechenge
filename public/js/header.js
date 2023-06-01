/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/header.js ***!
  \********************************/
var header = document.getElementById('header');
var headerNav = document.getElementById('header-nav');
var searchBtn = document.getElementById('search-btn');
var searchFull = document.getElementById('search-full');
var back = searchFull.querySelector('.back');
if (window.scrollY > 0) {
  headerNav.classList.add('active');
}
window.addEventListener("wheel", handleWheelEvent);
function handleWheelEvent(event) {
  console.log(this.scrollY);
  if (event.deltaY > 0) {
    if (this.scrollY > 100) {
      header.style.top = "-157px";
    }
  } else if (event.deltaY < 0) {
    header.style.top = "0";
  }
  if (this.scrollY > 0) {
    headerNav.classList.add('active');
  } else {
    headerNav.classList.remove('active');
  }
}
searchBtn.addEventListener('click', function () {
  searchFull.style.display = 'flex';
});
back.addEventListener('click', function () {
  searchFull.style.display = 'none';
});
/******/ })()
;