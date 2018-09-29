<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			text-align: center;
		}
		.header{
			border-color: white;
			border-bottom: 1px solid black;
		}
	</style>
</head>
<body>
<?php
	include_once "../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Str Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$perResult = $stmt->get_result();
	$perRow = $perResult->fetch_row();
	$per = $perRow[0];

	$stmt = null;
	$stmt = $conn->prepare("SELECT calc_SY()");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$syResult = $stmt->get_result();
	$syRow = $syResult->fetch_row();
	$sy = $syRow[0];

	?><h1>Schedules for <?php echo $per; ?><label> SY: <?php echo $sy; ?> - <?php echo $sy + 1; ?></label></h1><?php

	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
	$stmt->execute();
	$dResult = $stmt->get_result();
	if ($dResult->num_rows > 0) {
		?><table style="width: 100%"><?php
		while ($dRow = $dResult->fetch_assoc()) {
			$curDate = date("F j, Y (l)", strtotime($dRow["Date"]));
			
			$stmt = null;
			$stmt = $conn->prepare('CALL `select_exam_schedules`(?)');
			$stmt->bind_param('i', $dRow['Id']);
			$stmt->execute();
			$examResult = $stmt->get_result();
			if ($examResult->num_rows > 0) {
				?><tr><td colspan="6" class="header"><h2><?php echo "Day " . $dRow["rank"] . " : " . $curDate; ?></h2></td></tr>
					
					<tr>
						<th>Section</th>
						<th>Subject</th>
						<th>Room</th>
						<th>Time</th>
						<th>Proctor</th>
						<!--th style="width: 0.75in">Student Count</th-->
					</tr><?php

				$isFirst = true;
				$lSectionCodeFull = "";
				$lSubjectCode = "";
				$lRoom = "";
				$lStart = "";
				$lEnd = "";
				$lUserName = "";
				$lStudentCount = 0;

				while ($examRow = $examResult->fetch_assoc()){
					if ($isFirst == true){
						$isFirst = false;
						$lSectionCodeFull = $examRow["SectFull"];
						$lSubjectCode = $examRow["subjectCode"];
						$lRoom = $examRow["Room"];
						$lStart = $examRow["Start"];
						$lEnd = $examRow["End"];
						$lUserName = $examRow["User Name"];
						$lStudentCount = $examRow["Student Count"];
					}
					else{
						if($lRoom == $examRow["Room"] && $lStart == $examRow["Start"] && $lEnd == $examRow["End"] && $lUserName == $examRow["User Name"]){
							#merge
							$lSectionCodeFull = $lSectionCodeFull . "/" . $examRow["SectFull"];
							
							if ($lSubjectCode != $examRow["subjectCode"]){
								$lSubjectCode != $examRow["subjectCode"];
							}
							$lStudentCount += $examRow["Student Count"];
						}
						else{
							?>
								<tr>
									<td><?php echo $lSectionCodeFull ?></td>
									<td><?php echo $lSubjectCode ?></td>
									<td><?php echo $lRoom?></td>
									<td><?php echo date("g:i A", strtotime($lStart)) ?> - <?php echo date("g:i A", strtotime($lEnd)) ?></td>
									<td><?php echo $lUserName ?></td>
									<!--td><?php echo $lStudentCount ?></td-->
								</tr>
							<?php
							$lSectionCodeFull = $examRow["SectFull"];
							$lSubjectCode = $examRow["subjectCode"];
							$lRoom = $examRow["Room"];
							$lStart = $examRow["Start"];
							$lEnd = $examRow["End"];
							$lUserName = $examRow["User Name"];
							$lStudentCount = $examRow["Student Count"];
						}
					}
				}
				?>
					<tr>
						<td><?php echo $lSectionCodeFull?></td>
						<td><?php echo $lSubjectCode?></td>
						<td><?php echo $lRoom?></td>
						<td><?php echo date("g:i A", strtotime($lStart));?> - <?php echo date("g:i A", strtotime($lEnd));?></td>
						<td><?php echo $lUserName; ?></td>
						<!--td><?php echo $lStudentCount; ?></td-->
					</tr>
				<?php
			}
			
		}

		?></table>
		<br>
		<button id="btnPrint" onclick="myPrint()">Print</button><?php
	}
	else{
		echo "Nothing to show";
	}
?>
<script type="text/javascript">
	function myPrint(){
		document.getElementById("btnPrint").style.visibility = "hidden";
		window.print();
	}
</script>
</body>
</html>