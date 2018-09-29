<?php
	//-----------------------------------
	#query dont like null objects
	#$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	#$deptId = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : '';
	#$subjLvl = isset($_REQUEST['subjLvl']) ? $_REQUEST['subjLvl'] : '';
	#$q = isset($_REQUEST['q']) ? str_replace(' ', '%', $_REQUEST['q']) : '';
	#$q = str_replace(' ', '%', $_REQUEST['q']);

	
	#echo $nf->format($number);
	if (isset($levelRow['Year Level'])){
		$cYearLevel = $levelRow['Year Level'];
	}
	else{
		$cYearLevel = $_REQUEST['year'];
		$courseId = $_REQUEST['course'];
		include_once "../util_dbHandler.php";
	}

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_classes`(?,?);");
	$stmt->bind_param('si', $courseId, $cYearLevel);
	$stmt->execute();
	$classResult = $stmt->get_result();
	if ($classResult->num_rows > 0) {
		?>
		<div class="w3-cell-row w3-container">
			<div class="my-cell"><b>Subject Code</b></div>
			<div class="my-cell" style="width: 0.5in;"><b>Section</b></div>
			<div class="my-cell" style="width: 0.75in; text-align: center;"><b>Stud. Count</b></div>
			<div class="my-cell" style="white-space: nowrap; width: 0.75in;"></div>
		</div>
		<?php
		while ($classRow = $classResult->fetch_assoc()) {
			?><div class="w3-cell-row my-hover-light-grey w3-container">
				<div class="my-cell" id="lblSubjCode-<?php echo $classRow['Id'] ?>"><?php echo $classRow["subjectCode"]; ?></div>
				<div class="my-cell" style="width: 0.5in;" id="lblSectCode-<?php echo $classRow['Id'] ?>"><?php echo $classRow['courseCode'] . $classRow['yearLevel'] . $classRow['sectionCode'] ?></div>
				<div class="my-cell" style="width: 0.75in; text-align: center;"><?php echo $classRow['count'] ?></div>
				<div class="my-cell" style="white-space: nowrap; width: 0.75in;">
					<button title="View class" class="my-button w3-hover-green w3-hover-text-white" onclick="btnViewClass('<?php echo $classRow['Id'] ?>')" type="button">
						<i class="fas fa-eye" aria-hidden="true"></i>
					</button>
					<button title="Delete class" class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteClass('<?php echo $classRow['Id'] . "','" . $classRow['yearLevel']; ?>')" type="button">
						<i class="fas fa-minus" aria-hidden="true"></i>
					</button>
				</div>
			</div><?php
		}
	}
	else{
		?>
			<div class="w3-cell-row my-hover-light-grey w3-container">Please add a class</div>
		<?php
	}
?>
