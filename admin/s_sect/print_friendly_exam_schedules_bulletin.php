<?php
	include_once "../../util_dbHandler.php";
	
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Printer Friendly (Bulletin)</title>
	<link rel="stylesheet" href="../../css/fontawesome-all.css">
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
		h1,h2{
			margin: 0px;
		}
		h3{
			margin-bottom: 0px;
		}
	</style>
</head>
<body>
<?php
	

	$dId = isset($_REQUEST['id']) ? $_REQUEST['id'] : "" ; #Day ID 

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Int Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$perResult = $stmt->get_result();
	$perRow = $perResult->fetch_row();
	switch ($perRow[0]) {
		case '1':
			$per = "Prelim";
			break;
		case '2':
			$per = "Midterm";
			break;

		case '3':
			$per = "Finals";
			break;
		default:
			$per = "Err";
			break;
	}

	$stmt = null;
	$stmt = $conn->prepare("SELECT calc_SY()");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$syResult = $stmt->get_result();
	$syRow = $syResult->fetch_row();
	$sy = $syRow[0];


	#$curDate = date("F j, Y (l)", strtotime($dRow["Date"]));
	$datesString = "";
	$curMonth = "";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
	#$stmt->bind_param('i', $dId);
	$stmt->execute();
	$dResult = $stmt->get_result();
	$rCount = $dResult->num_rows;
	$i = 1;
	if ($rCount > 0) {
		while ($dRow = $dResult->fetch_assoc()) {
			if ($i==1){
				$curMonth = date("F", strtotime($dRow["Date"]));
				$datesString = date("F", strtotime($dRow["Date"])) . ' ';
				$datesString .= date("j", strtotime($dRow["Date"])); # show first number with comma
			}
			else{
				if($curMonth != date("F", strtotime($dRow["Date"]))){
					$curMonth = date("F", strtotime($dRow["Date"]));
					#Update the month stireng
					if ($rCount - $i == 0){
						#last one
						$datesString .= ' and ' . $curMonth . ' ' . date("j", strtotime($dRow["Date"]));
					}
					else{
						$datesString .= ', ' . $curMonth . ' ' . date("j", strtotime($dRow["Date"]));
					}
				}
				else{
					if ($rCount - $i == 0){
						#last one
						$datesString .= ' and ' . date("j", strtotime($dRow["Date"]));
					}
					else{
						$datesString .= ', ' . date("j", strtotime($dRow["Date"]));
					}
				}
				if ($rCount - $i == 0){
					$datesString .= ', ' . date("Y", strtotime($dRow["Date"]));
				}
			}
			$i++;
		}
	}
	$curDate = null; # Cleanup as there is a same variable name below




	?><div style="text-align: center;">
		<h1>Schedule of <?php echo $per; ?> Exam<!--label> SY: <?php #echo $sy; ?> - <?php #echo $sy + 1; ?></label--></h1>
		<h2><?php echo $datesString; ?></h2>
	</div>
	<?php

	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`(?);");
	$stmt->bind_param('i', $dId);
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
				?><tr><td colspan="6" class="header"><h4><?php echo "Day " . $dRow["rank"] . " : " . $curDate; ?><br>
						Officer of the day: <input type="text" style="border: none;" placeholder="Please enter name here"></h4></td></tr>
					
					<tr>
						<th>Section Code</th>
						<th>Subject Code</th>
						<th>Time</th>
						<th>Room</th>
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
									<td><?php echo date("g:i A", strtotime($lStart)) ?> - <?php echo date("g:i A", strtotime($lEnd)) ?></td>
									<td><?php echo $lRoom?></td>
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
						<td><?php echo date("g:i A", strtotime($lStart));?> - <?php echo date("g:i A", strtotime($lEnd));?></td>
						<td><?php echo $lRoom?></td>
						<!--td><?php echo $lStudentCount; ?></td-->
					</tr>
				<?php
			}
			
		}

		?></table>
		<br>
		<hr>
		<br>
		<br>
		<br>
		<p>Printed by: <?php echo $LoggedInName ?></p>
		<br>
		<br>
		<br>
		<p>Approved by: Dr. Jalop<br><em>School Director</em></p>
		<p style="text-align: center;">-<?php echo $per; ?> Examination-<br>-TBD Semester <?php echo date("Y"); ?>-</p>
		<button style="left: 5px;top: 5px;position: fixed; cursor: pointer;" id="btnPrint" onclick="myPrint()"><h1><i class="fas fa-print"></i> Print</h1></button><?php
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