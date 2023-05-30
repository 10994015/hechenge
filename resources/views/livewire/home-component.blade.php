<div id="home-component" x-data>
    
    <div class="banner">
        <div class="slick">
            <div class="cursor-pointer"> <img src="/images/banner.jpg" alt="赫成教育" /></div>
            <div class="cursor-grab"> <img src="/images/banner2.jpg" alt="赫成教育" /></div>
            <div class="cursor-grab"> <img src="/images/banner.jpg" alt="赫成教育" /></div>
        </div>
        <div class="list">
            <div class="item">
                <img src="/images/teacher.png" alt="">
                <div class="text">
                    <h4>師資介紹</h4>
                    <a href="">查看更多<i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="item">
                <img src="/images/course.png" alt="">
                <div class="text">
                    <h4>課程介紹</h4>
                    <a href="">查看更多<i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
            <div class="item">
                <img src="/images/about.png" alt="">
                <div class="text">
                    <h4>關於我們</h4>
                    <a href="">查看更多<i class="fa-solid fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <section class="course" x-data="{
        length:{{$popularCourseLength}},
        idx:0,
        pagePer:4,
        removeIdx(){
            if(this.idx <= 0) return
            this.idx--
        },
        addIdx(){
            if(this.idx >= this.length - this.pagePer) return
            this.idx++
        },
        init(){
        }
    }">
        <h2 class="title"><img src="/images/fire.png" /> 熱門課程</h2>
        <div class="btns">
            <button type="button" @click="removeIdx()">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            <button type="button" class="ml-3" @click="addIdx()">
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
        <div class="courses">
           
            @for($i=0;$i<10;$i++)
            
            <div class="card" :style="'transform: translateX(' + (idx*-100)  + '%)'">
                <div class="course" >
                    <a href="/" class="imgbox">
                        <img src="/images/c1.jpg" alt="">
                    </a>
                    <div class="content">
                        <a href="/">Course name...{{$i}}<br>Course name..</a>
                    </div>
                    <div class="footer">
                        <div class="watched">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            50
                        </div>
                        <div class="status @if(1) text-green-600 @else text-red-600 @endif">
                            火熱報名中
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

    </section>
  
</div>


@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $('.slick').slick({
        autoplay: true,
        autoplaySpeed: 6000,
        dots:false,
      });
    });
</script>
@endpush