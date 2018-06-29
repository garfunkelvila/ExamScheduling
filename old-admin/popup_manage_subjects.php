<!DOCTYPE html>
<html>
<head>
	<title>Subjects</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h4>Manage Subjects</h4>
		<form name="frmAddSubject" class="w3-card w3-padding" method="POST" onsubmit="return addSubject()">
			<input class="my-input-1" type="text" name="strSubjectName" placeholder="Subject Name" required="">
			<input class="my-input-1" type="text" name="strSubjectCode" placeholder="Subject Code" required="">
			<select class="my-input-1" name="optLevel" onchange="checkOptLevel(this)">
				<option value="-">Please select a level</option>
				<option value="1">First Year</option>
				<option value="2">Second Year</option>
				<option value="3">Third Year</option>
				<option value="4">Fourth Year</option>
				<option value="5">Fifth Year</option>
			</select>
			<select class="my-input-1" name="optDepartment" onchange="checkOptDept(this)">
				<option value="-">Please select a department</option>
				<?php include "fragment_option_department_names.php" ?>
			</select>
			<select class="my-input-1" name="optCourse" id="courseContainer" onchange="checkOptCourse(this)">
				<option value="-">Please select a department first</option>
			</select>
			<button class="my-button my-blue w3-section">Add</button>
		</form>
	</div>
	<div class="w3-container">
		<h4>Subject List</h4>
		<div class="w3-container w3-card w3-padding" style="width: 3in;">
			<input class="my-input-1" type="search" id="txbSearchDept" placeholder="Filter Subjects" onkeyup="subjSearch(this.value)">
			<select class="my-input-1" name="optDepartment" onchange="filterOptDept(this)">
				<option value="-">All departments</option>
				<?php include "fragment_option_department_names.php" ?>
			</select>
			<!--div class="w3-cell-row w3-border-bottom w3-container">
				<div class="w3-cell"><b>Name</b></div>
				<div class="w3-cell" style="width: 1in;"><b>Acronym</b></div>
				<div class="w3-cell" style="white-space: nowrap; width: 1in;"><b>Action</b></div>
			</div-->
		</div>
		<div id="departmentsContainer">
		</div>
	</div>
	<script src="/scripts/ordinal.js"></script>
	<script type="text/javascript">
		var divDepartmentsContainer = document.getElementById("departmentsContainer");
		var frmAddDepartment = document.frmAddDepartment;
		//var divSearch = document.getElementById('divSearch');
		var txbSearchDept = document.getElementById('txbSearchDept');

		var btnShowAddDepartment = document.getElementById('btnShowAddDepartment');
		var btnShowSearch = document.getElementById('btnShowSearch');

		//Used for validating the combo box
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

		function checkOptDept(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a department");
					updateOptCourse(e.value);
					return false;
				}
				else{
					e.setCustomValidity("");
					updateOptCourse(e.value);
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
		//--------------------------------------------------
		function updateOptCourse(q){
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
						$("#courseContainer").html("<option value='-'>Please select a department first</option>");
					}
				}
			});
			return false;
		}
		//--------------------------------------------------

		function btnEditSubj(id){
			document.getElementById("divView" + id).style.display = "none";
			document.getElementById("frmSubj" + id).style.display = "table";
			document.getElementById("txbSubjName" + id).focus();
		}

		function btnCancelEditSubj(id){
			document.getElementById("divView" + id).style.display = "table";
			document.getElementById("frmSubj" + id).style.display = "none";
			document.getElementById("txbSubjName" + id).value = document.getElementById("txbSubjName" + id).defaultValue;
			document.getElementById("txbSubjAccr" + id).value = document.getElementById("txbSubjAccr" + id).defaultValue;
		}

		function subjSearch(q){
			var deptId = ""; //***********************************TEMPORARY
			$.ajax({
				url: "ajax_table_subjects.php",
				dataType: "json",
				data: { q: q , deptId: deptId},
				success: function(response){
					$("#departmentsContainer").html("");
					if(response.sucess){
						var currentDept = "";
						var currentCour = "";
						var currentLevel = 0;
						$.each(response.result, function(i, subj){
							if (currentDept != subj['departmentName']){
								currentDept = subj['departmentName'];
								//Show department header
								$("#departmentsContainer").append("<h5 class='' style='display: block;'>" + subj['departmentName'] + "</h5>");
							}
							if (currentCour != subj['courseName']){
								currentCour = subj['courseName'];
								currentLevel = 0;
								$("#departmentsContainer").append("<div class='w3-container' style='display: block;'><h5 class='w3-border-bottom' style='display: block;'>" + subj['courseName'] + "</h5></div>");
							}
							if (currentLevel != subj['subjectYear']){
								currentLevel = subj['subjectYear'];
								$("#departmentsContainer").append("<b class='w3-container' style='display: block;'>" + getOrdinal(subj['subjectYear']) + " Year</b>");
							}
							$("#departmentsContainer").append(subjItem(subj));
						});
					}
					else{
						$("#departmentsContainer").html("Nothing to show");
					}
				}
			});
			return false;
		}

		function subjItem(item){
			//not yet edited
			return "" + 
			"<div id='divView" + item['Id'] +"'" +
				"class='w3-cell-row my-hover-light-grey w3-container'>" +
				"<div class='my-cell' id='lblSubjName" + item['Id'] + "'>" + item['subjectName'] + "</div>" +
				"<div class='my-cell' id='lblSubjAccr" + item['Id'] + "' style='width: 1in;'>" + item['subjectCode'] + "</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button " +
						"class='my-button w3-hover-green'" +
						"type='button'" +
						"onclick='btnEditSubj(&#39;" + item['Id'] + "&#39;)'>" +
							"<i class='far fa-edit' aria-hidden='true'></i></button>" +
					"<button " +
						"class='my-button w3-hover-red w3-hover-text-white'" +
						"type='button'" +
						"onclick='btnDeleteSubj(&#39;" + item['Id'] + "&#39;)'>" +
							"<i class='far fa-trash-alt' aria-hidden='true'></i></button>" +
				"</div>" + 
			"</div>" +
			"<form onsubmit='return btnComitEditSubj(&#39;" + item['Id'] + "&#39;)'" + 
				"class='w3-cell-row my-pale-green w3-container'" + 
				"id='frmSubj" + item['Id'] + "'" + 
				"style='display: none;'>" + 
				"<div class='my-cell'>" +
					"<input id='txbSubjName" + item['Id'] + "'"+
						"class='my-input-2'" +
						"type='text'" + 
						"style='width: 100%;'" +
						"value='" + item['subjectName'] + "'" +
						"required>" +
				"</div>" +
				"<div class='my-cell' style='width: 1in;'>" +
					"<input id='txbSubjAccr" + item['Id'] + "'" +
						"class='my-input-2 w3-cell'" + 
						"type='text'" +
						"style='width: 100%;'" +
						"value='" + item['subjectCode'] + "'" +
						"required>" + 
				"</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button id='btnOkSubj" + item['Id'] + "'" +
						"class='my-button w3-hover-green'" +
						"type='submit'" +
						"style=''>" +
						"<i class='fas fa-check' aria-hidden='true'></i></button>" +
					"<button id='btnCancelSubj" + item['Id'] + "'" +
						"class='my-button w3-hover-red w3-hover-text-white'" +
						"type='button'" +
						"style=''" +
						"onclick='btnCancelEditSubj(&#39;" + item["Id"] + "&#39;)'>" +
						"<i class='fas fa-ban' aria-hidden='true'></i></button>" +
				"</div>" +
			"</form>"
		}

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
						location.reload(false);
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}

		function btnComitEditSubj(id){
			var subjNameValue = document.getElementById("txbSubjName" + id);
			var subjAccrValue = document.getElementById("txbSubjAccr" + id);

			$.ajax({
				url: "ajax_update_subject.php",
				dataType: "json",
				data: { q: id , subjName: subjNameValue.value , subjCode : subjAccrValue.value},
				success: function(response){
					if (response.sucess){
						alert(response["result"]);
						location.reload(false);
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}

		function btnDeleteSubj(id){
			if (confirm("Are you sure you want to delete " + document.getElementById("txbSubjName" + id).value + "?\nDeleting a subject also deletes classes in it.") == true){
				$.ajax({
				url: "ajax_delete_subject.php",
				dataType: "json",
				data: { q: id },
				success: function(response){
					if (response.sucess){
						alert(response["result"]);
						location.reload(false);
					}
					else{
						alert(response["result"]);
					}
				}
				});
			}
			return false;
		}

		subjSearch('');
	</script>
</body>
</html>