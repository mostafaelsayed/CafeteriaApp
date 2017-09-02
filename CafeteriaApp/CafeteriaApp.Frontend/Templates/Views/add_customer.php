<br>

<div><label>Credit</label></div>

<span style="margin:auto">

	<input type="text" ng-model="credit" number-check>

</span>

<div><label>Gender</label></div>

<span style="margin:auto;margin-right:20px">

  <label>Female</label><input id="femaleInput" type="checkbox">

</span>

<span style="margin:auto;margin-left:20px">

  <label>Male</label><input id="maleInput" type="checkbox">

</span>

<div><br><label>Date of birth</label></div><br>

<span style="margin:auto;margin-left:40px">

  <label>Year</label>

  <select ng-options="year for year in years" ng-model="selectedYear"></select>

</span>

<span style="margin:auto">

  <label>Month</label>

  <select ng-options="month for month in months" ng-model="selectedMonth"></select>

</span>

<span style="margin:auto;margin-right:40px">

  <label>Day</label>

  <select ng-options="day for day in days" ng-model="selectedDay"></select>

</span>

<div>

  <input type="submit" value="save" class="btn btn-primary" ng-click="addCustomerUser()">
  
</div>