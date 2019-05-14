<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Executed Works</h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new">Add New</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8"><span class="error errormessage"></span></div>
                </div>
                <div class="row">
                    <div class="col-sm-8"><span class="success successmessage"></span></div>
                </div>
            </div>
            <div class="row" style="margin-bottom:1em;">
            <div class="col-sm-2"><h4>Area:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='area' id="area"><option value="">Select Area</option></select></div>
            <div class="col-sm-2"><h4>Exchange:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select></div>
            <div class="col-sm-2"><h4>Feeder:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='feeder' id="feeder"><option value="">Select Feeder</option></select></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Measured Quantity</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                        <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                        <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div id="pagination_controls"></div>
        </div>
    </div>     
    <script type="text/javascript">

function getallexecutedworksitems(pageno,areaname='',exchange='',feeder=''){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'executedworkslist',pageno:pageno,areaname:areaname,exchange:exchange,feeder:feeder},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    $("#pagination_controls").html(response.pagination);
    }   
});
}
function getareas(){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'executedworksarealist'},
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
    data: {calltype:'executedworksexchangelist',areaname:areaname},
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
    data: {calltype:'executedworksfeederlist',exchange:exchange},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#feeder").html(response);
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

$(document).ready(function(){
//get list of records
getallexecutedworksitems(1);

getpuitems();

getareas();
getexchanges();
getfeeders();

$(document).on("change", "#area", function(){
areaname = $('#area').val();
getallexecutedworksitems(1,areaname);
getexchanges(areaname);
});

$(document).on("change", "#exchange", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
getallexecutedworksitems(1,areaname,exchange);
getfeeders(exchange);
});

$(document).on("change", "#feeder", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
getallexecutedworksitems(1,areaname,exchange,feeder);
});

$(document).on("change", ".puitems", function(){
puitem = $(this).val();
descriptioncell = $(this).parents("tr").find('td').eq(3);
unit = $(this).parents("tr").find('td').eq(4);
$.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'getexecutedworkscurrentitem',puitem:puitem},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    descriptioncell.html(response.description);
    unit.html(response.unit);
    }   
});
});

$(document).on("click", ".executedworkspag", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
pagenum = $(this).attr('pagenum');
getallexecutedworksitems(pagenum,areaname,exchange,feeder);
getexchanges(areaname);
getfeeders(exchange);
});

$(document).on("keyup", "input[name='measuredqty']", function(){
  if (/\D/g.test(this.value)){
    this.value = this.value.match(/^\d+\.?\d{0,4}/);
  }
});


$('[data-toggle="tooltip"]').tooltip();
var actions = $("table td:last-child").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    if(index == '-1'){
        index = 0;
    }
    var row = '<tr>' +
        '<td><input type="text" class="form-control" name="from" id="from"></td>' +
        '<td><input type="text" class="form-control" name="to" id="to"></td>' +
        '<td>'+ getpuitems("") +'</td>' +
        '<td></td>' +
        '<td></td>' +
        '<td><input type="text" class="form-control" name="measuredqty" id="measuredqty"></td>' +
        '<td><input type="text" class="form-control" name="remark" id="remark"></td>' +
        '<td>' + actions + '</td>' +
    '</tr>';
    if(index){
        $("table tbody").html(row);
    }
    else{
    $("table tbody tr:first-child").before(row);
    }
    $("table tbody tr").eq(index).find(".add, .edit").toggle();
    $('[data-toggle="tooltip"]').tooltip();
});

// Add row on add button click
$(document).on("click", ".add", function(){
    var empty = false;
    var input = $(this).parents("tr").find('input[type="text"]');
    areaname = $('#area').val();
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();
    input.each(function(){
        if (areaname == '' || exchange == ''){
            alert('Please select Areaname and Exchange value');
            empty = true;
        }
        else if(!$(this).val()){
            $(this).addClass("error");
            empty = true;
        } else{
            $(this).removeClass("error");
        }
    });
    if(!empty){
        var id = $(this).attr("itemid");
        var from = $(this).parents("tr").find('input[name="from"]').val();
        var to = $(this).parents("tr").find('input[name="to"]').val();
        var puitemid = $(this).parents("tr").find('select[name="puitems"]').val();
        var measuredqty = $(this).parents("tr").find('input[name="measuredqty"]').val();
        var remark = $(this).parents("tr").find('input[name="remark"]').val();
        var calltype = 'executedworksadd';
        if (id != '' && id != undefined){
            calltype = 'executedworksedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, areaname:areaname,exchange:exchange,feeder:feeder,from:from,to:to,puitemid:puitemid,measuredqty:measuredqty, remark:remark, id:id},
            dataType: "json",      
            success: function(response)  
            {
            if (response.status == 0)
            {
                $(".errormessage").html(response.errormsg);
            }
            else{
            $("table tbody").html(response.html);
            $("#pagination_controls").html(response.pagination);
            $(".successmessage").html(response.successmessage);
            }
            }   
        });
        $(".add-new").removeAttr("disabled");
   }
});

// Edit row on edit button click
$(document).on("click", ".edit", function(){
    $(this).parents("tr").find("td:not(:last-child)").each(function(){
        var names = ["from", "to", "puitems", "description", "unit", "measuredqty", "remark"];
        var currentindex = $(this).index();
        if (currentindex == 2){
            $(this).html(getpuitems($(this).text()));
        }
        if(currentindex == 0 || currentindex == 1 || currentindex == 5 || currentindex == 6 ){
        $(this).html('<input type="text" class="form-control" name="' +names[currentindex]+ '" value="' + $(this).text() + '">');
        }
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).attr("itemid");
    $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'executedworksdlt', id:id},
        dataType: "json",      
        success: function(response)  
        {
        $("table tbody").html(response.html);
        $("#pagination_controls").html(response.pagination);
        $(".successmessage").html(response.successmessage);
        }   
    });
    $(".add-new").removeAttr("disabled");
});

});

</script>
</body>
</html>