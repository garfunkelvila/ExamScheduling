<a href="#"
	class="w3-button"
	onclick="refreshLogList(1)">
	<i class="fas fa-angle-double-left" aria-hidden="true"></i></a>
<?php
	include_once("../util_dbHandler.php");
	include_once("util_logs_vars.php");
	$logsStart;
	$logsEnd;

	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`Id`) FROM `logs_user_actions`");
	$stmt->execute();
	$logsDivided =  intval($stmt->get_result()->fetch_row()[0] / $logsCountPerPage);
	#echo $logsDivided;
	#THIS PARTS TARGETS TO LIMIT VISIBLE PAGES TO 5
	if($_REQUEST['page'] < 3){
		#hitting lower limit
		#echo "Low";
		$logsStart = 1;
		$logsEnd = $logsDivided <= 5 ? $logsDivided : 5;
	}
	elseif($_REQUEST['page'] >= $logsDivided - 1){
		#hitting upper limit
		#echo "High";
		$logsStart = $logsDivided > 5 ? ($logsDivided - 4) : 1;
		$logsEnd = $logsDivided;
	}
	else{
		#echo "Mid" . $logsDivided;
		#hitting nothing
		$logsStart = ($_REQUEST['page']) - 2;
		$logsEnd = ($_REQUEST['page']) + 2;
	}

	for ($i = $logsStart; $i <= $logsEnd; $i++) {
		if ($i == $_REQUEST['page']){
			?><a href="#"
			onclick="refreshLogList(<?php echo $i; ?>)"
			class="w3-button my-blue"><?php echo $i; ?></a><?php
		}
		else{
			?><a href="#"
			onclick="refreshLogList(<?php echo $i; ?>)"
			class="w3-button"><?php echo $i; ?></a><?php
		}
	}
?>
<a href="#"
	class="w3-button"
	onclick="refreshLogList(<?php echo $logsDivided; ?>)">
	<i class="fas fa-angle-double-right" aria-hidden="true"></i></a>