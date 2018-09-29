
<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	#**********************
	$locale = 'en_PH';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
	$stmt = null;
	$stmt = $conn->prepare("SELECT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level`;");
	$stmt->bind_param('s',$_REQUEST['course']);
	$stmt->execute();
	$yearResult = $stmt->get_result();
	if ($yearResult->num_rows > 0) {
		while ($yearRow = $yearResult->fetch_assoc()) {
			?>
			<b class="w3-container w3-border-bottom" style="display: block;"><?php echo $nf->format($yearRow['Year Level']); ?></b>
			<div class="w3-cell-row w3-container">
				<div class="my-cell" style="width: 50%">
					<?php include_once("fragment_table_subjects_by_course_item_subjects.php"); ?>
				</div>
				<div class="my-cell" style="width: 50%">
					<?php #include_once("fragment_table_subjects_by_course_item_classes.php"); ?>
				</div>
			</div>
			<?php
		}
	}
	else{
		echo "Nothing to show";
	}
?>
