<?php
	include "../util_dbHandler.php";
	#***************************************************
	
	if ($_REQUEST['subjId'] != 0){
		$stmt = null;
		$stmt = $conn->prepare("SELECT `classes`.`Section Code` AS `SectCode`, `classes`.`Id` AS `cId` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `Course Code` = ? AND `Year Level` = ?  AND `Subject Id` = ?");
		$stmt->bind_param('sii', $_REQUEST['course'], $_REQUEST['level'], $_REQUEST['subjId']);
		$stmt->execute();
		$courseResult = $stmt->get_result();
		if ($courseResult->num_rows > 0) {
			?><option value="0">Select section</option><?php
			while ($lvlRow = $courseResult->fetch_assoc()) {
				?>
					<option value="<?php echo $lvlRow['cId'] ?>>"><?php echo $lvlRow['SectCode'] ?></option>
				<?php
			}
		}
		else{
			?><option value="0">No section available</option><?php
		}
	}
	else{
		?><option value="0">Select a subject first</option><?php
	}
?>