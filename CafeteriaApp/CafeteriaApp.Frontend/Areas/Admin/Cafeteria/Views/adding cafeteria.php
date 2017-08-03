
<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

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
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading">Adding New Cafeteria</div>

            <div class="panel-body">
              <div class="row">
    	           <div class="col-lg-6">
    		           <form role="form" action="/CafeteriaApp.Backend/Requests/Cafeteria.php" method="POST" enctype="multipart/form-data">
  				           <label>Name</label>
  				           <input type="text" class="form-control" autofocus="autofocus" name="name" id="name" required/>
  				           <label>Image</label>
                     <div data-bind="fileDrag: fileData">
                       <div class="image-upload-preview">
                         <img width="370" height="266" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                       </div>
                       <div class="image-upload-input">
                         <input name="imageToUpload" type="file" data-bind="fileInput: fileData,customFileInput: {}">
                       </div>
                     </div>
  				           <input type = "submit" value = "save" style="float:right">
    		           </form>
    	           </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="/CafeteriaApp.Frontend/Scripts/admin/adding cafeteria.js"></script>
  <script>
    var app = new cafeteriaNewViewModel();
    ko.applyBindings(app);
  </script>
</html>
