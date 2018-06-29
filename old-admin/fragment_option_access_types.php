<?php
	$stmt = null;
	$stmt = $conn->prepare("SELECT * FROM `users_access_types` WHERE `Level` IN ('1','2') ORDER BY `Level` DESC;");
	$stmt->execute();
	$accessResult = $stmt->get_result();
	$x = 1;
	if ($accessResult->num_rows > 0) {
		while ($accesssRow = $accessResult->fetch_assoc()) {
			?><option value="<?php echo $accesssRow["Id"] ?>"><?php echo $accesssRow["Name"] ?></option><?php
		}
	}
?>