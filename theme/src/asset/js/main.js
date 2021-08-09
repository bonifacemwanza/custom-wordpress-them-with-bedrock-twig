function detectMob() {
    const toMatch = [
        /Android/i,
        /webOS/i,
        /iPhone/i,
        /iPad/i,
        /iPod/i,
        /BlackBerry/i,
        /Windows Phone/i
    ];

    return toMatch.some((toMatchItem) => {
        return navigator.userAgent.match(toMatchItem);
    });
}
var heroSlider = new Swiper(".hero-slider__horizantal-slider", {
    autoplay: {
        delay: 5000,
    }, 
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
var swiper = new Swiper(".carousel-slider", {
    slidesPerView: 2,
    spaceBetween: 2,
    breakpoints: {
        480: {
            slidesPerView: 2,
            spaceBetween: 30,
        },
        640: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
    },
    loop : true,
    autoplay: {
        delay: 4000,
    },  
    pagination: {
        el: ".carousel-slider-swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    }
});

const productSlider = new Swiper(".product__gallery-slider", {
    /*lazy: {
        preloadImages: false,
        loadPrevNext: true,
        loadPrevNextAmount: 2,
    },*/
    loop : true,
    autoplay: {
        delay: 5000,
    }, 
    /*
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },*/
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

function geSlideDataIndex(swipe){
    var activeIndex = swipe.activeIndex;
    var slidesLen = swipe.slides.length;
    if(swipe.params.loop){
        switch(swipe.activeIndex){
            case 0:
                activeIndex = slidesLen-3;
                break;
            case slidesLen-1:
                activeIndex = 0;
                break;
            default:
                --activeIndex;
        }
    }
    return  activeIndex;
}

var pswpElement = document.querySelectorAll('.pswp')[0];

// build items array
var items = [
    {
        src: 'dist/saye-product-01.jpeg',
        w: 1600,
        h: 2080
    },
    {
        src: 'dist/saye-product-02.jpeg',
        w: 1600,
        h: 2080
    },
    {
        src: 'dist/saye-product-03.jpeg',
        w: 1600,
        h: 2080
    }
];

// define options (if needed)
var options = {};


/**
 * Header sticky menu
 */
var doc = document.documentElement;

  var prevScroll = window.scrollY || doc.scrollTop;
  var curScroll;
  var direction = 0;
  var prevDirection = 0;

  var header = $(".header")[0];

  var checkScroll = function () {
    curScroll = window.scrollY || doc.scrollTop;

    if (curScroll > prevScroll) {
      direction = 2;
    } else if (curScroll < prevScroll) {
      direction = 1;
    }

    if(!detectMob())
    {
        if (direction !== prevDirection) {
            toggleHeader(direction, curScroll);
        }
    }
 
    prevScroll = curScroll;
  };

  var toggleHeader = function (direction, curScroll) {
    if (direction === 2 && curScroll > 90) {
      header.classList.add("hide");
      prevDirection = direction;
    } else if (direction === 1) {
      header.classList.remove("hide");
      prevDirection = direction;
    }
  };



$(document).ready(function () {
    window.addEventListener("scroll", checkScroll);
    //productSlider.on('slideChange', function () {
 
        if ($(".zoom-image")[0]){
 
                $('.zoom-image').click(function(){
                    // Initializes and opens PhotoSwipe
                    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                    gallery.init();
                });
  
        } 
    //});    





    //var ez =   $('.zoom-image').data('elevateZoom');
    //ez.swaptheimage($(this).attr('src'), $(this).attr('data-src'));




    // Disable img context menu
    $('img').bind('contextmenu', function(e) {
        return false;
    }); 
    // Disable img context menu

    $('.tooltip').tooltip({ boundary: 'window' })

    $('.js-trigger-collapse-menu').click(function (e) { 
        e.preventDefault();
        $('.js-collapse-menu').slideToggle();
    });

    $('.js-trigger-toggle').click(function (e) { 
        e.preventDefault();
        let $target = $(this).attr('data-target')
        $($target).slideToggle();
    });

    $(".collapse.show").each(function(){
        $(this).prev(".card-header").find(".fa").addClass("product-tabs__accordion-minus").removeClass("product-tabs__accordion-plus");
    });
    
    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("product-tabs__accordion-plus").addClass("product-tabs__accordion-minus");
    }).on('hide.bs.collapse', function(){
        $(this).prev(".card-header").find(".fa").removeClass("product-tabs__accordion-minus").addClass("product-tabs__accordion-plus");
    });


});