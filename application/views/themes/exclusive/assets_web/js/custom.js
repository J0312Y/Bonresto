jQuery(document).on(
  "ready",
  (function ($) {
    "use strict";

    // Hide Loading Box (Preloader)
    $(".preloader").delay(300).fadeOut("slow");
    $("body").delay(300).css({ overflow: "visible" });

    $(".menu-carousel").owlCarousel({
      items: 5,
      loop: true,
      margin: 10,
      dots: false,
      // autoplay: true,
      // autoplayTimeout: 2000,
      // autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1,
        },
        576: {
          items: 2,
        },
        800: {
          items: 3,
        },
        1200: {
          items: 4,
        },
        1400: {
          items: 5,
        },
      },
    });

    $(".expert-carousel").owlCarousel({
      items: 2,
      loop: true,
      center: true,
      margin: 40,
      dots: true,
      responsive: {
        0: {
          items: 1,
        },
        576: {
          items: 2,
        },
        1200: {
          items: 2,
        },
      },
    });

    $(".testimonial-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 30,
      dots: true,
      responsive: {
        0: {
          items: 1,
        },
        576: {
          items: 2,
        },
        1200: {
          items: 3,
          dots: true,
        },
      },
    });

    /*------------------------------------
     Mobile Menu
     -------------------------------------- */

    $("#mobile-menu").metisMenu();

    $("#dismiss, .overlay").on("click", function () {
      $(".sidebar-nav").removeClass("active");
      $(".overlay").fadeOut();
    });

    $("#sidebarCollapse").on("click", function () {
      $(".sidebar-nav").addClass("active");
      $(".overlay").fadeIn();
    });

    /*---------------------------
        Sticky Menu
    -----------------------------*/
    var $mainNav = $(".main-nav"),
      scrolledClass = "main-nav-scrolled",
      headerHeight = $(".header-content-top").height();

    $(window).scroll(function () {
      if ($(this).scrollTop() > headerHeight) {
        $mainNav.addClass(scrolledClass);
      } else {
        $mainNav.removeClass(scrolledClass);
      }
    });

    /*----------------------------
        SCROLL TO TOP
    ------------------------------*/
    // Back to top js
    var offset = 100,
      offset_opacity = 1200,
      scroll_top_duration = 1500,
      $back_to_top = $(".cd-top");

    $(window).on("scroll", function () {
      $(this).scrollTop() > offset ? $back_to_top.addClass("cd-is-visible") : $back_to_top.removeClass("cd-is-visible cd-fade-out");
      if ($(this).scrollTop() > offset_opacity) {
        $back_to_top.addClass("cd-fade-out");
      }
    });

    //smooth scroll to top
    $back_to_top.on("click", function (event) {
      event.preventDefault();
      $("body,html").animate(
        {
          scrollTop: 0,
        },
        scroll_top_duration
      );
    });

    $("#search-icon").click(function () {
      $(".search_box").toggle();
    });

    /*--------------------------
        ACTIVE AOS JS
    ----------------------------*/
    AOS.init({
      once: false,
      duration: 1200,
      mirror: true,
    });
  })(jQuery)
);
