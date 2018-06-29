<?php
	//include "../util_dbHandler.php";

	if (isset($levelRow['Year Level'])){
		$cYearLevel = $levelRow['Year Level'];
	}
	else{
		$cYearLevel = $_REQUEST['year'];
		$courseId = $_REQUEST['course'];
		include "../util_dbHandler.php";
	}



	//-----------------------------------
	#query dont like null objects
	#$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	$deptId = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : '';
	#$subjLvl = isset($_REQUEST['subjLvl']) ? $_REQUEST['subjLvl'] : '';
	$q = isset($_REQUEST['q']) ? str_replace(' ', '%', $_REQUEST['q']) : '';
	#$fullSect = isset($_REQUEST['fullSect']) ? $_REQUEST['fullSect'] : '';
	#$q = str_replace(' ', '%', $_REQUEST['q']);

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_subjects`(?,?,?,?);");
	$stmt->bind_param('ssis', $deptId, $courseId, $cYearLevel, $q);
	$stmt->execute();
	$subjectResult = $stmt->get_result();
	if ($subjectResult->num_rows > 0) {
		$lastDept = null;
		?>
		<div class="w3-cell-row w3-container">
		<div class="my-cell"><b>Subject Name</b></div>
		<div class="my-cell" style="width: 1in;"><b>Subject Code</b></div>
		<div class="my-cell" style="white-space: nowrap; width: 1in;"><b>Add class</b></div>
		<div class="my-cell" style="width: 1in;"></div>
		</div>
		<?php
		while ($subjectRow = $subjectResult->fetch_assoc()) {
			?><form class="w3-cell-row my-hover-light-grey w3-container"
				id="subj-view-<?php echo $subjectRow['Id']; ?>"
				onsubmit="return frmAddClass('<?php echo $subjectRow['Id'] . "','" . $cYearLevel; ?>')">
				<div class="my-cell" id="lblSubjName-<?php echo $subjectRow['Id']; ?>"><?php echo $subjectRow['subjectName']; ?></div>
				<div class="my-cell" style="width: 1in;"><?php echo $subjectRow['subjectCode']; ?></div>
				<div class="my-cell" style="white-space: nowrap; width: 1in;">
					<input
						class="my-input-2 txbSection"
						type="text"
						id="txbSection-<?php echo $subjectRow['Id'] ?>"
						placeholder="..."
						maxlength="1"
						style="width: 0.5in; text-transform: uppercase; text-align: center;"
						oninvalid="validateSection(this)"
						onkeyup="validateSection(this)"
						required>
					<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">
						<i class="fas fa-angle-double-right" aria-hidden="true"></i>
					</button>
				</div>
				<div class="my-cell" style="width: 1in;">
					<button title="Edit subject" class="my-button w3-hover-green" type="button"
						onclick="btnEditSubj('<?php echo $subjectRow['Id']; ?>')">
						<i class="far fa-edit" aria-hidden="true"></i>
					</button>
					<button title="Delete subject" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="btnDeleteSubj('<?php echo $subjectRow['Id']; ?>','<?php echo $cYearLevel; ?>')">
						<i class="far fa-trash-alt" aria-hidden="true"></i>
					</button>
				</div>
			</form>
				
			<form class="w3-cell-row my-pale-green my-hover-light-grey w3-container"
				style="display: none;"
				id="subj-edit-<?php echo $subjectRow['Id']; ?>"
				onsubmit="return btnComitEditSubj('<?php echo $subjectRow['Id']; ?>','<?php echo $cYearLevel; ?>')">
				<div class="my-cell"><input type="text" style="width: 100%;" class="my-input-2" id="txbSubjName-<?php echo $subjectRow['Id']; ?>" value="<?php echo $subjectRow['subjectName']; ?>" required></div>
				<div class="my-cell" style="width: 1in;"><input type="text" style="width: 100%;" class="my-input-2" id="txbSubjCode-<?php echo $subjectRow['Id']; ?>" value="<?php echo $subjectRow['subjectCode']; ?>" required> </div>
				<div class="my-cell" style="width: 1in;"></div>
				<div class="my-cell" style="white-space: nowrap; width: 1in;">
					<button title="Commit edit" class="my-button w3-hover-green">
						<i class="fas fa-check" aria-hidden="true"></i>
					</button>
					<button title="Cancel edit" class="my-button w3-hover-red w3-hover-text-white" type="button"
						onclick="btnCancelEditSubj('<?php echo $subjectRow['Id']; ?>')">
						<i class="fas fa-ban" aria-hidden="true"></i>
					</button></div>
			</form><?php
		}
	}
	else{
		?>
		<div class="w3-cell-row my-hover-light-grey w3-container">Please add a subject</div>
		<?php
	}
?>