<?php
	if(isset($lvlRow['Year Level']) == true){
		$yearLvl = $lvlRow['Year Level'];
	}
	else{
		# IT MEANS IT IS CALLED FROM AJAX
		include "../../util_dbHandler.php";
		$yearLvl = $_REQUEST['level'];
		$locale = 'en_US';
	}
?><div class="w3-container" style="display: table-row;">
	<div class="my-cell"><b>Subject Code</b></div>
	<div class="my-cell" style="width: 2in;"><b>Professor</b></div>
	<div class="my-cell" style="width: 1in;"><b>Section</b></div>
	<div class="my-cell" style="width: 1in;"><b>Action</b></div>
</div>
<?php
$stmt = null;
$stmt = $conn->prepare("CALL `select_classes`(?,?)");
$stmt->bind_param('si',$_REQUEST['id'], $yearLvl);
$stmt->execute();
$cResult = $stmt->get_result();
if ($cResult->num_rows > 0) {
	while ($cRow = $cResult->fetch_assoc()) {
		//---------- SUBJECT LOOPER
		?><div class="my-hover-light-grey w3-container" style="display: table-row;">
			<div class="my-cell"><?php echo $cRow['subjectCode']; ?></div>
			<div class="my-cell" id="v-Prof-<?php echo $cRow['Id']; ?>" style="width: 2in;"><?php echo $cRow['FullName']; ?> <a href="#" class="w3-tiny w3-text-blue" onclick="editProctor2(<?php echo $cRow['Id']; ?>)">[Change]</a></div>
			<div class="my-cell" id="e-Prof-<?php echo $cRow['Id']; ?>" style="width: 2in; display: none;">
				<input class="my-input-2" id="txbCProf-<?php echo $cRow['Id']; ?>" style="width: 1.75in;" required="" type="text" value="<?php echo $cRow['ProfId']; ?>" oninput="toggleProctorChooser2('<?php echo $cRow['Id']; ?>','<?php echo $yearLvl; ?>')"> <a href="#" class="w3-tiny w3-text-blue" onclick="editProctor2(<?php echo $cRow['Id']; ?>)">[x]</a>
				<div class="w3-dropdown-content w3-bar-block w3-border" id="prof-Filler-<?php echo $cRow['Id']; ?>">
				</div>
			</div>
			<div class="my-cell" style="width: 1in;"><?php echo $cRow['sectionCode']; ?></div>
			<div class="my-cell" style="width: 1in;">
				<button title="Delete section" class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteSection('<?php echo $cRow['Id']; ?>','<?php echo $yearLvl; ?>')" type="button">
					<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<?php
	}
}?>