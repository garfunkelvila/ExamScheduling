<?php
	include_once "../../util_dbHandler.php";
	include_once("../../util_check_stage.php");
	include_once("../util_check_isEndorsed.php");

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
	echo "IF WILL BE USED, ADD DAY RANK PARAMETER";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_endorsed_exams_dean`(?,?,?);");
	$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['subjCode'], $_REQUEST['sectCode']);
	$stmt->execute();
	$usResult = $stmt->get_result();
	if ($usResult->num_rows > 0) {
		?><div class="w3-container" style="display: table-row;">
			<div class="my-cell" style="width: 2in;"><b>Proctor Name</b></div>
			<div class="my-cell"><b>Subject Name</b></div>
			<div class="my-cell" style="width: 1in;"><b>Subject Code</b></div>
			<div class="my-cell" style="width: 1in;"><b>Section</b></div>
			<div class="my-cell" style="width: 0.75in;"><b>Span</b></div>
			<div class="my-cell" style="width: 0.5in;"><b>Day</b></div>
			<div class="my-cell" style="width: 0.5in;"><b></b></div>
		</div><?php
		while ($usRow = $usResult->fetch_assoc()) {
			$span = ($usRow['Span'] / 60) . " hr";
			?><div class="w3-container my-hover-light-grey" style="display: table-row;">
				<div class="my-cell" style="width: 2in;"><?php echo $usRow['fullName']; ?></div>
				<div class="my-cell"><?php echo $usRow['Name']; ?></div>
				<div class="my-cell" style="width: 1in;"><?php echo $usRow['Code']; ?></div>
				<div class="my-cell" style="width: 1in;"><?php echo $usRow['Section Code Full']; ?></div>
				<div class="my-cell" style="width: 0.75in;"><?php echo $span; ?></div>
				<div class="my-cell" style="width: 0.5in;"><?php echo $nf->format($usRow['DayRank']) ?></div>
				<div class="my-cell" style="width: 0.5in;">
					<?php
						if ($isEndorsed != 1){
							?><button title="Delete schedule" class="my-button w3-hover-red w3-hover-text-white" onclick="removeToEndorse('<?php echo $usRow['id']; ?>')" type="button">
								<i class="fas fa-minus" aria-hidden="true"></i>
							</button><?php
						}
					?>
					
				</div>
			</div><?php
		}
	}
	else{
		?>No section to show<?php
	}
?>