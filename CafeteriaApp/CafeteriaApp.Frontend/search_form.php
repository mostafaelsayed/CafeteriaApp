<form action="/myapi/search" method="post" style="display: inline-block;">
    <li class="inner" style="margin-top: 11px">
        <button type="submit">
            <i class="fa fa-search" style="font-size: 20px">
            </i>
        </button>
    </li>
    <li class="inner" style="margin-top: -27px;margin-left: 50px">
        <input ng-model="searchTerm" name="searchInput" ng-change="search()" type="text"/>
    </li>
    <div style="background-color: white;margin-right: -10px;margin-top: 5px" ng-repeat="res in searchResult">
    	<div class="search-term" ng-bind="res.Name" ng-click="selectFromSearchResult(res)"></div>
    </div>
</form>