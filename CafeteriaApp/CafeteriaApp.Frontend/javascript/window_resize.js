//console.log($(window).width());

// function onResize(e) {

//   if ($(window).width() <= 1210) {
//     if ($(".dropdown").length == 0) {
//       $("#dropdownbutton").css("display","inline");
//       $(".inner").wrapAll("<ul class='dropdown-menu' id='dropdownmenu' />");
//       $(".inner,#dropdownbutton").wrapAll("<li class='dropdown' />");
//     }
//   }

//   if ($(window).width() > 1210) {
//     if ($(".dropdown").length != 0) {
//       $(".inner,#dropdownbutton").unwrap($(".dropdown"));
//       $(".inner").unwrap($("#dropdownmenu"));
//       $("#dropdownbutton").css("display","none");
//     }
//   }

// }

// $(window).on("resize",function(e) {
//   //onResize(e);
// });

// // $(window).on("load",function(e) {
// //   onResize();
// // });

$(document).ready(function() {
  var c = 0;
  $("#mybutton").on('click',function() {
    // if (c == 0) {
    //   $('.navbar-right').css('margin-top','-197px');
    //   c = 1;
    // }
    // else if (c == 1) {
    //   $('.navbar-right').css('margin-top','-45px');
    //   c = 0;
    // }
  })
 // $('.navbar-collapse').on('show.bs.collapse',function() {
 //  $('.navbar-right').css('margin-top','-70px');
 // })

});
