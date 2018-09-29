<div style="display: table-header-group;">
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Student name</b>
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell; width: 0.5in"></b>
</div>
<?php
	include_once "../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_guardian_monitor`(?)");
	$stmt->bind_param('s', $_REQUEST['idNum']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	#$subjRow = $stmt->get_result()->fetch_row();
	if ($sResult->num_rows > 0){
		while ($sRow = $sResult->fetch_assoc()) {
			?><div style="display: table-row;">
				<div style="display: table-cell;"><?php echo $sRow['Full Name']; ?></div>
				<div style="display: table-cell;">
					<button title="Remove from class" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="removeStudent('<?php echo $sRow['Id']; ?>')">
						<i class="fas fa-minus" aria-hidden="true"></i>
					</button>
				</div>
			</div><?php
			#$subjRow[''];
		}
	}
	else{
		?><div style="display: table-row;">
			<div style="display: table-cell;">Nothing to show</div>
			<div style="display: table-cell;"></div>
		</div><?php
	}
?>