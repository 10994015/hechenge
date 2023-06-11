<div id="course-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>所有課程</h2>
            <p>Courses</p>
        </div>
    </div>
    <div class="courses">
        <div class="nav">
            <span>顯示 10-18 的 19 個結果</span>
            <div class="searchBar">
                <label for="">
                    <select name="" id="">
                        <option value="">國中課程</option>
                    </select>
                </label>
                <label for="" class="search-container">
                    <input type="text" placeholder="搜尋課程..." />
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                          </svg>
                    </button>
                </label>
            </div>
        </div>
        <div class="course-list">
            @for($i=0;$i<=1;$i++)
            <div class="course-item">
                <a href="/course-detail" class="imgbox">
                    <img src="/images/e2.jpg" alt="" />
                    <div class="view">查看課程</div>
                </a>
                <div class="content">
                    <a href="/course-detail">超級無敵英文課超級無敵英文課超級無敵英文課超級無敵英文課</a>
                </div>
                <div class="footer">
                    <div class="watched">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        100
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-2 mr-1">
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
            @endfor
        </div>
    </div>
</div>