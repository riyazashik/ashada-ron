<?php
include_once("header.php");
include_once("includes/function_printer.php");

?>
<style type="text/css">
    table>thead>tr>th>i.executed-works-item-desc, table>thead>tr>th>i.executed-works-item-asc
    {
        float:right !important;
    }
</style>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-2"><h2>Executed Works</h2></div>
                    <div class="col-sm-2">
                    <select class='form-control sort-by' name='sortby' id="sortby" style="display:none">
                    <option value="">Order of entry</option>
                    <option value="puitemasc">PU Item A-Z</option>
                    <option value="puitemdesc">PU Item Z-A</option></select>
                </span>
                </div>
                    <div class="col-sm-8">
                        <div class="row">
                        <div class="col-sm-10">
                        <button type="button" class="btn btn-info add-new" style="display:none">Add New</button>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-info export-excel-print" style="display:none;" onclick="PrintMe('printableArea')" >Print</button>                 
                        </div>
                    </div> 
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
            <div id="printableArea">  
            <table class="table table-bordered" style="min-width:900px">
            <!-- 
            <col width="60">
            <col width="60">
            <col width="50">
            <col width="200">
            <col width="20">
            <col width="40">
            <col width="80">
            <col width="40">
            <col width="40">
            -->
                <colgroup>
                    <col style="width: 65px;">
                    <col style="width: 85px;">
                    <col style="width: 50px;">
                    <col style="width: 200px;">
                    <col style="width: 45px;">
                    <col style="width: 57px;">
                    <col style="width: 130px;">
                    <col style="width: 60px;">
                    <col style="width: 70px;">
                </colgroup>
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
            </div>
            <div id="pagination_controls"></div>
        </div>
    </div>     
    <script type="text/javascript">
     function PrintMe(DivID) {
        var disp_setting="toolbar=yes,location=no,";
        disp_setting+="directories=yes,menubar=yes,";
        disp_setting+="scrollbars=no,width=1000px, height=800px";
        // var content_vlue = document.getElementById(DivID).innerHTML;
        var content_vlue = document.getElementById(DivID).innerHTML.replace(/id="first_child"/g,'id="first_child" style="display:none"').replace(/id="actions"/g,'id="actions" style="display:none"').replace(/<th>Action/g,'<th style="display:none">Action').replace(/<col style="width: 70px;">/g,'').replace(/class="table table-bordered"/g,'class="table"');
        console.log(content_vlue);
        var docprint=window.open("","",disp_setting);
        var areaname = $('#area').val();
        var header ='';
        var footer ='';
        var exchange = $('#exchange').val();
        var feeder = $('#feeder').val();
        var html = '';
        sort_order = '';
        pageno=0;
        $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'executedworkslistprint',pageno:pageno,areaname:areaname,exchange:exchange,feeder:feeder,sort_order:sort_order},
        dataType: "json",      
        success: function(response)  
        {
            //html = response.html; 
            //console.log(content_vlue); 
            var intialhtml='<table class="table" style="min-width:900px"><colgroup><col style="width: 65px;"> <col style="width: 85px;"> <col style="width: 50px;"><col style="width: 200px;"><col style="width: 45px;"><col style="width: 57px;"><col style="width: 130px;"><col style="width: 60px;"></colgroup>';
            intialhtml += '<thead><tr><th>From</th><th>To</th><th>PU item</th><th>Description</th><th>Unit</th><th>Measured Quantity</th><th>Remark</th><th>Invoice no</th></tr></thead><tbody>';

            html = intialhtml +  response.html + '</tbod></table>';
            //alert(html);
            $.ajax({
                type: "POST",  
                url: "includes/function_printer.php", 
                data: {calltype:'getPrinterHeaderFooter', name:'Executedworks',areaname:areaname,exchange:exchange,feeder:feeder,type:'',invoice:''},
                dataType: "json",      
                success: function(response)  
                {
                    header= response.header;
                    footer= response.footer;
                    docprint.document.open();
                    docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
                    docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
                    docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
                    docprint.document.write('<head><title>Executed works</title>');
                    docprint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css"><style type="text/css">@page{ size: auto;margin:3px;');
                    docprint.document.write('font-family:verdana,Arial;color:#000;');
                    docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
                    docprint.document.write('a{color:#000;text-decoration:none;}table .righttd { text-align: right;}table, th, td {border: 1px solid black;}.table>thead>tr>th {vertical-align:bottom;border-bottom:1px solid black;}.table>tbody>tr>td{bottom;border-top:1px solid black;}</style>');
                    docprint.document.write('</head><body onLoad="self.print()"><center>');
                    docprint.document.write(header);
                    docprint.document.write("<br/>");
                    //docprint.document.write(content_vlue);
                    docprint.document.write(html);
                    docprint.document.write('</center>');
                    docprint.document.write(footer);
                    docprint.document.write('</body></html>');
                    docprint.document.close();
                    docprint.focus();
                    //docprint.print();
                    //docprint.close();
                        return true;
                }
            });
        }
        });
        
}

function getallexecutedworksitems(pageno,areaname='',exchange='',feeder='',sort_order=''){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'executedworkslist',pageno:pageno,areaname:areaname,exchange:exchange,feeder:feeder,sort_order:sort_order},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    /*if(response.html != '' && $(".executed-works-item-asc").css('display') == 'block'){
        $(".executed-works-item-asc").css('display','block');
        $(".executed-works-item-desc").css('display','none');
    }
    else if(response.html != '' && $(".executed-works-item-desc").css('display') == 'block'){
        $(".executed-works-item-desc").css('display','block');
        $(".executed-works-item-asc").css('display','none');
    }
    else if(response.html != ''){
        $(".executed-works-item-asc").css('display','block');
        $(".executed-works-item-desc").css('display','none');
    }
    else{
        $(".executed-works-item-asc").css('display','none');
        $(".executed-works-item-desc").css('display','none');
        
    }*/
    if(response.html !=''){
        $('.export-excel-print').css('display','block');
        $('.sort-by').css('display','block');
    }
    if(exchange !='' || feeder != '')
    {   
        $('.add-new').trigger('click');
    }
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
    $(".add-new").hide();
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
getallexecutedworksitems(1,'');
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
//$('.export-excel-print').css('display','block');
}
else{
$(".add-new").attr("disabled", "disabled");
}
});

$(document).on("change", "#feeder", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
$(".add-new").removeAttr("disabled");
getallexecutedworksitems(1,areaname,exchange,feeder);
$('.export-excel-print').css('display','block');
$('.sort-by').css('display','block');
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

$(document).on("keyup", ".puitemauto", function(){
$(this).parents("tr").find('input[name="puitems"]').attr('currentitem','');
$(this).parents("tr").find('td').eq(3).empty();
$(this).parents("tr").find('td').eq(4).empty();
});

$(document).on("click", ".executedworkspag", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
pagenum = $(this).attr('pagenum');
getallexecutedworksitems(pagenum,areaname,exchange,feeder);
getexchanges(areaname);
getfeeders(exchange);
$('#exchange').val(exchange);
$('#feeder').val(feeder);
});

// $(document).on("keyup", "input[name='measuredqty']", function(){
//   if (/\D/g.test(this.value)){
//     this.value = this.value.match(/^\d+\.?\d{0,4}/);
//   }
// });

$('[data-toggle="tooltip"]').tooltip();
var actions = $("#actiontools").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    var row = '<tr id="first_child">' +
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
        if (areaname == '' || exchange == '' ){
        }
        else if(!$(this).val()){
             var name = $(this).attr("name");
             if (name != 'remark' && name != 'to'){
                $(this).addClass("error");
                empty = true;
            }
        } else{
            $(this).removeClass("error");
        }
    });
    /*
        var puitemid = $(this).parents("tr").find('input[name="puitems"]').attr('currentitem');
        if(puitemid == '' || puitemid == 'undefined'){
                $(".errormessage").html('Please Select Valid PU Item!');
                $("#myModalerror").modal('show');
                empty = true;
                return false;
        }
*/
    if(!empty){
        var id = $(this).attr("itemid");
        var from = $(this).parents("tr").find('input[name="from"]').val();
        var to = $(this).parents("tr").find('input[name="to"]').val();
        var puitemid = $(this).parents("tr").find('input[name="puitems"]').attr('currentitem');
        var puitem = $(this).parents("tr").find('input[name="puitems"]').val();
        var measuredqty = $(this).parents("tr").find('input[name="measuredqty"]').val();
        if (measuredqty){
             var regex = new RegExp(/^-?\d*\.?\d{0,4}$/);
                if(!regex.test(measuredqty)) {
                $(".errormessage").html('Measured quantity does not allow Alphabets and special characters');
                $("#myModalerror").modal('show');
                return false;
                }
        }
        var remark = $(this).parents("tr").find('input[name="remark"]').val();
        var invoice = $(this).parents("tr").find('input[name="invoice"]').val();
        var calltype = 'executedworksadd';
        if (id != '' && id != undefined){
            calltype = 'executedworksedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, areaname:areaname,exchange:exchange,feeder:feeder,from:from,to:to,puitemid:puitemid,measuredqty:measuredqty, remark:remark, invoice:invoice, id:id, puitem:puitem},
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
            $('.add-new').trigger('click');
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
        if(currentindex == 0 || currentindex == 1 || currentindex == 5 || currentindex == 6){
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

    if(id == '' || id == undefined ){
        getallexecutedworksitems(1,areaname,exchange,feeder);
    }

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

/*$(document).on("click", ".executed-works-item-asc", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
sort_order = 'puitemasc';
getallexecutedworksitems(1,areaname,exchange,feeder,sort_order);
//$(".executed-works-item-asc").css('display','none');
//$(".executed-works-item-desc").css('display','block');
});

/*$(document).on("click", ".executed-works-item-desc", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
sort_order = 'puitemdesc';
getallexecutedworksitems(1,areaname,exchange,feeder,sort_order);
$(".executed-works-item-desc").css('display','none');
$(".executed-works-item-asc").css('display','block');
});
*/
$(document).on("change", "#sortby", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
sort_order = $('#sortby').val();
getallexecutedworksitems(1,areaname,exchange,feeder,sort_order);

});


$(function(){
  $(document).on("keydown.autocomplete",".puitemauto",function(e){
    $(this).autocomplete({
matchContains: "word",
autoFill: true,
      source : '../includes/autocomplete.php',
      
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