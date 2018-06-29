<div style="width: 100%; display: table; max-width: 8in;" class="w3-container" id="to_endorse">
</div>
<script type="text/javascript">
	fillTable();
	function removeToEndorse(id){
		$.ajax({
			url: "mex/ajax_json_delete_to_endorse.php",
			dataType: "json",
			data: {
				id: id
			},
			success: function(response){
				if(response.sucess){
					alert(response["result"]);
					fillTable();
				}
				else{
					alert(response["result"]);
				}
			}
		});
		return false;
	}
</script>