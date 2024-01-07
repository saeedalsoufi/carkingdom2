<?php
include __DIR__ . '/php/connect.php';

// Get the car ID from the URL parameter
$car_id = $_GET['id'];

// SQL query to fetch data
$sql = "SELECT * FROM cars WHERE id = :id";
$stmt = $con->prepare($sql);
$stmt->bindParam(':id', $car_id, PDO::PARAM_INT);
$stmt->execute();

// Fetching data
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Splitting the 'Vehicle_extras' string by commas into an array
$vehicle_extras = $row['Vehicle_extras'];
$extras_array = explode(',', $vehicle_extras);

$primaryImage = $row['Primary_Image'];
$secondaryImages = explode(',', $row['Secondary_Images']); // Assuming the images are comma-separated in the database

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
          <a class="navbar-brand-logo" href="index.php"><img src="assets/images/logo.png" class="logo" alt=""></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item active">
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
    <div class="page-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1><small><del><sup></sup> </del></small> &nbsp; <sup></sup></h1>
            <span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <p class="special-h6"><strong><?php echo $row['Make']; ?> <?php echo $row['Model']; ?> </strong></p>
    <div class="services">
      <div class="container">
        <div class="row">
<!-- Existing HTML code above -->
<div class="col-md-7">
  <div>
    <!-- Display Primary Image -->
    <?php if (isset($Primary_Image)): ?>
     <img src="car_images/<?php echo $primaryImage; ?>" alt="" class="img-fluid wc-image">
    <?php endif; ?>
  </div>
  <br>
<!-- Slideshow for Secondary Images -->
<div id="secondaryImagesCarousel" class="carousel slide" data-interval="false">
  <div class="carousel-inner">
    <!-- Add Primary Image as the first item -->
    <div class="carousel-item active">
      <img src="car_images/<?php echo $primaryImage; ?>" class="d-block w-100" alt="...">
    </div>

    <?php
    foreach ($secondaryImages as $image) {
        echo '<div class="carousel-item">';
        echo '<img src="car_images/' . $image . '" class="d-block w-100" alt="...">';
        echo '</div>';
    }
    ?>
  </div>
  <a class="carousel-control-prev" href="#secondaryImagesCarousel" role="button" data-slide="prev">
    <span class="fas fa-arrow-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#secondaryImagesCarousel" role="button" data-slide="next">
    <span class="fas fa-arrow-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

    <br>
<!-- View All Button -->
<a href="contact.html" class="filled-button">Book Now</a>
</div>



<!-- Existing HTML code below -->


          <div class="col-md-5">
            <form action="#" method="post" class="form">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Body Type</span>
                            <strong class="pull-right"><?php echo $row['Body_type']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Year</span>
                            <strong class="pull-right"><?php echo $row['Year']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Mileage</span>
                            <strong class="pull-right"><?php echo $row['Mileage']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Fuel Type</span>
                            <strong class="pull-right"><?php echo $row['Fuel_type']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Engine size</span>
                            <strong class="pull-right"><?php echo $row['Engine_size']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Transmission</span>
                            <strong class="pull-right"><?php echo $row['Transmission']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Number of seats</span>
                            <strong class="pull-right"><?php echo $row['Number_of_seats']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Number of doors</span>
                            <strong class="pull-right"><?php echo $row['Number_of_doors']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">Colour</span>
                            <strong class="pull-right"><?php echo $row['Colour']; ?></strong>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="clearfix">
                            <span class="pull-left">First registered</span>
                            <strong class="pull-right"><?php echo $row['First_Registered']; ?></strong>
                        </div>
                    </li>
                </ul>
            </form>

            <br>
          </div>
        </div>
        <br>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="tabs-content">
                <h4>Vehicle Description</h4>
                <p><?php echo $row['Vehicle_Description']; ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tabs-content">
                <h4>Vehicle Extras</h4>
                <p>
                    <?php
                    foreach ($extras_array as $extra) {
                        echo '- ' . trim($extra) . ' <br>';
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>


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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 70px;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form action="#" id="contact">
                  <div class="row">
                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Pick-up location" required="">
                      </fieldset>
                    </div>
                   </div>

                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Return location" required="">
                      </fieldset>
                    </div>
                   </div>
                  </div>

                  <div class="row">
                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Pick-up date/time" required="">
                      </fieldset>
                    </div>
                   </div>

                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Return date/time" required="">
                      </fieldset>
                    </div>
                   </div>
                  </div>

                  <div class="form-group">
                    <fieldset>
                      <input type="text" class="form-control" placeholder="Enter full name" required="">
                    </fieldset>
                  </div>

                  <div class="row">
                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Enter email address" required="">
                      </fieldset>
                    </div>
                   </div>

                   <div class="col-md-6">
                    <div class="form-group">
                      <fieldset>
                        <input type="text" class="form-control" placeholder="Enter phone" required="">
                      </fieldset>
                    </div>
                   </div>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Book Now</button>
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