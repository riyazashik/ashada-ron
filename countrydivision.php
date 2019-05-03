<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Country Divisions</h2></div>
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S. No</th>
                        <th>Area</th>
                        <th>Exchanges</th>
                        <th>Feeders</th>
                        <th>Actions</th>
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

function getallcountrydivision(pageno){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'countrydivisionlist',pageno:pageno},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    $("#pagination_controls").html(response.pagination);
    }   
});
}
function getareanames(area){
areaname = '';
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'areanameslist',area:area},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    areaname = response;
    }   
});
return areaname;
}

$(document).ready(function(){
//get list of records
getallcountrydivision(1);

$('[data-toggle="tooltip"]').tooltip();
var actions = $("table td:last-child").html();
// Append table with add row form on add new button click
$(".add-new").click(function(){
    $(this).attr("disabled", "disabled");
    var index = $("table tbody tr:first-child").index();
    var row = '<tr>' +
        '<td></td>' +
        '<td>'+ getareanames("") +'</td>' +
        '<td><input type="text" class="form-control" name="exchange" id="exchange"></td>' +
        '<td><input type="text" class="form-control" name="feeder" id="feeder"></td>' +
        '<td>' + actions + '</td>' +
    '</tr>';
    $("table tbody tr:first-child").before(row);
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
        var id = $(this).parents("tr").find('input[name="slid"]').val();
        var areaname = $(this).parents("tr").find('select[name="areaname"]').val();
        var exchange = $(this).parents("tr").find('input[name="exchange"]').val();
        var feeder = $(this).parents("tr").find('input[name="feeder"]').val();
        var calltype = 'countrydivisionadd';
        if (id != '' && id != undefined){
            calltype = 'countrydivisionedit'
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
        var names = ["slid", "areaname", "exchange", "feeder"];
        var currentindex = $(this).index();
        if (currentindex == 1){
            $(this).html(getareanames($(this).text()));
        }
        else {
        $(this).html('<input type="text" class="form-control" name="' +names[currentindex]+ '" value="' + $(this).text() + '">');
        }
    });
    $(this).parents("tr").find(".add, .edit").toggle();
    $('[name="slid"]').css("display", "none");
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).parents("tr").find("td:first-child").text();
    $.ajax({
        type: "POST",  
        url: "ajaxprocess.php", 
        data: {calltype:'countrydivisiondlt', id:id},
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