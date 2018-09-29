<div style="display: table-row;">
	<div style="display: table-cell;"><b>Name</b></div>
	<div style="display: table-cell; width: 2in;"><b>Acronym</b></div>
	<div style="display: table-cell; width: 1in;"><b>Code</b></div>
	<div style="display: table-cell; width: 0.5in;"><b>Action</b></div>
</div>
<?php
	include_once "../../util_dbHandler.php";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_courses_with_total`(?);");#This query requires dept user ID, unless will return null
	$stmt->bind_param("s",$_SESSION["ID"]);
	$stmt->execute();
	$tResult = $stmt->get_result();
	if ($tResult->num_rows > 0) {
		while ($tRow = $tResult->fetch_assoc()) {
			?><div class="course" style="display: table-row;">
				<div style="display: table-cell;"><?php echo $tRow["Name"]; ?></div>
				<div style="display: table-cell; width: 2in;"><?php echo $tRow["Acronym"]; ?></div>
				<div style="display: table-cell; width: 1in;"><?php echo $tRow["CourseCode"]; ?></div>
				<div style="display: table-cell; width: 0.5in;">
					<button title="Delete section" class="my-button w3-hover-red w3-hover-text-white" onclick="btnDeleteCourse('<?php echo $tRow["CourseCode"]; ?>')" type="button">
						<i class="far fa-trash-alt" aria-hidden="true"></i>
					</button>
				</div>
			</div><?php
		}
	}
	else{
		?><div style="display: table-row;">
			<div style="display: table-cell;">n/a</div>
			<div style="display: table-cell; width: 2in;">n/a</div>
			<div style="display: table-cell; width: 1in;">n/a</div>
			<div style="display: table-cell; width: 0.5in;">n/a</div>
		</div><?php
	}
?>