<!DOCTYPE html>
<html>
<head>
	<title></title>

<style type="text/css">
		

body {
  overflow: hidden;
  perspective: 1000px;
}

.funky-show-hide.ng-hide-add {
  transform: rotateZ(0);
  transform-origin: right;
  transition: all 0.5s ease-in-out;
}

.funky-show-hide.ng-hide-add.ng-hide-add-active {
  transform: rotateZ(-135deg);
}

.funky-show-hide.ng-hide-remove {
  transform: rotateY(90deg);
  transform-origin: left;
  transition: all 0.5s ease;
}

.funky-show-hide.ng-hide-remove.ng-hide-remove-active {
  transform: rotateY(0);
}

.check-element {
  border: 1px solid black;
  opacity: 1;
  padding: 10px;
}

	</style>
      <script src="//code.angularjs.org/snapshot/angular.min.js"></script>
  <script src="//code.angularjs.org/snapshot/angular-animate.js"></script> 

</head>

<body ng-app="ngAnimate">
  Show: <input type="checkbox" ng-model="checked" aria-label="Toggle ngShow"><br />
<div class="check-element funky-show-hide" ng-show="checked">
  I show up when your checkbox is checked.
</div>
</body>
</html>

<script type="text/javascript">

 //var app = angular.module('myApp', [require('angular-animate')]);



it('should check ngShow', function() {
  var checkbox = element(by.model('checked'));
  var checkElem = element(by.css('.check-element'));

  expect(checkElem.isDisplayed()).toBe(false);
  checkbox.click();
  expect(checkElem.isDisplayed()).toBe(true);
});

</script>