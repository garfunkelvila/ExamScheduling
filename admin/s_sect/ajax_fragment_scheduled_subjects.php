<?php
	
	if (!isset($_REQUEST['a'])){
		#called via include_once
		include_once "../util_dbHandler.php";
	}
	else{
		#called via ajax
		include_once "../../util_dbHandler.php";
	}
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
	

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	if (isset($_REQUEST['id'])){
		#If a day is selected, show it directly
		$dayId = $_REQUEST['id'];
		?><div class="" style="width: 100%; max-width: 8in; display: table; text-align: center;"><?php
		include_once "fragment_scheduled_subjects_table.php";
		?></div><?php
	}
	else{
		#If all, show the date header
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
		#$stmt->bind_param('s', $dayId);
		$stmt->execute();
		$dateResult = $stmt->get_result();
		if ($dateResult->num_rows > 0) {
			while ($dateRow = $dateResult->fetch_assoc()) {
				$dayId = $dateRow['Id'];
				?><h6><?php echo date("F j, Y (l)", strtotime($dateRow["Date"])); ?></h6>
				<div class="w3-border-top w3-border-blue" style="width: 100%; max-width: 8in; display: table; text-align: center;"><?php
				include_once "fragment_scheduled_subjects_table.php";
				?></div><?php
			}
		}
	}
?>
