<?php
	include_once("../util_dbHandler.php");
	include_once("util_logs_vars.php");
	$from = ($_REQUEST['page'] - 1) * $logsCountPerPage;
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_logs_user_actions`(?,?);");
	$stmt->bind_param('ii', $from, $logsCountPerPage);
	$stmt->execute();
	$logsResult = $stmt->get_result();
	if ($logsResult->num_rows > 0) {
		while ($logsRow = $logsResult->fetch_assoc()) {

			if ($logsRow['Action Id'] == '1'){
				?><li class="w3-pale-yellow"><b><?php echo $logsRow['User Name']; ?></b> : <?php echo $logsRow['Message']; ?></li><?php
			}
			else if ($logsRow['Action Id'] == '2'){
				?><li class="w3-pale-green"><b><?php echo $logsRow['User Name']; ?></b> : <?php echo $logsRow['Message']; ?></li><?php
			}
			else if ($logsRow['Action Id'] == '3'){
				?><li class="w3-pale-red"><b><?php echo $logsRow['User Name']; ?></b> : <?php echo $logsRow['Message']; ?></li><?php
			}
		}
	}
?>