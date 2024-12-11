const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const close = document.getElementById('close');

if(bar) {
    bar.addEventListener('click', ()=>{
        nav.classList.add('active');
    })
}

if(close) {
    close.addEventListener('click', ()=>{
        nav.classList.remove('active');
    })
}
document.addEventListener("DOMContentLoaded", function() {
    var dropdowns = document.getElementsByClassName("dropdown");
    var i;

    for (i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("click", function() {
            this.querySelector(".dropdown-content").classList.toggle("show");
        });
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropdown')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
});