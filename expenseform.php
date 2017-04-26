

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
    var expenseType = $(element).parents("tr").find("select.form-control")[0];
    
    var section = expenseType.selectedOptions[0].id + "_expense";
    section = section.toLowerCase();
    
    
    var selector = '.popover-content #'+section;
    var section = $(selector);
    
    
    $(section).css("display", "block");
    //$("#formTypeContent").attr("display", "block");

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
      border: 1px solid black;
    }
  </style>
<body>
  
  <div id="formTypeContent" style="display:none;height:auto">
    <div id="air_expense" style="display:none;">
     <?php include("air_expense_form.php")?>
    </div>
    
    <div id="land_expense" style="display:none">
      <?php include("land_expense_form.php")?>
    </div>
    
    <div id="hotel_expense" style="display:none">
      <?php include("hotel_expense_form.php")?>
    </div>
    
    <div id="food_expense" style="display:none">
      <?php include("food_expense_form.php")?>
    </div>
    
    <div id="other_expense" style="display:none">
      <?php include("other_expense_form.php")?>
    </div>
    <hr>
    <div>
      <a class="btn btn-default" onclick="saveExpenseToTable(this)">Save</a>
      <a class="btn btn-default" onclick="cancelExpense()" >Cancel</a>
    </div>
  </div>
  
  
  <form id="expenseForm" action="Forms/submitform.php?action=submit" method="POST" enctype="multipart/form-data" > 
    <input id="formId" name="formId" value="<?php echo $formId; ?>" style="display:none;">
    <div id="General">
     <?php include("general_information_form.php");?>
    </div>
     <b>Expenditures:</b>
     <br><br>
    <table id="ExpenseTable" name="ExpenseTable">
      <thead>
        <tr>
        <td width="1%"></td>
        <td width="16%">Start Date</td>
        <td width="16%">End Date</td>
        <td width="16%">Expense Type</td>
        <td width="16%">Expense Total</td>
        <td width="16%">Approved Total</td>
        <td style="display:none"></td>
      </tr>
      </thead>
      <tbody>
        <tr id="templateRow" style="display:none">
          <td width="1%"  align="center">
            <input type="checkbox" name="selectedRow" id="selectedRow">  
          </td>
          <td>
            <input type="date" id="ExpenseStartDate" name="ExpenseStartDate[]" class="form-control">
          </td>
          <td>
            <input type="date" id="ExpenseEndDate" name="ExpenseEndDate[]" class="form-control">
          </td>
          <td>
            <select type="text" class="form-control" id="ExpenseType" name="ExpenseType[]" list="list1" style="display:inline-block; width:100%"  >
              <option value = "- Expense Type -" selected >- Expense Type -</option>
              <option name="Air"  id="Air" value="Air">Air</option>
              <option name="Land"  id="Land" value="Land">Land</option>
              <option name="Hotel"  id="Hotel" value="Hotel">Hotel</option>
              <option name="Food"  id="Food" value="Food">Food</option>
              <option name="Other"  id="Other" value="Other">Other</option>
          </select>
          </td>
          <td>
            <input  type = "text" class="expenseType form-control" id="ExpenseAmount"  name="ExpenseAmount[]"  title="ExpenseType" data-placement="left" data-toggle="popover" data-trigger="click"  style="float:right;">
          </td>
          <td>
            <input class="form-control"  id="ExpenseApproved" name="ExpenseApproved[]" type="text" >
          </td>
          <td style="display:none">
            <input id="fieldData" name="fieldData[]" type="text">
          </td>
        </tr>
        <tr id="dataRow" class="datarow">
          <td width="1%" align="center">
            <input type="checkbox" name="selectedRow" id="selectedRow">  
          </td>
          <td width="16%">
            <input type="date" id="ExpenseStartDate" name="ExpenseStartDate[]" class="form-control">
          </td>
          <td width="16%">
            <input type="date" id="ExpenseEndDate" name="ExpenseEndDate[]"  class="form-control">
          </td>
          <td width="16%">
            <select type="text" class="form-control" id="ExpenseType" name="ExpenseType[]" list = "list1" style="display:inline-block;" >
              <option value = "- Expense Type -" selected >- Expense Type -</option>
              <option name="Air"  id="Air" value="Air">Air</option>
              <option name="Land"  id="Land" value="Land">Land</option>
              <option name="Hotel"  id="Hotel" value="Hotel">Hotel</option>
              <option name="Food"  id="Food" value="Food">Food</option>
              <option name="Other"  id="Other" value="Other">Other</option>
          </select>
          </td>
          <td width="16%" >
           <input type = "text" class="expenseType form-control"  id="ExpenseAmount" name="ExpenseAmount[]" title="ExpenseType" data-placement="left" data-toggle="popover" data-trigger="click" style="float:right;" >
          </td>
          <td width="16%">
            <input class="form-control" id="ExpenseApproved" name="ExpenseApproved[]" type="text">
          </td>
          <td style="display:none">
            <input id="fieldData" name="fieldData[]" type="text">
          </td>
        </tr>
      </tbody>
    </table>
    <a onclick="addRowToTable()" style="padding-right:10px" >Add Row</a>
    <a onclick="deleteSelectedRow()" style="padding-right:10px" >Delete Selected Rows</a>
    <a onclick="copySelectedRow()" style="padding-right:10px" >Copy Selected Rows</a>
    <input style="display:none" id="numRows" name="numRows" value=1 >
    <br><br>
    
    <label for="totalExpense">Total Expense ($):</label><br>
    <input type="number" step="0.01" name="totalExpense" id="totalExpense" style="width:30%">
    <hr>
      <!--
  
    <input type="checkbox" name="Air" id="Air" onchange="DoCheckUncheckDisplay(this,'air_expense')"  value="Air">Air Travel<br>
    <input type="checkbox" name="Land" id="Land"onchange="DoCheckUncheckDisplay(this,'land_expense')"  value="Land">Land Travel<br>
    <input type="checkbox" name="Hotel" id="Hotel" onchange="DoCheckUncheckDisplay(this,'hotel_expense')"  value="Hotel">Hotel<br>
    <input type="checkbox" name="Food" id="Food" onchange="DoCheckUncheckDisplay(this,'food_expense')" value="Food">Food<br>
    <input type="checkbox" name="Other" id="Other" onchange="DoCheckUncheckDisplay(this,'other_expense')" value="Other">Other
    -->
    
    <div>
    
    <div>
      <?php 
      
        $sql = "select * from attachments where expenseform_id = '".$formId."'";
        $select = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($select))
        {
          $path = $row['uploadpath'];
          echo '<a href="'.$path.'" target="_blank" style="padding: 0px 5px 0px 5px"><span class="glyphicon glyphicon-picture"></span></a>';
        }
        if ($inSubmission)
        {
          echo '<br>' ;
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

    $(document).ready(function()
    {
      /*
      var totalFields = ["totalLandExpense", "totalOtherExpense", "totalFoodExpense", "totalHotelExpense", "totalAirExpense"];
      for (var i =0; i <= totalFields.length-1;i++)
      {
        var thisField = $(totalFields[i]);
        debugger;
        $(totalFields[i]).bind("change",function(){ $(totalFields[i]).val(   parseFloat($(totalFields[i]).val()).toFixed(2)     );debugger; })
      }
      */
      
      function saveForm()
      {
        $("#expenseForm").attr("action","Forms/submitform.php?action=save");
        $("#submit").click();
      }
      
      function setTotalExpense()
      {
        var table = $("#ExpenseTable").find("tbody");
        var rows = $(table).find(".datarow");
        var total = parseFloat("0.00").toFixed(2);
        for (var j = 0; j <= rows.length-1; j++)
        {
          var val = $(rows[j]).find("#ExpenseAmount").val();
          var rowTotal = (val == "" ? 0 : val );
          rowTotal = parseFloat(rowTotal).toFixed(2);
          total = parseFloat(total).toFixed(2) - -parseFloat(rowTotal).toFixed(2);
        }
        $(totalExpense).val( parseFloat(total).toFixed(2) );
      }
      setTotalExpense();
      
      $('.expenseType.form-control').popover({
            content: $('#formTypeContent').html(),
            html: true
        }).click(function(e)
        {
          var expenseType = $(this).parents("tr").find("#ExpenseType").val();
          if (expenseType != "- Expense Type -")
          {
            DisplayExpense(this);
            setFieldData(this);
            if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
            {
              $(this).click();
            }
            $(".popover-content")[0].style.height = "auto";
          }
          else
          {
            $('[data-toggle="popover"]').popover('hide');
            alert("Please enter an expense type.");
          }
          
        });
      
        var form_id = "<?php echo $id ?>";
    
    
        if (form_id != "0")
        {
      		$.ajax({
    			url: 'WebService/forminfo.php',
    			type: 'POST',
    			data: { "val": "getExpenseFields","formid":form_id },
    
      		})
      		.done(function(data){
      		    var expenseFields = JSON.parse(data);
                for (var i = 0; i<= expenseFields.length-1; i++)
                {
                  var type = jQuery.type(expenseFields[i]);
                    if ( jQuery.type(expenseFields[i]) === "object" )
                    {
                      var fieldId = expenseFields[i].fieldId;
                      var fieldValue = expenseFields[i].fieldValue;
                    
                      if (fieldId.toLowerCase().indexOf("table") != -1 )
                      {
                        for (var j = 0; j <= fieldValue.length-1; j++)
                        {
                          if (j > 0)
                            addRowToTable(fieldValue[j]);
                          else
                          {
                            var table = $("#ExpenseTable").find("tbody");
                            var data = fieldValue[j];
                            var rowIndex = data.Row - 1;
                            var row = $(table).find(".datarow")[rowIndex];
                            for ( var i = 0; i <= data.Value.length -1; i++ )
                            {
                              var column = data.Value[i].Column;
                              var value = data.Value[i].Value;
                              var str = "#"+column;
                              var col = $(row).find(str);
                              if (i == data.Value.length-1)
                              {
                                var arr = [];
                                for (var k = 0; k <= value.length-1; k++)
                                {
                                  arr.push(JSON.stringify(value[k]));
                                }
                                $(col).val("[" + arr.join(",") + "]");
                              }
                              else
                                $(col).val(value);
                            }
                          }
                        }
                      }
                    }
                    else
                    {
                      var fieldValue = expenseFields[i].fieldValue;
                      var expenseTypeField = document.getElementById(fieldId);
                      if (fieldId.indexOf("date")> -1)
                      {
      
                      }
                      $(expenseTypeField).val(fieldValue);
                    }
                }
                setTotalExpense();  
                 
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
    function addRowToTable(data = null)
    {
      var table = $("#ExpenseTable").find("tbody");
      var tr = $(table).find('tr:first').clone();
      var lastRowIndex = $(table).find('tr:last')[0].rowIndex;
      tr.attr("id", "dataRow");
      tr.attr("class", "datarow");
      tr.find("#selectedRow").attr("id", "selectedRow");
      tr.find("#ExpenseStartDate").attr("id", "ExpenseStartDate");
      tr.find("#ExpenseEndDate").attr("id", "ExpenseEndDate");
      tr.find("#ExpenseType").attr("id", "ExpenseType");
      var expenseAmount = tr.find("#ExpenseAmount");
      tr.find("#ExpenseAmount").attr("id", "ExpenseAmount");
       $(expenseAmount).popover({
            content: $('#formTypeContent').html(),
            html: true,
        }).click(function(e)
        {
          DisplayExpense(this);
          setFieldData(this);
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
          {
            $(this).click();
          }
          
        });
        $(expenseAmount).popover("toggle");
      tr.find("#ExpenseApproved").attr("id", "ExpenseApproved");
      //tr.find("#ExpenseType").bind("change", "DisplayExpense(this)" );
      //tr.find("#ExpenseAmount").bind("change", "OpenDialog(this)");
      
      tr[0].style = "display: ";
      $(table).append(tr);
      $("#numRows").val( parseInt($("#numRows").val() ) + 1 );
      if (data != null)
      {
        var rowIndex = data.Row - 1;
        
        var row = $(table).find(".datarow")[rowIndex];
        
        
        for ( var i = 0; i <= data.Value.length -1; i++ )
        {
          var column = data.Value[i].Column;
          var value = data.Value[i].Value;
          var str = "#"+column;
          var col = $(row).find(str);
          $(col).val(value);
        }
      }
      
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
        $("#numRows").val( parseInt($("#numRows").val() ) - 1 );
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
        var ExpenseTypeIndex = $(selectedRows[i]).parents("tr").find("#ExpenseType")[0];
        if (ExpenseTypeIndex)
          ExpenseTypeIndex = ExpenseTypeIndex.selectedOptions[0].index;
        

        tr.find("#selectedRow").attr("id", "selectedRow");
        tr.find("#selectedRow")[0].checked = false;
        tr.find("#ExpenseStartDate").attr("id", "ExpenseStartDate");
        tr.find("#ExpenseEndDate").attr("id", "ExpenseEndDate");
        tr.find("#ExpenseType").attr("id", "ExpenseType"+lastRowIndex);
        var expenseAmount = tr.find("#ExpenseAmount");
        tr.find("#ExpenseAmount").attr("id", "ExpenseAmount");
        $(table).append(tr);
        var erter = $(table).find('tr:last');
        var lastRowExpenseType = $(table).find('tr:last').find("#ExpenseType"+lastRowIndex)[0];
        
        $(expenseAmount).popover({
            content: $('#formTypeContent').html(),
            html: true,
        }).click(function(e)
        {
          DisplayExpense(this);
          setFieldData(this);
          if ( !$(".popover-content").parent()[0] || $(".popover-content").parent()[0].style.display != "block" )
          {
            $(this).click();
          }
          
        });
        
        if( lastRowExpenseType )
        {
          var options = lastRowExpenseType.options[ExpenseTypeIndex].selected = 'selected';
          
        }
        
        
        
        $("#numRows").val( parseInt($("#numRows").val() ) + 1 );
        
      }

    }
    function saveExpenseToTable(element)
    {
      
      var hField = $(element).parents("tr").find("#fieldData");
      var popover = $(element).parents(".popover-content");
      var fieldData = $(popover).find("input:visible");
      var texts = $(popover).find("textarea:visible");
      for (var i =0; i <= texts.length -1; i++)
      {
        fieldData.push( texts[i] );
      }
      data = [];
      for (var i =0; i <= fieldData.length -1; i++)
      {
        var field = fieldData[i];
        var fieldId = $(field).attr("id");
        var fieldValue = $(field).val();
        var json = '{"fieldId":"'+fieldId+'","fieldData":"'+fieldValue+'"}';
        data.push(json);
        if (fieldId.toLowerCase().indexOf("total") != -1)
        {
          $(element).parents("tr").find("#ExpenseAmount").val(fieldValue);
          $(element).parents("tr").find("#ExpenseApproved").val(fieldValue);
          
          var currentTotal = parseFloat( $("#totalExpense").val() );
          var newTotal = parseFloat( currentTotal - -fieldValue ).toFixed(2);
          $("#totalExpense").val(newTotal);
          
        }
      }
      
      
      
      data = '[' + data.join(",") + ']';
      $(hField).val(data);
      $('[data-toggle="popover"]').popover('hide');
    }
    
    
    function cancelExpense()
    {
      $('[data-toggle="popover"]').popover('hide');
    }
    
    
    function setFieldData(element)
    {
      var hField = $(element).parents("tr").find("#fieldData");
      var popover = $(".popover-content");
      var hFieldVal = $(hField).val();
      if (hFieldVal)
      {
        
        fieldData = JSON.parse(hFieldVal);
        for(var i = 0; i <= fieldData.length-1; i++)
        {
          var selector = '#'+fieldData[i].fieldId;
          var field = $(popover).find(selector);
          $(field).val(fieldData[i].fieldData);
        }
      }
       
      
    }
    
    
    
    

</script>
</html>
