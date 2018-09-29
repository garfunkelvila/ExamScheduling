OBSOLETE??????????
<!DOCTYPE html>
<html>
<head>
	<title>Courses</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h5>Manage Course</h5>
		<form name="frmAddCourse" class="w3-card w3-padding" method="POST" onsubmit="return addCourse()" autocomplete=off>
			<input class="my-input-1" type="text" name="strCourseName" placeholder="Course Name" required="" >
			<input class="my-input-1" type="text" name="strAcronym" placeholder="Acronym" required="">
			<input class="my-input-1" type="text" name="chrCode" style="text-transform: capitalize;" placeholder="Code" required="" maxlength="1">
			<select class="my-input-1" name="optDepartment" onchange="checkOptDept(this)">
				<option value="-">Please select a department</option>
				<?php include_once "fragment_option_department_names.php" ?>
			</select>
			<button class="my-button my-blue w3-section">Add</button>
		</form>
	</div>
	<div class="w3-container">
		<h5>Courses List</h5>
		<div class="w3-container w3-card w3-padding" style="width: 3in;">
			<input class="w3-cell my-input-1" type="search" id="txbSearchDept" placeholder="Filter Courses" onkeyup="courseSearch(this.value)">
		</div>
		<div class="w3-cell-row w3-border-bottom w3-container">
			<div class="my-cell"><b>Name</b></div>
			<div class="my-cell" style="width: 1in;"><b>Acronym</b></div>
			<div class="my-cell" style="width: 1in;"><b>Code</b></div>
			<div class="my-cell" style="white-space: nowrap; width: 1in;"><b>Action</b></div>
		</div>
		<div id="coursesContainer">
		</div>
	</div>
	
	<script type="text/javascript">
		var divcoursesContainer = document.getElementById("coursesContainer");
		//var frmAddDepartment = document.frmAddDepartment;
		//var divSearch = document.getElementById('divSearch');
		var txbSearchDept = document.getElementById('txbSearchDept');

		//var btnShowAddDepartment = document.getElementById('btnShowAddDepartment');
		var btnShowSearch = document.getElementById('btnShowSearch');

		var txbCourseName = document.frmAddCourse.strCourseName;
		var txbAcronym = document.frmAddCourse.strAcronym;
		var txbCode = document.frmAddCourse.chrCode;
		var optDepartment = document.frmAddCourse.optDepartment;

		function btnEditCourse(id){
			document.getElementById("divView" + id).style.display = "none";
			document.getElementById("frmCourse" + id).style.display = "table";
			document.getElementById("txbCourseName" + id).focus();
		}

		function btnCancelEditCourse(id){
			document.getElementById("divView" + id).style.display = "table";
			document.getElementById("frmCourse" + id).style.display = "none";
			document.getElementById("txbCourseName" + id).value = document.getElementById("txbCourseName" + id).defaultValue;
			document.getElementById("txbCourseAccr" + id).value = document.getElementById("txbCourseAccr" + id).defaultValue;
			//document.getElementById("txbCourseCode" + id).value = document.getElementById("txbCourseCode" + id).defaultValue;
		}

		
		//Used for validating the combo box
		function checkOptDept(e){
			if(e !== undefined){
				if (e.value == "-"){
					e.setCustomValidity("Please select a department");
					return false;
				}
				else{
					e.setCustomValidity("");
					return true;
				}
				
				//return e.value == "-" ? false : true;
			}
			return false;
		}
		// SEARCH CODES
		function courseSearch(q){
			$.ajax({
				url: "ajax_table_courses.php",
				dataType: "json",
				data: {
					q: q
					},
					success: function(courses){
						//divcoursesContainer.innerHTML = response;
						$("#coursesContainer").html("");
						if(courses.sucess){
							var currentDept = "";
							$.each(courses.result, function(i, course){
								if (currentDept != course["Department Id"]){
									//If not same dept, show header
									currentDept = course["Department Id"];
									$("#coursesContainer").append(
										"<div class='w3-cell-row'>" + 
											"<div class='my-cell'><b>" + course["Department Name"] + "</b></div>" +
										"</div>" + 
										courseItem(course)
									);
								}
								else{
									//go to course directly
									$("#coursesContainer").append(
										courseItem(course)
									);
								}
							});
						}
						else{
							$("#coursesContainer").html("Nothing to show");
						}
					}
				});
			return false;
		}
		function courseItem(course){
			return "" + 
			"<div id='divView" + course['Course Code'] + "'" + 
				"class='w3-cell-row my-hover-light-grey w3-container'>" +
				"<div class='my-cell' id='lblCourseName" + course['Course Code'] + "'>" + course["Name"] + "</div>" +
				"<div class='my-cell' id='lblCourseAccr" + course['Course Code'] + "'" + "style='width: 1in;'>" + course["Acronym"] + "</div>" +
				"<div class='my-cell' id='lblCourseAccr" + course['Course Code'] + "' style='width: 1in;'>" + course["Course Code"] + "</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button " +
						"class='my-button w3-hover-green'" +
						"type='button'" +
						"onclick='btnEditCourse(&#39;" + course['Course Code'] + "&#39;)'>" + 
							"<i class='far fa-edit' aria-hidden='true'></i></button>" + 
					"<button " +
						"class='my-button w3-hover-red w3-hover-text-white' " +
						"type='button' " +
						"onclick='btnDeleteCourse(&#39;" + course['Course Code'] + "&#39;)'>" +
						"<i class='far fa-trash-alt' aria-hidden='true'></i></button>" +
				"</div>" +
			"</div>" +
			"<form onsubmit='return btnComitEditCourse(&#39" + course['Course Code'] + "&#39)' " +
				"class='w3-cell-row my-pale-green w3-container'" +
				"id='frmCourse" + course['Course Code'] + "'" +
				"style='display: none;'>" +
				"<div class='my-cell'>" + 
					"<input id='txbCourseName" + course['Course Code'] + "'" +
						"class='my-input-2'" +
						"type='text'" +
						"style='width: 100%;'" +
						"value='" + course['Name'] + "'" +
						"required>" +
				"</div>" +
				"<div class='my-cell' style='width: 1in;'>" +
					"<input id='txbCourseAccr" + course['Course Code'] + "'" + 
						"class='my-input-2 w3-cell'" +
						"type='text'" +
						"style='width: 100%;'" + 
						"value='" + course["Acronym"] + "'" +
						"required>" +
				"</div>" + 
				"<div class='my-cell' style='width: 1in;'>" + 
					course['Course Code'] +
				"</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button id='btnOkCourse" + course['Course Code'] + "'" + 
						"class='my-button w3-hover-green' " + 
						"type='submit' " +
						"style=''>" +
						"<i class='fas fa-check' aria-hidden='true'></i></button>" +
					"<button id='btnCancelDept" + course['Course Code'] + "'" +
						"class='my-button w3-hover-red w3-hover-text-white' " +
						"type='button' " +
						"style=''" +
						"onclick='btnCancelEditCourse(&#39;" + course['Course Code'] + "&#39;)'>" +
						"<i class='fas fa-ban' aria-hidden='true'></i></button>" +
				"</div>" +
			"</form>"
		}

		function addCourse(){
			//FORM
			if (checkOptDept(optDepartment) == false) return false;
			$.ajax({
				url: "ajax_insert_course.php",
				dataType: "json",
				data: {
					strCourseName: txbCourseName.value,
					strAcronym: txbAcronym.value,
					chrCode: txbCode.value,
					optDepartment: optDepartment.value
				},
				success: function(response){
					if (response.sucess){
						alert("Course sucesfully added.");
						location.reload(false);
					}
					else{
						alert(response["result"]);
					}
				}
			});
			return false;
		}

		function btnComitEditCourse(id){
			$.ajax({
				url: "ajax_update_course.php",
				dataType: "json",
				data: {
					code: id,
					name: $("#txbCourseName" + id).val(),
					acronym: $("#txbCourseAccr" + id).val()
				},
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

		function btnDeleteCourse(id){
			if (confirm("Are you sure you want to delete " + document.getElementById("txbCourseName" + id).value + "?\nDeleting a course also deletes subjects in it.") == true){
				$.ajax({
				url: "ajax_delete_course.php",
				dataType: "json",
				data: {
					code: id
					},
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

		courseSearch('');
	</script>
</body>
</html>