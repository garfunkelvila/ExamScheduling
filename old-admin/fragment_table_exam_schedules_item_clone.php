<?php
include "../util_dbHandler.php";

$targDay = isset($dayRow['Id']) ? $dayRow['Id'] : $_REQUEST['day'];

$stmt = null;
$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible';");
$stmt->execute();
$cResult = $stmt->get_result();
$sRow = $cResult->fetch_row();

$stmt = null;
$stmt = $conn->prepare('CALL `select_exam_schedules`(?)');
$stmt->bind_param('i', $targDay);
$stmt->execute();
$examResult = $stmt->get_result();
if ($examResult->num_rows > 0) {
	$isFirst = true;
	$lSectionCodeFull = "";
	$lSubjectCode = "";
	$lRoom = "";
	$lStart = "";
	$lEnd = "";
	$lUserName = "";
	$lStudentCount = "";

	while ($examRow = $examResult->fetch_assoc()){
		if ($isFirst == true){
			$isFirst = false;
			$lSectionCodeFull = $examRow["Section Code Full"];
			$lSubjectCode = $examRow["subjectCode"];
			$lRoom = $examRow["Room"];
			$lStart = $examRow["Start"];
			$lEnd = $examRow["End"];
			$lUserName = $examRow["User Name"];
			$lStudentCount = $examRow["Student Count"];
			$lId = $examRow['Id'];
		}
		else{
			
			if($lRoom == $examRow["Room"] && $lStart == $examRow["Start"] && $lEnd == $examRow["End"] && $lUserName == $examRow["User Name"]){
				#MERGE
				?>
				<div class="w3-cell-row my-hover-light-grey">
					<div class="my-cell" style='width: 2in;'><?php echo $examRow["Section Code Full"] . "/" . $lSectionCodeFull?></div>
					<div class="my-cell" style='min-width: 1in;'><?php echo $lSubjectCode?></div>
					<div class="my-cell" style='width: 1in;'><?php echo $lRoom?></div>
					<div class="my-cell" style='width: 1in;'><?php echo date("g:i A", strtotime($lStart));?></div>
					<div class="my-cell" style='width: 1in;' step="900"><?php echo date("g:i A", strtotime($lEnd));?></div>
					<div class="my-cell" style='width: 2in;'><?php echo $lUserName; ?></div>
					<div class="my-cell" style='width: 1.5in; text-align: center;'><?php echo $lStudentCount + $examRow["Student Count"]; ?></div>
					<div class="my-cell" style='white-space: nowrap; width: 1in;'>
						<button class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteSchedule('<?php echo $lId; ?>','<?php echo $targDay; ?>')" type="button">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
					</div>
				</div>
				<?php
			}
			else{
				?>
				<div class="w3-cell-row my-hover-light-grey">
					<div class="my-cell" style='width: 2in;'><?php echo $lSectionCodeFull?></div>
					<div class="my-cell" style='min-width: 1in;'><?php echo $lSubjectCode?></div>
					<div class="my-cell" style='width: 1in;'><?php echo $lRoom?></div>
					<div class="my-cell" style='width: 1in;'><?php echo date("g:i A", strtotime($lStart));?></div>
					<div class="my-cell" style='width: 1in;' step="900"><?php echo date("g:i A", strtotime($lEnd));?></div>
					<div class="my-cell" style='width: 2in;'><?php echo $lUserName; ?></div>
					<div class="my-cell" style='width: 1.5in; text-align: center;'><?php echo $lStudentCount; ?></div>
					<div class="my-cell" style='white-space: nowrap; width: 1in;'>
						<button class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteSchedule('<?php echo $lId; ?>','<?php echo $targDay; ?>')" type="button">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
					</div>
				</div>
				<?php
			}
			$lSectionCodeFull = $examRow["Section Code Full"];
			$lSubjectCode = $examRow["subjectCode"];
			$lRoom = $examRow["Room"];
			$lStart = $examRow["Start"];
			$lEnd = $examRow["End"];
			$lUserName = $examRow["User Name"];
			$lStudentCount = $examRow["Student Count"];
			$lId = $examRow['Id'];
		}
	}

	?>
	<div class="w3-cell-row my-hover-light-grey">
		<div class="my-cell" style='width: 2in;'><?php $lSectionCodeFull?></div>
		<div class="my-cell" style='min-width: 1in;'><?php echo $lSubjectCode?></div>
		<div class="my-cell" style='width: 1in;'><?php echo $lRoom?></div>
		<div class="my-cell" style='width: 1in;'><?php echo date("g:i A", strtotime($lStart));?></div>
		<div class="my-cell" style='width: 1in;' step="900"><?php echo date("g:i A", strtotime($lEnd));?></div>
		<div class="my-cell" style='width: 2in;'><?php echo $lUserName; ?></div>
		<div class="my-cell" style='width: 1.5in; text-align: center;'><?php echo $lStudentCount; ?></div>
		<div class="my-cell" style='white-space: nowrap; width: 1in;'>
			<button class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteSchedule('<?php echo $lId; ?>','<?php echo $targDay; ?>')" type="button">
				<i class="fas fa-minus" aria-hidden="true"></i>
			</button>
		</div>
	</div>
	<?php
}
?>