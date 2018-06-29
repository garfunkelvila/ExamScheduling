<option class="w3-bar-item w3-button" value="-">-Setion-</option>
<?php
	include "../../util_dbHandler.php";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_sections_not_endorsed`(?,'')");
	$stmt->bind_param("s",$_SESSION["ID"]);
	$stmt->execute();
	$pResult = $stmt->get_result();
	if ($pResult->num_rows > 0) {
		while ($pRow = $pResult->fetch_assoc()) {
			?><option class="w3-bar-item w3-button" value="<?php echo $pRow['sect']; ?>"><?php echo $pRow['sect']; ?></option><?php
		}
	}
	else{
		?><option class="w3-bar-item w3-button" value="-">No result</option><?php
	}
?>