<?php # Check this for error, it dont show 2 sections?>
<div style="display: table-row;">
	<div style='display:table-cell; width: 1in;'><b>Section</b></div>
	<div style='display:table-cell; '><b>Subject</b></div>
	<div style='display:table-cell; width: 1in;'><b>Room</b></div>
	<div style='display:table-cell; width: 1in;'><b>Start</b></div>
	<div style='display:table-cell; width: 1in;'><b>End</b></div>
	<div style='display:table-cell; width: 2in;'><b>Professor Name</b></div>
	<div style='display:table-cell; width: 0.75in; text-align: center;'><b>Stud. Count</b></div>
	<div style='display:table-cell; white-space: nowrap; width: 1in;'><b>Action</b></div>
</div>
<?php
include_once "../util_dbHandler.php";

$targDay = isset($dayRow['Id']) ? $dayRow['Id'] : $_REQUEST['day'];

#echo $targDay;

$stmt = null;
$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible';");
$stmt->execute();
$cResult = $stmt->get_result();
$sRow = $cResult->fetch_row();
$examVisible = $sRow[0];

$stmt = null;
$stmt = $conn->prepare('CALL `select_exam_schedules`(?)');
$stmt->bind_param('i', $targDay);
$stmt->execute();
$examResult = $stmt->get_result();
while ($examRow = $examResult->fetch_assoc()){
	?>
	<div class="my-hover-light-grey" style="display: table-row;">
		<div style='display: table-cell; width: 1in;'><?php echo $examRow["SectFull"]?></div>
		<div style='display: table-cell; min-width: 1in;'><?php echo $examRow["subjectCode"]?></div>
		<div style='display: table-cell; width: 1in;'><?php echo $examRow["Room"]?></div>
		<div style='display: table-cell; width: 1in;'><?php echo date("g:i A", strtotime($examRow["Start"]));?></div>
		<div style='display: table-cell; width: 1in;' step="900"><?php echo date("g:i A", strtotime($examRow["End"]));?></div>
		<div style='display: table-cell; width: 2in;'><?php echo $examRow["User Name"]; ?></div>
		<div style='display: table-cell; width: 0.75in; text-align: center;'><?php echo $examRow["Student Count"]; ?></div>
		<div style='display: table-cell; white-space: nowrap; width: 1in;'>
			<button title="Delete schedule" class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteSchedule('<?php echo $examRow['Id']; ?>','<?php echo $targDay; ?>')" type="button">
				<i class="fas fa-minus" aria-hidden="true"></i>
			</button>
		</div>
	</div>
	<?php
}
?>
<form style="display: table-row;" name="frmAddSked-<?php echo $targDay; ?>" onsubmit="return addSchedule('<?php echo $targDay; ?>')">
	<div style='display: table-cell; width: 1in;'>
		<input class="my-input-1" type="text" autocomplete="off" name="strSection-<?php echo $targDay; ?>" id="idStrSection-<?php echo $targDay; ?>" placeholder="Section" required="" list="sectionsDatalist-<?php echo $targDay; ?>" onfocus="fillSectionDatalist('<?php echo $targDay; ?>')">
	</div>
	<div style="display: table-cell;">
		<input class="my-input-1" type="text" autocomplete="off" style='min-width: 1in;' name="strSubject-<?php echo $targDay; ?>" id="idStrSubject-<?php echo $targDay; ?>" placeholder="Subject" required="" list="subjectsDatalist-<?php echo $targDay; ?>" onfocus="fillSubjectDatalist('<?php echo $targDay; ?>')" onblur="fillStudentCount('<?php echo $targDay; ?>')">
	</div>
	<div style='display: table-cell; width: 1in; min-width: 1in;'>
		<input class="my-input-1" type="text" name="strSubject-<?php echo $targDay; ?>" id="idStrRoom-<?php echo $targDay; ?>" placeholder="Room" required="">
	</div>
	<div style='display: table-cell; width: 1in; min-width: 1in;'>
		<input class="my-input-1" type="time" min="14:00:00" max="19:00:00" name="strStartTime-<?php echo $targDay; ?>" id="idstrStartTime-<?php echo $targDay; ?>" required="">
	</div>
	<div style='width: 1in; min-width: 1in;'>
		<!--input class="my-input-1" type="time" name="strEndTime-<?php #echo $dayRow['Id']; ?>" id="idstrEndTime-<?php #echo $dayRow['Id']; ?>" required=""-->
		<input class="my-input-1" type="text" name="strLength-<?php echo $targDay; ?>" id="idStrLength-<?php echo $targDay; ?>" list="lstMinutes" placeholder="Minutes" required="">
	</div>
	<div style='display: table-cell; width: 2in;'>
		<input class="my-input-1" type="text" autocomplete="off" name="strProctorId-<?php echo $targDay; ?>" id="idstrProctorId-<?php echo $targDay; ?>" placeholder="Proctor ID" required="" list="proctorsDatalist-<?php echo $targDay; ?>" onfocus="fillProctorDatalist(<?php echo $targDay; ?>)">
	</div>
	<div style='display: table-cell; width: 0.75in; text-align: center;'>
		<label id="lblStudentCount-<?php echo $targDay; ?>">--</label>
	</div>
	<div style='display: table-cell; white-space: nowrap; width: 1in;'>
		<button title="Add schedule" id='btnOkSubj'
			class='my-button w3-hover-green'
			type='submit'
			style=''>
			<i class='fas fa-plus' aria-hidden='true'></i></button>
	</div>
</form>
<datalist id="proctorsDatalist-<?php echo $targDay; ?>"></datalist>
<datalist id="sectionsDatalist-<?php echo $targDay; ?>"></datalist>
<datalist id="subjectsDatalist-<?php echo $targDay; ?>"></datalist>