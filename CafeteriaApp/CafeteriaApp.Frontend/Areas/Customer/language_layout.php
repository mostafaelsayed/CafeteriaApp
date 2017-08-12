<?php //require_once("CafeteriaApp.Backend/session.php"); ?>

 
    <div class="input-field col s12" ng-app="myapp2"  ng-controller="Language"  >
            <select   title="Display language" ng-model="selectedLang" ng-options="l.Name for l in languages" > 
            <option value="" disabled selected >Choose the language</option></select>
           <?php $_SESSION["langId"]="{{selectedLang.Id}}" ;  //echo __FILE__;        ?>

       </div>
