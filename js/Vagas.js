document.addEventListener('DOMContentLoaded', function () {

    var swiper = new Swiper('.swiper', {
      loop: true,
  
      centeredSlides: true,
      
      keyboard: {
        enabled: true,
        onlyInViewport: false,
      },
      
      zoom: {
        maxRatio: 5,
      },
      
      mousewheel: {
        invert: true,
      },
      
      freeMode: {
        enabled: true,
        sticky: true,
      },
      
      grabCursor: true,
      
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      spaceBetween:50,
      effect: "coverflow",
  
      coverflowEffect: {
        rotate: -5,
        stretch: 10,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      
      direction: 'vertical',
      slidesPerView: 1,
      breakpoints: {
        768: {
          direction: 'horizontal',
          slidesPerView: 2,
          spaceBetween: 30,
        },
        1400: {
          direction: 'horizontal',
          slidesPerView: 3,
          spaceBetween: 40,
        },
      },
    });
  });