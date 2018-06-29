<?php
	include "../util_dbHandler.php";
	#***************************************************
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
	$stmt->execute();
	$deptResult = $stmt->get_result();
	if ($deptResult->num_rows > 0) {
		?><h3>Schedules for Prelim <label>SY: 2016 - 2017</label></h3><?php
		while ($deptRow = $deptResult->fetch_assoc()) {
			?>
			
			$.each(response.result, function(i, item){
							$("#sched-container").append("<div id='sched-sub-items'>" + subjTable(item["Id"],item["rank"]) +
								"</div>");
						});
			<?php
		}
	}
	else{
		
	}
?>