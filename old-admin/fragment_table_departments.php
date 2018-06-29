<!-- UNUSED -->
<h5>Departments
	<button id="btnShowAddDepartment"
		class="my-button w3-hover-green w3-hover-text-white"
		type="button"
		style=""
		onclick="showAddDept()">
		<i class="fas fa-plus" aria-hidden="true"></i></button>
	<button id="btnShowSearch"
		class="my-button w3-hover-green w3-hover-text-white"
		type="button"
		style=""
		onclick="showSearchDept()">
		<i class="fas fa-filter" aria-hidden="true"></i></button>
</h5>
<form name="frmAddDepartment" class="w3-card w3-padding" method="POST" onsubmit="return addDepartment()" style="display: none;">
	<input class="my-input-1" type="text" name="strDepartmentName" placeholder="Department Name" required="">
	<input class="my-input-1" type="text" name="strAcronym" placeholder="Acronym" required="">
	<button class="my-button my-blue w3-section">Add</button>
</form>
<input class="w3-cell my-input-1" type="search" id="txbSearchDept" placeholder="Filter Department" onkeyup="deptSearch(this.value)" style="display: none; width: 100%;">
<div id="departmentsContainer">
</div>

<script type="text/javascript">
	var divDepartmentsContainer = document.getElementById("departmentsContainer");
	var frmAddDepartment = document.frmAddDepartment;
	//var divSearch = document.getElementById('divSearch');
	var txbSearchDept = document.getElementById('txbSearchDept');

	var btnShowAddDepartment = document.getElementById('btnShowAddDepartment');
	var btnShowSearch = document.getElementById('btnShowSearch');

	function showAddDept(){
		txbSearchDept.style.display='none';
		txbSearchDept.value = "";

		if(frmAddDepartment.style.display == 'none'){
			frmAddDepartment.style.display='block';
		}
		else{
			frmAddDepartment.style.display='none';
		}
	}

	function showSearchDept(){
		frmAddDepartment.style.display='none';
		if(txbSearchDept.style.display == 'none'){
			txbSearchDept.style.display='block';
		}
		else{
			txbSearchDept.style.display='none';
			txbSearchDept.value = "";
		}
	}

	function deptSearch(q){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			divDepartmentsContainer.innerHTML = this.responseText;
		};
		xhttp.open("POST", "ajax_table_departments.php?q=" + q);
		xhttp.send();
		return false;
	}


	function btnDeleteDept(id){
		if (confirm("Are you sure you want to delete " + document.getElementById("lblDeptItem" + id).innerHTML + "?\nDeleting a department also deletes subjects assigned to it.") == true){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200) {
					deptSearch('');
					alert(this.responseText);
				}
			};
			xhttp.open("POST", "ajax_delete_department.php?q=" + id);
			xhttp.send();
		}
		return false;
	}

	function btnEditDept(id){
		document.getElementById("lblDeptAccr" + id).style.display = "none";
		document.getElementById("lblDeptName" + id).style.display = "none";
		document.getElementById("txbDeptItem" + id).style.display = "initial";
		document.getElementById("txbDeptAccr" + id).style.display = "initial";
		document.getElementById("btnEditDept" + id).style.display = "none";
		document.getElementById("btnDeleteDept" + id).style.display = "none";
		document.getElementById("btnOkDept" + id).style.display = "initial";
		document.getElementById("btnCancelDept" + id).style.display = "initial";
	}

	function btnCancelEditDept(id){
		document.getElementById("lblDeptAccr" + id).style.display = "initial";
		document.getElementById("lblDeptName" + id).style.display = "initial";
		document.getElementById("txbDeptItem" + id).style.display = "none";
		document.getElementById("txbDeptAccr" + id).style.display = "none";
		document.getElementById("btnEditDept" + id).style.display = "initial";
		document.getElementById("btnDeleteDept" + id).style.display = "initial";
		document.getElementById("btnOkDept" + id).style.display = "none";
		document.getElementById("btnCancelDept" + id).style.display = "none";
	}

	function btnComitEditDept(id){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				deptSearch('');
				alert(this.responseText);
			}
		};
		xhttp.open("POST", "ajax_update_department.php?id=" + id + "&deptName=" + document.getElementById("txbDeptItem" + id).value + "&deptAccr=" + document.getElementById("txbDeptAccr" + id).value);
		xhttp.send();
		return false;
	}

	deptSearch('');
</script>