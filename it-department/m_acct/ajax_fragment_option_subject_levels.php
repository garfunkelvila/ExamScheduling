<?php
	include_once "../../util_dbHandler.php";

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	#***************************************************

	if ($_REQUEST['course'] != '0'){
		$stmt = null;
		$stmt = $conn->prepare("SELECT DISTINCT(`subjects`.`Year Level`) AS `Level` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `subjects`.`Course Code` = ? ORDER BY `subjects`.`Year Level` ASC;");
		$stmt->bind_param('s', $_REQUEST['course']);
		$stmt->execute();
		$courseResult = $stmt->get_result();
		if ($courseResult->num_rows > 0) {
			?><option value="0">Select year level</option><?php
			while ($lvlRow = $courseResult->fetch_assoc()) {
				?>
					<option value="<?php echo $lvlRow['Level']; ?>"><?php echo $nf->format($lvlRow['Level']) ?> Year</option>
				<?php
			}
		}
		else{
			?><option value="0">No year level available</option><?php
		}
	}
	else{
		?><option value="0">Select a course first</option><?php
	}

	
?>