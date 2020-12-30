<!--
Template Name: Drywest
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<html lang="en">
<!-- To declare your language - read more here: https://www.w3.org/International/questions/qa-html-language-declarations -->

<head>
	<title>JADON</title>

	<!-- link to database and login-->
	<?php
	require_once 'connect.php';
	if (isset($_POST['action'])) {
		if ($_POST['action'] == 'login') {
			$adminLogin = false;
			$admins = mysqli_query($con, 'select * from admin');
			$inpName = $_POST['adname'];
			$inpPass = $_POST['password'];
			while ($admin = mysqli_fetch_array($admins)) {
				if ($admin['account_name'] == $inpName && $admin['password'] == $inpPass) {
					$adminLogin = true;
				}
			}
			if ($adminLogin) {
				header('Location: admin/admin.php');
			} else {
				header('Location: index.php');
				echo "<script>alert('Username or password incorrect!')</script>";
			}
		}

		if ($_POST['action'] == "sendFeedback") {
			$name = $_POST['name'];
			$email = isset($_POST['email']) ? $_POST['email'] : "";
			$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
			$content = $_POST['content'];
			mysqli_query($con, 'insert into feedback(name, email, phone_number, content) values("' . $name . '","' . $email . '","' . $phone . '","' . $content . '")');
			header('Location: index.php');
		}
	}
	?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?fbclid=IwAR0LWRgXp5RsP6aaAEkWEpq78cgoLv3ThyGyJrLFSs5IZ9yLK2tKA52LJao">
	<link href="layout/styles/form.css" rel="stylesheet" type="text/css">
	<link href="layout/styles/slideshow.css" rel="stylesheet" type="text/css">

	<!-- JAVASCRIPTS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="layout/scripts/jquery.min.js "></script>
	<script src="layout/scripts/jquery.backtotop.js "></script>
	<script src="layout/scripts/jquery.mobilemenu.js "></script>
</head>

<body id="top">
	<div class="wrapper row0">
		<div id="topbar" class="hoc clear">
			<ul>
				<li><i class="fa fa-clock-o"></i> Mon. - Sun. 7am - 5pm</li>
				<li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
				<li><i class="fa fa-envelope-o"></i> info@domain.com</li>
				<li><a href="#"><i class="fa fa-lg fa-home"></i></a></li>
				<li><a href="#" title="Login" onclick="document.getElementById('form').style.display='block'"><i class="fa fa-lg fa-sign-in"></i></a></li>
			</ul>
		</div>
	</div>

	<!--Login form -->
	<div id="form" class="hoc clear">
		<span onclick="document.getElementById('form').style.display='none'" class="closeForm" title="Close Form">&times;</span>
		<!-- Login Form content -->
		<form class="form-content animate" method="post">
			<div class="content">
				<h3 style="color:black; text-align: center;">Login</h3>
				<label for="username"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="adname" required>

				<label for="password"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="password" required>

				<input type="hidden" name="action" value="login">
				<center><input type="submit" class="btn" style="margin-top: 15px; " value="Login as User"></input></center>

				<br>
				<span style="margin-left: 47%;"><b>Or</b></span>
				<br>
				<center><input type="submit" class="btn" style="margin-top: 15px;margin-bottom: 15px;" value="Login as Administrator"></input></center>
			</div>
		</form>
	</div>
	<!-- End login form -->

	<div class="wrapper row1">
		<header id="header" class="hoc clear">
			<div id="logo" class="fl_left">
				<h1><a href="index.php">JADON</a></h1>
			</div>
		</header>
	</div>

	<!-- Main menu  -->
	<div class="wrapper row2">
		<nav id="mainav" class="hoc clear">
			<ul class="clear">
				<li <?= isset($_GET['page']) ? '' : 'class="active"' ?>><a href="index.php">Home</a></li>
				<li <?= isset($_GET['page']) && $_GET['page'] == 'gallery' ? 'class="active"' : '' ?>><a href="index.php?page=gallery">Gallery</a></li>
				<li <?= isset($_GET['page']) && $_GET['page'] == 'review' ? 'class="active"' : '' ?>><a href="index.php?page=review">Review</a></li>
				<li <?= isset($_GET['page']) && $_GET['page'] == 'events' ? 'class="active"' : '' ?>><a href="index.php?page=events">Events</a></li>
				<li <?= isset($_GET['page']) && $_GET['page'] == 'aboutus' ? 'class="active"' : '' ?>><a href="index.php?page=aboutus">About us</a></li>
			</ul>
		</nav>
	</div>

	<!-- Middle and main content of the web -->
	<div class="main-content">
		<?php
		$page = isset($_GET['page']) ? 'pages/' . $_GET['page'] . '.php' : 'pages/home.php';
		require_once $page;
		?>
	</div>

	<!-- Bottom content of the web -->
	<div class="wrapper bgded overlay light" style="background-image:url('images/demo/backgrounds/05.png');">
		<figure class="hoc clear">
			<ul class="nospace group logos">
				<li class="one_quarter first"><a href="#"><img src="images/demo/222x100.png" alt=""></a></li>
				<li class="one_quarter"><a href="#"><img src="images/demo/222x100.png" alt=""></a></li>
				<li class="one_quarter"><a href="#"><img src="images/demo/222x100.png" alt=""></a></li>
				<li class="one_quarter"><a href="#"><img src="images/demo/222x100.png" alt=""></a></li>
			</ul>
		</figure>
	</div>
	<div class="wrapper row4">
		<footer id="footer" class="hoc clear">
			<div class="one_third first">
				<h6 class="heading">Contact Us</h6>
				<ul class="nospace btmspace-30 linklist contact">
					<li><i class="fa fa-map-marker"></i>
						<address>
							Lầu 2, 24-26 Phan Liêm, phường Đakao, quận 1
						</address>
					</li>
					<li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
					<li><i class="fa fa-envelope-o"></i> huynguyenquang151@gmail.com</li>
				</ul>
				<ul class="faico clear">
					<li><a class="faicon-facebook" href="https://www.facebook.com/callmeNguyenHuy" target="_blank"><i class="fa fa-facebook" style="margin-top:10px;"></i></a></li>
					<li><a class="faicon-twitter" href="https://twitter.com/Huy50094824" target="_blank"><i class="fa fa-twitter" style="margin-top:10px;"></i></a></li>
					<li><a class="faicon-google-plus" href="https://mail.google.com/mail/u/0/?tab=mm#inbox" target="_blank"><i class="fa fa-google-plus" style="margin-top:10px;"></i></a></li>
				</ul>
			</div>
			<div class="one_third">
				<h6 class="heading">Find us here</h6>
				<a href="https://goo.gl/maps/GQ52LjJcBkGW8uMJ7" target="_blank"><img src="images/map.png"></a>
			</div>
			<div class="one_third">
				<h6 class="heading">Write Your Feedback</h6>
				<form id="feedback" method="post" action="#">
					<input class="btmspace-15" type="text" placeholder="Name" name="name" required>
					<input class="btmspace-15" type="email" placeholder="Email" name="email">
					<input class="btmspace-15" type="tel" placeholder="Phone number" pattern="[0-9]{10}" title="Please enter a phone number with 10 numbers" name="phone">
					<textarea class="btmspace-15" style="background-color: #646464; color:white;" placeholder="Your feedback" name="content" rows="4" cols="36" required></textarea>
					<button type="submit" form="feedback" class="btn">Submit</button>
					<input type="hidden" name="action" value="sendFeedback">
				</form>
			</div>
		</footer>
	</div>
	<div class="wrapper row5">
		<div id="copyright" class="hoc clear">
			<p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Jadon event</a></p>
			<p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
		</div>
	</div>

	<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
	<!-- JAVASCRIPTS -->
	<script src="layout/scripts/jquery.min.js"></script>
	<script src="layout/scripts/jquery.backtotop.js"></script>
	<script src="layout/scripts/jquery.mobilemenu.js"></script>

</body>

</html>