<br>
<div><label>Change Role</label></div>
<span style="margin: auto">
  <select ng-options="role for role in roles" ng-model="selectedRole"></select>
</span>

<div ng-show="selectedRole=='Customer'">
  <!-- <div><label>Image</label></div>
  <input type="text" ng-model="image" /> -->
  <div><label>Gender</label></div>
  <span style="margin: auto;margin-right: 20px">
    <label>Female</label><input id="femaleInput" type="checkbox" ng-click="femaleChecked()">
  </span>
  <span style="margin: auto;margin-left: 20px">
    <label>Male</label><input id="maleInput" type="checkbox" ng-click="maleChecked()">
  </span>
  <div><br><label>Date of birth</label></div><br>
  <div style="float: left;margin-left: 500px">
    <label>Year</label>
    <select ng-options="year for year in years" ng-model="userData.selectedYear"></select>
  </div>
  <span style="margin: auto">
    <label>Month</label>
    <select ng-options="month for month in months" ng-model="userData.selectedMonth"></select>
  </span>
  <span style="float: right;margin-right: 500px">
    <label>Day</label>
    <select ng-options="day for day in days" ng-model="userData.selectedDay"></select>
  </span>
</div>
<br><br>
<div><button ng-click="save()" class="btn btn-primary">Save</button></div>