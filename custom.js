jQuery( document ).ready(function( $ ) {
	"use strict";

    $(function() {
        $( "#tabs" ).tabs();
    });

    $("#preloader").animate({
        'opacity': '0'
    }, 600, function(){
        setTimeout(function(){
            $("#preloader").css("visibility", "hidden").fadeOut();
        }, 300);
    });
    
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      var box = $('.header-text').height();
      var header = $('header').height();

      if (scroll >= box - header) {
        $("header").addClass("background-header");
      } else {
        $("header").removeClass("background-header");
      }
    });
if ($('.my-custom-carousel').length) {
    $('.my-custom-carousel').owlCarousel({
        loop: true,
        nav: true,
        dots: true,
        items: 1,
        margin: 30,
        autoplay: false,
        smartSpeed: 700,
        autoplayTimeout: 6000,
        navText: ['<button class="PrevArrow"></button>', '<button class="NextArrow"></button>'],
        responsive: {
            0: {
                items: 1,
                margin: 0
            },
            460: {
                items: 1,
                margin: 0
            },
            576: {
                items: 2,
                margin: 20
            },
            992: {
                items: 2,
                margin: 30
            }
        }
    });
}

$(".PrevArrow, .NextArrow").on("mousedown", function(e) {
  $(this).css("outline", "none");
}).on("blur", function(e) {
  $(this).css("outline", "");
});


    $(".Modern-Slider").slick({
        autoplay:true,
        autoplaySpeed:10000,
        speed:600,
        slidesToShow:1,
        slidesToScroll:1,
        pauseOnHover:false,
        dots:true,
        pauseOnDotsHover:true,
        cssEase:'linear',
       // fade:true,
        draggable:false,
        prevArrow:'<button class="PrevArrow"></button>',
        nextArrow:'<button class="NextArrow"></button>', 
    });



});
    
document.addEventListener("DOMContentLoaded", function() {
  // Get the filters container and the button
  const filtersContainer = document.getElementById("filters-container");
  const filtersButton = document.getElementById("filters-button");

  // Initially hide the filters
  filtersContainer.style.display = "none";

  // Toggle the filters when the button is clicked
  filtersButton.addEventListener("click", function() {
    if (filtersContainer.style.display === "none") {
      filtersContainer.style.display = "block";
    } else {
      filtersContainer.style.display = "none";
    }
  });
});