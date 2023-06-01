const header = document.getElementById('header');
const headerNav = document.getElementById('header-nav');
const searchBtn = document.getElementById('search-btn')
const searchFull = document.getElementById('search-full')
const back = searchFull.querySelector('.back')
if(window.scrollY > 0){
    headerNav.classList.add('active')
}
window.addEventListener("wheel", handleWheelEvent);

function handleWheelEvent(event) {
  console.log(this.scrollY);
 
  if (event.deltaY > 0) {
    if(this.scrollY > 100){
        header.style.top = "-157px"
    }
  } else if (event.deltaY < 0) {
    header.style.top = "0"
  }
  if(this.scrollY > 0){
    headerNav.classList.add('active')
  }else{
    headerNav.classList.remove('active')
  }
}
searchBtn.addEventListener('click', ()=>{
  searchFull.style.display = 'flex'
})
back.addEventListener('click', ()=>{
  searchFull.style.display = 'none'
})