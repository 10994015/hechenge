<footer>
    <div class="contact">
        <div class="info">
            <a href="/" class="logo">
                <img src="/images/logo.png" alt="赫成教育" />
            </a>
            <p></p>
        </div>
        <div class="time">
            <h5>聯絡資訊</h5>
            <div class="item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
                03-4225500
            </div>      
            <div class="item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                </svg>
                桃園市中壢區中央東路88號15樓
            </div>      
           
            <div class="item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                平日 PM 14:00 - PM 22:00<br />
                假日 PM 09:00 - PM 22:00
            </div>
            <div class="item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                <a href= "mailto:hc4225500@gmail.com" >hc4225500@gmail.com</a> 
            </div>
        </div>
        <div class="course">
            <h5>探索課程</h5>
            @foreach(DB::table('course_categories')->where('deleted_at', null)->get() as $c)
            <div class="item"><a href="/courses/{{$c->id}}">{{$c->name}}</a></div>
            @endforeach
        </div>
        <div class="link">
            <h5>關注我們</h5>
            <div class="item">
                <a href=""><img width="40" src="/images/line-icon.png" class="mr-2"></a>
                <a href=""><img width="40" src="/images/ig-icon.png" class="mr-2"></a>
                <a href=""><img width="40" src="/images/fb-icon.png" ></a>
            </div>
            {{-- <div class="item mt-4">
                <img src="/images/qrcode.png" width="140" alt="" />
            </div> --}}
        </div>
    </div>
    <div class="copyright">
        <p>Copyright @2023 <a href="/">赫成教育集團.</a>  All Rights Reserved.</p>
    </div>
</footer>