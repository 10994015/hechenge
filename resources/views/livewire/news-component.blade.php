<div id="news-component" x-data>
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
                <input type="text" placeholder="搜尋公告..." />
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                      </svg>
                </button>
            </label>
        </div>
        <div class="nav">
            <button class="active">本月公告</button>
            <button>全部公告</button>
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
</div>
