jQuery(document).ready(function ($) {



  $(".extcon").on("click", function (e) {
    e.PreventDefault;
    $(this).siblings(".inner_blck_co").slideToggle();


  });
  $(".navbar-toggler").on("click", function (e) {
    $("#navbarNav").slideToggle();
    $("#header").toggleClass("fixed-header");
  });
  $(".swiper-button-next").hover(
    function () {
      $(".swiper-button-prev").addClass("result_hover");
    },
    function () {
      $(".swiper-button-prev").removeClass("result_hover");
    }
  );


});
const swiper = new Swiper('.swiper', {
  loop: true,

  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

});