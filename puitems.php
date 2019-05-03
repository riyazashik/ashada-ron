<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Plant Unit Items</h2></div>
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
                        <th>Type</th>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Unit price($)</th>
                        <th>Design qty</th>
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
    this.value = this.value.match(/^\d+\.?\d{0,2}/);
  }
});

$(document).on("keyup", "input[name='designqty']", function(){
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
    var row = '<tr>' +
        '<td><input type="text" class="form-control" name="type" id="type"></td>' +
        '<td><input type="text" class="form-control" name="puitem" id="puitem"></td>' +
        '<td><input type="text" class="form-control" name="description" id="description"></td>' +
        '<td>'+ getunits("") +'</td>' +
        '<td><input type="text" class="form-control" name="unitprice" id="unitprice"></td>' +
        '<td><input type="text" class="form-control" name="designqty" id="designqty"></td>' +
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
    //$('[name="slid"]').css("display", "none");
    $(".add-new").attr("disabled", "disabled");
});
// Delete row on delete button click
$(document).on("click", ".delete", function(){
    var id = $(this).attr("itemid");
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
        }   
    });
    $(".add-new").removeAttr("disabled");
});

});

</script>
</body>
</html>