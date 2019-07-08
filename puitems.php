<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Plant Unit Items</h2></div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-6">
                            <button type="button" class="btn btn-info add-new">Add New</button>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-info" onclick="PrintMe('printableArea')" >Print</button>                 
                            </div>
                    </div>
                    </div>
                </div>
            </div>
            <div id="actiontools" style="display:none">
            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
            </div>
            <div id="printableArea"> 
            <table class="table table-bordered">
            <col width="20">
            <col width="30">
            <col width="260">
            <col width="30">
            <col width="40">
            <col width="35">
            <col width="35">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th class="righttd">Unit price ($)</th>
                        <th class="righttd">Design qty</th>
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
   //var content_vlue = document.getElementById(DivID).innerHTML;
   var content_vlue = document.getElementById(DivID).innerHTML.replace(/id="first_child"/g,'id="first_child" style="display:none"').replace(/id="actions"/g,'id="actions" style="display:none"').replace(/<th>Action/g,'<th style="display:none">Action');
   var docprint=window.open("","",disp_setting);
   $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'puitemslistPrint',pageno:0},
        dataType: "json",      
        success: function(response)  
        {
            var intialhtml='<table class="table"> <col width="20"><col width="30"><col width="260"><col width="30"><col width="40"><col width="35">';
            intialhtml += '<thead><tr><th>Type</th><th>PU item</th><th>Description</th><th>Unit</th><th class="righttd">Unit price ($)</th><th class="righttd">Design qty</th></tr></thead><tbody>';

            html = intialhtml +  response.html + '</tbod></table>';
            docprint.document.open();
            docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
            docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
            docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
            docprint.document.write('<head><title> PU Items</title>');
                //docprint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css"><style type="text/css">@page {size: auto;   margin: 0mm;}body  { background-color:#FFFFFF; border: solid 1px black ; margin: 0px;');
            docprint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css"><style type="text/css">body{ margin:0px;');
            docprint.document.write('font-family:verdana,Arial;color:#000;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            docprint.document.write('a{color:#000;text-decoration:none;}table .righttd { text-align: right;}table, th, td {border: 1px solid black;}.table>thead>tr>th {vertical-align:bottom;border-bottom:1px solid black;}.table>tbody>tr>td{bottom;border-top:1px solid black;}</style>');
            docprint.document.write('</head><body onLoad="self.print()"><center>');
            docprint.document.write(html);
            docprint.document.write('</center></body></html>');
            docprint.document.close();
            docprint.focus();
        }
    });
}
function getallpuitems(pageno){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'puitemslist',pageno:pageno},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    $("#pagination_controls").html(response.pagination);
    }   
});
}
function getunits(units){
unitname = '';
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'unitslist',units:units},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    unitname = response;
    }   
});
return unitname;
}

$(document).ready(function(){
//get list of records
getallpuitems(1);

$(document).on("keyup", "input[name='type']", function(){
  if (/\D/g.test(this.value)){
    this.value = this.value.replace(/\D/g, '');
  }
  else if(this.value > 2 || this.value < 1){
    this.value = '';
  }
});

$(document).on("keyup", "input[name='unitprice']", function(){
  if (/\D/g.test(this.value)){
    this.value = this.value.match(/^\d+\.?\d{0,3}/);
  }
});

$(document).on("keyup", "input[name='designqty']", function(){
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
    var row = '<tr id="first_child">' +
        '<td><input type="text" class="form-control" name="type" id="type"></td>' +
        '<td><input type="text" class="form-control" name="puitem" id="puitem"></td>' +
        '<td><input type="text" class="form-control" name="description" id="description"></td>' +
        '<td>'+ getunits("") +'</td>' +
        '<td><input type="text" class="form-control" name="unitprice" id="unitprice"></td>' +
        '<td><input type="text" class="form-control" name="designqty" id="designqty"></td>' +
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
    input.each(function(){
            if(!$(this).val()){
            $(this).addClass("error");
            empty = true;
        } else{
            $(this).removeClass("error");
        }
    });
    if(!empty){
        var id = $(this).attr("itemid");
        var type = $(this).parents("tr").find('input[name="type"]').val();
        var puitem = $(this).parents("tr").find('input[name="puitem"]').val();
        var description = $(this).parents("tr").find('input[name="description"]').val();
        var unit = $(this).parents("tr").find('select[name="units"]').val();
        var unitprice = $(this).parents("tr").find('input[name="unitprice"]').val();
        var designqty = $(this).parents("tr").find('input[name="designqty"]').val();
        var calltype = 'puitemsadd';
        if (id != '' && id != undefined){
            calltype = 'puitemsedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, type:type, puitem:puitem, description:description, unit:unit, unitprice:unitprice, designqty:designqty, id:id},
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
        var names = ["type", "puitem", "description", "unit", "unitprice", "designqty"];
        var currentindex = $(this).index();
        if (currentindex == 3){
            $(this).html(getunits($(this).text()));
        }
        else {
        $(this).html('<input type="text" class="form-control" name="' +names[currentindex]+ '" value="' + $(this).text() + '">');
        }
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $(this).parents("tr").find('.add > .material-icons').text("save");
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).attr("itemid");    
    if(id == '' || id == undefined ){
        getallpuitems(1);
        $(".add-new").removeAttr("disabled");
        return false;
    }
    $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'puitemsdlt', id:id},
        dataType: "json",      
        success: function(response)  
        {
        $("table tbody").html(response.html);
        $("#pagination_controls").html(response.pagination);
        $(".successmessage").html(response.successmessage);
        $("#myModalsuccess").modal('show');
        }   
    });
    $(".add-new").removeAttr("disabled");
});

});


</script>
</body>
</html>