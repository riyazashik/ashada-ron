<?php
include_once("header.php");
?>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Design Quantity</h2></div>
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
            <div class="col-sm-2"><h4>Exchange:</h4></div>
            <div class="col-sm-4"><select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select></div>
            <div class="col-sm-2"><h4>Feeder:</h4></div>
            <div class="col-sm-4"><select class='form-control' name='feeder' id="feeder"><option value="">Select Feeder</option></select></div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>PU item</th>
                        <th>Description</th>
                        <th>Unit</th>
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

function getalldesignquantityitems(pageno,exchange='',feeder=''){
    $.ajax({
    type: "POST",  
    url: "ajaxprocess.php", 
    data: {calltype:'designquantitylist',pageno:pageno,exchange:exchange,feeder:feeder},
    dataType: "json",      
    success: function(response)  
    {
    $("table tbody").html(response.html);
    $("#pagination_controls").html(response.pagination);
    }   
});
}
function getexchanges(){
    $.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'exchangelist'},
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
    data: {calltype:'feederlist',exchange:exchange},
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
    data: {calltype:'puitemlist',puitem:puitem},
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
getalldesignquantityitems(1);

getpuitems();

getexchanges();

$(document).on("change", "#exchange", function(){
exchange = $(this).val();
getalldesignquantityitems(1,exchange);
getfeeders(exchange);
});

$(document).on("change", "#feeder", function(){
exchange = $('#exchange').val();
feeder = $('#feeder').val();
getalldesignquantityitems(1,exchange,feeder);
});

$(document).on("change", ".puitems", function(){
puitem = $(this).val();
descriptioncell = $(this).parents("tr").find('td').eq(1);
unit = $(this).parents("tr").find('td').eq(2);
$.ajax({
    type: "POST",
    url: "ajaxprocess.php", 
    data: {calltype:'getcurrentitem',puitem:puitem},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    descriptioncell.html(response.description);
    unit.html(response.unit);
    }   
});
});

$(document).on("click", ".designqntypag", function(){
exchange = $('#exchange').val();
feeder = $('#feeder').val();
pagenum = $(this).attr('pagenum');
getalldesignquantityitems(pagenum,exchange,feeder);
getfeeders(exchange);
});

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
    if(index == '-1'){
        index = 0;
    }
    var row = '<tr>' +
        '<td>'+ getpuitems("") +'</td>' +
        '<td></td>' +
        '<td></td>' +
        '<td><input type="text" class="form-control" name="designqty" id="designqty"></td>' +
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
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();
    input.each(function(){
        if (exchange == ''){
            alert('Please select Exchange value');
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
        var puitemid = $(this).parents("tr").find('select[name="puitems"]').val();
        var designqty = $(this).parents("tr").find('input[name="designqty"]').val();
        var calltype = 'designquantityadd';
        if (id != '' && id != undefined){
            calltype = 'designquantityedit'
        }
        $.ajax({
            type: "POST",  
            url: "ajaxprocess.php", 
            data: {calltype:calltype, exchange:exchange,feeder:feeder,puitemid:puitemid, designqty:designqty, id:id},
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
        var names = ["puitems", "description", "unit", "designqty"];
        var currentindex = $(this).index();
        if (currentindex == 0){
            $(this).html(getpuitems($(this).text()));
        }
        else if (currentindex == 3){
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
        data: {calltype:'designquantitydlt', id:id},
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