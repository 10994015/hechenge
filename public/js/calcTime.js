/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/calcTime.js ***!
  \**********************************/
setInterval(function () {
  window.Livewire.emit('addTime');
}, 30000);
setTimeout(function () {
  window.Livewire.emit('addCount');
  window.Livewire.emit('addVisitorCount');
}, 1000);
/******/ })()
;