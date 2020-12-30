<?php
session_start();
if (!isset($_SESSION['user_login'])) {
	header('Location: ../index.php');
}

if (isset($_POST['action'])) {
	if ($_POST['action'] == "logout") {
		if (session_destroy()) {
			header("Location: ../index.php");
		}
	}
}

require_once "../connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>
		Your profile
	</title>

	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<!-- CSS Files -->
	<link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
	<!--   Core JS Files   -->
	<script src="assets/js/core/jquery.min.js"></script>
	<script src="assets/js/core/popper.min.js"></script>
	<script src="assets/js/core/bootstrap-material-design.min.js"></script>
	<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<!-- Plugin for the momentJs  -->
	<script src="assets/js/plugins/moment.min.js"></script>
	<!--  Plugin for Sweet Alert -->
	<script src="assets/js/plugins/sweetalert2.js"></script>
	<!-- Forms Validations Plugin -->
	<script src="assets/js/plugins/jquery.validate.min.js"></script>
	<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
	<script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
	<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
	<script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
	<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
	<script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
	<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
	<script src="assets/js/plugins/jquery.dataTables.min.js"></script>
	<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
	<script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
	<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
	<script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
	<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
	<script src="assets/js/plugins/fullcalendar.min.js"></script>
	<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
	<script src="assets/js/plugins/nouislider.min.js"></script>
	<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<!-- Library for adding dinamically elements -->
	<script src="assets/js/plugins/arrive.min.js"></script>
	<!-- Chartist JS -->
	<script src="assets/js/plugins/chartist.min.js"></script>
	<!--  Notifications Plugin    -->
	<script src="assets/js/plugins/bootstrap-notify.js"></script>
	<script>
		$(document).ready(function() {
			// prevent form from resubmiting when page is refreshed
			if (window.history.replaceState) {
				window.history.replaceState(null, null, window.location.href);
			}

			// for I.E so that update can take effect
			$.ajaxSetup({
				// Disable caching of AJAX responses */
				cache: false
			});
		});
	</script>
</head>
</head>

<body class="">
	<div class="wrapper ">
		<div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
			<div class="logo">
				<a href="#" class="simple-text logo-normal">USER</a>
			</div>
			<div class="sidebar-wrapper">
				<ul class="nav">
					<li <?= !isset($_GET['page']) || $_GET['page'] == 'profile' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
						<a class="nav-link" href="user.php?page=profile">
							<i class="material-icons">person</i>
							<p>Your Profile</p>
						</a>
					</li>
					<li <?= isset($_GET['page']) && $_GET['page'] == 'events' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
						<a class="nav-link" href="user.php?page=events">
							<i class="material-icons">content_paste</i>
							<p>Organized Events</p>
						</a>
					</li>
					<li <?= isset($_GET['page']) && $_GET['page'] == 'reviews' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
						<a class="nav-link" href="user.php?page=reviews">
							<i class="material-icons">comments</i>
							<p>Your Reviews</p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
				<div class="container-fluid">
					<div class="collapse navbar-collapse justify-content-end">
						<span class="navbar-text">
							Welcome, <span style="color:dodgerblue"><?= $_SESSION['user_login'] ?></span>
						</span>
						<ul class="navbar-nav">
							<li class="nav-item dropdown">

								<a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="material-icons">person</i>
									<p class="d-lg-none d-md-block">
										Account
									</p>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
									<a class="dropdown-item" href="../index.php">Home</a>
									<form method="post" id="logoutForm">
										<input type="hidden" name="action" value="logout">
										<a class="dropdown-item" href="javascript:$('#logoutForm').submit();">Logout</a>
									</form>
								</div>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- End Navbar -->

			<!-- main content -->
			<?php
			$page = isset($_GET['page']) ? 'pages/' . $_GET['page'] . '.php' : 'pages/profile.php';
			require_once $page;
			?>
			<!-- end main content -->
		</div>

		<div class="footer">
			<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
			<script src="../layout/scripts/jquery.backtotop.js"></script>
		</div>
	</div>
</body>

</html>