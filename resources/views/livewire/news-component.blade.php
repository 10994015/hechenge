<div id="news-component" x-data>
    @php use Carbon\Carbon; @endphp
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>最新消息</h2>
            <p>Latest News</p>
        </div>
    </div>
    <section class="news fade-out">
        <div class="searchBar">
            <label for="" class="search-container">
                <input type="text" placeholder="搜尋公告..." wire:model='search' />
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                      </svg>
                </button>
            </label>
        </div>
        <div class="nav">
            <button class="@if($range == 'month') active @endif" wire:click='chengRange("month")'>本月公告</button>
            <button class="@if($range != 'month') active @endif" wire:click='chengRange("all")'>全部公告</button>
        </div>
        <div class="content">
            @if($articles->count() <= 0)
            <div class="flex justify-center items-center">
                <span class="py-10 text-center text-xs text-gray-500">暫無資料。</span>
            </div>
            @endif
            @foreach($articles as $article)
            <div class="new-item">
                <div class="time-from">
                    <span>{{ Carbon::createFromFormat('Y-m-d H:i:s', $article->updated_at)->format('d') }}</span>
                    {{Carbon::createFromFormat('Y-m-d H:i:s', $article->updated_at)->formatLocalized('%B')}}
                </div>
                <div class="text">
                    <a href="/new-detail/{{$article->slug}}" class="new-title">{{$article->title}}</a>
                    <span class="category">
                        @if($article->category_id)
                        {{$article->category->name}}
                        @else
                        尚無分類
                        @endif
                    </span>
                    <article> {!! $article->content !!} </article>
                </div>
                <a href="/new-detail/{{$article->slug}}" class="imgbox">
                    <img src="{{$article->image}}" alt="{{$article->title}}" />
                </a>
            </div>
            @endforeach
        </div>
       {{$articles->links()}}
    </section>
</div>
