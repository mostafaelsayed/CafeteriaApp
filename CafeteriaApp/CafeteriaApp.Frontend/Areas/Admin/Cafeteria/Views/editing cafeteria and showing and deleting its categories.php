<title>Managing Cafeteria</title>

<?php
 require_once("CafeteriaApp.Backend/functions.php"); 
   validatePageAccess($conn);
  include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
?>

<script src="/CafeteriaApp.Frontend/javascript/editing cafeteria and showing and deleting its categories.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/modal_controller.js"></script>
<script src="/CafeteriaApp.Frontend/javascript/modal.js"></script>

<link href="/CafeteriaApp.Frontend/css/input_file.css" rel="stylesheet">

<div>

  <div class="row">
    <div>
      <h1 class="page-header">Edit Cafeteria</h1>
    </div>
  </div>

  <div class="row" ng-app="myapp">
    <div ng-controller="editCafeteria">
      <div>
        <div>
          <div class="row">
            <div>
              <form novalidate role="form" name="myform" id="centerBlock">
                <div class="form-group">
                  <label>Name</label>
                  <input id="inputField" type="text" class="form-control" ng-model="name" autofocus="autofocus" name="name" required/>
                  <span ng-show="myform.name.$invalid && myform.name.$touched" id="inputControl">Cafeteria Name is Required<br></span><br>
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
                  <input type = "submit" value = "save" class="btn btn-primary" ng-click="editCafeteria()">
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div>
      <h1 class="page-header">Categories</h1>
    </div>
  </div>

  <div class="row" ng-controller="showingAndDeletingCategories">
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

   <div>
     <div>
       <div><h3>Manage Your categories</h3>
         <div>
           <a id="add" title="Add Category" href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/adding category.php?id={{cafeteriaId}}" target="_self" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
         </div>
       </div>
       <div>
         <table width="50%" class="table table-bordered">
           <thead>
             <tr>
               <th id="alignText">Name</th>
               <th id="alignText">Actions</th>
             </tr>
           </thead>
           <tbody ng-repeat="c in categories">
             <tr>
               <td id="alignText" ng-bind="c.Name"></td>
               <td id="alignText" class="center">
                 <a id="myButton" href="/CafeteriaApp.Frontend/Areas/Admin/Category/Views/editing category and showing and deleting its menuitems.php?id={{c.Id}}" target="_self">Edit</a>&nbsp;
                 <a style="cursor: pointer" ng-click="deleteCategory(c.Id)">Delete</button>
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
