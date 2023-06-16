<div id="faq-component">
    <div class="banner">
        <div class="overlay"></div>
        <div class="text">
            <h2>常見問答</h2>
            <p>FAQ</p>
        </div>
    </div>
    <div class="faqs">
        <h2>常見問答</h2>
        @foreach($faqs as $faq)
        <div class="item" x-data="{
            questOpen:false,
        }">
            <div x-bind:class="['question' , questOpen ? 'active': '']" @click="questOpen = !questOpen">
                <span>{{$faq->question}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" x-bind:class="['w-5', 'h-5', questOpen ? 'active': '']">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                  
            </div>
            <div x-bind:class="['answer', questOpen ? 'open': ''] "> @php echo nl2br($faq->content) @endphp</div>
        </div>
        @endforeach
    </div>
</div>
