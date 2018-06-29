<!DOCTYPE html>
<html>
<head>
	<title>Mergable subjects</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h5>Manage mergable subjects</h5>
		<div id="view-1">
			<input type="button" class="w3-button my-blue" value="New group" onclick="changeView(1,2);">
			<br><br>
			<div style="display: table; width: 100%">
				<div style="display: table-header-group;">
					<div style="display: table-cell;" class="w3-border-bottom w3-border-blue"><b>Filipino Christian Living</b>
						<button title="Edit day" class="my-button w3-hover-green" id="btnEditGroup" onclick="changeView(1,3)" type="button">
							<i class="far fa-edit" aria-hidden="true"></i></button>
					</div>
					<div style="display: table-cell; white-space: nowrap; width: 0.5in;" class="w3-border-bottom w3-border-blue"><b>-</b></div>
				</div>
				<div style="display: table-row;">
					<div style="display: table-cell;"><input type="text" class="my-input-1" placeholder="Subject name or code"></div>
					<div style="display: table-cell;"></div>
				</div>
				<div style="display: table-row;">
					<div style="display: table-cell;">FCL</div>
					<div style="display: table-cell;">-</div>
				</div>
				<br>
				<div style="display: table-header-group;">
					<div style="display: table-cell;" class="w3-border-bottom w3-border-blue"><b>FCL</b> <i class="far fa-edit" aria-hidden="true"></i></div>
					<div style="display: table-cell; white-space: nowrap; width: 0.5in;" class="w3-border-bottom w3-border-blue"><b>-</b></div>
				</div>
				<div style="display: table-row;">
					<div style="display: table-cell;"><input type="text" class="my-input-1" placeholder="Subject name or code"></div>
					<div style="display: table-cell;"></div>
				</div>
				<div style="display: table-row;">
					<div style="display: table-cell;">FCL</div>
					<div style="display: table-cell;">-</div>
				</div>
				
			</div>		
		</div>
		<!-- ####################################### -->
		<div id="view-2" style="">
			<div>
				<b>Add subject: </b>
				<input type="text" class="my-input-1" placeholder="Subject name or code">
				<div class="w3-card-2" id="sudgestions" style="display: table; background-color: white; position: absolute;">
					<!--a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a-->
				</div>
			</div>
			<!-- ########################### -->
			<em class="w3-tiny">Click on the sudgestions to add them.</em>
			<br><br>
			<div style="display: table; width: 100%">
				<div style="display: table-header-group;">
					<div style="display: table-cell;" class="w3-border-bottom"><b>Subject Name</b></div>
					<div style="display: table-cell; white-space: nowrap; width: 0.5in;" class="w3-border-bottom"><b>-</b></div>
				</div>
				<div style="display: table-header-group;">
					<div style="display: table-cell;">FCL</div>
					<div style="display: table-cell;">-</div>
				</div>
			</div>
			<em class="w3-tiny">This table shows the subject that can be merged.</em>
			<br><br>
			<div class="w3-right">
				<input type="button" class="w3-button my-blue" value="Cancel" onclick="changeView(2,1);">
				<input type="button" class="w3-button my-blue" value="Add Group" onclick="changeView(2,1);">
			</div>
		</div>
		<div id="view-3" style="display: none;">
			<div>
				<b>Add subject: </b>
				<input type="text" class="my-input-1" placeholder="Subject name or code">
				<div class="w3-card-2" id="sudgestions" style="display: table; background-color: white; position: absolute;">
					<!--a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a>
					<a class="w3-button" style="text-align: left; display:table-row;" onclick="addStudent('adasd')">
						<div class="w3-container" style="display: table-cell;">adasd</div>
						<div class="w3-container" style="display: table-cell;">Kevin Mocorro</div>
					</a-->
				</div>
			</div>
			<!-- ########################### -->
			<em class="w3-tiny">Click on the sudgestions to add them.</em>
			<br><br>
			<div style="display: table; width: 100%">
				<div style="display: table-header-group;">
					<div style="display: table-cell;" class="w3-border-bottom"><b>Subject Name</b></div>
					<div style="display: table-cell; white-space: nowrap; width: 0.5in;" class="w3-border-bottom"><b>-</b></div>
				</div>
				<div style="display: table-header-group;">
					<div style="display: table-cell;">FCL</div>
					<div style="display: table-cell;">-</div>
				</div>
			</div>
			<em class="w3-tiny">This table shows the subject that can be merged.</em>
			<br><br>
			<div class="w3-right">
				<input type="button" class="w3-button my-blue" value="Cancel" onclick="changeView(3,1);">
				<input type="button" class="w3-button my-blue" value="Add Group" onclick="changeView(3,1);">
			</div>
		</div>
	</div>
	<script type="text/javascript">
		changeView(2,1)
		function changeView(id,od){
			document.getElementById("view-" + id).style.display="none";
			document.getElementById("view-" + od).style.display="inline";
			return false;
		}

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
					success: function(response){
						
					}
				});
			return false;
		}
	</script>
</body>
</html>