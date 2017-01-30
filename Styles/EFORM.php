<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   <link href="/Styles/css/Eformstyle.css" rel="stylesheet">
    <title>Test eform</title>
</head>
<body>
    <div id="top">
    <div id="heading">Report of Business Expenses</div>
    
    <form action="mailto:mstolar2@oakland.edu" method="post" enctype="text/plain"><div>
    
    <div id="left">
       Report date:<br>
          <input type="text" ><br>
        Travel From:<br>
         <input type="text" size="28"><br>
        Purpose of Trip:<br>
         <input type="text" size="40"><br>
          Authorized By:<br>
         <input type="text"><br>
         <p>Employee Info</p>
          Name:<br>
          <input type="text" ><br>
          Last name:<br>
         <input type="text" size="28">
         <br>
        <label>Gender:</label><input type="radio" name="gender" value="female" />Female
        <input type="radio" name="gender" value="male" />Male
            <br>
          Branch:<br>
         <input type="text" size="40"><br>
          Department:<br>
         <input type="text"><br>
      <br>
      Company:
          <select name="Przeglądarka">
	            <option selected="selected">Select...</option>
	            <option>Netscape</option>
	            <option>Opera</option>
            	<option>Mozilla</option>
	            <option>Inna</option>
            </select>
            <br>
            <br>
            <input type="submit" value="Send form" />
<input type="reset" value="Clear form" />

    </div>
    <div id="center">
       Authorized By:<br>
         <input type="text" size="49"><br>
         Travel to:<br>
         <input type="text" size="40"><br>
         Authorization Number:<br>
         <input type="text"><br>
         <br>
         Payment method used: 
         <br>
         <form action="">
                  <input type="radio" name="payment" value="payment"> Credit card<br>
                  <input type="radio" name="payment" value="payment"> Cash<br>
                  <input type="radio" name="payment" value="payment"> Other
            </form>
         <br>
          E-mail Address:<br>
          <input type="text" ><br>
        Address Line1:<br>
         <input type="text" size="28"><br>
        Address Line2:<br>
         <input type="text" size="40"><br>
          City:<br>
         <input type="text"><br>
    </div>
    <div id="right">
            End date:<br>
          <input type="text" ><br>
         Vendor Number:<br>
         <input type="text" size="40"><br>
     <br>
             <textarea name="comment" cols="50" rows="10">Expense report info...</textarea>
             <br>
             <br>
        <input type="file" name="fileupload" value="fileupload" id="fileupload"> <label for="fileupload"></label>
    </div>
</div>
</form>
</body>
</html>