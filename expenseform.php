

<?php
  session_start();
  
  if (!$conn)
   {
      if (file_exists('Database/config.php') )
      {
          include("Database/config.php");
      }
      else 
      {
          include("../Database/config.php");
      }
      $conn = getConnection();
   }
  
  $id = intval($_REQUEST['id']);
  $userId = $_SESSION['userid'];
  $inSubmission = false;
  $formId = -1;
  if ($id != 0)
  {
    $thisForm = "select expense_reports_id, submitter_id, approver_id, expensereport_status from expense_reports where expense_reports_id = '".$id."'";
    $res = mysqli_query($conn, $thisForm);
    $row = mysqli_fetch_assoc($res);
    
    $formId = $row['expense_reports_id'];
    $submitterId = $row['submitter_id'];
    $approverId = $row['approver_id'];
    $status = $row['expensereport_status'];
    
    $isSubmitter = false;
    $isApprover = false;
    if ($status == "Saved")
    {
      $inSubmission = true;
    }
    if ($userId == $approverId )
    {
      $isApprover = true;
    }
    else if( $userId == $submitterId ) 
    {
      $isSubmitter = true;
    }
    
  }
  else {
      $inSubmission = true;
  }

  

  
  //include("Database/config.php");
  //$conn = getConnection();
?>

<script>
function DisplayExpense(element)
{
    
    var section = element.selectedOptions[0].id + "_expense";
    section = section.toLowerCase();
    var section = document.getElementById(section);
    $(section).css("display", "block");

}
function DoCheckUncheckDisplay(element, sectionId)
{
    var section = document.getElementById(sectionId);
    if  (element.checked == true)
    {
      
        $(section).css("display", "block");
        //document.getElementById(dunchecked).style.display = "none";
    }
    else
    {
        $(section).css("display", "none");
    }
}
</script>

<!DOCTYPE html>
<html>
  <style>
    table, th, td {
      border: 3px solid gray;
    }
  </style>
<body>
  <div class="container">
            <div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width:70%"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <button align="left" type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                <button data-toggle="modal" id="btnPrint" style="margin-left: 87%;" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i> Preview</button>
                                <button data-toggle="modal" onclick="getprint()" style="margin-left: 87%;" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i> Print</button>
                            <h4 class="modal-title">
                            	<i class="glyphicon glyphicon-list-alt"></i> Expense Form
                            </h4> 
                       </div> 
                       <div class="modal-body" id="masterContent"> 
                       	   <div id="modal-loader2" style="display: none; text-align: center;">
                       	   <img src="images/ajax-loader.gif">
                       	   </div>
                           <div class="row">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <div class="well panel panel-default" >
                                        <div class="panel-body">                                       
                                            <!-- content will be load here -->                          
                                            <div id="dynamic-content2">
                                              
                                            </div>   
                                        </div>
                                        <div class="col-lg-1"></div>
                                    </div>
                                </div>
                           </div> 
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                    </div> 
              </div>
           </div>
        </div>         
  
  
  <form id="expenseForm" action="Forms/submitform.php?action=submit" method="POST" enctype="multipart/form-data" > 
    <input id="formId" name="formId" value="<?php echo $formId; ?>" style="display:none;">
    <div id="General">
     <?php include("general_information_form.php");?>
    </div>
     <b>Expenditures:</b>
    <table id="ExpenseTable">
      <thead>
        <tr>
        <td></td>
        <td>Start Date</td>
        <td>End Date</td>
        <td>Expense Type</td>
        <td>Expense Total</td>
      </tr>
      </thead>
      <tbody>
        <tr id="templateRow" style="display:none">
        <td width="5%"  align="center">
          <input type="checkbox" name="selectedRow" id="selectedRow">  
        </td>
        <td>
          <input type="date" id="ExpenseStartDate" class="form-control">
        </td>
        <td>
          <input type="date" id="ExpenseEndDate" class="form-control">
        </td>
        <td width="25%">
          <select type="text" class="form-control" id="ExpenseType" name="ExpenseType" list = "list1" style="display:inline-block; width:100%" onchange="DisplayExpense(this)">
            <option value = "- Expense Type -" selected >- Expense Type -</option>
            <option name="Air"  id="Air" value="Air">Air</option>
            <option name="Land"  id="Land" value="Land">Land</option>
            <option name="Hotel"  id="Hotel" value="Hotel">Hotel</option>
            <option name="Food"  id="Food" value="Food">Food</option>
            <option name="Other"  id="Other" value="Other">Other</option>
        </select>
        </td>
        <td>
          <input id="ExpenseAmount" type="number">
        </td>
      </tr>
      <tr id="dataRow">
        <td width="5%" align="center">
          <input type="checkbox" name="selectedRow" id="selectedRow">  
        </td>
        <td>
          <input type="date" id="ExpenseStartDate" class="form-control">
        </td>
        <td>
          <input type="date" id="ExpenseEndDate" class="form-control">
        </td>
        <td width="25%">
          <select type="text" class="form-control" id="ExpenseType" name="ExpenseType" list = "list1" style="display:inline-block; width:100%" onchange="DisplayExpense(this)">
            <option value = "- Expense Type -" selected >- Expense Type -</option>
            <option name="Air"  id="Air" value="Air">Air</option>
            <option name="Land"  id="Land" value="Land">Land</option>
            <option name="Hotel"  id="Hotel" value="Hotel">Hotel</option>
            <option name="Food"  id="Food" value="Food">Food</option>
            <option name="Other"  id="Other" value="Other">Other</option>
        </select>
        </td>
        <td>
          <input id="ExpenseAmount" type="number" onclick="OpenDialog(this)">
        </td>
      </tr>
      </tbody>
      
      
    </table>
    <a onclick="addRowToTable()" style="padding-right:10px" >Add Row</a>
    <a onclick="deleteSelectedRow()" style="padding-right:10px" >Delete Selected Rows</a>
    <a onclick="copySelectedRow()" style="padding-right:10px" >Copy Selected Rows</a>
    <br>
    <hr>
      <!--
  
    <input type="checkbox" name="Air" id="Air" onchange="DoCheckUncheckDisplay(this,'air_expense')"  value="Air">Air Travel<br>
    <input type="checkbox" name="Land" id="Land"onchange="DoCheckUncheckDisplay(this,'land_expense')"  value="Land">Land Travel<br>
    <input type="checkbox" name="Hotel" id="Hotel" onchange="DoCheckUncheckDisplay(this,'hotel_expense')"  value="Hotel">Hotel<br>
    <input type="checkbox" name="Food" id="Food" onchange="DoCheckUncheckDisplay(this,'food_expense')" value="Food">Food<br>
    <input type="checkbox" name="Other" id="Other" onchange="DoCheckUncheckDisplay(this,'other_expense')" value="Other">Other
    -->
    
    <div>
    <div id="air_expense", style="display:none">
     <?php include("air_expense_form.php")?>
    </div>
    
    <div id="land_expense", style="display:none">
      <?php include("land_expense_form.php")?>
    </div>
    
    <div id="hotel_expense", style="display:none">
      <?php include("hotel_expense_form.php")?>
    </div>
    
    <div id="food_expense", style="display:none">
      <?php include("food_expense_form.php")?>
    </div>
    
    <div id="other_expense", style="display:none">
      <?php include("other_expense_form.php")?>
    </div>
    <div>
      <?php 
      
        $sql = "select * from attachments where expenseform_id = '".$formId."'";
        $select = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select))
        {
          $path = $row['uploadpath'];
          echo '<a href="'.$path.'" >Link</a>';
        }
        if ($inSubmission)
        {
          echo '<label for="air_receipt_upload">Upload a Receipt: </label><br>
                <input type="file" name="attachments[]" id="attachments" multiple>';
        }
      ?>
      
      
      
    </div>
    <br>
    <?php
      if ($isApprover == true)
      {
        echo '<a href="Forms/routeform.php?action=approve&fid='.$id.'" class="btn btn-default" id="approve">Approve</a>';
        echo '<a href="Forms/routeform.php?action=deny&fid='.$id.'" class="btn btn-default" id="deny">Deny</a>';
      }
      else if ($inSubmission) 
      {
        $onClick = 'document.getElementById("expenseForm").submit()';
        echo '<input class="btn btn-default" type= "submit"  value="Submit" id="submit" name="submit" value="">';
        echo '<a onclick="saveForm()" class="btn btn-default" id="save">Save</a>';
      }
      
    ?>
    
    </div>
  </form>
</body>
<script>
/*$("#expenseform input").prop("disabled", true);
$("#expenseform input").css("background-color", "#f5f5f5");
$("#expenseform input").css("border", "#f5f5f5");
$("#expenseform textarea").prop("disabled", true);
$("#expenseform textarea").css("background-color", "#f5f5f5");
$("#expenseform textarea").css("border", "#f5f5f5");
$('#homeTabs').on("click", "li", function (event) {         
   var activeTab = $(this).find('a').attr('href');
    if(activeTab == "#expenseform"){
          $("input").prop("disabled", false);
          $("input").css("background-color", "");
          $("input").css("border", "");
          $("textarea").prop("disabled", false);
          $("textarea").css("background-color", "");
    }
});*/
    $(document).ready(function()
    {
        var form_id = "<?php echo $id ?>";
    
    
        if (form_id != "0")
        {
          $.ajax({
    			url: 'WebService/forminfo.php',
    			type: 'POST',
    			data: { "val": "getExpenseTypes","formid":form_id },
    
      		})
      		.done(function(data){
      		    var expenseTypes = JSON.parse(data);
                  for (var i = 0; i<= expenseTypes.length-1; i++)
                  {
                      var fieldId = expenseTypes[i].fieldId;
                      var fieldValue = expenseTypes[i].fieldValue;
                      var checked = fieldValue == "checked" ? true : false;
                      var expenseTypeField = document.getElementById(fieldId);
                      $(expenseTypeField).attr("checked",checked);
                      $(expenseTypeField).trigger("change");
                  }
                 
      		})
      		.fail(function(){
      			
      		});
      		$.ajax({
    			url: 'WebService/forminfo.php',
    			type: 'POST',
    			data: { "val": "getExpenseFields","formid":form_id },
    
      		})
      		.done(function(data){
      		    var expenseFields = JSON.parse(data);
                  for (var i = 0; i<= expenseFields.length-1; i++)
                  {
                      var fieldId = expenseFields[i].fieldId;
                      var fieldValue = expenseFields[i].fieldValue;
                      var expenseTypeField = document.getElementById(fieldId);
                      if (fieldId.indexOf("date")> -1)
                      {
      
                      }
                      $(expenseTypeField).val(fieldValue);
                  }
                 
      		})
      		.fail(function(){
      			
      		});
        }
        
    		
    });
    
    function saveForm()
    {
      $("#expenseForm").attr("action","Forms/submitform.php?action=save");
      $("#submit").click();
    }
    function addRowToTable()
    {
      var table = $("#ExpenseTable").find("tbody");
      
      var tr = $(table).find('tr:first').clone();
      var lastRowIndex = $(table).find('tr:last')[0].rowIndex;
      tr.attr("id", "dataRow" + lastRowIndex );
      
      
      tr.find("#selectedRow").attr("id", "selectedRow");
      tr.find("#ExpenseStartDate").attr("id", "ExpenseStartDate");
      tr.find("#ExpenseEndDate").attr("id", "ExpenseEndDate");
      tr.find("#ExpenseType").attr("id", "ExpenseType");
      tr.find("#ExpenseAmount").attr("id", "ExpenseAmount");
      
      //tr.find("#ExpenseType").bind("change", "DisplayExpense(this)" );
      //tr.find("#ExpenseAmount").bind("change", "OpenDialog(this)");
      
      tr[0].style = "display: ";
      $(table).append(tr)
      
    }
    
    function deleteSelectedRow()
    {
      var table = $("#ExpenseTable").find("tbody");
      var rows = $(table).find("tr");
      
      var selectedRows = $(rows).find("input[name=selectedRow]:checked");
      for (var i = 0; i <= selectedRows.length -1; i ++)
      {
        var row = $(selectedRows[i]).parent().parent()[0].rowIndex;
        document.getElementById("ExpenseTable").deleteRow(row);
      }
      var numberOfRows = $(table).find("tr").length;
      if (numberOfRows == 1)
      {
        addRowToTable();
      }

    }
    function copySelectedRow()
    {
      var table = $("#ExpenseTable").find("tbody");
      var rows = $(table).find("tr");
      
      var selectedRows = $(rows).find("input[name=selectedRow]:checked");
      for (var i = 0; i <= selectedRows.length -1; i ++)
      {
        
        var lastRowIndex = $(table).find('tr:last')[0].rowIndex;
        var tr = $(selectedRows[i]).parent().parent().clone();
        var rowIndex = $(selectedRows[i]).parent().parent()[0].rowIndex-1;
        var ExpenseTypeIndex = $(selectedRows[i]).parent().parent().find("select[name=ExpenseType]")[0].selectedOptions[0].index;
        

        tr.find("#selectedRow").attr("id", "selectedRow");
        tr.find("#selectedRow")[0].checked = false;
        tr.find("#ExpenseStartDate").attr("id", "ExpenseStartDate");
        tr.find("#ExpenseEndDate").attr("id", "ExpenseEndDate");
        tr.find("#ExpenseType").attr("id", "ExpenseType");
        tr.find("#ExpenseAmount").attr("id", "ExpenseAmount");
        $(table).append(tr);
        var lastRowExpenseType = $(table).find('tr:last').find("#ExpenseType")[0];
        var options = lastRowExpenseType.options[ExpenseTypeIndex].selected = 'selected';
        //selectedRows[i].checked = false;
        
      }

    }
    
    
    
    function OpenDialog(element)
    {
      
      var expenseType = $(element).parent().parent().find("#ExpenseType").val(); // it will get id of clicked row

        		$('#dynamic-content').html(''); // leave it blank before ajax call
        		$('#modal-loader').show();      // load ajax loader
        		
      var url = "";
      if ( expenseType == "Air" )
        url = "air_expense_form.php";
      else if ( expenseType == "Land" )
        url = "land_expense_form.php";
      else if( expenseType == "Hotel" )
        url = "hotel_expense_form.php";
      else if ( expenseType == "Food" )
        url = "food_expense_form.php";
      else if ( expenseType == "Other" )
        url = "other_expense_form.php";
      
      
      
      $.ajax({
        
        			url: url,
        			type: 'POST'
        			
        		})
        		.done(function(data){
        			$('#dynamic-content2').html('');    
        			$('#dynamic-content2').html(data); // load response 
        			$('#modal-loader2').hide();		  // hide ajax loader	
        		})
        		.fail(function(){
        			$('#dynamic-content2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
        			$('#modal-loader2').hide();
        		});
    }
    
    
    /*
    $(document).ready(function(){
        	$(document).on('change', '#getexpenseform', function(e){
        		
        		e.preventDefault();
        		
        		
        		
        		$.ajax({
        			url: 'expenseform.php',
        			type: 'POST',
        			data: 'id='+user_id,
        			dataType: 'html'
        		})
        		.done(function(data){
        			$('#dynamic-content').html('');    
        			$('#dynamic-content').html(data); // load response 
        			$('#modal-loader').hide();		  // hide ajax loader	
        		})
        		.fail(function(){
        			$('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
        			$('#modal-loader').hide();
        		});
        		
        	});
        	
        });       
     */
</script>
</html>
