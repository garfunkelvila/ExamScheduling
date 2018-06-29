<!DOCTYPE html>
<html>
<head>
	<title>Departments</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h5>Manage Department</h5>
		<form name="frmAddDepartment" class="w3-card w3-padding" method="POST" onsubmit="return addDepartment()">
			<input class="my-input-1" type="text" name="strDepartmentName" placeholder="Department Name" required="">
			<input class="my-input-1" type="text" name="strAcronym" placeholder="Acronym" required="">
			<button class="my-button my-blue w3-section">Add</button>
		</form>
	</div>
	<div class="w3-container">
		<h5>Department List</h5>
		<div class="w3-container w3-card w3-padding" style="width: 3in;">
			<input class="w3-cell my-input-1" type="search" id="txbSearchDept" placeholder="Filter Departments" onkeyup="deptSearch(this.value)">
		</div>
		<div class="w3-cell-row w3-border-bottom w3-container">
				<div class="w3-cell"><b>Name</b></div>
				<div class="w3-cell" style="width: 1in;"><b>Acronym</b></div>
				<div class="w3-cell" style="white-space: nowrap; width: 1in;"><b>Action</b></div>
			</div>
		<div id="departmentsContainer">
		</div>
	</div>

	<script type="text/javascript">
		var divDepartmentsContainer = document.getElementById("departmentsContainer");
		var frmAddDepartment = document.frmAddDepartment;
		//var divSearch = document.getElementById('divSearch');
		var txbSearchDept = document.getElementById('txbSearchDept');

		var btnShowAddDepartment = document.getElementById('btnShowAddDepartment');
		var btnShowSearch = document.getElementById('btnShowSearch');

		

		function btnEditDept(id){
			document.getElementById("divView" + id).style.display = "none";
			document.getElementById("frmDept" + id).style.display = "table";
			document.getElementById("txbDeptName" + id).focus();
		}

		function btnCancelEditDept(id){
			document.getElementById("divView" + id).style.display = "table";
			document.getElementById("frmDept" + id).style.display = "none";
			document.getElementById("txbDeptName" + id).value = document.getElementById("txbDeptName" + id).defaultValue;
			document.getElementById("txbDeptAccr" + id).value = document.getElementById("txbDeptAccr" + id).defaultValue;
		}

		function deptSearch(q){
			$.ajax({
				url: "ajax_table_departments.php",
				dataType: "json",
				data: { q: q },
				success: function(response){
					$("#departmentsContainer").html("");
					if(response.sucess){
						$.each(response.result, function(i, dept){
							$("#departmentsContainer").append(deptItem(dept));
						});
					}
					else{
						$("#departmentsContainer").html("Nothing to show");
					}
				}
			});
			return false;
		}
		function deptItem(item){
			return "" + 
			"<div id='divView" + item['Id'] +"'" +
				"class='w3-cell-row my-hover-light-grey w3-container'>" +
				"<div class='my-cell' id='lblDeptName" + item['Id'] + "'>" + item['Name'] + "</div>" +
				"<div class='my-cell' id='lblDeptAccr" + item['Id'] + "' style='width: 1in;'>" + item['Acronym'] + "</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button " +
						"class='my-button w3-hover-green'" +
						"type='button'" +
						"onclick='btnEditDept(&#39;" + item['Id'] + "&#39;)'>" +
							"<i class='far fa-edit' aria-hidden='true'></i></button>" +
					"<button " +
						"class='my-button w3-hover-red w3-hover-text-white'" +
						"type='button'" +
						"onclick='btnDeleteDept(&#39;" + item['Id'] + "&#39;)'>" +
							"<i class='far fa-trash-alt' aria-hidden='true'></i></button>" +
				"</div>" + 
			"</div>" +
			"<form onsubmit='return btnComitEditDept(&#39;" + item['Id'] + "&#39;)'" + 
				"class='w3-cell-row my-pale-green w3-container'" + 
				"id='frmDept" + item['Id'] + "'" + 
				"style='display: none;'>" + 
				"<div class='my-cell'>" +
					"<input id='txbDeptName" + item['Id'] + "'"+
						"class='my-input-2'" +
						"type='text'" + 
						"style='width: 100%;'" +
						"value='" + item['Name'] + "'" +
						"required>" +
				"</div>" +
				"<div class='my-cell' style='width: 1in;'>" +
					"<input id='txbDeptAccr" + item['Id'] + "'" +
						"class='my-input-2 w3-cell'" + 
						"type='text'" +
						"style='width: 100%;'" +
						"value='" + item['Acronym'] + "'" +
						"required>" + 
				"</div>" +
				"<div class='my-cell' style='white-space: nowrap; width: 1in;'>" +
					"<button id='btnOkDept" + item['Id'] + "'" +
						"class='my-button w3-hover-green'" +
						"type='submit'" +
						"style=''>" +
						"<i class='fas fa-check' aria-hidden='true'></i></button>" +
					"<button id='btnCancelDept" + item['Id'] + "'" +
						"class='my-button w3-hover-red w3-hover-text-white'" +
						"type='button'" +
						"style=''" +
						"onclick='btnCancelEditDept(&#39;" + item["Id"] + "&#39;)'>" +
						"<i class='fas fa-ban' aria-hidden='true'></i></button>" +
				"</div>" +
			"</form>"
		}

		function addDepartment(){
			//FORM
			var txbDeptName = document.frmAddDepartment.strDepartmentName;
			var txbDeptAccr = document.frmAddDepartment.strAcronym;
			$.ajax({
				url: "ajax_insert_department.php",
				dataType: "json",
				data: { deptName: txbDeptName.value , deptAccr : txbDeptAccr.value},
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

		function btnComitEditDept(id){
			var txbDeptName = document.getElementById("txbDeptName" + id);
			var txbDeptAccr = document.getElementById("txbDeptAccr" + id);

			$.ajax({
				url: "ajax_update_department.php",
				dataType: "json",
				data: { id: id ,deptName: txbDeptName.value , deptAccr : txbDeptAccr.value},
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

		function btnDeleteDept(id){
			if (confirm("Are you sure you want to delete " + document.getElementById("txbDeptName" + id).value + "?\nDeleting a department also deletes courses and subjects in it.") == true){
				$.ajax({
				url: "ajax_delete_department.php",
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

		deptSearch('');
	</script>
</body>
</html>