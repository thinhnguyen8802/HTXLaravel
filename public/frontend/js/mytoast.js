const toast = document.querySelector(".toastms");
var closeIcon = document.querySelector('.close-toast');
let timer1, timer2;

if(closeIcon != undefined){
    closeIcon.addEventListener("click", () => {
        // toast.classList.add("close");
        toast.classList.remove("active");
    
        setTimeout(() => {
            progress.classList.remove("active");
        }, 300);
    
        clearTimeout(timer1);
        clearTimeout(timer2);
    });
}
if(toast != undefined){
    timer1 = setTimeout(() => {
        toast.classList.remove("active");
    
    }, 5000); //1s = 1000 milliseconds
    
    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 5300);
}
// $('.blog-owl').owlCarousel({
//     loop:true,
//     margin:10,
//     nav:true,
//     responsive:{
//         0:{
//             items:1
//         },
//         600:{
//             items:3
//         },
//         1000:{
//             items:5
//         }
//     }
// })

