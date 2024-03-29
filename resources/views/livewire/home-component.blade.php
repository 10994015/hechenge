<div id="home-component" x-data>
    @php use Carbon\Carbon; @endphp
    <div class="banner">
        <div class="slick">
            @foreach($banners as $banner)
            @if($banner->url)
            <a href="{{$banner->url}}" class="cursor-pointer" style="display:block"> <img src="{{$banner->image}}" alt="{{$banner->title}}" /></a>
            @else
            <div class="cursor-pointer" style="display:block"> <img src="{{$banner->image}}" alt="{{$banner->title}}" /></div>
            @endif
            @endforeach
        </div>
  
    @if($hotCourses->count() > 0)
    <div class="course-div" id="home-courses" >
        <section class="course"  x-data="{
            length:{{$hotCourses->count()}},
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
               
                @foreach($hotCourses as $course)
                
                <div class="card" :style="'transform: translateX(' + (idx*-100)  + '%)'">
                    <div class="course" >
                        <a href="/course-detail/{{$course->slug}}" class="imgbox">
                            <img src="{{$course->image}}" alt="{{$course->title}}">
                            <div class="view">查看課程</div>
                        </a>
                        <div class="content">
                            <a href="/course-detail/{{$course->slug}}">{{$course->title}}</a>
                        </div>
                        <div class="footer">
                            <div class="watched">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                {{$course->visitor}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{$course->watched}}
                            </div>
                            <div class="status @if(1) text-green-600 @else text-red-600 @endif">
                                火熱報名中
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
    
        </section>
    </div>
    @endif
    @if($focusCourses->count() > 0)
    <div class="featured" >
        <section class="featured-content" id="home-featured">
            <h2 class="title"><img src="/images/feature.png" /> 最近主打</h2>
            <div class="content">
                @foreach($focusCourses as $course)
                <div class="feature">
                    <div class="overlay"></div>
                    <img src="{{$course->image}}" alt="{{$course->title}}" />
                    <div class="text">
                        <div class="info">
                            <div class="date">
                                <span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $course->updated_at)->format('d') }}</span>
                                {{Carbon::createFromFormat('Y-m-d H:i:s', $course->updated_at)->formatLocalized('%B')}}
                            </div>
                            <div class="tiem-loaction">
                                {{-- <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    12:00 AM - 12:30 AM
                                </span> --}}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    320桃園市中壢區中央東路88號15樓
                                </span>
                            </div>
                        </div>
                        <h3 class="feature-title">{{$course->title}}</h3>
                        <article class="description">
                            {!! $course->content !!}
                        </article>
                        <a href="/course-detail/{{$course->slug}}" class="view-more">瀏覽更多</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
    @endif
    @if($articles->count() > 0)
    <section class="news" id="home-news" >
        <h2 class="title"><img src="/images/news.png" />最新消息</h2>
        <div class="readmore">
            <a href="/news">瀏覽更多</a>
        </div>
        <div class="content">
            @foreach($articles as $article)
            <div class="new-item">
                <div class="time-from">
                    <span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $article->updated_at)->format('d') }}</span>
                    {{Carbon::createFromFormat('Y-m-d H:i:s', $article->updated_at)->formatLocalized('%B')}}
                </div>
                <div class="text">
                    <a href="" class="new-title">{{$article->title}}</a>
                    <span class="category">
                        @if($article->category_id)
                        {{$article->category->name}}
                        @else
                        尚無分類
                        @endif
                    </span>
                    <article>{!! $article->content !!}</article>
                </div>
                <a href="/new-detail/{{$article->slug}}" class="imgbox">
                    <img src="{{$article->image}}" alt="{{$article->title}}" />
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>


@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
      $('.slick').slick({
        autoplay: true,
        autoplaySpeed: 6000,
        dots:true,
      });
    });
    isHome = true;

    const feature = document.querySelectorAll('.feature')
    for(let i=0;i<feature.length;i++){
        feature[i].style.backgroundImage = 'url(' +  feature[i].querySelector('img').src + ')'
    }
    // const slickDiv = document.querySelector('.slick').querySelectorAll('div');
    // console.log(slickDiv);
    // for(let i=0;i<slickDiv.length;i++){
    //     // console.log(slickDiv[i].querySelector("img").src);
    //     // console.log(slickDiv[i].style.backgroundImage);
    //     slickDiv[i].style.backgroundImage = `url('${slickDiv[i].querySelector("img").src}')`
    //     console.log(slickDiv[i].style.backgroundImage);
    // }
</script>
@endpush