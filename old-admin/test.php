<?php
$strings = array('AbCd 1zyZ9', 'foo! #$bar', ' ');
foreach ($strings as $testcase) {
	if (ctype_alnum(str_replace(' ', '', $testcase))) {
		echo "True<br>";
	}
	else {
		echo "False<br>";
	}
}
?>