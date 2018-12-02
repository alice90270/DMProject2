<?php
	require_once('database.php');
	
	#[待改]要抓Session的教練
	if(isset($_POST ["Instructor"])){
		$Instructor =  $_POST ["Instructor"];
	}else{
		$Instructor =  1;
	}
	
	
	
	
	/* Add an Period and acoording instructor to table Period */
	function AddPeriod($connection, $Instructor, $Begin_Time) {
		$Checked_Begin_Time = mysqli_real_escape_string($connection, $Begin_Time);
		
		$query1_INSERT = "INSERT INTO `period`(`I_ID`, `Begin_Time`) VALUES ($Instructor, '$Checked_Begin_Time');";
		if(!mysqli_query($connection, $query1_INSERT)) echo("<p>Error adding Period data.</p>");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Instructor Center</title>
  <meta charset="utf-8">
</head>

<body>

	<!-- Header -->
	<p>
			<a href="index.php">Home</a> 
			<a href="insert.php">Insert New Record</a> 
			<a href="logout.php">Logout</a>
	</p>
		
	<!--add  Period-->
	<?php
		if (isset($_POST["Period_Date"])){
			
			$Period_Date = $_POST["Period_Date"];
			$time = $_POST ["time"];
			print('Successfully Arranged Your Periods Below:<br>');		
			
			for($j=0 ; $j< count($time) ; $j++){
				$Begin_Time = $Period_Date.' '.$time[$j];
				print($Begin_Time.'<br>');
				AddPeriod($mysqli, $Instructor, $Begin_Time);
			}
			
		}
		
		

	?>
	
	<!--show all Course-->
	<h4>all Courses</h4>
	<table border="1" cellpadding="2" cellspacing="2">
			<tr>
				<td>instructor ID</td>
				<td>instructor Name</td>
				<td>Course_ID</td>
				<td>M_ID</td>
				<td>Price</td>
				<td>Course_Type</td>
				<td>Number_of_Session</td>
				<td>Remaining_Number</td>
			</tr>
	  
		<?php
		$result = mysqli_query($mysqli, "SELECT instructor.I_ID, instructor.I_Name, course.Course_ID, course.M_ID, course.Price, course.Course_Type, course.Number_of_Session, course.Remaining_Number FROM course, compose,instructor WHERE course.Course_ID = compose.Course_ID AND compose.I_ID = instructor.I_ID AND instructor.I_ID = $Instructor;
			"); 
		while($query_data = mysqli_fetch_row($result)) {
		  echo "<tr>";
		  echo "<td>",$query_data[0], "</td>",
			   "<td>",$query_data[1], "</td>",
			   "<td>",$query_data[2], "</td>",
			   "<td>",$query_data[3], "</td>",
			   "<td>",$query_data[4], "</td>",
			   "<td>",$query_data[5], "</td>",
			   "<td>",$query_data[6], "</td>",
			   "<td>",$query_data[7], "</td>";
		  echo "</tr>";
		}
		?>  
	  
	</table>
	
	<!--show all period-->
	<h4>all periods</h4>
	<table border="1" cellpadding="2" cellspacing="2">
			<tr>
				<td>I_ID</td>
				<td>Begin_Time</td>
			</tr>
	  
		<?php
		$result = mysqli_query($mysqli, "SELECT `I_ID`, `Begin_Time` FROM `period` WHERE I_ID = $Instructor
		"); 
		while($query_data = mysqli_fetch_row($result)) {
		  echo "<tr>";
		  echo "<td>",$query_data[0], "</td>",
			   "<td>",$query_data[1], "</td>";
		  echo "</tr>";
		}
		?>  
	  
	<div class="form">

		<h2>View Records</h2>
		
		<table width="100%" border="1" style="border-collapse:collapse;">
			<thead>
				<tr>
				<th><strong>count</strong></th>
				<th><strong>I_ID</strong></th>
				<th><strong>Begin_Time</strong></th>
				<th><strong>Edit</strong></th>
				<th><strong>Delete</strong></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$count=1;
					$result = mysqli_query($mysqli, "SELECT `I_ID`, `Begin_Time` FROM `period` WHERE I_ID = $Instructor
					"); 
					while($row = mysqli_fetch_assoc($result)) { 
				?>
				<tr>
					<td align="center"><?php echo $count; ?></td>
					<td align="center"><?php echo $row["I_ID"]; ?></td>
					<td align="center"><?php echo $row["Begin_Time"]; ?></td>
					<td align="center">
						<a href="edit.php?id=<?php echo $row["I_ID"]; ?>">Edit</a>
					</td>
					<td align="center">
						<a href="Delete.php?id=<?php echo $row["I_ID"].','.$row["Begin_Time"]; ?>">Delete</a>
					</td>
				</tr>
				<?php $count++; } 
				?>
			</tbody>
		</table>
	</div>


</body>

</html>