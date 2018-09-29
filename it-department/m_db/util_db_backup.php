<?php
	include_once "../../util_dbHandler.php";
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	
	$username = "root"; 
	$password = ""; 
	$hostname = "localhost"; 
	$dbname   = "db_thesis";
	 
	// if mysqldump is on the system path you do not need to specify the full path
	// simply use "mysqldump --add-drop-table ..." in this case
	$dumpfname = $dbname . "_" . date("Y-m-d_H-i-s").".sql";
	$command = "C:\\xampp\\mysql\\bin\\mysqldump --add-drop-table --host=$hostname --user=$username ";

	if ($password) 
		$command.= "--password=". $password ." "; 
	$command.= $dbname;
	$command.= " > " . "backup/" . $dumpfname;
	#echo $command;
	system($command);
	 
	// zip the dump file
	#$zipfname = $dbname . "_" . date("Y-m-d_H-i-s").".zip";
	#$zip = new ZipArchive();
	#if($zip->open($zipfname,ZIPARCHIVE::CREATE)){
	#	$zip->addFile($dumpfname,$dumpfname);
	#	$zip->close();
	#}
	
	#BUG: mabye it is not finished to write yet so that zip dont work

	# read zip file and send it to standard output
	/*if (file_exists("backup/" . $dumpfname)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename("backup/" . $dumpfname));
		flush();
		readfile("backup/" . $dumpfname);
		exit;
	}*/
?>