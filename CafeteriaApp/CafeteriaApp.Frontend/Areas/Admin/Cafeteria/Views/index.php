<title>Cafeterias</title>
<?php
include('CafeteriaApp.Frontend/Areas/Admin/layout.php');
 ?>
 <script src="/CafeteriaApp.Frontend/Scripts/admin/cafeteria.js"></script>

 <div id="page-wrapper" style="margin-top:-600px">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Cafeterias</h1>
    </div>
</div>
 <!--  -->

<div class="row" ng-app="myapp">

<div ng-controller="getcafeterias">
<!-- <script>
$("#mymodal").click(function(event){
    $(event.target).modal("hide");
});
</script> -->
 <script type="text/ng-template" id="modal.html">
         <div class="modal fade" id="mymodal" data-backdrop="false" style="background: rgba(0, 0, 0, 0.5)">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Are You Sure You Want To Delete This Cafeteria?</h4>
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
            <div class="panel-heading">
                Manage Your Cafeterias
                <div>
                    <a style="float: right;margin-top: -23px;" title="Add Cafeteria" id="creatNewCafeteria" ng-href="/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/create.php"
                       class="btn btn-success btn-circle"><i class="fa fa-plus"></i></a>
                </div>

            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-cafeteria">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody ng-repeat="c in cafeterias">
                        <tr class="odd gradeX">
                            <td ng-bind="c.Name"></td>

                            <td class="center">
                              <a id="myButton" ng-click="goToEditCafeteriaPage(c.Id)" class="btn btn-success">Edit</a>

                                <button href ng-click="deleteCafeteria(c.Id)" class="btn btn-danger">Delete</button>
<!--                                 <p>{{message}}</p>
 -->                            </td>
                        </tr>

                    </tbody>
                </table>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    </div>
    <!-- /.col-lg-12 -->
</div>
</div>

<!-- /.row -->
<!-- <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Warning !!</h4>
            </div>
            <div class="modal-body">
                <p>Are You Sure You Want To Delete This Cafeteria?.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bind="click:deleteCafeteria">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>

    </div>
</div> -->