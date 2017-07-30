<title>Adding Category</title>
<?php
include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/admin/category.js"></script>
 <div id="page-wrapper" style="margin-top:-600px">
 <div class="row">
     <div class="col-lg-12">
         <h1 class="page-header">Create Category</h1>
     </div>
     <!-- /.col-lg-12 -->
 </div>

 <div class="row" ng-app="myapp" ng-controller="addCategory">
     <div class="col-lg-12">
         <div class="panel panel-default">
             <div class="panel-heading">
                 Adding New Category
             </div>
             <div class="panel-body">
                 <div class="row">
                     <div class="col-lg-6">
                         <form role="form">
                             <div class="form-group" >
                                 <label>Name</label>
                                 <input type="text" class="form-control" autofocus="autofocus" ng-model="Name" name="name" id="name"  required>
                             </div>
                             <!-- <div data-bind="fileDrag: fileData">
                                 <div class="image-upload-preview">
                                     <img width="370" height="266" data-bind="attr: { src: fileData().dataURL }, visible: fileData().dataURL">
                                 </div>
                                 <div class="image-upload-input">
                                     <input type="file" data-bind="fileInput: fileData,customFileInput: {}">
                                 </div>
                             </div> -->
                             <div class="form-group" style="float: right">
                                 <button ng-click="addCategory()" class="btn btn-primary">Save</button>
                                 <!-- <button data-bind="click:cancel" class="btn btn-danger">Cancel</button> -->
                             </div>
                         </form>
                     </div>
                 </div>

             </div>
         </div>
     </div>
   </div>
 </div>
 <!-- <script>

     var app = new CategoryNewViewModel(@ViewBag.cafeteriaId);
     ko.applyBindings(app);
 </script> -->
