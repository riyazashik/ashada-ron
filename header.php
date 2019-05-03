<?php
//include_once("includes/functions.php");
include_once("includes/newfunctions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ashada</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/new.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
.header {
  overflow: hidden;
  background-color: #f1f1f1;
  padding: 20px 10px;
}

/* Style the header links */
.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 8px;
  text-decoration: none;
  font-size: 12px; 
  line-height: 15px;
  border-radius: 4px;
}

/* Style the logo link (notice that we set the same value of line-height and font-size to prevent the header to increase when the font gets bigger */
.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

/* Change the background color on mouse-over */
.header a:hover {
  background-color: #ddd;
  color: black;
}

/* Style the active/current link*/
.header a.active {
  background-color: dodgerblue;
  color: white;
}

/* Float the link section to the right */
.header-right {
  float: right;
}

/* Add media queries for responsiveness - when the screen is 500px wide or less, stack the links on top of each other */ 
@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}
span.errormessage{
    color: #f50000;
}
span.successmessage{
    color: #27C46B;
}
</style>
</head>
<body>
<?php
$curr_filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
?>
<div class="container">
<div class="header">
  <a href="#default" class="logo">Ashada</a>
  <div class="header-right">
    <a href="countrydivision.php" <?php echo $curr_filename == 'countrydivision' ? 'class="active"' : '' ?> >Country Divisions</a>
    <a href="puitems.php"<?php echo $curr_filename == 'puitems' ? 'class="active"' : '' ?> >PU Items</a>
    <a href="designquantity.php"<?php echo $curr_filename == 'designquantity' ? 'class="active"' : '' ?> >Design Quantities</a>
    <a href="#about">Executed Works</a>
    <a href="#about">Summary of Executed Works</a>
    <a href="#about">Bill of Quantities</a>
    <a href="#about">Entity Summary Sheet</a>
    <a href="#about">Invoices</a>
    <a href="login.php">Logout</a>
  </div>
</div>
