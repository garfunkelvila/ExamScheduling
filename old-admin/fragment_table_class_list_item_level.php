<?php
	include "../util_dbHandler.php";
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	//-----------------------------------
	$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level`;");
	$stmt->bind_param('s', $courseId);
	$stmt->execute();
	$levelResult = $stmt->get_result();
	if ($levelResult->num_rows > 0) {
		$lastDept = null;
		while ($levelRow = $levelResult->fetch_assoc()) {
			?><b class="w3-container w3-border-blue w3-border-bottom" style="display: block;"><?php  echo $nf->format($levelRow['Year Level']); ?> Year</b>
			<div class="w3-cell-row w3-container">
				<div class="my-cell" style="width: 65%" id="<?php  echo "subject-lvl-" . $levelRow['Year Level']; ?>">
					<?php include "fragment_table_class_list_item_subject_table.php"; ?>
				</div>
				<div class="w3-border-blue w3-border-left" style="display:table-cell"></div>
				<div class="my-cell" style="width: 35%" id="<?php  echo "class-lvl-" . $levelRow['Year Level']; ?>">
					<?php include "fragment_table_class_list_item_class_table.php"; ?>
				</div>
			</div><?php
		}
	}
	else{
		?>Please add a subject<?php
	}
?>