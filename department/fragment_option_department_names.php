<?php
	# ----------- OBSELETE -----------

	#include("../util_dbHandler.php");
	#$stmt = null;
	#$stmt = $conn->prepare("SELECT * FROM `departments` ORDER BY `Name` ASC;");
	#$stmt->execute();
	#$accessResult = $stmt->get_result();
	#if ($accessResult->num_rows > 0) {
	#	while ($accesssRow = $accessResult->fetch_assoc()) {
	#		?><option value="<?php echo $accesssRow['Id'] ?>"><?php echo $accesssRow["Name"] ?></option><?php
	#	}
	#}
	#else{
	#	?><option value="-">Please add a department</option><?php
	#}
?>
<?php
	$stmt = null;
	$stmt = $conn->prepare("SELECT `Id`,`Name` FROM `courses` WHERE `Dean_Id` = ?;");
	$stmt->bind_param("s",$_SESSION["ID"]);
	$stmt->execute();
	$departments = $stmt->get_result();
	if ($departments->num_rows > 0) {
		while ($deptRow = $departments->fetch_assoc()) {
			?><option value="<?php echo $accesssRow['Id'] ?>"><?php echo $accesssRow["Name"] ?></option><?php
		}
	}
	else{
		?><option value="-">Please add a department</option><?php
	}
?>