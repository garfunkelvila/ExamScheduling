<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
?>
<html>
<head>
	<title>Manage Database</title>
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
			<button class="w3-button my-blue" id="btnBackup" style="width: 100%;" type="button" onclick="btnBackup();">Backup Database</button>	
			<!--form>
				<input type="file" name="">
			</form-->
		</div>
		<div class="w3-rest w3-container" style="min-height: 7in;">
			<h5 class="w3-border-bottom w3-border-blue">Database Backups</h5>
			<?php include "m_db/backup/fragment_table_backups.php"; ?>
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
		function btnBackup(){
			$("#btnBackup").prop('disabled', true);
			$("#btnBackup").html('Please wait...');
			$.ajax({
				url: "m_db/util_db_backup.php",
				//dataType: "json",
				//data: { exDate: $("#inputDate").val() },
				success: function(response){
					/*if(response.sucess){
						alert(response["result"]);
						
					}*/
					alert("Done");
					location.reload();
				}
			});
			return false;
		}
		function btnRestore(name){
			if(confirm('Are you sure you want to restore the database?')){
				$.ajax({
					url: "m_db/util_db_restore.php",
					data: { name: name },
					success: function(response){
						alert("Done");
						location.reload();
					}
				});
			}
			return false;
		}
		function btnDelete(name){
			if(confirm('Are you sure you want to delete this backup?')){
				$.ajax({
					url: "m_db/util_db_delete.php",
					data: { name: name },
					success: function(response){
						alert("Done");
						location.reload();
					}
				});
			}
			return false;
		}
	</script>
</body>
</html>