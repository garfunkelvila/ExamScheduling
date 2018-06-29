<?php 
	include "../../util_dbHandler.php";
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` JOIN `classes` ON `subjects`.`Id` = `classes`.`Subject Id` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
	$stmt->bind_param('s', $_REQUEST['id']);
	$stmt->execute();
	$lvlResult = $stmt->get_result();
	if ($lvlResult->num_rows > 0) {
		while ($lvlRow = $lvlResult->fetch_assoc()) {
			?><b><?php echo $nf->format($lvlRow['Year Level']) ?> Year</b>
			<div class="w3-border-blue w3-border-top w3-container" id="year-<?php echo $lvlRow['Year Level']; ?>" style="display: table; width: 100%; max-width: 8in">
				<?php include "../m_sect/ajax_fragment_sections_items.php"; ?>
			</div><?php
		}
	}
	else{
		?>No sections to show<?php
	}
?>