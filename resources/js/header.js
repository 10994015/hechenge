const header = document.getElementById('header');
const headerNav = document.getElementById('header-nav');
const searchBtn = document.getElementById('search-btn')
const searchFull = document.getElementById('search-full')
const back = searchFull.querySelector('.back')
const homeAbout = document.getElementById('home-about')
const homeCourses = document.getElementById('home-courses')
const homeFeatured = document.getElementById('home-featured')
const homeNews = document.getElementById('home-news')
const menuBtn = document.getElementById('menuBtn');
const menuIcon = document.querySelector(".menu-icon");
const lines = document.querySelectorAll(".no-animation");
const image = new Image();
image.src = "/images/nav-bg.jpg"
const image2 = new Image();
image2.src = "/images/logo.png"
if(window.scrollY > 0){
    headerNav.classList.add('active')
}
// window.addEventListener("wheel", handleWheelEvent);
// window.addEventListener('scroll', handleScrollEvent)
headerNav.classList.add('active')
    function handleScrollEvent(event){
        if(this.scrollY > 0){
            headerNav.classList.add('active')
        }else{
            headerNav.classList.remove('active')
        }
        if(isHome){
          if(this.scrollY > 0){
            homeAbout.classList.add('fade-out')
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
    if(this.scrollY > 100){
        header.style.top = "-157px"
    }
  } else if (event.deltaY < 0) {
    header.style.top = "0"
  }
}
searchBtn.addEventListener('click', ()=>{
  searchFull.style.display = 'flex'
})
back.addEventListener('click', ()=>{
  searchFull.style.display = 'none'
})

menuBtn.addEventListener('click', clickMenu);
    function clickMenu(){
        lines.forEach((line) => {
            line.classList.remove("no-animation");
        });
        menuIcon.classList.toggle("active");
    }