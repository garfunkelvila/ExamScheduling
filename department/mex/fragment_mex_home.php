<?php 
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_dean_total_sections`(?);");
		$stmt->bind_param('s',$_SESSION['ID']);
		$stmt->execute();
		$sectCount = $stmt->get_result()->fetch_row()[0];

		$stmt = null;
		$stmt = $conn->prepare("CALL `select_dean_endorsed_total`(?);");
		$stmt->bind_param('s',$_SESSION['ID']);
		$stmt->execute();
		$endorsedCount = $stmt->get_result()->fetch_row()[0];


		$stmt = null;
		$stmt = $conn->prepare("CALL `select_dean_not_endorsed_total`(?);");
		$stmt->bind_param('s',$_SESSION['ID']);
		$stmt->execute();
		$notEndorsedCount = $stmt->get_result()->fetch_row()[0];
?>
<div class="w3-center">
	<div class="w3-card-4 w3-margin test" style="min-width:3in; display: inline-block;">
		<header class="w3-container my-blue">
		<h5>Sections</h5>
		</header>
		<div class="w3-container">
			<p>Not endorsed sections: <b><?php echo $notEndorsedCount; ?></b>
		</div>
		<div class="w3-center w3-padding">
			<a href="manage_exam_schedule.php?view=1" class="w3-button my-blue" type="button">View</a>
		</div>
	</div><div class="w3-card-4 w3-margin test" style="min-width:3in; display: inline-block;">
		<header class="w3-container my-blue">
		<h5>To endorse</h5>
		</header>
		<div class="w3-container">
			<p><b></b><p>
			<p>Total endorsed sections: <b><?php echo $endorsedCount; ?></b>
		</div>
		<div class="w3-center w3-padding">
			<a href="manage_exam_schedule.php?view=2" class="w3-button my-blue" type="button">View</a>
		</div>
	</div>
</div>