<?php
	include_once("../../util_dbHandler.php");
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
?>
<h6><?php echo $_REQUEST['ip']; ?></h6>
<table style="width: 100%">
	<tr>
		<?php
		$stmt = null;
		$stmt = $conn->prepare("SELECT DATE(`Date Time`) AS `Date`, TIME(`Date Time`) AS `Time`,`Url`,`User Agent` FROM `logs_page_visit` WHERE `REMOTE_ADDR` = ? ORDER BY `Date Time` DESC LIMIT 1000");
		$stmt->bind_param('s', $_REQUEST['ip']);
		$stmt->execute();
		$sResult = $stmt->get_result();
		#$subjRow = $stmt->get_result()->fetch_row();
		if ($sResult->num_rows > 0){
			?><th style="width: 1in;">Date</th>
			<th style="width: 1in;">Time</th>
			<th style="max-width: 3in;">URL</th>
			<th>User Agent</th><?php
			while ($sRow = $sResult->fetch_assoc()) {
				?><tr>
					<td><?php echo $sRow['Date']; ?></td>
					<td><?php echo $sRow['Time']; ?></td>
					<td><?php echo $sRow['Url']; ?></td>
					<td><?php echo $sRow['User Agent']; ?></td>
				</tr><?php
			}
		}
		else{
			echo "Empty";
		}?>
	</tr>
</table>