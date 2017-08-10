<title>Managing Category</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/editing category and showing and deleting its menuitems.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>

<script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">


<div id="page-wrapper" style="margin-top:-600px">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edit Category</h1>
    </div>
  </div>

  <div ng-app="myapp">
    <div class="row">
      <div class="col-lg-12" ng-controller="editCategory">
        <div class="panel panel-default">
          <div class="panel-heading">Edit Category</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-6">
                <form role="form" name="myform">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required/>
                    <span ng-show="myform.name.$invalid" id="inputControl">Category Name is Required</span>
                    <div><label>Image</label></div>
                    <div class="dropzone" file-dropzone="[image/png, image/jpeg, image/gif]" file="image" file-name=" imageFileName" data-max-file-size="3">
                    </div>
                    <input type="file" fileread="uploadme.src" name="file" id="file" class="inputfile">
                    <div ng-if="uploadme.src != ''">
                      <img ng-src="{{ uploadme.src }}" width="300" height="300">
                    </div>
                    <div ng-if="uploadme.src == ''">
                      <img ng-src="{{ imageUrl }}" width="300" height="300">
                    </div>
                    <br>
                    <button class="btn btn-primary" onclick="mylabel.click()" id="mybutton">Choose image</button><label id="mylabel" for="file"></label>
                  </div>
                  <div class="form-group">
                    <input type = "submit" value = "save" class="btn btn-primary" style="float:right" ng-click="editCategory()">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">MenuItems</h1>
      </div>
    </div>

    
    <div class="row" ng-controller="showingAndDeletingMenuItems">
      <script type="text/ng-template" id="modal.html">
         <div class="modal fade" id="mymodal" style="background: rgba(0, 0, 0, 0.5)">
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
          <div class="panel-heading">Manage Your MenuItems
            <div>
              <a style="float: right;margin-top: -23px;" title="Add MenuItem" id="creatNewCategory" href="/CafeteriaApp.Frontend/Areas/Admin/MenuItem/Views/adding menuitem.php?id={{categoryId}}" target="_self" class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
            </div>
          </div>
          <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-category">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody ng-repeat="m in menuItems">
                <tr class="odd gradeX">
                  <td ng-bind="m.Name"></td>
                  <td ng-bind="m.Price"></td>
                  <td ng-bind="m.Description"></td>
                  <td class="center">
                    <a id="myButton" href="/CafeteriaApp.Frontend/Areas/Admin/MenuItem/Views/editing menuitem.php?id={{m.Id}}" target="_self" class="btn btn-success">Edit</a>
                    <button ng-click="deleteMenuItem(m.Id)" class="btn btn-danger">Delete</button>
                  </td>
                </tr>
              </tbody>
              <tbody>
                <tr ng-show="menuItems.length == 0">
                  <td colspan="5"> There are no records.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
