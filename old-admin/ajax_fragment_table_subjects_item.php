<div id="viewSubjCode<?php echo $subjectRow['Id'] ?>"
	class="w3-cell-row my-hover-light-grey w3-container">
	<div id="lblSubjCode<?php echo $subjectRow['Id'] ?>" class="w3-rest w3-cell" style="width: 2in; max-width: 2in"><?php echo $subjectRow['subjectCode'] ?></div>
	<div id="lblSubjName<?php echo $subjectRow['Id'] ?>" class="w3-rest w3-cell"><?php echo $subjectRow['subjectName'] ?></div>
	<div class="w3-cell" style="width: 0; white-space: nowrap;">
		<button id="btnEditSubj<?php echo $subjectRow['Id'] ?>"
			class="my-button w3-hover-green"
			type="button"
			onclick="btnEditSubj(<?php echo $subjectRow['Id'] ?>)">
				<i class="far fa-edit" aria-hidden="true"></i>
		</button>
		<button id="btnDeleteSubj<?php echo $subjectRow['Id'] ?>"
			class="my-button w3-hover-red w3-hover-text-white"
			type="button"
			onclick="btnDeleteSubj(<?php echo $subjectRow['Id'] ?>)">
				<i class="far fa-trash-alt" aria-hidden="true"></i></button>
	</div>
</div>

<form id="frmSubjCode<?php echo $subjectRow['Id'] ?>"
	class="w3-cell-row my-pale-green w3-container" style="display: none;"
	onsubmit="return btnDoneEditSubj(<?php echo $subjectRow['Id'] ?>)">
	<div class="w3-cell" style="width: 2in; max-width: 2in">
		<input
			class="my-input-2"
			type="text"
			id="txbSubjCode<?php echo $subjectRow['Id'] ?>"
			value="<?php echo $subjectRow['subjectCode'] ?>"
			required
			style="width: 100%;">
	</div>
	<div class="w3-rest w3-cell">
		<input
			class="my-input-2"
			type="text"
			id="txbSubjName<?php echo $subjectRow['Id'] ?>"
			value="<?php echo $subjectRow['subjectName'] ?>"
			required
			style="width: 100%">
	</div>
	<div class="w3-cell" style="width: 0; white-space: nowrap;">
		<button id="btnDoneEditSubj<?php echo $subjectRow['Id'] ?>"
			class="my-button w3-hover-green"
			type="submit"
			style="">
			<i class="fas fa-check" aria-hidden="true"></i>
		</button>
		<button id="btnCancelEditSubj<?php echo $subjectRow['Id'] ?>"
			class="my-button w3-hover-red w3-hover-text-white"
			type="button"
			style=""
			onclick="btnCancelEditSubj(<?php echo $subjectRow['Id'] ?>)">
			<i class="fas fa-ban" aria-hidden="true"></i>
		</button>
	</div>
</form>