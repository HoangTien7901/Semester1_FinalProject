<!--
Template Name: Drywest
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<!-- link to database and login-->
<?php
session_start();
require_once 'connect.php';
if (isset($_POST['action'])) {
	if ($_POST['action'] == 'login') {
		$users = mysqli_query($con, 'select * from user');
		$inpName = $_POST['username'];
		$inpPass = $_POST['password'];
		while ($user = mysqli_fetch_array($users)) {
			if ($user['user_name'] == $inpName && $user['password'] == $inpPass) {
				if (strcmp($user['role'], "admin") == 0) {
					$_SESSION['admin_login'] = $user['user_name'];
					$_SESSION['admin_id'] = $user['id'];
					break;
				} else {
					$_SESSION['user_login'] = $user['user_name'];
					$_SESSION['user_id'] = $user['id'];
					break;
				}
			}
		}

		if (!(isset($_SESSION['admin_login']) || isset($_SESSION['user_login']))) {
			$_SESSION['login'] = false;
		}
	}

	if ($_POST['action'] == "sendFeedback") {
		$name = $_POST['name'];
		$email = isset($_POST['email']) ? $_POST['email'] : "";
		$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
		$content = $_POST['content'];
		if (mysqli_query($con, 'insert into feedback(name, email, phone_number, content) values("' . $name . '","' . $email . '","' . $phone . '","' . $content . '")')) {
			echo "<script>alert('Thank you for your feedback!')</script>";
		} else {
			echo "<script>alert('There was an error sending your feedback.')</script>";
		}
	}

	if ($_POST['action'] == "logout") {
		if (session_destroy()) {
			header("Location: index.php");
		}
	}

	if (isset($_SESSION['login']) && !$_SESSION['login']) {
		echo "<script>alert('Wrong username or password.')</script>";
		unset($_SESSION['login']);
	}
}
?>

<html lang="en">

<head>
    <title>JADON</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?fbclid=IwAR0LWRgXp5RsP6aaAEkWEpq78cgoLv3ThyGyJrLFSs5IZ9yLK2tKA52LJao">
    <link href="layout/styles/slideshow.css" rel="stylesheet" type="text/css" media="all">
    <style>
    /* contact us page */
    .title {
        font-size: 30px;
        margin-top: 10px;
        margin-left: 550px;
        color: #585858;

    }

    .content {
        margin-left: 10px;
    }

    .header {
        font-size: 20px;
        margin-left: 20px;
    }

    .main {

        font-size: 18px;
        margin-left: 20px;

    }

    .content {
        margin-top: 20px;
        margin-bottom: 5px;
        line-height: 1.5;
    }

    .contactUs ul {
        list-style: none;
        text-align: left;
        background: white;
    }

    .contactUs {
        background-color: white;
    }

    /* --------------------------------- */

    /* login form */
    #form {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 20;
        /* Sit on top */
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(133, 126, 126, 0.4);
        /* Black w/ opacity */
        padding: auto;
    }

    .form-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        /* 5% from the top, 15% from the bottom and centered */
        border: 1px solid #888;
        width: 500px;
        height: 350px;
        /* Could be more or less, depending on screen size */
    }

    .container {
        padding: 16px;
    }


    /* Close button */

    .closeForm {
        /* Position it in the top right corner outside of the modal */
        position: static;
        color: red;
        font-size: 35px;
        font-weight: bold;
    }
    </style>

    <!-- JAVASCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="layout/scripts/jquery.min.js"></script>
    <script src="layout/scripts/browser.js"></script>
    <script src="layout/scripts/jquery.backtotop.js "></script>
    <script src="layout/scripts/jquery.mobilemenu.js "></script>
</head>

<body id="top">
    <!--Login form -->
    <div class="wrapper row0" id="form">
        <div class="hoc clear">
            <div class="one-quarter">
                <!-- Login Form content -->
                <form class="form-content animate" method="post">
                    <div class="container">
                        <div class="form-row justify-content-end">
                            <span onclick="document.getElementById('form').style.display='none'" class="closeForm"
                                title="Close Form">
                                &times;
                            </span>
                        </div>
                        <div class="form-row justify-content-center">
                            <h3 style="color:black;">Login</h3>
                        </div>
                        <div class="form-group">
                            <label for="username"><b>Username</b></label>
                            <input type="text" placeholder="Enter Username" pattern="[a-zA-Z]*[0-9]*"
                                title="Invalid username (contain special characters)." class="form-control"
                                id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" class="form-control"
                                pattern="[a-zA-Z]*[0-9]*" title="Invalid password (contain special characters)."
                                id="password" name="password" required>
                        </div>
                        <input type="hidden" name="action" value="login">
                        <center><input type="submit" class="btn btmspace-15" style="margin-top: 15px;"
                                value="Login"></input></center>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End login form -->

    <div class="wrapper row0">
        <div id="topbar" class="hoc clear">
            <ul>
                <li><i class="fa fa-clock-o"></i> Mon. - Sun. 7am - 5pm</li>
                <li><i class="fa fa-phone"></i><a href="tel:001234567890"> +001234567890</a></li>
                <li><i class="fa fa-envelope-o"></i><a href="mailto:huynguyenquang151@gmail.com">
                        huynguyenquang151@gmail.com</a></li>
                <li><a href="#"><i class="fa fa-lg fa-home"></i></a></li>
                <?php if (!(isset($_SESSION['admin_login']) || isset($_SESSION['user_login']))) { ?>
                <li><a href="#" title="Login" onclick="document.getElementById('form').style.display='block'"><i
                            class="fa fa-lg fa-sign-in"></i></a></li>
                <?php } else {
					if (isset($_SESSION['admin_login'])) { ?>
                <li><a href="admin/admin.php?page=profile" title="Go to your profile."
                        style="text-decoration:none;">Welcome, <?= $_SESSION['admin_login'] ?></a></li>
                <?php } elseif (isset($_SESSION['user_login'])) { ?>
                <li><a href="user/user.php?page=profile" title="Go to your profile."
                        style="text-decoration:none;">Welcome, <?= $_SESSION['user_login'] ?></a></li>
                <?php } ?>
                <li>
                    <form method="post" id="logoutForm">
                        <input type="hidden" name="action" value="logout">
                        <a href="javascript:$('#logoutForm').submit();">Logout</a>
                    </form>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>

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
                <li <?= isset($_GET['page']) && $_GET['page'] == 'gallery' ? 'class="active"' : '' ?>><a
                        href="index.php?page=gallery">Gallery</a></li>
                <li <?= isset($_GET['page']) && $_GET['page'] == 'events' ? 'class="active"' : '' ?>><a
                        href="index.php?page=events">Events</a></li>
                <li <?= isset($_GET['page']) && $_GET['page'] == 'aboutus' ? 'class="active"' : '' ?>><a
                        href="index.php?page=aboutus">About us</a></li>
                <li <?= isset($_GET['page']) && $_GET['page'] == 'contactus' ? 'class="active"' : '' ?>><a
                        href="index.php?page=contactus">Contact us</a></li>
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
                    <li><a class="faicon-facebook" href="https://www.facebook.com/callmeNguyenHuy" target="_blank"><i
                                class="fa fa-facebook" style="margin-top:10px;"></i></a></li>
                    <li><a class="faicon-twitter" href="https://twitter.com/Huy50094824" target="_blank"><i
                                class="fa fa-twitter" style="margin-top:10px;"></i></a></li>
                    <li><a class="faicon-google-plus" href="https://mail.google.com/mail/u/0/?tab=mm#inbox"
                            target="_blank"><i class="fa fa-google-plus" style="margin-top:10px;"></i></a></li>
                </ul>
            </div>
            <div class="one_third">
                <h6 class="heading">Find us here</h6>
                <a href="https://goo.gl/maps/GQ52LjJcBkGW8uMJ7" target="_blank"><img src="images/map.png"></a>
            </div>
            <div class="one_third">
                <h6 class="heading">Have problem?</h6>
                <form id="feedback" method="post" action="#">
                    <input class="btmspace-15" type="text" placeholder="Name"
                        pattern="^[-a-zA-Z-()]+(\s+[-a-zA-Z-()]+)*$" minlength="2"
                        title="Name must has no special characters and at least 2 characters" name="name" required>
                    <input class="btmspace-15" type="email" placeholder="Email" name="email">
                    <input class="btmspace-15" type="tel" placeholder="Phone number" pattern="[0-9]{10}"
                        title="Please enter a phone number with 10 numbers" name="phone">
                    <textarea class="btmspace-15" style="background-color: #646464; color:white;"
                        placeholder="Your feedback" name="content" rows="4" cols="36" required></textarea>
                    <button type="submit" form="feedback" class="btn">Submit</button>
                    <input type="hidden" name="action" value="sendFeedback">
                </form>
            </div>
        </footer>
    </div>
    <div class="wrapper row5">
        <div id="copyright" class="hoc clear">
            <p class="fl_left">Copyright &copy; 2018 - All Rights Reserved - <a href="#">Jadon event</a></p>
            <p class="fl_right">Template by <a target="_blank" href="https://www.os-templates.com/"
                    title="Free Website Templates">OS Templates</a></p>
        </div>
    </div>


    <a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
    <!-- JAVASCRIPTS -->
    <script src="layout/scripts/jquery.min.js"></script>
    <script src="layout/scripts/jquery.backtotop.js"></script>
    <script src="layout/scripts/jquery.mobilemenu.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>

</html>