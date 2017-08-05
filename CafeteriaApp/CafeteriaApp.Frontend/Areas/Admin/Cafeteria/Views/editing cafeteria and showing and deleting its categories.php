<title>Managing Cafeteria</title>

<?php
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/Scripts/admin/editing cafeteria and showing and deleting its categories.js"></script>
<link href="/CafeteriaApp.Frontend/Scripts/input_file.css" rel="stylesheet">

<div id="page-wrapper" style="margin-top:-600px">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edit Cafeteria</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp">
    <div class="col-lg-12" ng-controller="editCafeteria">
      <div class="panel panel-default">
        <div class="panel-heading">Edit Cafeteria</div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-6">
              <form role="form">
                <label>Name</label>
                <input type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" id="name" required/>
                <label>Image</label>
                <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                  </div>
                  <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                  <div ng-if="uploadme.src != ''">
                    <img ng-src="{{ uploadme.src }}" width="300" height="300">
                  </div>
                  <div ng-if="uploadme.src == ''">
                    <img ng-src="{{ imageUrl }}" width="300" height="300">
                  </div>
                  <button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label>
                <input type = "submit" value = "save" class="btn btn-primary" style="float:right" ng-click="editCafeteria()">
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Categories</h1>
    </div>
  </div>

  <div class="row" ng-controller="showingAndDeletingCategories">
    <script type="text/ng-template" id="modal.html">
      <div class="modal fade" id="mymodal" data-backdrop="false" style="background: rgba(0, 0, 0, 0.5)">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Are You Sure You Want To Delete This Category?</h4>
            </div>
            <div class="modal-body">
              <p>It's your call...</p>
            </div>
            <div class="modal-footer">
              <button type="button" ng-click="close('No')" class="btn btn-default" data-dismiss="modal">No</button>
              <button type="button" ng-click="close('Yes')" class="btn btn-primary" data-dismiss="modal">Yes</button>
            </div>
          </div>
        </div>
      </div>
   </script>

   <div class="col-lg-12">
     <div class="panel panel-default">
       <div class="panel-heading">Manage Your categories
         <div>
           <a style="float: right;margin-top: -23px;" title="Add Category" id="creatNewCategory" target="_self" ng-href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/adding category.php?id={{cafeteriaId}}"class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
         </div>
       </div>
       <div class="panel-body">
         <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-category">
           <thead>
             <tr>
               <th>Name</th>
               <th>Actions</th>
             </tr>
           </thead>
           <tbody ng-repeat="c in categories">
             <tr class="odd gradeX">
               <td ng-bind="c.Name"></td>
               <td class="center">
                 <a id="myButton" ng-href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/editing category and showing and deleting its menuitems.php?id={{c.Id}}" target="_self" class="btn btn-success">Edit</a>
                 <button ng-click="deleteCategory(c.Id)" class="btn btn-danger">Delete</button>
               </td>
             </tr>
           </tbody>
           <tbody>
             <tr ng-show="categories.length == 0">
               <td colspan="5"> There are no records.</td>
             </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
  </div>

</div>
