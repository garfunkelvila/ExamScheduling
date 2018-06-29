<option value="-">-Year level-</option>
<?php
	include "../../util_dbHandler.php";
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
	#SPECIFICALLY JUST FOR INIT SECTIONS
	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT(`Year Level`) as `yLvl` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level` ASC");
	$stmt->bind_param('s',$_REQUEST['id']);
	$stmt->execute();
	$departments = $stmt->get_result();
	if ($departments->num_rows > 0) {
		while ($deptRow = $departments->fetch_assoc()) {
			?><option value="<?php echo $deptRow['yLvl'] ?>"><?php echo $nf->format($deptRow['yLvl']) ?> Year</option><?php
		}
	}
	else{
		?><option value="-">No year to show</option><?php
	}
?>