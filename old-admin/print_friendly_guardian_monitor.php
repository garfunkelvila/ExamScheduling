<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	$name = "";

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Access Id`, CONCAT(`users`.`First Name`, ' ', `users`.`Family Name`) FROM `users` WHERE `Id Number` = ?");
	$stmt->bind_param('s', $_REQUEST['idNum']);
	$stmt->execute();
	$row = $stmt->get_result()->fetch_row();
	$accResult = $row[0];
	$name = $row[1];
?>
<html>
<head>
	<title></title>
</head>
	<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	
	Name: <b><?php echo $name; ?></b><br>
	Login ID: <b><?php echo $_REQUEST['idNum']; ?></b>
	<br><br>
	<div style="display: table; width: 100%" id="tblSubjContainer">
		<div style="display: table-header-group;">
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell;">Students in monitor</b>
			<b class="w3-border-bottom w3-border-blue" style="display: table-cell; width: 0.5in"></b>
		</div>
		<?php
			include "../util_dbHandler.php";

			$stmt = null;
			$stmt = $conn->prepare("CALL `select_guardian_monitor`(?)");
			$stmt->bind_param('s', $_REQUEST['idNum']);
			$stmt->execute();
			$sResult = $stmt->get_result();
			#$subjRow = $stmt->get_result()->fetch_row();
			if ($sResult->num_rows > 0){
				while ($sRow = $sResult->fetch_assoc()) {
					?><div style="display: table-row;">
						<div style="display: table-cell;"><?php echo $sRow['Full Name']; ?></div>
					</div><?php
					#$subjRow[''];
				}
			}
			else{
				?><div style="display: table-row;">
					<div style="display: table-cell;">Nothing to show</div>
				</div><?php
			}
		?>
	</div>
	<button onclick="this.style.visibility = 'hidden'; window.print();">Print</button>
	</body>
</html>