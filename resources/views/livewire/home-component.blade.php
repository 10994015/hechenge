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
    <section class="about" id="home-about">
        <div class="icon-list">
            <div class="icons">
                <div class="item">
                    <img src="/images/icon1.png" alt="" />
                    <h4>國中英文</h4>
                </div>
                <div class="item">
                    <img src="/images/icon2.png" alt="" />
                    <h4>國中英文</h4>
                </div>
            </div>
            <div class="icons">
                <div class="item">
                    <img src="/images/icon3.png" alt="" />
                    <h4>國中英文</h4>
                </div>
                <div class="item">
                    <img src="/images/icon4.png" alt="" />
                    <h4>國中英文</h4>
                </div>
                <div class="item">
                    <img src="/images/icon5.png" alt="" />
                    <h4>國中英文</h4>
                </div>
            </div>
            <div class="icons">
                <div class="item">
                    <img src="/images/icon6.png" alt="" />
                    <h4>國中英文</h4>
                </div>
                <div class="item">
                    <img src="/images/icon7.png" alt="" />
                    <h4>國中英文</h4>
                </div>
            </div>
        </div>
        <div class="content">
            <h1>赫成教育集團</h1>
            <p>
                任何有抱負的天文學家的生活中都會有那麼一刻是購買第一台望遠鏡的時候了。考慮建立自己的觀察站是令人興奮的。在任何有抱負的天文學家的生活中，是時候購買第一台望遠鏡了。考慮建立自己的觀察站是令人興奮的。

                考慮建立自己的觀察站是令人興奮的。在任何有抱負的天文學家的生活中，是時候購買第一台望遠鏡了，令人興奮的是首先購買它。
            </p>
            <a href="/">關於赫成</a>
        </div>
    </section>
    <div class="course-div" id="home-courses" >
        <section class="course"  x-data="{
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
    <div class="featured" >
        <section class="featured-content" id="home-featured">
            <h2 class="title"><img src="/images/feature.png" /> 最近主打</h2>
            <div class="content">
                @for($i=0;$i<2;$i++)
                <div class="feature">
                    <img src="/images/e2.jpg" alt="" />
                    <div class="text">
                        <div class="info">
                            <div class="date">
                                <span>15</span>
                                Jun
                            </div>
                            <div class="tiem-loaction">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    12:00 AM - 12:30 AM
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    Hilton Quebec
                                </span>
                            </div>
                        </div>
                        <h3 class="feature-title">最近主打課程標題...</h3>
                        <p class="description">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio consequuntur, minus non itaque ea quisquam repellat sed quis sit debitis, perspiciatis temporibus facilis inventore nulla doloremque saepe id, quos deserunt!
                        </p>
                        <a href="" class="view-more">瀏覽更多</a>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </div>
    <section class="news" id="home-news" >
        <h2 class="title"><img src="/images/news.png" />最新消息</h2>
        <div class="readmore">
            <a href="">瀏覽更多</a>
        </div>
        <div class="content">
            @for($i=0;$i<3;$i++)
            <div class="new-item">
                <div class="time-from">
                    <span>15</span>
                    octubre
                </div>
                <div class="text">
                    <a href="" class="new-title">Aplicación de las leyes naturales a la tecnología y la sociedad</a>
                    <span class="category">類別</span>
                    <article>Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuatMorbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris itae erat conuat</article>
                </div>
                <a href="" class="imgbox">
                    <img src="/images/c1.jpg" alt="" />
                </a>
            </div>
            @endfor
        </div>
    </section>
    <div class="icon-links">
        <a href="" class="mb-3"><img src="/images/line.png" alt=""></a>
        <a href="" class="mb-3"><img src="/images/ig.png" alt=""></a>
        <a href=""><img src="/images/fb.png" alt=""></a>
    </div>
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