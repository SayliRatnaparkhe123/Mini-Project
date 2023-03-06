<?php
error_reporting(0);
date_default_timezone_set("Asia/Kolkata"); 
$local = 'localhost';
$user = 'root';
$pass = '';
$db = 'expense_db';
$con=mysqli_connect($local,$user,$pass,$db);

$todaysdate = date("Y-m-d");
$deleteid = $_GET['deleteid'];
if(isset($deleteid))
{
	$delete = mysqli_query($con,"delete from  expensemaster where `expenseid`='$deleteid'");
	echo "Expense Deleted!";
}
if(isset($_POST['submit']))
{
	$expnese_type = $_POST['expnese_type'];
	$amount = $_POST['amount'];
	$expense_date = $_POST['expense_date'];
	
	$insert = mysqli_query($con,"insert into expensemaster set `expense_type`='$expnese_type',`amount`='$amount',`expense_date`='$expense_date',`createdon`='$todaysdate',`addedby`='1' ");
	echo "Expense Added!";
}
if(isset($_POST['search']))
{
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date']; 
	
	$query = mysqli_query($con,"select * from  expensemaster where `expense_date` BETWEEN '$start_date' AND '$end_date' "); 
	 
}else{
	$query = mysqli_query($con,"select * from expensemaster order by expenseid DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Expense Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border: 1px solid black;
  /* border-radius: 10px; */
  width: 100%;
}

#customers td, #customers th {
    border: 1px solid black;
  padding: 8px;
  
}

#customers tr:nth-child(even){background-color: #ffffff;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>

</head>
<body>
<div class="container-fluid">
  <h1>Expense Tracker</h1>
  <p>Track your daily expenses</p> 
  <div class="row" style="background-color: lavender;">
    <div class="col-sm-4" > 
	<form action="expense.php" method="POST">
    <strong>Add Expenses</strong>
  <div class="form-group" style="margin-top: 4%;">
    <label for="email">Expense Type</label>
   <select name="expnese_type" class="form-control" >
   <option value="" selected disabled>-- Select Expense Type --</option>
  <option value="Petrol">Petrol</option>
  <option value="Medical">Medical</option>
  <option value="Bus Transport">Bus Transport</option>
  <option value="Mobile Recharge">Mobile Recharge</option>
  <option value="Mess">Mess</option>
  <option value="Entertainment">Entertainment</option>
  <option value="Hoteling">Hoteling</option>
</select>
   
  </div>
  <div class="form-group">
    <label for="pwd">Amount</label>
    <input type="text" name="amount" class="form-control" id="pwd">
  </div>
   <div class="form-group">
    <label for="pwd">Expense Date</label>
    <input type="date" name="expense_date" class="form-control" id="pwd">
  </div>
  <input type="submit" name="submit" value="Submit" class="btn btn-default"> 
</form> 
	
	</div>
    <div class="col-sm-8" >
    <strong>List of All Expenses</strong>
	<form action="expense.php" method="post">
	<div class="row" style="margin-top: 2%;">
	<div class="col-md-4">
	<strong>Start Date</strong>
	<input type="date" name="start_date" class="form-control" id="pwd">
	</div>
	<div class="col-md-4">
	<strong>End Date</strong>
	<input type="date" name="end_date" class="form-control" id="pwd">
	</div>
	<div class="col-md-4">
	<br />
	 <input type="submit" name="search" value="Search" class="btn btn-default"> 
     <button type="button" class="btn btn-default"> <a href="expense.php">View All</a></button>
	</div>
	</div>
	</form>
	<div style="margin-top: 2%;">
    <!-- <p>List Of All Expenses</p> -->
<table id="customers">
  <tr>
    <th>Expense Type</th>
    <th>Amount</th>
    <th>Date</th>
	 <th>Delete</th>
  </tr>
</div>
  <?php
  
  while($row = mysqli_fetch_array($query))
  {
	   $expenseid = $row['expenseid'];
	   $expense_type = $row['expense_type'];
	  $amount = $row['amount'];
	  $expense_date = $row['expense_date'];
	  $total += $amount;
	   
  ?>
  <tr>
    <td><?php echo $expense_type; ?></td>
    <td><?php echo $amount; ?></td>
    <td><?php echo $expense_date; ?></td>
	<td><a href="expense.php?deleteid=<?php echo $expenseid; ?>">Delete</a></td>
  </tr>
  <?php
  }
  ?>
  <tr>
   <td>Total</td>
    <td><?php echo $total; ?></td>
    <td></td>
	<td></td>
  </tr>
   
</table>
	
	</div>
  </div>
</div>  
</body>
</html>
