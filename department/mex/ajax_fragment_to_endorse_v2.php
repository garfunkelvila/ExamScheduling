<?php
	include_once("../../util_dbHandler.php");
	include_once("../util_check_isEndorsed.php");
	include_once("../../util_check_stage.php");
?>
<div class="w3-container" style="display: table-row;">
	<div style="display: table-cell; text-align: center; width: 1in;"><b>Section Code</b></div>
	<div style="display: table-cell; text-align: center; width: 1in;"><b>Subject Code</b></div>
	<div style="display: table-cell; text-align: center;"><b>Teacher</b></div>
	<div style="display: table-cell; text-align: center; width: 1.5in;"><b>Assigned Proctor</b></div>
	<div style="display: table-cell; text-align: center; width: 0.5in;"><b>Span</b></div>
	<?php if($isEndorsed == false) {?><div style="display: table-cell; text-align: center; width: 0in;"><b>Action</b></div><?php } ?>

	
</div>
<?php if($isEndorsed == false){
	?><form class="w3-container" style="display: table-row;" id="frmAddEndorse" onsubmit="return addToEndorse()">
		<div style="display: table-cell; text-align: center;">
			<select class="my-input-1" id="optSect" onchange="fillSubject()"></select>
		</div>
		<div style="display: table-cell; text-align: center;">
			<select class="my-input-1" id="optSubj" onchange="fillTeacher()">
				<option class="w3-bar-item w3-button" value="-">n/a</option>
			</select>
		</div>
		<div style="display: table-cell; text-align: center;"><input class="my-input-1" readonly type="text" id="teacher" placeholder="Section teacher" style="text-align: center; height: 17.58px"></div>
		<div style="display: table-cell; text-align: center;">
			<select class="my-input-1" id="optProc">
				<option class="w3-bar-item w3-button" value="-">-Proctor-</option>
				<?php
					$stmt = null;
					$stmt = $conn->prepare("CALL `select_prof_department`(?);");
					$stmt->bind_param('s', $_SESSION['ID']);
					$stmt->execute();
					$pResult = $stmt->get_result();
					if ($pResult->num_rows > 0) {
						while ($pRow = $pResult->fetch_assoc()) {
							?><option class="w3-bar-item w3-button" value="<?php echo $pRow['Id Number']?>"><?php echo $pRow['fullName'];?></option><?php
						}
					}
			?></select>
		</div>
		<div style="display: table-cell; text-align: center; width: 1in;">
			<select class="my-input-1" id="span">
					<option value="60" Selected>1 hr</option>
					<option value="75">1.25 hr</option>
					<option value="90">1.5 hr</option>
			</select>
		</div>
		<div style="display: table-cell; text-align: center;">
			<?php if($stage == 2){
				?><button title="Add section" class="my-button w3-hover-green w3-hover-text-white">
					<i class="fas fa-plus"></i>
				</button><?php
			} ?>
		</div>
	</form><?php
}
?>
<script type="text/javascript">fillSection();</script>
<?php
	$subjCode = isset($_REQUEST['subjCode']) ? $_REQUEST['subjCode'] : '';
	$sectCode = isset($_REQUEST['sectCode']) ? $_REQUEST['sectCode'] : '';

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_endorsed_exams_dean`(?,?,?,?);");
	#$stmt->bind_param('sssi',$_SESSION['ID'], $_REQUEST['subjCode'], $_REQUEST['sectCode'], $_REQUEST['day']);
	$stmt->bind_param('sssi',$_SESSION['ID'], $subjCode, $sectCode, $_REQUEST['day']);
	$stmt->execute();
	$usResult = $stmt->get_result();
	if ($usResult->num_rows > 0) {
		while ($usRow = $usResult->fetch_assoc()) {
			?><div class="my-hover-light-grey w3-container" style="display: table-row;">
				<div style="display: table-cell; text-align: center;"><?php echo $usRow['Section Code Full']; ?></div>
				<div style="display: table-cell; text-align: center;"><?php echo $usRow['Code']; ?></div>
				<div style="display: table-cell; text-align: center;"><?php echo $usRow['teacher']; ?></div>
				<div style="display: table-cell; text-align: center;"><?php echo $usRow['proctor']; ?></div>
				<div style="display: table-cell; text-align: center; width: 0.5in;"><?php echo $usRow['span']/60; ?> hr</div>
				<?php if($isEndorsed == false) {?><div style="display: table-cell; text-align: center; width: 0in; white-space: nowrap;">
					<button title="Delete section" class="my-button w3-hover-red w3-hover-text-white" onclick="removeToEndorse('<?php echo $usRow['id']; ?>')" type="button">
						<i class="fas fa-minus"></i>
					</button>
				</div><?php } ?>
				
			</div><?php
		}
	}
?>