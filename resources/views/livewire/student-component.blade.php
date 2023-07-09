<div id="student-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>學生回饋</h2>
            <p>Students Feedback</p>
        </div>
    </div>
    <div class="students">
        @if($students->count() <= 0)
            <div class="flex justify-center items-center">
                <span class="py-10 text-center text-xs text-gray-500">暫無資料。</span>
            </div>
        @endif
        @foreach($students as $student)
        <div class="student">
            <div class="title">
                <img src="{{$student->image}}" alt="" />
                <h2>{{$student->name}}</h2>
            </div>
            <div class="content">
                <div class="left-top">
                    <img src="/images/quote.png" />
                </div>
                <div class="right-bottom">
                    <img src="/images/quote.png" />
                </div>
                @if($student->url)
                <iframe width="560" height="315" src="{{$student->url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                @endif
                <article>
                    {!! $student->content !!}
                </article>
            </div>
        </div>
        @endforeach
    </div>
</div>
