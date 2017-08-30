<style type="text/css">
	
	.footer{
		font-weight: bold;
		text-align: center;
		color: white;
		margin-top: 100px;
		/*border:5px solid black;*/
		/*height: 300px;*/
	}

	.footerLinks ul{
		list-style: none;
		float: left;
		/*margin: 0 auto;*/
		text-align: left;
		margin-left: 100px; 
		/*line-height: 20px;*/
		/*width: 33.333333%;*/
	}

.footerLinks a{
		text-decoration: none;
	}

.footerLinks img{
		width: 45px;
		height: 45px;
		padding-right: 10px; 
		padding-top: 10px; 
		/*overflow: hidden;*/

	}


#followUs li:{
	/*position: absolute;
	top: 10px;*/
	   /*display: block;*/
		padding-top: 10px;
		padding-bottom: 10px;
		 height : 25px;
}

#followUs li:hover{
/*margin: 0px 0px 0px 20px;*/
transform: scale(1.4);
transition: 0.3s;

}

#ads{
    width: 100px;
    height: 100px;
    background: red;
    position :absolute;
    /*-webkit-animation: mymove 5s infinite; /* Safari 4.0 - 8.0 */
    animation: mymove 1.5s ;
    left: 30px;
    top: 100px;
}

@keyframes mymove {

    0%  {top: 600px;}
   /* 25%  {top: 200px;}
    75%  {top: 50px}*/
    100% {top: 100px;}
}
</style>


<div id="ads"  >
	<img style="width:200px;height:200px;" src="/CafeteriaApp.Frontend/footerIcons/hotOffer.jpg">
	<a href="">Go to offer</a>
</div>


<div class="footer"> 

<div class="footerLinks">

<ul id="followUs">
<h4>Follow Us</h4>
	<li><a style="color: #475993;" href="#"><img class="footerImage" src="/CafeteriaApp.Frontend/footerIcons/facebook.png">Facebook</a></li>
	<li><a style="color: #76A9EA;" href="#"><img  class="footerImage" src="/CafeteriaApp.Frontend/footerIcons/twitter.png">Twitter</a></li>
	<li><a  style="color: #F34A38;" href="#"><img  class="footerImage" src="/CafeteriaApp.Frontend/footerIcons/google-plus.png">Google+</a></li>
	<li><a  style="color: #F61C0D;" href="#"><img class="footerImage" src="/CafeteriaApp.Frontend/footerIcons/youtube.png">YouTube</a></li>

</ul>

<ul><h4>News</h4>
	<li><a href="#">ssss</a></li>
	<li><a href="#">ssssss</a></li>
	<li><a href="#">sssssssss</a></li>
	<li><a href="#">ssssss</a></li>
	
</ul>
<ul>
	<h4>Contact us</h4>
	<!-- show a form for feedback like ads -->
	<li><a href="#">Send Feedback</a></li>
	<li>Phone:</li>
	<li>+201016415791</li>
	<li>Email:</li>
	<li>mm_h434@yahoo.com</li>
</ul>

<ul>
	<h4>About us</h4>
	<li><a href="#">Our History</a></li>
	<li><a href="#">Our Story</a></li>
	
</ul>
</div>

<div class="break"></div>
<div style="margin-top: 30px;">
	Copyright &copy;<?php echo date("Y"); ?>, Restaurant
</div>

</div>

 </body>

</html>

<script type="text/javascript">
	
// $(".footerLinks a").mouseover(function() {
//     $(".footerImage").css({ width: '50px', height: '50px' });
// }).mouseout(function() {
//    $(".footerImage").css({ width: '45px', height: '45px' });
// });

</script>