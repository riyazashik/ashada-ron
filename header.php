<?php
include_once("includes/functions.php");
session_start();
if (!isset($_SESSION['userlogin']) && $_SESSION['userlogin'] != '1'){
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1">
<title>Ashada</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/hamburger_menu.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<body>
<?php
$curr_filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
?>
<div class="navbar navbar-default navbar-fixed-top navi" role="navigation">
        <input type="checkbox" id="toggle" checked>
        <label for="toggle" class="button logo">Ashada</label>
        <div class="navbar-collapse main-content" style="margin-left:0px">
            
            <ul class="nav navbar-nav">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Setup <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a href="exchangedivision.php">Exchange Divisions</a></li>
                        <li><a href="feederdivision.php">Feeder Divisions</a></li>
                        <li><a href="puitems.php">PU items</a></li>
                        <li><a href="designquantity.php">Design Quantities</a></li>
                    </ul>
                </li>
                <li><a href="executedworks.php" <?php echo $curr_filename == 'executedworks' ? 'class="active"' : '' ?>>Executed Works</a></li>
                <li><a href="summaryexecutedworks.php" <?php echo $curr_filename == 'summaryexecutedworks' ? 'class="active"' : '' ?>>Summary of Executed Works</a></li>
                <li><a href="billofquantity.php"<?php echo $curr_filename == 'billofquantity' ? 'class="active"' : '' ?>>B.O.Q.</a></li>
                <li><a href="exchangesummarysheet.php"<?php echo $curr_filename == 'exchangesummarysheet' ? 'class="active"' : '' ?>>Exchange Summary Sheet</a></li>
                <li><a href="invoices.php"<?php echo $curr_filename == 'invoices' ? 'class="active"' : '' ?>>Invoices</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
</div>

<div class="row">
        <div id="myModalsuccess" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body">
                    <div class="successcontainer"><span class="success successmessage"></span>
                </div>
            </div>
        </div>  
    </div>
</div>
<div class="row">
        <div id="myModalerror" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Error</h4>
                    </div>
                    <div class="modal-body">
                        <div class="errorcontainer"><span class="error errormessage"></span></div>
                    </div>
                </div>
            </div>  
        </div>
</div>

<script type="text/javascript">
$(function(){
    $('#myModalsuccess').on('show.bs.modal', function(){
        var myModal = $(this);
        clearTimeout(myModal.data('hideInterval'));
        myModal.data('hideInterval', setTimeout(function(){
            myModal.modal('hide');
        }, 1000));
    });
});
$(function(){
    $('#myModalerror').on('show.bs.modal', function(){
        var myModal = $(this);
        clearTimeout(myModal.data('hideInterval'));
        myModal.data('hideInterval', setTimeout(function(){
            myModal.modal('hide');
        }, 1000));
    });
});
</script>
