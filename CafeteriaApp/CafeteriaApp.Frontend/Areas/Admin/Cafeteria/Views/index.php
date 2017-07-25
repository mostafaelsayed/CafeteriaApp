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

<div class="row" ng-app="myapp" ng-controller="getcafeterias">
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
                              <a id="myButton" ng-click="editCafeteria(c.Id)" class="btn btn-success">Edit</a>

                                <!-- <button type="button" id="myButton" ng-click="editCafeteria(c.Id)" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Delete</button> -->
                            </td>
                        </tr>

                    </tbody>
                </table>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
</div>

<!-- /.row -->
