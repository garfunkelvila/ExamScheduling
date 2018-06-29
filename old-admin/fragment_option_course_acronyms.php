<?php
	include("../util_dbHandler.php");
	$stmt = null;
	$stmt = $conn->prepare("SELECT * FROM `courses`");
	$stmt->execute();
	$accessResult = $stmt->get_result();
	if ($accessResult->num_rows > 0) {
		while ($accesssRow = $accessResult->fetch_assoc()) {
			?><option value="<?php echo $accesssRow['Course Code'] ?>"><?php echo $accesssRow['Acronym'] ?></option><?php
		}
	}
	else{
		?><option value="-">Please add a course first</option><?php
	}
?>