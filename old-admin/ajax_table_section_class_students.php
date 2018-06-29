<div style="display: table-header-group;">
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Student name</b>
	<b class="w3-border-bottom w3-border-blue" style="display: table-cell;"></b>
</div>
<?php
	include "../util_dbHandler.php";
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("SELECT `Id`, CONCAT(`users`.`First Name`, ' ', `users`.`Middle Name`, ' ', `users`.`Family Name`) AS `Full Name` FROM `class_students` JOIN `users` ON `class_students`.`Student Id` = `users`.`Id Number` WHERE `Class Id` = ?");
	$stmt->bind_param('i', $_REQUEST['classId']);
	$stmt->execute();
	$classResult = $stmt->get_result();
	if ($classResult->num_rows > 0) {
		while ($classRow = $classResult->fetch_assoc()) {
			?>
			<div class="my-hover-light-grey" style="display: table-row;">
				<div style="display: table-cell;"> <?php echo $classRow['Full Name']; ?></div>
				<div style="display: table-cell;" style="width: 0.5in">
					<button
						class="my-button w3-hover-red w3-hover-text-white"
						onclick="removeStudentFromClass('<?php echo $classRow['Id']; ?>')"
						type='button'>
						<i class='fas fa-minus' aria-hidden='true'></i>
					</button>
				</div>
			</div>
			<?php
		}
	}
	else{
		?>
		<div class="my-hover-light-grey" style="display: table-row;">
			<div style="display: table-cell;">Nothing to show</div>
			<div style="display: table-cell;" style="width: 0.5in"></div>
		</div>
		<?php
	}
?>






