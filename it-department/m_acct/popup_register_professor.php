<?php 
	include "../../util_dbHandler.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Professor</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../../css/w3.css">
	<link rel="stylesheet" href="../../css/my.css">
	<link rel="stylesheet" href="../../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<h5>Register department faculty</h5>
		<form class="w3-card-4 w3-padding w3-container" onsubmit="validateIdNumber(); return registerProf();">
			<div style="display: table;">
				<div style="display: table-cell;"><input class="my-input-1"  type="text" id="fName" placeholder="First name" required=""></div>
				<div style="display: table-cell;"><input class="my-input-1" type="text" id="mName" placeholder="Middle name" required=""></div>
				<div style="display: table-cell;"><input class="my-input-1" type="text" id="lName" placeholder="Family name" required=""></div>
			</div>
			<input class="my-input-1" type="text" id="strIdNumber" placeholder="ID Number" required="" onblur="validateIdNumber()">
			<em class="w3-tiny" style="display: inline-block;">The default password is abcd1234. Please do take note that deans can also register their own professors.</em>
			<div class="w3-right">
				<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="validateIdNumber()">Register</button>
			</div>
		</form>
	</div>
	<script type="text/javascript">
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
		function registerProf(){
			$.ajax({
				url: "ajax_json_register_prof.php",
				dataType: "json",
				data: {
					idNumber: $("#strIdNumber").val(),
					fName: $("#fName").val(),
					mName: $("#mName").val(),
					lName: $("#lName").val()
				},
				success: function(response){
					//alert(response);
					//location.reload(false);
					if(response.sucess){
						window.onbeforeunload = null;
						if (confirm("Prof sucesfully registered! want to add more?") == true) {
							location.reload();
						} else {
							window.close();
						} 
					}
					else{
						alert(response.result);
					}
				}
			});
			return false;
		}
	</script>
</body>
</html>