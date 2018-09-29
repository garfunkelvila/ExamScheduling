<?php 
	include_once "../../util_dbHandler.php";
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
	$stmt->bind_param('s', $_REQUEST['id']);
	$stmt->execute();
	$lvlResult = $stmt->get_result();
	if ($lvlResult->num_rows > 0) {
		while ($lvlRow = $lvlResult->fetch_assoc()) {
			?><b><?php echo $nf->format($lvlRow['Year Level']) ?> Year</b>
				<div class="w3-border-blue w3-border-top" id="year-<?php echo $lvlRow['Year Level']?>" style="display: table; width: 100%;">
				<?php include_once "../m_subj/ajax_fragment_subjects_items.php"; ?>
			</div><?php
		}
	}
?>