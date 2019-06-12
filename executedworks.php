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
            </div>
            <div class="row" style="margin-bottom:1em;">
                <div class="col-sm-3">
                <span style="white-space: nowrap">
                    <label for="size">Area :</label>
                    <select class='form-control' name='area' id="area"><option value="">Select Area</option></select>
                </span>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-3">
                <span style="white-space: nowrap">
                    <label for="size">Exchange :</label>
                    <select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select>
                </span>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-3">
                <span style="white-space: nowrap">
                    <label for="size">Feeder :</label>
                    <select class='form-control' name='feeder' id="feeder"><option value="">Select Feeder</option></select>
                </span>
                </div>
            </div>
            <div id="actiontools" style="display:none">
            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
            </div>
            <table class="table table-bordered">
            <col width="60">
            <col width="60">
            <col width="50">
            <col width="200">
            <col width="20">
            <col width="40">
            <col width="80">
            <col width="40">
            <col width="40">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Measured Quantity</th>
                        <th>Remark</th>
                        <th>Invoice no</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
$(".add-new").attr("disabled", "disabled");
//get list of records
//getallexecutedworksitems(1);

getpuitems();

getareas();
getexchanges();
getfeeders();

$(document).on("change", "#area", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
getallexecutedworksitems(1,areaname);
getexchanges(areaname);
getfeeders("");
if(areaname == ''){
$(".add-new").attr("disabled", "disabled");
$(".errormessagefordropdown").remove();
}
});

$(document).on("change", "#exchange", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
getallexecutedworksitems(1,areaname,exchange);
getfeeders(exchange);
if(exchange != ''){
$(".add-new").removeAttr("disabled");
$(".errormessagefordropdown").remove();
}
else{
$(".add-new").attr("disabled", "disabled");
}
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
var actions = $("#actiontools").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    var row = '<tr>' +
        '<td><input type="text" class="form-control" name="from" id="from"></td>' +
        '<td><input type="text" class="form-control" name="to" id="to"></td>' +
        '<td currentid=""><input type="text" class="form-control puitemauto" name="puitems" id="puitems" currentitem=""></td>' +
        //'<td>'+ getpuitems("") +'</td>' +
        '<td></td>' +
        '<td></td>' +
        '<td><input type="text" class="form-control" name="measuredqty" id="measuredqty"></td>' +
        '<td><input type="text" class="form-control" name="remark" id="remark"></td>' +
        '<td></td>' +
        '<td>' + actions + '</td>' +
    '</tr>';
    if(index){
        $("table tbody").html(row);
    }
    else{
    $("table tbody tr:first-child").before(row);
    }
    $("table tbody tr").find('.add > .material-icons').text("save");
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
    
   // if (areaname == '' || exchange == '' || feeder == ''){
    if (areaname == '' || exchange == ''){
        if (areaname == ''){
            $( "<span class='errormessagefordropdown'>Please select Area</span>" ).insertAfter( "#areaname" );
            empty = true;
        }
        if (exchange == ''){
            $( "<span class='errormessagefordropdown'>Please select Exchange</span>" ).insertAfter( "#exchange" );
            empty = true;
        }
    //    if (feeder == ''){
    //        $( "<span class='errormessage'>Please select Feeder</span>" ).insertAfter( "#feeder" );
    //        empty = true;
    //    }
        }
    input.each(function(){
        if (areaname == '' || exchange == '' || feeder == ''){
        }
        else if(!$(this).val()){
            var name = $(this).attr("name");
            if (name != 'invoice'){
                $(this).addClass("error");
                empty = true;
            }
        } else{
            $(this).removeClass("error");
        }
    });
    if(!empty){
        var id = $(this).attr("itemid");
        var from = $(this).parents("tr").find('input[name="from"]').val();
        var to = $(this).parents("tr").find('input[name="to"]').val();
        var puitemid = $(this).parents("tr").find('input[name="puitems"]').attr('currentitem');
        var measuredqty = $(this).parents("tr").find('input[name="measuredqty"]').val();
        var remark = $(this).parents("tr").find('input[name="remark"]').val();
        var invoice = $(this).parents("tr").find('input[name="invoice"]').val();
        var calltype = 'executedworksadd';
        if (id != '' && id != undefined){
            calltype = 'executedworksedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, areaname:areaname,exchange:exchange,feeder:feeder,from:from,to:to,puitemid:puitemid,measuredqty:measuredqty, remark:remark, invoice:invoice, id:id},
            dataType: "json",      
            success: function(response)  
            {
            if (response.status == 0)
            {
                $(".errormessage").html(response.errormsg);
                $("#myModalerror").modal('show');
            }
            else{
            $("table tbody").html(response.html);
            $("#pagination_controls").html(response.pagination);
            $(".successmessage").html(response.successmessage);
            $("#myModalsuccess").modal('show');
            }
            }   
        });
        $(".add-new").removeAttr("disabled");
   }
});

// Edit row on edit button click
$(document).on("click", ".edit", function(){
    $(this).parents("tr").find("td:not(:last-child)").each(function(){
        var names = ["from", "to", "puitems", "description", "unit", "measuredqty", "remark", "invoice"];
        var currentindex = $(this).index();
        // if (currentindex == 2){
        //     $(this).html(getpuitems($(this).text()));
        // }
        //if(currentindex == 0 || currentindex == 1 || currentindex == 2 || currentindex == 5 || currentindex == 6){
        if(currentindex == 0 || currentindex == 1 || currentindex == 5 || currentindex == 6|| currentindex == 7){
        $(this).html('<input type="text" class="form-control" name="' +names[currentindex]+ '" value="' + $(this).text() + '">');
        }
        else if(currentindex == 2){            
        $(this).html('<input type="text" class="form-control puitemauto" name="' +names[currentindex]+ '" value="' + $(this).text() + '" currentitem="' + $(this).parents('tr').find('td:eq( 2 )' ).attr('currentid') + '">');
        }
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $(this).parents("tr").find('.add > .material-icons').text("save");
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).attr("itemid");
    areaname = $('#area').val();
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();
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
        $("#myModalsuccess").modal('show');
        getallexecutedworksitems(1,areaname,exchange,feeder);
        }   
    });
    $(".add-new").removeAttr("disabled");
});

$(function(){
  $(document).on("keydown.autocomplete",".puitemauto",function(e){
    $(this).autocomplete({
matchContains: "word",
autoFill: true,
      source : '../Ashada/includes/autocomplete.php',
      
select: function (event, ui) {
    var label = ui.item.label;
    var value = ui.item.value;
  //document.valueSelectedForAutocomplete = label;
puitem = ui.item.value;
descriptioncell = $(this).parents("tr").find('td').eq(3);
unit = $(this).parents("tr").find('td').eq(4);
$(".puitemauto").attr('currentitem',puitem);
$(".puitemauto").val(label);
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
return false;

}
    });
  });

});

});
</script>
</body>
</html>