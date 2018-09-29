<?php
	#MIGHT BE REMOVED IN THE FUTURE,
	include_once("util_dbHandler.php");
#--------------------------
	if ($cIP == '::1'){
		$password = getAdmPassword();
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_user`('admin','admin','Admin','','Account',6,?);");
		$stmt->bind_param('s', $password);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			echo "Registration sucessfull<br>Username: admin<br>Password: admin<br>";
		}
		else{
			echo "AAARGHHH IT STILL EXIIST!!!<br>";
			echo "Attempting password reset<br>";
			$stmt = null;
			$stmt = $conn->prepare("UPDATE `users` SET `User Password` = ? WHERE `Id Number` = 'admin' ;");
			$stmt->bind_param('s', $password);
			$stmt->execute();
			if ($stmt->affected_rows == 1){
				echo "Reset sucessfull<br>Username: admin<br>Password: admin<br>";
			}
			else{
				echo "Reset FAILED!!! Maybe it is already using the admin:admin";	
			}
		}
	}
	else{
		echo "STOP!!!";
	}
?>