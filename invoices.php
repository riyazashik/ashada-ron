<?php
include_once("header.php");
?>
<style type="text/css">
	.exchangecheckboxes input {

  position: absolute;
  top: 0;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #2196F3;
  display: inline-block;
	}
	.exchangecheckboxes .checkbox-inline{
position: relative;
    display: inline-block;
    padding-left: 20px;
    margin-bottom: 0;
    font-weight: 400;
    vertical-align: middle;
    cursor: pointer;
    line-height: 25px;
}
</style>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6"><h2>Invoices</h2></div>
                    <div class="col-sm-6">
		                <h2>Create New Invoice</h2>
                       </div>
                </div>
            </div>

                <div class="row">

                    <div class="col-sm-5">
			            <table class="table table-bordered" style="width1:100% !important;" align="center">
			            <col width="50">
			            <col width="50">
			                <thead>
			                    <tr>
			                        <th>Invoice No</th>
			                        <th>Invoice Date</th>
			                    </tr>
			                </thead>
			                <tbody>
			                </tbody>
			            </table>
			            <div id="pagination_controls"></div>
            		</div>

                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-6">
                    <!-- ------------------------------------------------------------ -->
                        <p class="invoice-create-error-message error" style="color:red;"></p>
		                <div class="row" style="margin-top: 15px;">           
		                    <div class="col-sm-3">Invoice No</div>
		                    <div class="col-sm-9"><input type="text" name="invoiceid" id="invoiceid" class="form-control"  style='margin-bottom: 10px;'></div>
		                </div>    
		                <div class="row" style="margin-top: 15px;">
		                    <div class="col-sm-3">Invoice Date</div>
		                    <div class="col-sm-9"><input type="text" name="invoicedate" id="invoicedate" class="form-control"   style='margin-bottom: 10px; readonly'></div>
		                </div>
		 
		                <div class="row" style="margin-top: 15px;">
		                    <div class="col-sm-3">Type </div>
		                    <div class="col-sm-9"><select class='form-control' name='cabletype' id="cabletype"><option value="">ALL</option><option value="1">Civil Works</option><option value="1">Cable Works</option></select></div>
		                </div>
		                <div class="row" style="margin-top: 15px;">
		                    <div class="col-sm-3">Exchange</div>
		                    <div class="col-sm-9 exchangecheckboxes">
		                    <?php /*
		                    <select class='form-control' name='exchange' id="exchange" multiple><option value="">Select Exchange</option></select>
								*/ ?>
		                    <label class="checkbox-inline"><input type="checkbox" class="exchange exchangealloption" name="exchange" value="">ALL</label>
		                    </div>
			                <div class="row">
			                    <div class="col-sm-12 text-center" style=""><button type="button" class="btn btn-info save-invoice-trigger"  onclick1="saveinvoiceform()" >SAVE</button></div>
			                </div>
                    <!-- ------------------------------------------------------------ -->

            		</div>

            </div>
        </div>
    </div>     
    <script type="text/javascript">

function getallinvoicess(pageno){
    $.ajax({
    type: "POST",  
    url: "reportajaxprocess.php", 
    data: {calltype:'allinvoicelist',pageno:pageno},
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
    data: {calltype:'invoicepageexchangelist'},
    dataType: "json",    
    async: false,  
    success: function(response)  
    {
    //$("#exchange").html(response);
    $(".exchangecheckboxes").html(response);

    }   
});
}

$(document).ready(function(){
	$('#invoicedate').datepicker({
    dateFormat: "dd/mm/yy"
});
//get list of records
getallinvoicess(1);
getexchanges();

$(document).on("click", ".exchangealloption", function(){

        $('.exchange').each(function(i){
         $(this).attr('checked',true);
        });

});

$(document).on("click","#ckbCheckAll", function(){
$(".exchange").prop('checked', $(this).prop('checked'));
});

$(document).on("click", "input.exchange", function(){
    	$(".exchangealloption").prop('checked',false); 
});

$(document).on("click", ".save-invoice-trigger", function(){
    $('.errormessage').remove();
    $('.invoice-create-error-message').html('');
    invoiceid = $("#invoiceid").val();
    invoicedate = $("#invoicedate").val();
    cabletype = $("#cabletype").val();
    exchange = [];

        $('.exchange:checked').each(function(i){
          exchange[i] = $(this).val();
        });

    error = 0;
        if(invoiceid == ''){
            error = 1;
            $( "<span class='errormessage' style='color:red;'>Please enter invoice no</span>" ).insertAfter( "#invoiceid" );
        }
        if(invoicedate == ''){
            error = 1;
            $( "<span class='errormessage' style='color:red;'>Please enter invoice date</span>" ).insertAfter( "#invoicedate" );   
        }
        if (exchange.length <= 0) {
            error = 1;
            $( "<span class='errormessage' style='color:red;margin: 9px 9px 9px 159px;'>Please select exchange</span>" ).insertAfter( ".exchangecheckboxes" );
        }

        if(!error){
    $.ajax({
        type: "POST",  
        url: "reportajaxprocess.php", 
        data: {calltype:'saveinvoices', invoiceid:invoiceid, invoicedate:invoicedate, cabletype:cabletype, exchange:exchange},
        dataType: "json",      
        success: function(response)  
        {
        if(response.status == 1){

    $("#invoiceid").val('');
   $("#invoicedate").val('');
    $("#cabletype").val('');
    $(".exchange").prop('checked', false); 
    $("#ckbCheckAll").prop('checked', false); 
        //$("#myModal").modal('hide');
        $("table tbody").html(response.html);
        $("#pagination_controls").html(response.pagination);
        $(".successmessage").html(response.successmessage);
        $("#myModalsuccess").modal('show');
        getallinvoicess(1);
        }
        else
        {
            $('.invoice-create-error-message').html(response.message);
        }
        }   
    });
    }
});
  //  document.multiselect('#exchange');
});

</script>
</body>
</html>