<link rel="stylesheet" type="text/css" href="../css/footer.css">

		<!-- Advertisments -->
		<!-- <div id="ads">
			<a href="">
			<img style="width: 200px;height: 200px" src="../footerIcons/hotOffer.jpg" />
			Get offer
		</a> 
		</div>-->

		<!-- feedback form -->
	<?php require(__DIR__.'/feedback.php'); ?>

		<!-- footer Links -->
		<div class="footer"> 
			<div class="footerLinks">
				<ul id="followUs">
					<h4>Follow Us</h4>
					<li>
						<a style="color: #475993" href="#"><img class="footerImage" src="../footerIcons/facebook.png">Facebook</a>
					</li>

					<li>
						<a style="color: #76A9EA" href="#"><img class="footerImage" src="../footerIcons/twitter.png">Twitter</a>
					</li>

					<li>
						<a style="color: #F34A38" href="#">
							<img class="footerImage" src="../footerIcons/google-plus.png">
							Google+
						</a>
					</li>

					<li>
						<a style="color: #F61C0D" href="#">
							<img class="footerImage" src="../footerIcons/youtube.png">
							YouTube
					</a>

					</li>

				</ul>

				<ul>
					<h4>News</h4>
					<li><a href="#">New Food</a></li>
					<li><a href="#">Offers up to -20%</a></li>
					<li><a href="#">sssssssss</a></li>
					<li><a href="#">ssssss</a></li>
				</ul>

				<ul>
					<h4>Contact us</h4>
					<!-- show a form for feedback like ads -->
					<li>
						<a onclick="displayForm()" style="cursor: pointer">Send Feedback
						</a>
					</li>
					<li>Phone:</li>
					<li><b>+201016415791</b></li>
					<li>Email:</li>
					<li><b>mm_h434@yahoo.com</b></li>
				</ul>

				<ul>
					<h4>About us</h4>
					<li>
						<a href="#">
						Our History
						</a>
					</li>

					<li>
						<a href='<?=__DIR__.'/gallery.php'?>' >
						Our Gallery
						</a>

					</li>

					<li>
						<a href='<?=__DIR__.'/Branches.php'?>'>
						Our Branches
						</a>
					</li>

				</ul>

			</div>

			<div class="break"></div>

			<div style="margin-top: 30px">
				Copyright &copy;<?php echo date("Y"); ?>, Restaurant
			</div>

		</div>

	</body>
</html>