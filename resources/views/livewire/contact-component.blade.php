<div id="contact-component" x-data>
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>聯絡我們</h2>
            <p>Contact Us</p>
        </div>
    </div>
    <div class="information">
        <div class="item item1">
            <img src="/images/address.png" alt="" />
            <h3>實體地址</h3>
            <p>桃園市中壢區中央東路88號15樓</p>
        </div>
        <div class="item item2">
            <img src="/images/contact.png" alt="" />
            <h3>聯絡資訊</h3>
            <p>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg> 03-4225500
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>hc4225500@gmail.com
                </span>
            </p>
        </div>
        <div class="item item3">
            <img src="/images/clock.png" alt="" />
            <h3>營業時間</h3>
            <p>週一至週五 PM 14:00 - PM 22:00<br>六日 PM 14:00 - PM 22:00</p>
        </div>
    </div>
    <form wire:submit.prevent='onSubmit' wire:ignore >
        <h3>立即填寫下方表單了解<br>也歡迎於官方臉書專頁、Instagram及line@訊息詢問更多優惠課程及相關資訊內容喔！</h3>
        <label for=""> 
            <span>詢問課程*</span>
            <select wire:model="course">
                <option value="">國中英文課</option>
            </select>
        </label>
        <label for=""> 
            <span>您的姓名*</span>
            <input type="text" placeholder="姓名 *" wire:model='name' />
        </label>
        <label for=""> 
            <span>電子郵件*</span>
            <input type="text" placeholder="電子郵件 *" wire:model='email' />
        </label>
        <label for="">
            <span>主旨*</span>
            <input type="text" placeholder="主旨 *" wire:model='subject' />
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
        @error('name') <span class="text-danger">{{$message}}</span> @enderror
        @error('email') <span class="text-danger">{{$message}}</span> @enderror
        @error('subject') <span class="text-danger">{{$message}}</span> @enderror
        @error('content') <span class="text-danger">{{$message}}</span> @enderror
        @error('captcha') <span class="text-danger">{{$message}}</span> @enderror
    </div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.2974069456636!2d121.22355707577283!3d24.9559940414274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3468224830092223%3A0x35ce2c0b437a7dc1!2zMzIw5qGD5ZyS5biC5Lit5aOi5Y2A5Lit5aSu5p2x6LevODjomZ8xNeaokw!5e0!3m2!1szh-TW!2stw!4v1685712033996!5m2!1szh-TW!2stw"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

</div>

@push('scripts')
    <script>
        const captcha_img = document.getElementById('captcha_img')
        const reloadCaptcha = document.getElementById('reloadCaptcha')


        reloadCaptcha.addEventListener('click', ()=>{
            axios.get('/reload-captcha').then(res=>{
                captcha_img.innerHTML = res.data.captcha;
            })
        })
    </script>
@endpush