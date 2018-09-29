<?php
	if(isset($lvlRow['Year Level']) == true){
		$yearLvl = $lvlRow['Year Level'];
	}
	else{
		# IT MEANS IT IS CALLED FROM AJAX
		include_once "../../util_dbHandler.php";
		$yearLvl = $_REQUEST['level'];
		$locale = 'en_US';
	}
?><div class="w3-container" style="display: table-row;">
	<div class="my-cell"><b>Subject Name</b></div>
	<div class="my-cell" style="width: 2in;"><b>Subject Code</b></div>
	<div class="my-cell" style="width: 0.5in;"><b></b></div>
	<div class="my-cell" style="width: 1in;"><b>Action</b></div>
</div>
<?php
$stmt = null;
$stmt = $conn->prepare("SELECT `Id`,`Name`,`Code`,`Is Major` FROM `subjects` WHERE `Year Level` = ? AND `Course Code` = ?");
$stmt->bind_param('is',$yearLvl, $_REQUEST['id']);
$stmt->execute();
$subjResult = $stmt->get_result();
if ($subjResult->num_rows > 0) {
	while ($subjRow = $subjResult->fetch_assoc()) {
		//---------- SUBJECT LOOPER
		if ($subjRow['Is Major'] == 0){
			$isMajor = "Minor";
		}
		else if ($subjRow['Is Major'] == 1){
			$isMajor = "Major";
		}
		#THAT SUBJECT CLASS IS JUST USED FOR SELECTOR TO COUNT THEM AT SPECIFIC PAGES
		?><div class="my-hover-light-grey w3-container subject" id="subj-view-<?php echo $subjRow['Id']; ?>" style="display: table-row;">
			<div class="my-cell" id="lblSubjName-34"><?php echo $subjRow['Name']; ?></div>
			<div class="my-cell" style="width: 2in;"><?php echo $subjRow['Code']; ?></div>
			<div class="my-cell" style="width: 0.75in;"><?php echo $isMajor; ?></div>
			<div class="my-cell" style="width: 1in;">
				<button title="Edit subject" class="my-button w3-hover-green" type="button" onclick="btnEditSubj('<?php echo $subjRow['Id']; ?>')">
					<i class="far fa-edit" aria-hidden="true"></i>
				</button><button title="Delete subject" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="btnDeleteSubj('<?php echo $subjRow['Id']; ?>','<?php echo $yearLvl; ?>')">
					<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<form class="w3-cell-row my-pale-green my-hover-light-grey w3-container" style="display: none;" id="subj-edit-<?php echo $subjRow['Id']; ?>" onsubmit="return btnApplyEditSubj('<?php echo $subjRow['Id']; ?>','<?php echo $yearLvl; ?>')">
			<div class="my-cell"><input type="text" style="width: 100%;" class="my-input-2" id="txbSubjName-<?php echo $subjRow['Id']; ?>" value="<?php echo $subjRow['Name']; ?>" required=""></div>
			<div class="my-cell" style="width: 2in;"><input type="text" style="width: 100%;" class="my-input-2" id="txbSubjCode-<?php echo $subjRow['Id']; ?>" value="<?php echo $subjRow['Code']; ?>" required=""> </div>
			<div class="my-cell" style="width: 0.75in;">
				<select class="my-input-1" id="cmbMajor-<?php echo $subjRow['Id']; ?>">
					<option value="0" <?php if ($subjRow['Is Major'] == 0) echo "selected"?>>Minor</option>
					<option value="1"<?php if ($subjRow['Is Major'] == 1) echo "selected"?>>Major</option>
				</select>
			</div>
			<div class="my-cell" style="white-space: nowrap; width: 1in;">
				<button title="Commit edit" class="my-button w3-hover-green" type="submit">
					<i class="fas fa-check" aria-hidden="true"></i>
				</button><button title="Cancel edit" class="my-button w3-hover-red w3-hover-text-white" type="button" onclick="btnCancelEditSubj('<?php echo $subjRow['Id']; ?>')">
					<i class="fas fa-ban" aria-hidden="true"></i>
				</button>
			</div>
		</form>
		<?php
	}
}?>