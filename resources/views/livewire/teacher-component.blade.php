<div id="teacher-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>師資陣容</h2>
            <p>Teachers</p>
        </div>
    </div>
    <div class="teachers">
        @foreach($teachers as $teacher)
        <div class="teacher">
            <div class="text">
                @if($teacher->title1)
                    <h3>{{$teacher->title1}}</h3>
                    <p>{{$teacher->content1}}</p>
                @endif
                @if($teacher->title2)
                    <h3>{{$teacher->title2}}</h3>
                    <p>{{$teacher->content2}}</p>
                @endif
                @if($teacher->title3)
                    <h3>{{$teacher->title3}}</h3>
                    <p>{{$teacher->content3}}</p>
                @endif
                @if($teacher->title4)
                    <h3>{{$teacher->title4}}</h3>
                    <p>{{$teacher->content4}}</p>
                @endif
                @if($teacher->title5)
                    <h3>{{$teacher->title5}}</h3>
                    <p>{{$teacher->content5}}</p>
                @endif
            </div>
            <div class="imgbox">
                <img src="{{$teacher->image}}" alt="{{$teacher->name}}" />
            </div>
            <div class="content">
                <h2>{{$teacher->name}}</h2>
                <p>{{$teacher->subname}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
