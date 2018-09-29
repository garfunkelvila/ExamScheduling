<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
?>
<html>
<head>
	<title></title>
	<style type="text/css">
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>
<body>
	<?php
		$stmt = null;
		$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible'");
		#$stmt->bind_param('i', $_REQUEST['q']);
		$stmt->execute();
		$vResult = $stmt->get_result();
		$vRow = $vResult->fetch_row();
		if ($vRow[0] == 1){
			$stmt = null;
			$stmt = $conn->prepare("SELECT `Str Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
			#$stmt->bind_param('i', $_REQUEST['q']);
			$stmt->execute();
			$perResult = $stmt->get_result();
			$perRow = $perResult->fetch_row();
			$per = $perRow[0];

			$stmt = null;
			$stmt = $conn->prepare("SELECT calc_SY()");
			#$stmt->bind_param('i', $_REQUEST['q']);
			$stmt->execute();
			$syResult = $stmt->get_result();
			$syRow = $syResult->fetch_row();
			$sy = $syRow[0];

			?><h1>Schedules for <?php echo $per; ?><label> SY: <?php echo $sy; ?> - <?php echo $sy + 1; ?></label></h1><?php
			
			$stmt = null;
			$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
			#$stmt->bind_param('i', $_REQUEST['q']);
			$stmt->execute();
			$dayResult = $stmt->get_result();
			if ($dayResult->num_rows > 0) {
				?><table style="width: 100%">
				<tr>
					<th>Name</th>
					<th>Time</th>
					<th>Room</th>
					<th>Section Code</th>
					<th>Subject Code</th>
				</tr><?php
				while ($dayRow = $dayResult->fetch_assoc()) {
					$stmt = null;
					$stmt = $conn->prepare("CALL `select_guardian_exam_schedule`(?,?)");
					$stmt->bind_param('si', $_SESSION['ID'],$dayRow['Id']);
					$stmt->execute();
					$skedResult = $stmt->get_result();
					if ($skedResult->num_rows > 0) {
						?><tr><td colspan="5"><b><?php echo $nf->format($dayRow['rank']) . " day"; ?> : <?php echo date("F j, Y", strtotime( $dayRow['Date'])); ?></b></td></tr><?php
						while ($skedRow = $skedResult->fetch_assoc()) {
							?><tr>
								<td style="text-align: center;"><?php echo $skedRow['First Name']; ?></td>
								<td style="text-align: center;"><?php echo date("g:i A", strtotime($skedRow['Start'])); ?> to <?php echo date("g:i A", strtotime($skedRow['End'])); ?></td>
								<td style="text-align: center;"><?php echo $skedRow['Room']; ?></td>
								<td style="text-align: center;"><?php echo $skedRow['Section Code Full']; ?></td>
								<td style="text-align: center;"><?php echo $skedRow['Code']; ?></td>
							</tr>
							<?php
						}
					}
					else{
					}
				}
				?></table><?php
			}
			else{
			}
		}
		else{
			echo "No schedules posted yet";
		}
	?>


<script type="text/javascript">
	window.print();
</script>
</body>
</html>