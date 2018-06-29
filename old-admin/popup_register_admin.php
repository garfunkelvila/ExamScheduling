<?php 
	include "../util_dbHandler.php";
	$stmt = null;
	#$stmt = $conn->prepare("CALL `insert_student_pre_reg_id`()");
	#$stmt->execute();
	#$tmpIdResult = $stmt->get_result();
	#$tmpIdRow = $tmpIdResult->fetch_row();
	#$tmpId = $tmpIdRow[0];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register an administrator</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
		<div>
			<h5>Register Administrator</h5>
			<form class="w3-card-4 w3-padding w3-container" onsubmit="validateIdNumber(); return registerProfessor();">
				<div style="display: table;">
					<div style="display: table-cell;"><input class="my-input-1"  type="text" id="fName" placeholder="First name" required=""></div>
					<div style="display: table-cell;"><input class="my-input-1" type="text" id="mName" placeholder="Middle name" required=""></div>
					<div style="display: table-cell;"><input class="my-input-1" type="text" id="lName" placeholder="Family name" required=""></div>
				</div>
				<input class="my-input-1" type="text" id="strIdNumber" placeholder="ID Number" required="" onblur="validateIdNumber()">
				<em class="w3-tiny" style="display: inline-block;">The default password is abcd1234</em>
				<div class="w3-right">
					<button class="my-button my-blue w3-section w3-hoverable" type="submit" onclick="validateIdNumber()">Register</button>
				</div>
				
			</form>
		</div>
	</div>
	
	<script type="text/javascript">
		window.onbeforeunload = function(){
			return "You haven't finished registering the professor. Do you want to leave without finishing?";
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

		function registerProfessor(){
			$.ajax({
				url: "ajax_insert_user.php",
				dataType: "json",
				data: {
					idNumber: $("#strIdNumber").val(),
					fName: $("#fName").val(),
					mName: $("#mName").val(),
					lName: $("#lName").val(),
					access: "1"
				},
				success: function(response){
					//alert(response);
					//location.reload(false);
					if(response.sucess){
						window.onbeforeunload = null;
						if (confirm("Professor sucesfully registered! want to add more?") == true) {
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