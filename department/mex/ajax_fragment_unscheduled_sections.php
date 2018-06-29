<?php
	include "../../util_dbHandler.php";
	include("../../util_check_stage.php");
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_dean_unscheduled_subjects`(?,?,?);");
	$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['subjCode'], $_REQUEST['sectCode']);
	$stmt->execute();
	$usResult = $stmt->get_result();
	if ($usResult->num_rows > 0) {
		?><div class="w3-container" style="display: table-row;">
			<!--div class="my-cell" style="width: 0.2in;"><input type="checkbox" onchange="checkAll(this)"></div-->
			<div class="my-cell" style="width: 1in;"><b>Subject Code</b></div>
			<div class="my-cell"><b>Professor Name</b></div>
			<div class="my-cell" style="width: 1in; text-align: center;"><b>Section Code</b></div>
			<div class="my-cell" style="width: 2in;"><b>Proctor Name</b></div>
			<div class="my-cell" style="width: 1.75in;"><b>Span</b></div>
			<div class="my-cell" style="width: 0in;"><b></b></div>
			<!--div class="my-cell" style="width: 0.3in;"><b></b></div-->
		</div><?php
		while ($usRow = $usResult->fetch_assoc()) {
			?><form class="w3-container my-hover-light-grey" style="display: table-row;" onsubmit="return addToEndorse('<?php echo $usRow['Id']; ?>')">
				<!--div class="my-cell" style="width: 0.2in;"><input class="chkSubjs" type="checkbox" name=""></div-->
				<div class="my-cell" style="width: 1in;"><?php echo $usRow['SubjCode']; ?></div>
				<div class="my-cell""><?php echo $usRow['profFullName']; ?></div>
				<div class="my-cell" style="width: 1in; text-align: center;"><?php echo $usRow['SectFull']; ?></div>
				<div class="my-cell" style="width: 2in;" id="v1-<?php echo $usRow['Id']; ?>">
					<input class="my-input-1" type="text" placeholder="Type here to search" id="txbProc-<?php echo $usRow['Id']; ?>" oninput="toggleProctorChooser('<?php echo $usRow['Id']; ?>')" required="">
						<div id="pc-<?php echo $usRow['Id']; ?>" class="w3-dropdown-content w3-bar-block w3-border">
							Loading...
						</div>
				</div>
				<div class="my-cell" style="width: 2in; display: none;" id="e1-<?php echo $usRow['Id']; ?>">
					<label id="lblNam-<?php echo $usRow['Id']; ?>">Test Proctor Name</label> <a href="#" onclick="editProctor('<?php echo $usRow['Id']; ?>')" class="w3-tiny w3-text-blue">[Edit]</a>
				</div>
				<div class="my-cell" style="width: 1.75in;">
					<select class="my-input-2" id="span-<?php echo $usRow['Id']; ?>">
						<option value="60" <?php if (!$usRow['IsMajor']) echo "Selected"; ?>>1 hr</option>
						<option value="75">1.25 hr</option>
						<option value="90" <?php if ($usRow['IsMajor']) echo "Selected"; ?>>1.5 hr</option>
					</select>
					<select class="my-input-2" id="day-<?php echo $usRow['Id']; ?>">
						<?php 
							#$stmt = null;
							#$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
							#$stmt->bind_param("ss",$_SESSION["ID"],$_REQUEST["q"]);
							#$stmt->execute();
							#$dResult = $stmt->get_result();
							#if ($dResult->num_rows > 0) {
							$i = 1;
							while ($i <= 5) {
								?><option value="<?php echo $i; ?>"><?php echo $nf->format($i) ?></b></option><?php
								$i++;
							}
							#}
						?>
					</select>
				</div>
				<div class="my-cell" style="width: 0in; white-space: nowrap;">
					<button title="Add to endorse" class="my-button w3-hover-green w3-hover-text-white">
						<i class="fas fa-plus" aria-hidden="true"></i>
					</button>
				</div>
			</form><?php
		}
	}
	else{
		?>No section to show<?php
	}
?>