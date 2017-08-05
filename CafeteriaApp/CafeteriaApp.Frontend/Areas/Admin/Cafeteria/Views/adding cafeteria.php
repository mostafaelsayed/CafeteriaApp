
<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<link href="/CafeteriaApp.Frontend/Scripts/input_file.css" rel="stylesheet">
<script src="/CafeteriaApp.Frontend/Scripts/admin/adding cafeteria.js"></script>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width" />
    <title>Adding Cafeteria</title>
  </head>

  <body>
    <div id="page-wrapper" style="margin-top:-600px">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Create Cafeteria</h1>
        </div>
      </div>
      <div class="row" ng-app="myapp" ng-controller="addCafeteria">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">Adding New Cafeteria</div>

            <div class="panel-body">
              <div class="row">
    	           <div class="col-lg-6">
    		           <form role="form" action="/CafeteriaApp.Backend/Requests/Cafeteria.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
  				           <label>Name</label>
  				           <input type="text" class="form-control" autofocus="autofocus" name="name" id="name" required/>
  				           <label>Image</label>
                     <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name="imageFileName" data-max-file-size="3">
                     </div>
                     <input type="file" fileread="uploadme.src" name="imageToUpload" id="file" class="inputfile">
                     <img ng-src="{{ uploadme.src }}" width="300" height="300">
                     <button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label>   
                    </div>
                    <div class="form-group">
  				           <input type = "submit" value = "save" class="btn btn-primary" style="float:right">
                    </div>
    		           </form>
    	           </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
