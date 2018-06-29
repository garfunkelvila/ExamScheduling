<?php
	include "../util_dbHandler.php";

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Int Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$perResult = $stmt->get_result();
	$perRow = $perResult->fetch_row();
	switch ($perRow[0]) {
		case '1':
			$per = "Prelim";
			break;
		case '2':
			$per = "Midterm";
			break;

		case '3':
			$per = "Finals";
			break;
		default:
			$per = "Err";
			break;
	}

	$stmt = null;
	$stmt = $conn->prepare("SELECT calc_SY()");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$syResult = $stmt->get_result();
	$syRow = $syResult->fetch_row();
	$sy = $syRow[0];


	$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$vResult = $stmt->get_result();
	$sView = $vResult->fetch_row()[0];

	if($sView == 0){
		header('Location: ../');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>All Exam schedules</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include "fragment_header.php"; ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<img class="w3-hide-small" src="/images/sys-logo.png" style="width: 100%">
			<br><br><hr>
			<a href="bookmarked.php" class="w3-button my-blue" style="width: 100%;" type="button"><i class="fas fa-bookmark"></i> My bookmarks</a>
		</div>
		<div class="w3-rest w3-container">
			<h1>Schedules for <?php echo $per; ?><label> SY: <?php echo $sy; ?> - <?php echo $sy + 1; ?></label></h1>
			<form style="max-width: 4in;" method="GET" action="index.php">
				<table style="width: 100%">
					<tr>
						<td><input class="my-input-1" type="text" name="q" placeholder="Search section or subject code" value="<?php echo $q; ?>"></td>
						<td><button class="my-button my-blue">Search</button></td>
					</tr>
				</table>
			</form>
			<div class="" style="max-width: 8in" id="sched-container">
				<?php include "fragment_exam_schedules.php"; ?>
			</div>
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
		function search(){
			return false;
		}
		function bookmark(id){
			$.ajax({
				url: "cookie_setWatchlist.php",
				data: { id: id },
				success: function(response){
					location.reload();
				}
			});
		}
		function unbookmark(id){
			$.ajax({
				url: "cookie_unsetWatchlist.php",
				data: { id: id },
				success: function(response){
					location.reload();
				}
			});
		}
	</script>
</body>
</html>