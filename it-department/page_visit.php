<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
?>
<html>
<head>
	<title>Page Visits</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<table>
				<tr>
					<th>IP</th>
					<th>Visits</th>
				</tr>
				<?php
					$stmt = null;
					$stmt = $conn->prepare("SELECT DISTINCT(`REMOTE_ADDR`) AS `remote_addr2`, (SELECT COUNT(`Id`) FROM `logs_page_visit` WHERE `REMOTE_ADDR` = `remote_addr2`) AS `Count`  FROM `logs_page_visit` ORDER BY `Date Time` DESC LIMIT 100");
					#$stmt->bind_param('s', $_REQUEST['idNum']);
					$stmt->execute();
					$sResult = $stmt->get_result();
					#$subjRow = $stmt->get_result()->fetch_row();
					if ($sResult->num_rows > 0){
						while ($sRow = $sResult->fetch_assoc()) {
							?><tr>
								<td onClick="loadList('<?php echo $sRow['remote_addr2']; ?>')"><?php echo $sRow['remote_addr2']; ?></td>
								<td><?php echo $sRow['Count']; ?></td>
							</tr><?php
						}
					}
					else{
						echo "Empty";
					}
				?>
			</table>
		</div>
		<div class="w3-rest w3-container" style="min-height: 7in;">
			<h5 class="w3-border-bottom w3-border-blue">Page Visits</h5>
			<div id="logContainer">
				<?php #include "p_visits/ajax_fragment_page_visit.php"; ?>
			</div>
			
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
		function loadList(ip){
			$.ajax({
				url: "p_visits/ajax_fragment_page_visit.php",
				data: {	ip: ip },
				success: function(response){
					$("#logContainer").html(response);
				}
			});
		}	
	</script>
</body>
</html>