<title>Orders</title>

<?php
  require(__DIR__ . '/../layout.php');
  validatePageAccess([3]);
  require(__DIR__ . '/../modal_includes.php');
?>

<head>

  <script src="/js/show_and_hide_orders.js"></script>

</head>

<div>

  <div class="row">

    <div class="col-lg-12">

      <h1 class="page-header">Orders</h1>

    </div>

  </div>

  <div class="row">

    <div ng-app="cashierApp" ng-controller="showAndHideOrders" ng-cloak>

      <div class="col-lg-12">

        <div style="margin: auto">

          <div style="text-align: center;">

            <div style="display: inline-block;"><h3>Manage Your Orders</h3></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div style="display: inline-block;">

              <form novalidate name="myForm" action="/myapi/Order" method="post">

                <input type="submit" class="btn btn-primary" value="add order" />

              </form>

            </div>

          </div>

          <br><br>

          <div>

            <table width="50%" class="table" style="border-collapse: collapse" border="0" cellspacing="0" cellpadding="0">

              <thead>

                <tr>

                  <th id="alignText">Id</th>

                  <th id="alignText">Type</th>

                  <th id="alignText">Status</th>

                  <th id="alignText">Actions</th>

                </tr>

              </thead>

              <tbody ng-repeat="o in orders" ng-show="o.Visible == 1">

                <tr>

                  <td id="alignText" ng-bind="o.Id"></td>

                  <td id="alignText" ng-show="o.Type == 1">Delivery</td>

                  <td id="alignText" ng-show="o.Type == 0">Take Away</td>

                  <td id="alignText" ng-show="o.OrderStatusId == 1">Open</td>

                  <td id="alignText" ng-show="o.OrderStatusId == 2">Closed</td>

                  <td id="alignText" class="center">

                    <a style="cursor: pointer" ng-click="editOrder(o.Id)">Edit</a>&nbsp;&nbsp;

                    <a style="cursor: pointer" ng-click="hideOrder(o)">Remove</a>&nbsp;&nbsp;

                    <a class="btn btn-info" style="cursor: pointer" href="{{o.Id}}/details">Show Details</a>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>