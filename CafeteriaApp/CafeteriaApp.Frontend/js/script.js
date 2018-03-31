/*global alert, console, $, WOW */
/* Enactus|MSA official Website */
/* *********************************Enactus|MSA IT Team*************************************** */
/* Powerd by Enactus|MSA IT Team */
/* 2017 */
/* Start Script */
$(document).ready(function () {
    "use strict";
    $('.main-carousel').carousel({
        interval: 6000 //6 Seconds
    });
    
    // Instantiate the Bootstrap carousel
    $('.company-carousel').carousel({
        interval: 2500 //2.5 Seconds
    });
    
    $('.carousel-Testimonials').carousel({
        interval: 4000 //4 Seconds
    });
    
// for every slide in carousel, copy the next slide's item in the slide.
// Do the same for the next, next item.
    // latest post slider call 
    /* Start tooltip */
    $('[data-toggle="tooltip"]').tooltip();
    /* Start liScroll */
    $("ul#ticker01").liScroll();
    /* Start WOW */
    new WOW().init();
    /* Start Nice Scroll */
    $('php').niceScroll({
        cursorcolor : '#26a69a',
        cursorborder: '1px solid #FFF',
        hidecursordelay: 0,
        autohidemode: false,
        horizrailenabled: false,
        cursorwidth: 12,
        cursorborderradius: 3
    });
    $(".loading-overlay .cssload-thecube").fadeOut(5000, function () {
        // Show The Scroll
        $("body").css("overflow", "auto");

        $(this).parent().fadeOut(5000, function () {

            $(this).remove();
        });
    });
    
});