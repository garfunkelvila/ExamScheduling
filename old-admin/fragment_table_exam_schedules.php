<?php 
include_once "../util_dbHandler.php";

$stmt = null;
$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible';");
$stmt->execute();
$cResult = $stmt->get_result();
$sRow = $cResult->fetch_row();
$examVisible = $sRow[0];
?>

<?php 
	#if (!isset($_REQUEST['day'])) echo "Date not set";
	#if (!is_null($_REQUEST['day'])) echo "Date not set";
	#echo $_REQUEST['day'];
	
	$dayID = is_numeric($_REQUEST['day']) ? $_REQUEST['day'] : "";


	include_once "../util_dbHandler.php";
	
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`(?)");
	$stmt->bind_param('i', $dayID);
	$stmt->execute();
	$daysResult = $stmt->get_result();
	if ($daysResult->num_rows > 0) {
		while ($dayRow = $daysResult->fetch_assoc()) {
			$curDate = date("F j, Y (l)", strtotime($dayRow["Date"]));
				#echo $classRow["Id"];
			?>
			<h5 class="w3-border-bottom w3-border-blue">
				<div id="viewDayId-<?php echo $dayRow['Id']; ?>" style="display: inline;"><?php echo "Day " . $dayRow["rank"] . " : " . $curDate; ?></div>
				<button title="Edit day" id="btnEditSked-"
					class="my-button w3-hover-green"
					type="button"
					onclick="document.getElementById('day-<?php echo $dayRow['Id']; ?>').style.display='block'">
					<i class="far fa-edit" aria-hidden="true"></i>
				</button>
				<button title="Delete day" id='btnOkSubj'
					class='my-button w3-hover-red'
					type='submit'
					style=''
					onclick="deleteDate('<?php echo $dayRow['Id']; ?>')">
					<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
			</h5>
			<div id="day-<?php echo $dayRow['Id']; ?>" class="w3-modal">
				<div class="w3-modal-content" style="max-width: 3in;">
					<div class="w3-container">
						<span onclick="document.getElementById('day-<?php echo $dayRow['Id']; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
						<p>Please enter the new date.</p>
						<p>Please do take note that you can't set date to past</p>
						<div class="w3-card w3-padding" style="display: inline-block; width: 100%;">
							<input
								id="txbEditDate-<?php echo $dayRow['Id']; ?>"
								class="my-input-1"
								type="date"
								min="<?php echo date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")+1, date("Y")));; ?>"
								max="<?php echo (date("Y") + 1) . date("-m-d"); ?>"
								value="<?php echo date("Y-m-d", strtotime($dayRow["Date"])); ?>">
							<br>
							<button class="my-input-1 my-blue" style="cursor: pointer;" type="button" onclick="updateDate('<?php echo $dayRow['Id']; ?>')">Update Day</button>	
						</div>
						<p></p>
					</div>
				</div>
			</div>
			<div style="display: table; width: 100%" id="dayItemsContainer-<?php echo $dayRow['Id']; ?>"><?php
				include_once "fragment_table_exam_schedules_item.php";
			?></div>
			<?php
		}
	}
	else{
		echo "Nothing to show";
	}
?>
<datalist id="lstMinutes">
	<option value="60">1 hr</option>
	<option value="90">1 hr 30 mins</option>
</datalist>