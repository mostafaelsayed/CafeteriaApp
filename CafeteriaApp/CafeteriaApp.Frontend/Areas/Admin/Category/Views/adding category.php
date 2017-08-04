<title>Adding Category</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<div id="page-wrapper" style="margin-top:-600px">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Create Category</h1>
    </div>
  </div>

  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">Adding New Category</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-6">
            <form role="form">
              <label>Name</label>
              <input type="text" class="form-control" data-bind="textInput:categoryName" autofocus="autofocus" name="name" id="name" required/>
              <label>Image</label>
              <div data-bind="fileDrag: fileData">
                <div class="image-upload-preview" data-bind="if: chooseImageClicked()==0">
                  <img width="370" height="266" data-bind="attr: { src: categoryImage }">
                </div>
                <div class="image-upload-preview" data-bind="if: chooseImageClicked()==1">
                  <img width="370" height="266" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                </div>
                <div class="image-upload-input" id="file">
                  <input name="imageToUpload" type="file" data-bind="fileInput: fileData,customFileInput: {}">
                </div>
              </div>
              <input type = "submit" value = "save" class="btn btn-primary" style="float:right" data-bind="click:addCategory">
            </form>
          </div>
        </div>
      </div>
    </div>
   </div>

 </div>
 <script src="/CafeteriaApp.Frontend/Scripts/admin/adding category.js"></script>
 <script>
   var app = new categoryNewViewModel();
   ko.applyBindings(app);
 </script>
