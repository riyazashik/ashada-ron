<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-10"><h2>Summary of Executed Works</h2></div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-info export-excel-button" style="display:none;" onclick="validateexportfilterform()" >Export Excel</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8"><span class="error errormessage"></span></div>
                </div>
                <div class="row">
                    <div class="col-sm-8"><span class="success successmessage"></span></div>
                </div>
            </div>
            <?php /*
            <div class="row" style="margin-bottom:1em;">
            <form id="summaryofexecutedworkslistform" action="report1.php" method="POST">
            <div class="col-sm-1"><h4>Area:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='area' id="area"><option value="">Select Area</option></select></div>
            <div class="col-sm-1"><h4>Exchange:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select></div>
            <div class="col-sm-1"><h4>Feeder:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='feeder' id="feeder"><option value="">Select Feeder</option></select></div>      
            <div class="col-sm-1"><h4>Type:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='type' id="type"><option value="">Select Type</option><option value="1">1</option><option value="2">2</option></select></div>             
            </form>
            </div>
            */
            ?>


            <div class="row" style="margin-bottom:2em;">
            <form id="summaryofexecutedworkslistform" action="report1.php" method="POST">
            <div class="row">

<div class="dropdown">
<span style="white-space: nowrap">
<label for="size">Area:</label>
<select class='form-control' name='area' id="area"><option value="">ALL</option></select>
</span>
</div>
<div class="dropdown">
<span style="white-space: nowrap">
<label for="size">Exchange:</label>
<select class='form-control' name='exchange' id="exchange"><option value="">ALL</option></select>
</span>
</div>
<div class="dropdown">
<span style="white-space: nowrap">
<label for="size">Feeder:</label>
<select class='form-control' name='feeder' id="feeder"><option value="">ALL</option></select>
</span>
</div>
<div class="dropdown">
<span style="white-space: nowrap">
<label for="size">Type:</label>
<select class='form-control' name='type' id="type"><option value="">ALL</option><option value="1">1</option><option value="2">2</option>
</select>
</div>
<div class="dropdown">
<span style="white-space: nowrap">
<label for="size">Invoice No:</label>
<select class='form-control' name='invoice' id="invoice"><option value="">ALL</option>
</select>
</div>

</div>
<div class="row" style="margin-top:1em;">

</div>

            </form>
            </div>

            <table class="table table-bordered">
            <col width="20">
<col width="30">
<col width="350">
<col width="30">
<col width="30">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th class="righttd">Measured Quantity</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <td colspan="5">No Items Found</td>
                </tr>
                </tbody>
            </table>
            <div id="pagination_controls"></div>
        </div>
    </div>     
    <script type="text/javascript">

function getallexecutedworksitems(pageno,areaname='',exchange='',feeder='',type='',invoice=''){
    $.ajax({
    type: "POST",  
    url: "reportajaxprocess.php", 
    data: {calltype:'summaryofexecutedworkslist',pageno:pageno,areaname:areaname,exchange:exchange,feeder:feeder,type:type,invoice:invoice},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    //$("#pagination_controls").html(response.pagination);
    if(response.total > 0 )
        $('.export-excel-button').css('display','block');
    else
        $('.export-excel-button').css('display','none'); 


    }   
});
}
function getareas(){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworksarealistwithall'},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#area").html(response);
    }   
});
}
function getexchanges(areaname){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworksexchangelistreport',areaname:areaname},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#exchange").html(response);
    }   
});
}
function getfeeders(exchange){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworksfeederlistreport',exchange:exchange},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#feeder").html(response);
    }   
});
}

function getinvoice(areaname='',exchange='',feeder=''){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworksinvoicelist',areaname:areaname,exchange:exchange,feeder:feeder},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#invoice").html(response);
    }   
});
}

function getpuitems(puitem){
puitemname = '';
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworkspuitemlist',puitem:puitem},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    puitemname = response;
    }   
});
return puitemname;
}

function validateexportfilterform(){
            $(".errormessage").html('');
    var empty = false;
    areaname = $('#area').val();
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();
    type = $('#type').val();

        // if (areaname == '' || exchange == ''){
        //     $(".errormessage").html('WARNING: Please select Areaname and Exchange value');
        // }
        //else{
            $("#summaryofexecutedworkslistform").submit();  
        //}
}


$(document).ready(function(){
//get list of records
getallexecutedworksitems(1);

//getpuitems();

getareas();
getexchanges();
getfeeders();
getinvoice();

$(document).on("change", "#area", function(){
areaname = $('#area').val();
getallexecutedworksitems(1,areaname);
getexchanges(areaname);
getfeeders('');
getinvoice(areaname);
});

$(document).on("change", "#exchange", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
getallexecutedworksitems(1,areaname,exchange);
getfeeders(exchange);
getinvoice(areaname,exchange);
});

$(document).on("change", "#feeder", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
getinvoice(areaname,exchange,feeder);
getallexecutedworksitems(1,areaname,exchange,feeder);
});

$(document).on("change", "#type", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
type = $('#type').val();
getallexecutedworksitems(1,areaname,exchange,feeder,type);
});

$(document).on("change", "#invoice", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
invoice = $('#invoice').val();
type = $('#type').val();
getallexecutedworksitems(1,areaname,exchange,feeder,type,invoice);
});

});

</script>

<style>
.dropdown{
    width:150px;
    float:left;
    margin-right: 6em;
    margin-left: 1.5em;
}
</style>
</body>
</html>