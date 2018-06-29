<!DOCTYPE html>
<?php
	include "util_dbHandler.php";
	if(isset($_SESSION["ID"])){
		if($LoggedInAccesID == "1"){
			header('Location: Admin/');
		}
		elseif ($LoggedInAccesID == "2"){
			header('Location: Professor/');
		}
		elseif ($LoggedInAccesID == "3"){
			header('Location: student/');
		}
		elseif ($LoggedInAccesID == "4"){
			header('Location: guardian/');
		}
		elseif ($LoggedInAccesID == "5"){
			header('Location: department/');
		}
		elseif ($LoggedInAccesID == "6"){
			header('Location: it-department/');
		}
	}
	$stmt = null;
	$stmt = $conn->prepare("CALL `check_login_attemps`(?,?)");
	$stmt->bind_param('ss', $cIP, $_SERVER['HTTP_USER_AGENT']);
	$stmt->execute();
	$lResult = $stmt->get_result();
	$lRow = $lResult->fetch_row();
	$ShowLogin = $lRow[0];

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$vResult = $stmt->get_result();
	$sView = $vResult->fetch_row()[0];

	
?>
<html>
<head>
	<title>UPHS - GMA College Exam Scheduling and Information System</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/w3.css">
	<link rel="stylesheet" href="css/my.css">
	<link rel="stylesheet" href="css/fontawesome-all.css">
	<style>
		body{
			background-image: url('/images/bg1.jpg');
			background-attachment: fixed!important;
			
			background-repeat: no-repeat;
			background-size: cover;
		}
		footer{
			position: absolute;
			bottom: 0;
		}
		@media (max-width:600px){
			body{
				background-image: url('/images/bg2.jpg');
			}
			footer{
				position: relative;
			}
		}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<nav class="w3-bar my-blue w3-card-2" id="myNavbar">
		<a class="w3-bar-item w3-padding">UPHS - GMA College Exam Scheduling and Information System</a>
	</nav>
	<div class="w3-row w3-margin-top">
		<div class="w3-row w3-container">
			<div class="w3-twothird w3-padding">
			</div>
			<div class="w3-third w3-card my-transparent-black-1">
				<div class="w3-center w3-padding-large w3-xlarge w3-wide w3-animate-opacity">
					<img src="images/sys-logo.png" class="" style="max-width: 80%;">
				</div>
				<div class="w3-center">
					<?php
					if($sView == 0){

					}
					else{
						?><button class="w3-button my-blue w3-margin" style="width: 1.5in;" onclick="window.location = '/guest';">View Schedules</button><?php
					}
					?>
					
					<!--button class="w3-button my-blue w3-margin" style="width: 1.5in;">Log-in</button-->
				</div>
				<?php if ($ShowLogin == "True"){ ?>
				<form name="frmLogin" class="w3-padding" onsubmit="return checkId()" method="POST">
					<div id="loginResponseContainer1">
						<!--div class="loader"></div-->
					</div>
					<input name="txbIdNumber" class="w3-input w3-border" required="" type="text" placeholder="ID Number" onkeydown="$('#loginResponseContainer1').html('')" autofocus>
					<!--em class="w3-tiny" style="color: white"><a href="Questionaire.pdf" download>Download questionaire click <b>here</b>.</a></em-->
					<button class="w3-button my-blue w3-right w3-margin" type="submit">Next</button>
				</form>
				<form name="frmEmployeeLogin" class="w3-padding" style="display: none;" onsubmit="return actionLogin()" method="POST">
					<div id="adminLoginResponseContainer2">
						<div class="w3-panel w3-green" id="loginPanel">
						<p>Please enter your password</p>
						</div>
					</div>
					<input name="txbPassword" class="w3-input w3-border" required="" type="password" placeholder="Password" onkeydown=" if(this.value.length > 2) $('#adminLoginResponseContainer2').html('')">
					<div class="w3-right">
						<button class="w3-button my-blue w3-margin" type="button" onclick="actionBack()">Cancel</button>
						<button class="w3-button my-blue w3-margin" type="submit">Log-in</button>
					</div>
				</form>
				<div style="display: none;" id="login-loader" class="w3-padding">
					<div style="margin: auto;" class="loader"></div>
				</div>
				
				<?php
				}
				else{ ?><div class="w3-padding">
					<div class='w3-panel w3-red' id='loginPanel'><p>Too much login attempts, please try again later</p></div>
					</div><?php } ?>
			</div>
		</div>
	</div>
	<br><br><br>
	<footer style="" class="w3-bar my-blue w3-small">
		<a class="w3-bar-item w3-padding">A thesis project by Garfunkel Vila, Mark Lester Caoc, Jhon William Berdul and Van Lieouein Delos Santos</a><a href="changelog.txt" class="w3-bar-item w3-padding">| Changelog</a>
	</footer>
	<?php if ($ShowLogin == "True"){ ?>
	<script type="text/javascript">
		var txbIdNumber = document.frmLogin.txbIdNumber;
		var txbPassword = document.frmEmployeeLogin.txbPassword;
		function actionLogin(){
			//Converted to CHECK-ID
			document.frmLogin.style.display = "none"; //HIDE THE FORM AND SHOW THE SPINNER
			document.getElementById('login-loader').style.display = "block";

			$.ajax({
			url: "ajax_login.php", //RENAMED TO check-id
			dataType: "json",
			data: { userId: txbIdNumber.value },
			success: function(login){
					$("#usersContainer").html("");
					if(login.sucess){
						switch(login.result){
							case 1:
							case 2:
							case 3:
							case 4:
							case 5:
								showEmployeeLogin();
								break;
							default:
								alert("Oops something went wrong. Please contact webmaster");
								break;
						}
					}
					else{
						document.getElementById('login-loader').style.display = "none";
						document.frmLogin.style.display = "block"; //HIDE THE FORM AND SHOW THE SPINNER
						document.frmLogin.txbIdNumber.focus();

						$("#loginResponseContainer1").html(
							"<div class='w3-panel w3-red' id='loginPanel'>" +
							"<p>" + login.result + "</p>" +
							"</div>"
							);
					}
				}
			});


			return false;
		}
		function checkId(){
			document.frmLogin.style.display = "none"; //HIDE THE FORM AND SHOW THE SPINNER
			document.getElementById('login-loader').style.display = "block";

			$.ajax({
			url: "ajax_json_check-id.php", //RENAMED TO check-id
			dataType: "json",
			data: { userId: txbIdNumber.value },
			success: function(login){
					$("#usersContainer").html("");
					if(login.sucess){
						showPasswordForm();
					}
					else{
						document.getElementById('login-loader').style.display = "none";
						document.frmLogin.style.display = "block"; //HIDE THE FORM AND SHOW THE SPINNER
						document.frmLogin.txbIdNumber.focus();

						$("#loginResponseContainer1").html(
							"<div class='w3-panel w3-red' id='loginPanel'>" +
							"<p>" + login.result + "</p>" +
							"</div>"
							);
					}
				}
			});
			return false;
		}

		function showPasswordForm(){
			//window.location = "admin";
			document.getElementById('login-loader').style.display = "none";
			document.frmLogin.style.display = "none";
			document.frmEmployeeLogin.style.display = "block";
			txbPassword.focus();
		}
		function actionBack(){
			//document.getElementById('login-loader').style.display = "none";
			document.frmLogin.style.display = "block";
			document.frmEmployeeLogin.style.display = "none";
			txbIdNumber.value = "";
			txbIdNumber.focus();
		}
		function actionLogin(){
			document.frmEmployeeLogin.style.display = "none"; //HIDE THE FORM AND SHOW THE SPINNER
			document.getElementById('login-loader').style.display = "block";

			$.ajax({
			url: "ajax_json_login.php",
			dataType: "json",
			data: { userId: txbIdNumber.value, userPassword: txbPassword.value},
			success: function(login){
					if(login.sucess){
						location.reload();
					}
					else{
						document.getElementById('login-loader').style.display = "none";
						document.frmEmployeeLogin.style.display = "block"; //HIDE THE FORM AND SHOW THE SPINNER
						txbPassword.focus();

						$("#adminLoginResponseContainer2").html(
							"<div class='w3-panel w3-red' id='loginPanel'>" +
							"<p>" + login.result + "</p>" + 
							"</div>"
							);
						txbPassword.value = "";
					}
				}
			});

			return false;
		}
		txbIdNumber.focus();
	</script>
	<?php } ?>
</body>
</html>