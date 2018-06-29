<div id="divView<?php echo $courseRow['Course Code'] ?>"
	class="w3-cell-row my-hover-light-grey w3-container">
	<div class="my-cell" id="lblCourseName<?php echo $courseRow['Course Code'] ?>"><?php echo $courseRow["Name"] ?></div>
	<div class="my-cell" id="lblCourseAccr<?php echo $courseRow['Course Code'] ?>" style="width: 1in;"><?php echo $courseRow["Acronym"] ?></div>
	<div class="my-cell" id="lblCourseAccr<?php echo $courseRow['Course Code'] ?>" style="width: 1in;"><?php echo $courseRow["Course Code"] ?></div>
	<div class="my-cell" style="white-space: nowrap; width: 1in;">
		<button
			class="my-button w3-hover-green"
			type="button"
			onclick="btnEditCourse('<?php echo $courseRow["Course Code"] ?>')">
				<i class="far fa-edit" aria-hidden="true"></i></button>
		<button 
			class="my-button w3-hover-red w3-hover-text-white"
			type="button"
			onclick="btnDeleteCourse('<?php echo $courseRow["Course Code"] ?>')">
				<i class="far fa-trash-alt" aria-hidden="true"></i></button>
	</div>
</div>
<form onsubmit="return btnComitEditCourse('<?php echo $courseRow["Course Code"] ?>')"
	class="w3-cell-row my-pale-green w3-container"
	id="frmCourse<?php echo $courseRow['Course Code'] ?>"
	style="display: none;">
	<div class="my-cell">
		<input id="txbCourseName<?php echo $courseRow['Course Code'] ?>"
			class="my-input-2"
			type="text"
			style="width: 100%;"
			value="<?php echo $courseRow["Name"] ?>"
			required>
	</div>
	<div class="my-cell" style="width: 1in;">
		<input id="txbCourseAccr<?php echo $courseRow['Course Code'] ?>"
			class="my-input-2 w3-cell"
			type="text"
			style="width: 100%;"
			value="<?php echo $courseRow["Acronym"] ?>"
			required>
	</div>
	<div class="my-cell" style="width: 1in;">
		<!--input id="txbCourseCode<?php echo $courseRow['Course Code'] ?>"
			class="my-input-2 w3-cell"
			type="text"
			style="width: 100%;"
			value="<?php echo $courseRow["Course Code"] ?>"
			required-->
			<?php echo $courseRow["Course Code"] ?>
	</div>
	<div class="my-cell" style="white-space: nowrap; width: 1in;">
		<button id="btnOkCourse<?php echo $courseRow['Course Code'] ?>"
			class="my-button w3-hover-green"
			type="submit"
			style="">
			<i class="fas fa-check" aria-hidden="true"></i></button>
		<button id="btnCancelDept<?php echo $courseRow['Course Code'] ?>"
			class="my-button w3-hover-red w3-hover-text-white"
			type="button"
			style=""
			onclick="btnCancelEditCourse('<?php echo $courseRow["Course Code"] ?>')">
			<i class="fas fa-ban" aria-hidden="true"></i></button>
	</div>
</form>