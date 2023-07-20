<div id="new-detail-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>{{$article->title}}</h2>
        </div>
    </div>
    <div class="content">
        <div class="detail">
            <h1>{{$article->title}}</h1>
            <a href="/courses" class="category">
            @if($article->category_id)
            {{$article->category->name}}
            @else
            尚無分類
            @endif
            </a>
            <img src="{{$article->image}}" class="cover-img" alt="{{$article->title}}" />
            <article>
                {!! $article->content !!}
            </article>
        </div>
    </div>
</div>
