<div id="course-detail-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <p>{{$course->title}}</p>
        </div>
    </div>
    <div class="content">
        <div class="detail" id="scrollDetail">
            <h1>{{$course->title}}</h1>
            <a href="/courses" class="category">{{$course->category->name}}</a>
            <img src="{{$course->image}}" class="cover-img" alt="{{$course->title}}" />
            <div class="tags">
                @foreach($tags as $tag)
                    @if($tag != "" || $tag != null)
                    <span>#{{DB::table('course_tags')->where('id', $tag)->first()->name}}</span> 
                    @endif
                @endforeach
            </div>
            <article>
                @php echo nl2br($course->content) @endphp
            </article>
            <hr class="mt-[100px] mb-[50px]">
            <form wire:submit.prevent='onSubmit' wire:ignore>
                <h3>立即報名</h3>
                <label for=""> 
                    <span>詢問課程*</span>
                    <input type="text" placeholder="詢問課程"  disabled  wire:model="courseName" class="cursor-not-allowed text-gray-400" />
                </label>
                <label for=""> 
                    <span>您的姓名*</span>
                    <input type="text" placeholder="姓名 *" wire:model='name' />
                </label>
                <label for=""> 
                    <span>聯絡電話</span>
                    <input type="text" placeholder="聯絡電話 *" wire:model='phone' />
                </label>
                <label for=""> 
                    <span>就讀學校 *</span>
                    <input type="text" placeholder="就讀學校 *" wire:model='school' />
                </label>
                <label for="">
                    <span>就讀年級</span>
                    <select wire:model="grade" >
                        <option value="高中一年級">高中一年級</option>
                        <option value="高中二年級">高中二年級</option>
                        <option value="高中三年級">高中三年級</option>
                        <option value="國中八年級">國中八年級</option>
                        <option value="國中八年級">國中八年級</option>
                        <option value="其他">其他</option>
                    </select>
                </label>
                <label for=""> 
                    <span>詢問內容*</span>
                    <textarea  placeholder="詢問內容 *" wire:model='content'></textarea>
                </label>
                <label for="" >
                    <div class="chaptcha" >
                        <span id="captcha_img">{!! captcha_img('flat') !!} </span>
                    <button type="button" class="reload" id="reloadCaptcha">&#x21bb;</button></div>
                    <input type="text" placeholder="請輸入上方驗證碼 *" class="mt-2" wire:model='captcha' />
                </label>
                <label for="">
                    <button type="submit" wire:loading.remove wire:target='onSubmit'>
                        確認送出
                    </button>
                    <button type="button"  class="loading" wire:loading wire:target='onSubmit'>
                        發送中...
                    </button>
                </label>
            </form>
            @if (session('success'))
            <div class='successDiv'>
                <div class="mb-4 font-medium text-sm text-green-600 ">
                    {{ session('success') }}
                </div>
            </div>
            @endif
            <div class="errorDiv">
                @if(session('error')) {{session('error')}} @endif
                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                @error('school') <span class="text-danger">{{$message}}</span> @enderror
                @error('grade') <span class="text-danger">{{$message}}</span> @enderror
                @error('content') <span class="text-danger">{{$message}}</span> @enderror
                @error('captcha') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        </div>
        <div class="sildebar" id="scrollSildebar">
            <div class="all-course">
                <h3 class="title">所有課程</h3>
                <ul>
                    @foreach($courses as $c)
                    <a href="/course-detail/{{$c->slug}}">{{$c->title}}</a>
                    @endforeach
                </ul>
            </div>
            <div class="hot-course mt-10">
                <h3 class="title">熱門課程</h3>
                <ul>
                    @foreach($hot_courses as $hot)
                    <a href="">
                        <img src="{{$hot->image}}" alt="{{$hot->title}}" />
                        <div class="content">
                            <h4>{{$hot->title}}</h4>
                            <ol>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                {{$hot->visitor}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{$hot->watched}}
                            </ol>
                        </div>
                    </a>
                    @endforeach
                </ul>
            </div>
            <div class="like-course mt-10">
                <h3 class="title">您可能會喜歡</h3>
                <ul>
                    @foreach($likeCourses as $like)
                    <a href="">
                        <img src="{{$like->image}}" alt="{{$like->title}}" />
                        <div class="content">
                            <h4>{{$like->title}}</h4>
                            <ol>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                                {{$like->visitor}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{$like->watched}}
                            </ol>
                        </div>
                    </a>
                    @endforeach
                </ul>
            </div>
            <div class="advertise">
                <a href="">
                    <img src="/images/e2.jpg" alt="" />
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="/js/calcTime.js"></script>
    <script>
        const captcha_img = document.getElementById('captcha_img')
        const reloadCaptcha = document.getElementById('reloadCaptcha')


        reloadCaptcha.addEventListener('click', ()=>{
            axios.get('/reload-captcha').then(res=>{
                captcha_img.innerHTML = res.data.captcha;
            })
        });
        window.addEventListener('reloadCaptcha', e=>{
            axios.get('/reload-captcha').then(res=>{
                captcha_img.innerHTML = res.data.captcha;
            })
        });
    </script>
@endpush