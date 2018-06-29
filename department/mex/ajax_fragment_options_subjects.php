<?php
	include "../../util_dbHandler.php";

	if ($_REQUEST['sect'] != '-'){
		
			$stmt = null;
			$stmt = $conn->prepare("CALL `select_subject_code_from_section`(?,?)");
			$stmt->bind_param('ss',$_SESSION['ID'],$_REQUEST['sect']);
			$stmt->execute();
			$pResult = $stmt->get_result();
			if ($pResult->num_rows > 0) {
				?><option class="w3-bar-item w3-button" value="-">-Subject-</option><?php 
				while ($pRow = $pResult->fetch_assoc()) {
					?><option class="w3-bar-item w3-button" value="<?php echo $pRow['subjId']; ?>"><?php echo $pRow['subjC']; ?></option><?php
				}
			}
			else{
				?><option class="w3-bar-item w3-button" value="-">No result</option><?php
			}
		?><?php
	}
	else{
		?><option class="w3-bar-item w3-button" value="-">n/a</option><?php
	}
?>
