<!DOCTYPE html>

<html>

  <head>

    <title>Register</title>

    <meta name="viewport" charset="UTF-8" content="width=device-width, initial-scale=1.0" />

    <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Anton"> -->

    <link rel="icon" href="../favicon.ico">

    <link rel="stylesheet" type="text/css" href="css/materialize.css" />

    <link href="css/input_file.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="icons/icons.css" />

    <link href="css/errors.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="css/register.css" />

    <!-- replace with the minimized version in production -->
    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- replace with the minimized version in production -->
    <script src="js/angular.min.js"></script>

    <script src="js/newjavascript.js"></script>

    <script src="js/materialize.js"></script>

    <script src="js/image_module.js"></script>

    <script type="text/javascript" src="js/register_form_validation.js"></script>

    <script type="text/javascript">

      angular.module('registerApp', ['image', 'registerFormValidation']).controller('registerController', ['$scope', function($scope) {
          $scope.image = {};
          $scope.image.src = '';
      }]);
      
    </script>

  </head>

  <style type="text/css">

    .errorMes {
      color: red;
    }

    label {
      font-family: 'Anton';
    }
    
  </style>

  <body style="background-image: url('');background-repeat: no-repeat;background-size: cover">

    <div>

      &nbsp;

    </div>
    
    <h2 style="text-align: center;color: violet">New User</h2>

    <div ng-app="registerApp" ng-controller="registerController" class="row">

      <form ng-cloak novalidate role="form" name="myform" style="width: 40%;margin: auto;text-align: center" enctype="multipart/form-data" method="post" action="../CafeteriaApp.Backend/Requests/User.php">

        <div class="input-field col s12">

          <label>First Name</label>

          <input type="text" name="firstName" ng-model="firstName" style="text-align: center" required />

          <span class="errorMes" ng-show="myform.firstName.$touched && myform.firstName.$invalid">First Name is Required</span>

        </div>

        <div class="input-field col s12">

          <label>Last Name</label>

          <input type="text" name="lastName" ng-model="lastName" style="text-align: center" required />

          <span class="errorMes" ng-show="myform.lastName.$touched && myform.lastName.$invalid">Last Name is Required</span>

        </div>

        <div class="input-field col s12">

          <label>E-mail</label>

          <input check type="email" name="email" ng-model="email" style="text-align: center" required />

          <span class="errorMes" ng-show="myform.email.$touched && myform.email.$invalid && !myform.email.$error.emailExisted">Email is Required</span>
          <span class="errorMes" ng-show="myform.email.$touched && myform.email.$error.emailExisted">Email already existed</span>

        </div>

        <div class="input-field col s12">

          <label>Password</label>

          <input check type="password" name="password" ng-model="password" style="text-align: center" required />

          <span class="errorMes" ng-show="myform.password.$touched && myform.password.$invalid && !myform.password.$error.checkPassword">Password is Required</span>
          <span class="errorMes" ng-show="myform.password.$touched && myform.password.$error.checkPassword">Password is Invalid. It must contain at least one lowercase letter, one uppercase letter and one digit</span>

        </div>

        <div class="input-field col s12">

          <label>Phone Number</label>

          <input type="text" check name="phone" ng-model="phone" style="text-align: center" required />

          <span class="errorMes" ng-show="myform.phone.$touched && myform.phone.$invalid && !myform.phone.$error.checkPhoneNumber">Phone Number is Required</span>
          <span class="errorMes" ng-show="myform.phone.$touched && myform.phone.$error.checkPhoneNumber">Phone Number is Invalid. It must has 11 digits starting with 01</span>

        </div>

        <div class="input-field col s12">

          <input check name="DOB" type="date" ng-model="DOB" class="datepicker" required />

          <label>Date of Birth</label>

          <span class="errorMes" ng-show="myform.DOB.$touched && myform.DOB.$invalid">Date of Birth is Required</span>

        </div>

        <div><br><br></div>

        <label class="labels" style="font-size: 16px">Gender</label>

        <br><br>

        <input class="with-gap" name="gender" ng-model="gender" type="radio" value="0" id="male" required />

        <label for="male">Male</label>

        <br>

        <input class="with-gap" name="gender" ng-model="gender" type="radio" value="1" id="female" required />

        <label for="female" style="margin-right: -17px">Female</label>

        <span class="errorMes" ng-show="myform.gender.$touched && myform.gender.$invalid">Gender is Required</span>

        <br>

        <div class="image-button">

          <label for="file" class="inside-image-label" onclick="event.preventDefault();$('#file').trigger('click')">Choose Image</label>

        </div>

        <!-- let user decide whether to crop or not -->
        <!-- <button onclick="event.preventDefault();crop();">Crop Image</button> -->

        <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">

          <input type="file" id="file" name="image" class="inputfile" onchange="readURL(this)">

          <div id="container">

            <img id="image">

            <div id="cont"><img id="inner" /></div>

          </div>

        </div>

        <input type="hidden" name="x1" value="" />
        <input type="hidden" name="y1" value="" />
        <input type="hidden" name="x2" value="" />
        <input type="hidden" name="y2" value="" />
        <input type="hidden" name="w" value="" />
        <input type="hidden" name="h" value="" />

        <input ng-if="myform.$invalid" type="button" name="submit" style="margin-left: -50px" class="btn btn-primary" value="Next" />
        
        <input ng-if="myform.$valid" type="submit" name="submit" style="margin-left: -50px" class="btn btn-primary" value="Next" />
        
      </form>

    </div>

    <br>

  </body>

</html>

<style type="text/css">
  #cont {
    width: 150px;
    height: 150px;
    overflow: hidden;
    float: right;
    position: relative,
  }
  #image {
    max-width: 100%;
    max-height: 100%;
  }
  #container {
    width: 400px;
    height: 300px;
  }
</style>


<!-- <script type="text/javascript" src="js/tapmodo-Jcrop-1902fbc/js/jquery.Jcrop.js"></script> -->



<!-- <link rel="stylesheet" type="text/css" href="js/node_modules/croppie/croppie.css">
<script type="text/javascript" src="js/node_modules/croppie/croppie.js"></script> -->



<!-- <script src="js/node_modules/cropperjs/dist/cropper.js"></script>
<link href="js/node_modules/cropperjs/dist/cropper.css" rel="stylesheet">
<script src="js/node_modules/jquery-cropper/dist/jquery-cropper.js"></script> -->



<link rel="stylesheet" type="text/css" href="js/jquery.imgareaselect-0.9.10/css/imgareaselect-default.css" />
<script type="text/javascript" src="js/jquery.imgareaselect-0.9.10/scripts/jquery.imgareaselect.pack.js"></script>


<script type="text/javascript">
  function readURL(input) {
    var file = input.files[0];

    if (input.files && file) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#image').attr('src', e.target.result);
              $('#inner').attr('src', e.target.result)
          };

          reader.readAsDataURL(file);
      }
  }


// // jquery cropper

// var cropper = 0;
// var newWidth = 0;
// var newHeight = 0;
// var newX = 0;
// var newY = 0;
// var $image = $('#image');
// var croppedCanvas = 0;

// document.getElementById('image').onload = function() {
//   console.log(1);
//   $image.cropper({
//     preview: '.preview',
//     // aspectRatio: 16 / 9,
//     crop: function(event) {
//       // console.log(event.detail.x);
//       // console.log(event.detail.y);
//       // console.log(event.detail.width);
//       // console.log(event.detail.height);
//       // console.log(event.detail.rotate);
//       // console.log(event.detail.scaleX);
//       // console.log(event.detail.scaleY);
//       // var cropper = $image.data('cropper');
//       // console.log(cropper.originalUrl == cropper.url);
//       // console.log();
//       //cropper = $image.data('cropper');
//       // console.log(cropper);
//       newX = event.detail.x;
//       newY = event.detail.y;
//       newWidth = event.detail.width;
//       newHeight = event.detail.height + 4;
//       // croppedCanvas = cropper.getCroppedCanvas();
//       // console.log(croppedCanvas);
//       $('.preview').css({ 
//         // setting width to $image.width() sets the 
//         // starting size to the same as orig image
//         width:    '100%',   
//         overflow: 'hidden',
//         height:    newHeight,
//         maxWidth:  newWidth,
//         maxHeight: newHeight
//       });

//       console.log($('.preview'));

//     }
//   });

//   cropper = $image.data('cropper');
//   // cropper.crop();
//   // console.log(cropper);
//   // Get the Cropper.js instance after initialized

// }



// imgAreaSelect

document.getElementById('image').onload = function() {
  console.log(1);
    $('#image').imgAreaSelect({
      aspectRatio: "1:1",
      handles: true,
      //show: true,
      onSelectChange: changePreview,
      onSelectEnd: setCoords
    });
  }

  function setCoords(img, selection) {
    $('input[name="x1"]').val(selection.x1);
    $('input[name="y1"]').val(selection.y1);
    $('input[name="x2"]').val(selection.x2);
    $('input[name="y2"]').val(selection.y2);
    $('input[name=w]').val(selection.width);
    $('input[name=h]').val(selection.height);

    console.log(selection);
  }

  function changePreview(img, selection) {
    if (!selection.width || !selection.height) {
      return;
    }

    var scaleX = 150 / (selection.width || 1);
    var scaleY = 150 / (selection.height || 1);

    $('#inner').css({
      width: Math.round(scaleX * $('#image').width()) + 'px',
      height: Math.round(scaleY * $('#image').height()) + 'px',
      marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
      marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
    });
  }
</script>