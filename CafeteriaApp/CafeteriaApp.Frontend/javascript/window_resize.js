console.log($(window).width());

function onResize(e) {

  if ($(window).width() <= 1210) {
    if ($(".dropdown").length == 0) {
      $("#dropdownbutton").css("display","inline");
      $(".inner").wrapAll("<ul class='dropdown-menu' id='dropdownmenu' />");
      $(".inner,#dropdownbutton").wrapAll("<li class='dropdown' />");
    }
  }

  if ($(window).width() > 1210) {
    if ($(".dropdown").length != 0) {
      $(".inner,#dropdownbutton").unwrap($(".dropdown"));
      $(".inner").unwrap($("#dropdownmenu"));
      $("#dropdownbutton").css("display","none");
    }
  }

}

$(window).on("resize",function(e) {
  onResize(e);
});

// $(window).on("load",function(e) {
//   onResize();
// });