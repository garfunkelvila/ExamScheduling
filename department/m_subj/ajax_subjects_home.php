<div class="w3-center">
	<div class="w3-card-4 w3-margin test" style="width:3in; height: 2in; display: inline-block; overflow: auto;">
		<header class="w3-container my-blue">
		<h5>Add a course</h5>
		</header>

		<form class="w3-container w3-padding" onsubmit="return addCourse()" autocomplete=off>
			<input class="my-input-1" type="text" id="strCourseName" placeholder="Course Name" required="" >
			<input class="my-input-1" type="text" id="strAcronym" placeholder="Acronym" required="">
			<input class="my-input-1" type="text" id="chrCode" style="text-transform: capitalize;" placeholder="Code" required="" maxlength="1">
			<div class="w3-center w3-padding">
				<button class="w3-button my-blue" type="submit">Add</button><br>
			</div>
		</form>
		
	</div><?php
		include "../../util_dbHandler.php";
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_courses_with_total`(?);");#This query requires dept user ID, unless will return null
		$stmt->bind_param("s",$_SESSION["ID"]);
		$stmt->execute();
		$tResult = $stmt->get_result();
		if ($tResult->num_rows > 0) {
			while ($tRow = $tResult->fetch_assoc()) {
				?><div class="w3-card-4 w3-margin test" style="width:3in; height: 2in; display: inline-block; overflow: auto;">
					<header class="w3-container my-blue">
					<h5><?php echo $tRow["Acronym"]; ?></h5>
					</header>

					<div class="w3-container">
						<p><b><?php echo $tRow["Name"]; ?></b><p>
						<p>Total subjects: <b><?php echo $tRow["TotalSubjects"]; ?></b>
					</div>
					<div class="w3-center w3-padding">
						<a href="manage_subjects.php?view=<?php echo $tRow["CourseCode"]; ?>" class="w3-button my-blue" type="button">View</a>
					</div>
				</div><?php
			}
		}
		else{
			
		}
	?>
</div>