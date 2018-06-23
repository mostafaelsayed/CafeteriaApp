<?php
  require_once(__DIR__ . '/Customer/layout.php');
?>

<link href="/css/magnific-popup.css" rel="stylesheet" type="text/css">

<style type="text/css">
	.images{
		width: 250px;
		height: 250px
	}

  html {
    font-family: helvetica, arial, sans-serif;
  }

  #images{
  	list-style: none;
  }
  #images>li{
  	  float: right;
  	  margin:50px; 
  }
  /* relevant styles */
  .img__wrap {
    position: relative;
    height: 250px;
    width: 250px;

  }

  .img__description_layer {
    position: absolute;
  /*  top: 80;
    bottom: 80;*/
    left: 0;
    right: 0;
    background: rgba(36, 62, 206, 0.6);
    color: #fff;
    visibility: hidden;
    opacity: 0;
    display: flex;
    align-items: center;/*Center the alignments for all the items of the flexible <div> element:*/
    justify-content: center;/*Make some space around the items of the flexible <div> element*/

    /* transition effect. not necessary */
    transition: opacity .3s, visibility .2s;
  }

  .img__wrap:hover .img__description_layer {
    visibility: visible;
    opacity: 1;
  }

  .img__description {
    transition: .2s;
    transform: translateY(1em);
  }

  .img__wrap:hover .img__description {
    transform: translateY(0);
  }





  .mfp-with-zoom .mfp-container,
  .mfp-with-zoom.mfp-bg {
    opacity: 0;
    -webkit-backface-visibility: hidden;
    /* ideally, transition speed should match zoom duration */
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }

  .mfp-with-zoom.mfp-ready .mfp-container {
      opacity: 1;
  }
  .mfp-with-zoom.mfp-ready.mfp-bg {
      opacity: 0.8;
  }

  .mfp-with-zoom.mfp-removing .mfp-container,
  .mfp-with-zoom.mfp-removing.mfp-bg {
    opacity: 0;
  }

  /*.mfp-container.mfp-s-ready.mfp-image-holder{
  	cursor: default;
  }*/

  /*a { cursor: -webkit-zoom-in;  cursor: zoom-in; }*/

</style>

<ul id="images">

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig4.jpg" data-group="1" class="galleryItem test123"><img src="/images/bbig4.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a>
</div>
</li>


<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>

<li>
<div class="img__wrap">
 <a href="/images/bbig3.jpg" data-group="1" class="galleryItem test"><img src="/images/bbig3.jpg" class="images">
  <div class="img__description_layer">
    <p class="img__description">This image looks super neat.</p>
  </div>
  </a> 
</div>
</li>
</ul>
<div class="break"></div>

<!--  <ol type="1">
 	<li></li>
	<li></li>
 </ol>

  <ol type="I">
 	<li></li>
	<li></li>
 </ol>

 <ol type="A">
 	<li></li>
	<li></li>
 </ol> -->
<?php require_once(__DIR__ . '/Public/footer.php'); ?>
<script src="/javascript/jquery-3.2.1.min.js"></script>
<script src="/javascript/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
  var groups = {};

  $('.galleryItem').each(function() {
    var id = parseInt($(this).attr('data-group'), 10);
    
    if(!groups[id]) {
      groups[id] = [];
    } 
    
    groups[id].push( this );
  });

  $.each(groups, function() {
    $(this).magnificPopup({
      type: 'image',
      closeOnContentClick: true,
      closeBtnInside: false,
      gallery: { enabled:true },
      mainClass: 'mfp-with-zoom', // this class is for CSS animation below

      zoom: {
        enabled: true, // By default it's false, so don't forget to enable it
        duration: 300, // duration of the effect, in milliseconds
        easing: 'ease-in-out', // CSS transition easing function

        // The "opener" function should return the element from which popup will be zoomed in
        // and to which popup will be scaled down
        // By defailt it looks for an image tag:
        opener: function(openerElement) {
          // openerElement is the element on which popup was initialized, in this case its <a> tag
          // you don't need to add "opener" option if this code matches your needs, it's defailt one.
          return openerElement.is('img') ? openerElement : openerElement.find('img');
        }
      }
    })
  });
</script>