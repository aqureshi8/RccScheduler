<?php
require_once('../private/initialize.php');

//If user isn't logged in then redirect to login page.
if (!isset($_SERVER['PHP_AUTH_USER'])) {
  redirect_to("index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  
  <head>
    <title>RCC Scheduler App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-route.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-animate.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular-sanitize.js"></script>
    <script src="https://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.3.0.js"></script>
    <script src=app.js></script>
    <link rel="shortcut icon" href="favicon.png" />
    <style type="text/css">
      table, td, th {
        color: black;
        width: 1000px;
        table-layout: fixed;
        border: 1px solid black;
      }
      th {
        width: 100px;
        text-align: center;
      }
      .shiftButton {
        width: 100%;
        border: none;
        background: none;
      }
      .shiftAction {
        width: 100%;
      }
      .addRem {
        width: 100%;
      }
      .taken {
        background-color: salmon;
      }
      .owned {
        background-color: lightblue;
      }
      .available {
        background-color: lightgreen;
      }
    </style>
  </head>
  
  <body ng-app="rccsched" ng-controller="schedCtrl">

    <select name="location" id="location" ng-model="location.name" value="baruch" ng-change="schedColors()">
    	<option value="baruch">Baruch</option>
  	  <option value="nobel">Nobel</option>
     	<option value="west">West</option>
    	<option value="douglass">Douglass</option>
    	<option value="cardozo">Cardozo</option>
  	  <option value="oneill">O'Neill</option>
    	<option value="benedict">Benedict</option>
    	<option value="chapin">Chapin</option>
    </select>

    <div class="weekTable">
      <table>
        <tr>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </tr>
        <tr>
        	<th><button class="shiftButton" id="SunM" disabled="disabled" ng-click='takeDrop("SunM")'></button></th>
         	<th><button class="shiftButton" id="MonM" disabled="disabled" ng-click='takeDrop("MonM")'></button></th>
          <th><button class="shiftButton" id="TueM" disabled="disabled" ng-click='takeDrop("TueM")'></button></th>
        	<th><button class="shiftButton" id="WedM" disabled="disabled" ng-click='takeDrop("WedM")'></button></th>
      	  <th><button class="shiftButton" id="ThuM" disabled="disabled" ng-click='takeDrop("ThuM")'></button></th>
        	<th><button class="shiftButton" id="FriM" disabled="disabled" ng-click='takeDrop("FriM")'></button></th>
        	<th><button class="shiftButton" id="SatM" disabled="disabled" ng-click='takeDrop("SatM")'></button></th>
        </tr>
        <tr>
        	<th><button class="shiftButton" id="SunE" disabled="disabled" ng-click='takeDrop("SunE")'></button></th>
      	  <th><button class="shiftButton" id="MonE" disabled="disabled" ng-click='takeDrop("MonE")'></button></th>
        	<th><button class="shiftButton" id="TueE" disabled="disabled" ng-click='takeDrop("TueE")'></button></th>
        	<th><button class="shiftButton" id="WedE" disabled="disabled" ng-click='takeDrop("WedE")'></button></th>
        	<th><button class="shiftButton" id="ThuE" disabled="disabled" ng-click='takeDrop("ThuE")'></button></th>
        	<th><button class="shiftButton" id="FriE" disabled="disabled" ng-click='takeDrop("FriE")'></button></th>
        	<th><button class="shiftButton" id="SatE" disabled="disabled" ng-click='takeDrop("SatE")'></button></th>
        </tr>
        <tr>
        	<th><button class="shiftButton" id="SunN" disabled="disabled" ng-click='takeDrop("SunN")'></button></th>
        	<th><button class="shiftButton" id="MonN" disabled="disabled" ng-click='takeDrop("MonN")'></button></th>
        	<th><button class="shiftButton" id="TueN" disabled="disabled" ng-click='takeDrop("TueN")'></button></th>
        	<th><button class="shiftButton" id="WedN" disabled="disabled" ng-click='takeDrop("WedN")'></button></th>
        	<th><button class="shiftButton" id="ThuN" disabled="disabled" ng-click='takeDrop("ThuN")'></button></th>
        	<th><button class="shiftButton" id="FriN" disabled="disabled" ng-click='takeDrop("FriN")'></button></th>
        	<th><button class="shiftButton" id="SatN" disabled="disabled" ng-click='takeDrop("SatN")'></button></th>
        </tr>
        <tr>
          <th><button class="shiftButton" id="SunL" disabled="disabled" ng-click='takeDrop("SunL")'></button></th>
          <th><button class="shiftButton" id="MonL" disabled="disabled" ng-click='takeDrop("MonL")'></button></th>
          <th><button class="shiftButton" id="TueL" disabled="disabled" ng-click='takeDrop("TueL")'></button></th>
          <th><button class="shiftButton" id="WedL" disabled="disabled" ng-click='takeDrop("WedL")'></button></th>
          <th><button class="shiftButton" id="ThuL" disabled="disabled" ng-click='takeDrop("ThuL")'></button></th>
          <th><button class="shiftButton" id="FriL" disabled="disabled" ng-click='takeDrop("FriL")'></button></th>
          <th><button class="shiftButton" id="SatL" disabled="disabled" ng-click='takeDrop("SatL")'></button></th>
        </tr>
      </table>
    </div>

    <div class="shiftList">
      <h3>Current Shifts:</h3>
      <p ng-repeat="shift in allShifts">Something</p>
    </div>

    <script type="text/javascript">

      function makeBWDOB() {
        $('.shiftButton').html('');
        $('.shiftButton').removeClass('available');
        $('.shiftButton').removeClass('taken');
        $('.shiftButton').removeClass('owned');
        $('.shiftButton').prop('disabled', true);

        $('#SunE').text('3:00PM - 7:00PM');
        $('#SunN').text('7:00PM - 11:00PM');
        $('#MonN').text('8:00PM - 11:00PM');
        $('#TueN').text('8:00PM - 11:00PM');
        $('#WedN').text('8:00PM - 11:00PM');
        $('#ThuN').text('8:00PM - 11:00PM');
        $('#SunL').text('11:00PM - 2:30AM');
        $('#MonL').text('11:00PM - 2:30AM');
        $('#TueL').text('11:00PM - 2:30AM');
        $('#WedL').text('11:00PM - 2:30AM');
        $('#ThuL').text('11:00PM - 2:30AM');

        $('#SunE').prop('disabled', false);
        $('#SunN').prop('disabled', false);
        $('#MonN').prop('disabled', false);
        $('#TueN').prop('disabled', false);
        $('#WedN').prop('disabled', false);
        $('#ThuN').prop('disabled', false);
        $('#SunL').prop('disabled', false);
        $('#MonL').prop('disabled', false);
        $('#TueL').prop('disabled', false);
        $('#WedL').prop('disabled', false);
        $('#ThuL').prop('disabled', false);

        $('#SunE').addClass("available");
        $('#SunN').addClass("available");
        $('#MonN').addClass("available");
        $('#TueN').addClass("available");
        $('#WedN').addClass("available");
        $('#ThuN').addClass("available");
        $('#SunL').addClass("available");
        $('#MonL').addClass("available");
        $('#TueL').addClass("available");
        $('#WedL').addClass("available");
        $('#ThuL').addClass("available");
      }

      function makeN() {
        $('#MonM').text('12:00PM - 4:00PM');
        $('#TueM').text('12:00PM - 4:00PM');
        $('#WedM').text('12:00PM - 4:00PM');
        $('#ThuM').text('12:00PM - 4:00PM');

        $('#MonM').prop('disabled', false);
        $('#TueM').prop('disabled', false);
        $('#WedM').prop('disabled', false);
        $('#ThuM').prop('disabled', false);

        $('#MonM').addClass("available");
        $('#TueM').addClass("available");
        $('#WedM').addClass("available");
        $('#ThuM').addClass("available");
      }

      function makeC() {
        $('#FriM').text('12:00PM - 4:00PM');
        $('#FriM').prop('disabled', false);
        $('#FriM').addClass("available");
      }

      function makeChap() {
        $('.shiftButton').html('');
        $('.shiftButton').removeClass('available');
        $('.shiftButton').removeClass('taken');
        $('.shiftButton').removeClass('owned');
        $('.shiftButton').prop('disabled', true);
        $('#MonM').text('12:00PM - 4:00PM');
        $('#TueM').text('12:00PM - 4:00PM');
        $('#WedM').text('12:00PM - 4:00PM');
        $('#ThuM').text('12:00PM - 4:00PM');
        $('#FriM').text('12:00PM - 4:00PM');
        $('#SatM').text('12:00PM - 5:00PM');
        $('#SunN').text('7:00PM - 10:00PM');
        $('#MonN').text('7:00PM - 10:00PM');
        $('#TueN').text('7:00PM - 10:00PM');
        $('#WedN').text('7:00PM - 10:00PM');
        $('#ThuN').text('7:00PM - 10:00PM');
        $('#SunL').text('10:00PM - 1:00AM');
        $('#MonL').text('10:00PM - 1:00AM');
        $('#TueL').text('10:00PM - 1:00AM');
        $('#WedL').text('10:00PM - 1:00AM');
        $('#ThuL').text('10:00PM - 1:00AM');

        $('#MonM').prop('disabled', false);
        $('#TueM').prop('disabled', false);
        $('#WedM').prop('disabled', false);
        $('#ThuM').prop('disabled', false);
        $('#FriM').prop('disabled', false);
        $('#SatM').prop('disabled', false);
        $('#SunN').prop('disabled', false);
        $('#MonN').prop('disabled', false);
        $('#TueN').prop('disabled', false);
        $('#WedN').prop('disabled', false);
        $('#ThuN').prop('disabled', false);
        $('#SunL').prop('disabled', false);
        $('#MonL').prop('disabled', false);
        $('#TueL').prop('disabled', false);
        $('#WedL').prop('disabled', false);
        $('#ThuL').prop('disabled', false);

        $('#MonM').addClass("available");
        $('#TueM').addClass("available");
        $('#WedM').addClass("available");
        $('#ThuM').addClass("available");
        $('#FriM').addClass("available");
        $('#SatM').addClass("available");
        $('#SunN').addClass("available");
        $('#MonN').addClass("available");
        $('#TueN').addClass("available");
        $('#WedN').addClass("available");
        $('#ThuN').addClass("available");
        $('#SunL').addClass("available");
        $('#MonL').addClass("available");
        $('#TueL').addClass("available");
        $('#WedL').addClass("available");
        $('#ThuL').addClass("available");
      }

      function makeWeek() {
        var loc = document.getElementById('location').value;
        if(loc === "baruch") {
          console.log("baruch");
          makeBWDOB();
        }
        else if(loc === "nobel") {
          console.log("nobel");
          makeBWDOB();
          makeN();
        }
        else if(loc === "west") {
          console.log("west");
          makeBWDOB();
        }
        else if(loc === "douglass") {
          console.log("douglass");
          makeBWDOB();
        }
        else if(loc === "cardozo") {
          console.log("cardozo");
          makeBWDOB();
          makeN();
          makeC();
        }
        else if(loc === "oneill") {
          console.log("oneill");
          makeBWDOB();
        }
        else if(loc === "benedict") {
          console.log("benedict");
          makeBWDOB();
        }
        else if(loc === "chapin") {
          console.log("chapin");
          makeChap();
        }
        else {
          console.log("Error: incorrect location");
        }
      }

      makeWeek();

      $('#location').on("change", function() {
        makeWeek();
      });

    </script>

  </body>

</html>