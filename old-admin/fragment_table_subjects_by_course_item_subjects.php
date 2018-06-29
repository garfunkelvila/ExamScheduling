<!-- UNUSED -->
<?php
	$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	$deptId = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : '';
	$subjLvl = isset($_REQUEST['subjLvl']) ? $_REQUEST['subjLvl'] : '';
	$q = isset($_REQUEST['q']) ? str_replace(' ', '%', $_REQUEST['q']) : '';

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_subjects`(?,?,?,?);");
	$stmt->bind_param('ssis', $deptId, $_REQUEST['course'], $yearRow['Year Level'], $q);
	$stmt->execute();
	$subjResult = $stmt->get_result();
	if ($subjResult->num_rows > 0) {
		while ($subjRow = $subjResult->fetch_assoc()) {
			?>
			<form class="w3-cell-row my-hover-light-grey w3-container" onsubmit="return frmAddClass('12','1')">
				<div class="my-cell"><?php $subjRow['subjectName'] ?></div>
				<div class="my-cell" style="width: 1in;"><?php $subjRow['subjectCode'] ?></div>
				<div class="my-cell" style="white-space: nowrap; width: 1in;">
					<input
						class="my-input-2 txbSection"
						id="txbSection-12"
						style="width: 0.5in; text-transform: uppercase"
						required=""
						onkeyup="validateSection(this)"
						oninvalid="validateSection(this)"
						type="text"
						maxlength="1">
						<button class="my-button w3-hover-green w3-hover-text-white"><i class="fas fa-plus" aria-hidden="true"></i></button>
				</div>
			</form>
			<?php
		}
	}
	else{
		echo "Nothing to show";
	}
?>