setInterval(()=>{
    window.Livewire.emit('addTime'); 
}, 30000)
setTimeout(()=>{
    window.Livewire.emit('addCount'); 
    window.Livewire.emit('addVisitorCount'); 
}, 1000)