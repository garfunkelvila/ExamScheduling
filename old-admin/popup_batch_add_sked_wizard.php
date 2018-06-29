<?php 
	include "../util_dbHandler.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Batch add wizard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<link rel="stylesheet" href="/jquery-ui-1.12.1.custom/jquery-ui.min.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script>
		$( function() {
			$( "#datepicker" ).datepicker();
		} );
	</script>


	<div class="w3-container" style="max-width: 5in;">
		<div id="view-1" style="display: table;">
			<h5>Date</h5>
			<div class="w3-card-4 w3-padding" style="width: 4in">
				<fieldset>
					<legend>Date type</legend>
					<input type="radio" name="dateType" id="new"><label for="new"> New date</label><br>
					<input type="radio" name="dateType" id="existing"><label for="existing"> Existing date</label><br>
				</fieldset><br>
				<fieldset>
					<legend>Enter the date</legend>
					<input type="text" class="my-input-2" name="" placeholder="mm/dd/yyyy" id="datepicker"><br>
				</fieldset>
				<fieldset>
					<legend>Select the date</legend>
					<select class="my-input-2" style="width: 2in;">
						<option>Jan 1, 2018</option>
						<option>Jan 1, 2018</option>
						<option>Jan 1, 2018</option>
						<option>Jan 1, 2018</option>
					</select>
				</fieldset>
				<br>
			</div>
			<div class="w3-right w3-margin">
				<button class="w3-button my-blue" type="submit" onclick="">Next</button>
			</div>
		</div>
		<div id="view-1" style="display: table;">
			<h5>Rooms</h5>
			<div class="w3-card-4 w3-padding" style="width: 4in">
				<fieldset>
					<legend>Add rooms</legend>
					<input type="radio" name="roomAddType" id="importRooms"><label for="importRooms"> Import from master list</label><br>
					<input type="radio" name="roomAddType" id="manualRooms"><label for="manualRooms"> Add manually</label><br>
				</fieldset><br>
				<fieldset>
					<legend>Enter room</legend>
					<input type="text" class="my-input-2" name="" placeholder="Room" id="room">
					<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">Add</button>
				</fieldset>
				<br>
			</div>
			<div class="w3-right w3-margin">
				<button class="w3-button my-blue" type="submit" onclick="">Back</button>
				<button class="w3-button my-blue" type="submit" onclick="">Next</button>
			</div>
		</div>
		<div id="view-1" style="display: table;">
			<h5>Subjects</h5>
			<div class="w3-card-4 w3-padding" style="width: 4in">
				<fieldset>
					<legend>Add type</legend>
					<input type="radio" name="subjAddType" id="byDaySubject"><label for="importRooms"> Add by sudgested day</label><br>
					<input type="radio" name="subjAddType" id="manualSubject"><label for="manualRooms"> Add manually</label><br>
				</fieldset><br>
				<fieldset>
					<legend>Enter room</legend>
					<input type="text" class="my-input-2" name="" placeholder="mm/dd/yyyy" id="room">
					<button title="Add class" class="my-button w3-hover-green w3-hover-text-white">Add</button>
				</fieldset>
				<br>
			</div>
			<div class="w3-right w3-margin">
				<button class="w3-button my-blue" type="submit" onclick="">Back</button>
				<button class="w3-button my-blue" type="submit" onclick="">Next</button>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
		/*window.onbeforeunload = function(){
			return "You haven't finished registering the student. Do you want to leave without finishing?";
		}*/

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