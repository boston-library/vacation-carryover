<?php

Header("Cache-Control: no-cache");
Header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>PSA - Vacation Carryover</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.css" rel="stylesheet">
    <!-- <script src="js/jquery-3.0.0.min.js"></script> -->

<!-- Start the CSS -->
<style>
  table, th, td {
    border: 1px solid black;
    padding: 1em;
    text-align: center;
  }

  #messages {
    background: #ffff80;
    /* padding: 1em; */
  }
</style>
<!-- End the CSS -->
  </head>

  <body class="noscript" role="document">

  <script type="text/javascript">
    //$("body").removeClass("noscript");
  </script>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
	  <a class="navbar-brand" href="/sites/carryover/"><img src="img/header_logo.png" /></a>
        </div>
      </div>
    </nav>

    <!-- Required for correct spacing -->
    <p style="margin: 1em;">&nbsp;</p>

    <div class="container theme-showcase" role="main">

      <div class="page-header">
        <h1>PSA - Vacation Carryover</h1>
      </div>

<!-- Start the HTML form -->
<p>How many years of service will you have completed on December 31?</p>
<select id="vacation_award">
  <option value="0-14">Up to 14</option>
  <option value="15-29">15 to 29</option>
  <option value="30+">30+</option>
</select>

<p>&nbsp;</p>

<p>How many weekly Standard Hours are listed on your time sheet?</p>
<select id="weekly_schedule">
  <option value="18">18</option>
  <option value="35">35</option>
</select>

<p>&nbsp;</p>

<p>How many of your vacation hours will remain unused on December 31?</p>
<input type="number" id="unused_vacation" min="0" max="210">

<p>&nbsp;</p>

<input type="submit" value="Submit" onclick="calc()" />

<p>&nbsp;</p>

<!-- Results table -->
<table>
  <tr>
    <th>&nbsp;</th>
    <th>Hours</th>
    <th>Weeks</th>
  </tr>
  <tr>
    <th>Total annual leave award</th>
    <td id="total_hours"></td>
    <td id="total_weeks"></td>
  </tr>
  <tr>
    <th>Amount of annual leave awarded Jan 1</th>
    <td id="newyear_hours"></td>
    <td id="newyear_weeks"></td>
  </tr>
  <tr>
    <th>Maximum carryover limit</th>
    <td id="limit_hours"></td>
    <td id="limit_weeks"></td>
  </tr>
  <tr>
    <th>Estimated carryover request amount</th>
    <td id="request_hours"></td>
    <td id="request_weeks"></td>
  </tr>
</table>

<p>&nbsp;</p>

<div id="messages"></div>
<!-- End the HTML form -->

    </div> <!-- /container -->

<!-- Start the JavaScript -->
<script>
function calc() {
"use strict";

// Basic vacacation award, in weeks
switch(document.querySelector("#vacation_award").value) {
  case "0-14":
    var vacation_award = 4;
    break;

  case "15-29":
    var vacation_award = 5;
    break;

  case "30+":
    var vacation_award = 6;
    break;

  default:
    console.log("Please select a value");
}

// Part- or full-time, in hours
var weekly_schedule = parseInt(document.querySelector("#weekly_schedule").value);

// Unused hours, user input
var unused_vacation = Number(document.querySelector("#unused_vacation").value);

// Populate the table
document.getElementById("total_hours").innerHTML = vacation_award * weekly_schedule;
document.getElementById("total_weeks").innerHTML = vacation_award;

document.getElementById("newyear_hours").innerHTML = (vacation_award * weekly_schedule) / 2;
document.getElementById("newyear_weeks").innerHTML = vacation_award / 2;

document.getElementById("limit_hours").innerHTML = (vacation_award * weekly_schedule) + weekly_schedule;
document.getElementById("limit_weeks").innerHTML = vacation_award + 1;

document.getElementById("request_weeks").innerHTML = "<small>(Please request<br />carryover<br />in hours)</small>";

// Determine the carryover limit
var carryover_limit = (vacation_award * weekly_schedule) + weekly_schedule;
var request_amount = unused_vacation + ((vacation_award * weekly_schedule) / 2);
var action_cell = document.querySelector("#request_hours");

if (request_amount >= vacation_award && request_amount - carryover_limit >= 0 ) {
  var action_required = 1;
  document.getElementById("request_hours").style.background = "#ff8080";
  document.getElementById("request_hours").innerHTML = request_amount - carryover_limit;
} else {
  var action_required = 0;
  document.getElementById("request_hours").style.background = "#80ff80";
  document.getElementById("request_hours").innerHTML = "None";
}

// Print messages
document.getElementById("messages").style.padding = "1em";
 
if (action_required === 1) {
  document.getElementById("messages").innerHTML = "<h3>Action is required to request carryover above contractual limits</h3><p>The total of your projected balance on December 31 plus your January 1 award amount is more than your contractual carryover limit. Your estimated carryover request amount is " + (request_amount - carryover_limit) + " hours.</p>";
} else {
  document.getElementById("messages").innerHTML = "<h3>No action required</h3><p>The total of your projected balance on December 31 plus your January 1 award amount is less or equal to your contractual carryover limit. You do not need to request any additional carryover.</p>";
}

};
</script>
<!-- End the JavaScript -->

  </body>
</html>
