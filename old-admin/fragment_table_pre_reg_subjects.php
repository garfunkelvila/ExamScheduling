<?php
	include_once "../util_dbHandler.php";

	#***************************************************
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_pre_reg_classes`(?)");
	$stmt->bind_param('i', $_REQUEST['idNum']);
	$stmt->execute();
	$subjResult = $stmt->get_result();
	if ($subjResult->num_rows > 0) {
		?>
		<div style="display: table-header-group;">
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Subject name</b>
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Subject code</b>
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Section</b>
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell;"></b>
		</div>
		<?php
		while ($subjRow = $subjResult->fetch_assoc()) {
			?>
				<div style="display: table-header-group;" id="tClass-<?php echo $subjRow['SubjId']; ?>">
					<div style="display: table-cell;"><?php echo $subjRow['SubjName']; ?></div>
					<div style="display: table-cell;"><?php echo $subjRow['SubjCode']; ?></div>
					<div style="display: table-cell;"><?php echo $subjRow['SectCode']; ?></div>
					<div style="display: table-cell;">
						<button title="Delete class" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="removeFromSection('<?php echo $subjRow['cId']; ?>')">
							<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			<?php
		}
	}
	else{
		?>Please add the student to section<?php
	}
?>