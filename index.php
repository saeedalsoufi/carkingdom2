<?php
include __DIR__ . '/php/connect.php';
session_start();

$start = 0;  // Starting row for the SQL query
$limit = 10; // Number of rows to fetch

// Fetch products
$select_products = $con->prepare("SELECT * FROM `cars` WHERE Featured_Cars = 'Yes' LIMIT $start, $limit"); 
$select_products->execute();
$products = $select_products->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>CarKingdom City</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/owl.css">
      
          <!-- Site Icons -->
    <link rel="shortcut icon" href="assets/images/logo.png" class="icon" type="image/x-icon">
    <link rel="apple-touch-icon" href="assets/images/logo.png">
  </head>

  <body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
    <div class="sub-header">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-xs-12">
            <ul class="left-info">
            <a href="mailto:info@carkingdom-city.co.uk" onclick="if(!window.navigator.onLine){ alert('Please set up an email client to use this feature.'); return false; }" class= "envople">info@carkingdom-city.co.uk</a>
              <li><a href="tel:+447387327070"><i class="fa fa-phone"></i>+44-7387-327070 </a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <ul class="right-icons">
              <li><a href="https://instagram.com/carkingdom_city?igshid=MzRlODBiNWFlZA=="><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand-logo" href="index.html"><img src="assets/images/logo.png" class="logo" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cars.php">Cars</a>
              </li>
              <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">About</a>
              
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="about.html">About Us</a>
                    <a class="dropdown-item" href="reviews.php">Reviews</a>
                    <a class="dropdown-item" href="faq.html">FAQ</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact Us</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="main-banner header-text" id="top">
        <div class="Modern-Slider">
          <!-- Item -->
          <div class="item item-1">
            <div class="img-fill">
                <div class="text-content">
                  <h6>Drive the Future with Us!</h6>
                  <h4>Experience Luxury <br> Like Never Before</h4>
                  <p>Discover the perfect blend of performance and elegance in our latest car models. Elevate your driving experience today.</p>
                  <a href="cars.php" class="filled-button">Our Cars</a>
                </div>
            </div>
          </div>
          <!-- // Item -->
          <!-- Item -->
          <div class="item item-2">
            <div class="img-fill">
                <div class="text-content">
                  <h6>Why Choose Us?</h6>
                  <h4>Quality, Reliability <br> & Exceptional Service</h4>
                  <p>We pride ourselves on delivering top-notch service and vehicles that meet the highest standards of quality.</p>
                  <a href="about.html" class="filled-button">About Us</a>
                </div>
            </div>
          </div>
          <!-- // Item -->
          <!-- Item -->
          <div class="item item-3">
            <div class="img-fill">
                <div class="text-content">
                  <h6>Get in Touch</h6>
                  <h4>We're Here to Assist <br> You 24/7</h4>
                  <p>Have questions or need support? Our dedicated team is always ready to assist you. Reach out to us anytime.</p>
                  <a href="contact.html" class="filled-button">Contact Us</a>
                </div>
            </div>
          </div>
          <!-- // Item -->
        </div>

    </div>
    <!-- Banner Ends Here -->


    <div class="services">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Featured <em>Cars</em></h2>
              <span>Discover top-performing vehicles for the ultimate drive.</span>
            </div>
          </div>
          <?php foreach($products as $product): ?>
          <div class="col-md-4">
            <div class="service-item">
              <img src="car_images/<?= $product['Primary_Image']; ?>" alt="">
              <div class="down-content">
                <h4><?= $product['Make']; ?> - <?= $product['Model']; ?></h4>
                <div style="margin-bottom:10px;">
                  <span>
                      <sup>£</sup><?= $product['Price']; ?>
                  </span>
                </div>

                <p>
                  <i class="fa fa-dashboard"></i> <?= $product['Mileage']; ?>km &nbsp;&nbsp;&nbsp;
                  <i class="fa fa-cube"></i> <?= $product['Engine_size']; ?> cc &nbsp;&nbsp;&nbsp;
                  <i class="fa fa-cog"></i> <?= $product['Transmission']; ?> &nbsp;&nbsp;&nbsp;
                </p>
                <a href="car-details.php?id=<?= $product['id']; ?>" class="filled-button">View More</a>
              </div>
            </div>

            <br>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>


    <div class="fun-facts">
      <div class="container">
        <div class="more-info-content">
          <div class="row">
            <div class="col-md-6">
              <div class="left-image">
                <img src="assets/images/about-1-570x350.jpg" class="img-fluid" alt="About Our Car Business">
              </div>
            </div>
            <div class="col-md-6 align-self-center">
              <div class="right-content">
                <span>Our Identity</span>
                <h2>Learn More About <em>Our Dealership</em></h2>
                <p>We are committed to providing exceptional service and top-quality vehicles to our customers. Discover why we're the trusted choice for all your automotive needs.</p>
                <a href="about.html" class="filled-button">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="testimonials">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Customers <em>Reviews</em></h2>
            </div>
          </div>
          <div class="col-md-12">
            <div class="owl-carousel owl-testimonials my-custom-carousel">      
              <div class="testimonial-item">
                <div class="inner-content">
                  <h4>Ashley <em>Bonfield</em></h4>
                  <p>"Amazing service! Trustworthy and transparent.
                      This was my first car purchase, I was a little nervous but the guys at Car kingdom went above and beyond to make the process as smooth as possible. The purchase came with a warranty as well as a service just prior to the final sale. I couldn’t recommend them enough as a seller to anyone, and I will be checking in again as I look into new cars Wishing the team all the best"</p>
                </div>
              </div>
              
              <div class="testimonial-item">
                <div class="inner-content">
                  <h4>Maisie <em>S</em></h4>
                  <p>"Perfect car buying experience!!!Jad was great - friendly and helpful. Really made my car buying experience a pleasure! Thank you very much."</p>
                </div>
              </div>
              
              <div class="testimonial-item">
                <div class="inner-content">
                  <h4>Ruth <em>H</em></h4>
                  <p>"Really impressed. I bought this car in July and was initially concerned about a couple of issues with the car when we picked it up. As promised these were addressed efficiently and we were given advice regarding auto protect cover which also gave peace of mind. The car is exactly what I wanted and at a reasonable price. Thanks Jad"</p>
                </div>
              </div>
              
              <div class="testimonial-item">
                <div class="inner-content">
                  <h4>Apo <em>O</em></h4>
                  <p>"best dealer, friendly and honest. Came to purchase a vw polo and the staff here were extremely friendly and welcoming. they told me about the vehicle and were so honest and made this process very smooth and efficient. If you'd like to buy a car i would definitly recommend coming here."</p>
                </div>
              </div>
            </div>
            <div class="text-center"> <!-- Bootstrap class for text centering -->
              <a href="reviews.php" class="filled-button">View all</a>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="callback-form">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Request a <em>call back</em></h2>
              <span>Speak with Our Experts Today!</span>
            </div>
          </div>
          <div class="col-md-12">
            <div class="contact-form">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-4 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="email" type="text" class="form-control" id="email" pattern="[^ @]*@[^ @]*" placeholder="Phone number" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="border-button">Send Message</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <br>
        <br>
        <br>
        <br>
      </div>
    </div>

    <!-- Footer Starts Here -->
    <footer>
      <div class="container">
        <div class="row">
            <div class="col-md-4 footer-item">
              <h4>Opening hours</h4>
              <p>Monday to Friday: 10am to 6pm<br>
                 Saturday and Sunday: 11am to 4pm</p>
            </div>
          <div class="col-md-4 footer-item">
            <h4>Additional Pages</h4>
            <ul class="menu-list">
              <li><a href="cars.php">Cars</a></li>
              <li><a href="reviews.php">Reviews</a></li>
              <li><a href="contact.html">Contact Us</a></li>
              <li><a href="faq.html">FAQ</a></li>
            </ul>
          </div>
          <div class="col-md-4 footer-item last-item">
            <h4>Contact Us</h4>
            <p><a href="tel:+447387327070">+44-7387-327070</a></p>
            <a href="mailto:info@carkingdom-city.co.uk" onclick="if(!window.navigator.onLine){ alert('Please set up an email client to use this feature.'); return false; }">info@carkingdom-city.co.uk</a>
            <br>
            <br>
            <br>
            <ul class="social-icons">
              <li><a href="https://instagram.com/carkingdom_city?igshid=MzRlODBiNWFlZA=="><i class="fa fa-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    
    <div class="sub-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <p>
                Copyright © 2023 Car Kingdom City
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/accordions.js"></script>

    <script language = "text/Javascript"> 
      cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
      function clearField(t){                   //declaring the array outside of the
      if(! cleared[t.id]){                      // function makes it static and global
          cleared[t.id] = 1;  // you could use true and false, but that's more typing
          t.value='';         // with more chance of typos
          t.style.color='#fff';
          }
      }
    </script>

  </body>
</html>