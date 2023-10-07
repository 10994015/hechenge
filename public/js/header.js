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
var menuBtn = document.getElementById('menuBtn');
var menuIcon = document.querySelector(".menu-icon");
var lines = document.querySelectorAll(".no-animation");
var image = new Image();
image.src = "/images/nav-bg.jpg";
if (window.scrollY > 0) {
  headerNav.classList.add('active');
}
window.addEventListener("wheel", handleWheelEvent);
window.addEventListener('scroll', handleScrollEvent);
function handleScrollEvent(event) {
  if (this.scrollY > 0) {
    headerNav.classList.add('active');
  } else {
    headerNav.classList.remove('active');
  }
  if (isHome) {
    if (this.scrollY > 0) {
      homeAbout.classList.add('fade-out');
    }
    // if(this.scrollY >  250){
    //     homeCourses.classList.add('fade-out')
    // }
    // if(this.scrollY >  250){
    //     homeFeatured.classList.add('fade-out')
    // }
    // if(this.scrollY >  250){
    //     homeNews.classList.add('fade-out')
    // }
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
menuBtn.addEventListener('click', clickMenu);
function clickMenu() {
  lines.forEach(function (line) {
    line.classList.remove("no-animation");
  });
  menuIcon.classList.toggle("active");
}
/******/ })()
;