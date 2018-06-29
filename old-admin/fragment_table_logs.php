<ul id="logs-list-container" class="w3-hoverable">
</ul>
<div id="page-number-Container" class="w3-bar w3-center">
</div>
<script type="text/javascript">
	var logsListContainer = document.getElementById("logs-list-container");
	var pageNumberContainer = document.getElementById("page-number-Container");
	function refreshLogList(page){
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				logsListContainer.innerHTML = this.responseText;
				refreshPageButtons(page);
			}
		};
		//TODO: convert to page
		xhttp.open("GET", "ajax_logs_list.php?page=" + page);
		xhttp.send();
		return false;
	}

	function refreshPageButtons(page){
		var xhttp = new XMLHttpRequest();
		
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200) {
				pageNumberContainer.innerHTML = this.responseText;
			}
		};
		//TODO: convert to page
		xhttp.open("GET", "ajax_table_logs_pages.php?page=" + (page));
		xhttp.send();
		return false;
	}
	refreshLogList(1);
</script>