<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
	#THIS THING IS TO BE OBSOLETE
?>
<html>
<head>
	<title>Manage class list</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		/*Mozila recolors the invalid entry upon clearing via javascript. So it is needed*/
		@-moz-document url-prefix(){
			input:required {
				box-shadow:none!important;
			}
			input:invalid {
				box-shadow:0 0 3px red;
			}
		}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<button class="w3-button my-blue" style="width: 100%" type="button" onclick="manageTable('popup_manage_department.php','ManageDepartment')">Manage Departments</button>
			<button class="w3-button my-blue" style="width: 100%" type="button" onclick="manageTable('popup_manage_courses.php','ManageCourse')">Manage Courses</button>
			<!--button class="w3-button my-blue" style="width: 100%" type="button" onclick="manageTable('popup_manage_subjects.php','ManageSubject')">Manage Subjects</button-->
			<br><br>
			<form name="frmAddSubject" class="w3-card w3-padding" method="POST" onsubmit="return addSubject()">
				<h5>Add a subject</h5>
				<input class="my-input-1" type="text" name="strSubjectName" placeholder="Subject Name" required="">
				<input class="my-input-1" type="text" name="strSubjectCode" placeholder="Subject Code" required="">
				<select class="my-input-1" name="optLevel" onchange="checkOptLevel(this)">
					<option value="-">Select a level</option>
					<option value="1">First Year</option>
					<option value="2">Second Year</option>
					<option value="3">Third Year</option>
					<option value="4">Fourth Year</option>
					<option value="5">Fifth Year</option>
				</select>
				<select class="my-input-1" name="optDepartment" onchange="checkOptDept(this); updateOptCourse(this.value);">
					<option value="-">Select a department</option>
					<?php include "fragment_option_department_names.php" ?>
				</select>
				<select class="my-input-1" name="optCourse" id="courseContainer" onchange="checkOptCourse(this)">
					<option value="-">Select a department first</option>
				</select>
				<button class="my-button my-blue w3-section">Add</button>
			</form>
		</div>
		<div class="w3-rest w3-container">
			<div class="w3-row">
			</div>
			<div>
				<?php include "fragment_table_classes.php" ?>
			</div>
		</div>
	</div>
	<?php #include "fragment_footer.php" ?>
	<script type="text/javascript">
		//-- FORM CODES ----------------------------------------
		function checkOptLevel(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a level");
					return false;
				}
				else{
					e.setCustomValidity("");
					return true;
				}
			}
			return false;
		}

		function checkOptExLength(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a length");
					return false;
				}
				else{
					e.setCustomValidity("");
					return true;
				}
			}
			return false;
		}

		function checkOptDept(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a department");
					//updateOptCourse(e.value);
					return false;
				}
				else{
					e.setCustomValidity("");
					//updateOptCourse(e.value);
					return true;
				}
			}
			return false;
		}

		function checkOptCourse(e){

			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a course");
					return false;
				}
				else{
					e.setCustomValidity("");
					return true;
				}
			}
			return false;
		}

		function updateOptCourse(q){
			if (q == "-"){
				$("#courseContainer").html("<option value='-'>Plese select a department first</option>");
				return;
			}
			$("#courseContainer").html("<option value='-'>Loading...</option>");
			$.ajax({
				url: "ajax_option_course_names.php",
				dataType: "json",
				data: { dept: q },
				success: function(response){
					$("#courseContainer").html("");
					if(response.sucess){
						$("#courseContainer").append("<option value='-'>Please select a course</option>");
						$.each(response.result, function(i, course){
							$("#courseContainer").append("<option value='" + course['Course Code'] + "'>" + course['Name'] + "</option>");
						});
					}
					else{
						$("#courseContainer").html("<option value='-'>No course available</option>");
					}
				}
			});
			return false;
		}
		//-------------------------------------------------------

		function addSubject(){
			//FORM
			if (checkOptLevel(document.frmAddSubject.optLevel) == false) return false;
			if (checkOptDept(document.frmAddSubject.optDepartment) == false) return false;
			if (checkOptCourse(document.frmAddSubject.optCourse) == false) return false;
			


			var subjNameValue = document.frmAddSubject.strSubjectName.value;
			var subjCodeValue = document.frmAddSubject.strSubjectCode.value;
			var subjLevelValue = document.frmAddSubject.optLevel.value;
			var subjDeptValue = document.frmAddSubject.optDepartment.value;
			var subjCourValue = document.frmAddSubject.optCourse.value;

			$.ajax({
				url: "ajax_insert_subject.php",
				dataType: "json",
				data: {
					name: subjNameValue,
					code: subjCodeValue,
					level: subjLevelValue,
					courseId: subjCourValue
				},
				success: function(response){
					if(response.sucess){
						alert(response["result"]);
						fillMainTable($("#optCourse").val());
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}

		//-------------------------------------------------------------
		function manageTable(dir, name){
			//second parameter helps prevents duplication of window
			openwindow = window.open(dir, name, "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
			openwindow.focus();
		}

		function btnViewClass(classId){
			openwindow = window.open("popup_manage_class.php?classId=" + classId, "Class", "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
			openwindow.focus();
		}
	</script>
</body>
</html>