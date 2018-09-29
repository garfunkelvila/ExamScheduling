<?php 
	include_once "../util_dbHandler.php";
	

	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_student_pre_reg_id`()");
	$stmt->execute();
	$tmpIdResult = $stmt->get_result();
	$tmpIdRow = $tmpIdResult->fetch_row();
	$tmpId = $tmpIdRow[0];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register a student</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<div id="view-1">
			<h5>Register student</h5>
			<form class="w3-card-4 w3-padding w3-container" onsubmit="validateIdNumber(); return changeView('1','2');">
				
				
				<div style="display: table;">
					<div style="display: table-cell;"><input class="my-input-1"  type="text" id="fName" placeholder="First name" required=""></div>
					<div style="display: table-cell;"><input class="my-input-1" type="text" id="mName" placeholder="Middle name" required=""></div>
					<div style="display: table-cell;"><input class="my-input-1" type="text" id="lName" placeholder="Family name" required=""></div>
				</div>
				<input class="my-input-1" type="text" id="strIdNumber" placeholder="ID Number" required="" onblur="validateIdNumber()">
				<em class="w3-tiny" style="display: inline-block;">The default password is abcd1234</em>
				<div class="w3-right">
					<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="validateIdNumber()">Next</button>
				</div>
				
			</form>
		</div>
		<div id="view-2" style="display: none;">
			<h5>Subjects</h5>
			<div class="w3-card-4 w3-padding">
			
				<div style="display: table; width: 100%">
					<div style="display: table-row;">
						<label style="display: table-cell;">Department</label>
						<select class="my-input-1" style="display: table-cell;" name="optDepartment" onchange="updateOptCourse(this.value)">
							<option value="0">Select a department</option>
							<?php include_once "fragment_option_department_names.php" ?>
						</select>
					</div>
					<div style="display: table-row;">
						<label style="display: table-cell;">Course</label>
						<select class="my-input-1" style="display: table-cell;" name="optCourse" id="courseContainer" onchange="updateOptLevels(this.value)">
							<option value="0">Select a department first</option>
						</select>
					</div>
					<div style="display: table-row;">
						<label style="display: table-cell; min-width: 1in; width: 1in;">Year level</label>
						<select class="my-input-1" style="display: table-cell;" id="levelContainer" onchange="updateOptSubjects()">
							<option value="0">Select a course first</option>
						</select>
					</div>
					<br>
					<div style="display: table-row;">
						<label style="display: table-cell;">Subject</label>
						<select class="my-input-1" style="display: table-cell;" id="optSubjectContainer" onchange="updateOptSections()">
							<option value="0">Select a year level first</option>
						</select>
					</div>
					<div style="display: table-row;">
						<label style="display: table-cell;">Section</label>
						<select class="my-input-1" style="display: table-cell;" id="sectContainer">
							<option value="0">Select a subject first</option>
						</select>
					</div>
				</div>
				<button class="my-button my-blue w3-section" onclick="addToSection()">Add to section</button>
			</div>
			<div class="w3-right">
				<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="return changeView('2','1'); fillSubjContainer();">Back</button>
				<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="return registerStudent()">Register</button>
				<!--button onclick="fillSubjContainer();">asdsad</button-->
			</div>
			
			<div style="display: table; width: 100%" id="tblSubjContainer">
				
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		var tmpId = <?php echo $tmpId; ?>;
		window.onbeforeunload = function(){
			return "You haven't finished registering the student. Do you want to leave without finishing?";
		}

		function changeView(id,od){
			document.getElementById("view-" + id).style.display="none";
			document.getElementById("view-" + od).style.display="inline";
			return false;
		}

		/************************/
		function validateIdNumber(){
			var id = $("#strIdNumber").val();
			var idl = id.length;
			var isValid = true;
			for (var i = 0; i < idl; i++) {
				if (isNaN(id[i]) && id[i] != "-"){
					isValid = false;
					break;
				}
			}

			if (isValid == false){
				$("#strIdNumber").get(0).setCustomValidity("Invalid ID number");
			}
			else{
				$("#strIdNumber").get(0).setCustomValidity("");
			}
		}
		

		function updateOptCourse(q){
			$("#courseContainer").html("<option value='0'>Loading...</option>");
			$.ajax({
				url: "ajax_option_course_names_popup_register.php",
				data: { dept: q },
				success: function(response){
					$("#courseContainer").html("");
					$("#courseContainer").html(response);
					updateOptLevels();
				}
			});
			return false;
		}

		function updateOptLevels(){
			var e = $("#courseContainer").val();
			$("#levelContainer").html("<option value='0'>Loading...</option>");
			$.ajax({
				url: "ajax_option_subject_levels_popup_register.php",
				data: {
					course: e
				},
				success: function(response){
					$("#levelContainer").html(""); //limot ko bat to nka dissable -_-
					$("#levelContainer").html(response);
					updateOptSubjects();
				}
				
			});
			return false;
		}

		function updateOptSubjects(){
			$("#optSubjectContainer").html("<option value='0'>Loading...</option>");
			$.ajax({
				url: "ajax_option_subject_names_popup_register.php",
				data: {
					course: $("#courseContainer").val(),
					level:  $("#levelContainer").val(),
					tUserId: tmpId
				},
				success: function(response){
					$("#optSubjectContainer").html("");
					$("#optSubjectContainer").html(response);
					updateOptSections();
				}
			});
			return false;
		}

		function updateOptSections(){
			var e = $("optSubjectContainer").val();
			if (e == "-"){
				$("#sectContainer").html('<option value="-">Select a subject first</option>');
				return;
			}
			$("#sectContainer").html("<option value='0'>Loading...</option>");
			$.ajax({
				url: "ajax_option_subject_level_sections_popup_register.php",
				data: {
					course: $("#courseContainer").val(),
					level:  $("#levelContainer").val(),
					subjId: $("#optSubjectContainer").val()
				},
				success: function(response){
					$("#sectContainer").html("");
					$("#sectContainer").html(response);
					fillSubjContainer();
				}
			});
			return false;
		}

		function fillSubjContainer(){
			$("#tblSubjContainer").html("<option value='0'>Loading...</option>");
			$.ajax({
				url: "fragment_table_pre_reg_subjects.php",
				data: { idNum: tmpId },
				success: function(response){
					$("#tblSubjContainer").html("");
					$("#tblSubjContainer").html(response);
				}
			});
			return false;
		}

		function registerStudent(){
			$.ajax({
				url: "ajax_insert_student.php",
				dataType: "json",
				data: {
					tId: tmpId,
					idNumber: $("#strIdNumber").val(),
					fName: $("#fName").val(),
					mName: $("#mName").val(),
					lName: $("#lName").val()
				},
				success: function(response){
					if(response.sucess){
						window.onbeforeunload = null;
						if (confirm("Student sucesfully registered! want to add more?") == true) {
							location.reload();
						} else {
							window.close();
						} 
					}
					else{
						alert("ID number already exist, and is registered to " + response.result + ".");
					}
				}
			});
			return false;
		}
		function addToSection(){
			if ($("#sectContainer").val() == 0){
				alert("Please select a section.");
				return;
			}
			$.ajax({
				url: "ajax_insert_pre_reg_class.php",
				data: {
					classId: $("#sectContainer").val(),
					tUserId: tmpId
				},
				success: function(response){
					fillSubjContainer();
					updateOptSubjects();
				}
			});
			return false;
		}
		function removeFromSection(e){
			$.ajax({
				url: "ajax_delete_from_class_pre_reg.php",
				data: {
					classId: e
				},
				success: function(response){
					fillSubjContainer();
					updateOptSubjects();
				}
			});
			return false;
		}
	</script>
</body>
</html>