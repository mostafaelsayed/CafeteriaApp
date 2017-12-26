		<link rel="stylesheet" type="text/css" href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/css/footer.css">

		<!-- Advertisments -->
		<div id="ads">

			<img style="width: 200px;height: 200px" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/footerIcons/hotOffer.jpg" />

			<a href="">Go to offer</a>

		</div>

		<!-- feedback form -->
		<?php $x = rand(0, 20);$y = rand(0, 20);?>

		<div ng-controller="feedback" class="background" ng-init="result = <?php echo ($y + $x); ?>">

			<div id="feedbackForm">

				<form method="post" action="feedback form.php">

					<div class="entry">

						<label for="name">Name:</label>

						<input type="text" id="name" ng-model="name" required />

					</div>

					<div class="entry">

						<label for="mail">Email:</label>

						<input type="mail" id="mail" ng-model="mail" required />

					</div>

					<div class="entry">

						<label for="phone">Phone:</label>

						<input type="text" id="phone" ng-model="phone" required />

					</div>

					<div class="entry">

						<label for="about">About:</label>

						<select id="about" ng-model="selectedAbout" ng-options="a.Name for a in abouts" ></select>

					</div>
					
					<div class="entry">

						<h4 style="margin: 0px;padding-left: 50px;color: red"> <?php echo $x ; ?>+<?php echo $y;?> =</h4>

						<label for="check" style="float: left">Answer:</label>

						<input type="text" id="check" name="check" ng-model="answer" required />

					</div>

					<div class="entry">

						<label for="message" style="float: left">Message:</label>

						<textarea id="message" ng-model="message" required></textarea>

					</div>

					<input ng-click="addFeedback(name, mail, phone, selectedAbout, message, answer)" type="submit" id="submitbtn" value="Submit" name="submit" style="height: 30px;width: 100px;color: white;background-color: #7FC27F;font-weight: bold;margin-left: 30px">
					<h4 style="color: yellow" ng-cloak ng-show="success">Thanks, your feedback has submitted !</h4>
					<h4 style="color: red" ng-cloak ng-show="failure">Sorry, we couldn't get your feedback .try later.</h4>
					<h4 style="color: red" ng-cloak ng-show="SummationWrong">Summation is wrong, try again.</h4>

				</form>

			</div>

		</div>

		<!-- Other Links -->

		<div class="footer"> 

			<div class="footerLinks">

				<ul id="followUs">

					<h4>Follow Us</h4>

					<li>

						<a style="color: #475993" href="#"><img class="footerImage" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/footerIcons/facebook.png">Facebook</a>

					</li>

					<li>

						<a style="color: #76A9EA" href="#"><img class="footerImage" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/footerIcons/twitter.png">Twitter</a>

					</li>

					<li>

						<a style="color: #F34A38" href="#"><img class="footerImage" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/footerIcons/google-plus.png">Google+</a>

					</li>

					<li>

						<a style="color: #F61C0D" href="#"><img class="footerImage" src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/footerIcons/youtube.png">YouTube</a>

					</li>

				</ul>

				<ul>

					<h4>News</h4>

					<li><a href="#">ssss</a></li>

					<li><a href="#">ssssss</a></li>

					<li><a href="#">sssssssss</a></li>

					<li><a href="#">ssssss</a></li>
					
				</ul>

				<ul>

					<h4>Contact us</h4>

					<!-- show a form for feedback like ads -->
					<li>

						<a onclick="displayForm()" style="cursor: pointer">Send Feedback</a>

					</li>

					<li>Phone:</li>

					<li>+201016415791</li>

					<li>Email:</li>

					<li>mm_h434@yahoo.com</li>

				</ul>

				<ul>

					<h4>About us</h4>

					<li>

						<a href="#">Our History</a>

					</li>

					<li>

						<a href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/gallery.php">Our Gallery</a>

					</li>

					<li>

						<a href="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/Branches.php">Our Branches</a>

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

<script src="/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/javascript/feedback.js"></script>