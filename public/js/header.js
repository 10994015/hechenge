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
var homeAbout = document.getElementById('home-about');
var homeCourses = document.getElementById('home-courses');
var homeFeatured = document.getElementById('home-featured');
var homeNews = document.getElementById('home-news');
if (window.scrollY > 0) {
  headerNav.classList.add('active');
}
window.addEventListener("wheel", handleWheelEvent);
window.addEventListener('scroll', handleScrollEvent);
function handleScrollEvent(event) {
  console.log(this.scrollY);
  if (this.scrollY > 0) {
    headerNav.classList.add('active');
  } else {
    headerNav.classList.remove('active');
  }
  if (this.scrollY > 250) {
    homeAbout.classList.add('fade-out');
  }
  if (this.scrollY > 1200) {
    homeCourses.classList.add('fade-out');
  }
  if (this.scrollY > 1900) {
    homeFeatured.classList.add('fade-out');
  }
  if (this.scrollY > 2700) {
    homeNews.classList.add('fade-out');
  }
}
function handleWheelEvent(event) {
  if (event.deltaY > 0) {
    if (this.scrollY > 100) {
      header.style.top = "-157px";
    }
  } else if (event.deltaY < 0) {
    header.style.top = "0";
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