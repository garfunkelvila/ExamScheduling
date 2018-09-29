<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
?>

<html>
<head>
	<title>Guardian</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<?php include_once "fragment_header.php" ?>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<img class="w3-hide-small" src="/images/sys-logo.png" style="width: 100%">
		</div>
		<div class="w3-rest w3-container">
			<div class="w3-half">
				<h3>Change Password</h3>
				<form method="POST" onsubmit="return changePass()">
					<input class="w3-input" type="password" id="old" placeholder="Old Password" onblur="checkPass(this)" required="">
					<input class="w3-input" type="password" id="new" placeholder="New Password" required="">
					<input class="w3-input" type="password" id="new2" placeholder="Re-type Password" onkeyup="checkPassMatch()">
					<br>
					<button class="w3-button my-blue">Submit</button>
				</form>
			</div>
			<div class="w3-half">

			</div>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
	function checkPass(pass){
		var uID = "<?php echo $_SESSION['ID'] ?>";

		//alert(pass.value);
		$.ajax({
			url: "/ajax_json_login.php",
			dataType: "json",
			data: {userId:uID , userPassword: pass.value},
			success: function(login){
				if(login.sucess){
					pass.setCustomValidity("");
				}
				else{
					pass.setCustomValidity(login.result);
				}
			}
		});

		return false;
	}

	function checkPassMatch(){
		if ($("#new").val() == $("#new2").val()){
			document.getElementById('new2').setCustomValidity("");
			return true;
		}
		else{
			document.getElementById('new2').setCustomValidity("Password not matched");
			return false;
		}
		return false;
	}

	function changePass(){
		checkPass(document.getElementById('old'));
		checkPassMatch();
		
		$.ajax({
			url: "ajax_json_update_password.php",
			dataType: "json",
			data: {userPassword: $("#new2").val()},
			success: function(response){
				if(response.sucess){
					alert('Password sucesfully changed');
					window.location = "../";
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