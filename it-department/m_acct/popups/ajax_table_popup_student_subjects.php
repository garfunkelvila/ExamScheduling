<div style="display: table-header-group;">
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Subject name</b>
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Subject code</b>
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Section</b>
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;"></b>
</div>
<?php
	include_once "../../../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_student_subjects`(?)");
	$stmt->bind_param('s', $_REQUEST['idNum']);
	$stmt->execute();
	$subjResult = $stmt->get_result();
	#$subjRow = $stmt->get_result()->fetch_row();
	if ($subjResult->num_rows > 0){
		while ($subjRow = $subjResult->fetch_assoc()) {
			?><div style="display: table-row;">
				<div style="display: table-cell;"><?php echo $subjRow['Name']; ?></div>
				<div style="display: table-cell;"><?php echo $subjRow['Code']; ?></div>
				<div style="display: table-cell;"><?php echo $subjRow['sectCode']; ?></div>
				<div style="display: table-cell;">
					<button title="Remove from class" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="removeFromSection('<?php echo $subjRow['id']; ?>')">
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