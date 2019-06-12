<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Feeder Divisions</h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new">Add New</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:1em;">
            <div class="col-sm-5">
                <span style="white-space: nowrap">
                    <label for="size">Area :</label>
                    <select class='form-control' name='areaname' id="areaname"><option value="">Select Area</option></select>
                </span>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-5">
                <span style="white-space: nowrap">
                    <label for="size">Exchange :</label>
                    <select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select>
                </span>
                </div>
            </div>
            <div id="actiontools" style="display:none">
            <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
            <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
            <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Feeders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="pagination_controls"></div>
        </div>
    </div>     
    <script type="text/javascript">

function getallfeederdivision(pageno,areaname='',exchange=''){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'feederdivisionlist',pageno:pageno,areaname:areaname,exchange:exchange},
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
    data: {calltype:'feederdivisionarealist'},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#areaname").html(response);
    }   
});
}
function getexchanges(areaname){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'feederdivisionexchangelist',areaname:areaname},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#exchange").html(response);
    }   
});
}

$(document).ready(function(){
$(".add-new").attr("disabled", "disabled");
//get list of records
getallfeederdivision(1);
getareas();
getexchanges();

$(document).on("change", "#areaname", function(){
areaname = $('#areaname').val();
getallfeederdivision(1,areaname);
getexchanges(areaname);
if(areaname == ''){
$(".add-new").attr("disabled", "disabled");
}
});

$(document).on("change", "#exchange", function(){
areaname = $('#areaname').val();
exchange = $(this).val();
getallfeederdivision(1,areaname,exchange);
if(exchange != ''){
$(".add-new").removeAttr("disabled");
}
else {
$(".add-new").attr("disabled", "disabled");
}
});

$('[data-toggle="tooltip"]').tooltip();
var actions = $("#actiontools").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    var row = '<tr>' +
        '<td><input type="text" class="form-control" name="feeder" id="feeder"></td>' +
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
    areaname = $('#areaname').val();
    exchange = $('#exchange').val();
    input.each(function(){
        if (areaname == '' || exchange == ''){
        if (areaname == ''){
            $( "<span class='errormessage'>Please select Area</span>" ).insertAfter( "#areaname" );
            empty = true;
        }
        if (exchange == ''){
            $( "<span class='errormessage'>Please select Exchange</span>" ).insertAfter( "#exchange" );
            empty = true;
        }
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
        var feeder = $(this).parents("tr").find('input[name="feeder"]').val();
        var calltype = 'feederdivisionadd';
        if (id != '' && id != undefined){
            calltype = 'feederdivisionedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, areaname:areaname, exchange:exchange, feeder:feeder, id:id},
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
        var names = ["feeder"];
        var currentindex = $(this).index();
        $(this).html('<input type="text" class="form-control" name="' +names[currentindex]+ '" value="' + $(this).text() + '">');        
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $(this).parents("tr").find('.add > .material-icons').text("save");
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).attr("itemid");
    areaname = $('#areaname').val();
    exchange = $('#exchange').val();
    var feeder = $(this).parents("tr").find('td:first').text();
    $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'feederdivisiondlt', id:id,areaname:areaname,exchange:exchange,feeder:feeder},    
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
});

});

</script>
</body>
</html>