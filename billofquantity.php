<?php
include_once("header.php");
include_once("includes/function_printer.php");
?>
<style>

.table-wrapper {
    width: 95%;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
    margin-top: 30px !important;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
}
table tr td.tdcellbold{
    font-weight: bold;
}

table>thead>tr>th, table>tbody>tr>td{
    max-width: 30px !important;
    min-width: 15px !important;
    width:20px !important;
}
table .righttd {
    text-align: right;
}
</style>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Bill of Quantities</h2></div>
                    <div class="col-sm-2">  <button type="button" class="btn btn-info create-invoice-trigger1" data-toggle="modal" data-target="#myModal"  style="float:right;display: none;">CREATE INVOICE</button>                      
                    </div>
                    <div class="col-sm-2">
                     <div class="row">
                        <div class="col-sm-6">
                      <!--  <button type="button" class="btn btn-info create-invoice-trigger"  onclick="showinvoiceform()" >CREATE INVOICE</button>-->
                            <button type="button" class="btn btn-info export-excel-button"  onclick="validateexportfilterform()"  style="display: none;" >Export Excel</button>
                        </div>
                        <div class="col-sm-1">
                        <button type="button" class="btn btn-info export-excel-print" style="display:none;" onclick="PrintMe('printableArea')" >Print</button>                 
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row">

                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Create Invoice</h4>
                              </div>
                              <div class="modal-body">
                                <p></p>
                <div class="row">           
                    <div class="col-sm-3"><h4>Invoice ID</h4></div>
                    <div class="col-sm-9"><input type="text" name="invoiceid" id="invoiceid" class="form-control"></div>
                </div>    
                <div class="row">
                    <div class="col-sm-3"><h4>Invoice Date</h4></div>
                    <div class="col-sm-9"><input type="text" name="invoicedate" id="invoicedate" class="form-control" ></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center" style=""><button type="button" class="btn btn-info save-invoice-trigger"  onclick="saveinvoiceform()" >SAVE</button></div>
                </div>
                              </div>

                          </div>
                        </div>

                </div>

               

                <div class="row">
                    <div class="col-sm-8"><span class="error errormessage"></span></div>
                </div>
                <div class="row">
                    <div class="col-sm-8"><span class="success successmessage"></span></div>
                </div>
            </div>

                <div class="row" style="height:30px !important;"> 
                </div>  
                <?php /*
            <div class="row" style="margin-bottom:1em;">
            <form id="summaryofexecutedworkslistform" action="report.php" method="POST">
            <div class="col-sm-2"><h4>Area:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='area' id="area"><option value="">ALL</option></select></div>
            <div class="col-sm-2"><h4>Exchange:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='exchange' id="exchange"><option value="">Select Exchange</option></select></div>
            <div class="col-sm-2"><h4>Feeder:</h4></div>
            <div class="col-sm-2"><select class='form-control' name='feeder' id="feeder"><option value="">Select Feeder</option></select></div>            
            </form>
            </div> */ ?>



            <div class="row" style="margin-bottom:1em;">
            <form id="summaryofexecutedworkslistform" action="report2.php" method="POST">
                    <div class="row">
                    <div class="col-sm-2" style="left:10px;">
                    <span style="white-space: nowrap">
                    <label for="size">Area:</label>
                    <select class='form-control' name='area' id="area"><option value="">ALL</option></select>
                    </span>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2">
                    <span style="white-space: nowrap">
                    <label for="size">Exchange:</label>
                    <select class='form-control' name='exchange' id="exchange"><option value="">ALL</option></select>
                    </span>
                    </div>

                    <div class="col-sm-1"></div>
                    <div class="col-sm-2">
                    <span style="white-space: nowrap">
                    <label for="size">Feeder:</label>
                    <select class='form-control' name='feeder' id="feeder"><option value="">ALL</option></select>
                    </span>
                    </div>     
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2">
                    <span style="white-space: nowrap">
                    <label for="size">Invoice No:</label>
                    <select class='form-control' name='invoice' id="invoice"><option value="">Select Invoice No</option></select>
                    </span>
                    </div>
                    </div>         
            </form>
            </div>
            <div id="printableArea" >
            <table class="table table-bordered">

            <col width="5">
            <col width="20">
            <col width="3">
            <col width="5">
            <col width="5">
                <thead>

                    <tr>
                        <th colspan="3"></th>
                        <th colspan="3" class="text-center">Design</th>
                        <th colspan="3" class="text-center">Executed qty</th>
                        <th colspan="3" class="text-center">Executed value</th>
                    </tr>

                    <tr>
                        <th>PU item</th>
                        <th>Description</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Unit</br>Price ($)</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Value ($)</th>
                        <th class="text-center">Previous</br>month</th>
                        <th class="text-center">This</br>month</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Previous</br>month ($)</th>
                        <th class="text-center">This</br>month ($)</th>
                        <th class="text-center">Total ($)</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                <td colspan="12">No Items Found</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>     
    <script type="text/javascript">

function PrintMe(DivID) {
var disp_setting="toolbar=yes,location=no,";
disp_setting+="directories=yes,menubar=yes,";
disp_setting+="scrollbars=no,width=1000px, height=700px";
   var content_vlue = document.getElementById(DivID).innerHTML.replace(/class="table table-bordered"/g,'class="table"');
   var docprint=window.open("","",disp_setting);
   var areaname = $('#area').val();
    var header ='';
    var footer ='';
   var exchange = $('#exchange').val();
    var feeder = $('#feeder').val();
    var invoice = $('#invoice').val();
   $.ajax({
        type: "POST",  
        url: "includes/function_printer.php", 
        data: {calltype:'getPrinterHeaderFooter', name:'BOQ',areaname:areaname,exchange:exchange,feeder:feeder,type:'',invoice:invoice},
        dataType: "json",      
        success: function(response)  
        {
            header= response.header;
            footer= response.footer;
            docprint.document.open();
            docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
            docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
            docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
            docprint.document.write('<head><title>Bill of Quantities - FFTX');
            //docprint.document.write(header);
            docprint.document.write('</title>');
            docprint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css"><style type="text/css">@page{ size: auto;margin:3px;');
            docprint.document.write('font-family:verdana,Arial;color:#000;');
            docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
            //docprint.document.write('a{color:#000;text-decoration:none;} table .righttd { text-align: right;}</style>');
            docprint.document.write('a{color:#000;text-decoration:none;}table .righttd { text-align: right;}table, th, td {border: 1px solid black;}.table>thead>tr>th {vertical-align:bottom;border-bottom:1px solid black;}.table>tbody>tr>td{bottom;border-top:1px solid black;}</style>');
            docprint.document.write('</head><body onLoad="self.print()"><center>');
            docprint.document.write(header);
            docprint.document.write("</br>");
            docprint.document.write(content_vlue);
            docprint.document.write('</center>');
            docprint.document.write(footer);
            docprint.document.write('</body></html>');
            docprint.document.close();
            docprint.focus();
        }
    });
}

function getallexecutedworksitems(areaname='',exchange='',feeder='',invoice=''){
    $.ajax({
    type: "POST",  
    url: "reportajaxprocess.php", 
    data: {calltype:'billofquantity',areaname:areaname,exchange:exchange,feeder:feeder,invoice:invoice},
    dataType: "json",      
    async: false,     
    success: function(response)  
    {
    $("table tbody").html(response.html);
    if(response.invoicetotal > 0 )
        $('.create-invoice-trigger').css('display','block');
    else
        $('.create-invoice-trigger').css('display','none');
    if(response.total > 0 )
    {
        $('.export-excel-button').css('display','block');
        $('.export-excel-print').css('display','block');
    }
    else
    {   
        $('.export-excel-button').css('display','none'); 
        $('.export-excel-print').css('display','none');   
    }
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
    $("#summaryofexecutedworkslistform").submit();  
}

function showinvoiceform(){
            $(".errormessage").html('');
    var empty = false;
    areaname = $('#area').val();
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();

        if (areaname == '' || exchange == ''){
            $(".errormessage").html('Please select Areaname and Exchange value');
        }
        else{
            $('#invoicegenerationattributes').css('display','block');
            $('.create-invoice-trigger').css('display','none');
        }
}

function saveinvoiceform(){
            $(".errormessage").html('');
    var empty = false;
    areaname = $('#area').val();
    exchange = $('#exchange').val();
    feeder = $('#feeder').val();
    pageno = 1;
    invoiceid = $('#invoiceid').val();
    invoicedate = $('#invoicedate').val();
        if(invoiceid == ''){
            //$(".errormessage").html('Please enter invoice id');
            $( "<span class='errormessage'>Please enter invoice id</span>" ).insertAfter( "#invoiceid" );

        }
        else if(invoicedate == ''){
            //$(".errormessage").html('Please enter invoice date');
            $( "<span class='errormessage'>Please use MM/DD/YYYY format</span>" ).insertAfter( "#invoicedate" );
            
        }
        else{
             generateinvoiceforexecutedworksitems(areaname,exchange,feeder,invoiceid, invoicedate);
             getallexecutedworksitems(areaname='',exchange='',feeder='');
            $('#invoicegenerationattributes').css('display','none');
            $('.create-invoice-trigger').css('display','block');
            $("#myModal").modal('hide');
            //$('#myModal .close').trigger('click');
        }
}

function generateinvoiceforexecutedworksitems(areaname='',exchange='',feeder='',invoiceid,invoicedate){

    $.ajax({
        type: "POST",  
        url: "reportajaxprocess.php", 
        data: {calltype:'generateinvoices',areaname:areaname,exchange:exchange,feeder:feeder,invoiceid:invoiceid,invoicedate:invoicedate},
        dataType: "json",      
        success: function(response)  
        {
        $("table tbody").html(response.html);
        alert(response);return false;
        if (response == '1'){
            $("#mymodal").css('display','none');
        }
        }   
    });

}

    function validatedate() {
    text = $('#invoicedate').val();
    if (/\d+\/\d+\/\d{4}/.test(text))
    {// good input
    }
      else { // bad input
            $( "<span class='errormessage'>Please use MM/DD/YYYY format</span>" ).insertAfter( "#invoicedate" );
      }
    }

$(document).ready(function(){
getareas();
getexchanges();
getfeeders();
getinvoice();
//get list of records
getallexecutedworksitems();

//getpuitems();


$(document).on("change", "#area", function(){
areaname = $('#area').val();
getallexecutedworksitems(areaname);
getexchanges(areaname);
getfeeders('');
getinvoice(areaname);
});

$(document).on("change", "#exchange", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
getallexecutedworksitems(areaname,exchange);
getfeeders(exchange);
getinvoice(areaname,exchange);
});

$(document).on("change", "#feeder", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
getinvoice(areaname,exchange,feeder);
getallexecutedworksitems(areaname,exchange,feeder);
});

$(document).on("change", "#invoice", function(){
areaname = $('#area').val();
exchange = $('#exchange').val();
feeder = $('#feeder').val();
invoice = $('#invoice').val();
getallexecutedworksitems(areaname,exchange,feeder,invoice);
});

//$('#invoicedate').on('keyup', 'input', validatedate);

$(document).on("blur", "input[name='invoicedate']", validatedate);
/*$(document).on("blur", "input[name='invoicedate']", function(){

  if (/\D/g.test(this.value)){
    this.value = this.value.replace(/\D/g, '');
  }
  else if(this.value > 2 || this.value < 1){
    this.value = '';
  }
validatedate();
});
*/

});

</script>
</body>
</html>