<script setup>

</script>

<template>
<svg width="0" height="0">
 <filter id="gooey-black-hole">
      <feGaussianBlur in="SourceGraphic" stdDeviation="20" result="blur"/>
      <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 50 -16" result="goo" />
  </filter>
</svg>
<div class="black-hole">
  <ul class="gooey-container">
    <li class="bubble"></li>
    <li class="bubble"></li>
    <li class="bubble"></li>
    <li class="bubble"></li>
    <li class="bubble"></li>
    <li class="bubble"></li>
  </ul>
</div>
</template>

<style lang="scss" scoped>

@keyframes black-hole{
  0%  { transform:scale(1) translate3d( 75px,0,0) }
  50% { transform:scale(4) translate3d( 55px,0,0) }
  100%{ transform:scale(1) translate3d( 75px,0,0) }
}
@keyframes black-hole-rotate{
  0%   { transform: translate(-50%,-50%) rotate(  0deg) skew(3deg)}
  50%  { transform: translate(-50%,-50%) rotate(180deg) skew(0deg)}
  100% { transform: translate(-50%,-50%) rotate(360deg) skew(3deg)}
}

.black-hole{
  backface-visibility: hidden;
  z-index: 20;
  position      : relative;
  overflow      : hidden;
  border-radius : 50%;
  width         : 180px;
  height        : 180px;
  padding       : 0;
  box-shadow    : 0 0 30px 0 #1484c4 inset;
  
  .gooey-container {
    overflow      : hidden;
    border-radius : 50%;
    position      : absolute;
    top           : 50%;
    left          : 50%;
    transform     : translate(-50%,-50%) rotate(0deg) skew(5deg);
    filter        : url(#gooey-black-hole);
    width         : 300px;
    height        : 300px;
    padding       : 0;
    margin        : 0;
    box-shadow    : 0 0 0 22px #1f0033 inset;
    animation     : black-hole-rotate 5s ease infinite;
    
    .bubble {
      display    : block;
      position   : absolute;
      top        : 50%;
      left       : 50%;
      width      : 100%;
      text-align : right;

      &:before{
        content       : "";
        display       : inline-block;
        background    : #ff4081;
        width         : 100px;
        height        : 100px;
        border-radius : 50%;
        transform     : scale(1) translate3d(75px,0,0);
        box-shadow    : 0 0 10px 0 #0000ff inset,
                        0 0 10px 0 #0000ff inset;
      }
    }
    @for $i from 1 through 6 {
      .bubble:nth-child(#{$i}) {
        transform : translate(-50%,-50%) rotate(60deg*$i);
      }
      .bubble:nth-child(#{$i}):before {
        animation : black-hole 1s*($i) ease .5s*$i infinite;
      }
    }
  }
}



</style>