<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Exchange Divisions</h2></div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info add-new">Add New</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom:1em;">            
            <div class="col-sm-4">
            <span style="white-space: nowrap">
                <label for="size">Area :</label>
                <select class='form-control' name='areaname' id="areaname"><option value="">Select Area</option></select>
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
                        <th>Exchange</th>
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

function getallexchangedivision(pageno,areaname=''){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'exchangedivisionlist',pageno:pageno,areaname:areaname},
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
    data: {calltype:'exchangearealist'},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    $("#areaname").html(response);
    }   
});
}

$(document).ready(function(){
$(".add-new").attr("disabled", "disabled");
//get list of records
getallexchangedivision(1);
getareas();

$(document).on("change", "#areaname", function(){
areaname = $('#areaname').val();
getallexchangedivision(1,areaname);
if(areaname != ''){
$(".add-new").removeAttr("disabled");
}
else{
$(".add-new").attr("disabled", "disabled");
}
});

$(document).on("click", ".exchangedivision", function(){
areaname = $('#area').val();
pagenum = $(this).attr('pagenum');
getallexchangedivision(pagenum,areaname);
});

$('[data-toggle="tooltip"]').tooltip();
var actions = $("#actiontools").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    var row = '<tr>' +
        '<td><input type="text" class="form-control" name="exchange" id="exchange"></td>' +
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
    input.each(function(){
        if (areaname == ''){
            $( "<span class='errormessage'>Please select Area</span>" ).insertAfter( "#areaname" );
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
        var exchange = $(this).parents("tr").find('input[name="exchange"]').val();
        var calltype = 'exchangedivisionadd';
        if (id != '' && id != undefined){
            calltype = 'exchangedivisionedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, areaname:areaname, exchange:exchange,id:id},
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
        var names = ["exchange"];
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
    var exchange = $(this).parents("tr").find('td:first').text();
    var empty = false;
    areaname = $('#areaname').val();
    if (areaname == ''){
        $( "<span class='errormessage'>Please select Area</span>" ).insertAfter( "#areaname" );
        empty = true;
    }
    if(!empty){
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:'exchangedivisiondlt', areaname:areaname,exchange:exchange,id:id},
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

});

</script>
</body>
</html>