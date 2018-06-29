<div class="w3-container" style="display: table-row;">
	<div class="w3-border-bottom w3-border-blue" style="display: table-cell;"><b>Name</b></div>
	<div class="w3-border-bottom w3-border-blue" style="width: 1in; text-align: center; display: table-cell; min-width: 1in;"><b>ID</b></div>
	<div class="w3-border-bottom w3-border-blue" style="width: 0.5in; display: table-cell;"></div>
</div>
<?php
	include "../../../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_pre_reg_guardian_monitor`(?);");
	$stmt->bind_param('i', $_REQUEST['idNum']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	if ($sResult->num_rows > 0) {
		while ($sRow = $sResult->fetch_assoc()) {
			?>
				<div class="w3-container" style="display: table-row;">
					<div class="w3-hoverable" style="display: table-cell;"><?php echo $sRow["Name"] ?></div>
					<div class="w3-hoverable" style="width: 1in; text-align: center; display: table-cell; min-width: 1in;"><?php echo $sRow["Id Number"] ?></div>
					<div class="w3-hoverable" style="width: 0.5in; display: table-cell;">
						<button title="Delete class" class="my-button w3-hover-red w3-hover-text-white" onclick="removeStudent('<?php echo $sRow["Id"] ?>')" type="button">
						<i class="fas fa-minus" aria-hidden="true"></i>
						</button>
					</div>
				</div>
			<?php
		}
	}
?>