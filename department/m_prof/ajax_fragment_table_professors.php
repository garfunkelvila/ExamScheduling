<?php
	include "../../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_prof_department`(?);");
	$stmt->bind_param('s', $_SESSION['ID']);
	$stmt->execute();
	$pResult = $stmt->get_result();
	if ($pResult->num_rows > 0) {
		?><div class="w3-container" style="display: table-row;">
			<div class="my-cell"><b>Professor Name</b></div>
			<div class="my-cell" style="width: 1in;"><b>Action</b></div>
		</div><?php
		while ($pRow = $pResult->fetch_assoc()) {
			?><div class="my-hover-light-grey w3-container professor" id="prof-view-<?php echo $pRow['Id Number']?>" style="display: table-row;">
				<div class="my-cell" id="lblSubjName-34"><?php echo $pRow['fullName'];?></div>
				<div class="my-cell" style="width: 1in;">
					<button title="Edit professor" class="my-button w3-hover-green" onclick="btnEditProf('<?php echo $pRow['Id Number']?>')" type="button">
						<i class="far fa-edit" aria-hidden="true"></i>
					</button><button title="Delete professor" class="my-button w3-hover-red w3-hover-text-white" onclick="deleteProfessor('<?php echo $pRow['Id Number']?>')" type="button">
						<i class="far fa-trash-alt" aria-hidden="true"></i>
					</button>
				</div>
			</div>
			<form class="w3-cell-row my-pale-green my-hover-light-grey w3-container" id="prof-edit-<?php echo $pRow['Id Number']?>" style="display: none;">
				<div class="my-cell" id="lblSubjName-34">
					<input style="width: 32%; text-transform: capitalize;" class="my-input-1" type="text" id="pEditfName-<?php echo $pRow['Id Number']?>" value="<?php echo $pRow['fName']?>">
					<input style="width: 32%; text-transform: capitalize;" class="my-input-1" type="text" id="pEditmName-<?php echo $pRow['Id Number']?>" value="<?php echo $pRow['mName']?>">
					<input style="width: 32%; text-transform: capitalize;" class="my-input-1" type="text" id="pEditlName-<?php echo $pRow['Id Number']?>" value="<?php echo $pRow['lName']?>">
				</div>
				<div class="my-cell" style="width: 1in;">
					<button title="Apply" class="my-button w3-hover-green" onclick="editProfessor('<?php echo $pRow['Id Number']?>')" type="submit">
						<i class="fas fa-check" aria-hidden="true"></i>
					</button><button title="Cancel" class="my-button w3-hover-red w3-hover-text-white" onclick="btnCancelEditProf('<?php echo $pRow['Id Number']?>')" type="button">
						<i class="fas fa-ban" aria-hidden="true"></i>
					</button>
				</div>
			</form>
			<?php
		}
	}
	else{
		?>No professors to show<?php
	}
?>
