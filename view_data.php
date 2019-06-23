<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
</head>
<body>
 <h2>Tugas Azure View Data</h2>
 
 <form action="/form.php" method="get">
 <!--<a href="/azure/form.php" class="button">Input data</a>-->
<button type="submit" class="button" formaction="/form.php">Input data</button>
<br />
</form>
<?php 
//$Driver="ODBC Driver 13 for SQL Server";
$serverName = "herwin.database.windows.net";
$options = array(  "UID" => "e30nx",  "PWD" => "K@nwil0199",  "Database" => "dicodingdb");
$conn = sqlsrv_connect($serverName, $options);
$query = "SELECT * FROM Registration";
$stmt = sqlsrv_query($conn,$query);
if($stmt === false)
{
    die(print_r(sqlsrv_errors(), true));
}
//var_dump($row);	 
 {
?>
<br />
<table id="customers">
  <tr>
    <th>Name</th>
    <th>Email</th>
    <th>Job</th>
	<th>Date</th>
	<th>Phone</th>
  </tr>
  <tr>
  <?php
  if(sqlsrv_has_rows($stmt))
	{
  while($row = sqlsrv_fetch_array($stmt))
  {
	  ?>
  <td><?php echo $row['name'];?></td>
    <td><?php echo $row['email'];?></td>
    <td><?php echo $row['job'];?></td>
	<td><?php echo $Date = $row['date']->format('d/m/Y');?></td>
	<td><?php echo $row['phone'];?></td>
  </tr>
 <?php
 }
 }
 }
  ?>
</table>

</body>
</html>
