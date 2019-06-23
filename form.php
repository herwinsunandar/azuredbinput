<!-- 
Adapted from Antonio Lupetti
http://woork.blogspot.com/2008/06/clean-and-pure-css-form-design.html
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tugas Azure Registration Form</title>

<style type="text/css">
body{
	font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif; 
	font-size:12px;
}
p, h1, form, button{border:0; margin:0; padding:0;}
.spacer{clear:both; height:1px;}
/* ----------- My Form ----------- */
.myform{
	margin:0 auto;
	width:400px;
	padding:14px;
}
	/* ----------- basic ----------- */
	#basic{
		border:solid 2px #DEDEDE;	
	}
	#basic h1 {
		font-size:14px;
		font-weight:bold;
		margin-bottom:8px;
	}
	#basic p{
		font-size:11px;
		color:#666666;
		margin-bottom:20px;
		border-bottom:solid 1px #dedede;
		padding-bottom:10px;
	}
	#basic label{
		display:block;
		font-weight:bold;
		text-align:right;
		width:140px;
		float:left;
	}
	#basic .small{
		color:#666666;
		display:block;
		font-size:11px;
		font-weight:normal;
		text-align:right;
		width:140px;
	}
	#basic input{
		float:left;
		width:200px;
		margin:2px 0 30px 10px;
	}
	#basic button{ 
		clear:both;
		margin-left:150px;
		background:#888888;
		color:#FFFFFF;
		border:solid 1px #666666;
		font-size:11px;
		font-weight:bold;
		padding:4px 6px;
	}


	/* ----------- stylized ----------- */
	#stylized{
		border:solid 2px #b7ddf2;
		background:#ebf4fb;

	}
	#stylized h1 {
		font-size:14px;
		font-weight:bold;
		margin-bottom:8px;
	}
	#stylized p{
		font-size:11px;
		color:#666666;
		margin-bottom:20px;
		border-bottom:solid 1px #b7ddf2;
		padding-bottom:10px;
	}
	#stylized label{
		display:block;
		font-weight:bold;
		text-align:right;
		width:140px;
		float:left;
	}
	#stylized .small{
		color:#666666;
		display:block;
		font-size:11px;
		font-weight:normal;
		text-align:right;
		width:140px;
	}
	#stylized input{
		float:left;
		font-size:12px;
		padding:4px 2px;
		border:solid 1px #aacfe4;
		width:200px;
		margin:2px 0 20px 10px;
	}
	#stylized button{ 
		clear:both;
		margin-left:160px;
		width:125px;
		height:31px;
		background:#444;
		text-align:center;
		line-height:31px;
		color:#FFFFFF;
		font-size:11px;
		font-weight:bold;
	}

</style>
</head>

<body>


<div id="stylized" class="myform">
 <h1>Register here!</h1>
  
<br />
<br />
<form id="form1" id="form1" action="form.php" method="POST">

    <label>Name
        <span class="small">Add your name</span>
    </label>
<input type="text" name="name" id="name">
    <label>Email
        <span class="small">Enter a Valid Email</span>
    </label>
<input type="text" name="email" id="email">
    <label>Job
        <span class="small">Add Your Jobs</span>
    </label>
<input type="text" name="job" id="job">
    <label>Phone
        <span class="small">Add a Phone Number</span>
    </label>
<input type="text" name="phone" id="phone">



<br />
<br />


    <button type="submit" name="submit" value="Send" style="margin-top:15px;">Submit</button>
	<button type="submit" formaction="/view_data.php" name="view_data" value="View Data" style="margin-top:15px;">View Data</button>
<div class="spacer"></div>



</div> <!-- end of form class -->
<?php 
$Driver={ODBC Driver 13 for SQL Server};
$serverName = "tcp:herwin.database.windows.net,1433";
$options = array(  "UID" => "e30nx",  "PWD" => "K@nwil0199",  "Database" => "dicodingdb");
$conn = sqlsrv_connect($Driver,$serverName, $options);

if( $conn === false )
     {
     echo "Could not connect.\n";
     die( print_r( sqlsrv_errors(), true));
     }
	 
	 ///input database
	  if (isset($_POST['submit'])) {
        try {
	$name= $_POST['name'];
	$email= $_POST['email'];
	$job= $_POST['job'];
	$date = date("Y-m-d");
	$phone= $_POST['phone'];

	$query = "INSERT INTO Registration(name,email,job,date,phone)VALUES(?,?,?,?,?)";
	$params1 = array($name,$email,$job,$date,$phone);                       
	$result = sqlsrv_query($conn,$query,$params1);
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h2>Your're registered!</h2>";
 }
sqlsrv_close($conn);
?>
</form>
</body>
</html>
