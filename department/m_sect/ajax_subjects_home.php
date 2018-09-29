<div class="w3-center">
	<?php
		include_once "../../util_dbHandler.php";
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_courses_with_total`(?);");#This query requires dept user ID, unless will return null
		$stmt->bind_param("s",$_SESSION["ID"]);
		$stmt->execute();
		$tResult = $stmt->get_result();
		if ($tResult->num_rows > 0) {
			while ($tRow = $tResult->fetch_assoc()) {
				?>
				<div class="w3-card-4 w3-margin test" style="min-width:3in; display: inline-block;">
					<header class="w3-container my-blue">
					<h5><?php echo $tRow["Acronym"]; ?></h5>
					</header>

					<div class="w3-container">
						<p><b><?php echo $tRow["Name"]; ?></b><p>
						<p>Total sections: <b><?php echo $tRow["TotalSections"]; ?></b>
					</div>
					<div class="w3-center w3-padding">
						<a href="manage_sections.php?view=<?php echo $tRow["CourseCode"]; ?>" class="w3-button my-blue" style="" type="button">View</a>
					</div>
				</div>
				<?php
			}
		}
		else{
			?>No course to show<?php
		}
	?>
</div>