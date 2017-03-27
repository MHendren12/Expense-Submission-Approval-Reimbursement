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

<body>
  <form id="printexpenseForm" action="Forms/submitform.php?action=submit" method="POST" enctype="multipart/form-data" > 
    <input id="formId" name="formId" value="<?php echo $formId; ?>" style="display:none;">
    <div id="General">
     <?php include("general_information_form.php");?>
    </div>
      <br>
    <div id="expenses">
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
      <label for="air_receipt_upload">Upload a Receipt: </label><br>
      <input type="file" name="air_receipt_upload" id="air_receipt_upload">
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
     
  $("input").prop("disabled", true);
  $("input").css("background-color", "#f5f5f5");
  $("input").css("border", "#f5f5f5");
  $("textarea").prop("disabled", true);
  $("textarea").css("background-color", "#f5f5f5");
  $("textarea").css("border", "#f5f5f5");
  $('#btnPrint').click(function () {
    doc.fromHTML($('#printexpenseForm').html(), 15, 15, {
        'width': 1080,
            'elementHandlers': specialElementHandlers
    });
    doc.fromHTML($('#printexpenseForm').html(), 15, 15, {
        'width': 1080,
            'elementHandlers': specialElementHandlers
    });
    doc.save('expenseform.pdf');
});  
</script>
</html>