<?php
	$stmt = null;
	$stmt = $conn->prepare("SELECT * FROM `subjects` ORDER BY `Name` ASC;");
	$stmt->execute();
	$subjectResult = $stmt->get_result();
	if ($subjectResult->num_rows > 0) {
		while ($subjectRow = $subjectResult->fetch_assoc()) {
			?><option value="<?php echo $subjectRow['Id'] ?>"><?php echo $subjectRow["Name"] ?></option><?php
		}
	}
	else{
		?><option value="-">Please add a department</option><?php
	}
?>