<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`Dean_Id`) FROM `departments` WHERE `Dean_Id` = ?");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isDeptExist = $sRow[0];

	if ($isDeptExist){
		header('Location: /');
	}
?>

<html>
<head>
	<title>Initialization</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		body{
			background-image: url('/images/bg3.jpg');
			background-attachment: fixed!important;
			
			background-repeat: no-repeat;
			background-size: cover;
			min-height: 7in;
		}
	</style>
</head>
<body>
	<!-- Navbar (sit on top) -->
	<div class="">
		<div class="w3-bar my-blue w3-card-2" id="myNavbar">
			<a href="javascript:void(0)" class="w3-bar-item w3-padding w3-left w3-hide-large w3-hide-medium w3-button" onclick="w3_open()">
				<i class="fas fa-bars"></i>
			</a>
			<a class="w3-bar-item w3-padding"><?php echo $LoggedInAccesName; ?> : <?php echo $LoggedInName ?></a>
			<!-- Right-sided navbar links -->
			<div class="w3-right w3-hide-small">
				<div class="w3-dropdown-hover">
					<button class="w3-padding w3-button my-blue"><i class="fas fa-angle-down" aria-hidden="true"></i></button>
					<div class="w3-dropdown-content w3-bar-block w3-card-4" style="right: 0;">
						<a href="#" onclick="document.getElementById('dlgLogOut').style.display='block'" class="w3-bar-item w3-padding w3-button"><i class="fas fa-sign-out-alt"></i> Log Out</a>
					</div>
				</div>
			</div>
			<!-- Hide right-floated links on small screens and replace them with a menu icon -->
		</div>
	</div>
	<!-- Sidebar on small screens when clicking the menu icon -->
	<nav class="w3-sidebar w3-bar-block my-light-blue w3-card-2 w3-animate-left w3-hide-medium w3-hide-large" style="display:none; z-index: 3;" id="mySidebar">
		<a href="#" class="w3-bar-item w3-padding"><img class="" src="/images/sys-logo.png" style="width: 100%"></a>
		<hr>
		<a href="#" onclick="document.getElementById('dlgLogOut').style.display='block'" class="w3-bar-item w3-padding w3-button">Log Out</a>
	</nav>
	<!-- Overlay -->
	<div class="w3-overlay w3-animate-opacity w3-hide-medium w3-hide-large" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
	<!-- Log Out -->
	<div id="dlgLogOut" class="w3-modal">
		<div class="w3-modal-content" style="max-width: 5in">
			<header class="w3-container my-blue"> 
				<h5><i class="fas fa-sign-out-alt"></i> Log-Out?</h5>
			</header>
			<div class="w3-container">
				<p>Are you sure you want to log-out?</p>
				<div class=" w3-margin w3-right">
					<button class="w3-btn my-blue" style="width: 1in;" onclick="window.location = '../log-out.php'">Yes</button>
					<button class="w3-btn my-blue" style="width: 1in;" onclick="document.getElementById('dlgLogOut').style.display='none'">No</button>
				</div>
			</div>
		</div>
	</div>
	<script  type="text/javascript" src="../../scripts/sidebar.js"></script>
	<?php #include_once "fragment_header.php" ?>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-margin-top w3-margin-bottom w3-padding">
		<!--div align="center">
			<img style="display: block; margin: auto; width: 2.5in;" src="/images/sys-logo.png">
		</div>
		<br><br><hr-->
		
		<div class="w3-card-4 my-opacity-white" style="max-width: 8in; margin: auto;">
			<header class="w3-container my-blue"> 
				<h2>Account Setup</h2>
			</header>
			<div class="w3-container" id="contentContainer"></div>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
		function switchView(id){
			var url = '';
			switch(id) {
				case "1":
					url = "init/department_information.php";
					break;
				case "2":
					url = "init/courses.php";
					break;
				case "3":
					url = "init/subjects.php";
					break;
				case "4":
					url = "init/professors.php";
					break;
				case "5":
					url = "init/sections.php";
					break;
				default:
					url = "#";
			}
			$.ajax({
				url: url,
				success: function(response){
					$("#contentContainer").html(response);
				}
			});
			return false;
		}
		<?php #echo isset($_REQUEST['v']) ? $_REQUEST['v'] : '1'; ?>
		switchView('1');

		function finish(deptName,deptAccr){
			$.ajax({
				url: "ajax_json_insert_department.php",
				dataType: "json",
				data: {
					deptName: deptName,
					deptAccr: deptAccr
				},
				success: function(response){
					alert(response.result);
					if(response.sucess){
						location.reload();
					}
					
				}
			});
			return false;
		}
	</script>
</body>
</html>