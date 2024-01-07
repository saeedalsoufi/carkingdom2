<?php
session_start(); // Ensure session_start() is at the beginning

include("connect.php");

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header('location: C:\xampp\htdocs\emesa_markets\user_login.php');
    exit;
}

// Print session data for debugging

// Rest of your dashboard code goes here


?>

<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>Emesa Markets</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="/emesa_markets/images/emesaicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="/emesa_markets/images/emesa-touch.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/custom.css">


    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>


    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="custom-select-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
							<option>English</option>
						</select>
                    </div>
                    <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +447495 946666</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            <li><a href="../php/admin_logout.php"><i class="fa fa-user s_color"></i> Logout</a></li>  
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
                                    <i class="fab fa-opencart"></i> Enjoy the low prices!
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 10% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Greek products you can't find anywhere else
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Fill your fridge now!
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Lay back, fill your basket and we will deliver it
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Trust Emesa Markets :)
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Enjoy the low prices! 
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Best Greek products!
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->


    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                    <a class="navbar-brand" href="index.html"><img src="/emesa_markets/images/logo.png" class="logo" alt=""></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item active"><a class="nav-link" href="/emesa_markets/index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/emesa_markets/about.html">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="/emesa_markets/shop.html">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="/emesa_markets/contact-us.html">Contact Us</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                        <li class="side-menu">
							<a href="#">
								<i class="fa fa-shopping-bag" href="cart.html"></i>
								<span class="badge">3</span>
								<p>My Cart</p>
							</a>
						</li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->
<body>

    <!-- Dashboard Section -->
    <section class="dashboard py-5">
        <div class="container">
            <h1 class="heading text-center mb-5">Admin Dashboard</h1>
            <div class="row">

                <!-- Total Pendings -->
                <div class="col-md-4">
                    <div class="dashboard-box p-4 mb-4">
         <?php
            $total_pendings = 0;
            $select_pendings = $con->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
                        <h3 class="text-center"><span>$</span><?= $total_pendings; ?><span>/-</span></h3>
                        <p class="text-center">Total Pendings</p>
                        <a href="placed_orders.php" class="btn btn-block btn-primary">See Orders</a>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="col-md-4">
                    <div class="dashboard-box p-4 mb-4">
         <?php
            $total_completes = 0;
            $select_completes = $con->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['completed']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price'];
               }
            }
         ?>
                        <h3 class="text-center"><span>$</span><?= $total_completes; ?><span>/-</span></h3>
                        <p class="text-center">Completed Orders</p>
                        <a href="placed_orders.php" class="btn btn-block btn-success">See Orders</a>
                    </div>
                </div>

                <!-- Orders Placed -->
                <div class="col-md-4">
                    <div class="dashboard-box p-4 mb-4">
         <?php
            $select_orders = $con->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
                        <h3 class="text-center"><?= $number_of_orders; ?></h3>
                        <p class="text-center">Orders Placed</p>
                        <a href="placed_orders.php" class="btn btn-block btn-info">See Orders</a>
                    </div>
                </div>

                <!-- Products Added -->
                <div class="col-md-4">
                    <div class="dashboard-box p-4 mb-4">
         <?php
            $select_products = $con->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
                        <h3 class="text-center"><?= $number_of_products; ?></h3>
                        <p class="text-center">Products Added</p>
                        <a href="products.php" class="btn btn-block btn-warning">See Products</a>
                    </div>
                </div>

                <!-- Normal Users -->
                <div class="col-md-4">
                    <div class="dashboard-box p-4 mb-4">
         <?php
            $select_users = $con->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
                        <h3 class="text-center"><?= $number_of_users; ?></h3>
                        <p class="text-center">Normal Users</p>
                        <a href="users_accounts.php" class="btn btn-block btn-danger">See Users</a>
                    </div>
                </div>

            </div>
        </div>
    </section>








    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Business Time</h3>
							<ul class="list-time">
								<li>Monday - Sunday: 08.00am to 10.00pm</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Recommend products</h3>
                            <ul class="list-time">
                            <li>Were you looking for a product that you couldn't find?Feel free to suggest it in the email below! emesamarkets...</li>
                            </ul>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Social Media</h3>
                            <ul class="list-time">
							<li>Make sure to stay up-to-date with our latest news!</li>
                            </ul>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>

                            </ul>
						</div>
					</div>
				</div>
				<hr>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2023 <a href="#">Emesa Markets</a></p> <!-- Corrected the p and a tags -->
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

<!-- ALL JS FILES -->
<script src="/emesa_markets/js/jquery-3.2.1.min.js"></script>
<script src="/emesa_markets/js/popper.min.js"></script>
<script src="/emesa_markets/js/bootstrap.min.js"></script>
<!-- ALL PLUGINS -->
<script src="/emesa_markets/js/jquery.superslides.min.js"></script>
<script src="/emesa_markets/js/bootstrap-select.js"></script>
<script src="/emesa_markets/js/inewsticker.js"></script>
<script src="/emesa_markets/js/bootsnav.js."></script>
<script src="/emesa_markets/js/images-loded.min.js"></script>
<script src="/emesa_markets/js/isotope.min.js"></script>
<script src="/emesa_markets/js/owl.carousel.min.js"></script>
<script src="/emesa_markets/js/baguetteBox.min.js"></script>
<script src="/emesa_markets/js/form-validator.min.js"></script>
<script src="/emesa_markets/js/contact-form-script.js"></script>
<script src="/emesa_markets/js/custom.js"></script>
   
</body>
</html>