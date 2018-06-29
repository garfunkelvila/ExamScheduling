<div class="w3-center">
<?php
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
	$stmt->execute();
	$dayResult = $stmt->get_result();
	if ($dayResult->num_rows > 0) {
		while ($dayRow = $dayResult->fetch_assoc()) {
			$stmt = null;
			$stmt = $conn->prepare("CALL `select_count_dean_day_endorsed`(?,?)");
			$stmt->bind_param('si', $_SESSION['ID'], $dayRow['rank']);
			$stmt->execute();
			$syResult = $stmt->get_result();
			$syRow = $syResult->fetch_row();
			$count = $syRow[0];


			?><div class="w3-card-4 w3-margin test" style="min-width:3in; display: inline-block;">
				<header class="w3-container my-blue">
				<h5><?php echo $nf->format($dayRow['rank']) . " day"; ?></h5>
				</header>
				<div class="w3-container">
					<p>Endorsed sections: <b><?php echo $count; ?></b>
				</div>
				<div class="w3-center w3-padding">
					<a href="manage_exam_schedule.php?dayRank=<?php echo $dayRow['rank']; ?>" class="w3-button my-blue" type="button">View</a>
				</div>
			</div><?php
		}
	}
	else{
		?><div class="w3-card-4 w3-margin test" style="max-width:3in; display: inline-block;">
			<header class="w3-container my-blue">
			<h5>Endorsment not open yet</h5>
			</header>
			<div class="w3-container">
				<p>Please wait for confirmation from SDO and this page will show exam dates.</b>
			</div>
		</div><?php
	}
?>
</div>