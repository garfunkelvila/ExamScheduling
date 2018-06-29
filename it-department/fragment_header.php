<div class="">
	<div class="w3-bar my-blue w3-card-2" id="myNavbar">
		<a href="javascript:void(0)" class="w3-bar-item w3-padding w3-left w3-hide-large w3-hide-medium w3-button" onclick="w3_open()">
			<i class="fas fa-bars"></i>
		</a>
		<a class="w3-bar-item w3-padding"><?php echo $LoggedInAccesName; ?> : <?php echo $LoggedInName ?></a>
		<!-- Right-sided navbar links -->
		<div class="w3-right w3-hide-small">
			<a href="/" class="w3-bar-item w3-padding w3-button"><i class="fas fa-home" aria-hidden="true"></i></a>
			<a href="manage_accounts.php" class="w3-bar-item w3-padding w3-button">Manage Accounts</a>
			<a href="manage_db.php" class="w3-bar-item w3-padding w3-button">Manage Database</a>
			<div class="w3-dropdown-hover">
				<button class="w3-padding w3-button my-blue"><i class="fas fa-angle-down" aria-hidden="true"></i></button>
				<div class="w3-dropdown-content w3-bar-block w3-card-4" style="right: 0;">
					<!--a href="#" class="w3-bar-item w3-padding w3-button"><i class="fas fa-cog" aria-hidden="true"></i> Settings</a-->
					<a href="change_password.php" class="w3-bar-item w3-padding w3-button"><i class="far fa-edit" aria-hidden="true"></i> Change Password</a>
					<a href="#" onclick="document.getElementById('dlgLogOut').style.display='block'" class="w3-bar-item w3-padding w3-button"><i class="fas fa-sign-out" aria-hidden="true"></i> Log Out</a>
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
	<a href="/" class="w3-bar-item w3-padding w3-button">Home</a>
	<a href="manage_accounts.php" class="w3-bar-item w3-padding w3-button">Manage Accounts</a>
	<a href="manage_db.php" class="w3-bar-item w3-padding w3-button">Manage Database</a>
	<hr>
	<a href="change_password.php" class="w3-bar-item w3-padding w3-button">Change Password</a>
	<a href="#" onclick="document.getElementById('dlgLogOut').style.display='block'" class="w3-bar-item w3-padding w3-button">Log Out</a>
</nav>
<!-- Overlay -->
<div class="w3-overlay w3-animate-opacity w3-hide-medium w3-hide-large" onclick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
<!-- Log Out -->
<div id="dlgLogOut" class="w3-modal">
	<div class="w3-modal-content" style="max-width: 5in">
		<header class="w3-container my-blue"> 
			<h5>Log-Out?</h5>
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